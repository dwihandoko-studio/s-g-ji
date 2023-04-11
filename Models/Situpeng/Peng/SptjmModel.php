<?php

namespace App\Models\Situpeng\Peng;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SptjmModel extends Model
{
    protected $table = "_tb_sptjm_pengawas a";
    protected $column_order = array(null, null, 'a.kode_usulan', 'b.tahun', 'b.tw', 'a.jumlah_pengawas', 'a.lampiran_sptjm');
    protected $column_search = array('a.kode_usulan', 'b.tahun', 'b.tw');
    protected $order = array('a.created_at' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
    }
    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables($userId, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.jenjang_pengawas, c.tahun, c.tw");
        $this->dt->join('__pengawas_tb b', "b.id = (SELECT ptk_id FROM _profil_users_tb WHERE id = '$userId')");
        $this->dt->join('_ref_tahun_tw c', 'a.id_tahun_tw = c.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $userId);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered($userId, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.jenjang_pengawas, c.tahun, c.tw");
        $this->dt->join('__pengawas_tb b', "b.id = (SELECT ptk_id FROM _profil_users_tb WHERE id = '$userId')");
        $this->dt->join('_ref_tahun_tw c', 'a.id_tahun_tw = c.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $userId);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }

    public function count_all($userId, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.jenjang_pengawas, c.tahun, c.tw");
        $this->dt->join('__pengawas_tb b', "b.id = (SELECT ptk_id FROM _profil_users_tb WHERE id = '$userId')");
        $this->dt->join('_ref_tahun_tw c', 'a.id_tahun_tw = c.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $userId);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
