<?php

namespace App\Controllers\A\Setting;

use App\Controllers\BaseController;
use App\Models\A\PenggunaModel;
use Config\Services;
use App\Libraries\Profilelib;

class Hakaccess extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new PenggunaModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<button type="button" onclick="actionRoleAccess(\'' . $list->uid . '\', \'' . $list->fullname . '\')" class="btn btn-primary btn-sm waves-effect waves-light">
                <i class="bx bxs-layout font-size-16 align-middle me-2"></i> Action
            </button>';

            $row[] = $action;
            $row[] = $list->fullname;
            $row[] = $list->email;
            switch ((int)$list->level) {
                case 1:
                    $row[] = "Superadmin";
                    break;
                case 2:
                    $row[] = "Pengguna";
                    break;
                case 3:
                    $row[] = "Pengguna";
                    break;

                default:
                    $row[] = "Monitoring";
                    break;
            }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            // "recordsTotal" => 0,
            // "recordsFiltered" => 0,
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        $data['title'] = 'Hak Akses';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/setting/hakaccess/index', $data);
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
            'title' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('title');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);

            $current = $this->_db->table('_user_hak_access')
                ->where('u_id', $id)->get()->getResultArray();

            $access = json_decode(file_get_contents(FCPATH . "uploads/hakaccess.json"), true);

            if ($current) {
                $data['nama_pengguna'] = $title;
                $data['u_id'] = $id;
                $data['data'] = $current;
                $data['access'] = $access;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/hakaccess/role', $data);
                return json_encode($response);
            } else {
                $data['u_id'] = $id;
                $data['nama_pengguna'] = $title;
                $data['access'] = $access;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/hakaccess/role', $data);
                return json_encode($response);
            }
        }
    }

    public function save()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'user_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'User id tidak boleh kosong. ',
                ]
            ],
            'menu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Menu tidak boleh kosong. ',
                ]
            ],
            'submenu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Submenu tidak boleh kosong. ',
                ]
            ],
            'aksi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Aksi tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('user_id')
                . $this->validator->getError('menu')
                . $this->validator->getError('aksi')
                . $this->validator->getError('submenu');
            return json_encode($response);
        } else {
            $user_id = htmlspecialchars($this->request->getVar('user_id'), true);
            $menu = htmlspecialchars($this->request->getVar('menu'), true);
            $submenu = htmlspecialchars($this->request->getVar('submenu'), true);
            $aksi = htmlspecialchars($this->request->getVar('aksi'), true);

            $current = $this->_db->table('_users_tb')
                ->where('uid', $user_id)->get()->getRowObject();

            if ($current) {
                $cekData = $this->_db->table('_user_hak_access')->where(['u_id' => $user_id, 'menu' => $menu, 'sub_menu' => $submenu, 'aksi' => $aksi])->get()->getRowObject();
                if ($cekData) {
                    $this->_db->table('_user_hak_access')->where('hid', $cekData->hid)->delete();
                } else {
                    $this->_db->table('_user_hak_access')->insert([
                        'u_id' => $user_id,
                        'menu' => $menu,
                        'sub_menu' => $submenu,
                        'aksi' => $aksi,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                if ($this->_db->affectedRows() > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Berhasil merubah hak akses menu: $menu, Submenu: $submenu, Aksi: $aksi";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal merubah hak akses.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "User tidak ditemukan";
                return json_encode($response);
            }
        }
    }
}
