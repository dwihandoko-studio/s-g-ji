<?php

namespace App\Models\Situgu\Su;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AduanModel extends Model
{
    protected $table = "aduan_tb";
    protected $column_order = array(null, 'status_ajuan', 'created_at', 'jenis', 'isi', 'status');
    protected $column_search = array('created_at', 'jenis', 'isi', 'npsn');
    protected $order = array('created_at' => 'desc');
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
    function get_datatables($status)
    {
        $this->dt->where('status_ajuan', $status);
        if ($this->request->getPost('jenis')) {
            $this->dt->where('jenis', $this->request->getPost('jenis'));
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($status)
    {
        $this->dt->where('status_ajuan', $status);
        if ($this->request->getPost('jenis')) {
            $this->dt->where('jenis', $this->request->getPost('jenis'));
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($status)
    {
        $this->dt->where('status_ajuan', $status);
        if ($this->request->getPost('jenis')) {
            $this->dt->where('jenis', $this->request->getPost('jenis'));
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
