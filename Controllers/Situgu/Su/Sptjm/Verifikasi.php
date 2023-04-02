<?php

namespace App\Controllers\Situgu\Su\Sptjm;

use App\Controllers\BaseController;
use App\Models\Situgu\Su\SptjmverifikasiModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;
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

class Verifikasi extends BaseController
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
        $datamodel = new SptjmverifikasiModel($request);

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

        $lists = $datamodel->get_datatables();
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->kode_verifikasi . '\', \'' . $list->kode_usulan . '\', \'' . $list->id_tahun_tw . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>';
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
            $row[] = $list->fullname;
            $row[] = $list->jabatan;
            $row[] = $list->kode_verifikasi;
            $row[] = $list->tahun;
            $row[] = $list->tw;
            $row[] = $list->jumlah_ptk;
            if ($list->is_locked == 1) {
                $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
            } else {
                if ($list->lampiran_sptjm == null || $list->lampiran_sptjm == "") {
                    $row[] = '<span class="badge rounded-pill badge-soft-danger">Belum Generate / Upload</span>';
                } else {
                    $row[] = '<a target="popup" onclick="window.open(\'' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '\',\'popup\',\'width=600,height=600\'); return false;" href="' . base_url('upload/verifikasi/sptjm') . '/' . $list->lampiran_sptjm . '"><span class="badge rounded-pill badge-soft-dark">Lihat</span></a>';
                }
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
        return redirect()->to(base_url('situgu/su/sptjm/verifikasi/data'));
    }

    public function data()
    {
        $data['title'] = 'SPTJM VERIFIKASI ADMIN, OPK, DAN OPSR';
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
        return view('situgu/su/sptjm/verifikasi/index', $data);
    }
    public function detail()
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
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tahun tidak boleh kosong. ',
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
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);

            $currents = $this->_db->table('_tb_sptjm_verifikasi a')
                ->select("a.id, a.kode_verifikasi, a.kode_usulan, a.id_ptks, a.id_tahun_tw, a.aksi, a.keterangan, a.created_at, b.nama as nama_ptk, b.nuptk, b.npsn, b.tempat_tugas as nama_sekolah")
                ->join('_ptk_tb b', 'a.id_ptks = b.id')
                ->where('kode_verifikasi', $id)
                ->get()->getResult();

            if (count($currents) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan. Silahkan Generate terlebih dahulu.";
                return json_encode($response);
            }

            $data['data'] = $currents;
            $data['tw'] = $tw;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/su/sptjm/verifikasi/detail', $data);
            return json_encode($response);
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('jenis')
                . $this->validator->getError('tw')
                . $this->validator->getError('jumlah');
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

            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $jumlah = htmlspecialchars($this->request->getVar('jumlah'), true);

            $twActive = $this->_db->table('_ref_tahun_tw')->where('id', $tw)->get()->getRowObject();
            if (!$twActive) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengenerate SPTJM verifikasi TPG. TW active tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();

            try {
                $kodeVerifikasi = "VTPG-" . $twActive->tahun . '-' . $twActive->tw . '-' . time();

                $this->_db->table('_tb_sptjm_verifikasi')
                    ->where(['jenis_usulan' => 'tpg', 'generate_sptjm' => 0, 'user_id' => $user->data->id, 'id_tahun_tw' => $tw])
                    ->update(
                        [
                            'generate_sptjm' => 1,
                            'kode_verifikasi' => $kodeVerifikasi,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "SPTJM Verifikasi TPG Tahun {$twActive->tahun} TW {$twActive->tw} berhasil digenerate.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal Mengenerate SPTJM Verifikasi TPG.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal Mengenerate SPTJM Verifikasi TPG.";
                return json_encode($response);
            }
        }
    }

    public function download()
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

        $id = htmlspecialchars($this->request->getGet('id'), true);

        $currents = $this->_db->table('_tb_sptjm_verifikasi a')
            ->select("a.id, a.kode_verifikasi, a.kode_usulan, a.id_ptks, a.id_tahun_tw, a.aksi, a.keterangan, a.created_at, b.nama as nama_ptk, b.nuptk, b.npsn, b.tempat_tugas as nama_sekolah")
            ->join('_ptk_tb b', 'a.id_ptks = b.id')
            ->where('kode_verifikasi', $id)
            ->where("lampiran_sptjm IS NULL")
            ->get()->getResult();
        if (count($currents) < 1) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "SPTJM tidak ditemukan. Silahkan Generate terlebih dahulu.";
            return json_encode($response);
        }

        $twActive = $this->_db->table('_ref_tahun_tw')->where('id', $currents[0]->id_tahun_tw)->get()->getRowObject();
        if (!$twActive) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mendowload SPTJM verifikasi TPG. TW active tidak ditemukan.";
            return json_encode($response);
        }

        $userDetail = $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->get()->getRowObject();

        return $this->_download($currents, $user->data, $twActive, $userDetail);
        // }
    }

    private function _download($ptks, $user, $tw, $userDetail)
    {
        if (count($ptks) > 0) {
            $file = FCPATH . "upload/template/sptjm-verifikasi-tpg-new-1.docx";
            $template_processor = new TemplateProcessor($file);
            $template_processor->setValue('TW_TW', $tw->tw);
            $template_processor->setValue('TW_TAHUN', $tw->tahun);
            $template_processor->setValue('NOMOR_SPTJM', $ptks[0]->kode_verifikasi);

            $template_processor->setValue('NAMA_ADMIN', $user->fullname);
            $jabatan = $user->role_user == 3 ? 'Admin Kecamatan' : 'Admin Sub Rayon';
            $template_processor->setValue('JABATAN_ADMIN', $jabatan);
            $userD = $userDetail->jabatan == NULL || $userDetail->jabatan == "" ? '' : $userDetail->jabatan;
            $template_processor->setValue('KECAMATAN_SUB._RAYON', $userD);
            $template_processor->setValue('KECAMATAN_SUB_RAYON', $userD);
            $template_processor->setValue('JUMLAH_PTK', count($ptks));
            $template_processor->setValue('TANGGAL_SPTJM', tgl_indo(date('Y-m-d')));

            $dataPtnya = [];
            foreach ($ptks as $key => $v) {
                $dataPtnya[] = [
                    'NO' => $key + 1,
                    'KODE_USULAN' => $v->kode_usulan,
                    'NAMA_PTK' => $v->nama_ptk,
                    'NUPTK' => $v->nuptk,
                    'NPSN' => $v->npsn,
                    'NAMA_SEKOLAH' => $v->nama_sekolah,
                    'STATUS' => $v->aksi,
                    'KETERANGAN' => $v->keterangan,
                    'WAKTU' => $v->created_at,
                ];
            }
            $template_processor->cloneRowAndSetValues('NO', $dataPtnya);
            $template_processor->setImageValue('BARCODE', array('path' => 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=layanan.disdikbud.lampungtengahkab.go.id/verifiqrcodev?token=' . $ptks[0]->kode_verifikasi . '&choe=UTF-8', 'width' => 150, 'height' => 150, 'ratio' => false));

            $filed = FCPATH . "upload/generate/verifikasi/tpg/word/" . $ptks[0]->kode_verifikasi . ".docx";

            $template_processor->saveAs($filed);



            $downloadLib = new Downloadlib();

            $responseD =  $downloadLib->downloaded($filed, $ptks[0]->kode_verifikasi . ".pdf", "tpg");

            return $responseD;
            // if ($responseD->status == 200) {
            //     $filePdf = $responseD->file;
            // $this->response->setHeader('Content-Type', 'application/octet-stream');
            //     $this->response->setHeader('Content-Disposition', 'attachment; filename="' . basename($filePdf) . '"');
            //     $this->response->setHeader('Content-Length', filesize($filePdf));
            //     return $this->response->download($filePdf, null);
            // } else {
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->error = $responseD;
            //     $response->message = "Gagal mendownload SPTJM.";
            //     return json_encode($response);
            // }
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mendownload SPTJM.";
            return json_encode($response);
        }
    }

    public function formuploadedit()
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

            $current = $this->_db->table('_tb_sptjm_verifikasi')->where(['kode_verifikasi' => $id])->get()->getResult();

            if (count($current) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan.";
                return json_encode($response);
            }

            foreach ($current as $key => $value) {
                if ($value->is_locked == 1) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data SPTJM ini sudah diverifikasi, sehingga tidak diperkenankan untuk mengedit.";
                    return json_encode($response);
                }
            }

            $data['data'] = $current;
            $data['tahun'] = $tahun;
            $data['tw'] = $tw;
            $data['id'] = $id;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/opsr/sptjm/tpg/upload_edit', $data);
            return json_encode($response);
        }
    }

    public function uploadEditSave()
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

            $current = $this->_db->table('_tb_sptjm_verifikasi')->where(['kode_verifikasi' => $id])->get()->getResult();

            if (count($current) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan.";
                return json_encode($response);
            }

            foreach ($current as $key => $value) {
                if ($value->is_locked == 1) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data SPTJM ini sudah diverifikasi, sehingga tidak diperkenankan untuk mengedit.";
                    return json_encode($response);
                }
            }

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "upload/verifikasi/sptjm";
            $field_db = 'lampiran_sptjm';
            $table_db = '_tb_sptjm_verifikasi';

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
                $this->_db->table($table_db)->where(['kode_verifikasi' => $id, 'is_locked' => 0])->update($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);

                $this->_db->transRollback();

                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($e);
                $response->message = "Gagal mengupdate data.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    unlink($dir . '/' . $current[0]->lampiran_sptjm);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);

                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupdate data";
                return json_encode($response);
            }
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
            $response->data = view('situgu/opsr/sptjm/tpg/upload', $data);
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

            $current = $this->_db->table('_tb_sptjm_verifikasi')->where(['kode_verifikasi' => $id])->get()->getResult();

            if (count($current) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "SPTJM tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "upload/verifikasi/sptjm";
            $field_db = 'lampiran_sptjm';
            $table_db = '_tb_sptjm_verifikasi';

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
                $this->_db->table($table_db)->where(['kode_verifikasi' => $id, 'is_locked' => 0])->update($data);
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
