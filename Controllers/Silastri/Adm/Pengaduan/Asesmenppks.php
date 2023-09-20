<?php

namespace App\Controllers\Silastri\Adm\Pengaduan;

use App\Controllers\BaseController;
use App\Models\Silastri\Adm\Pengaduan\AsesmenppksModel;
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

class Asesmenppks extends BaseController
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
        $datamodel = new AsesmenppksModel($request);

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $bidangs = getBidangNaungan($user->data->id);

        $lists = $datamodel->get_datatables($user->data->nik);
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
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->nik_aduan . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama_aduan)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
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
            $row[] = $list->nik_aduan;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama_aduan));

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->nik),
            "recordsFiltered" => $datamodel->count_filtered($user->data->nik),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('silastri/adm/pengaduan/asesmenppks/data'));
    }

    public function data()
    {
        $data['title'] = 'Asesment Pengaduan Layanan PPKS';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        $data['jeniss'] = ['Pengaduan Program Bantuan Sosial', 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)', 'Pengaduan Layanan Sosial', 'Lainnya'];

        return view('silastri/adm/pengaduan/asesmenppks/index', $data);
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
                ->select("a.*,b.peserta_spt, b.tgl_spt, b.lokasi_spt")
                ->join('_pengaduan_tanggapan_spt b', 'b.id = a.id')
                ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                ->where(['a.id' => $id, 'a.status_aduan' => 2])->get()->getRowObject();

            if ($current) {
                $granted = grantedBidangNaungan($user->data->id, $current->diteruskan_ke);
                if ($granted) {
                    $data['data'] = $current;
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('silastri/adm/pengaduan/asesmenppks/detail', $data);
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

            $oldData = $this->_db->table('_pengaduan a')
                ->select("a.*,b.peserta_spt, b.tgl_spt, b.lokasi_spt")
                ->join('_pengaduan_tanggapan_spt b', 'b.id = a.id')
                ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                ->where(['a.id' => $id, 'a.status_aduan' => 2])->get()->getRowObject();

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
            $data['petugas'] = getPetugasFromNik($user->data->nik);
            $data['nama'] = $nama;
            $data['data'] = $oldData;
            $data['dinass'] = $this->_db->table('ref_instansi')->orderBy('id', 'ASC')->get()->getResult();
            $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
            $data['kelurahans'] = $this->_db->table('ref_kelurahan')->orderBy('kelurahan', 'ASC')->get()->getResult();
            $data['pekerjaans'] = $this->_db->table('_profil_users_tb')->select("pekerjaan, count(pekerjaan) as jumlah")->groupBy('pekerjaan')->orderBy('pekerjaan', 'ASC')->get()->getResult();
            // $data['anak_kategori_ppkss'] = ["Anak dalam situasi darurat", "Anak yang berhadapan dengan hukum", "Anak dari kelompok minoritas dan terisolasi", "Anak yang dieksploitasi secara ekonomi dan/atau seksual", "Anak yang menjadi korban penyalahgunaan narkotika, alkohol, psikotropika, dan zat adiktif lainnya", "Anak yang menjadi korban pornografi", "Anak dengan HIV/AIDS", "Anak korban penculikan, penjualan,dan/atau perdagangan", "Anak korban Kekerasan fisik dan/atau psikis", "Anak korban kejahatan seksual", "Anak korban jaringan terorisme", "Anak Penyandang Disabilitas", "Anak korban perlakuan salah dan penelantaran", "Anak dengan perilaku sosial menyimpang", "Anak yang menjadi korban stigmatisasi dari pelabelan terkait dengan kondisi Orang Tuanya"];
            // $data['disabilitas_kategori_ppkss'] = [
            //     "Fisik (terganggunya fungsi gerak)",
            //     "Intelektual (terganggunya fungsi pikir karena tingkat kecerdasan dibawah rata-rata)",
            //     "Mental (terganggunya fungsi pikir, emosi, dan perilaku)",
            //     "Sensorik (terganggunya salah satu fungsi dari panca indera)",
            //     "Ganda (Penyandang Disabilitas yang mempunyai dua atau lebih ragam disabilitas, antara lain disabilitas rungu-wicara dan disabilitas netra-tuli)",
            // ];
            // $data['bencana_kategori_ppkss'] = [
            //     "Tuna Susila",
            //     "Gelandangan",
            //     "Pengemis",
            //     "Pemulung",
            //     "Kelompok Minoritas",
            //     "Bekas Warga Binaan Lembaga Pemasyarakatan (BWBLP)",
            //     "Orang dengan HIV/AIDS (ODHA)",
            //     "Korban Penyalahgunaan NAPZA",
            //     "Korban Trafficking",
            //     "Korban tindak kekerasan",
            //     "Pekerja Migran Indonesia Bermasalah Sosial (PMBS) (PMIB)",
            //     "Perempuan rawan sosial ekonomi",
            //     "Korban bencana alam",
            //     "Korban bencana sosial",
            // ];
            // $data['kategori_ppkss'] = [
            //     "KBA (Korban Bencana Alam)",
            //     "KBS (Korban Bencana Sosial)",
            //     "Fakir Miskin",
            //     "ANTAR (Anak Terlantar",
            //     "ABT (Anak Balita Terlantar)",
            //     "ABH (Anak Berhadapan Dengan Hukum)",
            //     "ANJAL (Anak Jalanan)",
            //     "ANAK SALAH (Anak Yang Mendapatkan Perlakuan Salah)",
            //     "AMPK (Anak Yang Memerlukan Perlindungan Khusus)",
            //     "LANSIA (Lanjut Usia)",
            //     "ADK (Anak Dengan Kedisabilitasan)",
            //     "PD (Penyandang Disabilitas)",
            //     "KBSP (Keluarga Bermasalah Sosial Psikologis)",
            //     "TUNA SUSILA",
            //     "GELANDANGAN",
            //     "PENGEMIS",
            //     "PEMULUNG",
            //     "PERSOSEK (Perempuan Rawan Sosial Ekonomi)",
            //     "MINORITAS (Kelompok Minoritas)",
            //     "WBINLAP (Bekas Warga Binaan Lembaga Pemasyarakatan)",
            //     "ODHA (Orang Dengan HIV/AIDS)",
            //     "NAPZA (Korban Penyalahgunaan NAPZA)",
            //     "TRAFICKING (Korban Traficking)",
            //     "KEKERASAN (Korban Kekerasan)",
            //     "MIGRAN (Pekerja Migran Bermasalah Sosial)",
            //     "KAT (Komunitas Adat Terpencil)",
            // ];

            $data['kategori_ppkss'] = [
                [
                    'name' => 'Anak',
                    'id' => '1',
                    'value' => [
                        'Anak balita terlantar',
                        'Anak terlantar',
                        'Anak yang berhadapan dengan hukum',
                        'Anak jalanan',
                        'Anak dengan kedisabilitasan (ADK)',
                        'Anak yang menjadi korban tindak kekerasan atau diperlakukan salah',
                        'Anak yang memerlukan perlindungan khusus',
                    ],
                ],
                [
                    'name' => 'Lanjut Usia',
                    'id' => '2',
                    'value' => [
                        'Membutuhkan bantuan dalam aktifitas sehari – hari (Activity Daily Living)',
                        'Tidak membutuhkan bantuan dalam aktifitas sehari – hari (Activity Daily Living)',
                    ],
                ],
                [
                    'name' => 'Penyandang disabilitas',
                    'id' => '3',
                    'value' => [
                        'Fisik (terganggunya fungsi gerak)',
                        'Intelektual (terganggunya fungsi pikir karena tingkat kecerdasan dibawah rata-rata)',
                        'Mental (terganggunya fungsi pikir, emosi, dan perilaku) Skizofrenia',
                        'Sensorik    (terganggunya    salah    satu    fungsi    dari panca indera)',
                        'Ganda (Penyandang  Disabilitas  yang  mempunyai  dua  atau lebih  ragam  disabilitas, antara  lain  disabilitas rungu- wicara dan disabilitas netra-tuli)',
                    ],
                ],
                [
                    'name' => 'Bencana',
                    'id' => '4',
                    'value' => [
                        'Tuna Susila',
                        'Gelandangan',
                        'Pengemis',
                        'Pemulung',
                        'Kelompok Minoritas',
                        'Bekas Warga Binaan Lembaga Pemasyarakatan (BWBLP)',
                        'Orang dengan HIV/AIDS (ODHA)',
                        'Korban Penyalahgunaan  NAPZA',
                        'Korban trafficking',
                        'Korban tindak kekerasan',
                        'Pekerja Migran Bermasalah Sosial (PMBS)',
                        'Korban bencana alam',
                        'Korban bencana sosial',
                        'Perempuan rawan sosial ekonomi',
                        'Fakir Miskin',
                        'Keluarga bermasalah sosial psikologis',
                        'Komunitas Adat Terpencil',
                    ],
                ],
            ];

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";

            // switch ($oldData->kategori) {
            //     case 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)':
            $data['sdm'] = $this->_db->table('ref_sdm')->orderBy('jenis', 'ASC')->orderBy('nama', 'ASC')->get()->getResult();
            $response->data = view('silastri/adm/pengaduan/asesmenppks/form-asesment-ppks', $data);
            //         break;

            //     default:
            //         $response->data = view('silastri/adm/pengaduan/antrian/form-tanggapan', $data);
            //         break;
            // }
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

    //_penghasilan_ekonomi
    // 1.	lebih dari 3 jt        
    // 2.	500 rb s.d. 3 jt   
    // 3.	kurang dari 500  rb

    //_penghasilan_makan_ekonomi
    // 1.	sebagaian besar untuk investasi                     
    // 2.	sebagian besar untuk konsumsi dasar            

    //_makan_ekonomi
    // 1.	tiga kali/hari                                        
    // 2.	dua kali/hari 
    // 3.	satu kali/perhari  

    //_kemampuan_pakaian_ekonomi
    // 1.	tiga kali pertahun                               
    // 2.	dua kali pertahun            
    // 3.	satu kali/tahun

    //_tempat_tinggal_ekonomi
    // 1.	Milik Sendiri
    // 2.	Sewa
    // 3.	Menumpang
    // 4.	Lembaga
    // 5.	Telantar/Menggelandang

    //_luas_lantai_ekonomi
    // 1.	lebih dari 8 m²
    // 2.	sampai dengan 8 m²

    //_jenis_lantai_ekonomi
    // 1.	Marmer/granit
    // 2.	Keramik
    // 3.	Parket/vinil/permadani
    // 4.	Ubin/tegel/teraso kondisi bagus
    // 5.	Kayu/papan kualitas tinggi 
    // 6.	Ubin/tegel/teraso kondisi jelek/rusak
    // 7.	Kayu/papan kualitas rendah
    // 8.	Semen/bata merah
    // 9.	Bambu
    // 10.	Tanah  

    //_jenis_dinding_ekonomi
    // 1.	Tembok kondisi bagus
    // 2.	Plesteran anyaman bambu/kawat kondisi bagus
    // 3.	Kayu/papan/gypsum/GRC/calciboard kondisi bagus
    // 4.	Tembok kondisi jelek/rusak
    // 5.	Plesteran anyaman bambu/kawat kondisi jelek/rusak
    // 6.	Kayu/papan/gypsum/GRC/calciboard kondisi jelek/rusak
    // 7.	Anyaman bamboo
    // 8.	Batang kayu
    // 9.	Bambu

    //_jenis_atap_ekonomi
    // 01.	Beton/genteng beton
    // 02.	Genteng keramik
    // 03.	Genteng metal
    // 04.	Genteng tanah liat kondisi bagus
    // 05.	Genteng tanah liat kondisi jelek
    // 06.	Seng
    // 07.	Sirap
    // 08.	Jerami/ijuk/daun daunan/rumbia
    // 09.	Asbes
    // 10.	Lainnya

    //_milik_wc_ekonomi
    // 01.	Ada, digunakan hanya Anggota keluarga sendiri
    // 02.	Ada, digunakan bersama Anggota Keluarga dari keluarga tertentu
    // 03.	Ada, di MCK komunal
    // 04.	Ada, di MCK umum/siapapun munggunakan
    // 05.	Ada, Anggota Keluarga tidak menggunkan
    // 06.	Tidak ada fasilitas

    //_jenis_wc_ekonomi
    // 01.	Duduk / Leher angsa        
    // 02.	Plengesengan       
    // 03.	Cemplung/cubluk         
    // 04.	Tidak pakai

    //_penerangan_ekonomi
    // 01.	Listrik PLN > 2.200 volt ampere  
    // 02.	Listrik PLN  2.200 volt ampere  
    // 03.	Listrik PLN  1.300 volt ampere  
    // 04.	Listrik non PLN > 2.200 volt ampere 
    // 05.	Listrik non PLN  2.200 volt ampere  
    // 06.	Listrik non PLN  1.300 volt ampere  
    // 07.	Listrik PLN  900 volt ampere  
    // 08.	Listrik Non PLN  900 volt ampere 
    // 09.	Listrik PLN  450 volt ampere  
    // 10.	Listrik Non PLN  450 volt ampere                 
    // 11.	Bukan listrik

    //_sumber_air_minum_ekonomi
    // 1.	Air kemasan bermerk
    // 2.	Air isi ulang
    // 3.	Leding
    // 4.	Sumur bor/pompa
    // 5.	Sumur terlindung
    // 6.	Sumur tak terlindung 
    // 7.	Mata air terlindung
    // 8.	Mata air tak terlindung
    // 9.	Air Permukaan (sungai/danau/waduk/kolam/irigasi)
    // 10.	Air hujan
    // 11.	Lainnya

    //_bahan_bakar_masak_ekonomi
    // 1.	Listrik
    // 2.	Gas > 3 kg
    // 3.	Gas kota/biogas
    // 4.	gas 3 kg
    // 5.	Minyak tanah
    // 6.	Briket
    // 7.	Arang
    // 8.	Kayu bakar
    // 9.	Tidak memasak di rumah

    //_berobat_ekonomi
    // 1.	Dokter                                                  
    // 2.	Mantri                                
    // 3.	Puskesmas    

    //_rata_pendidikan_ekonomi
    // 1.	Perguruan tinggi         
    // 2.	SMA/sederajat              
    // 3.	SMP/sederajat             
    // 4.	SD/sederajat
    // 5.	Tidak bersekolah

    public function simpanassesment()
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
            // '_gambaran_kasus' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Gambaran kasus tidak boleh kosong. ',
            //     ]
            // ],
            // '_kondisi_kesehatan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Kondisi kesehatan tidak boleh kosong. ',
            //     ]
            // ],
            // '_kondisi_perekonomian_keluarga' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Kondisi perekonomian keluarga tidak boleh kosong. ',
            //     ]
            // ],
            // '_permasalahan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Permasalahan tidak boleh kosong. ',
            //     ]
            // ],
            // '_identifikasi_kebutuhan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Identifikasi kebutuhan tidak boleh kosong. ',
            //     ]
            // ],
            // '_intervensi_telah_dilakukan' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Interversi yang telah dilakukan tidak boleh kosong. ',
            //     ]
            // ],
            // '_saran_tindak_lanjut' => [
            //     'rules' => 'required|trim',
            //     'errors' => [
            //         'required' => 'Saran / rencana tindak lanjut tidak boleh kosong. ',
            //     ]
            // ],
            '_id_petugas_assesment' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Petugas assesment tidak boleh kosong. ',
                ]
            ],
            '_tgl_assesment' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal assesment tidak boleh kosong. ',
                ]
            ],
            '_provinsi_ktp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Provinsi KTP tidak boleh kosong. ',
                ]
            ],
            '_kabupaten_ktp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kabupaten KTP tidak boleh kosong. ',
                ]
            ],
            '_kecamatan_ktp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'kecamatan KTP tidak boleh kosong. ',
                ]
            ],
            '_kelurahan_ktp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'kelurahan KTP tidak boleh kosong. ',
                ]
            ],
            '_alamat_ktp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'alamat KTP tidak boleh kosong. ',
                ]
            ],
            '_provinsi_domisili' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Provinsi domisili tidak boleh kosong. ',
                ]
            ],
            '_kabupaten_domisili' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kabupaten domisili tidak boleh kosong. ',
                ]
            ],
            '_kecamatan_domisili' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'kecamatan domisili tidak boleh kosong. ',
                ]
            ],
            '_kelurahan_domisili' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'kelurahan domisili tidak boleh kosong. ',
                ]
            ],
            '_alamat_domisili' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'alamat domisili tidak boleh kosong. ',
                ]
            ],
            '_nama_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama PPKS tidak boleh kosong. ',
                ]
            ],
            '_tempat_lahir_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tempat lahir PPKS tidak boleh kosong. ',
                ]
            ],
            '_tgl_lahir_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_kelamin_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis kelamin PPKS tidak boleh kosong. ',
                ]
            ],
            '_agama_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Agama PPKS tidak boleh kosong. ',
                ]
            ],
            '_nik_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK PPKS tidak boleh kosong. ',
                ]
            ],
            '_kk_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'KK PPKS tidak boleh kosong. ',
                ]
            ],
            '_akta_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Akta PPKS tidak boleh kosong. ',
                ]
            ],
            '_dtks_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'PPKS sudah masuk DTKS tidak boleh kosong. ',
                ]
            ],
            // 'nik_pemilik_bansos.*' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'NIK pemilik bansos tidak boleh kosong. ',
            //     ]
            // ],
            // 'nama_pemilik_bansos.*' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Nama pemilik bansos tidak boleh kosong. ',
            //     ]
            // ],
            // 'keterangan_pemilik_bansos.*' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Keterangan pemilik bansos tidak boleh kosong. ',
            //     ]
            // ],

            '_pendidikan_terakhir_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pendidikan terakhir PPKS ke tidak boleh kosong. ',
                ]
            ],
            '_status_kawin_identitas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Status kawin PPKS tidak boleh kosong. ',
                ]
            ],
            '_nama_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_nohp_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No hp pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_hubungan_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Hubungan pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_tempat_lahir_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tempat lahir pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_tgl_lahir_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_kelamin_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis kelamin pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_agama_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Agama pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_nik_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_kk_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'KK pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_dtks_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pengampu PPKS sudah masuk DTKS tidak boleh kosong. ',
                ]
            ],
            '_pendidikan_terakhir_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pendidikan terakhir pengampu PPKS ke tidak boleh kosong. ',
                ]
            ],
            '_status_kawin_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Status kawin pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_pekerjaan_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pekerjaan pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_pengeluaran_perbulan_pengampu' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pengeluaran perbulan pengampu PPKS tidak boleh kosong. ',
                ]
            ],
            '_kategori_ppks' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori PPKS tidak boleh kosong. ',
                ]
            ],
            '_kondisi_fisik_ppks' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kondisi fisik PPKS tidak boleh kosong. ',
                ]
            ],
            '_detail_kondisi_fisik_ppks' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Penjelasan kondisi fisik PPKS tidak boleh kosong. ',
                ]
            ],
            '_penghasilan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Penghasilan PPKS perbulan tidak boleh kosong. ',
                ]
            ],
            '_penghasilan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Penghasilan PPKS perbulan tidak boleh kosong. ',
                ]
            ],
            '_penghasilan_makan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Penghasilan dan makan PPKS tidak boleh kosong. ',
                ]
            ],
            '_makan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Makan dalam sehari PPKS tidak boleh kosong. ',
                ]
            ],
            '_kemampuan_pakaian_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kemampuan membeli pakaian dalam setahun PPKS tidak boleh kosong. ',
                ]
            ],
            '_tempat_tinggal_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_tinggal_bersama_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'PPKS tinggal bersama tidak boleh kosong. ',
                ]
            ],
            '_luas_lantai_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Luas lantai tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_lantai_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis lantai tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_dinding_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis dinding tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_atap_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis atap tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_milik_wc_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Memiliki WC pada tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_jenis_wc_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis WC pada tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_penerangan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Sumber penerangan pada tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_sumber_air_minum_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Sumber air minum pada tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_bahan_bakar_masak_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bahan bakar memasak pada tempat tinggal PPKS tidak boleh kosong. ',
                ]
            ],
            '_berobat_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kemampuan berobat PPKS tidak boleh kosong. ',
                ]
            ],
            '_rata_pendidikan_ekonomi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Rata-rata pendidikan pada keluarga PPKS tidak boleh kosong. ',
                ]
            ],
            '_catatan_tambahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Catatan tambahan tidak boleh kosong. ',
                ]
            ],
            '_gambaran_kasus' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Gambaran kasus tidak boleh kosong. ',
                ]
            ],
            '_kondisi_kesehatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kondisi perekonomian keluarga tidak boleh kosong. ',
                ]
            ],
            '_permasalahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Permasalahan tidak boleh kosong. ',
                ]
            ],
            '_identifikasi_kebutuhan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Identifikasi kebutuhan tidak boleh kosong. ',
                ]
            ],
            '_intervensi_telah_dilakukan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Intervensi yang telah dilakukan tidak boleh kosong. ',
                ]
            ],
            '_saran_tindak_lanjut' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Saran / Rencana tindak lanjut tidak boleh kosong. ',
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

    public function getKelurahan()
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

            $kels = $this->_db->table('ref_kelurahan')->where('id_kecamatan', $id)->orderBy('kelurahan', 'ASC')->get()->getResult();

            if (count($kels) > 0) {
                $x['kels'] = $kels;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('portal/ref_kelurahan', $x);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
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
