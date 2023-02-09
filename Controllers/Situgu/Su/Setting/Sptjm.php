<?php

namespace App\Controllers\Situgu\Su\Setting;

use App\Controllers\BaseController;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;

class Sptjm extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/su/setting/sptjm/data'));
    }

    public function data()
    {
        $data['title'] = 'SETTING SPTJM';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        $data['sptjm'] = $this->_db->table('_setting_sptjm_tb')->whereIn('id', [2])->get()->getRowObject();
        $data['sptjmTamsil'] = $this->_db->table('_setting_sptjm_tb')->whereIn('id', [3])->get()->getRowObject();
        $data['sptjmPghm'] = $this->_db->table('_setting_sptjm_tb')->whereIn('id', [4])->get()->getRowObject();

        return view('situgu/su/setting/sptjm/index', $data);
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

            $current = $this->_db->table('_setting_sptjm_tb')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/su/setting/sptjm/edit', $data);
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
            'awal' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Batas Awal tidak boleh kosong. ',
                ]
            ],
            'akhir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Batas Akhir tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('awal')
                . $this->validator->getError('akhir');
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
            $awal = htmlspecialchars($this->request->getVar('awal'), true);
            $akhir = htmlspecialchars($this->request->getVar('akhir'), true);

            $this->_db->table('_setting_sptjm_tb')->where('id', $id)->update(['max_upload_sptjm' => str_replace("T", " ", $akhir), 'max_download_sptjm' => str_replace("T", " ", $awal), 'updated_at' => date('Y-m-d H:i:s')]);


            if ($this->_db->affectedRows() > 0) {
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Setting SPTJM berhasil disimpan.";
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan Setting SPTJM.";
                return json_encode($response);
            }
        }
    }
}
