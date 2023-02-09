<?php

namespace App\Controllers\A\Data;

use App\Controllers\BaseController;
use App\Models\A\Data\JabatanModel;
use Config\Services;
use App\Libraries\Profilelib;

class Jabatan extends BaseController
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
        $datamodel = new JabatanModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionEdit(\'' . $list->jid . '\', \'' . $list->jabatan . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bx-edit font-size-16 align-middle"></i></button>
                        </a>
                        <a href="javascript:actionHapus(\'' . $list->jid . '\', \'' . $list->jabatan . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bx-trash font-size-16 align-middle"></i></button>
                        </a>';
            $row[] = $action;
            switch ((int)$list->tingkat) {
                case 1:
                    $row[] = "Kepala";
                    break;
                case 2:
                    $row[] = "Sekretaris";
                    break;
                case 3:
                    $row[] = "Kabid / Setingkat Kabid";
                    break;
                case 4:
                    $row[] = "Kasi / Setingkat Kasi";
                    break;
                case 5:
                    $row[] = "Staf / Setingkat Staf";
                    break;

                default:
                    $row[] = "TKS";
                    break;
            }

            $row[] = $list->jabatan;
            $row[] = $list->parentJabatan;

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
        return redirect()->to(base_url('a/data/jabatan/data'));
    }

    public function data()
    {
        $data['title'] = 'Jabatan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/data/jabatan/index', $data);
    }

    public function add()
    {
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

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('a/data/jabatan/add');
        return json_encode($response);
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

            $current = $this->_db->table('_tb_jabatan')
                ->where('jid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;

                $s = (int)$current->tingkat - 1;
                $where = "tingkat = $s";

                if ((int)$current->tingkat === 2 || (int)$current->tingkat === 3) {
                    $where = "tingkat = 1";
                } else if ((int)$current->tingkat === 4) {
                    $where = "tingkat = 2 OR tingkat = 3";
                } else {
                    $where = "tingkat = 4";
                }

                $data['parents'] = $this->_db->table('_tb_jabatan')
                    ->select("jid, jabatan")
                    ->where($where)
                    ->get()->getResult();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/data/jabatan/edit', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function getParent()
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

            $s = (int)$id - 1;
            $where = "tingkat = $s";

            if ($id === "2" || $id === "3") {
                $where = "tingkat = 1";
            } else if ($id === "4") {
                $where = "tingkat = 2 OR tingkat = 3";
            } else {
                $where = "tingkat = 4";
            }

            $current = $this->_db->table('_tb_jabatan')
                ->where($where)->get()->getResult();

            if (count($current) > 0) {
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = $current;
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function delete()
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
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Permintaan diizinkan";
                return json_encode($response);
            }
            $this->_db->table('_tb_jabatan')->where('jid', $id)->delete();

            if ($this->_db->affectedRows() > 0) {

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil dihapus.";
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data gagal dihapus.";
                return json_encode($response);
            }
        }
    }

    public function addSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'tingkat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tingkat jabatan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('name')
                . $this->validator->getError('tingkat');
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

            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tingkat = htmlspecialchars($this->request->getVar('tingkat'), true);
            $parent = htmlspecialchars($this->request->getVar('parent'), true) ?? "";

            if ($parent === "") {
                $parent = null;
            }

            $cekData = $this->_db->table('_tb_jabatan')->where(['jabatan' => $name, 'tingkat' => $tingkat, 'parent' => $parent])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Nama jabatan sudah ada.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            $data = [
                'jabatan' => $name,
                'tingkat' => $tingkat,
                'parent' => $parent,
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s')
            ];

            try {
                $this->_db->table('_tb_jabatan')->insert($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan.";
                    $response->data = $data;
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data.";
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
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'tingkat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tingkat jabatan tidak boleh kosong. ',
                ]
            ],
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
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('tingkat')
                . $this->validator->getError('name');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tingkat = htmlspecialchars($this->request->getVar('tingkat'), true);
            $parent = htmlspecialchars($this->request->getVar('parent'), true) ?? "";

            if ($parent === "") {
                $parent = null;
            }

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

            $cekOldData = $this->_db->table('_tb_jabatan')->where('jid', $id)->get()->getRowObject();

            if (!$cekOldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }


            if (
                $name === $cekOldData->jabatan
                && $tingkat === $cekOldData->tingkat
                && $parent === $cekOldData->parent
            ) {
                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Tidak ada perubahan data yang disimpan.";
                $response->redirect = base_url('a/data/jabatan/data');
                return json_encode($response);
            }

            $this->_db->transBegin();

            $data = [
                'jabatan' => $name,
                'parent' => $parent,
                'tingkat' => $tingkat,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                $this->_db->table('_tb_jabatan')->where('jid', $cekOldData->jid)->update($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();

                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil diupdate.";
                    $response->data = $data;
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupdate data.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupdate data.";
                return json_encode($response);
            }
        }
    }
}
