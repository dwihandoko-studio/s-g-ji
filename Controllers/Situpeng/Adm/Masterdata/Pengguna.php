<?php

namespace App\Controllers\Situpeng\Adm\Masterdata;

use App\Controllers\BaseController;
use App\Models\Situpeng\Adm\PenggunaModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengguna extends BaseController
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
            switch ($list->role_user) {
                case 4:
                    $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->fullname))  . '\', \'' . $list->username  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:actionAddRayon(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-shape-triangle font-size-16 align-middle"></i> &nbsp;Tambah Naungan</i></a>
                            </div>
                        </div>';
                    break;

                case 5:
                    $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->fullname))  . '\', \'' . $list->username  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->fullname))  . '\');"><i class="bx bx-edit-alt font-size-16 align-middle"></i> &nbsp;Edit</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:actionUnlockSpj(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-lock-open-alt font-size-16 align-middle"></i> &nbsp;Unlock SPJ</i></a>
                            </div>
                        </div>';
                    break;
                default:
                    $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionResetPassword(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->fullname))  . '\', \'' . $list->username  . '\');"><i class="bx bx-key font-size-16 align-middle"></i> &nbsp;Reset Password</a>
                                <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:actionUnlockSpj(\'' . $list->id . '\', \'' . str_replace("'", "", $list->fullname)  . '\', \'' . $list->username . '\');"><i class="bx bx-lock-open-alt font-size-16 align-middle"></i> &nbsp;Unlock SPJ</i></a>
                            </div>
                        </div>';
                    break;
            }
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->fullname;
            $row[] = $list->username;
            $row[] = $list->no_hp;
            $row[] = $list->role_name;
            switch ($list->is_active) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Aktif</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Non Aktif</span>
                    </div>';
                    break;
            }
            switch ($list->email_verified) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
                    </div>';
                    break;
            }
            switch ($list->wa_verified) {
                case 1:
                    $row[] = '<div class="text-center">
                            <span class="badge rounded-pill badge-soft-success font-size-11">Ya</span>
                        </div>';
                    break;
                default:
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Tidak</span>
                    </div>';
                    break;
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
        return redirect()->to(base_url('situpeng/adm/masterdata/pengguna/data'));
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

        return view('situpeng/adm/masterdata/pengguna/index', $data);
    }

    public function getPengawas()
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

            $already = $this->_db->table('_profil_users_tb')
                ->where("ptk_id = '$id'")->get()->getRowObject();

            if ($already) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengawas ini sudah tertaut ke akun " . $already->fullname . " - " . $already->nip;
                return json_encode($response);
            }

            $current = $this->_db->table('__pengawas_tb')
                ->where("id = '$id'")->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['id'] = $id;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = $current;
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 404;
                $response->redirrect = base_url('situpeng/adm/masterdata/pengawas');
                $response->message = "Anda terdeteksi belum melakukan Import Data Pengawas. Silahkan untuk melakukan Import Data terlebih dahulu.";
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
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'nuptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NUPTK tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong. ',
                ]
            ],
            'id_pengawas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengawas tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nuptk')
                . $this->validator->getError('nip')
                . $this->validator->getError('id_pengawas');
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
            $nuptk = htmlspecialchars($this->request->getVar('nuptk'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $id_pengawas = htmlspecialchars($this->request->getVar('id_pengawas'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $oldData =  $this->_db->table('_profil_users_tb')->where('nip', $nip)->get()->getRowObject();

            if ($oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "NIP sudah terdaftar.";
                return json_encode($response);
            }

            $uuidLib = new Uuid();

            $data = [
                'id' => $uuidLib->v4(),
                'fullname' => $nama,
                'nip' => $nip,
                'ptk_id' => $id_pengawas,
                'role_user' => 8,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();
            try {
                $this->_db->table('_users_tb')->insert([
                    'id' => $data['id'],
                    'email' => $data['nip'],
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                    'scope' => 'app',
                    'is_active' => $status,
                    'wa_verified' => 0,
                    'email_verified' => 0,
                    'email_tertaut' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    $this->_db->table('_profil_users_tb')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data baru.";
                    return json_encode($response);
                }
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan. Password Default Akun: 123456";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data baru";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data baru";
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

            $current = $this->_db->table('_users_tb')
                ->where('uid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/setting/pengguna/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function resetPassword()
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
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
                ]
            ],
            'password' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Password tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('npsn')
                . $this->validator->getError('password')
                . $this->validator->getError('email');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $password = htmlspecialchars($this->request->getVar('password'), true);

            $current = $this->_db->table('v_user')
                ->where("id = '$id'")->get()->getRowObject();
            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $id)->update(['password' => password_hash($password, PASSWORD_DEFAULT), 'updated_at' => date('Y-m-d H:i:s')]);
                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Reset Password PTK $nama berhasil. Password default : $password";
                        return json_encode($response);
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal reset password.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal reset password.";
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

    public function add()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'action' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('action');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('action'), true);

            $current = $this->_db->table('__pengawas_tb')
                ->where("nip NOT IN (SELECT nip FROM _profil_users_tb WHERE role_user = 8)")->get()->getResult();

            if (count($current) > 0) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengguna/add', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 404;
                $response->redirrect = base_url('situpeng/adm/masterdata/pengawas');
                $response->message = "Anda terdeteksi belum melakukan Import Data Pengawas. Silahkan untuk melakukan Import Data Pengawas terlebih dahulu.";
                return json_encode($response);
            }
        }
    }

    public function addRayon()
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
            $oldData =  $this->_db->table('sekolah_naungan')->where('user_id', $id)->get()->getRowObject();

            $sekolahs = $this->_db->table('ref_sekolah')->whereIn('bentuk_pendidikan_id', [6])->get()->getResult();

            if (count($sekolahs) > 0) {
                if ($oldData) {
                    $data['npsns'] = explode(",", $oldData->npsn);
                } else {
                    $data['npsns'] = [];
                }
                $data['id'] = $id;
                $data['sekolahs'] = $sekolahs;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengguna/add_rayon', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function addSaveRayon()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'sekolahs' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Sekolahs tidak boleh kosong. ',
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
            $response->message = $this->validator->getError('sekolahs')
                . $this->validator->getError('id');
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

            $sekolahs = $this->request->getVar('sekolahs');
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $oldData =  $this->_db->table('sekolah_naungan')->where('user_id', $id)->get()->getRowObject();

            $data = [
                'npsn' => $sekolahs,
            ];

            $this->_db->transBegin();
            if ($oldData) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                try {
                    $this->_db->table('sekolah_naungan')->where('user_id', $oldData->user_id)->update($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal mengupdate data baru.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {

                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil diupdate.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupdate data baru";
                    return json_encode($response);
                }
            } else {
                $data['user_id'] = $id;
                $data['created_at'] = date('Y-m-d H:i:s');

                try {
                    $this->_db->table('sekolah_naungan')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal menyimpan data baru.";
                    return json_encode($response);
                }

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
                    $response->message = "Gagal menyimpan data baru";
                    return json_encode($response);
                }
            }
        }
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

            $current = $this->_db->table('v_user')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengguna/edit', $data);
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
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('id')
                . $this->validator->getError('email')
                . $this->validator->getError('nohp')
                . $this->validator->getError('password');
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
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $password = htmlspecialchars($this->request->getVar('password'), true);

            $oldData =  $this->_db->table('v_user')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            if (
                $nama === $oldData->fullname
                && $email === $oldData->email
                && $nohp === $oldData->no_hp
            ) {
                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Tidak ada perubahan data yang disimpan.";
                $response->redirect = base_url('situpeng/adm/masterdata/pengguna');
                return json_encode($response);
            }

            if ($email !== $oldData->email) {
                $cekData = $this->_db->table('v_user')->where(['email' => $email])->get()->getRowObject();
                if ($cekData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Email sudah terdaftar pengguna lain.";
                    return json_encode($response);
                }
            }

            $dataProfil = [
                'email' => $email,
                'fullname' => $nama,
                'no_hp' => $nohp,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $data = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'email_verified' => 0,
                'email_tertaut' => 0,
                'tautan_email' => NULL,
                'update_firs_login' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($nohp !== $oldData->no_hp) {
                $data['wa_verified'] = 0;
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_users_tb')->where('id', $oldData->id)->update($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    $this->_db->table('_profil_users_tb')->where('id', $oldData->id)->update($dataProfil);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data baru.";
                    return json_encode($response);
                }
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil diupdate.";
                    $response->redirect = base_url('situpeng/adm/masterdata/pengguna');
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupate data";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }

    public function sync()
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
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'kecamatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kecamatan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('kecamatan');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);

            $apiLib = new Apilib();
            $result = $apiLib->syncSekolah($id, $kecamatan);

            if ($result) {
                if ($result->status == 200) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Syncrone Data Sekolah Berhasil Dilakukan.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal Syncrone Data";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal Syncrone Data";
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
            $current = $this->_db->table('_users_tb')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('id', $id)->delete();

                    if ($this->_db->affectedRows() > 0) {
                        try {
                            $dir = FCPATH . "uploads/user";
                            unlink($dir . '/' . $current->image);
                        } catch (\Throwable $err) {
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

    public function import()
    {
        $data['title'] = 'Import Data PTK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $data['user'] = $user->data;
        return view('situpeng/adm/masterdata/pengguna/import', $data);
    }

    public function uploadData()
    {
        if ($this->request->getMethod() != 'post') {
            $response = [
                'code' => 400,
                'error' => "Hanya request post yang diperbolehkan."
            ];
        } else {

            $rules = [
                'file' => [
                    'rules' => 'uploaded[file]|max_size[file, 5120]|mime_in[file,application/vnd.ms-excel,application/msexcel,application/x-msexcel,application/x-ms-excel,application/x-excel,application/x-dos_ms_excel,application/xls,application/x-xls,application/excel,application/download,application/vnd.ms-office,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip]',
                    'errors' => [
                        'uploaded' => 'File import gagal di upload',
                        'max_size' => 'Ukuran file melebihi batas file max file upload.',
                        'mime_in' => 'Ekstensi file tidak diizinkan untuk di upload.',
                    ]
                ]
                // 'file' => 'uploaded[file]|max_size[file, 5120]|mime_in[file,application/vnd.ms-excel,application/msexcel,application/x-msexcel,application/x-ms-excel,application/x-excel,application/x-dos_ms_excel,application/xls,application/x-xls,application/excel,application/download,application/vnd.ms-office,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip]'
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'code' => 400,
                    'error' => $this->validator->getError('file')
                ];
            } else {

                // if (!file_exists('./upload/' . $this->folderImage)) {
                //     mkdir('./upload/' . $this->folderImage, 0755);
                //     $dir = './upload/' . $this->folderImage;
                // } else {
                //     $dir = './upload/' . $this->folderImage;
                // }

                $lampiran = $this->request->getFile('file');
                $extension = $lampiran->getClientExtension();
                $filesNamelampiran = $lampiran->getName();
                $fileLocation = $lampiran->getTempName();
                // $newNamelampiran = _create_name_import($filesNamelampiran);

                // if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                //     $movedFile = $lampiran->move($dir, $newNamelampiran);
                //     if($movedFile != false) {

                //         $fileLocation = FCPATH . $dir . '/' . $newNamelampiran;

                if ('xls' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $reader->load($fileLocation);
                $sheet = $spreadsheet->getActiveSheet()->toArray();

                $total_line = (count($sheet) > 0) ? count($sheet) - 1 : 0;

                $dataImport = [];

                unset($sheet[0]);

                foreach ($sheet as $key => $data) {
                    $dataInsert = [
                        'fullname' => $data[0],
                        'email' => $data[1],
                        'kecamatan' => $data[2],
                        'sekolah' => $data[3],
                        'npsn' => $data[4],
                        'kode_kecamatan' => $data[5],
                        'koreg' => $data[6],
                    ];

                    $dataImport[] = $dataInsert;
                }

                $response = [
                    'code' => 200,
                    'success' => true,
                    'total_line' => $total_line,
                    'data' => $dataImport,
                ];
                //     } else {
                //         $response =[
                //             'code' => 400,
                //             'error' => "Gagal upload file."
                //         ];
                //     }
                // } else {
                //     $response =[
                //         'code' => 400,
                //         'error' => "Gagal upload file."
                //     ];
                // }
            }
        }

        echo json_encode($response);
    }

    public function importData()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->code = 500;
            $response->message = "Request not allowed";
            return json_encode($response);
        }

        $fullname = htmlspecialchars($this->request->getVar('fullname'), true);
        $email = htmlspecialchars($this->request->getVar('email'), true);
        $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);
        $sekolah = htmlspecialchars($this->request->getVar('sekolah'), true);
        $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
        $koreg = htmlspecialchars($this->request->getVar('koreg'), true);
        $kode_kecamatan = htmlspecialchars($this->request->getVar('kode_kecamatan'), true);

        $currentDataOnDB = $this->_db->table('_users_tb')->where('email', $email)->get()->getRowObject();

        if ($currentDataOnDB) {
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "Berhasil mengimport data. data sudah ada.";
            $response->url = base_url('');
            return json_encode($response);
        } else {

            $uuidLib = new Uuid();

            // try {

            $data = [
                'id' => $uuidLib->v4(),
                'email' => $email,
                'fullname' => $fullname,
                'npsn' => $npsn,
                'jabatan' => 'Admin',
                'kecamatan' => $kode_kecamatan,
                'role_user' => 5,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $koregs = ($koreg === NULL || $koreg === "" || strlen($koreg) < 5) ? $npsn : $koreg;

            $this->_db->transBegin();
            try {
                $this->_db->table('_users_tb')->insert([
                    'id' => $data['id'],
                    'email' => $data['email'],
                    'password' => password_hash($koregs, PASSWORD_DEFAULT),
                    'scope' => 'app',
                    'is_active' => 0,
                    'wa_verified' => 0,
                    'email_verified' => 0,
                    'email_tertaut' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Gagal menyimpan data";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    $this->_db->table('_profil_users_tb')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Gagal menyimpan data";
                    return json_encode($response);
                }
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->code = 200;
                    $response->message = "Berhasil mengimport data";
                    $response->url = base_url('');
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Gagal menyimpan data";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Gagal menyimpan data";
                return json_encode($response);
            }

            // if ($this->_db->affectedRows() > 0) {
            //     $this->_db->transCommit();
            //     $response = new \stdClass;
            //     $response->code = 200;
            //     $response->message = "Berhasil mengimport data";
            //     $response->url = base_url('');
            //     return json_encode($response);
            // } else {

            //     $this->_db->transRollback();
            //     // } catch (\Throwable $e) {
            //     $response = new \stdClass;
            //     $response->code = 400;
            //     $response->message = "Gagal menyimpan data";
            //     return json_encode($response);
            // }
        }
    }
}
