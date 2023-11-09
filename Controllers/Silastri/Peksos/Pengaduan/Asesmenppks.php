<?php

namespace App\Controllers\Silastri\Peksos\Pengaduan;

use App\Controllers\BaseController;
use App\Models\Silastri\Peksos\Pengaduan\AsesmenppksModel;
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
use PhpOffice\PhpWord\TemplateProcessor;

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
        return redirect()->to(base_url('silastri/peksos/pengaduan/asesmenppks/data'));
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

        return view('silastri/peksos/pengaduan/asesmenppks/index', $data);
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
                $granted = grantedCanAssesment($user->data->nik, $current->peserta_spt);
                if ($granted) {
                    $data['data'] = $current;
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Permintaan diizinkan";
                    $response->data = view('silastri/peksos/pengaduan/asesmenppks/detail', $data);
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

            $granted = grantedCanAssesment($user->data->nik, $oldData->peserta_spt);
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
            $response->data = view('silastri/peksos/pengaduan/asesmenppks/form-asesment-ppks', $data);
            //         break;

            //     default:
            //         $response->data = view('silastri/peksos/pengaduan/antrian/form-tanggapan', $data);
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
            $response->data = view('silastri/peksos/pengaduan/antrian/tolak', $data);
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
            '_tgl_asessment' => [
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
            // 'waktu_bansos_identitas.*' => [
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
            // 'jumlah_bansos_identitas.*' => [
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
            '_kondisi_perekonomian_keluarga' => [
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

        $filenamelampiranktp = dot_array_search('_file_ktp.name', $_FILES);
        if ($filenamelampiranktp != '') {
            $lampiranValKtp = [
                '_file_ktp' => [
                    'rules' => 'uploaded[_file_ktp]|max_size[_file_ktp,2048]|mime_in[_file_ktp,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKtp);
        }

        $filenamelampirankk = dot_array_search('_file_kk.name', $_FILES);
        if ($filenamelampirankk != '') {
            $lampiranValkk = [
                '_file_kk' => [
                    'rules' => 'uploaded[_file_kk]|max_size[_file_kk,2048]|mime_in[_file_kk,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValkk);
        }

        $filenamelampiranrumah_depan = dot_array_search('_file_rumah_depan.name', $_FILES);
        if ($filenamelampiranrumah_depan != '') {
            $lampiranValrumah_depan = [
                '_file_rumah_depan' => [
                    'rules' => 'uploaded[_file_rumah_depan]|max_size[_file_rumah_depan,2048]|mime_in[_file_rumah_depan,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValrumah_depan);
        }

        $filenamelampiranrumah_kiri = dot_array_search('_file_rumah_kiri.name', $_FILES);
        if ($filenamelampiranrumah_kiri != '') {
            $lampiranValrumah_kiri = [
                '_file_rumah_kiri' => [
                    'rules' => 'uploaded[_file_rumah_kiri]|max_size[_file_rumah_kiri,2048]|mime_in[_file_rumah_kiri,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValrumah_kiri);
        }

        $filenamelampiranrumah_kanan = dot_array_search('_file_rumah_kanan.name', $_FILES);
        if ($filenamelampiranrumah_kanan != '') {
            $lampiranValrumah_kanan = [
                '_file_rumah_kanan' => [
                    'rules' => 'uploaded[_file_rumah_kanan]|max_size[_file_rumah_kanan,2048]|mime_in[_file_rumah_kanan,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValrumah_kanan);
        }

        $filenamelampiranrumah_belakang = dot_array_search('_file_rumah_belakang.name', $_FILES);
        if ($filenamelampiranrumah_belakang != '') {
            $lampiranValrumah_belakang = [
                '_file_rumah_belakang' => [
                    'rules' => 'uploaded[_file_rumah_belakang]|max_size[_file_rumah_belakang,2048]|mime_in[_file_rumah_belakang,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValrumah_belakang);
        }


        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            // $response->message = "Silahkan lengkapi isian wajib.";
            $response->message =
                $this->validator->getError('_id')
                . $this->validator->getError('_nama')
                . $this->validator->getError('_id_petugas_assesment')
                . $this->validator->getError('_tgl_asessment')
                . $this->validator->getError('_provinsi_ktp')
                . $this->validator->getError('_kabupaten_ktp')
                . $this->validator->getError('_kecamatan_ktp')
                . $this->validator->getError('_kelurahan_ktp')
                . $this->validator->getError('_alamat_ktp')
                . $this->validator->getError('_provinsi_domisili')
                . $this->validator->getError('_kabupaten_domisili')
                . $this->validator->getError('_kecamatan_domisili')
                . $this->validator->getError('_kelurahan_domisili')
                . $this->validator->getError('_alamat_domisili')
                . $this->validator->getError('_nama_identitas')
                . $this->validator->getError('_tempat_lahir_identitas')
                . $this->validator->getError('_tgl_lahir_identitas')
                . $this->validator->getError('_jenis_kelamin_identitas')
                . $this->validator->getError('_agama_identitas')
                . $this->validator->getError('_nik_identitas')
                . $this->validator->getError('_kk_identitas')
                . $this->validator->getError('_akta_identitas')
                . $this->validator->getError('_dtks_identitas')
                . $this->validator->getError('_pendidikan_terakhir_identitas')
                . $this->validator->getError('_status_kawin_identitas')
                . $this->validator->getError('_nama_pengampu')
                . $this->validator->getError('_nohp_pengampu')
                . $this->validator->getError('_hubungan_pengampu')
                . $this->validator->getError('_tempat_lahir_pengampu')
                . $this->validator->getError('_tgl_lahir_pengampu')
                . $this->validator->getError('_jenis_kelamin_pengampu')
                . $this->validator->getError('_agama_pengampu')
                . $this->validator->getError('_nik_pengampu')
                . $this->validator->getError('_kk_pengampu')
                . $this->validator->getError('_dtks_pengampu')
                . $this->validator->getError('_pendidikan_terakhir_pengampu')
                . $this->validator->getError('_status_kawin_pengampu')
                . $this->validator->getError('_pekerjaan_pengampu')
                . $this->validator->getError('_pengeluaran_perbulan_pengampu')
                . $this->validator->getError('_kategori_ppks')
                . $this->validator->getError('_kondisi_fisik_ppks')
                . $this->validator->getError('_detail_kondisi_fisik_ppks')
                . $this->validator->getError('_penghasilan_ekonomi')
                . $this->validator->getError('_penghasilan_makan_ekonomi')
                . $this->validator->getError('_makan_ekonomi')
                . $this->validator->getError('_kemampuan_pakaian_ekonomi')
                . $this->validator->getError('_tempat_tinggal_ekonomi')
                . $this->validator->getError('_tinggal_bersama_ekonomi')
                . $this->validator->getError('_luas_lantai_ekonomi')
                . $this->validator->getError('_jenis_lantai_ekonomi')
                . $this->validator->getError('_jenis_dinding_ekonomi')
                . $this->validator->getError('_jenis_atap_ekonomi')
                . $this->validator->getError('_milik_wc_ekonomi')
                . $this->validator->getError('_jenis_wc_ekonomi')
                . $this->validator->getError('_penerangan_ekonomi')
                . $this->validator->getError('_sumber_air_minum_ekonomi')
                . $this->validator->getError('_bahan_bakar_masak_ekonomi')
                . $this->validator->getError('_berobat_ekonomi')
                . $this->validator->getError('_rata_pendidikan_ekonomi')
                . $this->validator->getError('_catatan_tambahan')
                . $this->validator->getError('_gambaran_kasus')
                . $this->validator->getError('_kondisi_kesehatan')
                . $this->validator->getError('_permasalahan')
                . $this->validator->getError('_identifikasi_kebutuhan')
                . $this->validator->getError('_intervensi_telah_dilakukan')
                . $this->validator->getError('_saran_tindak_lanjut');
            return json_encode($response);
        } else {
            $namesBansosIdentitas = $this->request->getVar('nama_bansos_identitas');
            $waktu_bansos_identitas = $this->request->getVar('waktu_bansos_identitas');
            $jumlah_bansos_identitas = $this->request->getVar('jumlah_bansos_identitas');
            $satuan_bansos_identitas = $this->request->getVar('satuan_bansos_identitas');
            $sumber_anggaran_identitas = $this->request->getVar('sumber_anggaran_identitas');
            $keterangan_identitas = $this->request->getVar('keterangan_identitas');

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

            $bansosIdentitas = [];

            if ($namesBansosIdentitas || $namesBansosIdentitas !== NULL) {
                if (count($namesBansosIdentitas) == count($waktu_bansos_identitas) && count($namesBansosIdentitas) == count($jumlah_bansos_identitas) && count($namesBansosIdentitas) == count($satuan_bansos_identitas) && count($namesBansosIdentitas) == count($sumber_anggaran_identitas) && count($namesBansosIdentitas) == count($keterangan_identitas)) {
                    foreach ($namesBansosIdentitas as $key => $value) {
                        $bansosOrang = [
                            'waktu_bansos' => $waktu_bansos_identitas[$key],
                            'nama_bansos' => $namesBansosIdentitas[$key],
                            'jumlah_bansos' => $jumlah_bansos_identitas[$key],
                            'satuan_bansos' => $satuan_bansos_identitas[$key],
                            'sumber_anggaran_bansos' => $sumber_anggaran_identitas[$key],
                            'keterangan_bansos' => $keterangan_identitas[$key],
                        ];

                        $bansosIdentitas[] = $bansosOrang;
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Silahkan lengkapi bantuan yang sudah diterima PPKS dengan benar.";
                    return json_encode($response);
                }
            }

            $bansosPengampu = [];
            $namesBansosPengampu = $this->request->getVar('nama_bansos_pengampu');
            $tahun_bansos_pengampu = $this->request->getVar('tahun_bansos_pengampu');

            if ($namesBansosPengampu || $namesBansosPengampu !== NULL) {
                if (count($namesBansosPengampu) == count($tahun_bansos_pengampu)) {
                    foreach ($namesBansosPengampu as $key => $valu) {
                        $bansosOrangPengampu = [
                            'tahun_bansos' => $tahun_bansos_pengampu[$key],
                            'nama_bansos' => $namesBansosPengampu[$key],
                        ];

                        $bansosPengampu[] = $bansosOrangPengampu;
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Silahkan lengkapi bantuan yang sudah diterima oleh pengampu PPKS dengan benar.";
                    return json_encode($response);
                }
            }

            $id = htmlspecialchars($this->request->getVar('_id'), true) ?? NULL;
            $nama = htmlspecialchars($this->request->getVar('_nama'), true) ?? NULL;
            $id_petugas_assesment = htmlspecialchars($this->request->getVar('_id_petugas_assesment'), true) ?? NULL;
            $tgl_assesment = htmlspecialchars($this->request->getVar('_tgl_asessment'), true) ?? NULL;
            $provinsi_ktp = htmlspecialchars($this->request->getVar('_provinsi_ktp'), true) ?? NULL;
            $kabupaten_ktp = htmlspecialchars($this->request->getVar('_kabupaten_ktp'), true) ?? NULL;
            $kecamatan_ktp = htmlspecialchars($this->request->getVar('_kecamatan_ktp'), true) ?? NULL;
            $kelurahan_ktp = htmlspecialchars($this->request->getVar('_kelurahan_ktp'), true) ?? NULL;
            $alamat_ktp = htmlspecialchars($this->request->getVar('_alamat_ktp'), true) ?? NULL;
            $provinsi_domisili = htmlspecialchars($this->request->getVar('_provinsi_domisili'), true) ?? NULL;
            $kabupaten_domisili = htmlspecialchars($this->request->getVar('_kabupaten_domisili'), true) ?? NULL;
            $kecamatan_domisili = htmlspecialchars($this->request->getVar('_kecamatan_domisili'), true) ?? NULL;
            $kelurahan_domisili = htmlspecialchars($this->request->getVar('_kelurahan_domisili'), true) ?? NULL;
            $alamat_domisili = htmlspecialchars($this->request->getVar('_alamat_domisili'), true) ?? NULL;
            $nama_identitas = htmlspecialchars($this->request->getVar('_nama_identitas'), true) ?? NULL;
            $tempat_lahir_identitas = htmlspecialchars($this->request->getVar('_tempat_lahir_identitas'), true) ?? NULL;
            $tgl_lahir_identitas = htmlspecialchars($this->request->getVar('_tgl_lahir_identitas'), true) ?? NULL;
            $jenis_kelamin_identitas = htmlspecialchars($this->request->getVar('_jenis_kelamin_identitas'), true) ?? NULL;
            $agama_identitas = htmlspecialchars($this->request->getVar('_agama_identitas'), true) ?? NULL;
            $nik_identitas = htmlspecialchars($this->request->getVar('_nik_identitas'), true) ?? NULL;
            $kk_identitas = htmlspecialchars($this->request->getVar('_kk_identitas'), true) ?? NULL;
            $akta_identitas = htmlspecialchars($this->request->getVar('_akta_identitas'), true) ?? NULL;
            $dtks_identitas = htmlspecialchars($this->request->getVar('_dtks_identitas'), true) ?? NULL;
            $pendidikan_terakhir_identitas = htmlspecialchars($this->request->getVar('_pendidikan_terakhir_identitas'), true) ?? NULL;
            $status_kawin_identitas = htmlspecialchars($this->request->getVar('_status_kawin_identitas'), true) ?? NULL;
            $nama_pengampu = htmlspecialchars($this->request->getVar('_nama_pengampu'), true) ?? NULL;
            $nohp_pengampu = htmlspecialchars($this->request->getVar('_nohp_pengampu'), true) ?? NULL;
            $hubungan_pengampu = htmlspecialchars($this->request->getVar('_hubungan_pengampu'), true) ?? NULL;
            $tempat_lahir_pengampu = htmlspecialchars($this->request->getVar('_tempat_lahir_pengampu'), true) ?? NULL;
            $tgl_lahir_pengampu = htmlspecialchars($this->request->getVar('_tgl_lahir_pengampu'), true) ?? NULL;
            $jenis_kelamin_pengampu = htmlspecialchars($this->request->getVar('_jenis_kelamin_pengampu'), true) ?? NULL;
            $agama_pengampu = htmlspecialchars($this->request->getVar('_agama_pengampu'), true) ?? NULL;
            $nik_pengampu = htmlspecialchars($this->request->getVar('_nik_pengampu'), true) ?? NULL;
            $kk_pengampu = htmlspecialchars($this->request->getVar('_kk_pengampu'), true) ?? NULL;
            $dtks_pengampu = htmlspecialchars($this->request->getVar('_dtks_pengampu'), true) ?? NULL;
            $pendidikan_terakhir_pengampu = htmlspecialchars($this->request->getVar('_pendidikan_terakhir_pengampu'), true) ?? NULL;
            $status_kawin_pengampu = htmlspecialchars($this->request->getVar('_status_kawin_pengampu'), true) ?? NULL;
            $pekerjaan_pengampu = htmlspecialchars($this->request->getVar('_pekerjaan_pengampu'), true) ?? NULL;
            $pengeluaran_perbulan_pengampu = htmlspecialchars($this->request->getVar('_pengeluaran_perbulan_pengampu'), true) ?? NULL;
            $kategori_ppks = htmlspecialchars($this->request->getVar('_kategori_ppks'), true) ?? NULL;
            $kondisi_fisik_ppks = htmlspecialchars($this->request->getVar('_kondisi_fisik_ppks'), true) ?? NULL;
            $detail_kondisi_fisik_ppks = htmlspecialchars($this->request->getVar('_detail_kondisi_fisik_ppks'), true) ?? NULL;
            $penghasilan_ekonomi = htmlspecialchars($this->request->getVar('_penghasilan_ekonomi'), true) ?? NULL;
            $penghasilan_makan_ekonomi = htmlspecialchars($this->request->getVar('_penghasilan_makan_ekonomi'), true) ?? NULL;
            $makan_ekonomi = htmlspecialchars($this->request->getVar('_makan_ekonomi'), true) ?? NULL;
            $kemampuan_pakaian_ekonomi = htmlspecialchars($this->request->getVar('_kemampuan_pakaian_ekonomi'), true) ?? NULL;
            $tempat_tinggal_ekonomi = htmlspecialchars($this->request->getVar('_tempat_tinggal_ekonomi'), true) ?? NULL;
            $tinggal_bersama_ekonomi = htmlspecialchars($this->request->getVar('_tinggal_bersama_ekonomi'), true) ?? NULL;
            $luas_lantai_ekonomi = htmlspecialchars($this->request->getVar('_luas_lantai_ekonomi'), true) ?? NULL;
            $jenis_lantai_ekonomi = htmlspecialchars($this->request->getVar('_jenis_lantai_ekonomi'), true) ?? NULL;
            $jenis_dinding_ekonomi = htmlspecialchars($this->request->getVar('_jenis_dinding_ekonomi'), true) ?? NULL;
            $jenis_atap_ekonomi = htmlspecialchars($this->request->getVar('_jenis_atap_ekonomi'), true) ?? NULL;
            $milik_wc_ekonomi = htmlspecialchars($this->request->getVar('_milik_wc_ekonomi'), true) ?? NULL;
            $jenis_wc_ekonomi = htmlspecialchars($this->request->getVar('_jenis_wc_ekonomi'), true) ?? NULL;
            $penerangan_ekonomi = htmlspecialchars($this->request->getVar('_penerangan_ekonomi'), true) ?? NULL;
            $sumber_air_minum_ekonomi = htmlspecialchars($this->request->getVar('_sumber_air_minum_ekonomi'), true) ?? NULL;
            $bahan_bakar_masak_ekonomi = htmlspecialchars($this->request->getVar('_bahan_bakar_masak_ekonomi'), true) ?? NULL;
            $berobat_ekonomi = htmlspecialchars($this->request->getVar('_berobat_ekonomi'), true) ?? NULL;
            $rata_pendidikan_ekonomi = htmlspecialchars($this->request->getVar('_rata_pendidikan_ekonomi'), true) ?? NULL;
            $catatan_tambahan = htmlspecialchars($this->request->getVar('_catatan_tambahan'), true) ?? NULL;
            $gambaran_kasus = htmlspecialchars($this->request->getVar('_gambaran_kasus'), true) ?? NULL;
            $kondisi_kesehatan = htmlspecialchars($this->request->getVar('_kondisi_kesehatan'), true) ?? NULL;
            $kondisi_perekonomian_keluarga = htmlspecialchars($this->request->getVar('_kondisi_perekonomian_keluarga'), true) ?? NULL;
            $permasalahan = htmlspecialchars($this->request->getVar('_permasalahan'), true) ?? NULL;
            $identifikasi_kebutuhan = htmlspecialchars($this->request->getVar('_identifikasi_kebutuhan'), true) ?? NULL;
            $intervensi_telah_dilakukan = htmlspecialchars($this->request->getVar('_intervensi_telah_dilakukan'), true) ?? NULL;
            $saran_tindak_lanjut = htmlspecialchars($this->request->getVar('_saran_tindak_lanjut'), true) ?? NULL;

            $lampiran = "";

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

            $granted = grantedCanAssesment($user->data->nik, $oldData->peserta_spt);
            if (!$granted) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Akses tidak diizinkan.";
                return json_encode($response);
            }
            $kepala_dinas = $this->request->getVar('_kepala_dinas') ? htmlspecialchars($this->request->getVar('_kepala_dinas'), true) : NULL;
            $kepala_dinas_pilihan = $this->request->getVar('_kepala_dinas_pilihan') ? htmlspecialchars($this->request->getVar('_kepala_dinas_pilihan'), true) : NULL;
            $camat = $this->request->getVar('_camat') ? htmlspecialchars($this->request->getVar('_camat'), true) : NULL;
            $camat_pilihan = $this->request->getVar('_camat_pilihan') ? htmlspecialchars($this->request->getVar('_camat_pilihan'), true) : NULL;
            $kampung = $this->request->getVar('_kampung') ? htmlspecialchars($this->request->getVar('_kampung'), true) : NULL;
            $kampung_pilihan = $this->request->getVar('_kampung_pilihan') ? htmlspecialchars($this->request->getVar('_kampung_pilihan'), true) : NULL;
            // $jumlah_lampiran = $this->request->getVar('_jumlah_lampiran') ? htmlspecialchars($this->request->getVar('_jumlah_lampiran'), true) : '0';

            $namesPemilikBansos = $this->request->getVar('nama_pemilik_bansos');
            $nik_pemilik_bansos = $this->request->getVar('nik_pemilik_bansos');
            $keterangan_pemilik_bansos = $this->request->getVar('keterangan_pemilik_bansos');

            if ($namesPemilikBansos && !($namesPemilikBansos == NULL || $namesPemilikBansos == "")) {
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
            }

            $dir = FCPATH . "uploads/assesment/lampiran";

            if ($filenamelampiranktp != '') {
                $lampiranktp = $this->request->getFile('_file_ktp');
                $filesNamelampiranktp = $lampiranktp->getName();
                $newNamelampiranktp = _create_name_foto($filesNamelampiranktp);

                if ($lampiranktp->isValid() && !$lampiranktp->hasMoved()) {
                    $lampiranktp->move($dir, $newNamelampiranktp);
                    $lampiran .= $newNamelampiranktp . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            if ($filenamelampirankk != '') {
                $lampirankk = $this->request->getFile('_file_kk');
                $filesNamelampirankk = $lampirankk->getName();
                $newNamelampirankk = _create_name_foto($filesNamelampirankk);

                if ($lampirankk->isValid() && !$lampirankk->hasMoved()) {
                    $lampirankk->move($dir, $newNamelampirankk);
                    $lampiran .= $newNamelampirankk . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranrumah_depan != '') {
                $lampiranrumah_depan = $this->request->getFile('_file_rumah_depan');
                $filesNamelampiranrumah_depan = $lampiranrumah_depan->getName();
                $newNamelampiranrumah_depan = _create_name_foto($filesNamelampiranrumah_depan);

                if ($lampiranrumah_depan->isValid() && !$lampiranrumah_depan->hasMoved()) {
                    $lampiranrumah_depan->move($dir, $newNamelampiranrumah_depan);
                    $lampiran .= $newNamelampiranrumah_depan . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranrumah_kiri != '') {
                $lampiranrumah_kiri = $this->request->getFile('_file_rumah_kiri');
                $filesNamelampiranrumah_kiri = $lampiranrumah_kiri->getName();
                $newNamelampiranrumah_kiri = _create_name_foto($filesNamelampiranrumah_kiri);

                if ($lampiranrumah_kiri->isValid() && !$lampiranrumah_kiri->hasMoved()) {
                    $lampiranrumah_kiri->move($dir, $newNamelampiranrumah_kiri);
                    $lampiran .= $newNamelampiranrumah_kiri . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranrumah_kanan != '') {
                $lampiranrumah_kanan = $this->request->getFile('_file_rumah_kanan');
                $filesNamelampiranrumah_kanan = $lampiranrumah_kanan->getName();
                $newNamelampiranrumah_kanan = _create_name_foto($filesNamelampiranrumah_kanan);

                if ($lampiranrumah_kanan->isValid() && !$lampiranrumah_kanan->hasMoved()) {
                    $lampiranrumah_kanan->move($dir, $newNamelampiranrumah_kanan);
                    $lampiran .= $newNamelampiranrumah_kanan . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranrumah_belakang != '') {
                $lampiranrumah_belakang = $this->request->getFile('_file_rumah_belakang');
                $filesNamelampiranrumah_belakang = $lampiranrumah_belakang->getName();
                $newNamelampiranrumah_belakang = _create_name_foto($filesNamelampiranrumah_belakang);

                if ($lampiranrumah_belakang->isValid() && !$lampiranrumah_belakang->hasMoved()) {
                    $lampiranrumah_belakang->move($dir, $newNamelampiranrumah_belakang);
                    $lampiran .= $newNamelampiranrumah_belakang . ';';
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran assesment.";
                    return json_encode($response);
                }
            }

            $kepersertaan_bansos = [];
            if ($namesPemilikBansos && !($namesPemilikBansos == NULL || $namesPemilikBansos == "")) {
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
            }

            $date = date('Y-m-d H:i:s');
            $upData = [];
            $upData['updated_at'] = $date;
            $upData['date_assesment'] = $date;
            $upData['admin_assesment'] = $user->data->id;
            $upData['status_aduan'] = 5;

            $skor_assesment = [];

            if ((int)$penghasilan_ekonomi > 2) {
                $skor_assesment['penghasilan'] = 0;
            } else {
                $skor_assesment['penghasilan'] = 1;
            }
            if ((int)$penghasilan_makan_ekonomi > 1) {
                $skor_assesment['penghasilan_makan'] = 0;
            } else {
                $skor_assesment['penghasilan_makan'] = 1;
            }
            if ((int)$makan_ekonomi > 1) {
                $skor_assesment['makan'] = 0;
            } else {
                $skor_assesment['makan'] = 1;
            }
            if ((int)$kemampuan_pakaian_ekonomi > 1) {
                $skor_assesment['kemampuan_pakaian'] = 0;
            } else {
                $skor_assesment['kemampuan_pakaian'] = 1;
            }
            if ((int)$tempat_tinggal_ekonomi > 2) {
                $skor_assesment['tempat_tinggal'] = 0;
            } else {
                $skor_assesment['tempat_tinggal'] = 1;
            }
            // if ((int)$tinggal_bersama_ekonomi > 2) {
            //     $skor_assesment['tinggal_bersama'] = 0;
            // } else {
            //     $skor_assesment['tinggal_bersama'] = 1;
            // }
            if ((int)$luas_lantai_ekonomi > 1) {
                $skor_assesment['luas_lantai'] = 0;
            } else {
                $skor_assesment['luas_lantai'] = 1;
            }
            if ((int)$jenis_lantai_ekonomi > 5) {
                $skor_assesment['jenis_lantai'] = 0;
            } else {
                $skor_assesment['jenis_lantai'] = 1;
            }
            if ((int)$jenis_dinding_ekonomi > 3) {
                $skor_assesment['jenis_dinding'] = 0;
            } else {
                $skor_assesment['jenis_dinding'] = 1;
            }
            if ((int)$jenis_atap_ekonomi > 4) {
                $skor_assesment['jenis_atap'] = 0;
            } else {
                $skor_assesment['jenis_atap'] = 1;
            }
            if ((int)$milik_wc_ekonomi > 1) {
                $skor_assesment['milik_wc'] = 0;
            } else {
                $skor_assesment['milik_wc'] = 1;
            }
            if ((int)$jenis_wc_ekonomi > 1) {
                $skor_assesment['jenis_wc'] = 0;
            } else {
                $skor_assesment['jenis_wc'] = 1;
            }
            if ((int)$penerangan_ekonomi > 6) {
                $skor_assesment['penerangan'] = 0;
            } else {
                $skor_assesment['penerangan'] = 1;
            }
            if ((int)$sumber_air_minum_ekonomi > 7) {
                $skor_assesment['sumber_air_minum'] = 0;
            } else {
                $skor_assesment['sumber_air_minum'] = 1;
            }
            if ((int)$bahan_bakar_masak_ekonomi > 3) {
                $skor_assesment['bahan_bakar_masak'] = 0;
            } else {
                $skor_assesment['bahan_bakar_masak'] = 1;
            }
            if ((int)$berobat_ekonomi > 1) {
                $skor_assesment['berobat'] = 0;
            } else {
                $skor_assesment['berobat'] = 1;
            }
            if ((int)$rata_pendidikan_ekonomi > 1) {
                $skor_assesment['rata_pendidikan'] = 0;
            } else {
                $skor_assesment['rata_pendidikan'] = 1;
            }

            $skor_total = $skor_assesment['penghasilan'] + $skor_assesment['penghasilan_makan'] + $skor_assesment['makan'] + $skor_assesment['kemampuan_pakaian'] + $skor_assesment['tempat_tinggal'] + $skor_assesment['luas_lantai'] + $skor_assesment['jenis_lantai'] + $skor_assesment['jenis_dinding'] + $skor_assesment['jenis_atap'] + $skor_assesment['milik_wc'] + $skor_assesment['jenis_wc'] + $skor_assesment['penerangan'] + $skor_assesment['sumber_air_minum'] + $skor_assesment['bahan_bakar_masak'] + $skor_assesment['berobat'] + $skor_assesment['rata_pendidikan'];

            $this->_db->transBegin();
            $this->_db->table('_pengaduan')->where('id', $oldData->id)->update($upData);
            if ($this->_db->affectedRows() > 0) {
                $this->_db->table('_pengaduan_tanggapan_spt')->where('id', $oldData->id)->update(['updated_at' => $date]);
                if ($this->_db->affectedRows() > 0) {
                    $dataTindakLanjut = [
                        'id' => $oldData->id,
                        'user_id' => $user->data->id,
                        'kode_aduan' => $oldData->kode_aduan,
                        'gambaran_kasus' => $gambaran_kasus,
                        'kondisi_kesehatan' => $kondisi_kesehatan,
                        'kondisi_perekonomian_keluarga' => $kondisi_perekonomian_keluarga,
                        'permasalahan' => $permasalahan,
                        // 'media_pengaduan' => $oldData->media_pengaduan,
                        'identifikasi_kebutuhan' => $identifikasi_kebutuhan,
                        'kepersertaan_bansos' => json_encode($kepersertaan_bansos),
                        'intervensi_telah_dilakukan' => $intervensi_telah_dilakukan,
                        // 'bansos_pengampu' => json_encode($bansosPengampu),
                        // 'bansos_ppks' => json_encode($bansosIdentitas),
                        'saran_tindaklanjut' => $saran_tindak_lanjut,
                        'tembusan_dinas' => ($kepala_dinas == 1 || $kepala_dinas == "1" || $kepala_dinas == "on") ? $kepala_dinas_pilihan : NULL,
                        'tembusan_camat' => ($camat == 1 || $camat == "1" || $camat == "on") ? $camat_pilihan : NULL,
                        'tembusan_kampung' => ($kampung == 1 || $kampung == "1" || $kampung == "on") ? $kampung_pilihan : NULL,
                        // 'jumlah_lampiran' => ($jumlah_lampiran == 0 || $jumlah_lampiran == "0" || $jumlah_lampiran == "-") ? $jumlah_lampiran : 0,
                        'created_at' => $date,
                    ];

                    $this->_db->table('_pengaduan_tanggapan_ppks')->insert($dataTindakLanjut);
                    if ($this->_db->affectedRows() > 0) {
                        $dataAssesment = [
                            'id' => $oldData->id,
                            'jenis' => 'PENGADUAN PPKS',
                            'kode_assesment' => 'ASSESMENT-' . $oldData->kode_aduan,
                            'admin_assesment' => $user->data->id,
                            'date_assesment' => $tgl_assesment,
                            'nik_orang_assesment' => $nik_identitas,
                            'nama_orang_assesment' => $nama_identitas,
                            'tempat_lahir_orang_assesment' => $tempat_lahir_identitas,
                            'tgl_lahir_orang_assesment' => $tgl_lahir_identitas,
                            'jk_orang_assesment' => $jenis_kelamin_identitas,
                            'agama_orang_assesment' => $agama_identitas,
                            'kk_orang_assesment' => $kk_identitas,
                            'akta_orang_assesment' => $akta_identitas,
                            'provinsi_ktp_orang_assesment' => $provinsi_ktp,
                            'kabupaten_ktp_orang_assesment' => $kabupaten_ktp,
                            'kecamatan_ktp_orang_assesment' => $kecamatan_ktp,
                            'kelurahan_ktp_orang_assesment' => $kelurahan_ktp,
                            'alamat_ktp_orang_assesment' => $alamat_ktp,
                            'provinsi_domisili_orang_assesment' => $provinsi_domisili,
                            'kabupaten_domisili_orang_assesment' => $kabupaten_domisili,
                            'kecamatan_domisili_orang_assesment' => $kecamatan_domisili,
                            'kelurahan_domisili_orang_assesment' => $kelurahan_domisili,
                            'alamat_domisili_orang_assesment' => $alamat_domisili,
                            'pendidikan_terakhir_orang_assesment' => $pendidikan_terakhir_identitas,
                            'status_kawin_orang_assesment' => $status_kawin_identitas,
                            'dtks_orang_assesment' => $dtks_identitas,
                            'bansos_orang_assesment' => json_encode($bansosIdentitas),
                            'nama_pengampu_assesment' => $nama_pengampu,
                            'nohp_pengampu_assesment' => $nohp_pengampu,
                            'hubungan_pengampu_assesment' => $hubungan_pengampu,
                            'tempat_lahir_pengampu_assesment' => $tempat_lahir_pengampu,
                            'tgl_lahir_pengampu_assesment' => $tgl_lahir_pengampu,
                            'jk_pengampu_assesment' => $jenis_kelamin_pengampu,
                            'agama_pengampu_assesment' => $agama_pengampu,
                            'nik_pengampu_assesment' => $nik_pengampu,
                            'kk_pengampu_assesment' => $kk_pengampu,
                            'pendidikan_terakhir_pengampu_assesment' => $pendidikan_terakhir_pengampu,
                            'status_kawin_pengampu_assesment' => $status_kawin_pengampu,
                            'pekerjaan_pengampu_assesment' => $pekerjaan_pengampu,
                            'dtks_pengampu_assesment' => $dtks_pengampu,
                            'bansos_pengampu_assesment' => json_encode($bansosPengampu),
                            'pengeluaran_perbulan_pengampu_assesment' => $pengeluaran_perbulan_pengampu,
                            'kategori_ppks' => $kategori_ppks,
                            'kondisi_fisik_ppks' => $kondisi_fisik_ppks,
                            'detail_kondisi_fisik_ppks' => $detail_kondisi_fisik_ppks,
                            'penghasilan_ekonomi' => $penghasilan_ekonomi,
                            'penghasilan_makan_ekonomi' => $penghasilan_makan_ekonomi,
                            'makan_ekonomi' => $makan_ekonomi,
                            'kemampuan_pakaian_ekonomi' => $kemampuan_pakaian_ekonomi,
                            'tempat_tinggal_ekonomi' => $tempat_tinggal_ekonomi,
                            'tinggal_bersama_ekonomi' => $tinggal_bersama_ekonomi,
                            'luas_lantai_ekonomi' => $luas_lantai_ekonomi,
                            'jenis_lantai_ekonomi' => $jenis_lantai_ekonomi,
                            'jenis_dinding_ekonomi' => $jenis_dinding_ekonomi,
                            'jenis_atap_ekonomi' => $jenis_atap_ekonomi,
                            'milik_wc_ekonomi' => $milik_wc_ekonomi,
                            'jenis_wc_ekonomi' => $jenis_wc_ekonomi,
                            'penerangan_ekonomi' => $penerangan_ekonomi,
                            'sumber_air_minum_ekonomi' => $sumber_air_minum_ekonomi,
                            'bahan_bakar_masak_ekonomi' => $bahan_bakar_masak_ekonomi,
                            'berobat_ekonomi' => $berobat_ekonomi,
                            'rata_pendidikan_ekonomi' => $rata_pendidikan_ekonomi,
                            'catatan_tambahan' => $catatan_tambahan,
                            'lampiran' => $lampiran,
                            'skor_assesment' => json_encode($skor_assesment),
                            'skor_total' => $skor_total,
                            'created_at' => $date,
                        ];

                        $this->_db->table('_data_assesment')->insert($dataAssesment);
                        if ($this->_db->affectedRows() > 0) {
                            $riwayatLib = new Riwayatpengaduanlib();
                            try {
                                $riwayatLib->create($user->data->id, "Mengassesment pengaduan: " . $oldData->kode_aduan . ", dengan skor Nilai $skor_total, dan dengan saran tindaklanjut $saran_tindak_lanjut", "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $oldData->id, $oldData->id);
                            } catch (\Throwable $th) {
                            }
                            try {
                                $generateDokumen = $this->_download($user, $tgl_assesment, $dataTindakLanjut, $dataAssesment, $bansosIdentitas, $bansosPengampu, $skor_assesment, $skor_total, $oldData, $kepersertaan_bansos, $lampiran);

                                if ($generateDokumen->status !== 200) {
                                    if ($filenamelampiranktp != '') {
                                        unlink($dir . '/' . $newNamelampiranktp);
                                    }
                                    if ($filenamelampirankk != '') {
                                        unlink($dir . '/' . $newNamelampirankk);
                                    }
                                    if ($filenamelampiranrumah_depan != '') {
                                        unlink($dir . '/' . $newNamelampiranrumah_depan);
                                    }
                                    if ($filenamelampiranrumah_kiri != '') {
                                        unlink($dir . '/' . $newNamelampiranrumah_kiri);
                                    }
                                    if ($filenamelampiranrumah_kanan != '') {
                                        unlink($dir . '/' . $newNamelampiranrumah_kanan);
                                    }
                                    if ($filenamelampiranrumah_belakang != '') {
                                        unlink($dir . '/' . $newNamelampiranrumah_belakang);
                                    }

                                    $this->_db->transRollback();
                                    $response = new \stdClass;
                                    $response->status = 400;
                                    $response->eror = $generateDokumen->message;
                                    $response->message = "1. Gagal mengassesment aduan " . $oldData->kode_aduan;
                                    return json_encode($response);
                                } else {
                                    $this->_db->transCommit();
                                    $response = new \stdClass;
                                    $response->status = 200;
                                    $response->redirrect = base_url('silastri/peksos/pengaduan/antrian');
                                    $response->filenya = base_url('upload/generate/surat/pdf') . '/' . $generateDokumen->filename;
                                    $response->filename = $generateDokumen->filename;
                                    $response->message = "Assesment Aduan " . $oldData->kode_aduan . " berhasil disimpan.";
                                    return json_encode($response);
                                }
                            } catch (\Throwable $th) {
                                if ($filenamelampiranktp != '') {
                                    unlink($dir . '/' . $newNamelampiranktp);
                                }
                                if ($filenamelampirankk != '') {
                                    unlink($dir . '/' . $newNamelampirankk);
                                }
                                if ($filenamelampiranrumah_depan != '') {
                                    unlink($dir . '/' . $newNamelampiranrumah_depan);
                                }
                                if ($filenamelampiranrumah_kiri != '') {
                                    unlink($dir . '/' . $newNamelampiranrumah_kiri);
                                }
                                if ($filenamelampiranrumah_kanan != '') {
                                    unlink($dir . '/' . $newNamelampiranrumah_kanan);
                                }
                                if ($filenamelampiranrumah_belakang != '') {
                                    unlink($dir . '/' . $newNamelampiranrumah_belakang);
                                }
                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->eror = var_dump($th);
                                $response->message = "1. Gagal mengassesment aduan " . $oldData->kode_aduan;
                                return json_encode($response);
                            }
                            // $this->_db->transCommit();
                            // $response = new \stdClass;
                            // $response->status = 200;
                            // $response->redirrect = base_url('silastri/peksos/pengaduan/antrian');
                            // $response->id = $oldData->id;
                            // // $response->filenya = base_url('upload/generate/surat/pdf') . '/' . $generateDokumen->filename;
                            // // $response->filename = $$generateDokumen->filename;
                            // $response->message = "Assesment Aduan " . $oldData->kode_aduan . " berhasil disimpan.";
                            // return json_encode($response);
                        } else {
                            if ($filenamelampiranktp != '') {
                                unlink($dir . '/' . $newNamelampiranktp);
                            }
                            if ($filenamelampirankk != '') {
                                unlink($dir . '/' . $newNamelampirankk);
                            }
                            if ($filenamelampiranrumah_depan != '') {
                                unlink($dir . '/' . $newNamelampiranrumah_depan);
                            }
                            if ($filenamelampiranrumah_kiri != '') {
                                unlink($dir . '/' . $newNamelampiranrumah_kiri);
                            }
                            if ($filenamelampiranrumah_kanan != '') {
                                unlink($dir . '/' . $newNamelampiranrumah_kanan);
                            }
                            if ($filenamelampiranrumah_belakang != '') {
                                unlink($dir . '/' . $newNamelampiranrumah_belakang);
                            }
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "2. Gagal mengassesment aduan " . $oldData->kode_aduan;
                            return json_encode($response);
                        }
                    } else {
                        if ($filenamelampiranktp != '') {
                            unlink($dir . '/' . $newNamelampiranktp);
                        }
                        if ($filenamelampirankk != '') {
                            unlink($dir . '/' . $newNamelampirankk);
                        }
                        if ($filenamelampiranrumah_depan != '') {
                            unlink($dir . '/' . $newNamelampiranrumah_depan);
                        }
                        if ($filenamelampiranrumah_kiri != '') {
                            unlink($dir . '/' . $newNamelampiranrumah_kiri);
                        }
                        if ($filenamelampiranrumah_kanan != '') {
                            unlink($dir . '/' . $newNamelampiranrumah_kanan);
                        }
                        if ($filenamelampiranrumah_belakang != '') {
                            unlink($dir . '/' . $newNamelampiranrumah_belakang);
                        }
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "3. Gagal mengassesment aduan " . $oldData->kode_aduan;
                        return json_encode($response);
                    }
                } else {
                    if ($filenamelampiranktp != '') {
                        unlink($dir . '/' . $newNamelampiranktp);
                    }
                    if ($filenamelampirankk != '') {
                        unlink($dir . '/' . $newNamelampirankk);
                    }
                    if ($filenamelampiranrumah_depan != '') {
                        unlink($dir . '/' . $newNamelampiranrumah_depan);
                    }
                    if ($filenamelampiranrumah_kiri != '') {
                        unlink($dir . '/' . $newNamelampiranrumah_kiri);
                    }
                    if ($filenamelampiranrumah_kanan != '') {
                        unlink($dir . '/' . $newNamelampiranrumah_kanan);
                    }
                    if ($filenamelampiranrumah_belakang != '') {
                        unlink($dir . '/' . $newNamelampiranrumah_belakang);
                    }
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "4. Gagal mengassesment aduan " . $oldData->kode_aduan;
                    return json_encode($response);
                }
            } else {
                if ($filenamelampiranktp != '') {
                    unlink($dir . '/' . $newNamelampiranktp);
                }
                if ($filenamelampirankk != '') {
                    unlink($dir . '/' . $newNamelampirankk);
                }
                if ($filenamelampiranrumah_depan != '') {
                    unlink($dir . '/' . $newNamelampiranrumah_depan);
                }
                if ($filenamelampiranrumah_kiri != '') {
                    unlink($dir . '/' . $newNamelampiranrumah_kiri);
                }
                if ($filenamelampiranrumah_kanan != '') {
                    unlink($dir . '/' . $newNamelampiranrumah_kanan);
                }
                if ($filenamelampiranrumah_belakang != '') {
                    unlink($dir . '/' . $newNamelampiranrumah_belakang);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "5. Gagal mengassesment aduan " . $oldData->kode_aduan;
                return json_encode($response);
            }
        }
    }

    private function _download($user, $tgl_assesment, $dataTindakLanjut, $dataAssesment, $bansosIdentitas, $bansosPengampu, $skor_assesment, $skor_total, $oldData, $kepersertaan_bansos, $lampiran = "")
    {
        $file = FCPATH . "upload/template/nota-assesment.docx";
        $template_processor = new TemplateProcessor($file);
        $template_processor->setValue('NAMA_PETUGAS_ASSESMENT', $user->data->fullname);
        $template_processor->setValue('TGL_ASSESMENT', tgl_indo($tgl_assesment));

        $tembusan = "";
        if ($dataTindakLanjut['tembusan_dinas'] !== NULL) {
            $tembusan   .= '1. Kepala Dinas ' . getNamaDinas($dataTindakLanjut['tembusan_dinas']) . '<br/>';
            if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                $tembusan   .= '\n2. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                    $tembusan   .= '\n3. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                    $tembusan .= '\n4. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                } else {
                    $tembusan .= '\n3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                }
            } else {
                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                    $tembusan   .= '\n2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                } else {
                    $tembusan .= '\n2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                }
            }
        } else {
            if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
                $tembusan   .= '1. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                    $tembusan   .= '\n2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                    $tembusan .= '\n3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                } else {
                    $tembusan .= '\n2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                }
            } else {
                if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
                    $tembusan   .= '1. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
                    $tembusan .= '\n2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                } else {
                    $tembusan .= '1. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
                }
            }
        }

        $template_processor->setValue('TEMBUSAN', $tembusan);
        $template_processor->setValue('NAMA_PPKS', $dataAssesment['nama_orang_assesment']);
        $template_processor->setValue('KODE_PENGADUAN', $oldData->kode_aduan);
        $template_processor->setValue('TGL_PENGADUAN', tgl_hari_indo($oldData->created_at));
        $template_processor->setValue('MEDIA_PENGADUAN', $oldData->media_pengaduan);
        $template_processor->setValue('NAMA_PENGADU', ucwords($oldData->nama));
        $template_processor->setValue('NIK_PENGADU', $oldData->nik);
        $template_processor->setValue('NOHP_PENGADU', $oldData->nohp);
        $template_processor->setValue('ALAMAT_PENGADU', $oldData->alamat);
        $template_processor->setValue('KECAMATAN_PENGADU', getNamaKecamatan($oldData->kecamatan));
        $template_processor->setValue('KELURAHAN_PENGADU', getNamaKelurahan($oldData->kelurahan));
        $template_processor->setValue('NAMA_ADUAN', ucwords($dataAssesment['nama_orang_assesment']));
        $template_processor->setValue('NIK_ADUAN', $dataAssesment['nik_orang_assesment']);
        $template_processor->setValue('NOHP_ADUAN', '-');
        $template_processor->setValue('ALAMAT_ADUAN', $dataAssesment['alamat_domisili_orang_assesment']);
        $template_processor->setValue('KECAMATAN_ADUAN', getNamaKecamatan($dataAssesment['kecamatan_domisili_orang_assesment']));
        $template_processor->setValue('KELURAHAN_ADUAN', getNamaKelurahan($dataAssesment['kelurahan_domisili_orang_assesment']));
        $template_processor->setValue('KATEGORI_PPKS', getNameKategoriPPKS($dataAssesment['kategori_ppks']));

        $kepersertaan_bansos_fix = [];
        foreach ($kepersertaan_bansos as $key => $v) {
            $kepersertaan_bansos_fix[] = [
                'NKB' => $key + 1,
                'NAMA_KB' => ucwords($v['nama_anggota']),
                'NIK_KB' => $v['nik_anggota'],
                'DTKS_KB' => ucwords($v['dtks']),
                'PKH_KB' => ucwords($v['pkh']),
                'BPNT_KB' => ucwords($v['bpnt']),
                'PBI_KB' => ucwords($v['pbi_jk']),
                'RST_KB' => ucwords($v['rst']),
                'LAIN_KB' => ucwords($v['bansos_lain']),
                'KET_KB' => $v['keterangan_anggota'],
            ];
        }
        $template_processor->cloneRowAndSetValues('NKB', $kepersertaan_bansos_fix);

        $template_processor->setValue('GAMBARAN_KASUS', $dataTindakLanjut['gambaran_kasus']);
        $template_processor->setValue('DETAIL_KONDISI_FISIK_PPKS', $dataAssesment['detail_kondisi_fisik_ppks']);
        $template_processor->setValue('KONDISI_PEREKONOMIAN', $dataTindakLanjut['kondisi_perekonomian_keluarga']);
        $template_processor->setValue('PERMASALAHAN', $dataTindakLanjut['permasalahan']);
        $template_processor->setValue('IDENTIFIKASI_KEBUTUHAN', $dataTindakLanjut['identifikasi_kebutuhan']);
        $template_processor->setValue('INTERVENSI_YANG_TELAH_DILAKUKAN', $dataTindakLanjut['intervensi_telah_dilakukan']);
        $template_processor->setValue('SARAN_TINDAK_LANJUT', $dataTindakLanjut['saran_tindaklanjut']);
        $petugasTerlibat = "";
        $petugasTerlibat .= "1. " . ucwords($oldData->nama);

        $template_processor->setValue('PETUGAS_TERLIBAT', $petugasTerlibat);
        $template_processor->setValue('NAMA_PETUGAS_ASSESMENT', $user->data->fullname);

        $template_processor->setValue('NOMOR_ASSESMENT', $dataAssesment['kode_assesment']);
        $template_processor->setValue('SATUAN_KERJA_PETUGAS', "Dinas Sosial");
        $template_processor->setValue('KECAMATAN_KTP', getNamaKecamatan($dataAssesment['kabupaten_ktp_orang_assesment']));
        $template_processor->setValue('KELURAHAN_KTP', getNamaKelurahan($dataAssesment['kelurahan_ktp_orang_assesment']));
        $template_processor->setValue('ALAMAT_KTP', $dataAssesment['alamat_ktp_orang_assesment']);
        $template_processor->setValue('PROVINSI_DOMISILI', $dataAssesment['provinsi_domisili_orang_assesment']);
        $template_processor->setValue('KABUPATEN_DOMISILI', $dataAssesment['kabupaten_domisili_orang_assesment']);
        $template_processor->setValue('KECAMATAN_DOMISILI', getNamaKecamatan($dataAssesment['kabupaten_domisili_orang_assesment']));
        $template_processor->setValue('KELURAHAN_DOMISILI', getNamaKelurahan($dataAssesment['kelurahan_domisili_orang_assesment']));
        $template_processor->setValue('ALAMAT_DOMISILI', $dataAssesment['alamat_domisili_orang_assesment']);
        $template_processor->setValue('NAMA_PPKS', ucwords($dataAssesment['nama_orang_assesment']));
        $template_processor->setValue('TEMPAT_LAHIR_PPKS', ucwords($dataAssesment['tempat_lahir_orang_assesment']));
        $template_processor->setValue('TGL_LAHIR_PPKS', tgl_indo($dataAssesment['tgl_lahir_orang_assesment']));
        $template_processor->setValue('JK_PPKS', $dataAssesment['jk_orang_assesment']);
        $template_processor->setValue('AGAMA_PPKS', $dataAssesment['agama_orang_assesment']);
        $template_processor->setValue('NIK_PPKS', $dataAssesment['nik_orang_assesment']);
        $template_processor->setValue('KK_PPKS', $dataAssesment['kk_orang_assesment']);
        $template_processor->setValue('NO_AKTA_PPKS', $dataAssesment['akta_orang_assesment']);
        $template_processor->setValue('PENDIDIKAN_PPKS', $dataAssesment['pendidikan_terakhir_orang_assesment']);
        $template_processor->setValue('STATUS_KAWIN_PPKS', $dataAssesment['status_kawin_orang_assesment']);
        $template_processor->setValue('DTKS_PPKS', $dataAssesment['dtks_orang_assesment']);

        if (count($bansosIdentitas) > 0) {
            $bansosIdentitasFix = [];
            foreach ($bansosIdentitas as $keyB => $vb) {
                $bansosIdentitasFix[] = [
                    'NB' => $keyB + 1,
                    'WAKTU' => $vb['waktu_bansos'],
                    'NAMA_BANSOS' => $vb['nama_bansos'],
                    'JML_BAN' => $vb['jumlah_bansos'],
                    'SAT_BAN' => $vb['satuan_bansos'],
                    'SMB_DN' => $vb['sumber_anggaran_bansos'],
                    'KET' => $vb['keterangan_bansos'],
                ];
            }
            $template_processor->cloneRowAndSetValues('NB', $bansosIdentitasFix);
        }

        if ($dataAssesment['nama_pengampu_assesment'] == "" || $dataAssesment['nama_pengampu_assesment'] == NULL) {
        } else {
            $template_processor->setValue('NAMA_PENGAMPU', $dataAssesment['nama_pengampu_assesment']);
            $template_processor->setValue('NOHP_PENGAMPU', $dataAssesment['nohp_pengampu_assesment']);
            $template_processor->setValue('HUBUNGAN_PENGAMPU', $dataAssesment['hubungan_pengampu_assesment']);
            $template_processor->setValue('TEMPAT_LAHIR_PENGAMPU', $dataAssesment['tempat_lahir_pengampu_assesment']);
            $template_processor->setValue('TGL_LAHIR_PENGAMPU', tgl_indo($dataAssesment['tgl_lahir_pengampu_assesment']));
            $template_processor->setValue('JK_PENGAMPU', $dataAssesment['jk_pengampu_assesment']);
            $template_processor->setValue('AGAMA_PENGAMPU', $dataAssesment['agama_pengampu_assesment']);
            $template_processor->setValue('NIK_PENGAMPU', $dataAssesment['nik_pengampu_assesment']);
            $template_processor->setValue('KK_PENGAMPU', $dataAssesment['kk_pengampu_assesment']);
            $template_processor->setValue('PENDIDIKAN_PENGAMPU', $dataAssesment['pendidikan_terakhir_pengampu_assesment']);
            $template_processor->setValue('STATUS_KAWIN_PENGAMPU', $dataAssesment['status_kawin_pengampu_assesment']);
            $template_processor->setValue('PEKERJAAN_PENGAMPU', $dataAssesment['pekerjaan_pengampu_assesment']);
            $template_processor->setValue('PENGELUARAN_PER_BULAN_PENGAMPU', $dataAssesment['pengeluaran_perbulan_pengampu_assesment']);
            $template_processor->setValue('DTKS_PENGAMPU', $dataAssesment['dtks_pengampu_assesment']);

            if (count($bansosPengampu) > 0) {
                $bansosPengampuFix = [];
                foreach ($bansosPengampu as $keyP => $vp) {
                    $bansosPengampuFix[] = [
                        'NP' => $keyP + 1,
                        'NAMA_BANSOS_PENGAMPU' => $vp['nama_bansos'],
                        'TAHUN_PENGAMPU' => $vp['tahun_bansos'],
                    ];
                }
                $template_processor->cloneRowAndSetValues('NP', $bansosPengampuFix);
            }
        }

        $template_processor->setValue('KONDISI_FISIK_PPKS', $dataAssesment['kondisi_fisik_ppks']);
        $template_processor->setValue('RATA_PENGHASILAN_E', getNamePenghasilanEkonomi($dataAssesment['penghasilan_ekonomi']));
        $template_processor->setValue('PENGHASILAN_MAKAN_E', getNamePenghasilanMakanEkonomi($dataAssesment['penghasilan_makan_ekonomi']));
        $template_processor->setValue('MAKAN_E', getNameMakanEkonomi($dataAssesment['makan_ekonomi']));
        $template_processor->setValue('PAKAIAN_E', getNameKemampuanPakaianEkonomi($dataAssesment['kemampuan_pakaian_ekonomi']));
        $template_processor->setValue('TEMPAT_TINGGAL_E', getNameTempatTinggalEkonomi($dataAssesment['tempat_tinggal_ekonomi']));
        $template_processor->setValue('TEMPAT_BERSAMA_E', $dataAssesment['tinggal_bersama_ekonomi']);
        $template_processor->setValue('LUAS_LANTAI_E', getNameLuasLantaiEkonomi($dataAssesment['luas_lantai_ekonomi']));
        $template_processor->setValue('JENIS_LANTAI_E', getNameJenisLantaiEkonomi($dataAssesment['jenis_lantai_ekonomi']));
        $template_processor->setValue('JENIS_DINDING_E', getNameJenisDindingEkonomi($dataAssesment['jenis_dinding_ekonomi']));
        $template_processor->setValue('JENIS_ATAP_E', getNameJenisAtapEkonomi($dataAssesment['jenis_atap_ekonomi']));
        $template_processor->setValue('MILIK_WC_E', getNameMilikWcEkonomi($dataAssesment['milik_wc_ekonomi']));
        $template_processor->setValue('JENIS_WC_E', getNameJenisWcEkonomi($dataAssesment['jenis_wc_ekonomi']));
        $template_processor->setValue('LISTRIK_E', getNamePeneranganEkonomi($dataAssesment['penerangan_ekonomi']));
        $template_processor->setValue('SUMBER_AIR_E', getNameSumberAirMinumEkonomi($dataAssesment['sumber_air_minum_ekonomi']));
        $template_processor->setValue('BAHAN_BAKAR_E', getNameBahanBakarMasakEkonomi($dataAssesment['bahan_bakar_masak_ekonomi']));
        $template_processor->setValue('BEROBAT_E', getNameBerobatEkonomi($dataAssesment['berobat_ekonomi']));
        $template_processor->setValue('RATA_PENDIDIKAN_E', getNameRataPendidikanEkonomi($dataAssesment['rata_pendidikan_ekonomi']));
        $template_processor->setValue('JUMLAH_SKOR', $skor_total);
        $template_processor->setValue('1', $skor_assesment['penghasilan']);
        $template_processor->setValue('2', $skor_assesment['penghasilan_makan']);
        $template_processor->setValue('3', $skor_assesment['makan']);
        $template_processor->setValue('4', $skor_assesment['kemampuan_pakaian']);
        $template_processor->setValue('5', $skor_assesment['tempat_tinggal']);
        $template_processor->setValue('6', '');
        $template_processor->setValue('7', $skor_assesment['luas_lantai']);
        $template_processor->setValue('8', $skor_assesment['jenis_lantai']);
        $template_processor->setValue('9', $skor_assesment['jenis_dinding']);
        $template_processor->setValue('10', $skor_assesment['jenis_atap']);
        $template_processor->setValue('11', $skor_assesment['milik_wc']);
        $template_processor->setValue('12', $skor_assesment['jenis_wc']);
        $template_processor->setValue('13', $skor_assesment['penerangan']);
        $template_processor->setValue('14', $skor_assesment['sumber_air_minum']);
        $template_processor->setValue('15', $skor_assesment['bahan_bakar_masak']);
        $template_processor->setValue('16', $skor_assesment['berobat']);
        $template_processor->setValue('17', $skor_assesment['rata_pendidikan']);

        $fileLampiran = explode(";", $lampiran);
        if (count($fileLampiran) > 0) {
            $template_processor->setImageValue('FOTO_PPKS', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[0], 'width' => 100, 'height' => 100, 'ratio' => true));
        }
        if (count($fileLampiran) > 1) {
            $template_processor->setImageValue('RUMAH_1', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[1], 'width' => 100, 'height' => 100, 'ratio' => true));
        }
        if (count($fileLampiran) > 2) {
            $template_processor->setImageValue('RUMAH_2', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[2], 'width' => 100, 'height' => 100, 'ratio' => true));
        }
        if (count($fileLampiran) > 3) {
            $template_processor->setImageValue('RUMAH_3', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[3], 'width' => 100, 'height' => 100, 'ratio' => true));
        }
        if (count($fileLampiran) > 4) {
            $template_processor->setImageValue('RUMAH_4', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[4], 'width' => 100, 'height' => 100, 'ratio' => true));
        }
        if (count($fileLampiran) > 5) {
            $template_processor->setImageValue('ASSET', array('path' => FCPATH . './uploads/assesment/lampiran/' . $fileLampiran[5], 'width' => 100, 'height' => 100, 'ratio' => true));
        }

        $template_processor->setImageValue('QR_CODE_NOTA', array('path' => 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData->kode_aduan . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));
        $template_processor->setImageValue('QR_CODE_ASSESMENT', array('path' => 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $dataAssesment['kode_assesment'] . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));

        $filed = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";

        $template_processor->saveAs($filed);

        sleep(3);

        $datas = [
            'nama_file' => $dataAssesment['kode_assesment'] . '.docx',
            'file_folder' => $filed,
        ];

        $curlHandle = curl_init("http://10.20.30.99:1890/convert");
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            // 'X-API-TOKEN: ' . $apiToken,
            // 'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 120);

        $send_data         = curl_exec($curlHandle);

        $result = json_decode($send_data);


        if (isset($result->error)) {
            try {
                unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
            } catch (\Throwable $th) {
                //throw $th;
            }
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mengenerate dokumen.";
            return $response;
        }

        if ($result) {
            if ($result->status == 200) {
                $response = new \stdClass;
                $response->status = 200;
                $response->result = $result;
                $response->dir = FCPATH . "upload/generate/surat/pdf/" . $dataAssesment['kode_assesment'] . ".pdf";
                $response->dir_temp = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";
                $response->filename = $dataAssesment['kode_assesment'] . ".pdf";
                return $response;
            } else {
                try {
                    unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $result->message;
                // $response->message = "Gagal mengenerate dokumen.";
                return $response;
            }
            // return $result;
        } else {
            try {
                unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
            } catch (\Throwable $th) {
                //throw $th;
            }
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mengenerate dokumen.";
            return $response;
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


    // public function simpanassesment()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         '_id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nama' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Nama tidak boleh kosong. ',
    //             ]
    //         ],
    //         // '_gambaran_kasus' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Gambaran kasus tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_kondisi_kesehatan' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Kondisi kesehatan tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_kondisi_perekonomian_keluarga' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Kondisi perekonomian keluarga tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_permasalahan' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Permasalahan tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_identifikasi_kebutuhan' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Identifikasi kebutuhan tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_intervensi_telah_dilakukan' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Interversi yang telah dilakukan tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // '_saran_tindak_lanjut' => [
    //         //     'rules' => 'required|trim',
    //         //     'errors' => [
    //         //         'required' => 'Saran / rencana tindak lanjut tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         '_id_petugas_assesment' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Petugas assesment tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tgl_asessment' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tanggal assesment tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_provinsi_ktp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Provinsi KTP tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kabupaten_ktp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kabupaten KTP tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kecamatan_ktp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'kecamatan KTP tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kelurahan_ktp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'kelurahan KTP tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_alamat_ktp' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'alamat KTP tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_provinsi_domisili' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Provinsi domisili tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kabupaten_domisili' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kabupaten domisili tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kecamatan_domisili' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'kecamatan domisili tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kelurahan_domisili' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'kelurahan domisili tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_alamat_domisili' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'alamat domisili tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nama_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Nama PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tempat_lahir_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tempat lahir PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tgl_lahir_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tanggal lahir PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_kelamin_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis kelamin PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_agama_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Agama PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nik_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'NIK PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kk_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'KK PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_akta_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Akta PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_dtks_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'PPKS sudah masuk DTKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         // 'waktu_bansos_identitas.*' => [
    //         //     'rules' => 'required',
    //         //     'errors' => [
    //         //         'required' => 'NIK pemilik bansos tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // 'nama_pemilik_bansos.*' => [
    //         //     'rules' => 'required',
    //         //     'errors' => [
    //         //         'required' => 'Nama pemilik bansos tidak boleh kosong. ',
    //         //     ]
    //         // ],
    //         // 'jumlah_bansos_identitas.*' => [
    //         //     'rules' => 'required',
    //         //     'errors' => [
    //         //         'required' => 'Keterangan pemilik bansos tidak boleh kosong. ',
    //         //     ]
    //         // ],

    //         '_pendidikan_terakhir_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Pendidikan terakhir PPKS ke tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_status_kawin_identitas' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Status kawin PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nama_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Nama pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nohp_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'No hp pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_hubungan_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Hubungan pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tempat_lahir_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tempat lahir pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tgl_lahir_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tanggal lahir pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_kelamin_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis kelamin pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_agama_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Agama pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_nik_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'NIK pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kk_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'KK pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_dtks_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Pengampu PPKS sudah masuk DTKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_pendidikan_terakhir_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Pendidikan terakhir pengampu PPKS ke tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_status_kawin_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Status kawin pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_pekerjaan_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Pekerjaan pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_pengeluaran_perbulan_pengampu' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Pengeluaran perbulan pengampu PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kategori_ppks' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kategori PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kondisi_fisik_ppks' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kondisi fisik PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_detail_kondisi_fisik_ppks' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Penjelasan kondisi fisik PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_penghasilan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Penghasilan PPKS perbulan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_penghasilan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Penghasilan PPKS perbulan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_penghasilan_makan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Penghasilan dan makan PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_makan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Makan dalam sehari PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kemampuan_pakaian_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kemampuan membeli pakaian dalam setahun PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tempat_tinggal_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_tinggal_bersama_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'PPKS tinggal bersama tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_luas_lantai_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Luas lantai tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_lantai_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis lantai tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_dinding_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis dinding tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_atap_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis atap tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_milik_wc_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Memiliki WC pada tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_jenis_wc_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis WC pada tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_penerangan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Sumber penerangan pada tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_sumber_air_minum_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Sumber air minum pada tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_bahan_bakar_masak_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Bahan bakar memasak pada tempat tinggal PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_berobat_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kemampuan berobat PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_rata_pendidikan_ekonomi' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Rata-rata pendidikan pada keluarga PPKS tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_catatan_tambahan' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Catatan tambahan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_gambaran_kasus' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Gambaran kasus tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kondisi_kesehatan' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kondisi perekonomian keluarga tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_kondisi_perekonomian_keluarga' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kondisi perekonomian keluarga tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_permasalahan' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Permasalahan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_identifikasi_kebutuhan' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Identifikasi kebutuhan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_intervensi_telah_dilakukan' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Intervensi yang telah dilakukan tidak boleh kosong. ',
    //             ]
    //         ],
    //         '_saran_tindak_lanjut' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Saran / Rencana tindak lanjut tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     $filenamelampiranktp = dot_array_search('_file_ktp.name', $_FILES);
    //     if ($filenamelampiranktp != '') {
    //         $lampiranValKtp = [
    //             '_file_ktp' => [
    //                 'rules' => 'uploaded[_file_ktp]|max_size[_file_ktp,2048]|mime_in[_file_ktp,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValKtp);
    //     }

    //     $filenamelampirankk = dot_array_search('_file_kk.name', $_FILES);
    //     if ($filenamelampirankk != '') {
    //         $lampiranValkk = [
    //             '_file_kk' => [
    //                 'rules' => 'uploaded[_file_kk]|max_size[_file_kk,2048]|mime_in[_file_kk,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValkk);
    //     }

    //     $filenamelampiranrumah_depan = dot_array_search('_file_rumah_depan.name', $_FILES);
    //     if ($filenamelampiranrumah_depan != '') {
    //         $lampiranValrumah_depan = [
    //             '_file_rumah_depan' => [
    //                 'rules' => 'uploaded[_file_rumah_depan]|max_size[_file_rumah_depan,2048]|mime_in[_file_rumah_depan,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValrumah_depan);
    //     }

    //     $filenamelampiranrumah_kiri = dot_array_search('_file_rumah_kiri.name', $_FILES);
    //     if ($filenamelampiranrumah_kiri != '') {
    //         $lampiranValrumah_kiri = [
    //             '_file_rumah_kiri' => [
    //                 'rules' => 'uploaded[_file_rumah_kiri]|max_size[_file_rumah_kiri,2048]|mime_in[_file_rumah_kiri,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValrumah_kiri);
    //     }

    //     $filenamelampiranrumah_kanan = dot_array_search('_file_rumah_kanan.name', $_FILES);
    //     if ($filenamelampiranrumah_kanan != '') {
    //         $lampiranValrumah_kanan = [
    //             '_file_rumah_kanan' => [
    //                 'rules' => 'uploaded[_file_rumah_kanan]|max_size[_file_rumah_kanan,2048]|mime_in[_file_rumah_kanan,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValrumah_kanan);
    //     }

    //     $filenamelampiranrumah_belakang = dot_array_search('_file_rumah_belakang.name', $_FILES);
    //     if ($filenamelampiranrumah_belakang != '') {
    //         $lampiranValrumah_belakang = [
    //             '_file_rumah_belakang' => [
    //                 'rules' => 'uploaded[_file_rumah_belakang]|max_size[_file_rumah_belakang,2048]|mime_in[_file_rumah_belakang,image/jpeg,image/jpg,image/png]',
    //                 'errors' => [
    //                     'uploaded' => 'Pilih lampiran dokumen terlebih dahulu. ',
    //                     'max_size' => 'Ukuran lampiran dokumen terlalu besar. ',
    //                     'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
    //                 ]
    //             ],
    //         ];
    //         $rules = array_merge($rules, $lampiranValrumah_belakang);
    //     }


    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         // $response->message = "Silahkan lengkapi isian wajib.";
    //         $response->message =
    //             $this->validator->getError('_id')
    //             . $this->validator->getError('_nama')
    //             . $this->validator->getError('_id_petugas_assesment')
    //             . $this->validator->getError('_tgl_asessment')
    //             . $this->validator->getError('_provinsi_ktp')
    //             . $this->validator->getError('_kabupaten_ktp')
    //             . $this->validator->getError('_kecamatan_ktp')
    //             . $this->validator->getError('_kelurahan_ktp')
    //             . $this->validator->getError('_alamat_ktp')
    //             . $this->validator->getError('_provinsi_domisili')
    //             . $this->validator->getError('_kabupaten_domisili')
    //             . $this->validator->getError('_kecamatan_domisili')
    //             . $this->validator->getError('_kelurahan_domisili')
    //             . $this->validator->getError('_alamat_domisili')
    //             . $this->validator->getError('_nama_identitas')
    //             . $this->validator->getError('_tempat_lahir_identitas')
    //             . $this->validator->getError('_tgl_lahir_identitas')
    //             . $this->validator->getError('_jenis_kelamin_identitas')
    //             . $this->validator->getError('_agama_identitas')
    //             . $this->validator->getError('_nik_identitas')
    //             . $this->validator->getError('_kk_identitas')
    //             . $this->validator->getError('_akta_identitas')
    //             . $this->validator->getError('_dtks_identitas')
    //             . $this->validator->getError('_pendidikan_terakhir_identitas')
    //             . $this->validator->getError('_status_kawin_identitas')
    //             . $this->validator->getError('_nama_pengampu')
    //             . $this->validator->getError('_nohp_pengampu')
    //             . $this->validator->getError('_hubungan_pengampu')
    //             . $this->validator->getError('_tempat_lahir_pengampu')
    //             . $this->validator->getError('_tgl_lahir_pengampu')
    //             . $this->validator->getError('_jenis_kelamin_pengampu')
    //             . $this->validator->getError('_agama_pengampu')
    //             . $this->validator->getError('_nik_pengampu')
    //             . $this->validator->getError('_kk_pengampu')
    //             . $this->validator->getError('_dtks_pengampu')
    //             . $this->validator->getError('_pendidikan_terakhir_pengampu')
    //             . $this->validator->getError('_status_kawin_pengampu')
    //             . $this->validator->getError('_pekerjaan_pengampu')
    //             . $this->validator->getError('_pengeluaran_perbulan_pengampu')
    //             . $this->validator->getError('_kategori_ppks')
    //             . $this->validator->getError('_kondisi_fisik_ppks')
    //             . $this->validator->getError('_detail_kondisi_fisik_ppks')
    //             . $this->validator->getError('_penghasilan_ekonomi')
    //             . $this->validator->getError('_penghasilan_makan_ekonomi')
    //             . $this->validator->getError('_makan_ekonomi')
    //             . $this->validator->getError('_kemampuan_pakaian_ekonomi')
    //             . $this->validator->getError('_tempat_tinggal_ekonomi')
    //             . $this->validator->getError('_tinggal_bersama_ekonomi')
    //             . $this->validator->getError('_luas_lantai_ekonomi')
    //             . $this->validator->getError('_jenis_lantai_ekonomi')
    //             . $this->validator->getError('_jenis_dinding_ekonomi')
    //             . $this->validator->getError('_jenis_atap_ekonomi')
    //             . $this->validator->getError('_milik_wc_ekonomi')
    //             . $this->validator->getError('_jenis_wc_ekonomi')
    //             . $this->validator->getError('_penerangan_ekonomi')
    //             . $this->validator->getError('_sumber_air_minum_ekonomi')
    //             . $this->validator->getError('_bahan_bakar_masak_ekonomi')
    //             . $this->validator->getError('_berobat_ekonomi')
    //             . $this->validator->getError('_rata_pendidikan_ekonomi')
    //             . $this->validator->getError('_catatan_tambahan')
    //             . $this->validator->getError('_gambaran_kasus')
    //             . $this->validator->getError('_kondisi_kesehatan')
    //             . $this->validator->getError('_permasalahan')
    //             . $this->validator->getError('_identifikasi_kebutuhan')
    //             . $this->validator->getError('_intervensi_telah_dilakukan')
    //             . $this->validator->getError('_saran_tindak_lanjut');
    //         return json_encode($response);
    //     } else {
    //         $namesBansosIdentitas = $this->request->getVar('nama_bansos_identitas');
    //         $waktu_bansos_identitas = $this->request->getVar('waktu_bansos_identitas');
    //         $jumlah_bansos_identitas = $this->request->getVar('jumlah_bansos_identitas');
    //         $satuan_bansos_identitas = $this->request->getVar('satuan_bansos_identitas');
    //         $sumber_anggaran_identitas = $this->request->getVar('sumber_anggaran_identitas');
    //         $keterangan_identitas = $this->request->getVar('keterangan_identitas');

    //         $Profilelib = new Profilelib();
    //         $user = $Profilelib->user();
    //         if ($user->status != 200) {
    //             delete_cookie('jwt');
    //             session()->destroy();
    //             $response = new \stdClass;
    //             $response->status = 401;
    //             $response->message = "Session telah habis";
    //             $response->redirrect = base_url('auth');
    //             return json_encode($response);
    //         }

    //         $bansosIdentitas = [];

    //         if ($namesBansosIdentitas || $namesBansosIdentitas !== NULL) {
    //             if (count($namesBansosIdentitas) == count($waktu_bansos_identitas) && count($namesBansosIdentitas) == count($jumlah_bansos_identitas) && count($namesBansosIdentitas) == count($satuan_bansos_identitas) && count($namesBansosIdentitas) == count($sumber_anggaran_identitas) && count($namesBansosIdentitas) == count($keterangan_identitas)) {
    //                 foreach ($namesBansosIdentitas as $key => $value) {
    //                     $bansosOrang = [
    //                         'waktu_bansos' => $waktu_bansos_identitas[$key],
    //                         'nama_bansos' => $namesBansosIdentitas[$key],
    //                         'jumlah_bansos' => $jumlah_bansos_identitas[$key],
    //                         'satuan_bansos' => $satuan_bansos_identitas[$key],
    //                         'sumber_anggaran_bansos' => $sumber_anggaran_identitas[$key],
    //                         'keterangan_bansos' => $keterangan_identitas[$key],
    //                     ];

    //                     $bansosIdentitas[] = $bansosOrang;
    //                 }
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Silahkan lengkapi bantuan yang sudah diterima PPKS dengan benar.";
    //                 return json_encode($response);
    //             }
    //         }

    //         $bansosPengampu = [];
    //         $namesBansosPengampu = $this->request->getVar('nama_bansos_pengampu');
    //         $tahun_bansos_pengampu = $this->request->getVar('tahun_bansos_pengampu');

    //         if ($namesBansosPengampu || $namesBansosPengampu !== NULL) {
    //             if (count($namesBansosPengampu) == count($tahun_bansos_pengampu)) {
    //                 foreach ($namesBansosPengampu as $key => $valu) {
    //                     $bansosOrangPengampu = [
    //                         'tahun_bansos' => $tahun_bansos_pengampu[$key],
    //                         'nama_bansos' => $namesBansosPengampu[$key],
    //                     ];

    //                     $bansosPengampu[] = $bansosOrangPengampu;
    //                 }
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Silahkan lengkapi bantuan yang sudah diterima oleh pengampu PPKS dengan benar.";
    //                 return json_encode($response);
    //             }
    //         }

    //         $id = htmlspecialchars($this->request->getVar('_id'), true) ?? NULL;
    //         $nama = htmlspecialchars($this->request->getVar('_nama'), true) ?? NULL;
    //         $id_petugas_assesment = htmlspecialchars($this->request->getVar('_id_petugas_assesment'), true) ?? NULL;
    //         $tgl_assesment = htmlspecialchars($this->request->getVar('_tgl_asessment'), true) ?? NULL;
    //         $provinsi_ktp = htmlspecialchars($this->request->getVar('_provinsi_ktp'), true) ?? NULL;
    //         $kabupaten_ktp = htmlspecialchars($this->request->getVar('_kabupaten_ktp'), true) ?? NULL;
    //         $kecamatan_ktp = htmlspecialchars($this->request->getVar('_kecamatan_ktp'), true) ?? NULL;
    //         $kelurahan_ktp = htmlspecialchars($this->request->getVar('_kelurahan_ktp'), true) ?? NULL;
    //         $alamat_ktp = htmlspecialchars($this->request->getVar('_alamat_ktp'), true) ?? NULL;
    //         $provinsi_domisili = htmlspecialchars($this->request->getVar('_provinsi_domisili'), true) ?? NULL;
    //         $kabupaten_domisili = htmlspecialchars($this->request->getVar('_kabupaten_domisili'), true) ?? NULL;
    //         $kecamatan_domisili = htmlspecialchars($this->request->getVar('_kecamatan_domisili'), true) ?? NULL;
    //         $kelurahan_domisili = htmlspecialchars($this->request->getVar('_kelurahan_domisili'), true) ?? NULL;
    //         $alamat_domisili = htmlspecialchars($this->request->getVar('_alamat_domisili'), true) ?? NULL;
    //         $nama_identitas = htmlspecialchars($this->request->getVar('_nama_identitas'), true) ?? NULL;
    //         $tempat_lahir_identitas = htmlspecialchars($this->request->getVar('_tempat_lahir_identitas'), true) ?? NULL;
    //         $tgl_lahir_identitas = htmlspecialchars($this->request->getVar('_tgl_lahir_identitas'), true) ?? NULL;
    //         $jenis_kelamin_identitas = htmlspecialchars($this->request->getVar('_jenis_kelamin_identitas'), true) ?? NULL;
    //         $agama_identitas = htmlspecialchars($this->request->getVar('_agama_identitas'), true) ?? NULL;
    //         $nik_identitas = htmlspecialchars($this->request->getVar('_nik_identitas'), true) ?? NULL;
    //         $kk_identitas = htmlspecialchars($this->request->getVar('_kk_identitas'), true) ?? NULL;
    //         $akta_identitas = htmlspecialchars($this->request->getVar('_akta_identitas'), true) ?? NULL;
    //         $dtks_identitas = htmlspecialchars($this->request->getVar('_dtks_identitas'), true) ?? NULL;
    //         $pendidikan_terakhir_identitas = htmlspecialchars($this->request->getVar('_pendidikan_terakhir_identitas'), true) ?? NULL;
    //         $status_kawin_identitas = htmlspecialchars($this->request->getVar('_status_kawin_identitas'), true) ?? NULL;
    //         $nama_pengampu = htmlspecialchars($this->request->getVar('_nama_pengampu'), true) ?? NULL;
    //         $nohp_pengampu = htmlspecialchars($this->request->getVar('_nohp_pengampu'), true) ?? NULL;
    //         $hubungan_pengampu = htmlspecialchars($this->request->getVar('_hubungan_pengampu'), true) ?? NULL;
    //         $tempat_lahir_pengampu = htmlspecialchars($this->request->getVar('_tempat_lahir_pengampu'), true) ?? NULL;
    //         $tgl_lahir_pengampu = htmlspecialchars($this->request->getVar('_tgl_lahir_pengampu'), true) ?? NULL;
    //         $jenis_kelamin_pengampu = htmlspecialchars($this->request->getVar('_jenis_kelamin_pengampu'), true) ?? NULL;
    //         $agama_pengampu = htmlspecialchars($this->request->getVar('_agama_pengampu'), true) ?? NULL;
    //         $nik_pengampu = htmlspecialchars($this->request->getVar('_nik_pengampu'), true) ?? NULL;
    //         $kk_pengampu = htmlspecialchars($this->request->getVar('_kk_pengampu'), true) ?? NULL;
    //         $dtks_pengampu = htmlspecialchars($this->request->getVar('_dtks_pengampu'), true) ?? NULL;
    //         $pendidikan_terakhir_pengampu = htmlspecialchars($this->request->getVar('_pendidikan_terakhir_pengampu'), true) ?? NULL;
    //         $status_kawin_pengampu = htmlspecialchars($this->request->getVar('_status_kawin_pengampu'), true) ?? NULL;
    //         $pekerjaan_pengampu = htmlspecialchars($this->request->getVar('_pekerjaan_pengampu'), true) ?? NULL;
    //         $pengeluaran_perbulan_pengampu = htmlspecialchars($this->request->getVar('_pengeluaran_perbulan_pengampu'), true) ?? NULL;
    //         $kategori_ppks = htmlspecialchars($this->request->getVar('_kategori_ppks'), true) ?? NULL;
    //         $kondisi_fisik_ppks = htmlspecialchars($this->request->getVar('_kondisi_fisik_ppks'), true) ?? NULL;
    //         $detail_kondisi_fisik_ppks = htmlspecialchars($this->request->getVar('_detail_kondisi_fisik_ppks'), true) ?? NULL;
    //         $penghasilan_ekonomi = htmlspecialchars($this->request->getVar('_penghasilan_ekonomi'), true) ?? NULL;
    //         $penghasilan_makan_ekonomi = htmlspecialchars($this->request->getVar('_penghasilan_makan_ekonomi'), true) ?? NULL;
    //         $makan_ekonomi = htmlspecialchars($this->request->getVar('_makan_ekonomi'), true) ?? NULL;
    //         $kemampuan_pakaian_ekonomi = htmlspecialchars($this->request->getVar('_kemampuan_pakaian_ekonomi'), true) ?? NULL;
    //         $tempat_tinggal_ekonomi = htmlspecialchars($this->request->getVar('_tempat_tinggal_ekonomi'), true) ?? NULL;
    //         $tinggal_bersama_ekonomi = htmlspecialchars($this->request->getVar('_tinggal_bersama_ekonomi'), true) ?? NULL;
    //         $luas_lantai_ekonomi = htmlspecialchars($this->request->getVar('_luas_lantai_ekonomi'), true) ?? NULL;
    //         $jenis_lantai_ekonomi = htmlspecialchars($this->request->getVar('_jenis_lantai_ekonomi'), true) ?? NULL;
    //         $jenis_dinding_ekonomi = htmlspecialchars($this->request->getVar('_jenis_dinding_ekonomi'), true) ?? NULL;
    //         $jenis_atap_ekonomi = htmlspecialchars($this->request->getVar('_jenis_atap_ekonomi'), true) ?? NULL;
    //         $milik_wc_ekonomi = htmlspecialchars($this->request->getVar('_milik_wc_ekonomi'), true) ?? NULL;
    //         $jenis_wc_ekonomi = htmlspecialchars($this->request->getVar('_jenis_wc_ekonomi'), true) ?? NULL;
    //         $penerangan_ekonomi = htmlspecialchars($this->request->getVar('_penerangan_ekonomi'), true) ?? NULL;
    //         $sumber_air_minum_ekonomi = htmlspecialchars($this->request->getVar('_sumber_air_minum_ekonomi'), true) ?? NULL;
    //         $bahan_bakar_masak_ekonomi = htmlspecialchars($this->request->getVar('_bahan_bakar_masak_ekonomi'), true) ?? NULL;
    //         $berobat_ekonomi = htmlspecialchars($this->request->getVar('_berobat_ekonomi'), true) ?? NULL;
    //         $rata_pendidikan_ekonomi = htmlspecialchars($this->request->getVar('_rata_pendidikan_ekonomi'), true) ?? NULL;
    //         $catatan_tambahan = htmlspecialchars($this->request->getVar('_catatan_tambahan'), true) ?? NULL;
    //         $gambaran_kasus = htmlspecialchars($this->request->getVar('_gambaran_kasus'), true) ?? NULL;
    //         $kondisi_kesehatan = htmlspecialchars($this->request->getVar('_kondisi_kesehatan'), true) ?? NULL;
    //         $kondisi_perekonomian_keluarga = htmlspecialchars($this->request->getVar('_kondisi_perekonomian_keluarga'), true) ?? NULL;
    //         $permasalahan = htmlspecialchars($this->request->getVar('_permasalahan'), true) ?? NULL;
    //         $identifikasi_kebutuhan = htmlspecialchars($this->request->getVar('_identifikasi_kebutuhan'), true) ?? NULL;
    //         $intervensi_telah_dilakukan = htmlspecialchars($this->request->getVar('_intervensi_telah_dilakukan'), true) ?? NULL;
    //         $saran_tindak_lanjut = htmlspecialchars($this->request->getVar('_saran_tindak_lanjut'), true) ?? NULL;

    //         $lampiran = "";

    //         $oldData = $this->_db->table('_pengaduan a')
    //             ->select("a.*,b.peserta_spt, b.tgl_spt, b.lokasi_spt")
    //             ->join('_pengaduan_tanggapan_spt b', 'b.id = a.id')
    //             ->join('ref_kecamatan c', 'c.id = a.kecamatan')
    //             ->join('ref_kelurahan d', 'd.id = a.kelurahan')
    //             ->where(['a.id' => $id, 'a.status_aduan' => 2])->get()->getRowObject();

    //         if (!$oldData) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Pengaduan tidak ditemukan.";
    //             return json_encode($response);
    //         }

    //         $granted = grantedCanAssesment($user->data->nik, $oldData->peserta_spt);
    //         if (!$granted) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Akses tidak diizinkan.";
    //             return json_encode($response);
    //         }
    //         $kepala_dinas = $this->request->getVar('_kepala_dinas') ? htmlspecialchars($this->request->getVar('_kepala_dinas'), true) : NULL;
    //         $kepala_dinas_pilihan = $this->request->getVar('_kepala_dinas_pilihan') ? htmlspecialchars($this->request->getVar('_kepala_dinas_pilihan'), true) : NULL;
    //         $camat = $this->request->getVar('_camat') ? htmlspecialchars($this->request->getVar('_camat'), true) : NULL;
    //         $camat_pilihan = $this->request->getVar('_camat_pilihan') ? htmlspecialchars($this->request->getVar('_camat_pilihan'), true) : NULL;
    //         $kampung = $this->request->getVar('_kampung') ? htmlspecialchars($this->request->getVar('_kampung'), true) : NULL;
    //         $kampung_pilihan = $this->request->getVar('_kampung_pilihan') ? htmlspecialchars($this->request->getVar('_kampung_pilihan'), true) : NULL;
    //         // $jumlah_lampiran = $this->request->getVar('_jumlah_lampiran') ? htmlspecialchars($this->request->getVar('_jumlah_lampiran'), true) : '0';

    //         $dir = FCPATH . "uploads/assesment/lampiran";

    //         if ($filenamelampiranktp != '') {
    //             $lampiranktp = $this->request->getFile('_file_ktp');
    //             $filesNamelampiranktp = $lampiranktp->getName();
    //             $newNamelampiranktp = _create_name_foto($filesNamelampiranktp);

    //             if ($lampiranktp->isValid() && !$lampiranktp->hasMoved()) {
    //                 $lampiranktp->move($dir, $newNamelampiranktp);
    //                 $lampiran .= $newNamelampiranktp . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($filenamelampirankk != '') {
    //             $lampirankk = $this->request->getFile('_file_kk');
    //             $filesNamelampirankk = $lampirankk->getName();
    //             $newNamelampirankk = _create_name_foto($filesNamelampirankk);

    //             if ($lampirankk->isValid() && !$lampirankk->hasMoved()) {
    //                 $lampirankk->move($dir, $newNamelampirankk);
    //                 $lampiran .= $newNamelampirankk . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($filenamelampiranrumah_depan != '') {
    //             $lampiranrumah_depan = $this->request->getFile('_file_rumah_depan');
    //             $filesNamelampiranrumah_depan = $lampiranrumah_depan->getName();
    //             $newNamelampiranrumah_depan = _create_name_foto($filesNamelampiranrumah_depan);

    //             if ($lampiranrumah_depan->isValid() && !$lampiranrumah_depan->hasMoved()) {
    //                 $lampiranrumah_depan->move($dir, $newNamelampiranrumah_depan);
    //                 $lampiran .= $newNamelampiranrumah_depan . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($filenamelampiranrumah_kiri != '') {
    //             $lampiranrumah_kiri = $this->request->getFile('_file_rumah_kiri');
    //             $filesNamelampiranrumah_kiri = $lampiranrumah_kiri->getName();
    //             $newNamelampiranrumah_kiri = _create_name_foto($filesNamelampiranrumah_kiri);

    //             if ($lampiranrumah_kiri->isValid() && !$lampiranrumah_kiri->hasMoved()) {
    //                 $lampiranrumah_kiri->move($dir, $newNamelampiranrumah_kiri);
    //                 $lampiran .= $newNamelampiranrumah_kiri . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($filenamelampiranrumah_kanan != '') {
    //             $lampiranrumah_kanan = $this->request->getFile('_file_rumah_kanan');
    //             $filesNamelampiranrumah_kanan = $lampiranrumah_kanan->getName();
    //             $newNamelampiranrumah_kanan = _create_name_foto($filesNamelampiranrumah_kanan);

    //             if ($lampiranrumah_kanan->isValid() && !$lampiranrumah_kanan->hasMoved()) {
    //                 $lampiranrumah_kanan->move($dir, $newNamelampiranrumah_kanan);
    //                 $lampiran .= $newNamelampiranrumah_kanan . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         if ($filenamelampiranrumah_belakang != '') {
    //             $lampiranrumah_belakang = $this->request->getFile('_file_rumah_belakang');
    //             $filesNamelampiranrumah_belakang = $lampiranrumah_belakang->getName();
    //             $newNamelampiranrumah_belakang = _create_name_foto($filesNamelampiranrumah_belakang);

    //             if ($lampiranrumah_belakang->isValid() && !$lampiranrumah_belakang->hasMoved()) {
    //                 $lampiranrumah_belakang->move($dir, $newNamelampiranrumah_belakang);
    //                 $lampiran .= $newNamelampiranrumah_belakang . ';';
    //             } else {
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "Gagal mengupload lampiran assesment.";
    //                 return json_encode($response);
    //             }
    //         }

    //         $date = date('Y-m-d H:i:s');
    //         $upData = [];
    //         $upData['updated_at'] = $date;
    //         $upData['date_assesment'] = $date;
    //         $upData['admin_assesment'] = $user->data->id;
    //         $upData['status_aduan'] = 5;

    //         $skor_assesment = [];

    //         if ((int)$penghasilan_ekonomi > 2) {
    //             $skor_assesment['penghasilan'] = 0;
    //         } else {
    //             $skor_assesment['penghasilan'] = 1;
    //         }
    //         if ((int)$penghasilan_makan_ekonomi > 1) {
    //             $skor_assesment['penghasilan_makan'] = 0;
    //         } else {
    //             $skor_assesment['penghasilan_makan'] = 1;
    //         }
    //         if ((int)$makan_ekonomi > 1) {
    //             $skor_assesment['makan'] = 0;
    //         } else {
    //             $skor_assesment['makan'] = 1;
    //         }
    //         if ((int)$kemampuan_pakaian_ekonomi > 1) {
    //             $skor_assesment['kemampuan_pakaian'] = 0;
    //         } else {
    //             $skor_assesment['kemampuan_pakaian'] = 1;
    //         }
    //         if ((int)$tempat_tinggal_ekonomi > 2) {
    //             $skor_assesment['tempat_tinggal'] = 0;
    //         } else {
    //             $skor_assesment['tempat_tinggal'] = 1;
    //         }
    //         // if ((int)$tinggal_bersama_ekonomi > 2) {
    //         //     $skor_assesment['tinggal_bersama'] = 0;
    //         // } else {
    //         //     $skor_assesment['tinggal_bersama'] = 1;
    //         // }
    //         if ((int)$luas_lantai_ekonomi > 1) {
    //             $skor_assesment['luas_lantai'] = 0;
    //         } else {
    //             $skor_assesment['luas_lantai'] = 1;
    //         }
    //         if ((int)$jenis_lantai_ekonomi > 5) {
    //             $skor_assesment['jenis_lantai'] = 0;
    //         } else {
    //             $skor_assesment['jenis_lantai'] = 1;
    //         }
    //         if ((int)$jenis_dinding_ekonomi > 3) {
    //             $skor_assesment['jenis_dinding'] = 0;
    //         } else {
    //             $skor_assesment['jenis_dinding'] = 1;
    //         }
    //         if ((int)$jenis_atap_ekonomi > 4) {
    //             $skor_assesment['jenis_atap'] = 0;
    //         } else {
    //             $skor_assesment['jenis_atap'] = 1;
    //         }
    //         if ((int)$milik_wc_ekonomi > 1) {
    //             $skor_assesment['milik_wc'] = 0;
    //         } else {
    //             $skor_assesment['milik_wc'] = 1;
    //         }
    //         if ((int)$jenis_wc_ekonomi > 1) {
    //             $skor_assesment['jenis_wc'] = 0;
    //         } else {
    //             $skor_assesment['jenis_wc'] = 1;
    //         }
    //         if ((int)$penerangan_ekonomi > 6) {
    //             $skor_assesment['penerangan'] = 0;
    //         } else {
    //             $skor_assesment['penerangan'] = 1;
    //         }
    //         if ((int)$sumber_air_minum_ekonomi > 7) {
    //             $skor_assesment['sumber_air_minum'] = 0;
    //         } else {
    //             $skor_assesment['sumber_air_minum'] = 1;
    //         }
    //         if ((int)$bahan_bakar_masak_ekonomi > 3) {
    //             $skor_assesment['bahan_bakar_masak'] = 0;
    //         } else {
    //             $skor_assesment['bahan_bakar_masak'] = 1;
    //         }
    //         if ((int)$berobat_ekonomi > 1) {
    //             $skor_assesment['berobat'] = 0;
    //         } else {
    //             $skor_assesment['berobat'] = 1;
    //         }
    //         if ((int)$rata_pendidikan_ekonomi > 1) {
    //             $skor_assesment['rata_pendidikan'] = 0;
    //         } else {
    //             $skor_assesment['rata_pendidikan'] = 1;
    //         }

    //         $skor_total = $skor_assesment['penghasilan'] + $skor_assesment['penghasilan_makan'] + $skor_assesment['makan'] + $skor_assesment['kemampuan_pakaian'] + $skor_assesment['tempat_tinggal'] + $skor_assesment['luas_lantai'] + $skor_assesment['jenis_lantai'] + $skor_assesment['jenis_dinding'] + $skor_assesment['jenis_atap'] + $skor_assesment['milik_wc'] + $skor_assesment['jenis_wc'] + $skor_assesment['penerangan'] + $skor_assesment['sumber_air_minum'] + $skor_assesment['bahan_bakar_masak'] + $skor_assesment['berobat'] + $skor_assesment['rata_pendidikan'];

    //         $this->_db->transBegin();
    //         $this->_db->table('_pengaduan')->where('id', $oldData->id)->update($upData);
    //         if ($this->_db->affectedRows() > 0) {
    //             $this->_db->table('_pengaduan_tanggapan_spt')->where('id', $oldData->id)->update(['updated_at' => $date]);
    //             if ($this->_db->affectedRows() > 0) {
    //                 $dataTindakLanjut = [
    //                     'id' => $oldData->id,
    //                     'user_id' => $user->data->id,
    //                     'kode_aduan' => $oldData->kode_aduan,
    //                     'gambaran_kasus' => $gambaran_kasus,
    //                     'kondisi_kesehatan' => $kondisi_kesehatan,
    //                     'kondisi_perekonomian_keluarga' => $kondisi_perekonomian_keluarga,
    //                     'permasalahan' => $permasalahan,
    //                     // 'media_pengaduan' => $oldData->media_pengaduan,
    //                     'identifikasi_kebutuhan' => $identifikasi_kebutuhan,
    //                     'intervensi_telah_dilakukan' => $intervensi_telah_dilakukan,
    //                     // 'bansos_pengampu' => json_encode($bansosPengampu),
    //                     // 'bansos_ppks' => json_encode($bansosIdentitas),
    //                     'saran_tindaklanjut' => $saran_tindak_lanjut,
    //                     'tembusan_dinas' => ($kepala_dinas == 1 || $kepala_dinas == "1" || $kepala_dinas == "on") ? $kepala_dinas_pilihan : NULL,
    //                     'tembusan_camat' => ($camat == 1 || $camat == "1" || $camat == "on") ? $camat_pilihan : NULL,
    //                     'tembusan_kampung' => ($kampung == 1 || $kampung == "1" || $kampung == "on") ? $kampung_pilihan : NULL,
    //                     // 'jumlah_lampiran' => ($jumlah_lampiran == 0 || $jumlah_lampiran == "0" || $jumlah_lampiran == "-") ? $jumlah_lampiran : 0,
    //                     'created_at' => $date,
    //                 ];

    //                 $this->_db->table('_pengaduan_tanggapan_ppks')->insert($dataTindakLanjut);
    //                 if ($this->_db->affectedRows() > 0) {
    //                     $dataAssesment = [
    //                         'id' => $oldData->id,
    //                         'jenis' => 'PENGADUAN PPKS',
    //                         'kode_assesment' => 'ASSESMENT-' . $oldData->kode_aduan,
    //                         'admin_assesment' => $user->data->id,
    //                         'date_assesment' => $tgl_assesment,
    //                         'nik_orang_assesment' => $nik_identitas,
    //                         'nama_orang_assesment' => $nama_identitas,
    //                         'tempat_lahir_orang_assesment' => $tempat_lahir_identitas,
    //                         'tgl_lahir_orang_assesment' => $tgl_lahir_identitas,
    //                         'jk_orang_assesment' => $jenis_kelamin_identitas,
    //                         'agama_orang_assesment' => $agama_identitas,
    //                         'kk_orang_assesment' => $kk_identitas,
    //                         'akta_orang_assesment' => $akta_identitas,
    //                         'provinsi_ktp_orang_assesment' => $provinsi_ktp,
    //                         'kabupaten_ktp_orang_assesment' => $kabupaten_ktp,
    //                         'kecamatan_ktp_orang_assesment' => $kecamatan_ktp,
    //                         'kelurahan_ktp_orang_assesment' => $kelurahan_ktp,
    //                         'alamat_ktp_orang_assesment' => $alamat_ktp,
    //                         'provinsi_domisili_orang_assesment' => $provinsi_domisili,
    //                         'kabupaten_domisili_orang_assesment' => $kabupaten_domisili,
    //                         'kecamatan_domisili_orang_assesment' => $kecamatan_domisili,
    //                         'kelurahan_domisili_orang_assesment' => $kelurahan_domisili,
    //                         'alamat_domisili_orang_assesment' => $alamat_domisili,
    //                         'pendidikan_terakhir_orang_assesment' => $pendidikan_terakhir_identitas,
    //                         'status_kawin_orang_assesment' => $status_kawin_identitas,
    //                         'dtks_orang_assesment' => $dtks_identitas,
    //                         'bansos_orang_assesment' => json_encode($bansosIdentitas),
    //                         'nama_pengampu_assesment' => $nama_pengampu,
    //                         'nohp_pengampu_assesment' => $nohp_pengampu,
    //                         'hubungan_pengampu_assesment' => $hubungan_pengampu,
    //                         'tempat_lahir_pengampu_assesment' => $tempat_lahir_pengampu,
    //                         'tgl_lahir_pengampu_assesment' => $tgl_lahir_pengampu,
    //                         'jk_pengampu_assesment' => $jenis_kelamin_pengampu,
    //                         'agama_pengampu_assesment' => $agama_pengampu,
    //                         'nik_pengampu_assesment' => $nik_pengampu,
    //                         'kk_pengampu_assesment' => $kk_pengampu,
    //                         'pendidikan_terakhir_pengampu_assesment' => $pendidikan_terakhir_pengampu,
    //                         'status_kawin_pengampu_assesment' => $status_kawin_pengampu,
    //                         'pekerjaan_pengampu_assesment' => $pekerjaan_pengampu,
    //                         'dtks_pengampu_assesment' => $dtks_pengampu,
    //                         'bansos_pengampu_assesment' => json_encode($bansosPengampu),
    //                         'pengeluaran_perbulan_pengampu_assesment' => $pengeluaran_perbulan_pengampu,
    //                         'kategori_ppks' => $kategori_ppks,
    //                         'kondisi_fisik_ppks' => $kondisi_fisik_ppks,
    //                         'detail_kondisi_fisik_ppks' => $detail_kondisi_fisik_ppks,
    //                         'penghasilan_ekonomi' => $penghasilan_ekonomi,
    //                         'penghasilan_makan_ekonomi' => $penghasilan_makan_ekonomi,
    //                         'makan_ekonomi' => $makan_ekonomi,
    //                         'kemampuan_pakaian_ekonomi' => $kemampuan_pakaian_ekonomi,
    //                         'tempat_tinggal_ekonomi' => $tempat_tinggal_ekonomi,
    //                         'tinggal_bersama_ekonomi' => $tinggal_bersama_ekonomi,
    //                         'luas_lantai_ekonomi' => $luas_lantai_ekonomi,
    //                         'jenis_lantai_ekonomi' => $jenis_lantai_ekonomi,
    //                         'jenis_dinding_ekonomi' => $jenis_dinding_ekonomi,
    //                         'jenis_atap_ekonomi' => $jenis_atap_ekonomi,
    //                         'milik_wc_ekonomi' => $milik_wc_ekonomi,
    //                         'jenis_wc_ekonomi' => $jenis_wc_ekonomi,
    //                         'penerangan_ekonomi' => $penerangan_ekonomi,
    //                         'sumber_air_minum_ekonomi' => $sumber_air_minum_ekonomi,
    //                         'bahan_bakar_masak_ekonomi' => $bahan_bakar_masak_ekonomi,
    //                         'berobat_ekonomi' => $berobat_ekonomi,
    //                         'rata_pendidikan_ekonomi' => $rata_pendidikan_ekonomi,
    //                         'catatan_tambahan' => $catatan_tambahan,
    //                         'lampiran' => $lampiran,
    //                         'skor_assesment' => json_encode($skor_assesment),
    //                         'skor_total' => $skor_total,
    //                         'created_at' => $date,
    //                     ];

    //                     $this->_db->table('_data_assesment')->insert($dataAssesment);
    //                     if ($this->_db->affectedRows() > 0) {
    //                         $riwayatLib = new Riwayatpengaduanlib();
    //                         try {
    //                             $riwayatLib->create($user->data->id, "Mengassesment pengaduan: " . $oldData->kode_aduan . ", dengan skor Nilai $skor_total, dan dengan saran tindaklanjut $saran_tindak_lanjut", "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $oldData->id, $oldData->id);
    //                         } catch (\Throwable $th) {
    //                         }

    //                         // $this->_db->transCommit();
    //                         // try {
    //                         $m = new Merger();
    //                         $dataFileGambar = file_get_contents(FCPATH . './uploads/logo-lamteng.png');;
    //                         $base64 = "data:image/png;base64," . base64_encode($dataFileGambar);

    //                         $qrCode = "data:image/png;base64," . base64_encode(file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData->kode_aduan . '&choe=UTF-8'));

    //                         // $petugas =getPetugasFromNik($user->data->nik);

    //                         $html   =  '<html>
    //                     <head>
    //                         <link href="';
    //                         $html   .=              base_url('uploads/bootstrap.css');
    //                         $html   .=          '" rel="stylesheet">
    //                     </head>
    //                     <body>
    //                         <div class="container">
    //                             <div class="row">
    //                                 <table class="table table-responsive" style="border: none;">
    //                                     <tbody>
    //                                         <tr>
    //                                             <td>
    //                                                 <img class="image-responsive" width="110px" height="110px" src="';
    //                         $html   .=                                      $base64;
    //                         $html   .=                                  '"/>
    //                                             </td>
    //                                             <td>
    //                                                 &nbsp;&nbsp;&nbsp;
    //                                             </td>
    //                                             <td>
    //                                                 <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">PEMERINTAH KABUPATEN LAMPUNG TENGAH</h3>
    //                                                 <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">DINAS SOSIAL</h3>
    //                                                 <h3 style="margin: 0rem;font-size: 16px; font-weight: 500; text-align: center;">KABUPATEN LAMPUNG TENGAH</h3>
    //                                                 <h4 style="margin: 0rem;font-size: 12px;font-weight: 400;" text-align: center;>Jl. Hi. Muchtar Gunung Sugih 34161 Telp. (0725) 529786 Fax. 529787</h4>
    //                                             </td>
    //                                         </tr>
    //                                     </tbody>
    //                                 </table>
    //                             </div>
    //                             <div class="row">
    //                                 <div style="text-align: center;margin-top: 30px;">
    //                                     <h3 style="margin: 0rem;font-size: 14px;"><u>NOTA DINAS</u></h3>
    //                                 </div>
    //                             </div>
    //                             <div class="row" style="margin-left: 30px;margin-right:30px;">
    //                                 <div style="text-align: justify;margin-top: 30px;">
    //                                     <p style="margin-bottom: 15px; margin-top: 0px; font-size: 12px; padding-top: 0px; padding-bottom: 0px;">
    //                                         <table style="border: none;font-size: 12px; margin-bottom: 0px; margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
    //                                             <tbody>
    //                                                 <tr>
    //                                                     <td>
    //                                                         Kepada Yth.
    //                                                     </td>
    //                                                     <td>&nbsp;: &nbsp;</td>
    //                                                     <td>&nbsp;Kepala Dinas Sosial Kabupaten Lampung Tengah</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Melalui
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
    //                                                     <td style="vertical-align: top;">&nbsp;Kepala Bidang Rehabilitasi Sosial</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Dari
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
    //                                                     <td style="vertical-align: top;">&nbsp;';
    //                         $html   .=                                          $user->data->fullname;
    //                         // $html   .=                                          getNamaPengguna($user->data->id);
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Tanggal
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
    //                                                     <td style="vertical-align: top;">&nbsp;';
    //                         $html   .=                                          tgl_indo($tgl_assesment);
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr>
    //                                                     <td>
    //                                                         Sifat
    //                                                     </td>
    //                                                     <td>&nbsp;: &nbsp;</td>
    //                                                     <td>&nbsp;Penting/Segera';
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr>
    //                                                     <td>
    //                                                         Lampiran
    //                                                     </td>
    //                                                     <td>&nbsp;: &nbsp;</td>
    //                                                     <td>&nbsp;';
    //                         $html   .=                                          '1 (satu) berkas';
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Tembusan
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>';
    //                         $html   .=                      '<td style="vertical-align: top;">&nbsp;';
    //                         if ($dataTindakLanjut['tembusan_dinas'] !== NULL) {
    //                             $html   .= '1. Kepala Dinas ' . getNamaDinas($dataTindakLanjut['tembusan_dinas']) . '<br/>';
    //                             if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
    //                                 $html   .= '&nbsp;2. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
    //                                 if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
    //                                     $html   .= '&nbsp;3. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
    //                                     $html .= '&nbsp;4. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 } else {
    //                                     $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 }
    //                             } else {
    //                                 if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
    //                                     $html   .= '&nbsp;2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
    //                                 } else {
    //                                     $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 }
    //                             }
    //                         } else {
    //                             if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
    //                                 $html   .= '&nbsp;1. Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']) . '<br/>';
    //                                 if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
    //                                     $html   .= '&nbsp;2. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
    //                                     $html .= '&nbsp;3. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 } else {
    //                                     $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 }
    //                             } else {
    //                                 if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
    //                                     $html   .= '&nbsp;1. Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']) . '<br/>';
    //                                     $html .= '&nbsp;2. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 } else {
    //                                     $html .= '&nbsp;1. Kepada Yang Bersangkutan <i>(Pelapor)</i>';
    //                                 }
    //                             }
    //                         }
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Perihal
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
    //                                                     <td style="vertical-align: top;">&nbsp;';
    //                         $html   .=                                          'Laporan Hasil Assesment Respon Kasus a.n ' . $nama_identitas;
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                                 <tr style="vertical-align: top;">
    //                                                     <td style="vertical-align: top;">
    //                                                         Nomor Aduan
    //                                                     </td>
    //                                                     <td style="vertical-align: top;">&nbsp;: &nbsp;</td>
    //                                                     <td style="vertical-align: top;">&nbsp;';
    //                         $html   .=                                          $oldData->kode_aduan;
    //                         $html   .=                                      '</td>
    //                                                 </tr>
    //                                             </tbody>
    //                                         </table>
    //                                     </p>
    //                                     <p style="margin-top: 20px;font-size: 12px;vertical-align: top;">
    //                                         <ol style="font-size: 12px;vertical-align: top;">
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>TANGGAL ADUAN</b><br/><span>' . tgl_hari_indo($date) . '</span></li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>MEDIA PENGADUAN</b><br/><span>' . $oldData->media_pengaduan . '</span></li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>IDENTITAS PEMOHON</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Nama</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . ucwords($oldData->nama) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">NIK</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $oldData->nik . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">No HP</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $oldData->nohp . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Alamat</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $oldData->alamat . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kampung</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamaKelurahan($oldData->kelurahan) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kecamatan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamaKecamatan($oldData->kecamatan) . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>IDENTITAS SUBJEK ADUAN</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Nama</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . ucwords($nama_identitas) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">NIK</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $nik_identitas . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">No HP</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . '-' . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Alamat</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $alamat_domisili . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kampung</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamaKelurahan($kelurahan_domisili) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kecamatan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamaKecamatan($kecamatan_domisili) . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>KATEGORI ADUAN</b><br/><span>' . $oldData->kategori . '</span></li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px; margin-top: 20px;"><b>HASIL ANALISA</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Kepersertaan Basos<br/>
    //                                                             <table style="border: 1px solid #dcdfe4;">
    //                                                                 <thead>
    //                                                                     <tr style="vertical-align: top;border: 1px solid #dcdfe4;">
    //                                                                         <td style="vertical-align: top;">No</td>
    //                                                                         <td style="vertical-align: top;">Nama</td>
    //                                                                         <td style="vertical-align: top;">NIK</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">DTKS</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">PKH</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">BPNT</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">PBI JK</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">RST</td>
    //                                                                         <td style="vertical-align: top;text-align: center;">Bansos Lainnya</td>
    //                                                                         <td style="vertical-align: top;">Keterangan</td>
    //                                                                     </tr>
    //                                                                 </thead>
    //                                                                 <tbody>';
    //                         $kepersertaan_bansos = [];
    //                         foreach ($kepersertaan_bansos as $key => $v) {
    //                             $html .= '<tr style="vertical-align: top;border: 1px solid #dcdfe4;">
    //                                                                             <td style="vertical-align: top;">' . $key + 1 . '</td>
    //                                                                             <td style="vertical-align: top;">' . ucwords($v['nama_anggota']) . '</td>
    //                                                                             <td style="vertical-align: top;">' . $v['nik_anggota'] . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['dtks']) . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['pkh']) . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['bpnt']) . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['pbi_jk']) . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['rst']) . '</td>
    //                                                                             <td style="vertical-align: top;text-align: center;">' . ucwords($v['bansos_lain']) . '</td>
    //                                                                             <td style="vertical-align: top;">' . $v['keterangan_anggota'] . '</td>
    //                                                                         </tr>';
    //                         }
    //                         $html .=                                                '</tbody>
    //                                                             </table>
    //                                                         </td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Gambaran Kasus : &nbsp;<br/>' . $dataTindakLanjut['gambaran_kasus'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Kondisi Kesehatan : &nbsp;<br/>' . $dataTindakLanjut['kondisi_kesehatan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Kondisi perekonomian keluarga : &nbsp;<br/>' . $dataTindakLanjut['kondisi_perekonomian_keluarga'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Permasalahan : &nbsp;<br/>' . $dataTindakLanjut['permasalahan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Identifikasi Kebutuhan : &nbsp;<br/>' . $dataTindakLanjut['identifikasi_kebutuhan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">g. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Intervensi Yang Telah Dilakukan : &nbsp;<br/>' . $dataTindakLanjut['intervensi_telah_dilakukan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;margin-bottom: 15px;">
    //                                                         <td style="vertical-align: top;">h. &nbsp;</td>
    //                                                         <td colspan="3" style="vertical-align: top;">Saran Tindak Lanjut : &nbsp;<br/>' . $dataTindakLanjut['saran_tindaklanjut'] . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>PETUGAS / PIHAK YANG TERLIBAT</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . ucwords($oldData->nama) . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                         </ol>
    //                                     </p>
    //                                 </div>
    //                             </div>
    //                             <div class="row" style="margin-left: 30px;margin-right:30px;">
    //                                 <div>
    //                                     <table style="width: 100%;max-width: 100%;" border="0">
    //                                         <tbody>
    //                                             <tr>
    //                                                 <td style="width: 60%"><center><img class="image-responsive" width="110px" height="110px" src="' . $qrCode . '"/></center></td>
    //                                                 <td style="width: 40%">
    //                                                     <br>
    //                                                     <br>
    //                                                     <span style="font-size: 12px;">Gunung Sugih, ';
    //                         $html   .=                                          tgl_indo(date('Y-m-d'));
    //                         $html   .=                                      '</span><br>
    //                                                     <span style="font-size: 12px;">PETUGAS</span><br><br><br><br><br>
    //                                                     <span style="font-size: 12px;"><b><u>';
    //                         $html   .=                                          $user->data->fullname;
    //                         $html   .=                                      '</u></b></span>
    //                                                 </td>
    //                                             </tr>
    //                                         </tbody>
    //                                     </table>

    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </body>
    //                 </html>';

    //                         $aHtml = '
    //                 <html>
    //                     <head>
    //                         <link href="';
    //                         $aHtml   .=              base_url('uploads/bootstrap.css');
    //                         $aHtml   .=          '" rel="stylesheet">
    //                     </head>
    //                     <body>
    //                         <div class="container">
    //                             <div class="row">
    //                                 <div style="text-align: center;margin-top: 30px;">
    //                                     <img class="image-responsive" width="80px" height="80px" src="';
    //                         $aHtml   .=                                      $base64;
    //                         $aHtml   .=                                  '"/><br/>
    //                                     <h3 style="margin: 0rem;font-size: 14px; padding-top: 20px;">FORM ASSESMENT RESPON KASUS</h3>
    //                                     <h3 style="margin: 0rem;font-size: 14px;">DINAS SOSIAL KABUPATEN LAMPUNG TENGAH</h3>
    //                                 </div>
    //                             </div>
    //                             <div class="row">
    //                                 <div style="text-align: center;margin-top: 10px;font-size: 12px;">
    //                                 <b>Nomor Kuesioner</b><br/>' . $dataAssesment['kode_assesment'] . '
    //                                 </div>
    //                             </div>
    //                             <div class="row" style="margin-left: 30px;margin-right:30px;">
    //                                 <div style="text-align: justify;margin-top: 30px;">
    //                                     <p style="margin-top: 20px;font-size: 12px;vertical-align: top;">
    //                                         <ol style="font-size: 12px;vertical-align: top;">
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>DATA PENUGASAN</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Tanggal Assesment</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . tgl_indo($tgl_assesment) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Nama Petugas Assesment</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . ucwords($user->data->fullname) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Instansi / Unit Kerja</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $oldData->nohp . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>PROFIL LENGKAP PPKS</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">2.1. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Alamat Sesuai Data Kependudukan</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">&nbsp;</td>
    //                                                         <td style="vertical-align: top;">
    //                                                             <table>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top; width: 20px;">a. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Provinsi</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['provinsi_ktp_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top; width: 20px;">b. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kabupaten</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['kabupaten_ktp_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top; width: 20px;">c. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kecamatan</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . getNamaKecamatan($dataAssesment['kabupaten_ktp_orang_assesment']) . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top; width: 20px;">d. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kelurahan</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . getNamaKelurahan($dataAssesment['kelurahan_ktp_orang_assesment']) . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top; width: 20px;">e. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Alamat</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['alamat_ktp_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                             </table>
    //                                                         </td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">2.2. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Alamat Sesuai Domisili</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">&nbsp;</td>
    //                                                         <td style="vertical-align: top;">
    //                                                             <table>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Provinsi</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['provinsi_domisili_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kabupaten</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['kabupaten_domisili_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kecamatan</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . getNamaKecamatan($dataAssesment['kabupaten_domisili_orang_assesment']) . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Kelurahan</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . getNamaKelurahan($dataAssesment['kelurahan_domisili_orang_assesment']) . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Alamat</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['alamat_domisili_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                             </table>
    //                                                         </td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">2.3. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Identitas PPKS</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top; width: 20px;">&nbsp;</td>
    //                                                         <td style="vertical-align: top;">
    //                                                             <table>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Nama Lengkap</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['nama_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Tempat Lahir</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['tempat_lahir_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Tanggal Lahir</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . tgl_indo($dataAssesment['tgl_lahir_orang_assesment']) . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Jenis Kelamin</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['jk_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Agama</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['agama_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">NIK</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['nik_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Nomor KK</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['kk_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">g. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Nomor Akta Lahir</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['akta_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">h. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Sudah Masuk DTKS</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['dtks_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">i. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Bantuan yang pernah / sedang diterima saat ini</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">&nbsp;</td>
    //                                                                     <td style="vertical-align: top;" colspan="3">
    //                                                                         <table border="1">
    //                                                                             <thead>
    //                                                                                 <tr style="vertical-align: top;">
    //                                                                                     <td style="vertical-align: top;">No</td>
    //                                                                                     <td style="vertical-align: top;">Waktu Pelaksanaan</td>
    //                                                                                     <td style="vertical-align: top;">Nama Bantuan</td>
    //                                                                                     <td style="vertical-align: top;">Jumlah</td>
    //                                                                                     <td style="vertical-align: top;">Satuan</td>
    //                                                                                     <td style="vertical-align: top;">Sumber Dana</td>
    //                                                                                     <td style="vertical-align: top;">Ket</td>
    //                                                                                 </tr>
    //                                                                             </thead>
    //                                                                             <tbody>';
    //                         if (count($bansosIdentitas) > 0) {
    //                             foreach ($bansosIdentitas as $key => $value) {
    //                                 $aHtml .= '
    //                                                                                 <tr style="vertical-align: top;">
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $key + 1 . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['waktu_bansos'] . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['nama_bansos'] . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['jumlah_bansos'] . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['satuan_bansos'] . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['sumber_anggaran_bansos'] . '
    //                                                                                     </td>
    //                                                                                     <td style="vertical-align: top;">
    //                                                                                         ' . $value['keterangan_bansos'] . '
    //                                                                                     </td>
    //                                                                                 </tr>';
    //                             }
    //                         }
    //                         $aHtml .= '
    //                                                                             </tbody>
    //                                                                         </table>
    //                                                                     </td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">j. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Pendidikan Terakhir</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['pendidikan_terakhir_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                                 <tr style="vertical-align: top;">
    //                                                                     <td style="vertical-align: top;">k. &nbsp;</td>
    //                                                                     <td style="vertical-align: top;">Status Kawin</td>
    //                                                                     <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                                     <td style="vertical-align: top;"> ' . $dataAssesment['status_kawin_orang_assesment'] . '</td>
    //                                                                 </tr>
    //                                                             </table>
    //                                                         </td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>';
    //                         if ($nama_pengampu == "" || $nama_pengampu == NULL) {
    //                         } else {
    //                             $aHtml .= '
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>PROFIL LENGKAP PENGAMPU PPKS</b><br/>
    //                                                 <table>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Nama Lengkap</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['nama_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">No Handphone</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['nohp_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Hubungan dengan PPKS</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['hubungan_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Tempat Lahir</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['tempat_lahir_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Tanggal Lahir</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . tgl_indo($dataAssesment['tgl_lahir_pengampu_assesment']) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Jenis Kelamin</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['jk_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">g. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Agama</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['agama_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">h. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">NIK</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['nik_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">i. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Nomor KK</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['kk_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">j. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Sudah Masuk DTKS</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['dtks_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">k. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Bantuan yang pernah / sedang diterima saat ini</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;">&nbsp;</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">&nbsp;</td>
    //                                                         <td style="vertical-align: top;" colspan="3">
    //                                                             <table border="1">
    //                                                                 <thead>
    //                                                                     <tr style="vertical-align: top;">
    //                                                                         <td style="vertical-align: top;">No</td>
    //                                                                         <td style="vertical-align: top;">Nama Bansos</td>
    //                                                                         <td style="vertical-align: top;">Tahun Bansos</td>
    //                                                                     </tr>
    //                                                                 </thead>
    //                                                                 <tbody>';
    //                             if (count($bansosPengampu) > 0) {
    //                                 foreach ($bansosPengampu as $keys => $valu) {
    //                                     $aHtml .= '
    //                                                                     <tr style="vertical-align: top;">
    //                                                                         <td style="vertical-align: top;">
    //                                                                             ' . $keys + 1 . '
    //                                                                         </td>
    //                                                                         <td style="vertical-align: top;">
    //                                                                             ' . $valu['nama_bansos'] . '
    //                                                                         </td>
    //                                                                         <td style="vertical-align: top;">
    //                                                                             ' . $valu['tahun_bansos'] . '
    //                                                                         </td>
    //                                                                     </tr>';
    //                                 }
    //                             }
    //                             $aHtml .= '
    //                                                                 </tbody>
    //                                                             </table>
    //                                                         </td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">l. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Pendidikan Terakhir</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['pendidikan_terakhir_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">m. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Status Kawin</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['status_kawin_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">n. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Pekerjaan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['pekerjaan_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">o. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Pengeluaran Perbulan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:&nbsp;</td>
    //                                                         <td style="vertical-align: top;"> ' . $dataAssesment['pengeluaran_perbulan_pengampu_assesment'] . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                                         ';
    //                         }
    //                         $aHtml .= '
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>KONDISI PPKS</b><br/>
    //                                                 <table border="0">
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kategori PPKS</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameKategoriPPKS($dataAssesment['kategori_ppks']) . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kondisi Fisik PPKS</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $dataAssesment['kondisi_fisik_ppks'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Detail Kondisi Fisik PPKS</td>
    //                                                         <td style="vertical-align: top;">&nbsp;:</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $dataAssesment['detail_kondisi_fisik_ppks'] . '</td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                             <li style="font-size: 12px;vertical-align: top;margin-bottom: 15px;"><b>KONDISI PEREKONOMIAN</b><br/>
    //                                                 <table border="0">
    //                                                     <thead>
    //                                                         <tr style="vertical-align: top;">
    //                                                             <td style="vertical-align: top;">#</td>
    //                                                             <td style="vertical-align: top;">Indikator</td>
    //                                                             <td style="vertical-align: top;">Jawaban</td>
    //                                                             <td style="vertical-align: top;">Skor</td>
    //                                                         </tr>
    //                                                     </thead>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">a. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Rata-rata Penghasilan Kepala Keluarga Perbulan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamePenghasilanEkonomi($dataAssesment['penghasilan_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['penghasilan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">b. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Penghasilan dan Makan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamePenghasilanMakanEkonomi($dataAssesment['penghasilan_makan_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['penghasilan_makan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">c. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Makan</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameMakanEkonomi($dataAssesment['makan_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['makan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">d. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kemampuan Membeli Pakaian</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameKemampuanPakaianEkonomi($dataAssesment['kemampuan_pakaian_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['kemampuan_pakaian'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">e. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Tempat Tinggal Saat Ini</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameTempatTinggalEkonomi($dataAssesment['tempat_tinggal_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['tempat_tinggal'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">f. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Tinggal Bersama</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $dataAssesment['tinggal_bersama_ekonomi'] . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">g. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Luas lantai (yang beratap) bangunan tempat tinggal</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameLuasLantaiEkonomi($dataAssesment['luas_lantai_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['luas_lantai'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">h. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Jenis lantai terluas</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameJenisLantaiEkonomi($dataAssesment['jenis_lantai_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['jenis_lantai'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">i. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Jenis dinding terluas</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameJenisDindingEkonomi($dataAssesment['jenis_dinding_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['jenis_dinding'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">j. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Jenis atap terluas</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameJenisAtapEkonomi($dataAssesment['jenis_atap_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['jenis_atap'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">k. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kepemilikan dan penggunaan fasilitas tempat buang air besar</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameMilikWcEkonomi($dataAssesment['milik_wc_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['milik_wc'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">l. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">jenis fasilitas tempat buang air besar</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameJenisWcEkonomi($dataAssesment['jenis_wc_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['jenis_wc'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">m. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Sumber Penerangan Utama</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNamePeneranganEkonomi($dataAssesment['penerangan_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['penerangan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">n. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Sumber Air Minum</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameSumberAirMinumEkonomi($dataAssesment['sumber_air_minum_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['sumber_air_minum'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">o. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Bahan bakar / energi utama untuk memasak</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameBahanBakarMasakEkonomi($dataAssesment['bahan_bakar_masak_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['bahan_bakar_masak'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">p. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Kemampuan Berobat</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameBerobatEkonomi($dataAssesment['berobat_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['berobat'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td style="vertical-align: top;">q. &nbsp;</td>
    //                                                         <td style="vertical-align: top;">Rata-rata tingkat pendidikan keluarga </td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . getNameRataPendidikanEkonomi($dataAssesment['rata_pendidikan_ekonomi']) . '</td>
    //                                                         <td style="vertical-align: top;">&nbsp;' . $skor_assesment['rata_pendidikan'] . '</td>
    //                                                     </tr>
    //                                                     <tr style="vertical-align: top;">
    //                                                         <td colspan ="4" style="vertical-align: top;text-align: center;"><b>Total Skor : ' . $skor_total . '</b></td>
    //                                                     </tr>
    //                                                 </table>
    //                                             </li>
    //                                         </ol>
    //                                     </p>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </body>
    //                 </html>
    //                 ';

    //                         try {
    //                             $dompdf = new DOMPDF();
    //                             $dompdf->setPaper('F4', 'potrait');
    //                             $dompdf->loadHtml($html);
    //                             $dompdf->render();
    //                             $m->addRaw($dompdf->output());
    //                             // unset($dompdf);

    //                             $dompdf1 = new DOMPDF();
    //                             // // $dompdf = new Dompdf();
    //                             $dompdf1->setPaper('F4', 'potrait');
    //                             $dompdf1->loadHtml($aHtml);
    //                             $dompdf1->render();
    //                             $m->addRaw($dompdf1->output());

    //                             if ($lampiran !== "") {
    //                                 $xx['files'] = $lampiran;
    //                                 $dompdf2 = new DOMPDF();
    //                                 // // $dompdf = new Dompdf();
    //                                 $dompdf2->setPaper('F4', 'potrait');
    //                                 $dompdf2->loadHtml(view('silastri/peksos/pengaduan/asesmenppks/template_lampiran_assesment', $xx));
    //                                 $dompdf2->render();
    //                                 $m->addRaw($dompdf2->output());
    //                             }

    //                             $dir = FCPATH . "upload/assesment/pdf";
    //                             $fileNya = $dir . '/' . $oldData->kode_aduan . '.pdf';

    //                             file_put_contents($fileNya, $m->merge());

    //                             sleep(3);
    //                             // } catch (\Throwable $th) {
    //                             //     //throw $th;
    //                             // }
    //                             // header('Content-Type: application/pdf');
    //                             // header('Content-Disposition: attachment; filename="' . basename($fileNya) . '"');
    //                             // header('Content-Length: ' . filesize($fileNya));
    //                             // readfile($fileNya);

    //                             $this->_db->transCommit();
    //                             $response = new \stdClass;
    //                             $response->status = 200;
    //                             $response->redirrect = base_url('silastri/peksos/pengaduan/antrian');
    //                             $response->filenya = base_url('upload/assesment/pdf') . '/' . $oldData->kode_aduan . '.pdf';
    //                             $response->filename = $fileNya;
    //                             $response->message = "Assesment Aduan " . $oldData->kode_aduan . " berhasil disimpan.";
    //                             return json_encode($response);
    //                         } catch (\Throwable $th) {
    //                             if ($filenamelampiranktp != '') {
    //                                 unlink($dir . '/' . $newNamelampiranktp);
    //                             }
    //                             if ($filenamelampirankk != '') {
    //                                 unlink($dir . '/' . $newNamelampirankk);
    //                             }
    //                             if ($filenamelampiranrumah_depan != '') {
    //                                 unlink($dir . '/' . $newNamelampiranrumah_depan);
    //                             }
    //                             if ($filenamelampiranrumah_kiri != '') {
    //                                 unlink($dir . '/' . $newNamelampiranrumah_kiri);
    //                             }
    //                             if ($filenamelampiranrumah_kanan != '') {
    //                                 unlink($dir . '/' . $newNamelampiranrumah_kanan);
    //                             }
    //                             if ($filenamelampiranrumah_belakang != '') {
    //                                 unlink($dir . '/' . $newNamelampiranrumah_belakang);
    //                             }
    //                             $this->_db->transRollback();
    //                             $response = new \stdClass;
    //                             $response->status = 400;
    //                             $response->eror = var_dump($th);
    //                             $response->message = "1. Gagal mengassesment aduan " . $oldData->kode_aduan;
    //                             return json_encode($response);
    //                         }
    //                     } else {
    //                         if ($filenamelampiranktp != '') {
    //                             unlink($dir . '/' . $newNamelampiranktp);
    //                         }
    //                         if ($filenamelampirankk != '') {
    //                             unlink($dir . '/' . $newNamelampirankk);
    //                         }
    //                         if ($filenamelampiranrumah_depan != '') {
    //                             unlink($dir . '/' . $newNamelampiranrumah_depan);
    //                         }
    //                         if ($filenamelampiranrumah_kiri != '') {
    //                             unlink($dir . '/' . $newNamelampiranrumah_kiri);
    //                         }
    //                         if ($filenamelampiranrumah_kanan != '') {
    //                             unlink($dir . '/' . $newNamelampiranrumah_kanan);
    //                         }
    //                         if ($filenamelampiranrumah_belakang != '') {
    //                             unlink($dir . '/' . $newNamelampiranrumah_belakang);
    //                         }
    //                         $this->_db->transRollback();
    //                         $response = new \stdClass;
    //                         $response->status = 400;
    //                         $response->message = "2. Gagal mengassesment aduan " . $oldData->kode_aduan;
    //                         return json_encode($response);
    //                     }
    //                 } else {
    //                     if ($filenamelampiranktp != '') {
    //                         unlink($dir . '/' . $newNamelampiranktp);
    //                     }
    //                     if ($filenamelampirankk != '') {
    //                         unlink($dir . '/' . $newNamelampirankk);
    //                     }
    //                     if ($filenamelampiranrumah_depan != '') {
    //                         unlink($dir . '/' . $newNamelampiranrumah_depan);
    //                     }
    //                     if ($filenamelampiranrumah_kiri != '') {
    //                         unlink($dir . '/' . $newNamelampiranrumah_kiri);
    //                     }
    //                     if ($filenamelampiranrumah_kanan != '') {
    //                         unlink($dir . '/' . $newNamelampiranrumah_kanan);
    //                     }
    //                     if ($filenamelampiranrumah_belakang != '') {
    //                         unlink($dir . '/' . $newNamelampiranrumah_belakang);
    //                     }
    //                     $this->_db->transRollback();
    //                     $response = new \stdClass;
    //                     $response->status = 400;
    //                     $response->message = "3. Gagal mengassesment aduan " . $oldData->kode_aduan;
    //                     return json_encode($response);
    //                 }
    //             } else {
    //                 if ($filenamelampiranktp != '') {
    //                     unlink($dir . '/' . $newNamelampiranktp);
    //                 }
    //                 if ($filenamelampirankk != '') {
    //                     unlink($dir . '/' . $newNamelampirankk);
    //                 }
    //                 if ($filenamelampiranrumah_depan != '') {
    //                     unlink($dir . '/' . $newNamelampiranrumah_depan);
    //                 }
    //                 if ($filenamelampiranrumah_kiri != '') {
    //                     unlink($dir . '/' . $newNamelampiranrumah_kiri);
    //                 }
    //                 if ($filenamelampiranrumah_kanan != '') {
    //                     unlink($dir . '/' . $newNamelampiranrumah_kanan);
    //                 }
    //                 if ($filenamelampiranrumah_belakang != '') {
    //                     unlink($dir . '/' . $newNamelampiranrumah_belakang);
    //                 }
    //                 $this->_db->transRollback();
    //                 $response = new \stdClass;
    //                 $response->status = 400;
    //                 $response->message = "4. Gagal mengassesment aduan " . $oldData->kode_aduan;
    //                 return json_encode($response);
    //             }
    //         } else {
    //             if ($filenamelampiranktp != '') {
    //                 unlink($dir . '/' . $newNamelampiranktp);
    //             }
    //             if ($filenamelampirankk != '') {
    //                 unlink($dir . '/' . $newNamelampirankk);
    //             }
    //             if ($filenamelampiranrumah_depan != '') {
    //                 unlink($dir . '/' . $newNamelampiranrumah_depan);
    //             }
    //             if ($filenamelampiranrumah_kiri != '') {
    //                 unlink($dir . '/' . $newNamelampiranrumah_kiri);
    //             }
    //             if ($filenamelampiranrumah_kanan != '') {
    //                 unlink($dir . '/' . $newNamelampiranrumah_kanan);
    //             }
    //             if ($filenamelampiranrumah_belakang != '') {
    //                 unlink($dir . '/' . $newNamelampiranrumah_belakang);
    //             }
    //             $this->_db->transRollback();
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "5. Gagal mengassesment aduan " . $oldData->kode_aduan;
    //             return json_encode($response);
    //         }
    //     }
    // }

}
