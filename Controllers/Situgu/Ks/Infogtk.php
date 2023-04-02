<?php

namespace App\Controllers\Situgu\Ks;

use App\Controllers\BaseController;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Kehadiranptklib;

class Infogtk extends BaseController
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
        return redirect()->to(base_url('situgu/ks/infogtk/data'));
    }

    public function data()
    {
        $data['title'] = 'Info GTK Digital';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        if ($user->data->ptk_id !== NULL) {
            $data['infogtk'] = $this->_db->table('_info_gtk')->where('ptk_id', $user->data->ptk_id)->get()->getRowObject();
        }
        return view('situgu/ks/infogtk/index', $data);
    }

    public function taut()
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
                    'required' => 'Link tidak valid. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
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

            if ($user->data->ptk_id == NULL || $user->data->ptk_id == "") {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akun anda belum ditautkan ke data PTK, silahkan hubungi Admin Sekolah untuk menautkan Akun terlebih dahulu.";
                return json_encode($response);
            }

            $id = htmlspecialchars($this->request->getVar('id'), true);

            $oldData = $this->_db->table('_info_gtk')->where('ptk_id', $user->data->ptk_id)->get()->getRowObject();

            if ($oldData) {
                $data = [
                    'qrcode' => $id,
                    'is_active' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('_info_gtk')->where('ptk_id', $oldData->ptk_id)->update($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal menautkan Info GTK Digital.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    createAktifitas($user->data->id, "Menautkan ulang info gtk digital", "Taut Ulang Info GTK Digital", "edit");
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Info GTK Digital berhasil ditautkan ulang.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menautkan Info GTK Digital.";
                    return json_encode($response);
                }
            } else {

                $data = [
                    'ptk_id' => $user->data->ptk_id,
                    'qrcode' => $id,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $this->_db->transBegin();
                try {
                    $this->_db->table('_info_gtk')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal menautkan Info GTK Digital.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    createAktifitas($user->data->id, "Menautkan Info GTK Digital", "Menautkan Info GTK Digital", "add");
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Info GTK Digital berhasil ditautkan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menautkan Info GTK Digital.";
                    return json_encode($response);
                }
            }
        }
    }

    public function tautulang()
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

            $current = $this->_db->table('_info_gtk')
                ->where('ptk_id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ks/infogtk/tautulang', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function hapus()
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

            $current = $this->_db->table('_info_gtk')
                ->where('ptk_id', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_info_gtk')->where('ptk_id', $id)->delete();
                } catch (\Exception $e) {
                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal menghapus tautan Info GTK Digital.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    createAktifitas($user->data->id, "Menghapus tautan Info GTK Digital", "Menghapus Tautan Info GTK Digital", "delete");
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Info GTK Digital berhasil dihapus.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memhapus tautan Info GTK Digital.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }
}
