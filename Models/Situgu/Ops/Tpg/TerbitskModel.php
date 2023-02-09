<?php

namespace App\Models\Situgu\Ops\Tpg;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TerbitskModel extends Model
{
    protected $table = "_tb_usulan_detail_tpg a";
    protected $column_order = array(null, null, 'b.nama', 'nik', 'b.nuptk', 'b.jenis_ptk', 'a.created_at');
    protected $column_search = array('b.nik', 'b.nuptk', 'b.nama');
    protected $order = array('a.created_at' => 'asc', 'a.status_usulan' => 'asc');
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
    function get_datatables($npsn)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik, b.npsn, b.jenis_ptk");
        $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->where('a.status_usulan', '6');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->dt->where('b.npsn', $npsn);
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($npsn)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik, b.npsn, b.jenis_ptk");
        $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->where('a.status_usulan', '6');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->dt->where('b.npsn', $npsn);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($npsn)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik, b.npsn, b.jenis_ptk");
        $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->where('a.status_usulan', '6');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->dt->where('b.npsn', $npsn);
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
