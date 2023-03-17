<?php

namespace App\Models\Situgu\Su;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SptjmModel extends Model
{
    protected $table = "_tb_sptjm_verifikasi a";
    protected $column_order = array(null, null, 'a.kode_usulan', 'b.tahun', 'b.tw', 'a.jumlah_ptk', 'a.lampiran_sptjm');
    protected $column_search = array('a.kode_verifikasi', 'b.tahun', 'b.tw');
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
    function get_datatables($user_id, $jenis)
    {
        $this->dt->select("a.*, b.tahun, b.tw, count(*) as jumlah_ptk");
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $user_id);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->dt->groupBy('kode_verifikasi');
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($user_id, $jenis)
    {
        $this->dt->select("a.*, b.tahun, b.tw, count(*) as jumlah_ptk");
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $user_id);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->dt->groupBy('kode_verifikasi');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($user_id, $jenis)
    {
        $this->dt->select("a.*, b.tahun, b.tw, count(*) as jumlah_ptk");
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id');
        $this->dt->where('a.jenis_usulan', $jenis);
        $this->dt->where('a.user_id', $user_id);
        if ($this->request->getPost('tw')) {
            $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        }
        $this->dt->groupBy('kode_verifikasi');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
