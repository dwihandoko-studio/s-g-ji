<?php

namespace App\Models\Silastri\Peksos\Layanan;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table = "_permohonan_temp a";
    protected $column_order = array(null, null, 'a.layanan', 'a.kode_permohonan', 'a.nik', 'a.nama', 'b.kk', 'a.jenis');
    protected $column_search = array('a.nik', 'a.nama', 'a.kode_permohonan');
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
        $this->dt->select("a.id as id_permohonan, a.layanan, a.kode_permohonan, a.user_id, a.nik, a.nama, a.jenis, a.kelurahan, b.kk");
        $this->dt->join('_profil_users_tb b', 'b.id = a.user_id');
        $this->dt->where("(a.status_permohonan = 0)");

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
    function get_datatables($layanan)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        $this->dt->whereIn('a.layanan', $layanan);
        if ($this->request->getPost('layanan')) {
            if ($this->request->getPost('layanan') !== "") {

                $this->dt->where('a.layanan', $this->request->getPost('layanan'));
            }
        }
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered($layanan)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        // $this->dt->whereIn('a.status_usulan', [6]);
        $this->dt->whereIn('a.layanan', $layanan);
        if ($this->request->getPost('layanan')) {
            if ($this->request->getPost('layanan') !== "") {

                $this->dt->where('a.layanan', $this->request->getPost('layanan'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }

    public function count_all($layanan)
    {
        // $this->dt->select("a.id as id_usulan, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, a.date_matching, a.date_terbitsk");
        // $this->dt->join('_ptk_tb b', 'a.id_ptk = b.id');
        // $this->dt->whereIn('a.status_usulan', [6]);
        $this->dt->whereIn('a.layanan', $layanan);
        if ($this->request->getPost('layanan')) {
            if ($this->request->getPost('layanan') !== "") {

                $this->dt->where('a.layanan', $this->request->getPost('layanan'));
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
