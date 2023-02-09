<?php

namespace App\Controllers\A\Setting;

use App\Controllers\BaseController;
use App\Models\A\Setting\MenulainModel;
use Config\Services;
use App\Libraries\Profilelib;

class Menulain extends BaseController
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
        $datamodel = new MenulainModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->judul) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                        </a>
                        <a href="javascript:actionEdit(\'' . $list->id . '\', \'' . str_replace("'", "", $list->judul) . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bx-edit font-size-16 align-middle"></i></button>
                        </a>
                        <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->judul) . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bx-trash font-size-16 align-middle"></i></button>
                        </a>';
            if ((int)$list->external_link == 1) {
                $image = '<span class="badge badge-pill badge-soft-danger">External Link</span>';
            } else {
                $image = '<span class="badge badge-pill badge-soft-success">Content Link</span>';
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

            if ((int)$list->has_sub == 0) {
                $hasSub = '<span class="badge badge-pill badge-soft-danger">Tidak</span>';
            } else {
                $hasSub = '<span class="badge badge-pill badge-soft-success">Ya</span>';
            }

            if ((int)$list->parent == 0) {
                $parent = 'Menu Utama';
            } else {
                $parent = $list->nama_parent;
            }
            $row[] = $image;
            $row[] = $hasSub;
            $row[] = $parent;
            $row[] = $list->judul;
            $row[] = potong_teks($list->url, 50);
            // $row[] = $list->deskripsi;

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
        return redirect()->to(base_url('a/setting/menulain/data'));
    }

    public function data()
    {
        $data['title'] = 'Menu Lain Publik';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/setting/menulain/index', $data);
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

        $data['parents'] = $this->_db->table('_tb_menu_lain')->select("id, judul")->where(['has_sub' => 1, 'parent' => 0])->orderBy('urut', 'ASC')->get()->getResult();

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('a/setting/menulain/add', $data);
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

            $current = $this->_db->table('_tb_menu_lain')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['parents'] = $this->_db->table('_tb_menu_lain')->select("id, judul")->where(['has_sub' => 1, 'parent' => 0])->orderBy('urut', 'ASC')->get()->getResult();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/menulain/edit', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function detail()
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

            $current = $this->_db->table('_tb_menu_lain')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/menulain/detail', $data);
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
            $current = $this->_db->table('_tb_menu_lain')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                if ((int)$current->has_sub == 1) {
                    $countRes = $this->_db->table('_tb_menu_lain')->where('parent', $current->id)->countAllResults();
                    if ($countRes > 0) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Anda tidak diizinkan menghapus data ini, karena ada menu ini menjadi parent sub menu lain. Silahkan untuk menghapus parent sub menu terlebih dahulu.";
                        return json_encode($response);
                    }
                }
                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_menu_lain')->where('id', $id)->delete();

                    if ($this->_db->affectedRows() > 0) {
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
                    'required' => 'Judul sop tidak boleh kosong. ',
                ]
            ],
            'external_link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'External link tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
            'urut' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Urut tidak boleh kosong. ',
                ]
            ],
            'parent' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Parent tidak boleh kosong. ',
                ]
            ],
        ];


        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('judul')
                . $this->validator->getError('isi')
                . $this->validator->getError('external_link')
                . $this->validator->getError('status')
                . $this->validator->getError('urut')
                . $this->validator->getError('parent');
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
            $isi = $this->request->getVar('isi');
            $external_link = htmlspecialchars($this->request->getVar('external_link'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);
            $urut = htmlspecialchars($this->request->getVar('urut'), true);
            $url = htmlspecialchars($this->request->getVar('url'), true);
            $parent = htmlspecialchars($this->request->getVar('parent'), true);

            $slug = "#";

            if ((int)$external_link == 0) {

                $slug = generateSlug($judul);

                $cekData = $this->_db->table('_tb_menu_lain')->where(['url' => 'lain-lain/' . $slug . '.html'])->get()->getRowObject();

                if ($cekData) {
                    $slug = $slug . "-" . date('Y-m-d') . "-" . date('H-i-s') . ".html";
                } else {
                    $slug = $slug . ".html";
                }
            } else {
                $slug = $url;
            }

            $isi = str_replace('<img src=', '<img style="max-width: 100%;" src=', $isi);

            $hasSub = 0;

            if ((int)$parent == 0 && $url == "#") {
                $hasSub = 1;
            }

            $data = [
                'judul' => $judul,
                'status' => $status,
                'urut' => $urut,
                'parent' => $parent,
                'has_sub' => $hasSub,
                'external_link' => $external_link,
                'url' => $slug,
                'isi' => $isi,
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_menu_lain')->insert($data);
            } catch (\Exception $e) {
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
                $response->redirect = base_url('a/setting/menulain/data');
                return json_encode($response);
            } else {
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
                    'required' => 'Judul sop tidak boleh kosong. ',
                ]
            ],
            'external_link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'External link tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
            'urut' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Urut tidak boleh kosong. ',
                ]
            ],
            'parent' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Urut tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('judul')
                . $this->validator->getError('isi')
                . $this->validator->getError('external_link')
                . $this->validator->getError('status')
                . $this->validator->getError('urut')
                . $this->validator->getError('parent');
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
            $isi = $this->request->getVar('isi');
            $external_link = htmlspecialchars($this->request->getVar('external_link'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);
            $urut = htmlspecialchars($this->request->getVar('urut'), true);
            $parent = htmlspecialchars($this->request->getVar('parent'), true);
            $url = htmlspecialchars($this->request->getVar('url'), true);

            $oldData =  $this->_db->table('_tb_menu_lain')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $isi = str_replace('<img src=', '<img style="max-width: 100%;" src=', $isi);

            $hasSub = 0;

            $data = [
                'judul' => $judul,
                'status' => $status,
                'urut' => $urut,
                'parent' => $parent,
                'external_link' => $external_link,
                'isi' => $isi,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ((int)$external_link !== (int)$oldData->external_link) {
                if ((int)$external_link == 0) {
                    if ($judul !== $oldData->judul) {
                        $slug = generateSlug($judul);
                        $cekData = $this->_db->table('_tb_menu_lain')->where(['url' => 'lain-lain/' . $slug . '.html'])->get()->getRowObject();

                        if ($cekData) {
                            $slug = $slug . "-" . date('Y-m-d') . "-" . date('H-i-s') . ".html";
                        } else {
                            $slug = $slug . ".html";
                        }

                        $data['url'] = $slug;
                    } else {
                        $data['url'] = $url;
                    }
                } else {
                    if ((int)$parent == 0 && $url == "#") {
                        $hasSub = 1;
                    }
                    $data['url'] = $url;
                    $data['has_sub'] = $hasSub;
                }
            } else {
                if ((int)$external_link == 0) {
                    if ($judul !== $oldData->judul) {
                        $slug = generateSlug($judul);
                        $cekData = $this->_db->table('_tb_menu_lain')->where(['url' => 'lain-lain/' . $slug . '.html'])->get()->getRowObject();

                        if ($cekData) {
                            $slug = $slug . "-" . date('Y-m-d') . "-" . date('H-i-s') . ".html";
                        } else {
                            $slug = $slug . ".html";
                        }

                        $data['url'] = $slug;
                    } else {
                        $data['url'] = $url;
                    }
                } else {
                    if ((int)$parent == 0 && $url == "#") {
                        $hasSub = 1;
                    }
                    $data['url'] = $url;
                    $data['has_sub'] = $hasSub;
                }
            }

            if (
                (int)$status === (int)$oldData->status
                && $judul === $oldData->judul
                && $isi === $oldData->isi
                && $url === $oldData->url
                && $urut === $oldData->urut
                && (int)$parent === (int)$oldData->parent
                && $external_link === $oldData->external_link
            ) {

                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Tidak ada perubahan data yang disimpan.";
                $response->redirect = base_url('a/setting/menulain/data');
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_menu_lain')->where('id', $oldData->id)->update($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data gagal disimpan.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                $response->redirect = base_url('a/setting/menulain/data');
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

    public function uploadImage()
    {
        $validated = $this->validate([
            'upload' => [
                'uploaded[upload]',
                'max_size[upload, 1024]',
                'is_image[upload]',
            ],
        ]);

        if ($validated) {
            $lampiran = $this->request->getFile('upload');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_foto($filesNamelampiran);
            $writePath = FCPATH . "uploads/setting/widget";

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($writePath, $newNamelampiran);
                $data = [
                    "uploaded" => true,
                    "url" => base_url('uploads/setting/widget/' . $newNamelampiran),
                ];
            } else {
                $data = [
                    "uploaded" => false,
                    "error" => [
                        "message" => $lampiran
                    ],
                ];
            }
        } else {
            $data = [
                "uploaded" => false,
                "error" => [
                    "message" => $this->validator->getError('upload')
                ],
            ];
        }
        return $this->response->setJSON($data);
    }
}
