<?php

namespace App\Controllers\A\Galeri;

use App\Controllers\BaseController;
use App\Models\A\SliderModel;
use Config\Services;
use App\Libraries\Profilelib;

class Slider extends BaseController
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
        $datamodel = new SliderModel($request);


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
                $image = '<img alt="Image placeholder" src="' . base_url() . '/uploads/slider/' . $list->image . '" width="80px" height="50px">';
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
            // $row[] = $list->sub_judul;
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
        return redirect()->to(base_url('a/galeri/slider/data'));
    }

    public function data()
    {
        $data['title'] = 'Slider';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/galeri/slider/index', $data);
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
        $response->data = view('a/galeri/slider/add');
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

            $current = $this->_db->table('_tb_slider')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/galeri/slider/edit', $data);
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
            $current = $this->_db->table('_tb_slider')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_slider')->where('id', $id)->delete();

                    if ($this->_db->affectedRows() > 0) {
                        if ($current->image !== null) {
                            try {
                                $dir = FCPATH . "uploads/slider";
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
            'sub_judul' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Sub judul tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png]',
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
                . $this->validator->getError('sub_judul')
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
            $sub_judul = htmlspecialchars($this->request->getVar('sub_judul'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $slug = generateSlug($judul);

            $cekData = $this->_db->table('_tb_slider')->where(['url' => $slug . '.html'])->get()->getRowObject();

            if ($cekData) {
                $slug = $slug . "-" . date('Y-m-d');
            }

            $data = [
                'judul' => $judul,
                'sub_judul' => $sub_judul,
                'status' => $status,
                'url' => $slug . '.html',
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/slider";

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
                $this->_db->table('_tb_slider')->insert($data);
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
                $response->redirect = base_url('a/galeri/slider/data');
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
            'sub_judul' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Sub judul tidak boleh kosong. ',
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
                    'rules' => 'uploaded[_file]|max_size[_file,5148]|mime_in[_file,image/jpeg,image/jpg,image/png]',
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
                . $this->validator->getError('sub_judul')
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
            $sub_judul = htmlspecialchars($this->request->getVar('sub_judul'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $oldData =  $this->_db->table('_tb_slider')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'judul' => $judul,
                'sub_judul' => $sub_judul,
                'status' => $status,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($judul !== $oldData->judul) {
                $slug = generateSlug($judul);
                $cekData = $this->_db->table('_tb_slider')->where(['url' => $slug . '.html'])->get()->getRowObject();

                if ($cekData) {
                    $slug = $slug . "-" . date('Y-m-d');
                }

                $data['url'] = $slug . '.html';
            }

            if (
                (int)$status === (int)$oldData->status
                && $judul === $oldData->judul
                && $sub_judul === $oldData->sub_judul
            ) {
                if ($filenamelampiranFile == '') {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('a/galeri/slider/data');
                    return json_encode($response);
                }
            }

            $dir = FCPATH . "uploads/slider";

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
                $this->_db->table('_tb_slider')->where('id', $oldData->id)->update($data);
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
                $response->redirect = base_url('a/galeri/slider/data');
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
