<?php

namespace App\Controllers\Silastri\Su\Masterdata;

use App\Controllers\BaseController;
use App\Models\Silastri\Su\PenggunaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Accesspengguna extends BaseController
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
        $datamodel = new PenggunaModel($request);


        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $list->nik;
            $row[] = $list->fullname;
            $row[] = $list->email;
            $row[] = $list->role_name;
            if (cekGrantedLayanan($list->id, '2')) {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'0\',\'2\')" id="' . $list->id . '-2" switch="none" checked />
                        <label for="' . $list->id . '-2" data-on-label="On" data-off-label="Off"></label>';
            } else {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'1\',\'2\')" id="' . $list->id . '-2" switch="none" />
                        <label for="' . $list->id . '-2" data-on-label="On" data-off-label="Off"></label>';
            }
            if (cekGrantedLayanan($list->id, '3')) {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'0\',\'3\')" id="' . $list->id . '-3" switch="none" checked />
                        <label for="' . $list->id . '-3" data-on-label="On" data-off-label="Off"></label>';
            } else {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'1\',\'3\')" id="' . $list->id . '-3" switch="none" />
                        <label for="' . $list->id . '-3" data-on-label="On" data-off-label="Off"></label>';
            }
            if (cekGrantedLayanan($list->id, '4')) {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'0\',\'4)" id="' . $list->id . '-4" switch="none" checked />
                        <label for="' . $list->id . '-4" data-on-label="On" data-off-label="Off"></label>';
            } else {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'1\',\'4\')" id="' . $list->id . '-4" switch="none" />
                        <label for="' . $list->id . '-4" data-on-label="On" data-off-label="Off"></label>';
            }
            if (cekGrantedLayanan($list->id, '5')) {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'0\',\'5)" id="' . $list->id . '-5" switch="none" checked />
                        <label for="' . $list->id . '-5" data-on-label="On" data-off-label="Off"></label>';
            } else {
                $row[] = '<input type="checkbox" onchange="aksiChange(this, \'' . $list->id . '\',\'1\',\'5\')" id="' . $list->id . '-5" switch="none" />
                        <label for="' . $list->id . '-5" data-on-label="On" data-off-label="Off"></label>';
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
        return redirect()->to(base_url('silastri/su/masterdata/accesspengguna/data'));
    }

    public function data()
    {
        $data['title'] = 'PENGGUNA';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['roles'] = $this->_db->table('_role_user')->whereIn('id', [2, 3, 4, 5, 6, 7])->get()->getResult();

        return view('silastri/su/masterdata/accesspengguna/index', $data);
    }

    public function changeval()
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
            'bidang' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bidang tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('id')
                . $this->validator->getError('bidang');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $val = htmlspecialchars($this->request->getVar('val'), true);
            $bidang = htmlspecialchars($this->request->getVar('bidang'), true);

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

            if ($val == '0') {
                $current = $this->_db->table('hak_access_layanan')
                    ->where(['user_id' => $id, 'bidang' => $bidang])->get()->getRowObject();

                if ($current) {
                    $this->_db->transBegin();
                    try {
                        $this->_db->table('hak_access_layanan')->where(['user_id' => $current->user_id, 'bidang' => $bidang])->delete();

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
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan";
                    return json_encode($response);
                }
            } else {
                $current = $this->_db->table('hak_access_layanan')
                    ->where(['user_id' => $id, 'bidang' => $bidang])->get()->getRowObject();

                if (!$current) {
                    $this->_db->transBegin();
                    try {
                        $this->_db->table('hak_access_layanan')->insert(['user_id' => $id, 'bidang' => $bidang, 'created_at' => date('Y-m-d H:i:s')]);

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
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan";
                    return json_encode($response);
                }
            }
        }
    }
}
