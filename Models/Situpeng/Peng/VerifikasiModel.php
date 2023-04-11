<?php

namespace App\Models\Situpeng\Peng;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    protected $table = "_tb_temp_usulan_detail_pengawas a";
    protected $column_order = array(null, null, 'b.nama', 'b.nik', 'b.nuptk', 'b.jenis_pengawas', 'a.created_at');
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
    function get_datatables($jenjangPengawas, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik, b.jenjang_pengawas, b.guru_naungan, b.npsn_naungan, b.jenis_pengawas");
        $this->dt->join('__pengawas_tb b', 'a.id_pengawas = b.id');
        $this->dt->where('a.jenis_tunjangan', $jenis);
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        if ($jenjangPengawas == "SD") {
            $this->dt->whereIn('b.jenjang_pengawas', ['SD', 'TK']);
        } else {
            $this->dt->where('b.jenjang_pengawas', $jenjangPengawas);
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered($jenjangPengawas, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik");
        $this->dt->join('__pengawas_tb b', 'a.id_pengawas = b.id');
        $this->dt->where('a.jenis_tunjangan', $jenis);
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        if ($jenjangPengawas == "SD") {
            $this->dt->whereIn('b.jenjang_pengawas', ['SD', 'TK']);
        } else {
            $this->dt->where('b.jenjang_pengawas', $jenjangPengawas);
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all($jenjangPengawas, $jenis)
    {
        $this->dt->select("a.*, b.nama, b.nuptk, b.nik");
        $this->dt->join('__pengawas_tb b', 'a.id_pengawas = b.id');
        $this->dt->where('a.jenis_tunjangan', $jenis);
        $this->dt->where('a.status_usulan', 0);
        $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
        if ($jenjangPengawas == "SD") {
            $this->dt->whereIn('b.jenjang_pengawas', ['SD', 'TK']);
        } else {
            $this->dt->where('b.jenjang_pengawas', $jenjangPengawas);
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
