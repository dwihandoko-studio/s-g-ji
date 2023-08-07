<?php

namespace App\Controllers\Silastri\Adm\Pengaduan;

use App\Controllers\BaseController;
use App\Models\Silastri\Adm\Pengaduan\AntrianModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;
use App\Libraries\Silastri\Riwayatpengaduanlib;
use iio\libmergepdf\Merger;
use Dompdf\Dompdf;

class Antrian extends BaseController
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
        $datamodel = new AntrianModel($request);

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $lists = $datamodel->get_datatables();
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
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->nik . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->kategori;
            $row[] = $list->kode_aduan;
            $row[] = $list->nik;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama_aduan));

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
        return redirect()->to(base_url('silastri/adm/pengaduan/antrian/data'));
    }

    public function data()
    {
        $data['title'] = 'Antrian Pengaduan Layanan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        $data['jeniss'] = ['Pengaduan Program Bantuan Sosial', 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)', 'Pengaduan Layanan Sosial', 'Lainnya'];

        return view('silastri/adm/pengaduan/antrian/index', $data);
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
            'nik' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK tidak boleh kosong. ',
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
                . $this->validator->getError('nik')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $current = $this->_db->table('_pengaduan a')
                ->select("a.*")
                // ->join('_profil_users_tb b', 'b.id = a.user_id')
                ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                ->where(['a.id' => $id, 'a.status_aduan' => 1])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('silastri/adm/pengaduan/antrian/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function proses()
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
                $response->redirrect = base_url('auth');
                return json_encode($response);
            }
            // $canUsulTamsil = canUsulTamsil();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $oldData = $this->_db->table('_pengaduan')->where(['id' => $id])->get()->getRowObject();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengaduan tidak ditemukan.";
                return json_encode($response);
            }

            $data['id'] = $id;
            $data['nama'] = $nama;
            $data['data'] = $oldData;
            $data['dinass'] = [];
            $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
            $data['kelurahans'] = $this->_db->table('ref_kelurahan')->orderBy('kelurahan', 'ASC')->get()->getResult();
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('silastri/adm/pengaduan/antrian/form-tanggapan', $data);
            return json_encode($response);
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
            // $canUsulTamsil = canUsulTamsil();

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
            $response->data = view('silastri/su/layanan/antrian/tolak', $data);
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
                $response->redirrect = base_url('auth');
                return json_encode($response);
            }
            // $canUsulTamsil = canUsulTamsil();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $keterangan = htmlspecialchars($this->request->getVar('keterangan'), true);

            $oldData = $this->_db->table('_permohonan_temp')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Permohonan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_reject'] = $date;
            $oldData['admin_reject'] = $user->data->id;
            $oldData['keterangan_reject'] = $keterangan;
            $oldData['status_permohonan'] = 3;

            $this->_db->transBegin();
            $this->_db->table('_permohonan_tolak')->insert($oldData);
            if ($this->_db->affectedRows() > 0) {
                $this->_db->table('_permohonan_temp')->where('id', $oldData['id'])->delete();
                if ($this->_db->affectedRows() > 0) {
                    // try {
                    //     $riwayatLib = new Riwayatlib();
                    //     $riwayatLib->insert("Menolak Pendaftaran $name via Jalur Afirmasi dengan NISN : " . $nisn, "Tolak Pendaftaran Jalur Afirmasi", "tolak");

                    //     $saveNotifSystem = new Notificationlib();
                    //     $saveNotifSystem->send([
                    //         'judul' => "Pendaftaran Jalur Afirmasi Ditolak.",
                    //         'isi' => "Pendaftaran anda melalui jalur afirmasi ditolak dengan keterangan: $keterangan.",
                    //         'action_web' => 'peserta/riwayat/pendaftaran',
                    //         'action_app' => 'riwayat_pendaftaran_page',
                    //         'token' => $cekRegisterTemp['id'],
                    //         'send_from' => $user->data->id,
                    //         'send_to' => $cekRegisterTemp['user_id'],
                    //     ]);

                    //     $onesignal = new Fcmlib();
                    //     $send = $onesignal->pushNotifToUser([
                    //         'title' => "Pendaftaran Jalur Afirmasi Ditolak.",
                    //         'content' => "Pendaftaran anda melalui jalur afirmasi ditolak dengan keterangan: $keterangan.",
                    //         'send_to' => $cekRegisterTemp['user_id'],
                    //         'app_url' => 'riwayat_pendaftaran_page',
                    //     ]);
                    // } catch (\Throwable $th) {
                    // }
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->redirrect = base_url('silastri/su/layanan/antrian');
                    $response->message = "Tolak Proses Permohonan $nama berhasil dilakukan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menolak proses permohonan $nama";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menolak proses permohonan $nama";
                return json_encode($response);
            }
        }
    }

    public function tanggapi()
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
            'media_pengaduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Media pengaduan tidak boleh kosong. ',
                ]
            ],
            'uraian_permasalahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Uraian Permasalahan tidak boleh kosong. ',
                ]
            ],
            'pokok_permasalahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pokok permasalahan ke tidak boleh kosong. ',
                ]
            ],
            'dtks' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'DTKS ke tidak boleh kosong. ',
                ]
            ],
            'pkh' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'PKH ke tidak boleh kosong. ',
                ]
            ],
            'bpnt' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'BPNT ke tidak boleh kosong. ',
                ]
            ],
            'rst' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Rumah sederhana terpadu ke tidak boleh kosong. ',
                ]
            ],
            'jawaban' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jawaban ke tidak boleh kosong. ',
                ]
            ],
            'saran_tindaklanjut' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Saran tindaklanjut ke tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('media_pengaduan')
                . $this->validator->getError('uraian_permasalahan')
                . $this->validator->getError('pokok_permasalahan')
                . $this->validator->getError('dtks')
                . $this->validator->getError('pkh')
                . $this->validator->getError('bpnt')
                . $this->validator->getError('rst')
                . $this->validator->getError('jawaban')
                . $this->validator->getError('saran_tidaklanjut');
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
                $response->redirrect = base_url('auth');
                return json_encode($response);
            }
            // $canUsulTamsil = canUsulTamsil();

            // if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
            //     return json_encode($canUsulTamsil);
            // }

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $media_pengaduan = htmlspecialchars($this->request->getVar('media_pengaduan'), true);
            $uraian_permasalahan = htmlspecialchars($this->request->getVar('uraian_permasalahan'), true);
            $pokok_permasalahan = htmlspecialchars($this->request->getVar('pokok_permasalahan'), true);
            $dtks = htmlspecialchars($this->request->getVar('dtks'), true);
            $pkh = htmlspecialchars($this->request->getVar('pkh'), true);
            $bpnt = htmlspecialchars($this->request->getVar('bpnt'), true);
            $rst = htmlspecialchars($this->request->getVar('rst'), true);
            $bansos_lain = $this->request->getVar('bansos_lain') ? htmlspecialchars($this->request->getVar('bansos_lain'), true) : NULL;
            $bansos_lain_pilihan = $this->request->getVar('bansos_lain_option') ? htmlspecialchars($this->request->getVar('bansos_lain_option'), true) : NULL;
            $kepersertaan_jamkesnas = $this->request->getVar('kepersertaan_jamkesnas') ? htmlspecialchars($this->request->getVar('kepersertaan_jamkesnas'), true) : NULL;
            $kepersertaan_jamkesnas_pilihan = $this->request->getVar('kepersertaan_jamkesnas_option') ? htmlspecialchars($this->request->getVar('kepersertaan_jamkesnas_option'), true) : NULL;
            $jawaban = htmlspecialchars($this->request->getVar('jawaban'), true);
            $saran_tindaklanjut = htmlspecialchars($this->request->getVar('saran_tidaklanjut'), true);
            $kepala_dinas = $this->request->getVar('kepala_dinas') ? htmlspecialchars($this->request->getVar('kepala_dinas'), true) : NULL;
            $kepala_dinas_pilihan = $this->request->getVar('kepala_dinas_pilihan') ? htmlspecialchars($this->request->getVar('kepala_dinas_pilihan'), true) : NULL;
            $camat = $this->request->getVar('camat') ? htmlspecialchars($this->request->getVar('camat'), true) : NULL;
            $camat_pilihan = $this->request->getVar('camat_pilihan') ? htmlspecialchars($this->request->getVar('camat_pilihan'), true) : NULL;
            $kampung = $this->request->getVar('kampung') ? htmlspecialchars($this->request->getVar('kampung'), true) : NULL;
            $kampung_pilihan = $this->request->getVar('kampung_pilihan') ? htmlspecialchars($this->request->getVar('kampung_pilihan'), true) : NULL;

            $oldData = $this->_db->table('_pengaduan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengaduan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');
            $upData = [];
            $upData['updated_at'] = $date;
            $upData['date_approve'] = $date;
            $upData['admin_approve'] = $user->data->id;
            $upData['status_aduan'] = 2;

            $this->_db->transBegin();
            $this->_db->table('_pengaduan')->where('id', $oldData['id'])->update($upData);
            if ($this->_db->affectedRows() > 0) {
                $dataTindakLanjut = [
                    'id' => $oldData['id'],
                    'kode_aduan' => $oldData['kode_aduan'],
                    'media_pengaduan' => $oldData['media_pengaduan'],
                    'uraian_permasalahan' => $uraian_permasalahan,
                    'pokok_permasalahan' => $pokok_permasalahan,
                    'bansos_dtks' => $dtks,
                    'bansos_pkh' => $pkh,
                    'bansos_bpnt' => $bpnt,
                    'bansos_rst' => $rst,
                    'bansos_lain' => ($bansos_lain == NULL || $bansos_lain == "") ? NULL : $bansos_lain,
                    'bansos_lain_pilihan' => ($bansos_lain_pilihan == NULL || $bansos_lain_pilihan == "") ? NULL : $bansos_lain_pilihan,
                    'kepersertaan_jkn' => ($kepersertaan_jamkesnas == NULL || $kepersertaan_jamkesnas == "") ? NULL : $kepersertaan_jamkesnas,
                    'kepersertaan_jkn_pilihan' => ($kepersertaan_jamkesnas_pilihan == NULL || $kepersertaan_jamkesnas_pilihan == "") ? NULL : $kepersertaan_jamkesnas_pilihan,
                    'jawaban' => $jawaban,
                    'saran_tindaklanjut' => $saran_tindaklanjut,
                    'tembusan_dinas' => ($kepala_dinas == 1 || $kepala_dinas == "1") ? $kepala_dinas_pilihan : NULL,
                    'tembusan_camat' => ($camat == 1 || $camat == "1") ? $camat_pilihan : NULL,
                    'tembusan_kampung' => ($kampung == 1 || $kampung == "1") ? $kampung_pilihan : NULL,
                    'created_at' => $date,
                ];
                $this->_db->table('_pengaduan_tanggapan')->insert($dataTindakLanjut);
                if ($this->_db->affectedRows() > 0) {
                    $riwayatLib = new Riwayatpengaduanlib();
                    try {
                        $riwayatLib->create($user->data->id, "Menanggapi pengaduan: " . $oldData['kode_aduan'] . ", dengan jawaban $jawaban, dan dengan saran tindaklanjut $saran_tindaklanjut", "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $oldData['id'], $oldData['id']);
                    } catch (\Throwable $th) {
                    }
                    $this->_db->transCommit();
                    try {
                        $m = new Merger();
                        $dataFileGambar = file_get_contents(FCPATH . './assets/favicon/android-icon-192x192.png');
                        $base64 = "data:image/png;base64," . base64_encode($dataFileGambar);

                        $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData->kode_aduan . '&choe=UTF-8'));

                        $jabatan_ks = $ks->jabatan_ks_plt ? ($ks->jabatan_ks_plt == 0 ? "Kepala Sekolah" : "Plt. Kepala Sekolah") : "Kepala Sekolah";

                        $html   =  '<html>
                        <head>
                            <link href="';
                        $html   .=              base_url('uploads/bootstrap.css');
                        $html   .=          '" rel="stylesheet">
                        </head>
                        <body>
                            <div class="container">
                                <div class="row">
                                    <table class="table table-responsive" style="border: none;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img class="image-responsive" width="110px" height="110px" src="';
                        $html   .=                                      $base64;
                        $html   .=                                  '"/>
                                                </td>
                                                <td>
                                                    &nbsp;&nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500;">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500;">DINAS SOSIAL</h3>
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500;">KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h4 style="margin: 0rem;font-size: 12px;font-weight: 400;">Jl. Hi. Muchtar Gunung Sugih 34161 Telp. (0725) 529786 Fax. 529787</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div style="text-align: center;margin-top: 30px; border:1px solid black;">
                                        <h3 style="margin: 0rem;font-size: 14px;">NOTA DINAS</h3>
                                    </div>
                                </div>
                                <div class="row" style="margin-left: 30px;margin-right:30px;">
                                    <div style="text-align: justify;margin-top: 30px;">
                                        <p style="margin-bottom: 15px; margin-top: 0px; font-size: 12px; padding-top: 0px; padding-bottom: 0px;">
                                            <table style="border: none;font-size: 12px; margin-bottom: 0px; margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Kepada Yth.
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;Kepala Dinas Sosial Kabupaten Lampung Tengah</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Dari
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;';
                        $html   .=                                          $user->data->fullname;
                        // $html   .=                                          getNamaPengguna($user->data->id);
                        $html   .=                                      '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Jabatan
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;';
                        $html   .=                                          $user->data->fullname;
                        $html   .=                                      '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Tanggal
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;';
                        $html   .=                                          tgl_indo($oldData->created_at);
                        $html   .=                                      '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Lampiran
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;';
                        $html   .=                                          '-';
                        $html   .=                                      '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Tembusan
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>';
                        $html   .=                      '<td>&nbsp;';
                        if ($dataTindakLanjut['tembusan_dinas'] !== NULL) {
                            $html   .= '1. Kepala Dinas ' . getNamaDinas($dataTindakLanjut['tembusan_dinas']) . '<br/>';
                            if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                                $html   .= '&nbsp;2. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                    $html   .= '&nbsp;3. Kepala Kampung/Lulrah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                    $html .= '&nbsp;4. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                } else {
                                    $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                }
                            } else {
                                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                    $html   .= '&nbsp;2. Kepala Kampung/Lulrah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                } else {
                                    $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                }
                            }
                        } else {
                            if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                                $html   .= '&nbsp;2. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                    $html   .= '&nbsp;3. Kepala Kampung/Lulrah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                    $html .= '&nbsp;4. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                } else {
                                    $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                }
                            } else {
                                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                    $html   .= '&nbsp;2. Kepala Kampung/Lulrah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                } else {
                                    $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                                }
                            }
                        }
                        $html   .=                                          '-';
                        $html   .=                                      '</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Perihal
                                                        </td>
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>&nbsp;';
                        $html   .=                                          'Laporan Tindak Lanjut Penanganan Aduan';
                        $html   .=                                      '</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </p>
                                        <p style="margin-top: 20px;font-size: 12px;">
                                            <ol style="font-size: 14px;">
                                                <li style="font-size: 14px;"><b>TANGGAL ADUAN</b><br/><span>Hari Tanggal Bulan Tahun</span></li>
                                                <li style="font-size: 14px;"><b>MEDIA PENGADUAN</b><br/><span>' . $dataTindakLanjut['media_pengaduan'] . '</span></li>
                                                <li style="font-size: 14px;"><b>IDENTITAS PEMOHON</b><br/>
                                                    <ol style="font-size: 12px;">
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Nama</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nama'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>NIK</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nik'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>No HP</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nohp'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Alamat</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['alamat'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kampung</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . getNamaKelurahan($oldData['kelurahan']) . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kecamatan</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . getNamaKecamatan($oldData['kecamatan']) . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li style="font-size: 14px;"><b>IDENTITAS SUBJEK ADUAN</b><br/>
                                                    <ol style="font-size: 12px;">
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Nama</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nama_aduan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>NIK</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nik_aduan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>No HP</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['nohp_aduan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Alamat</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . $oldData['alamat_aduan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kampung</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . getNamaKelurahan($oldData['kelurahan_aduan']) . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kecamatan</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>&nbsp;' . getNamaKecamatan($oldData['kecamatan_aduan']) . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li style="font-size: 14px;"><b>KATEGORI ADUAN</b><br/><span>' . $dataTindakLanjut['kategori'] . '</span></li>
                                                <li style="font-size: 14px;"><b>HASIL ANALISA</b><br/>
                                                    <ol style="font-size: 12px;">
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Uraian Permasalahan</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>' . $dataTindakLanjut['uraian_permasalahan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Pokok Permasalahan</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>' . $dataTindakLanjut['pokok_permasalahan'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kepersertaan Basos</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>
                                                                        1. DTKS (' . $dataTindakLanjut['dtks'] . ')<br/>
                                                                        2. PKH (' . $dataTindakLanjut['pkh'] . ')<br/>
                                                                        3. BPNT (' . $dataTindakLanjut['bpnt'] . ')<br/>
                                                                        4. Rumah Sederhana Terpadu - RST (' . $dataTindakLanjut['rst'] . ')<br/>';
                        if ($dataTindakLanjut['bansos_lain'] == NULL || $dataTindakLanjut['bansos_lain'] == "") {
                        } else {
                            $html .= '5. ' . $dataTindakLanjut['bansos_lain'] . ' (' . $dataTindakLanjut['bansos_lain_pilihan'] . ')';
                        }
                        $html   .=                                  '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Kepersertaan Jaminan Kesehatan Nasional (JKN)</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>';
                        if ($dataTindakLanjut['kepersertaan_jkn'] == NULL || $dataTindakLanjut['kepersertaan_jkn'] == "") {
                        } else {
                            $html .= '' . $dataTindakLanjut['kepersertaan_jkn'] . ' Dengan Status (' . $dataTindakLanjut['kepersertaan_jkn_pilihan'] . ')';
                        }
                        $html   .=                                  '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Jawaban</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>' . $dataTindakLanjut['jawaban'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                        <li style="font-size: 14px;">
                                                            <table border="0">
                                                                <tr>
                                                                    <td>Saran Tindak Lanjut</td>
                                                                    <td>&nbsp;:</td>
                                                                    <td>' . $dataTindakLanjut['saran_tindaklanjut'] . '</td>
                                                                </tr>
                                                            </table>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </p>
                                    </div>
                                </div>
                                <div class="row" style="margin-left: 30px;margin-right:30px;">
                                    <div>
                                        <table style="width: 100%;max-width: 100%;" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 60%"><center><img class="image-responsive" width="110px" height="110px" src="' . $qrCode . '"/></center></td>
                                                    <td style="width: 40%">
                                                        <br>
                                                        <br>
                                                        <span style="font-size: 12px;">Gunung Sugih, ';
                        $html   .=                                          tgl_indo(date('Y-m-d'));
                        $html   .=                                      '</span><br>
                                                        <span style="font-size: 12px;">PETUGAS</span><br><br><br><span style="font-size: 10px; color: #1c1c1cb8;">Materai 10.000</span><br><br>
                                                        <span style="font-size: 12px;"><b><u>';
                        $html   .=                                          $user->data->fullname;
                        $html   .=                                      '</u></b></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </body>
                    </html>';

                        $dompdf = new DOMPDF();
                        $dompdf->setPaper('F4', 'potrait');
                        $dompdf->loadHtml($html);
                        $dompdf->render();
                        $m->addRaw($dompdf->output());
                        // unset($dompdf);

                        // $dompdf1 = new DOMPDF();
                        // // $dompdf = new Dompdf();
                        // $dompdf1->set_paper('F4', 'landscape');
                        // $dompdf1->load_html($lHtml);
                        // $dompdf1->render();
                        // $m->addRaw($dompdf1->output());

                        $dir = FCPATH . "upload/pengaduan/pdf";
                        $fileNya = $dir . '/' . $oldData->kode_aduan . '.pdf';

                        file_put_contents($fileNya, $m->merge());

                        sleep(3);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->redirrect = base_url('silastri/adm/pengaduan/antrian');
                    $response->message = "Tanggapan Aduan " . $oldData['kode_aduan'] . " berhasil disimpan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                return json_encode($response);
            }
        }
    }
}
