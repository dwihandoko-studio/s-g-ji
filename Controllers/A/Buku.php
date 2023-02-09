<?php

namespace App\Controllers\A;

use App\Controllers\BaseController;
use App\Models\Admin\BukuModel;
use Config\Services;
use App\Libraries\Profilelib;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Buku extends BaseController
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
        $datamodel = new BukuModel($request);
        $kategori = htmlspecialchars($request->getVar('filter_kategori'), true) ?? "";


        $lists = $datamodel->get_datatables($kategori);
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="dropup">
                        <div class="btn btn-primary btn-sm" href="javascript:;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span>&nbsp;&nbsp;Aksi&nbsp;&nbsp;</span>
                        </div>
                        <div class="dropdown-menu">
                            <button onclick="actionDetail(\'' . $list->bid . '\')" type="button" class="dropdown-item">
                                <i class="fa fa-eye"></i>
                                <span>Detail</span>
                            </button>
                            <a href="' . base_url('admin/buku/edit') . '?id=' . $list->bid . '" class="dropdown-item">
                                <i class="ni ni-ruler-pencil"></i>
                                <span>Edit</span>
                            </a>
                            <button onclick="actionHapus(\'' . $list->bid . '\', \' ' . $list->nama_buku . '\')" type="button" class="dropdown-item">
                                <i class="fa fa-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>';
            if ($list->gambar !== null) {
                $image = '<img alt="Image placeholder" src="' . base_url() . '/uploads/buku/' . $list->gambar . '" width="60px" height="60px">';
            } else {
                $image = "-";
            }
            $row[] = $action;
            $row[] = $list->kategori;
            $row[] = $list->nama_buku;
            $row[] = $list->pengarang;
            $row[] = $image;
            $row[] = $list->tahun_terbit;
            $row[] = $list->harga;
            $row[] = $list->stok;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            // "recordsTotal" => 0,
            // "recordsFiltered" => 0,
            "recordsTotal" => $datamodel->count_all($kategori),
            "recordsFiltered" => $datamodel->count_filtered($kategori),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('admin/buku/data'));
    }

    public function data()
    {
        $data['title'] = 'Buku';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['bukuMenu'] = true;
        $data['bukuMenuBuku'] = true;

        return view('admin/buku/index', $data);
    }

    public function add()
    {
        $data['title'] = 'Tambah Buku';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['kategoris'] = $this->_db->table('_tb_kategori_buku')->get()->getResult();
        $data['bukuMenu'] = true;
        $data['bukuMenuBuku'] = true;
        $data['bukuMenuBukuAdd'] = true;

        return view('admin/buku/add', $data);
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

            $current = $this->_db->table('_tb_buku a')
                ->select("a.*, b.kategori")
                ->join('_tb_kategori_buku b', 'a.k_id = b.kid')
                ->where('bid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('admin/buku/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function edit()
    {
        $data['title'] = 'Tambah Buku';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $id = htmlspecialchars($this->request->getGet('id'), true);

        $current = $this->_db->table('_tb_buku a')
            ->select("a.*, b.kategori")
            ->join('_tb_kategori_buku b', 'a.k_id = b.kid')
            ->where('bid', $id)->get()->getRowObject();

        if (!$current) {
            return view('404');
        }

        $data['user'] = $user->data;
        $data['data'] = $current;
        $data['kategoris'] = $this->_db->table('_tb_kategori_buku')->get()->getResult();
        $data['bukuMenu'] = true;
        $data['bukuMenuBuku'] = true;
        $data['bukuMenuBukuAdd'] = true;

        return view('admin/buku/edit', $data);
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

            $oldData = $this->_db->table('_tb_buku')->where('bid', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->table('_tb_buku')->where('bid', $id)->delete();

            if ($this->_db->affectedRows() > 0) {
                $dir = FCPATH . "uploads/buku";

                try {
                    unlink($dir . '/' . $oldData->gambar);
                } catch (\Throwable $th) {
                }

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
            'file' => [
                'rules' => 'uploaded[file]|max_size[file,5120]|is_image[file]',
                'errors' => [
                    'uploaded' => 'Pilih gambar buku terlebih dahulu. ',
                    'max_size' => 'Ukuran gambar buku terlalu besar. ',
                    'is_image' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama buku tidak boleh kosong. ',
                ]
            ],
            'pengarang' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pengarang tidak boleh kosong. ',
                ]
            ],
            'kategori' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori buku tidak boleh kosong. ',
                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun terbit buku tidak boleh kosong. ',
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga buku tidak boleh kosong. ',
                ]
            ],
            'qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Quantiti buku tidak boleh kosong. ',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi buku tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('pengarang')
                . $this->validator->getError('kategori')
                . $this->validator->getError('tahun')
                . $this->validator->getError('harga')
                . $this->validator->getError('qty')
                . $this->validator->getError('deskripsi')
                . $this->validator->getError('file');
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

            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $pengarang = htmlspecialchars($this->request->getVar('pengarang'), true);
            $kategori = htmlspecialchars($this->request->getVar('kategori'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $harga = htmlspecialchars($this->request->getVar('harga'), true);
            $qty = htmlspecialchars($this->request->getVar('qty'), true);
            $deskripsi = htmlspecialchars($this->request->getVar('deskripsi'), true);

            $cekData = $this->_db->table('_tb_buku')->where(['nama_buku' => $nama, 'k_id' => $kategori, 'pengarang' => $pengarang, 'tahun_terbit' => $tahun])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Buku sudah ada dalam database, silahkan menggunakan menu edit untuk merubah data.";
                return json_encode($response);
            }

            $data = [
                'nama_buku' => $nama,
                'pengarang' => $pengarang,
                'k_id' => $kategori,
                'tahun_terbit' => $tahun,
                'harga' => $harga,
                'stok' => $qty,
                'deskripsi' => $deskripsi,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $dir = FCPATH . "uploads/buku";

            $lampiran = $this->request->getFile('file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_foto($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data['gambar'] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload gambar.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_buku')->insert($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan buku baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                $response->redirect = base_url('admin/buku/data');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);
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
                    'required' => 'Id buku tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama buku tidak boleh kosong. ',
                ]
            ],
            'pengarang' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pengarang tidak boleh kosong. ',
                ]
            ],
            'kategori' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori buku tidak boleh kosong. ',
                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun terbit buku tidak boleh kosong. ',
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga buku tidak boleh kosong. ',
                ]
            ],
            'qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Quantiti buku tidak boleh kosong. ',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi buku tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                'file' => [
                    'rules' => 'uploaded[file]|max_size[file,5120]|is_image[file]',
                    'errors' => [
                        'uploaded' => 'Pilih gambar buku terlebih dahulu. ',
                        'max_size' => 'Ukuran gambar buku terlalu besar. ',
                        'is_image' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('id')
                . $this->validator->getError('pengarang')
                . $this->validator->getError('kategori')
                . $this->validator->getError('tahun')
                . $this->validator->getError('harga')
                . $this->validator->getError('qty')
                . $this->validator->getError('deskripsi')
                . $this->validator->getError('file');
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
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $pengarang = htmlspecialchars($this->request->getVar('pengarang'), true);
            $kategori = htmlspecialchars($this->request->getVar('kategori'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $harga = htmlspecialchars($this->request->getVar('harga'), true);
            $qty = htmlspecialchars($this->request->getVar('qty'), true);
            $deskripsi = htmlspecialchars($this->request->getVar('deskripsi'), true);

            // var_dump($id);
            // die;

            $oldData =  $this->_db->table('_tb_buku')->where('bid', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            if (
                $nama === $oldData->nama_buku
                && $pengarang === $oldData->pengarang
                && $tahun === $oldData->tahun_terbit
                && $harga === $oldData->harga
                && $qty === $oldData->stok
                && $kategori === $oldData->k_id
                && $deskripsi === $oldData->deskripsi
            ) {
                if ($filenamelampiran == '') {
                    $response = new \stdClass;
                    $response->status = 204;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('admin/buku/data');
                    return json_encode($response);
                }
            }

            if ($filenamelampiran == '') {
                $cekData = $this->_db->table('_tb_buku')->where(['nama_buku' => $nama, 'k_id' => $kategori, 'pengarang' => $pengarang, 'tahun_terbit' => $tahun])->get()->getRowObject();

                if ($cekData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Buku sudah ada dalam database, silahkan menggunakan menu edit untuk merubah data.";
                    return json_encode($response);
                }
            }

            $data = [
                'nama_buku' => $nama,
                'pengarang' => $pengarang,
                'k_id' => $kategori,
                'tahun_terbit' => $tahun,
                'harga' => $harga,
                'stok' => $qty,
                'deskripsi' => $deskripsi,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dir = FCPATH . "uploads/buku";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['gambar'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload gambar.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_buku')->where('bid', $oldData->bid)->update($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan buku baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    unlink($dir . '/' . $oldData->gambar);
                } catch (\Throwable $th) {
                }
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                $response->redirect = base_url('admin/buku/data');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
