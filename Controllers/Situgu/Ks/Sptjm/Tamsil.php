<?php

namespace App\Controllers\Situgu\Ks\Sptjm;

use App\Controllers\BaseController;
use App\Models\Situgu\Ks\SptjmModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Kehadiranptklib;
use App\Libraries\Uuid;
use App\Libraries\Downloadlib;
// use Smalot\PdfParser\Parser;
// use Smalot\PdfParser\Element\Image;
// use Smalot\PdfParser\Element\Text;
// use Smalot\PdfParser\Element\Rectangle;
// use Smalot\PdfParser\Element\Table;
// use Spatie\PdfToText\Pdf;
// use TCPDF;
// use setasign\Fpdi\Fpdi;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use mPDF;
use PhpOffice\PhpWord\TemplateProcessor;

class Tamsil extends BaseController
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
        $datamodel = new SptjmModel($request);

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


        $npsn = $this->_helpLib->getNpsn($userId);

        $lists = $datamodel->get_datatables($npsn, 'tamsil');
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->kode_usulan . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>';
            if ($list->is_locked !== 1) {
                if ($list->lampiran_sptjm == null || $list->lampiran_sptjm == "") {
                    $action .= '<a class="dropdown-item" href="javascript:actionUpload(\'' . $list->id . '\',\'' . $list->tahun . '\',\'' . $list->tw . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Upload Lampiran</a>';
                } else {
                    $action .= '<a class="dropdown-item" href="javascript:actionEditUpload(\'' . $list->id . '\',\'' . $list->tahun . '\',\'' . $list->tw . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Edit Lampiran</a>';
                }
            }
            $action .= '</div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->kode_usulan . '\', \'' . $list->id_tahun_tw . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
            //     </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->kode_usulan;
            $row[] = $list->tahun;
            $row[] = $list->tw;
            $row[] = $list->jumlah_ptk;
            if ($list->is_locked == 1) {
                $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/sekolah/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/sekolah/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
            } else {
                if ($list->lampiran_sptjm == null || $list->lampiran_sptjm == "") {
                    $row[] = '<a class="btn btn-sm btn-primary waves-effect waves-light" target="_blank" href="' . base_url('situgu/ks/sptjm/tamsil/download') . '?id=' . $list->id . '"><i class="bx bxs-cloud-download font-size-16 align-middle me-2"></i> Download</a>&nbsp;&nbsp;'
                        . '<a class="btn btn-sm btn-primary waves-effect waves-light" href="javascript:actionUpload(\'' . $list->id . '\',\'' . $list->tahun . '\',\'' . $list->tw . '\');"><i class="bx bxs-cloud-upload font-size-16 align-middle me-2"></i> Upload</a>';
                } else {
                    $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/sekolah/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/sekolah/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
                }
            }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($npsn, 'tamsil'),
            "recordsFiltered" => $datamodel->count_filtered($npsn, 'tamsil'),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/ks/sptjm/tamsil/data'));
    }

    public function data()
    {
        $data['title'] = 'SPTJM USULAN TUNJANGAN TAMSIL';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_tw')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
        return view('situgu/ks/sptjm/tamsil/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

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

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('tw');
            return json_encode($response);
        } else {
            $jenis_tunjangan = htmlspecialchars($this->request->getVar('id'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $current = $this->_db->table('v_temp_usulan')
                ->where(['jenis_tunjangan_usulan' => $jenis_tunjangan, 'status_usulan' => 2, 'id_tahun_tw' => $tw])->get()->getResult();

            if (count($current) > 0) {
                $data['data'] = $current;
                $data['tw'] = $tw;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/ks/sptjm/tamsil/add', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Tidak ada data untuk dibuatkan SPTJM.";
                return json_encode($response);
            }
        }
    }

    public function generatesptjm()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'jenis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis tidak boleh kosong. ',
                ]
            ],
            'jumlah' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jumlah tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'ptks' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'PTK terpilih tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('jenis')
                . $this->validator->getError('tw')
                . $this->validator->getError('jumlah')
                . $this->validator->getError('ptks');
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
            $canUsulTamsil = canUsulTamsil();

            if ($canUsulTamsil && $canUsulTamsil->code !== 200) {
                return json_encode($canUsulTamsil);
            }

            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $jumlah = htmlspecialchars($this->request->getVar('jumlah'), true);
            $ptks = $this->request->getVar('ptks');
            if (count($ptks) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Belum ada data ptk yang dipilih.";
                return json_encode($response);
            }

            $twActive = $this->_db->table('_ref_tahun_tw')->where('id', $tw)->get()->getRowObject();
            if (!$twActive) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengenerate SPTJM usulan tamsil. TW active tidak ditemukan.";
                return json_encode($response);
            }

            $id_ptks = implode(",", $ptks);

            $this->_db->transBegin();

            try {
                $this->_db->table('_tb_temp_usulan_detail')->where(['status_usulan' => 2, 'id_tahun_tw' => $twActive->id, 'jenis_tunjangan' => 'tamsil'])->whereIn('id_ptk', $ptks)->update(['status_usulan' => 5, 'updated_at' => date('Y-m-d H:i:s')]);
                if (!($this->_db->affectedRows() > 0)) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengenerate SPTJM usulan tamsil. gagal mengupdate status.";
                    return json_encode($response);
                }
            } catch (\Throwable $thU) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($thU);
                $response->message = "Gagal mengenerate SPTJM usulan tamsil. gagal mengupdate status.";
                return json_encode($response);
            }

            try {
                $uuidLib = new Uuid();
                $kodeUsulan = "TAMSIL-" . $twActive->tahun . '-' . $twActive->tw . '-' . $user->data->npsn . '-' . time();

                $this->_db->table('_tb_sptjm')->insert(
                    [
                        'id' => $uuidLib->v4(),
                        'kode_usulan' => $kodeUsulan,
                        'jumlah_ptk' => $jumlah,
                        'jenis_usulan' => 'tamsil',
                        'id_ptks' => $id_ptks,
                        'generate_sptjm' => 0,
                        'id_tahun_tw' => $twActive->id,
                        'npsn' => $user->data->npsn,
                        'kecamatan' => $user->data->kecamatan,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]
                );
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "SPTJM Usulan Tamsil Tahun {$twActive->tahun} TW {$twActive->tw} berhasil digenerate.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal Mengenerate SPTJM Usulan Tamsil.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal Mengenerate SPTJM Usulan Tamsil.";
                return json_encode($response);
            }
        }
    }

    public function download()
    {
        // if ($this->request->getMethod() != 'post') {
        //     $response = new \stdClass;
        //     $response->status = 400;
        //     $response->message = "Permintaan tidak diizinkan";
        //     return json_encode($response);
        // }

        // $rules = [
        //     'id' => [
        //         'rules' => 'required|trim',
        //         'errors' => [
        //             'required' => 'Id tidak boleh kosong. ',
        //         ]
        //     ],
        //     'tahun' => [
        //         'rules' => 'required|trim',
        //         'errors' => [
        //             'required' => 'Title tidak boleh kosong. ',
        //         ]
        //     ],
        //     'tw' => [
        //         'rules' => 'required|trim',
        //         'errors' => [
        //             'required' => 'Id PTK tidak boleh kosong. ',
        //         ]
        //     ],
        // ];

        // if (!$this->validate($rules)) {
        //     $response = new \stdClass;
        //     $response->status = 400;
        //     $response->message = $this->validator->getError('id')
        //         . $this->validator->getError('tahun')
        //         . $this->validator->getError('tw');
        //     return json_encode($response);
        // } else {
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

        $id = htmlspecialchars($this->request->getGet('id'), true);
        // $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
        // $tw = htmlspecialchars($this->request->getVar('tw'), true);

        $current = $this->_db->table('_tb_sptjm')->where('id', $id)->get()->getRowObject();
        if (!$current) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "SPTJM tidak ditemukan. Silahkan Generate terlebih dahulu.";
            return json_encode($response);
        }

        $ptks = explode(",", $current->id_ptks);
        $dataPtks = [];
        foreach ($ptks as $key => $value) {
            $ptk = $this->_db->table('v_temp_usulan')->where(['id_ptk_usulan' => $value, 'status_usulan' => 5, 'jenis_tunjangan_usulan' => 'tamsil'])->get()->getRowObject();
            if ($ptk) {
                $dataPtks[] = $ptk;
            }
        }

        $sekolah = $this->_db->table('ref_sekolah')->where('npsn', $user->data->npsn)->get()->getRowObject();
        if (!$sekolah) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Referensi sekolah tidak ditemukan.";
            return json_encode($response);
        }

        $idUser = $this->_helpLib->getPtkId($user->data->id);
        $ks = $this->_db->table('_ptk_tb')->where('id', $idUser)->get()->getRowObject();

        return $this->_download($dataPtks, $sekolah, $ks, $current);
        // }
    }

    private function _download($ptks, $sekolah, $ks, $usulan)
    {
        if (count($ptks) > 0) {
            $file = FCPATH . "upload/template/sptjm-tamsil-new-1.docx";
            $template_processor = new TemplateProcessor($file);
            $template_processor->setValue('NAMA_SEKOLAH', $sekolah->nama);
            $template_processor->setValue('NPSN_SEKOLAH', $sekolah->npsn);
            $alamat = $sekolah->alamat_jalan ? ($sekolah->alamat_jalan !== "" ? $sekolah->alamat_jalan : "-") : "-";
            $template_processor->setValue('ALAMAT_SEKOLAH', $alamat);
            $template_processor->setValue('KECAMATAN_SEKOLAH', $sekolah->kecamatan);
            $template_processor->setValue('KABUPATEN_SEKOLAH', getenv('setting.utpg.kabupaten'));
            $template_processor->setValue('PROV_SEKOLAH', getenv('setting.utpg.provinsi'));
            $no_telp = $sekolah->no_telepon ? ($sekolah->no_telepon !== "" ? $sekolah->no_telepon : "-") : "-";
            $template_processor->setValue('TELP_SEKOLAH', $no_telp);
            $email = $sekolah->email ? ($sekolah->email !== "" ? $sekolah->email : "-") : "-";
            $template_processor->setValue('EMAIL_SEKOLAH', $no_telp);
            $template_processor->setValue('TW_TW', $ptks[0]->tw_tw);
            $template_processor->setValue('TW_TAHUN', $ptks[0]->tw_tahun);
            $template_processor->setValue('NOMOR_SPTJM', $usulan->kode_usulan);
            $nama_ks = "";
            if ($ks->gelar_depan && ($ks->gelar_depan !== "" || $ks->gelar_depan !== "-")) {
                $nama_ks .= $ks->gelar_depan;
            }
            $nama_ks .= $ks->nama;
            if ($ks->gelar_belakang && ($ks->gelar_belakang !== "" || $ks->gelar_belakang !== "-")) {
                $nama_ks .= $ks->gelar_belakang;
            }
            $template_processor->setValue('NAMA_KS', $nama_ks);
            $jabatan_ks = $ks->jabatan_ks_plt ? ($ks->jabatan_ks_plt == 0 ? "Kepala Sekolah" : "Plt. Kepala Sekolah") : "Kepala Sekolah";
            $template_processor->setValue('JABATAN_KS', $jabatan_ks);
            $template_processor->setValue('JUMLAH_PTK', $usulan->jumlah_ptk);
            $template_processor->setValue('TANGGAL_SPTJM', tgl_indo(date('Y-m-d')));
            $nipKs = "";
            if ($ks->nip && ($ks->nip !== "" || $ks->nip !== "-")) {
                $nipKs .= $ks->nip;
            } else {
                $nipKs .= "-";
            }
            $template_processor->setValue('NIP_KS', $nipKs);

            $dataPtnya = [];
            foreach ($ptks as $key => $v) {
                $dataPtnya[] = [
                    'NO' => $key + 1,
                    'NRG' => $v->nrg,
                    'NOPES' => $v->no_peserta,
                    'NUPTK' => $v->nuptk,
                    'NIP' => $v->nip,
                    'NAMA' => $v->nama,
                    'GOL' => $v->us_pang_golongan,
                    'TH' => $v->us_pang_mk_tahun,
                    'BL' => $v->us_pang_mk_bulan,
                    'GAPOK' => rpTanpaAwalan($v->us_gaji_pokok),
                    'JB' => 3,
                    'JU' => rpTanpaAwalan(($v->us_gaji_pokok * 3)),
                    'PPH' => "15%",
                    'JD' => rpTanpaAwalan(($v->us_gaji_pokok * 3)),
                    'NPWP' => $v->npwp,
                    'NOREK' => $v->no_rekening,
                    'BANK' => $v->cabang_bank,
                ];
            }
            $template_processor->cloneRowAndSetValues('NO', $dataPtnya);
            $template_processor->setImageValue('BARCODE', array('path' => 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=layanan.disdikbud.kntechline.id/verifiqrcode?token=' . $usulan->kode_usulan . '&choe=UTF-8', 'width' => 150, 'height' => 150, 'ratio' => false));

            $filed = FCPATH . "upload/generate/sptjm/tamsil/word/" . $usulan->kode_usulan . ".docx";

            $template_processor->saveAs($filed);

            $downloadLib = new Downloadlib();

            $filePdf =  $downloadLib->downloaded($filed, $usulan->kode_usulan . ".pdf");

            $this->response->setHeader('Content-Type', 'application/octet-stream');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . basename($filePdf) . '"');
            $this->response->setHeader('Content-Length', filesize($filePdf));
            return $this->response->download($filePdf, null);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mendownload SPTJM.";
            return json_encode($response);
        }
    }

    public function formupload()
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
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('tahun')
                . $this->validator->getError('tw');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $data['tahun'] = $tahun;
            $data['tw'] = $tw;
            $data['id'] = $id;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ks/sptjm/tamsil/upload', $data);
            return json_encode($response);
        }
    }

    public function uploadSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tahun tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar dan pdf. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('tahun')
                . $this->validator->getError('id')
                . $this->validator->getError('tw')
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

            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $current = $this->_db->table('_tb_sptjm')->where(['id' => $id])->get()->getRowObject();

            if (!$current) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "upload/sekolah/sptjm";
            $field_db = 'lampiran_sptjm';
            $table_db = '_tb_sptjm';

            $lampiran = $this->request->getFile('_file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_file($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data[$field_db] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table($table_db)->where(['id' => $id, 'is_locked' => 0])->update($data);
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
                $ptks = explode(",", $current->id_ptks);
                $dataPtks = [];
                foreach ($ptks as $key => $value) {
                    $ptk = $this->_db->table('_tb_temp_usulan_detail')->where(['id_ptk' => $value, 'status_usulan' => 5, 'jenis_tunjangan' => 'tamsil'])->get()->getRowObject();
                    if ($ptk) {
                        $this->_db->table('_tb_usulan_detail_tamsil')->insert([
                            'id' => $ptk->id,
                            'kode_usulan' => $current->kode_usulan,
                            'id_ptk' => $ptk->id_ptk,
                            'id_tahun_tw' => $ptk->id_tahun_tw,
                            'us_pang_golongan' => $ptk->us_pang_golongan,
                            'us_pang_tmt' => $ptk->us_pang_tmt,
                            'us_pang_tgl' => $ptk->us_pang_tgl,
                            'us_pang_mk_tahun' => $ptk->us_pang_mk_tahun,
                            'us_pang_mk_bulan' => $ptk->us_pang_mk_bulan,
                            'us_pang_jenis' => $ptk->us_pang_jenis,
                            'us_gaji_pokok' => $ptk->us_gaji_pokok,
                            'status_usulan' => 0,
                            'date_approve_ks' => $ptk->admin_approve,
                            'date_approve_sptjm' => date('Y-m-d H:i:s'),
                            'created_at' => $ptk->created_at,
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->table('_tb_temp_usulan_detail')->where(['id' => $ptk->id, 'status_usulan' => 5, 'jenis_tunjangan' => 'tamsil'])->delete();
                            if ($this->_db->affectedRows() > 0) {
                                continue;
                            } else {
                                unlink($dir . '/' . $newNamelampiran);

                                $this->_db->transRollback();
                                $response = new \stdClass;
                                $response->status = 400;
                                $response->message = "Gagal memindahkan data usulan.";
                                return json_encode($response);
                            }
                        } else {
                            unlink($dir . '/' . $newNamelampiran);

                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal mengupdate data usulan.";
                            return json_encode($response);
                        }
                    }
                }

                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
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
}
