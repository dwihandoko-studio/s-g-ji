<?php

namespace App\Models\Situpeng\Adm;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class VerifikasitpgpengawasModel extends Model
{
    protected $table = "_tb_usulan_detail_tpg_pengawas a";
    protected $column_order = array(null, null, 'b.jenjang_pengawas', null);
    protected $column_search = array('b.jenjang_pengawas', 'b.nama');
    protected $order = array('a.date_approve_sptjm' => 'asc');
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
    function get_datatables($jenis)
    {
        $this->dt->select("count(a.kode_usulan) as jumlah_pengawas, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.jenjang_pengawas");
        $this->dt->join('__pengawas_tb b', "b.id = a.id_pengawas");
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        $this->dt->groupBy('a.kode_usulan');
        // $this->dt->where('b.npsn', $npsn);
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($jenis)
    {
        $this->dt->select("count(a.kode_usulan) as jumlah_pengawas, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.jenjang_pengawas");
        $this->dt->join('__pengawas_tb b', "b.id = a.id_pengawas");
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        $this->dt->groupBy('a.kode_usulan');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($jenis)
    {
        $this->dt->select("count(a.kode_usulan) as jumlah_pengawas, a.kode_usulan, a.status_usulan, a.date_approve_sptjm, b.jenjang_pengawas");
        $this->dt->join('__pengawas_tb b', "b.id = a.id_pengawas");
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        $this->dt->groupBy('a.kode_usulan');
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
