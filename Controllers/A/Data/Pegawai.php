<?php

namespace App\Controllers\A\Data;

use App\Controllers\BaseController;
use App\Models\A\Data\PegawaiModel;
use Config\Services;
use App\Libraries\Profilelib;

class Pegawai extends BaseController
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
        $datamodel = new PegawaiModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            if ($list->image !== null) {
                $image = '<img alt="Image placeholder" src="' . base_url() . '/uploads/pegawai/' . $list->image . '" width="80px" height="50px">';
            } else {
                $image = "-";
            }

            switch ((int)$list->created_akun) {
                case 1:
                    $row[] = '<a href="javascript:actionDetail(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bxs-show font-size-16 align-middle"></i></button>
                            </a>
                            <a href="javascript:actionResetAkun(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-warning btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bxs-lock-open-alt font-size-16 align-middle"></i></button>
                            </a>
                            <a href="javascript:actionEdit(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bx-edit font-size-16 align-middle"></i></button>
                            </a>
                            <a href="javascript:actionHapus(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                            <i class="bx bx-trash font-size-16 align-middle"></i></button>
                            </a>';
                    $row[] = '<span class="badge badge-pill badge-soft-success">Sudah</span>';
                    break;
                default:
                    $row[] = '<a href="javascript:actionDetail(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                </a>
                                <a href="javascript:actionCreateAkun(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-warning btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                <i class="bx bxs-user-plus font-size-16 align-middle"></i></button>
                                </a>
                                <a href="javascript:actionEdit(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                <i class="bx bx-edit font-size-16 align-middle"></i></button>
                                </a>
                                <a href="javascript:actionHapus(\'' . $list->pid . '\', \'' . str_replace("'", "", $list->fullname) . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                <i class="bx bx-trash font-size-16 align-middle"></i></button>
                                </a>';
                    $row[] = '<span class="badge badge-pill badge-soft-danger">Belum</span>';
                    break;
            }
            switch ((int)$list->status) {
                case 1:
                    $row[] = '<span class="badge badge-pill badge-soft-success">Terpublish</span>';
                    break;
                default:
                    $row[] = '<span class="badge badge-pill badge-soft-danger">Tidak</span>';
                    break;
            }
            $row[] = $list->fullname;
            $row[] = $list->nip;
            $row[] = $list->email;
            $row[] = $list->jabatan;
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
        return redirect()->to(base_url('a/data/pegawai/data'));
    }

    public function data()
    {
        $data['title'] = 'Pegawai';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/data/pegawai/index', $data);
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
        $response->data = view('a/data/pegawai/add');
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

            $current = $this->_db->table('_tb_pegawai a')
                ->select("a.*, b.tingkat")
                ->join('_tb_jabatan b', 'a.j_id = b.jid', 'left')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;

                $jabatans = $this->_db->table('_tb_jabatan a')
                    ->select("a.*, b.jabatan as parentJabatan")
                    ->join('_tb_jabatan b', 'a.parent = b.jid', 'left')
                    ->where('a.tingkat', $current->tingkat)->get()->getResult();
                $data['jabatans'] = $jabatans;

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/data/pegawai/edit', $data);
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

            $current = $this->_db->table('_tb_pegawai a')
                ->select("a.*, b.jabatan")
                ->join('_tb_jabatan b', 'a.j_id = b.jid', 'left')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/data/pegawai/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function createAkun()
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
            $current = $this->_db->table('_tb_pegawai')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                $date = date('Y-m-d H:i:s');
                $data = [
                    'email' => $current->email,
                    'fullname' => $current->fullname,
                    'password' => password_hash('123456', PASSWORD_BCRYPT),
                    'no_hp' => $current->no_hp,
                    'level' => 2,
                    'nip' => $current->nip,
                    'created_at' => $date,
                ];

                try {
                    $this->_db->table('_users_tb')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal membuatkan akun pegawai.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    try {
                        $this->_db->table('_tb_pegawai')->where('pid', $id)->update(['created_akun' => 1, 'updated_at' => $date]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Akun pegawai berhasil dibuat.";
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal membuatkan akun pegawai.";
                            return json_encode($response);
                        }
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal membuatkan akun pegawai.";
                        return json_encode($response);
                    }
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal membuatkan akun pegawai.";
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

    public function resetAkun()
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

            $current = $this->_db->table('_tb_pegawai')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->table('_users_tb')->where('email', $current->email)->update(['password' => password_hash('123456', PASSWORD_BCRYPT), 'updated_at' => date('Y-m-d H:i:s')]);
                if ($this->_db->affectedRows() > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Password pegawai $current->fullname berhasil direset. Password Default : <b>123456</b>";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mereset password pegawai $current->fullname.";
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
            $current = $this->_db->table('_tb_pegawai')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('email', $current->email)->delete();
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data gagal dihapus.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    try {
                        $this->_db->table('_tb_pegawai')->where('pid', $id)->delete();

                        if ($this->_db->affectedRows() > 0) {
                            if ($current->image !== null) {
                                try {
                                    $dir = FCPATH . "uploads/pegawai";
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

            $current = $this->_db->table('_tb_jabatan a')
                ->select("a.*, b.jabatan as parentJabatan")
                ->join('_tb_jabatan b', 'a.parent = b.jid', 'left')
                ->where('a.tingkat', $id)->get()->getResult();

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

    public function addSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'jabatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jabatan tidak boleh kosong. ',
                ]
            ],
            'fullname' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Fullname tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIP/NIK tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            'biodata' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Biodata tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
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
                    'uploaded' => 'Pilih gambar berita terlebih dahulu. ',
                    'max_size' => 'Ukuran gambar berita terlalu besar. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('jabatan')
                . $this->validator->getError('fullname')
                . $this->validator->getError('nip')
                . $this->validator->getError('email')
                . $this->validator->getError('nohp')
                . $this->validator->getError('biodata')
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

            $jabatan = htmlspecialchars($this->request->getVar('jabatan'), true);
            $fullname = htmlspecialchars($this->request->getVar('fullname'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $biodata = $this->request->getVar('biodata');
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $cekDataNip = $this->_db->table('_tb_pegawai')->where(['nip' => $nip])->get()->getRowObject();

            if ($cekDataNip) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "NIP/NIK sudah terdaftar";
                return json_encode($response);
            }

            $cekDataEmail = $this->_db->table('_tb_pegawai')->where(['email' => $email])->get()->getRowObject();

            if ($cekDataEmail) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Email sudah terdaftar";
                return json_encode($response);
            }

            $data = [
                'j_id' => $jabatan,
                'fullname' => $fullname,
                'nip' => $nip,
                'email' => $email,
                'no_hp' => $nohp,
                'status' => $status,
                'created_akun' => 0,
                'biodata' => $biodata,
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/pegawai";

            $lampiran = $this->request->getFile('_file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_foto($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data['image'] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }


            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_pegawai')->insert($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
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
                $response->redirect = base_url('a/data/pegawai/data');
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
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'jabatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jabatan tidak boleh kosong. ',
                ]
            ],
            'fullname' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Fullname tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIP/NIK tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            'biodata' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Biodata tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,512]|mime_in[_file,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih gambar berita terlebih dahulu. ',
                        'max_size' => 'Ukuran gambar berita terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('fullname')
                . $this->validator->getError('nip')
                . $this->validator->getError('email')
                . $this->validator->getError('nohp')
                . $this->validator->getError('biodata')
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
            $jabatan = htmlspecialchars($this->request->getVar('jabatan'), true);
            $fullname = htmlspecialchars($this->request->getVar('fullname'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $biodata = $this->request->getVar('biodata');
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $oldData =  $this->_db->table('_tb_pegawai')->where('pid', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'j_id' => $jabatan,
                'fullname' => $fullname,
                'nip' => $nip,
                'email' => $email,
                'no_hp' => $nohp,
                'status' => $status,
                'biodata' => $biodata,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (
                (int)$jabatan === (int)$oldData->j_id
                && (int)$status === (int)$oldData->status
                && $fullname === $oldData->fullname
                && $email === $oldData->email
                && $nip === $oldData->nip
                && $nohp === $oldData->no_hp
                && $biodata === $oldData->biodata
            ) {
                if ($filenamelampiran == '') {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('a/data/pegawai/data');
                    return json_encode($response);
                }
            }

            if ($email !== $oldData->email) {
                $cekDataEmail = $this->_db->table('_tb_pegawai')->where(['email' => $email])->get()->getRowObject();
                if ($cekDataEmail) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Email sudah terdaftar pegawai lain.";
                    return json_encode($response);
                }
            }

            if ($nip !== $oldData->nip) {
                $cekDataNip = $this->_db->table('_tb_pegawai')->where(['nip' => $nip])->get()->getRowObject();
                if ($cekDataNip) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "NIP/NIK sudah terdaftar pegawai lain.";
                    return json_encode($response);
                }
            }

            $dir = FCPATH . "uploads/pegawai";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('_file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['image'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload gambar.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_pegawai')->where('pid', $oldData->pid)->update($data);
            } catch (\Exception $e) {
                if ($filenamelampiran != '') {
                    unlink($dir . '/' . $newNamelampiran);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data gagal disimpan.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                if ($filenamelampiran != '') {
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
                $response->redirect = base_url('a/data/pegawai/data');
                return json_encode($response);
            } else {
                if ($filenamelampiran != '') {
                    unlink($dir . '/' . $newNamelampiran);
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
