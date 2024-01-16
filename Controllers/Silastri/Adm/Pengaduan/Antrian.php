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
use App\Libraries\Silastri\Notificationlib;
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

        $bidangs = getBidangNaungan($user->data->id);

        $lists = $datamodel->get_datatables($bidangs);
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
            "recordsTotal" => $datamodel->count_all($bidangs),
            "recordsFiltered" => $datamodel->count_filtered($bidangs),
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

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }

            $current = $this->_db->table('_pengaduan a')
                ->select("a.*")
                // ->join('_profil_users_tb b', 'b.id = a.user_id')
                ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                ->where(['a.id' => $id, 'a.status_aduan' => 1])->get()->getRowObject();

            if ($current) {
                $granted = grantedBidangNaungan($user->data->id, $current->diteruskan_ke);
                if ($granted) {
                    $data['data'] = $current;
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('silastri/adm/pengaduan/antrian/detail', $data);
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Akses tidak dizinkan.";
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

            $granted = grantedBidangNaungan($user->data->id, $oldData->diteruskan_ke);
            if (!$granted) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akses tidak diizinkan.";
                return json_encode($response);
            }

            $data['id'] = $id;
            $data['nama'] = $nama;
            $data['data'] = $oldData;
            $data['dinass'] = $this->_db->table('ref_instansi')->orderBy('id', 'ASC')->get()->getResult();
            $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
            $data['kelurahans'] = $this->_db->table('ref_kelurahan')->orderBy('kelurahan', 'ASC')->get()->getResult();

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";

            switch ($oldData->kategori) {
                case 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)':
                    $data['sdm'] = $this->_db->table('ref_sdm')->orderBy('jenis', 'ASC')->orderBy('nama', 'ASC')->get()->getResult();
                    $response->data = view('silastri/adm/pengaduan/antrian/form-tanggapan-ppks', $data);
                    break;

                default:
                    $response->data = view('silastri/adm/pengaduan/antrian/form-tanggapan', $data);
                    break;
            }
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
            $response->data = view('silastri/adm/pengaduan/antrian/tolak', $data);
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

            $oldData = $this->_db->table('_pengaduan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Permohonan tidak ditemukan.";
                return json_encode($response);
            }

            $granted = grantedBidangNaungan($user->data->id, $oldData['diteruskan_ke']);
            if (!$granted) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akses tidak diizinkan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_reject'] = $date;
            $oldData['admin_reject'] = $user->data->id;
            $oldData['keterangan_reject'] = $keterangan;
            $oldData['status_aduan'] = 3;

            $this->_db->transBegin();
            $this->_db->table('_pengaduan_tolak')->insert($oldData);
            if ($this->_db->affectedRows() > 0) {
                $this->_db->table('_pengaduan')->where('id', $oldData['id'])->delete();
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

    public function tanggapispt()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            '_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            '_nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            // 'media_pengaduan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Media pengaduan tidak boleh kosong. ',
            //     ]
            // ],
            '_tgl_spt' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal SPT tidak boleh kosong. ',
                ]
            ],
            '_lokasi_tujuan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Lokasi tujuan SPT ke tidak boleh kosong. ',
                ]
            ],
            'nama_spt.*' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Peserta SPT tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Silahkan lengkapi isian wajib.";
            // $this->validator->getError('_id')
            //     . $this->validator->getError('_nama')
            //     // . $this->validator->getError('media_pengaduan')
            //     . $this->validator->getError('_uraian_permasalahan')
            //     . $this->validator->getError('_pokok_permasalahan')
            //     // . $this->validator->getError('_nama_pemilik_bansos.*')
            //     // . $this->validator->getError('_nik_pemilik_bansos.*')
            //     // . $this->validator->getError('keterangan_pemilik_bansos.*')
            //     . $this->validator->getError('_jawaban')
            //     . $this->validator->getError('_saran_tindaklanjut');
            return json_encode($response);
        } else {
            $namesSpt = $this->request->getVar('nama_spt');

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

            $id = htmlspecialchars($this->request->getVar('_id'), true);

            $oldData = $this->_db->table('_pengaduan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengaduan tidak ditemukan.";
                return json_encode($response);
            }

            $granted = grantedBidangNaungan($user->data->id, $oldData['diteruskan_ke']);
            if (!$granted) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akses tidak diizinkan.";
                return json_encode($response);
            }

            // $nama = htmlspecialchars($this->request->getVar('_nama'), true);
            $tgl_spt = htmlspecialchars($this->request->getVar('_tgl_spt'), true);
            $lokasi_tujuan = htmlspecialchars($this->request->getVar('_lokasi_tujuan'), true);

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
                    'user_id' => $user->data->id,
                    'kode_aduan' => $oldData['kode_aduan'],
                    'tgl_spt' => $tgl_spt,
                    'lokasi_spt' => $lokasi_tujuan,
                    'peserta_spt' => json_encode($namesSpt),
                    'created_at' => $date,
                ];

                $this->_db->table('_pengaduan_tanggapan_spt')->insert($dataTindakLanjut);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->table('_data_assesment')->insert([
                        'id' => $oldData['id'],
                        'jenis' => "PENGADUAN PPKS",
                        'created_at' => $date,
                        'status' => 0,
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $riwayatLib = new Riwayatpengaduanlib();
                        try {
                            $riwayatLib->create($user->data->id, "Meneruskan pengaduan: " . $oldData['kode_aduan'] . ", dengan penerusan assesmen dengan SPT ke $lokasi_tujuan", "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $oldData['id'], $oldData['id']);
                        } catch (\Throwable $th) {
                        }
                        // $this->_db->transCommit();
                        // try {
                        $m = new Merger();
                        $dataFileGambar = file_get_contents(FCPATH . './uploads/logo-lamteng.png');;
                        $base64 = "data:image/png;base64," . base64_encode($dataFileGambar);
                        $dataFileBsre = file_get_contents(FCPATH . './assets/bsre.png');;
                        $base64bsre = "data:image/png;base64," . base64_encode($dataFileBsre);

                        $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_aduan']));
                        // $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_aduan'] . '&choe=UTF-8'));

                        $userIdSpts = [];
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
                                            <tr style="justify-content: center; text-align: center;">
                                                <td width="13%">
                                                    <img class="image-responsive" width="100px" height="100px" src="';
                        $html   .=                                      $base64;
                        $html   .=                                  '"/>
                                                </td>
                                                <td width="2%">
                                                    &nbsp;&nbsp;&nbsp;
                                                </td>
                                                <td width="85%" style="justify-content: center; text-align: center;">
                                                    <h3 style="margin: 0rem;font-size: 18px; font-weight: 500; text-align: center; justify-content: center;">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h3 style="margin: 0rem;font-size: 20px; font-weight: 500; text-align: center;">DINAS SOSIAL</h3>
                                                    <h3 style="margin: 0rem;font-size: 18px; font-weight: 500; text-align: center;">KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h4 style="margin: 0rem;font-size: 12px;font-weight: 400;" text-align: center;>Jl. Hi. Muchtar Gunung Sugih 34161 Telp. (0725) 529786 Fax. 529787</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div style="text-align: center;margin-top: 30px;">
                                        <h3 style="margin: 0rem;font-size: 14px;"><u>SURAT PERINTAH TUGAS</u></h3>
                                        <p style="margin: 0rem;padding:0rem;">Nomor: 094/        /D.a.VI.07.e/' . date('Y') . '</p>
                                    </div>
                                </div>
                                <div class="row" style="margin-left: 30px;margin-right:30px;">
                                    <div style="text-align: justify;margin-top: 10px;">
                                        <p style="margin-bottom: 5px; margin-top: 0px; font-size: 12px; padding-top: 0px; padding-bottom: 0px;">
                                            <table style="border: none;font-size: 12px; margin-bottom: 0px; margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            Dasar
                                                        </td>
                                                        <td style="font-size: 12px;vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="font-size: 12px;vertical-align: top;">Peraturan Menteri Sosial Republik Indonesia No. 09 Tahun 2018tentang Standar Teknis Pelayanan Dasar pada Standar Pelayanan Minimal Bidang Sosial di Daerah Provinsi dan di Daerah Kabupaten/Kota</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </p>
                                        <p style="margin-top: 5px;font-size: 12px;vertical-align: top; text-align: center; margin-bottom: 0px;"><b>M E M E R I N T A H K A N</b></p>
                                        <p style="margin-bottom: 15px; margin-top: 0px; font-size: 12px; padding-top: 0px; padding-bottom: 0px;">
                                            <table style="border: none;font-size: 12px; margin-bottom: 0px; margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            Kepada
                                                        </td>
                                                        <td style="font-size: 12px;vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            &nbsp;
                                                        </td>
                                                        <td style="font-size: 12px;vertical-align: top;">&nbsp;</td>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            <table border="0">';
                        foreach ($namesSpt as $key => $value) {
                            $pesertaDetail = getNamaSdmFromNik($value);
                            $userIdSpts[] = getIdPenggunaFromNik($value);
                            $html .=                                '<tr style="vertical-align: top;margin-bottom: 15px;">
                                                                    <td>' . $key + 1 . '</td>
                                                                    <td>Nama</td>
                                                                    <td>&nbsp;:&nbsp;</td>
                                                                    <td>' . ($pesertaDetail ? ucwords($pesertaDetail->nama) : '-') . '</td>
                                                                </tr>
                                                                <tr style="vertical-align: top;margin-bottom: 15px;">
                                                                    <td>&nbsp;</td>
                                                                    <td>Pangkat / Golongan</td>
                                                                    <td>&nbsp;:&nbsp;</td>
                                                                    <td>' . ($pesertaDetail ? ($pesertaDetail->pangkat_golongan == NULL || $pesertaDetail->pangkat_golongan == "" ? '-' : $pesertaDetail->pangkat_golongan) : '-') . '</td>
                                                                </tr>
                                                                <tr style="vertical-align: top;margin-bottom: 15px;">
                                                                    <td>&nbsp;</td>
                                                                    <td>NIP/No Id TKSK/KP</td>
                                                                    <td>&nbsp;:&nbsp;</td>
                                                                    <td>' . ($pesertaDetail ? $pesertaDetail->nip : '-') . '</td>
                                                                </tr>
                                                                <tr style="vertical-align: top;margin-bottom: 15px;">
                                                                    <td>&nbsp;</td>
                                                                    <td>Jabatan</td>
                                                                    <td>&nbsp;:&nbsp;</td>
                                                                    <td>' . ($pesertaDetail ? $pesertaDetail->jabatan : '-') . '</td>
                                                                </tr>
                                                                ';
                        }
                        $html .=                                '</table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </p>
                                        <p style="margin-bottom: 15px; margin-top: 0px; font-size: 12px; padding-top: 0px; padding-bottom: 0px;">
                                            <table style="border: none;font-size: 12px; margin-bottom: 0px; margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            Untuk
                                                        </td>
                                                        <td style="font-size: 12px;vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                        Melaksanakan asesmen kepada pemerlu pelayanan kesejahteraan sosial pada hari <b>' . hari(strtotime($tgl_spt)) . '</b> tanggal <b>' . tgl_indo($tgl_spt) . '</b> di <b>' . ucwords($lokasi_tujuan) . '</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 12px;vertical-align: top;">
                                                            Catatan
                                                        </td style="font-size: 12px;vertical-align: top;">
                                                        <td>&nbsp;: &nbsp;</td>
                                                        <td>
                                                        &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="font-size: 12px;vertical-align: top;">
                                                        <ol style="font-size: 12px;vertical-align: top;">
                                                            <li style="font-size: 12px;vertical-align: top;margin-bottom: 5px;">
                                                                Surat Perintah ini diberikan kepada yang bersangkutan untuk dilaksanakan dengan penuh rasa tanggung jawab.
                                                            </li>
                                                            <li style="font-size: 12px;vertical-align: top;margin-bottom: 5px;">
                                                                Melaporkan hasil pelaksanaan tugas kepada Kepala Dinas Sosial Kabupaten Lampung Tengah.
                                                            </li>
                                                            <li style="font-size: 12px;vertical-align: top;margin-bottom: 5px;">
                                                                Surat Perintah ini berlaku sejak tanggal dikeluarkan dan apabila dikemudian hari terdapat kekeliruan akan diperbaiki sebagaimana mestinya.
                                                            </li>
                                                        </ol>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </p>
                                        <p style="margin-top: 20px;font-size: 12px;vertical-align: top;">
                                            Demikianlah Surat Tugas ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.
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
                                                        <span style="font-size: 12px;">&nbsp;dikeluarkan di  :  Gunung Sugih</span><br>
                                                        <span style="font-size: 12px;">&nbsp;Pada Tanggal    &nbsp;:  ';
                        $html   .=                                          tgl_indo(date('Y-m-d'));
                        $html   .=                                      '</span><br>
                                                        <table border="0" style="padding: 0px; background-color: #fff;">
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;">Ditandatangani secara elektronik oleh : &nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;">Kepala Dinas Sosial</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;">Kabupaten Lampung Tengah</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-top: 5px; padding-bottom: 5px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;">
                                                                    <img src="' . $base64bsre . '" alt="" height="65px">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;"><b><u>ARI NUGRAHA MUKTI, S.STP.,M.M</u></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: 0; padding-left: 0px; padding-right: 8px; margin: 0px;font-size: 12px;vertical-align: top;">NIP. 19860720 200501 1 004</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </body>
                    </html>';

                        try {
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

                            $dir = FCPATH . "upload/spt/pdf";
                            $fileNya = $dir . '/' . $oldData['kode_aduan'] . '.pdf';

                            file_put_contents($fileNya, $m->merge());

                            sleep(3);
                            // } catch (\Throwable $th) {
                            //     //throw $th;
                            // }
                            // header('Content-Type: application/pdf');
                            // header('Content-Disposition: attachment; filename="' . basename($fileNya) . '"');
                            // header('Content-Length: ' . filesize($fileNya));
                            // readfile($fileNya);
                            if (count($userIdSpts) > 0) {
                                foreach ($userIdSpts as $i) {
                                    if ($i == "-") {
                                        continue;
                                    }
                                    try {
                                        $notifLib = new NotificationLib();
                                        $notifLib->create("Tugas SPT Assesment", "Anda mendapat SPT untuk mengaksesmen dengan kode " . $oldData['kode_aduan'] . ".", "success", $user->data->id, $i, base_url('silastri/peksos/assesment/antrian'));
                                    } catch (\Throwable $th) {
                                        //throw $th;
                                    }
                                }
                            }

                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->redirrect = base_url('silastri/adm/pengaduan/antrian');
                            $response->filenya = base_url('upload/spt/pdf') . '/' . $oldData['kode_aduan'] . '.pdf';
                            $response->filename = $fileNya;
                            $response->message = "Tanggapan Aduan " . $oldData['kode_aduan'] . " berhasil disimpan.";
                            return json_encode($response);
                        } catch (\Throwable $th) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->error = var_dump($th);
                            $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->error = "Gagal Insert Assesment";
                        $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                        return json_encode($response);
                    }
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = "Gagal Insert SPT";
                    $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = "gagal pengaduan";
                $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
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
            '_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            '_nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            // 'media_pengaduan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Media pengaduan tidak boleh kosong. ',
            //     ]
            // ],
            '_uraian_permasalahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Uraian Permasalahan tidak boleh kosong. ',
                ]
            ],
            '_pokok_permasalahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pokok permasalahan ke tidak boleh kosong. ',
                ]
            ],
            'nik_pemilik_bansos.*' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIK pemilik bansos tidak boleh kosong. ',
                ]
            ],
            'nama_pemilik_bansos.*' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pemilik bansos tidak boleh kosong. ',
                ]
            ],
            'keterangan_pemilik_bansos.*' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan pemilik bansos tidak boleh kosong. ',
                ]
            ],

            '_jawaban' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jawaban ke tidak boleh kosong. ',
                ]
            ],
            '_saran_tindaklanjut' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Saran tindaklanjut ke tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Silahkan lengkapi isian wajib.";
            // $this->validator->getError('_id')
            //     . $this->validator->getError('_nama')
            //     // . $this->validator->getError('media_pengaduan')
            //     . $this->validator->getError('_uraian_permasalahan')
            //     . $this->validator->getError('_pokok_permasalahan')
            //     // . $this->validator->getError('_nama_pemilik_bansos.*')
            //     // . $this->validator->getError('_nik_pemilik_bansos.*')
            //     // . $this->validator->getError('keterangan_pemilik_bansos.*')
            //     . $this->validator->getError('_jawaban')
            //     . $this->validator->getError('_saran_tindaklanjut');
            return json_encode($response);
        } else {
            $namesPemilikBansos = $this->request->getVar('nama_pemilik_bansos');
            $nik_pemilik_bansos = $this->request->getVar('nik_pemilik_bansos');
            $keterangan_pemilik_bansos = $this->request->getVar('keterangan_pemilik_bansos');

            foreach ($namesPemilikBansos as $i => $idN) {
                $name = $namesPemilikBansos[$i];
                $rulesBansos = [
                    '_dtks_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan DTKS untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                    '_pkh_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan PKH untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                    '_bpnt_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan BPNT untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                    '_pbi_jk_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan PBI JK untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                    '_rst_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan RST untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                    '_bansos_lain_bansos_' . $i => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pilihan Bansos Lain untuk penerima bansos tidak boleh kosong. ',
                        ]
                    ],
                ];

                if (!$this->validate($rulesBansos)) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Siilahkan pilih pilihan penerima bantuan.";
                    return json_encode($response);
                }
            }

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

            $id = htmlspecialchars($this->request->getVar('_id'), true);

            $oldData = $this->_db->table('_pengaduan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Pengaduan tidak ditemukan.";
                return json_encode($response);
            }

            $granted = grantedBidangNaungan($user->data->id, $oldData['diteruskan_ke']);
            if (!$granted) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akses tidak diizinkan.";
                return json_encode($response);
            }

            $nama = htmlspecialchars($this->request->getVar('_nama'), true);
            $uraian_permasalahan = htmlspecialchars($this->request->getVar('_uraian_permasalahan'), true);
            $pokok_permasalahan = htmlspecialchars($this->request->getVar('_pokok_permasalahan'), true);
            $jawaban = htmlspecialchars($this->request->getVar('_jawaban'), true);
            $saran_tindaklanjut = htmlspecialchars($this->request->getVar('_saran_tindaklanjut'), true);

            $kepala_dinas = $this->request->getVar('_kepala_dinas') ? htmlspecialchars($this->request->getVar('_kepala_dinas'), true) : NULL;
            $kepala_dinas_pilihan = $this->request->getVar('_kepala_dinas_pilihan') ? htmlspecialchars($this->request->getVar('_kepala_dinas_pilihan'), true) : NULL;
            $camat = $this->request->getVar('_camat') ? htmlspecialchars($this->request->getVar('_camat'), true) : NULL;
            $camat_pilihan = $this->request->getVar('_camat_pilihan') ? htmlspecialchars($this->request->getVar('_camat_pilihan'), true) : NULL;
            $kampung = $this->request->getVar('_kampung') ? htmlspecialchars($this->request->getVar('_kampung'), true) : NULL;
            $kampung_pilihan = $this->request->getVar('_kampung_pilihan') ? htmlspecialchars($this->request->getVar('_kampung_pilihan'), true) : NULL;
            $jumlah_lampiran = $this->request->getVar('_jumlah_lampiran') ? htmlspecialchars($this->request->getVar('_jumlah_lampiran'), true) : '0';

            $kepersertaan_bansos = [];
            foreach ($namesPemilikBansos as $i => $idN) {
                $dtks = htmlspecialchars($this->request->getVar('_dtks_bansos_' . $i), true);
                $pkh = htmlspecialchars($this->request->getVar('_pkh_bansos_' . $i), true);
                $bpnt = htmlspecialchars($this->request->getVar('_bpnt_bansos_' . $i), true);
                $pbi_jk = htmlspecialchars($this->request->getVar('_pbi_jk_bansos_' . $i), true);
                $rst = htmlspecialchars($this->request->getVar('_rst_bansos_' . $i), true);
                $bansos_lain = htmlspecialchars($this->request->getVar('_bansos_lain_bansos_' . $i), true);
                $anggotaPeserta = [
                    'nama_anggota' => $namesPemilikBansos[$i],
                    'nik_anggota' => $nik_pemilik_bansos[$i],
                    'nik_anggota' => $nik_pemilik_bansos[$i],
                    'keterangan_anggota' => $keterangan_pemilik_bansos[$i],
                    'dtks' => $dtks,
                    'pkh' => $pkh,
                    'bpnt' => $bpnt,
                    'pbi_jk' => $pbi_jk,
                    'rst' => $rst,
                    'bansos_lain' => $bansos_lain,
                ];

                $kepersertaan_bansos[] = $anggotaPeserta;
            }

            $date = date('Y-m-d H:i:s');
            $upData = [];
            $upData['updated_at'] = $date;
            $upData['date_approve'] = $date;
            $upData['admin_approve'] = $user->data->id;
            $upData['status_aduan'] = 5;

            $this->_db->transBegin();
            $this->_db->table('_pengaduan')->where('id', $oldData['id'])->update($upData);
            if ($this->_db->affectedRows() > 0) {
                $dataTindakLanjut = [
                    'id' => $oldData['id'],
                    'user_id' => $user->data->id,
                    'kode_aduan' => $oldData['kode_aduan'],
                    'media_pengaduan' => $oldData['media_pengaduan'],
                    'uraian_permasalahan' => $uraian_permasalahan,
                    'pokok_permasalahan' => $pokok_permasalahan,
                    'kepersertaan_bansos' => json_encode($kepersertaan_bansos),
                    'jawaban' => $jawaban,
                    'saran_tindaklanjut' => $saran_tindaklanjut,
                    'tembusan_dinas' => ($kepala_dinas == 1 || $kepala_dinas == "1" || $kepala_dinas == "on") ? $kepala_dinas_pilihan : NULL,
                    'tembusan_camat' => ($camat == 1 || $camat == "1" || $camat == "on") ? $camat_pilihan : NULL,
                    'tembusan_kampung' => ($kampung == 1 || $kampung == "1" || $kampung == "on") ? $kampung_pilihan : NULL,
                    'jumlah_lampiran' => ($jumlah_lampiran == 0 || $jumlah_lampiran == "0" || $jumlah_lampiran == "-") ? $jumlah_lampiran : 0,
                    'created_at' => $date,
                ];

                $this->_db->table('_pengaduan_tanggapan')->insert($dataTindakLanjut);
                if ($this->_db->affectedRows() > 0) {
                    $riwayatLib = new Riwayatpengaduanlib();
                    try {
                        $riwayatLib->create($user->data->id, "Menanggapi pengaduan: " . $oldData['kode_aduan'] . ", dengan jawaban $jawaban, dan dengan saran tindaklanjut $saran_tindaklanjut", "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $oldData['id'], $oldData['id']);
                    } catch (\Throwable $th) {
                    }
                    // $this->_db->transCommit();
                    // try {
                    $m = new Merger();
                    $dataFileGambar = file_get_contents(FCPATH . './uploads/logo-lamteng.png');;
                    $base64 = "data:image/png;base64," . base64_encode($dataFileGambar);

                    $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_aduan'] . '&choe=UTF-8'));

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
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">DINAS SOSIAL</h3>
                                                    <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">KABUPATEN LAMPUNG TENGAH</h3>
                                                    <h4 style="margin: 0rem;font-size: 12px;font-weight: 400;" text-align: center;>Jl. Hi. Muchtar Gunung Sugih 34161 Telp. (0725) 529786 Fax. 529787</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div style="text-align: center;margin-top: 30px;">
                                        <h3 style="margin: 0rem;font-size: 14px;"><u>NOTA DINAS</u></h3>
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
                                                    <tr style="vertical-align: top;">
                                                        <td style="vertical-align: top;">
                                                            Dari
                                                        </td>
                                                        <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="vertical-align: top;">&nbsp;';
                    $html   .=                                          $user->data->fullname;
                    // $html   .=                                          getNamaPengguna($user->data->id);
                    $html   .=                                      '</td>
                                                    </tr>
                                                    <tr style="vertical-align: top;">
                                                        <td style="vertical-align: top;">
                                                            Jabatan
                                                        </td>
                                                        <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="vertical-align: top;">&nbsp;';
                    $html   .=                                          $user->data->fullname;
                    $html   .=                                      '</td>
                                                    </tr>
                                                    <tr style="vertical-align: top;">
                                                        <td style="vertical-align: top;">
                                                            Tanggal
                                                        </td>
                                                        <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="vertical-align: top;">&nbsp;';
                    $html   .=                                          tgl_indo($oldData['created_at']);
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
                                                    <tr style="vertical-align: top;">
                                                        <td style="vertical-align: top;">
                                                            Tembusan
                                                        </td>
                                                        <td style="vertical-align: top;">&nbsp;: &nbsp;</td>';
                    $html   .=                      '<td style="vertical-align: top;">&nbsp;';
                    if ($dataTindakLanjut['tembusan_dinas'] !== NULL) {
                        $html   .= '1. Kepala Dinas ' . getNamaDinas($dataTindakLanjut['tembusan_dinas']) . '<br/>';
                        if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                            $html   .= '&nbsp;2. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                            if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                $html   .= '&nbsp;3. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                $html .= '&nbsp;4. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            } else {
                                $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            }
                        } else {
                            if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                $html   .= '&nbsp;2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                            } else {
                                $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            }
                        }
                    } else {
                        if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                            $html   .= '&nbsp;1. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                            if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                $html   .= '&nbsp;2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            } else {
                                $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            }
                        } else {
                            if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                                $html   .= '&nbsp;1. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                                $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            } else {
                                $html .= '&nbsp;1. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                            }
                        }
                    }
                    $html   .=                                      '</td>
                                                    </tr>
                                                    <tr style="vertical-align: top;">
                                                        <td style="vertical-align: top;">
                                                            Perihal
                                                        </td>
                                                        <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
                                                        <td style="vertical-align: top;">&nbsp;';
                    $html   .=                                          'Laporan Tindak Lanjut Penanganan Aduan';
                    $html   .=                                      '</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </p>
                                        <p style="margin-top: 20px;font-size: 12px;vertical-align: top;">
                                            <ol style="font-size: 12px;vertical-align: top;">
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>TANGGAL ADUAN</b><br/><span>' . tgl_hari_indo($date) . '</span></li>
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>MEDIA PENGADUAN</b><br/><span>' . $dataTindakLanjut['media_pengaduan'] . '</span></li>
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>IDENTITAS PEMOHON</b><br/>
                                                    <table border="0">
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">a. &nbsp;</td>
                                                            <td style="vertical-align: top;">Nama</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . ucwords($oldData['nama']) . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">b. &nbsp;</td>
                                                            <td style="vertical-align: top;">NIK</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['nik'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">c. &nbsp;</td>
                                                            <td style="vertical-align: top;">No HP</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['nohp'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">d. &nbsp;</td>
                                                            <td style="vertical-align: top;">Alamat</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['alamat'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">e. &nbsp;</td>
                                                            <td style="vertical-align: top;">Kampung</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . getNamaKelurahan($oldData['kelurahan']) . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">f. &nbsp;</td>
                                                            <td style="vertical-align: top;">Kecamatan</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . getNamaKecamatan($oldData['kecamatan']) . '</td>
                                                        </tr>
                                                    </table>
                                                </li>
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>IDENTITAS SUBJEK ADUAN</b><br/>
                                                    <table border="0">
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">a. &nbsp;</td>
                                                            <td style="vertical-align: top;">Nama</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . ucwords($oldData['nama_aduan']) . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">b. &nbsp;</td>
                                                            <td style="vertical-align: top;">NIK</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['nik_aduan'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">c. &nbsp;</td>
                                                            <td style="vertical-align: top;">No HP</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['nohp_aduan'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">d. &nbsp;</td>
                                                            <td style="vertical-align: top;">Alamat</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . $oldData['alamat_aduan'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">e. &nbsp;</td>
                                                            <td style="vertical-align: top;">Kampung</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . getNamaKelurahan($oldData['kelurahan_aduan']) . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="vertical-align: top;">f. &nbsp;</td>
                                                            <td style="vertical-align: top;">Kecamatan</td>
                                                            <td style="vertical-align: top;">&nbsp;:</td>
                                                            <td style="vertical-align: top;">&nbsp;' . getNamaKecamatan($oldData['kecamatan_aduan']) . '</td>
                                                        </tr>
                                                    </table>
                                                </li>
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>KATEGORI ADUAN</b><br/><span>' . $oldData['kategori'] . '</span></li>
                                                <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>HASIL ANALISA</b><br/>
                                                    <table border="0">
                                                        <tr style="vertical-align: top;margin-bottom: 15px;">
                                                            <td style="vertical-align: top;">a. &nbsp;</td>
                                                            <td colspan="3" style="vertical-align: top;">Uraian Permasalahan :&nbsp;<br />' . $dataTindakLanjut['uraian_permasalahan'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;margin-bottom: 15px;">
                                                            <td style="vertical-align: top;">b. &nbsp;</td>
                                                            <td colspan="3" style="vertical-align: top;">Pokok Permasalahan :&nbsp;<br />' . $dataTindakLanjut['pokok_permasalahan'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;margin-bottom: 15px;">
                                                            <td style="vertical-align: top;">c. &nbsp;</td>
                                                            <td colspan="3" style="vertical-align: top;">Kepersertaan Basos<br/>
                                                                <table style="border: 1px solid #dcdfe4;">
                                                                    <thead>
                                                                        <tr style="vertical-align: top;border: 1px solid #dcdfe4;">
                                                                            <td style="vertical-align: top;">No</td>
                                                                            <td style="vertical-align: top;">Nama</td>
                                                                            <td style="vertical-align: top;">NIK</td>
                                                                            <td style="vertical-align: top;text-align: center;">DTKS</td>
                                                                            <td style="vertical-align: top;text-align: center;">PKH</td>
                                                                            <td style="vertical-align: top;text-align: center;">BPNT</td>
                                                                            <td style="vertical-align: top;text-align: center;">PBI JK</td>
                                                                            <td style="vertical-align: top;text-align: center;">RST</td>
                                                                            <td style="vertical-align: top;text-align: center;">Bansos Lainnya</td>
                                                                            <td style="vertical-align: top;">Keterangan</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>';
                    foreach ($kepersertaan_bansos as $key => $v) {
                        $html .= '<tr style="vertical-align: top;border: 1px solid #dcdfe4;">
                                                                                <td style="vertical-align: top;">' . $key + 1 . '</td>
                                                                                <td style="vertical-align: top;">' . ucwords($v['nama_anggota']) . '</td>
                                                                                <td style="vertical-align: top;">' . $v['nik_anggota'] . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['dtks']) . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['pkh']) . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['bpnt']) . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['pbi_jk']) . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['rst']) . '</td>
                                                                                <td style="vertical-align: top;text-align: center;">' . ucwords($v['bansos_lain']) . '</td>
                                                                                <td style="vertical-align: top;">' . $v['keterangan_anggota'] . '</td>
                                                                            </tr>';
                    }
                    $html .=                                                '</tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr style="vertical-align: top;margin-bottom: 15px;">
                                                            <td style="vertical-align: top;">d. &nbsp;</td>
                                                            <td colspan="3" style="vertical-align: top;">Kesimpulan : &nbsp;<br/>' . $dataTindakLanjut['jawaban'] . '</td>
                                                        </tr>
                                                        <tr style="vertical-align: top;margin-bottom: 15px;">
                                                            <td style="vertical-align: top;">e. &nbsp;</td>
                                                            <td colspan="3" style="vertical-align: top;">Saran Tindak Lanjut : &nbsp;<br/>' . $dataTindakLanjut['saran_tindaklanjut'] . '</td>
                                                        </tr>
                                                    </table>
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
                                                        <span style="font-size: 12px;">PETUGAS</span><br><br><br><br><br>
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

                    try {
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
                        $fileNya = $dir . '/' . $oldData['kode_aduan'] . '.pdf';

                        file_put_contents($fileNya, $m->merge());

                        sleep(3);
                        // } catch (\Throwable $th) {
                        //     //throw $th;
                        // }
                        // header('Content-Type: application/pdf');
                        // header('Content-Disposition: attachment; filename="' . basename($fileNya) . '"');
                        // header('Content-Length: ' . filesize($fileNya));
                        // readfile($fileNya);

                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->redirrect = base_url('silastri/adm/pengaduan/antrian');
                        $response->filenya = base_url('upload/pengaduan/pdf') . '/' . $oldData['kode_aduan'] . '.pdf';
                        $response->filename = $fileNya;
                        $response->message = "Tanggapan Aduan " . $oldData['kode_aduan'] . " berhasil disimpan.";
                        return json_encode($response);
                    } catch (\Throwable $th) {
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
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menanggapi aduan " . $oldData['kode_aduan'];
                return json_encode($response);
            }
        }
    }

    public function getSdm()
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

            $kels = $this->_db->table('ref_sdm')->where('nik', $id)->get()->getRowObject();

            if ($kels) {
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = $kels;
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }
}
