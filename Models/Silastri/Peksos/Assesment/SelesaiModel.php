<?php

namespace App\Models\Silastri\Peksos\Assesment;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SelesaiModel extends Model
{
    protected $table = "_data_assesment a";
    protected $column_order = array(null, null, 'a.jenis', 'a.kode_assesment', 'a.nik_orang_assesment', 'a.nama_orang_assesment');
    protected $column_search = array('a.nik_orang_assesment', 'a.nama_orang_assesment', 'a.kode_assesment');
    protected $order = array('a.created_at' => 'asc');
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

    function get_datatables($userId)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->select("a.*, c.kode_aduan, c.peserta_spt, c.tgl_spt, c.lokasi_spt");
        // $this->dt->join('_profil_users_tb b', 'b.id = a.user_id');
        $this->dt->join('_pengaduan_tanggapan_spt c', 'c.id = a.id');
        $this->dt->where("a.status > 0 AND (JSON_CONTAINS(c.peserta_spt, '\"$userId\"', '$'))");

        // $where = `JSON_CONTAINS(c.peserta_spt, '"$userId"', '$')`;
        // $this->dt->where($where);
        // if ($this->request->getPost('kategori')) {
        //     if ($this->request->getPost('kategori') !== "") {

        //         $this->dt->where('a.kategori', $this->request->getPost('kategori'));
        //     }
        // }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered($userId)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->select("a.*, c.kode_aduan, c.peserta_spt, c.tgl_spt, c.lokasi_spt");
        // $this->dt->join('_profil_users_tb b', 'b.id = a.user_id');
        $this->dt->join('_pengaduan_tanggapan_spt c', 'c.id = a.id');
        $this->dt->where("a.status > 0 AND (JSON_CONTAINS(c.peserta_spt, '\"$userId\"', '$'))");

        // if ($this->request->getPost('kategori')) {
        //     if ($this->request->getPost('kategori') !== "") {

        //         $this->dt->where('a.kategori', $this->request->getPost('kategori'));
        //     }
        // }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }

    public function count_all($userId)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->select("a.*, c.kode_aduan, c.peserta_spt, c.tgl_spt, c.lokasi_spt");
        // $this->dt->join('_profil_users_tb b', 'b.id = a.user_id');
        $this->dt->join('_pengaduan_tanggapan_spt c', 'c.id = a.id');
        $this->dt->where("a.status > 0 AND (JSON_CONTAINS(c.peserta_spt, '\"$userId\"', '$'))");

        // $this->dt->whereIn('a.peserta_spt', $userId);
        // if ($this->request->getPost('kategori')) {
        //     if ($this->request->getPost('kategori') !== "") {

        //         $this->dt->where('a.kategori', $this->request->getPost('kategori'));
        //     }
        // }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
