<?php

namespace App\Models\Situgu\Ks;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AtributModel extends Model
{
    protected $table = "_upload_data_attribut a";
    protected $column_order = array(null, null, 'b.tahun', 'b.tw', 'a.is_locked', 'c.is_locked');
    protected $column_search = array('b.tahun', 'b.tw');
    protected $order = array('b.tahun' => 'desc', 'b.tw' => 'desc');
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
    function get_datatables($id)
    {
        $select = "a.*, b.tahun, b.tw, c.status_kepegawaian";

        $this->dt->select($select);
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id', 'LEFT');
        $this->dt->join('_ptk_tb c', 'a.id_ptk = c.id', 'LEFT');
        $this->dt->where('a.id_ptk', $id);
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($id)
    {
        $this->dt->where('a.id_ptk', $id);
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($id)
    {
        $this->dt->where('a.id_ptk', $id);
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
