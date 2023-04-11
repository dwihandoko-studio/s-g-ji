<?php

namespace App\Controllers\Situpeng\Adm\Verifikasi;

use App\Controllers\BaseController;
use App\Models\Situpeng\Adm\VerifikasitpgdetailModel;
use App\Models\Situpeng\Adm\VerifikasitpgpengawasModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situpeng\Verifikasiadminlib;
use App\Libraries\Uuid;

class Tpg extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new VerifikasitpgpengawasModel($request);

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                } else {
                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => []
                    ];
                    echo json_encode($output);
                    return;
                }
            } catch (\Exception $e) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        }

        $lists = $datamodel->get_datatables('tpg');
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="./datalist?n=' . $list->kode_usulan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            if ($list->jenjang_pengawas == "SD") {
                $row[] = "SD / TK";
            } else {
                $row[] = $list->jenjang_pengawas;
            }
            $row[] = $list->jumlah_ptk;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all('tamsil'),
            "recordsFiltered" => $datamodel->count_filtered('tamsil'),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllDetail()
    {
        $request = Services::request();
        $datamodel = new VerifikasitpgdetailModel($request);

        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                } else {
                    $output = [
                        "draw" => $request->getPost('draw'),
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => []
                    ];
                    echo json_encode($output);
                    return;
                }
            } catch (\Exception $e) {
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ];
                echo json_encode($output);
                return;
            }
        }

        // $npsns = $this->_helpLib->getSekolahNaungan($userId);

        $lists = $datamodel->get_datatables($request->getPost('id'));
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="javascript:actionDetail(\'' . $list->id_usulan . '\', \'' . $list->id_pengawas . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->kode_usulan;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->nip;
            $row[] = $list->nuptk;
            $row[] = $list->jenis_ptk;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($request->getPost('id')),
            "recordsFiltered" => $datamodel->count_filtered($request->getPost('id')),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situpeng/adm/verifikasi/tpg/data'));
    }

    public function data()
    {
        $data['title'] = 'VERIFIKASI USULAN TUNJANGAN PROFESI GURU';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        return view('situpeng/adm/verifikasi/tpg/index', $data);
    }

    public function datalist()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $id = htmlspecialchars($this->request->getGet('n'), true);

        $data['title'] = 'VERIFIKASI USULAN TUNJANGAN PROFESI GURU';
        $data['user'] = $user->data;
        $data['kode_usulan'] = $id;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        return view('situpeng/adm/verifikasi/tpg/detail_index', $data);
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
            'id_ptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('id_ptk')
                . $this->validator->getError('tw')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $current = $this->_db->table('_tb_temp_usulan_detail_pengawas a')
                ->select("b.*, a.id as id_usulan, a.id_tahun_tw, a.jenis_tunjangan, a.us_pang_golongan, a.us_pang_tmt, a.us_pang_tgl, a.us_pang_mk_tahun, a.us_pang_mk_bulan, a.us_pang_jenis, a.us_gaji_pokok, a.status_usulan, c.gaji_pokok as gaji_pokok_referensi, d.pang_no, d.pangkat_terakhir as lampiran_pangkat, d.kgb_terakhir as lampiran_kgb, d.pernyataan_24jam as lampiran_pernyataan, d.penugasan as lampiran_penugasan, d.kunjungan_binaan as lampiran_kunjungan_binaan, d.cuti as lampiran_cuti, d.pensiun as lampiran_pensiun, d.kematian as lampiran_kematian, d.lainnya as lampiran_attr_lainnya")
                ->join('__pengawas_tb b', 'a.id_pengawas = b.id')
                ->join('__pengawas_upload_data_attribut d', 'a.id_pengawas = d.id_ptk AND (a.id_tahun_tw = d.id_tahun_tw)')
                ->join('ref_gaji c', 'a.us_pang_golongan = c.pangkat AND (c.masa_kerja = (IF(a.us_pang_mk_tahun > 32, 32, a.us_pang_mk_tahun)))', 'LEFT')
                ->where(['a.id' => $id, 'a.id_tahun_tw' => $tw])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/verifikasi/tpg/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function approve()
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $canGrantedVerifikasi = canGrantedVerifikasiPengawas($user->data->id);

            if ($canGrantedVerifikasi && $canGrantedVerifikasi->code !== 200) {
                return json_encode($canGrantedVerifikasi);
            }

            // $canUsulTamsil = canVerifikasiTpg();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $oldData = $this->_db->table('_tb_usulan_detail_tpg_pengawas')->where(['id' => $id])->get()->getRowObject();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_usulan_detail_tpg_pengawas')->where('id', $oldData->id)->update(['status_usulan' => 2, 'date_approve' => date('Y-m-d H:i:s'), 'admin_approve' => $user->data->id]);
                if ($this->_db->affectedRows() > 0) {
                    try {
                        $checkLocked = $this->_db->table('_tb_sptjm_pengawas')->select('is_locked')->where('kode_usulan', $oldData->kode_usulan)->get()->getRowObject();
                        if ($checkLocked) {
                            if ($checkLocked->is_locked == 0) {
                                $this->_db->table('_tb_sptjm_pengawas')->where('kode_usulan', $oldData->kode_usulan)->update(['is_locked' => 1]);
                            }
                        }
                        $this->_db->table('__pengawas_upload_data_attribut')->where(['id_ptk' => $oldData->id_ptk, 'id_tahun_tw' => $oldData->id_tahun_tw])->update(['is_locked' => 1]);
                        $this->_db->table('__pengawas_tb')->where(['id' => $oldData->id_ptk])->update(['is_locked' => 1]);

                        $verifikasiLib = new Verifikasiadminlib();
                        $verifikasiLib->create($user->data->id, $oldData->kode_usulan, 'tpg', $oldData->id_ptk, $oldData->id_tahun_tw, 'Lolos');
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->error = var_dump($th);
                        $response->onError = 'update SPTJM';
                        $response->message = "Gagal memverifikasi usulan $nama.";
                        return json_encode($response);
                    }

                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Usulan $nama berhasil diverifikasi dan disetujui.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memverifikasi usulan $nama.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal memverifikasi usulan $nama.";
                return json_encode($response);
            }
        }
    }

    public function formtolak()
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $canGrantedVerifikasi = canGrantedVerifikasi($user->data->id);

            if ($canGrantedVerifikasi && $canGrantedVerifikasi->code !== 200) {
                return json_encode($canGrantedVerifikasi);
            }

            // $canUsulTamsil = canVerifikasiTpg();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $data['id'] = $id;
            $data['nama'] = $nama;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situpeng/adm/verifikasi/tpg/tolak', $data);
            return json_encode($response);
        }
    }

    public function tolak()
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
            'keterangan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('keterangan');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                $response->redirect = base_url('auth');
                return json_encode($response);
            }

            $canGrantedVerifikasi = canGrantedVerifikasi($user->data->id);

            if ($canGrantedVerifikasi && $canGrantedVerifikasi->code !== 200) {
                return json_encode($canGrantedVerifikasi);
            }

            // $canUsulTamsil = canVerifikasiTpg();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $keterangan = htmlspecialchars($this->request->getVar('keterangan'), true);

            $oldData = $this->_db->table('_tb_usulan_detail_tpg_pengawas')->where(['id' => $id])->get()->getRowObject();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_usulan_detail_tpg_pengawas')->where('id', $oldData->id)->update(['status_usulan' => 3, 'keterangan_reject' => $keterangan, 'admin_reject' => $user->data->id, 'date_reject' => date('Y-m-d H:i:s')]);
                if ($this->_db->affectedRows() > 0) {
                    try {
                        $checkLocked = $this->_db->table('_tb_sptjm_pengawas')->select('is_locked')->where('kode_usulan', $oldData->kode_usulan)->get()->getRowObject();
                        if ($checkLocked) {
                            if ($checkLocked->is_locked == 0) {
                                $this->_db->table('_tb_sptjm_pengawas')->where('kode_usulan', $oldData->kode_usulan)->update(['is_locked' => 1]);
                            }
                        }
                        $this->_db->table('__pengawas_upload_data_attribut')->where(['id_ptk' => $oldData->id_ptk, 'id_tahun_tw' => $oldData->id_tahun_tw])->update(['is_locked' => 0]);
                        $this->_db->table('__pengawas_tb')->where(['id' => $oldData->id_ptk])->update(['is_locked' => 0]);

                        $verifikasiLib = new Verifikasiadminlib();
                        $verifikasiLib->create($user->data->id, $oldData->kode_usulan, 'tpg', $oldData->id_ptk, $oldData->id_tahun_tw, 'Ditolak', $keterangan);
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->error = var_dump($th);
                        $response->onError = 'update SPTJM';
                        $response->message = "Gagal memverifikasi usulan $nama.";
                        return json_encode($response);
                    }

                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Usulan $nama berhasil diverifikasi dan ditolak.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memverifikasi usulan $nama.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal memverifikasi usulan $nama.";
                return json_encode($response);
            }
        }
    }

    public function tester()
    {
        $data = $this->_db->table('_tb_temp_usulan_detail_pengawas_backup_change')->get()->getResult();

        foreach ($data as $key => $value) {
            $mk = ((int)$value->us_pang_mk_tahun > 32) ? '32' : $value->us_pang_mk_tahun;
            $gajiPokok = $this->_db->table('ref_gaji')
                ->where('pangkat', $value->us_pang_golongan)
                ->where('masa_kerja', $mk)
                ->get()->getRowObject();
            $this->_db->table('_tb_temp_usulan_detail_pengawas_backup_change')->where('id', $value->id)->update(
                [
                    'us_gaji_pokok' => $gajiPokok ? $gajiPokok->gaji_pokok : 0
                ]
            );
        }
    }
}
