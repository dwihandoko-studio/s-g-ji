<?php

namespace App\Controllers\Situgu\Ks;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;

// header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Home extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function index()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['title'] = 'Dashboard';
        $data['verified_wa'] = $user->data->wa_verified == 1 ? true : false;
        $data['verified_email'] = $user->data->email_verified == 1 ? true : false;
        $data['email_tertaut'] = $user->data->email_tertaut == 1 ? true : false;
        $data['admin'] = true;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        $data['data_antrian_tamsil'] = $this->_db->table('_tb_usulan_detail_tamsil')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tpg'] = $this->_db->table('_tb_usulan_detail_tpg')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_pghm'] = $this->_db->table('_tb_usulan_detail_pghm')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tamsil_transfer'] = $this->_db->table('_tb_usulan_detail_pghm')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_tpg_transfer'] = $this->_db->table('_tb_usulan_detail_pghm')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $data['data_antrian_pghm_transfer'] = $this->_db->table('_tb_usulan_detail_pghm')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getRowObject();
        $aa = $this->_db->table('_tb_temp_usulan_detail')->where(['id_tahun_tw' => $data['tw']->id, 'id_ptk' => $id])->orderBy('created_at', 'desc')->get()->getResult();
        if (count($aa) > 0) {
            if ($aa[0]->status_usulan == 1) {
                // var_dump($data['data_antrian_tamsil']);
                // die;
                if ($data['data_antrian_tamsil'] || $data['data_antrian_tpg'] || $data['data_antrian_pghm'] || $data['data_antrian_tamsil_transfer'] || $data['data_antrian_tpg_transfer'] || $data['data_antrian_pghm_transfer']) {
                    $data['data'] = false;
                } else {
                    $data['data'] = $aa[0];
                }
            } else {
                $data['data'] = $aa[0];
            }
        } else {
            $data['data'] = false;
        }

        $data['jumlah'] = $this->_db->table('v_temp_usulan a')
            ->select("a.id, (SELECT count(*) FROM v_temp_usulan WHERE npsn = a.npsn AND (status_usulan = 0 OR status_usulan = 2) AND jenis_tunjangan_usulan = 'tpg') as jumlah_ajuan_tpg, (SELECT count(*) FROM v_temp_usulan WHERE npsn = a.npsn AND (status_usulan = 0 OR status_usulan = 2) AND jenis_tunjangan_usulan = 'tamsil') as jumlah_ajuan_tamsil, (SELECT count(*) FROM v_temp_usulan WHERE npsn = a.npsn AND (status_usulan = 0 OR status_usulan = 2) AND jenis_tunjangan_usulan = 'pghm') as jumlah_ajuan_pghm")
            ->where('a.npsn', $user->data->npsn)
            ->get()->getRowObject();
        $data['cut_off_pengajuan'] = $this->_db->table('_setting_sptjm_tb')->get()->getResult();
        $data['cut_off_spj'] = $this->_db->table('_setting_upspj_tb')->get()->getResult();
        $data['informasis'] = $this->_db->table('_tb_infopop')->select("*, (SELECT count(*) FROM _tb_infopop WHERE tampil = 1 AND tujuan_role LIKE '%PTK%') as jumlah_all")->where("tampil = 1 AND tujuan_role LIKE '%PTK%'")->orderBy('created_at', 'DESC')->limit(5)->get()->getResult();

        return view('situgu/ks/home/index', $data);
    }

    public function getAktivasiWa()
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if ($id == "wa") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ks/home/aktivasi/wa', $x);
                return json_encode($response);
            } else if ($id == "email") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ks/home/aktivasi/email', $x);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function kirimAktivasiWa()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'nomor' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nomor');
            return json_encode($response);
        } else {
            $nomor = htmlspecialchars($this->request->getVar('nomor'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if (substr($nomor, 0, 1) == 0) {
                $nomor = "+62" . substr($nomor, 1);
            }

            if (substr($nomor, 0, 1) == 8) {
                $nomor = "+62" . substr($nomor, 0);
            }

            if (substr($nomor, 0, 2) == 62) {
                $nomor = "+62" . substr($nomor, 2);
            }

            $kode = rand(1000, 9999);
            $nama = $user->data->fullname;
            $message = "Hallo *$nama*....!!!\n______________________________________________________\n\n*KODE AKTIVASI* untuk akun *SI-TUGU* anda adalah : \n*$kode*\n\n\nPesan otomatis dari *SI-TUGU Kab. Lampung Tengah*\n_________________________________________________";

            $dataReq = [
                'number' => (string)$nomor,
                'message' => $message,
            ];

            $ch = curl_init("https://whapi.kntechline.id/send-message");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataReq));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

            $server_output = curl_exec($ch);
            if (curl_errno($ch)) {
                $response = new \stdClass;
                $response->status = 400;
                $response->error = curl_error($ch);
                $response->message = "Gagal mengirim kode aktivasi.";
                return json_encode($response);
            }
            curl_close($ch);
            $sended = json_decode($server_output, true);

            if ($sended) {
                $x['user'] = $user->data;
                $x['nomor'] = $nomor;
                $x['kode_aktivasi'] = $kode;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ks/home/aktivasi/kode', $x);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengirim kode aktivasi.";
                return json_encode($response);
            }
        }
    }

    public function verifiAktivasiWa()
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
            'nomor' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor tidak boleh kosong. ',
                ]
            ],
            'kode' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode tidak boleh kosong. ',
                ]
            ],
            'fth' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nomor')
                . $this->validator->getError('kode')
                . $this->validator->getError('fth');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nomor = htmlspecialchars($this->request->getVar('nomor'), true);
            $kode = htmlspecialchars($this->request->getVar('kode'), true);
            $fth = htmlspecialchars($this->request->getVar('fth'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if ($kode === $fth) {
                $this->_db->transBegin();
                try {
                    $date = date('Y-m-d H:i:s');
                    $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->update([
                        'no_hp' => $nomor,
                        'updated_at' => $date
                    ]);

                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->table('_users_tb')->where('id', $user->data->id)->update([
                            'wa_verified' => 1,
                            'updated_at' => $date
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Berhasil memverifikasi nomor whatsapp.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menautkan nomor whatsapp.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menautkan nomor whatsapp.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menautkan nomor whatsapp.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Kode verifikasi salah.";
                return json_encode($response);
            }
        }
    }
}
