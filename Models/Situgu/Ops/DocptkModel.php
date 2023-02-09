<?php

namespace App\Models\Situgu\Ops;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class DocptkModel extends Model
{
    protected $table = "_absen_kehadiran a";
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
    function get_datatables()
    {
        $select = "c.*, b.tahun, b.tw, a.lampiran_absen1, a.lampiran_absen2, a.lampiran_absen3, a.pembagian_tugas, a.slip_gaji, a.id_tahun_tw, a.doc_lainnya, a.is_locked as lockedAbsen, d.pangkat_terakhir as doc_pangkat_terakhir, d.kgb_terakhir as doc_kgb_terakhir, d.pernyataan_24jam as doc_pernyataan_24jam, d.cuti as doc_cuti, d.pensiun as doc_pensiun, d.kematian as doc_kematian, d.lainnya as doc_attr_lainnya, d.is_locked as lockedAttr";

        $this->dt->select($select);
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id', 'LEFT');
        $this->dt->join('_ptk_tb c', 'a.id_ptk = c.id', 'LEFT');
        $this->dt->join('_upload_data_attribut d', 'a.id_ptk = d.id_ptk AND a.id_tahun_tw = d.id_tahun_tw', 'LEFT');
        $this->dt->where('a.id_ptk', $this->request->getPost('id'));
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
    function count_filtered()
    {
        $select = "c.*, b.tahun, b.tw, a.lampiran_absen1, a.lampiran_absen2, a.lampiran_absen3, a.pembagian_tugas, a.slip_gaji, a.doc_lainnya, a.is_locked as lockedAtribut";

        $this->dt->select($select);
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id', 'LEFT');
        $this->dt->join('_ptk_tb c', 'a.id_ptk = c.id', 'LEFT');
        $this->dt->where('a.id_ptk', $this->request->getPost('id'));
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $select = "c.*, b.tahun, b.tw, a.lampiran_absen1, a.lampiran_absen2, a.lampiran_absen3, a.pembagian_tugas, a.slip_gaji, a.doc_lainnya, a.is_locked as lockedAtribut";

        $this->dt->select($select);
        $this->dt->join('_ref_tahun_tw b', 'a.id_tahun_tw = b.id', 'LEFT');
        $this->dt->join('_ptk_tb c', 'a.id_ptk = c.id', 'LEFT');
        $this->dt->where('a.id_ptk', $this->request->getPost('id'));
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {

                $this->dt->where('a.id_tahun_tw', $this->request->getPost('tw'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
