<?php

namespace App\Controllers\Situpeng\Peng\Masterdata;

use App\Controllers\BaseController;
// use App\Models\Situgu\Ptk\PtkModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;

class Individu extends BaseController
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
        return redirect()->to(base_url('situpeng/peng/masterdata/individu/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA INDIVIDU';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $current = $this->_db->table('__pengawas_tb a')
            ->select("a.*, b.no_hp as nohpAkun, b.email as emailAkun, b.wa_verified, b.image")
            ->join('v_user_pengawas b', 'a.id = b.ptk_id', 'left')
            ->where('a.id', $user->data->ptk_id)->get()->getRowObject();

        if ($current) {
            $data['data'] = $current;
            // $data['penugasans'] = $this->_db->table('_ptk_tb_dapodik a')
            //     ->select("a.*, b.npsn, b.nama as namaSekolah, b.kecamatan as kecamatan_sekolah, (SELECT SUM(jam_mengajar_per_minggu) FROM _pembelajaran_dapodik WHERE ptk_id = a.ptk_id AND sekolah_id = a.sekolah_id AND semester_id = a.semester_id) as jumlah_total_jam_mengajar_perminggu")
            //     ->join('ref_sekolah b', 'a.sekolah_id = b.id')
            //     ->where('a.ptk_id', $current->id_ptk)
            //     ->where("a.jenis_keluar IS NULL")
            //     ->orderBy('a.ptk_induk', 'DESC')->get()->getResult();
            return view('situpeng/peng/masterdata/individu/index', $data);
        } else {
            return view('situpeng/peng/404', $data);
        }
    }

    public function edit()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'action' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Action tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('action');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('action'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                return redirect()->to(base_url('auth'));
            }

            $current = $this->_db->table('__pengawas_tb a')
                ->select("a.*, b.no_hp as nohpAkun, b.email as emailAkun, b.wa_verified, b.image")
                ->join('v_user b', 'a.id = b.ptk_id', 'left')
                ->where('a.id', $user->data->ptk_id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/peng/masterdata/individu/edit', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function editSave()
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
                    'required' => 'Id buku tidak boleh kosong. ',
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tempat lahir tidak boleh kosong. ',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong. ',
                ]
            ],
            'jk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis kelamin tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|trim',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                    'valid_email' => 'Email tidak valid. ',
                ]
            ],
            'nrg' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NRG tidak boleh kosong. ',
                ]
            ],
            'no_peserta' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No Peserta tidak boleh kosong. ',
                ]
            ],
            'npwp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPWP tidak boleh kosong. ',
                ]
            ],
            'no_rekening' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Rekening tidak boleh kosong. ',
                ]
            ],
            'cabang_bank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Cabang bank tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nrg')
                . $this->validator->getError('tempat_lahir')
                . $this->validator->getError('tgl_lahir')
                . $this->validator->getError('jk')
                . $this->validator->getError('nohp')
                . $this->validator->getError('email')
                . $this->validator->getError('id')
                . $this->validator->getError('no_peserta')
                . $this->validator->getError('npwp')
                . $this->validator->getError('no_rekening')
                . $this->validator->getError('cabang_bank');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tempat_lahir = htmlspecialchars($this->request->getVar('tempat_lahir'), true);
            $tgl_lahir = htmlspecialchars($this->request->getVar('tgl_lahir'), true);
            $jk = htmlspecialchars($this->request->getVar('jk'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $nrg = htmlspecialchars($this->request->getVar('nrg'), true);
            $no_peserta = htmlspecialchars($this->request->getVar('no_peserta'), true);
            $npwp = htmlspecialchars($this->request->getVar('npwp'), true);
            $no_rekening = htmlspecialchars($this->request->getVar('no_rekening'), true);
            $cabang_bank = htmlspecialchars($this->request->getVar('cabang_bank'), true);

            $oldData =  $this->_db->table('__pengawas_tb')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'email' => $email,
                'no_hp' => $nohp,
                'tempat_lahir' => $tempat_lahir,
                'tgl_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jk,
                'nrg' => $nrg,
                'no_peserta' => $no_peserta,
                'npwp' => $npwp,
                'no_rekening' => $no_rekening,
                'cabang_bank' => $cabang_bank,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();
            try {
                $this->_db->table('__pengawas_tb')->where('id', $oldData->id)->update($data);
                // $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->update(['email' => $email]);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupdate data.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
