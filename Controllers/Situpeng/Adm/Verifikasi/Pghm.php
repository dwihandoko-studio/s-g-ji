<?php

namespace App\Controllers\Situgu\Adm\Verifikasi;

use App\Controllers\BaseController;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Kehadiranptklib;
use App\Libraries\Uuid;

class Pghm extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/adm/verifikasi/pghm/data'));
    }

    public function data()
    {
        $data['title'] = 'VERIFIKASI USULAN TUNJANGAN PGHM';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        $data['data'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tamsil'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tpg'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_pghm'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tamsil_transfer'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tpg_transfer'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_pghm_transfer'] = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();

        return view('situgu/adm/verifikasi/pghm/index', $data);
    }

    public function prosesajukan()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'jenis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('tw')
                . $this->validator->getError('jenis');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $ptk = $this->_db->table('_upload_data_attribut a')
                ->select("b.*, (SELECT gaji_pokok FROM ref_gaji WHERE pangkat = a.pang_golongan AND masa_kerja = a.pang_tahun LIMIT 1) as gajiPokok, a.id_tahun_tw, a.pang_jenis, a.pang_golongan, a.pang_no, a.pang_tmt, a.pang_tgl, a.pang_tahun, a.pang_bulan, a.pangkat_terakhir as lampiran_pangkat, a.kgb_terakhir as lampiran_kgb, a.pernyataan_24jam as lampiran_pernyataan24, a.cuti as lampiran_cuti, a.pensiun as lampiran_pensiun, a.kematian as lampiran_kematian, a.lainnya as lampiran_att_lain, c.bulan_1, c.bulan_2, c.bulan_3, c.lampiran_absen1, c.lampiran_absen2, c.lampiran_absen3, c.pembagian_tugas as lampiran_pembagian_tugas, c.slip_gaji as lampiran_slip_gaji, c.doc_lainnya as lampiran_doc_absen_lain")
                ->join('_ptk_tb b', 'a.id_ptk = b.id')
                ->join('_absen_kehadiran c', 'a.id_ptk = c.id_ptk AND c.id_tahun_tw = a.id_tahun_tw')
                ->where(['a.id_ptk' => $id, 'a.id_tahun_tw' => $tw])
                ->get()->getRowObject();

            if (!$ptk) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            if ($jenis === "tpg") {

                $canUsulTpg = canUsulTpg();

                if ($canUsulTpg && $canUsulTpg->code !== 200) {
                    return json_encode($canUsulTpg);
                }

                $uuidLib = new Uuid();
                $data = [
                    'id' => $uuidLib->v4(),
                    'id_ptk' => $id,
                    'id_tahun_tw' => $tw,
                    'jenis_tunjangan' => $jenis,
                    'us_pang_golongan' => $ptk->pang_golongan,
                    'us_pang_tmt' => $ptk->pang_tmt,
                    'us_pang_tgl' => $ptk->pang_tgl,
                    'us_pang_mk_tahun' => $ptk->pang_tahun,
                    'us_pang_mk_bulan' => $ptk->pang_bulan,
                    'us_pang_jenis' => $ptk->pang_jenis,
                    'us_gaji_pokok' => $ptk->gajiPokok ? ($ptk->gajiPokok > 0 ? $ptk->gajiPokok : 1500000) : 1500000,
                    'status_usulan' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } else if ($jenis === "tamsil") {

                $canUsulTamsil = canUsulTamsil();

                if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
                    return json_encode($canUsulTamsil);
                }

                $uuidLib = new Uuid();
                $data = [
                    'id' => $uuidLib->v4(),
                    'id_ptk' => $id,
                    'id_tahun_tw' => $tw,
                    'jenis_tunjangan' => $jenis,
                    'us_pang_golongan' => $ptk->pang_golongan,
                    'us_pang_tmt' => $ptk->pang_tmt,
                    'us_pang_tgl' => $ptk->pang_tgl,
                    'us_pang_mk_tahun' => $ptk->pang_tahun,
                    'us_pang_mk_bulan' => $ptk->pang_bulan,
                    'us_pang_jenis' => $ptk->pang_jenis,
                    'us_gaji_pokok' => $this->_helpLib->nilaiTamsil(),
                    'status_usulan' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } else if ($jenis === "pghm") {

                $canUsulPghm = canUsulPghm();

                if ($canUsulPghm && $canUsulPghm->code !== 200) {
                    return json_encode($canUsulPghm);
                }

                $uuidLib = new Uuid();
                $data = [
                    'id' => $uuidLib->v4(),
                    'id_ptk' => $id,
                    'id_tahun_tw' => $tw,
                    'jenis_tunjangan' => $jenis,
                    'us_pang_golongan' => $ptk->pang_golongan,
                    'us_pang_tmt' => $ptk->pang_tmt,
                    'us_pang_tgl' => $ptk->pang_tgl,
                    'us_pang_mk_tahun' => $ptk->pang_tahun,
                    'us_pang_mk_bulan' => $ptk->pang_bulan,
                    'us_pang_jenis' => $ptk->pang_jenis,
                    'us_gaji_pokok' => $this->_helpLib->nilaiPghm(),
                    'status_usulan' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Jenis tunjangan tidak tersedia.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_temp_usulan_detail')->insert($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Usulan $jenis berhasil diajukan.";
                    $response->data = $data;
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengajukan uslan $jenis.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal mengajukan uslan $jenis.";
                return json_encode($response);
            }
        }
    }
}
