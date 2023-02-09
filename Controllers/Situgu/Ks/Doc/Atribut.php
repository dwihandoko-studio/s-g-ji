<?php

namespace App\Controllers\Situgu\Ks\Doc;

use App\Controllers\BaseController;
use App\Models\Situgu\Ks\AtributModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

class Atribut extends BaseController
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
        $datamodel = new AtributModel($request);

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
        $id = $this->_helpLib->getPtkId($userId);
        $lists = $datamodel->get_datatables($id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $list->tahun;
            $row[] = $list->tw;
            $row[] = $list->pang_golongan;
            $row[] = $list->pang_no;
            $row[] = $list->pang_tmt;
            $row[] = $list->pang_tgl;
            $row[] = $list->pang_tahun;
            $row[] = $list->pang_bulan;

            switch ($list->is_locked) {
                case 1:
                    $row[] = $list->pangkat_terakhir ? '<a href="' . base_url('upload/ptk/pangkat') . '/' . $list->pangkat_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pangkat</span></a>' : '-';
                    $row[] = $list->kgb_terakhir ? '<a href="' . base_url('upload/ptk/kgb') . '/' . $list->kgb_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran KGB</span></a>' : '-';
                    $row[] = $list->pernyataan_24jam ? '<a href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->pernyataan_24jam . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pernyataan</span></a>' : '-';
                    $row[] = $list->cuti ? '<a href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->cuti . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Cuti</span></a>' : '-';
                    $row[] = $list->pensiun ? '<a href="' . base_url('upload/ptk/pensiun') . '/' . $list->pensiun . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pensiun</span></a>' : '-';
                    $row[] = $list->kematian ? '<a href="' . base_url('upload/ptk/kematian') . '/' . $list->kematian . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Kematian</span></a>' : '-';
                    $row[] = $list->lainnya ? '<a href="' . base_url('upload/ptk/lainnya') . '/' . $list->lainnya . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Atribut Lainnya</span></a>' : '-';
                    $row[] = '<div class="text-center">
                    <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                    </div>';
                    break;
                default:
                    if ($list->status_kepegawaian === "PNS" || $list->status_kepegawaian === "PPPK" || $list->status_kepegawaian === "PNS Diperbantukan" || $list->status_kepegawaian === "PNS Depag" || $list->status_kepegawaian === "CPNS") {
                        $row[] = $list->pangkat_terakhir ? '<a target="_blank" href="' . base_url('upload/ptk/pangkat') . '/' . $list->pangkat_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pangkat_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->kgb_terakhir ? '<a target="_blank" href="' . base_url('upload/ptk/kgb') . '/' . $list->kgb_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kgb_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->pernyataan_24jam ? '<a target="_blank" href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->pernyataan_24jam . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pernyataan_24jam . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->cuti ? '<a target="_blank" href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->cuti . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->pensiun ? '<a target="_blank" href="' . base_url('upload/ptk/pensiun') . '/' . $list->pensiun . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->kematian ? '<a target="_blank" href="' . base_url('upload/ptk/kematian') . '/' . $list->kematian . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->lainnya ? '<a target="_blank" href="' . base_url('upload/ptk/lainnya') . '/' . $list->lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    } else {
                        $row[] = '-';
                        $row[] = '-';
                        $row[] = $list->pernyataan_24jam ? '<a target="_blank" href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->pernyataan_24jam . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pernyataan_24jam . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->cuti ? '<a target="_blank" href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->cuti . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->pensiun ? '<a target="_blank" href="' . base_url('upload/ptk/pensiun') . '/' . $list->pensiun . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->kematian ? '<a target="_blank" href="' . base_url('upload/ptk/kematian') . '/' . $list->kematian . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->lainnya ? '<a target="_blank" href="' . base_url('upload/ptk/lainnya') . '/' . $list->lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    }
                    $row[] = '<div class="text-center">
                <span class="badge rounded-pill badge-soft-danger font-size-11">Terbuka</span>
            </div>';
                    break;
            }
            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($id),
            "recordsFiltered" => $datamodel->count_filtered($id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/ks/doc/atribut/data'));
    }

    public function data()
    {
        $data['title'] = 'DOKUMEN ATRIBUT';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $id = $this->_helpLib->getPtkId($user->data->id);
        $data['ptk'] = $this->_db->table('_ptk_tb')->where('id', $id)->get()->getRowObject();

        return view('situgu/ks/doc/atribut/index', $data);
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
            $response->message = "Permintaan diizinkan";
            return json_encode($response);
        }

        $data['tw'] = $this->_db->table('_ref_tahun_tw')->orderBy('is_current', 'DESC')->orderBy('tahun', 'DESC')->orderBy('tw', 'DESC')->get()->getResult();

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('situgu/ks/doc/atribut/add', $data);
        return json_encode($response);
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
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('tw');
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

            $id = $this->_helpLib->getPtkId($user->data->id);
            $ptkNya = $this->_db->table('_ptk_tb')->where('id', $id)->get()->getRowObject();

            if (!$ptkNya) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "PTK tidak ditemukan.";
                return json_encode($response);
            }

            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $cekData = $this->_db->table('_upload_data_attribut')->where(['id_tahun_tw' => $tw, 'id_ptk' => $ptkNya->id])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 201;
                $response->message = "Data atribut sudah ada.";
                return json_encode($response);
            }

            $uuidLib = new Uuid();
            $data = [
                'id' => $uuidLib->v4(),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $data['id_tahun_tw'] = $tw;
            $data['id_ptk'] = $ptkNya->id;
            $data['pang_golongan'] = $ptkNya->pangkat_golongan;
            $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
            $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
            $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
            $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
            $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
            $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);

            $this->_db->transBegin();

            try {
                $this->_db->table('_upload_data_attribut')->insert($data);
                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data berhasil disimpan.";
                    $response->data = $data;
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            } catch (\Throwable $th) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($th);
                $response->message = "Gagal menyimpan data.";
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
            'bulan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bulan tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'title' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
            'id_ptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('bulan')
                . $this->validator->getError('tw')
                . $this->validator->getError('title')
                . $this->validator->getError('id_ptk');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['title'] = $title;
            $data['id_ptk'] = $id_ptk;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ks/doc/atribut/upload', $data);
            return json_encode($response);
        }
    }

    public function editformupload()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'bulan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bulan tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'title' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
            'old' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Old tidak boleh kosong. ',
                ]
            ],
            'id_ptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('bulan')
                . $this->validator->getError('tw')
                . $this->validator->getError('title')
                . $this->validator->getError('old')
                . $this->validator->getError('id_ptk');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['title'] = $title;
            $data['old'] = $old;
            $data['id_ptk'] = $id_ptk;
            switch ($bulan) {
                case 'pangkat':
                    $data['old_url'] = base_url('upload/ptk/pangkat') . '/' . $old;
                    break;
                case 'kgb':
                    $data['old_url'] = base_url('upload/ptk/kgb') . '/' . $old;
                    break;
                case 'pernyataan24':
                    $data['old_url'] = base_url('upload/ptk/pernyataanindividu') . '/' . $old;
                    break;
                case 'cuti':
                    $data['old_url'] = base_url('upload/ptk/keterangancuti') . '/' . $old;
                    break;
                case 'pensiun':
                    $data['old_url'] = base_url('upload/ptk/pensiun') . '/' . $old;
                    break;
                case 'kematian':
                    $data['old_url'] = base_url('upload/ptk/kematian') . '/' . $old;
                    break;
                case 'attr_lainnya':
                    $data['old_url'] = base_url('upload/ptk/lainnya') . '/' . $old;
                    break;
                default:
                    $data['old_url'] = base_url('upload/sekolah/doc-lainnya') . '/' . $old;
                    break;
            }

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ks/doc/atribut/editupload', $data);
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
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Name tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
            'id_ptk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
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
            $response->message = $this->validator->getError('name')
                . $this->validator->getError('tw')
                . $this->validator->getError('id_ptk')
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

            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';
            $table_db = '';

            switch ($name) {
                case 'pangkat':
                    $dir = FCPATH . "upload/ptk/pangkat";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'kgb':
                    $dir = FCPATH . "upload/ptk/kgb";
                    $field_db = 'kgb_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'pernyataan24':
                    $dir = FCPATH . "upload/ptk/pernyataanindividu";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'cuti':
                    $dir = FCPATH . "upload/ptk/keterangancuti";
                    $field_db = 'cuti';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'pensiun':
                    $dir = FCPATH . "upload/ptk/pensiun";
                    $field_db = 'pensiun';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'kematian':
                    $dir = FCPATH . "upload/ptk/kematian";
                    $field_db = 'kematian';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'attr_lainnya':
                    $dir = FCPATH . "upload/ptk/lainnya";
                    $field_db = 'lainnya';
                    $table_db = '_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '_absen_kehadiran';
                    break;
            }

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

            $ptkNya = $this->_db->table('_ptk_tb')->where('id', $id_ptk)->get()->getRowObject();

            if (!$ptkNya) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "PTK Tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $cekCurrent = $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk])->countAllResults();
                if ($cekCurrent > 0) {
                    $data['pang_golongan'] = $ptkNya->pangkat_golongan;
                    $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
                    $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
                    $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
                    $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
                    $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
                    $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);
                    $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk, 'is_locked' => 0])->update($data);
                } else {
                    $uuidLib = new Uuid();
                    $data['id'] = $uuidLib->v4();
                    $data['id_tahun_tw'] = $tw;
                    $data['id_ptk'] = $id_ptk;
                    $data['pang_golongan'] = $ptkNya->pangkat_golongan;
                    $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
                    $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
                    $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
                    $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
                    $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
                    $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $this->_db->table($table_db)->insert($data);
                }
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

    public function editUploadSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Name tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
            'old' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Old tidak boleh kosong. ',
                ]
            ],
            'id_ptk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
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
            $response->message = $this->validator->getError('name')
                . $this->validator->getError('tw')
                . $this->validator->getError('old')
                . $this->validator->getError('id_ptk')
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

            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';
            $table_db = '';

            switch ($name) {
                case 'pangkat':
                    $dir = FCPATH . "upload/ptk/pangkat";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'kgb':
                    $dir = FCPATH . "upload/ptk/kgb";
                    $field_db = 'kgb_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'pernyataan24':
                    $dir = FCPATH . "upload/ptk/pernyataanindividu";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'cuti':
                    $dir = FCPATH . "upload/ptk/keterangancuti";
                    $field_db = 'cuti';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'pensiun':
                    $dir = FCPATH . "upload/ptk/pensiun";
                    $field_db = 'pensiun';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'kematian':
                    $dir = FCPATH . "upload/ptk/kematian";
                    $field_db = 'kematian';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'attr_lainnya':
                    $dir = FCPATH . "upload/ptk/lainnya";
                    $field_db = 'lainnya';
                    $table_db = '_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '_absen_kehadiran';
                    break;
            }

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

            $ptkNya = $this->_db->table('_ptk_tb')->where('id', $id_ptk)->get()->getRowObject();

            if (!$ptkNya) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "PTK Tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $data['pang_golongan'] = $ptkNya->pangkat_golongan;
                $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
                $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
                $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
                $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
                $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
                $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);
                $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk, 'is_locked' => 0])->update($data);
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
                try {
                    unlink($dir . '/' . $old);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
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
