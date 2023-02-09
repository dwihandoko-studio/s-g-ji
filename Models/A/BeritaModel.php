<?php

namespace App\Models\A;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = "_tb_berita a";
    protected $column_order = array(null, null, 'a.status', 'a.tanggal', 'b.kategori', 'a.judul', null);
    protected $column_search = array('a.judul', 'a.deskripsi');
    protected $order = array('a.tanggal' => 'desc', 'a.created_at' => 'desc');
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
        $select = "a.*, b.kategori";

        $this->dt->select($select);
        $this->dt->join('_tb_kategori_berita b', 'a.k_id = b.kid');

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
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {

        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
