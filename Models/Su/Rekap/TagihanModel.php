<?php

namespace App\Models\Su\Rekap;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table = "tb_gaji_sipd a";
    protected $column_order = array(null, null, 'b.nama', 'b.nip', 'b.golongan', 'a.jumlah_transfer');
    protected $column_search = array('b.nip', 'b.nama');
    protected $order = array('b.nama' => 'asc');
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
        $this->dt->select("a.id, a.id_pegawai, a.jumlah_transfer, a.tahun, b.nama, b.nip, b.golongan, b.no_rekening_bank, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, d.bank_eka_bandar_jaya, d.bank_eka_metro, d.bpd_bandar_jaya, d.bpd_koga, d.bpd_metro, d.bpd_kalirejo, d.wajib_kpn, d.kpn, d.bri, d.btn, d.bni, d.dharma_wanita, d.korpri, d.zakat_profesi, d.infak, d.shodaqoh");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->join('tb_potongan_ d', 'a.id_pegawai = d.id_pegawai AND a.tahun = d.tahun', 'LEFT');
        // $this->dt->whereIn('a.status_usulan', [2]);
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
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
        $this->dt->select("a.jumlah_transfer, a.tahun, b.nama, b.nip, b.golongan, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, d.infak");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->join('tb_potongan_ d', 'a.id_pegawai = d.id_pegawai AND a.tahun = d.tahun', 'LEFT');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $this->dt->select("a.jumlah_transfer, a.tahun, b.nama, b.nip, b.golongan, b.kode_instansi, b.nama_instansi, b.nama_kecamatan, c.tahun, c.bulan, d.infak");
        $this->dt->join('_ref_tahun_bulan c', 'a.tahun = c.id');
        $this->dt->join('tb_pegawai_ b', 'a.id_pegawai = b.id');
        $this->dt->join('tb_potongan_ d', 'a.id_pegawai = d.id_pegawai AND a.tahun = d.tahun', 'LEFT');
        if ($this->request->getPost('tw')) {
            if ($this->request->getPost('tw') !== "") {
                $this->dt->where('a.tahun', $this->request->getPost('tw'));
            } else {
                if ($this->request->getPost('tw_active')) {
                    if ($this->request->getPost('tw_active') !== "") {

                        $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                    }
                }
            }
        } else {
            if ($this->request->getPost('tw_active')) {
                if ($this->request->getPost('tw_active') !== "") {

                    $this->dt->where('a.tahun', $this->request->getPost('tw_active'));
                }
            }
        }
        $this->_get_datatables_query();

        return $this->dt->countAllResults();
    }
}
