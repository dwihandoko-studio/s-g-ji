<?php

namespace App\Controllers\A\Setting;

use App\Controllers\BaseController;
use App\Models\A\Setting\PortallayananModel;
use Config\Services;
use App\Libraries\Profilelib;

class Portallayanan extends BaseController
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
        $datamodel = new PortallayananModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionEdit(\'' . $list->id . '\', \'' . str_replace("'", "", $list->judul) . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bx-edit font-size-16 align-middle"></i></button>
                        </a>
                        <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->judul) . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bx-trash font-size-16 align-middle"></i></button>
                        </a>';
            if ($list->image !== null) {
                $image = '<img alt="Image placeholder" src="' . base_url() . '/uploads/appslider/' . $list->image . '" width="80px" height="50px">';
            } else {
                $image = "-";
            }
            $row[] = $action;
            switch ((int)$list->status) {
                case 1:
                    $row[] = '<span class="badge badge-pill badge-soft-success">Terpublish</span>';
                    break;
                default:
                    $row[] = '<span class="badge badge-pill badge-soft-danger">Tidak Terpublish</span>';
                    break;
            }
            $row[] = $list->judul;
            $row[] = $list->deskripsi;
            $row[] = $list->url;
            $row[] = $image;

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
        return redirect()->to(base_url('a/setting/portallayanan/data'));
    }

    public function data()
    {
        $data['title'] = 'App Slider';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/setting/portallayanan/index', $data);
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
        $response->data = view('a/setting/portallayanan/add');
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

            $current = $this->_db->table('_tb_appslider')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/portallayanan/edit', $data);
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
            $current = $this->_db->table('_tb_portallayanan')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_portallayanan')->where('id', $id)->delete();

                    if ($this->_db->affectedRows() > 0) {
                        if ($current->image !== null) {
                            try {
                                $dir = FCPATH . "uploads/portallayanan";
                                unlink($dir . '/' . $current->image);
                            } catch (\Throwable $err) {
                            }
                        }
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data berhasil dihapus.";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Data gagal dihapus.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data gagal dihapus.";
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

    public function addSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'judul' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong. ',
                ]
            ],
            'url' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Url tidak boleh kosong. ',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,1024]|mime_in[_file,image/jpeg,image/jpg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('judul')
                . $this->validator->getError('deskripsi')
                . $this->validator->getError('url')
                . $this->validator->getError('status')
                . $this->validator->getError('_file');
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

            $judul = htmlspecialchars($this->request->getVar('judul'), true);
            $deskripsi = htmlspecialchars($this->request->getVar('deskripsi'), true);
            $url = htmlspecialchars($this->request->getVar('url'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $cekData = $this->_db->table('_tb_portallayanan')->where(['url' => $url])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Url portal layanan sudah ada.";
                return json_encode($response);
            }

            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'status' => $status,
                'url' => $url,
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/portallayanan";

            $lampiranFile = $this->request->getFile('_file');
            $filesNamelampiranFile = $lampiranFile->getName();
            $newNamelampiranFile = _create_name_foto($filesNamelampiranFile);

            if ($lampiranFile->isValid() && !$lampiranFile->hasMoved()) {
                $lampiranFile->move($dir, $newNamelampiranFile);
                $data['image'] = $newNamelampiranFile;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload gambar.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_portallayanan')->insert($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiranFile);
                $this->_db->transRollback();

                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($e);
                $response->message = "Gagal menyimpan data.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                $response->redirect = base_url('a/setting/portallayanan/data');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiranFile);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data";
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
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'judul' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong. ',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong. ',
                ]
            ],
            'url' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Url tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiranFile = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiranFile != '') {
            $lampiranValFile = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,1024]|mime_in[_file,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih file terlebih dahulu. ',
                        'max_size' => 'Ukuran file terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValFile);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('judul')
                . $this->validator->getError('deskripsi')
                . $this->validator->getError('url')
                . $this->validator->getError('status')
                . $this->validator->getError('_file');
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
            $judul = htmlspecialchars($this->request->getVar('judul'), true);
            $url = htmlspecialchars($this->request->getVar('url'), true);
            $deskripsi = htmlspecialchars($this->request->getVar('deskripsi'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $oldData =  $this->_db->table('_tb_portallayanan')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'url' => $url,
                'status' => $status,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (
                (int)$status === (int)$oldData->status
                && $judul === $oldData->judul
                && $url === $oldData->url
            ) {
                if ($filenamelampiranFile == '') {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('a/setting/portallayanan/data');
                    return json_encode($response);
                }
            }

            if ($url !== $oldData->url) {
                $cekData = $this->_db->table('_tb_portallayanan')->where(['url' => $url])->get()->getRowObject();

                if ($cekData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Url portal layanan sudah ada.";
                    return json_encode($response);
                }
            }

            $dir = FCPATH . "uploads/portallayanan";

            if ($filenamelampiranFile != '') {
                $lampiranFile = $this->request->getFile('_file');
                $filesNamelampiranFile = $lampiranFile->getName();
                $newNamelampiranFile = _create_name_foto($filesNamelampiranFile);

                if ($lampiranFile->isValid() && !$lampiranFile->hasMoved()) {
                    $lampiranFile->move($dir, $newNamelampiranFile);
                    $data['image'] = $newNamelampiranFile;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload file.";
                    return json_encode($response);
                }
            }
            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_portallayanan')->where('id', $oldData->id)->update($data);
            } catch (\Exception $e) {
                if ($filenamelampiranFile != '') {
                    unlink($dir . '/' . $newNamelampiranFile);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data gagal disimpan.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                if ($filenamelampiranFile != '') {
                    if ($oldData->image !== null) {
                        try {
                            unlink($dir . '/' . $oldData->image);
                        } catch (\Throwable $th) {
                        }
                    }
                }
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                $response->redirect = base_url('a/setting/portallayanan/data');
                return json_encode($response);
            } else {
                if ($filenamelampiranFile != '') {
                    unlink($dir . '/' . $newNamelampiranFile);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
