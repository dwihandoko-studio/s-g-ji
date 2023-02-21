<?php

namespace App\Controllers\Situgu\Ptk;

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
        return redirect()->to(base_url('situgu/ptk/infogtk/data'));
    }

    public function data()
    {
        $data['title'] = 'Info GTK';
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
        return view('situgu/ptk/infogtk/index', $data);
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
