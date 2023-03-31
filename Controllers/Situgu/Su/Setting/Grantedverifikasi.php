<?php

namespace App\Controllers\Situgu\Su\Setting;

use App\Controllers\BaseController;
use App\Models\Situgu\Su\UserverifikasiModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;

class Grantedverifikasi extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new UserverifikasiModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $list->fullname;
            $row[] = $list->email;
            $row[] = $list->role_name;
            $row[] = $list->nama_kecamatan;
            if (cekGrantedVerifikasi($list->id)) {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'1\')" id="' . $list->id . '" switch="none" checked />
                        <label for="' . $list->id . '" data-on-label="On" data-off-label="Off"></label>';
            } else {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'0\')" id="' . $list->id . '" switch="none" />
                        <label for="' . $list->id . '" data-on-label="On" data-off-label="Off"></label>';
            }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/su/setting/grantedverifikasi/data'));
    }

    public function data()
    {
        $data['title'] = 'ACCESS VERIFIKASI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('situgu/su/setting/grantedverifikasi/index', $data);
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
            'val' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Value tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $val = htmlspecialchars($this->request->getVar('val'), true);

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

            if ($val == 0) {
                $current = $this->_db->table('access_verifikasi')
                    ->where('user_id', $id)->get()->getRowObject();

                if ($current) {
                    $this->_db->transBegin();
                    try {
                        $this->_db->table('access_verifikasi')->where('id', $current->id)->delete();

                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Data berhasil disimpan.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Data gagal disimpan.";
                            return json_encode($response);
                        }
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Data gagal disimpan.";
                        return json_encode($response);
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data berhasil disimpan";
                    return json_encode($response);
                }
            } else {
                $current = $this->_db->table('access_verifikasi')
                    ->where('user_id', $id)->get()->getRowObject();

                if (!$current) {
                    $this->_db->transBegin();
                    try {
                        $this->_db->table('access_verifikasi')->insert(['user_id' => $id, 'created_at' => date('Y-m-d H:i:s')]);

                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Data berhasil disimpan.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Data gagal disimpan.";
                            return json_encode($response);
                        }
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Data gagal disimpan.";
                        return json_encode($response);
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data berhasil disimpan";
                    return json_encode($response);
                }
            }
        }
    }
}
