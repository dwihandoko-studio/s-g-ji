<?php

namespace App\Controllers\Situpeng\Peng\Doc;

use App\Controllers\BaseController;
use App\Models\Situpeng\Peng\AtributModel;
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
        $id = $this->_helpLib->getPengawasId($userId);
        $lists = $datamodel->get_datatables($id);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                        <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->id . '\', \'' . $list->tahun . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->tw)) . '\');"><i class="bx bxs-edit-alt font-size-16 align-middle"></i> &nbsp;Edit</a>
                        <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . $list->tahun . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->tw))  . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                        </div>
                    </div>';

            $row[] = $no;
            $row[] = $action;
            $row[] = $list->tahun;
            $row[] = $list->tw;
            if ($list->pang_golongan == NULL || $list->pang_golongan == "") {
                $row[] = '<a class="dropdown-item" href="javascript:actionEdit(\'' . $list->id . '\', \'' . $list->tahun . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->tw)) . '\');"><i class="bx bxs-edit-alt font-size-16 align-middle"></i> &nbsp;Edit</a>';
            } else {
                $row[] = $list->pang_golongan;
            }
            $row[] = $list->pang_no;
            $row[] = $list->pang_tmt;
            $row[] = $list->pang_tgl;
            $row[] = $list->pang_tahun;
            $row[] = $list->pang_bulan;

            switch ($list->is_locked) {
                case 1:
                    $row[] = $list->pangkat_terakhir ? '<a href="' . base_url('upload/pengawas/pangkat') . '/' . $list->pangkat_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pangkat</span></a>' : '-';
                    $row[] = $list->kgb_terakhir ? '<a href="' . base_url('upload/pengawas/kgb') . '/' . $list->kgb_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran KGB</span></a>' : '-';
                    // $row[] = $list->pernyataan_24jam ? '<a href="' . base_url('upload/pengawas/pernyataanindividu') . '/' . $list->pernyataan_24jam . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pernyataan</span></a>' : '-';
                    $row[] = $list->penugasan ? '<a href="' . base_url('upload/pengawas/penugasan') . '/' . $list->penugasan . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Penugasan</span></a>' : '-';
                    $row[] = $list->kunjungan_binaan ? '<a href="' . base_url('upload/pengawas/kunjunganbinaan') . '/' . $list->kunjungan_binaan . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Ket. Kunjungan Binaan</span></a>' : '-';
                    $row[] = $list->cuti ? '<a href="' . base_url('upload/pengawas/keterangancuti') . '/' . $list->cuti . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Cuti</span></a>' : '-';
                    $row[] = $list->pensiun ? '<a href="' . base_url('upload/pengawas/pensiun') . '/' . $list->pensiun . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pensiun</span></a>' : '-';
                    $row[] = $list->kematian ? '<a href="' . base_url('upload/pengawas/kematian') . '/' . $list->kematian . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Kematian</span></a>' : '-';
                    $row[] = $list->lainnya ? '<a href="' . base_url('upload/pengawas/lainnya') . '/' . $list->lainnya . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Atribut Lainnya</span></a>' : '-';
                    $row[] = '<div class="text-center">
                    <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                    </div>';
                    break;
                default:
                    $row[] = $list->pangkat_terakhir ? '<a target="_blank" href="' . base_url('upload/pengawas/pangkat') . '/' . $list->pangkat_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pangkat_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->kgb_terakhir ? '<a target="_blank" href="' . base_url('upload/pengawas/kgb') . '/' . $list->kgb_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kgb_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionHapusFile(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kgb_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="mdi mdi-trash-can-outline font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    // $row[] = $list->pernyataan_24jam ? '<a target="_blank" href="' . base_url('upload/pengawas/pernyataanindividu') . '/' . $list->pernyataan_24jam . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    // </a>
                    // <a href="javascript:actionEditFile(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pernyataan_24jam . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    //     <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    // </a>' :
                    //     '<a href="javascript:actionUpload(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                    //     <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    // </a>';
                    $row[] = $list->penugasan ? '<a target="_blank" href="' . base_url('upload/pengawas/penugasan') . '/' . $list->penugasan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Penugasan\',\'penugasan\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->penugasan . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Penugasan\',\'penugasan\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->kunjungan_binaan ? '<a target="_blank" href="' . base_url('upload/pengawas/kunjunganbinaan') . '/' . $list->kunjungan_binaan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Kunjungan Binaan\',\'kunjunganbinaan\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kunjungan_binaan . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Kunjungan Binaan\',\'kunjunganbinaan\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->cuti ? '<a target="_blank" href="' . base_url('upload/pengawas/keterangancuti') . '/' . $list->cuti . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionHapusFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="mdi mdi-trash-can-outline font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->pensiun ? '<a target="_blank" href="' . base_url('upload/pengawas/pensiun') . '/' . $list->pensiun . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionHapusFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="mdi mdi-trash-can-outline font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->kematian ? '<a target="_blank" href="' . base_url('upload/pengawas/kematian') . '/' . $list->kematian . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionHapusFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="mdi mdi-trash-can-outline font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lainnya ? '<a target="_blank" href="' . base_url('upload/pengawas/lainnya') . '/' . $list->lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionHapusFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\',\'' . $list->lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="mdi mdi-trash-can-outline font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->id_ptk . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';

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
        return redirect()->to(base_url('situpeng/peng/doc/atribut/data'));
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
        $ptk = $this->_db->table('__pengawas_tb')->where('id', $user->data->ptk_id)->get()->getRowObject();

        if (!$ptk) {
            return view('404', $data);
        }

        $data['ptk'] = $ptk;

        return view('situpeng/peng/doc/atribut/index', $data);
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
        $response->data = view('situpeng/peng/doc/atribut/add', $data);
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

            $ptkNya = $this->_db->table('__pengawas_tb')->where('id', $user->data->ptk_id)->get()->getRowObject();

            if (!$ptkNya) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "PTK tidak ditemukan.";
                return json_encode($response);
            }

            if ($ptkNya->nik == NULL || $ptkNya->nik == "") {
                $response = new \stdClass;
                $response->status = 401;
                $response->redirrect = base_url('situpeng/peng/masterdata/individu');
                $response->message = "Data individu belum lengkap, silahkan lengkapi terlebih dahulu.";
                return json_encode($response);
            }

            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $cekData = $this->_db->table('__pengawas_upload_data_attribut')->where(['id_tahun_tw' => $tw, 'id_ptk' => $ptkNya->id])->get()->getRowObject();

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
                $this->_db->table('__pengawas_upload_data_attribut')->insert($data);
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
            $response->data = view('situpeng/peng/doc/atribut/upload', $data);
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
                    $data['old_url'] = base_url('upload/pengawas/pangkat') . '/' . $old;
                    break;
                case 'kgb':
                    $data['old_url'] = base_url('upload/pengawas/kgb') . '/' . $old;
                    break;
                case 'pernyataan24':
                    $data['old_url'] = base_url('upload/pengawas/pernyataanindividu') . '/' . $old;
                    break;
                case 'penugasan':
                    $data['old_url'] = base_url('upload/pengawas/penugasan') . '/' . $old;
                    break;
                case 'kunjunganbinaan':
                    $data['old_url'] = base_url('upload/pengawas/kunjunganbinaan') . '/' . $old;
                    break;
                case 'cuti':
                    $data['old_url'] = base_url('upload/pengawas/keterangancuti') . '/' . $old;
                    break;
                case 'pensiun':
                    $data['old_url'] = base_url('upload/pengawas/pensiun') . '/' . $old;
                    break;
                case 'kematian':
                    $data['old_url'] = base_url('upload/pengawas/kematian') . '/' . $old;
                    break;
                case 'attr_lainnya':
                    $data['old_url'] = base_url('upload/pengawas/lainnya') . '/' . $old;
                    break;
                default:
                    $data['old_url'] = base_url('upload/pengawas/doc-lainnya') . '/' . $old;
                    break;
            }

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situpeng/peng/doc/atribut/editupload', $data);
            return json_encode($response);
        }
    }

    public function hapusfile()
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

            switch ($bulan) {
                case 'pangkat':
                    $dir = FCPATH . "upload/pengawas/pangkat";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kgb':
                    $dir = FCPATH . "upload/pengawas/kgb";
                    $field_db = 'kgb_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pernyataan24':
                    $dir = FCPATH . "upload/pengawas/pernyataanindividu";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'penugasan':
                    $dir = FCPATH . "upload/pengawas/penugasan";
                    $field_db = 'penugasan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kunjunganbinaan':
                    $dir = FCPATH . "upload/pengawas/kunjunganbinaan";
                    $field_db = 'kunjungan_binaan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'cuti':
                    $dir = FCPATH . "upload/pengawas/keterangancuti";
                    $field_db = 'cuti';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pensiun':
                    $dir = FCPATH . "upload/pengawas/pensiun";
                    $field_db = 'pensiun';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kematian':
                    $dir = FCPATH . "upload/pengawas/kematian";
                    $field_db = 'kematian';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'attr_lainnya':
                    $dir = FCPATH . "upload/pengawas/lainnya";
                    $field_db = 'lainnya';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/pengawas/doc-lainnya";
                    $field_db = 'qrcode';
                    $table_db = 'info_gtk';
                    break;
            }

            $currentFile = $this->_db->table($table_db)->select("$field_db AS file, id")->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk, 'is_locked' => 0])->get()->getRowObject();
            if (!$currentFile) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menghapus file. Data tidak ditemukan.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table($table_db)->where(['id' => $currentFile->id, 'is_locked' => 0])->update([$field_db => null, 'updated_at' => date('Y-m-d H:i:s')]);
            } catch (\Exception $e) {
                $this->_db->transRollback();

                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($e);
                $response->message = "Gagal menghapus file lampiran $title.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                try {
                    unlink($dir . '/' . $currentFile->file);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "File lampiran $title berhasil dihapus.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menghapus file lampiran $title";
                return json_encode($response);
            }
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
                    $dir = FCPATH . "upload/pengawas/pangkat";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kgb':
                    $dir = FCPATH . "upload/pengawas/kgb";
                    $field_db = 'kgb_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pernyataan24':
                    $dir = FCPATH . "upload/pengawas/pernyataanindividu";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'penugasan':
                    $dir = FCPATH . "upload/pengawas/penugasan";
                    $field_db = 'penugasan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kunjunganbinaan':
                    $dir = FCPATH . "upload/pengawas/kunjunganbinaan";
                    $field_db = 'kunjungan_binaan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'cuti':
                    $dir = FCPATH . "upload/pengawas/keterangancuti";
                    $field_db = 'cuti';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pensiun':
                    $dir = FCPATH . "upload/pengawas/pensiun";
                    $field_db = 'pensiun';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kematian':
                    $dir = FCPATH . "upload/pengawas/kematian";
                    $field_db = 'kematian';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'attr_lainnya':
                    $dir = FCPATH . "upload/pengawas/lainnya";
                    $field_db = 'lainnya';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/pengawas/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '__pengawas_absen_kehadiran';
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

            $ptkNya = $this->_db->table('__pengawas_tb')->where('id', $id_ptk)->get()->getRowObject();

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
                    $dir = FCPATH . "upload/pengawas/pangkat";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kgb':
                    $dir = FCPATH . "upload/pengawas/kgb";
                    $field_db = 'kgb_terakhir';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pernyataan24':
                    $dir = FCPATH . "upload/pengawas/pernyataanindividu";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'penugasan':
                    $dir = FCPATH . "upload/pengawas/penugasan";
                    $field_db = 'penugasan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kunjunganbinaan':
                    $dir = FCPATH . "upload/pengawas/kunjunganbinaan";
                    $field_db = 'kunjungan_binaan';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'cuti':
                    $dir = FCPATH . "upload/pengawas/keterangancuti";
                    $field_db = 'cuti';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'pensiun':
                    $dir = FCPATH . "upload/pengawas/pensiun";
                    $field_db = 'pensiun';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'kematian':
                    $dir = FCPATH . "upload/pengawas/kematian";
                    $field_db = 'kematian';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                case 'attr_lainnya':
                    $dir = FCPATH . "upload/pengawas/lainnya";
                    $field_db = 'lainnya';
                    $table_db = '__pengawas_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/pengawas/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '__pengawas_absen_kehadiran';
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

            $ptkNya = $this->_db->table('__pengawas_tb')->where('id', $id_ptk)->get()->getRowObject();

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

    public function edit()
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
                    'required' => 'Action tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tahun tidak boleh kosong. ',
                ]
            ],
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
            $response->message = $this->validator->getError('action')
                . $this->validator->getError('id')
                . $this->validator->getError('tahun')
                . $this->validator->getError('tw');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
                return json_encode($response);
            }

            $current = $this->_db->table('__pengawas_upload_data_attribut')
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['tahun'] = $tahun;
                $data['tw'] = $tw;
                $data['pangkats'] = $this->_db->table('ref_gaji')->select("pangkat, count(pangkat) as jumlah")->whereNotIn('pangkat', ['pghm', 'tamsil'])->groupBy('pangkat')->orderBy('pangkat', 'ASC')->get()->getResult();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/peng/doc/atribut/edit', $data);
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
                    'required' => 'Id buku tidak boleh kosong. ',
                ]
            ],
            'jenis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis tidak boleh kosong. ',
                ]
            ],
            'pangkat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pangkat golongan tidak boleh kosong. ',
                ]
            ],
            'nomor_sk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor SK tidak boleh kosong. ',
                ]
            ],
            'tgl_sk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal SK tidak boleh kosong. ',
                ]
            ],
            'tmt_sk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TMT SK tidak boleh kosong. ',
                ]
            ],
            'mk_tahun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Masa kerja tahun tidak boleh kosong. ',
                ]
            ],
            'mk_bulan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Masa kerja bulan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('jenis')
                . $this->validator->getError('pangkat')
                . $this->validator->getError('nomor_sk')
                . $this->validator->getError('tgl_sk')
                . $this->validator->getError('tmt_sk')
                . $this->validator->getError('mk_tahun')
                . $this->validator->getError('mk_bulan');
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
            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
            $pangkat = htmlspecialchars($this->request->getVar('pangkat'), true);
            $nomor_sk = htmlspecialchars($this->request->getVar('nomor_sk'), true);
            $tgl_sk = htmlspecialchars($this->request->getVar('tgl_sk'), true);
            $tmt_sk = htmlspecialchars($this->request->getVar('tmt_sk'), true);
            $mk_tahun = htmlspecialchars($this->request->getVar('mk_tahun'), true);
            $mk_bulan = htmlspecialchars($this->request->getVar('mk_bulan'), true);

            $oldData =  $this->_db->table('__pengawas_upload_data_attribut')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'pang_jenis' => $jenis,
                'pang_golongan' => $pangkat,
                'pang_no' => $nomor_sk,
                'pang_tgl' => $tgl_sk,
                'pang_tmt' => $tmt_sk,
                'pang_tahun' => $mk_tahun,
                'pang_bulan' => $mk_bulan,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();
            try {
                $this->_db->table('__pengawas_upload_data_attribut')->where(['id' => $oldData->id, 'is_locked' => 0])->update($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupdate data.";
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
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }

    public function hapus()
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
                    'required' => 'Action tidak boleh kosong. ',
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
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'id tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('action')
                . $this->validator->getError('tw')
                . $this->validator->getError('tahun')
                . $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);

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

            $current = $this->_db->table('__pengawas_upload_data_attribut')->where(['id' => $id])->get()->getRowObject();
            if (!$current) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menghapus data. Data tidak ditemukan.";
                return json_encode($response);
            }
            if ($current->is_locked == 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menghapus data. Data attribut sudah terkunci, silahkan hubungi admin dinas untuk menghapus.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('__pengawas_upload_data_attribut')->where(['id' => $current->id, 'is_locked' => 0])->delete();
            } catch (\Exception $e) {
                $this->_db->transRollback();

                $response = new \stdClass;
                $response->status = 400;
                $response->error = var_dump($e);
                $response->message = "Gagal menghapus data attribut.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                try {
                    if ($current->pangkat_terakhir !== NULL) {
                        unlink(FCPATH . "upload/pengawas/pangkat/" . $current->pangkat_terakhir);
                    }
                    if ($current->kgb_terakhir !== NULL) {
                        unlink(FCPATH . "upload/pengawas/kgb/" . $current->kgb_terakhir);
                    }
                    if ($current->pernyataan_24jam !== NULL) {
                        unlink(FCPATH . "upload/pengawas/pernyataanindividu/" . $current->pernyataan_24jam);
                    }
                    if ($current->penugasan !== NULL) {
                        unlink(FCPATH . "upload/pengawas/penugasan/" . $current->penugasan);
                    }
                    if ($current->kunjungan_binaan !== NULL) {
                        unlink(FCPATH . "upload/pengawas/kunjunganbinaan/" . $current->kunjungan_binaan);
                    }
                    if ($current->cuti !== NULL) {
                        unlink(FCPATH . "upload/pengawas/keterangancuti/" . $current->cuti);
                    }
                    if ($current->pensiun !== NULL) {
                        unlink(FCPATH . "upload/pengawas/pensiun/" . $current->pensiun);
                    }
                    if ($current->kematian !== NULL) {
                        unlink(FCPATH . "upload/pengawas/kematian/" . $current->kematian);
                    }
                    if ($current->lainnya !== NULL) {
                        unlink(FCPATH . "upload/pengawas/lainnya/" . $current->lainnya);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data atribut berhasil dihapus.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menghapus data attribut";
                return json_encode($response);
            }
        }
    }
}
