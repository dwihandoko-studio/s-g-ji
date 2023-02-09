<?php

namespace App\Models\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = "_tb_buku a";
    protected $column_order = array(null, null, 'b.kategori', 'a.nama_buku', 'a.pengarang', null, 'a.tahun_terbit', 'a.harga', 'a.stok');
    protected $column_search = array('a.nama_buku', 'a.pengarang', 'a.tahun_terbit', 'a.harga', 'b.kategori');
    protected $order = array('a.nama_buku' => 'asc');
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
        $this->dt->join('_tb_kategori_buku b', 'a.k_id = b.kid');

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
    function get_datatables($kategori)
    {
        $this->_get_datatables_query();

        if ($kategori != "") {
            $this->dt->where('a.k_id', $kategori);
        }

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($kategori)
    {
        $this->_get_datatables_query();
        if ($kategori != "") {
            $this->dt->where('a.k_id', $kategori);
        }

        return $this->dt->countAllResults();
    }
    public function count_all($kategori)
    {
        $this->_get_datatables_query();
        if ($kategori != "") {
            $this->dt->where('a.k_id', $kategori);
        }

        return $this->dt->countAllResults();
    }
}
