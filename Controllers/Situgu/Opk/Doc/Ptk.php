<?php

namespace App\Controllers\Situgu\Ops\Doc;

use App\Controllers\BaseController;
use App\Models\Situgu\Ops\DocptkModel;
use App\Models\Situgu\Ops\PtkModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

class Ptk extends BaseController
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
        $datamodel = new PtkModel($request);

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

        $lists = $datamodel->get_datatables($npsn);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i> Detail</button>
                </a>';
            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->nik;
            $row[] = $list->nip;
            $row[] = $list->nuptk;
            $row[] = $list->jenis_ptk;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($npsn),
            "recordsFiltered" => $datamodel->count_filtered($npsn),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function getAllDoc()
    {
        $request = Services::request();
        $datamodel = new DocptkModel($request);

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
            $row[] = $list->tahun;
            $row[] = $list->tw;

            switch ($list->lockedAbsen) {
                case 1:
                    $row[] = $list->lampiran_absen1 ? '<a href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen1 . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Absen 1</span></a>' : '-';
                    $row[] = $list->lampiran_absen2 ? '<a href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen2 . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Absen 2</span></a>' : '-';
                    $row[] = $list->lampiran_absen3 ? '<a href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen3 . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Absen 3</span></a>' : '-';
                    $row[] = $list->pembagian_tugas ? '<a href="' . base_url('upload/sekolah/pembagian-tugas') . '/' . $list->pembagian_tugas . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pembagian Tugas</span></a>' : '-';
                    $row[] = $list->slip_gaji ? '<a href="' . base_url('upload/sekolah/slip-gaji') . '/' . $list->slip_gaji . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Slip Gaji</span></a>' : '-';
                    $row[] = $list->doc_lainnya ? '<a href="' . base_url('upload/sekolah/lainnya') . '/' . $list->doc_lainnya . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Doc Lainnya</span></a>' : '-';
                    $row[] = '<div class="text-center">
                    <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                    </div>';
                    break;
                default:
                    $row[] = $list->lampiran_absen1 ? '<a target="_blank" href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen1 . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Absen Bulan 1\',\'bulan1\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_absen1 . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Absen Bulan 1\',\'bulan1\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_absen2 ? '<a target="_blank" href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen2 . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Absen Bulan 2\',\'bulan2\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_absen2 . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Absen Bulan 2\',\'bulan2\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_absen3 ? '<a target="_blank" href="' . base_url('upload/sekolah/kehadiran') . '/' . $list->lampiran_absen3 . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Absen Bulan 3\',\'bulan3\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_absen3 . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Absen Bulan 3\',\'bulan3\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->pembagian_tugas ? '<a target="_blank" href="' . base_url('upload/sekolah/pembagian-tugas') . '/' . $list->pembagian_tugas . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pembagian Tugas\',\'pembagian_tugas\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->pembagian_tugas . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Pembagian Tugas\',\'pembagian_tugas\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->slip_gaji ? '<a target="_blank" href="' . base_url('upload/sekolah/slip-gaji') . '/' . $list->slip_gaji . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Slip Gaji\',\'slip_gaji\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->slip_gaji . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Slip Gaji\',\'slip_gaji\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->doc_lainnya ? '<a target="_blank" href="' . base_url('upload/sekolah/doc-lainnya') . '/' . $list->doc_lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Lainnya\',\'doc_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Dokumen Lainnya\',\'doc_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = '<div class="text-center">
                        <span class="badge rounded-pill badge-soft-danger font-size-11">Terbuka</span>
                    </div>';
                    break;
            }

            switch ($list->lockedAttr) {
                case 1:
                    $row[] = $list->doc_pangkat_terakhir ? '<a href="' . base_url('upload/ptk/pangkat') . '/' . $list->doc_pangkat_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pangkat</span></a>' : '-';
                    $row[] = $list->doc_kgb_terakhir ? '<a href="' . base_url('upload/ptk/kgb') . '/' . $list->doc_kgb_terakhir . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran KGB</span></a>' : '-';
                    $row[] = $list->doc_pernyataan_24jam ? '<a href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->doc_pernyataan_24jam . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pernyataan</span></a>' : '-';
                    $row[] = $list->doc_cuti ? '<a href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->doc_cuti . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Cuti</span></a>' : '-';
                    $row[] = $list->doc_pensiun ? '<a href="' . base_url('upload/ptk/pensiun') . '/' . $list->doc_pensiun . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Pensiun</span></a>' : '-';
                    $row[] = $list->doc_kematian ? '<a href="' . base_url('upload/ptk/kematian') . '/' . $list->doc_kematian . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Kematian</span></a>' : '-';
                    $row[] = $list->doc_attr_lainnya ? '<a href="' . base_url('upload/ptk/lainnya') . '/' . $list->doc_attr_lainnya . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Atribut Lainnya</span></a>' : '-';
                    $row[] = '<div class="text-center">
                    <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                    </div>';
                    break;
                default:
                    if ($list->status_kepegawaian === "PNS" || $list->status_kepegawaian === "PPPK" || $list->status_kepegawaian === "PNS Diperbantukan" || $list->status_kepegawaian === "PNS Depag" || $list->status_kepegawaian === "CPNS") {
                        $row[] = $list->doc_pangkat_terakhir ? '<a target="_blank" href="' . base_url('upload/ptk/pangkat') . '/' . $list->doc_pangkat_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_pangkat_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pangkat Terakhir\',\'pangkat\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_kgb_terakhir ? '<a target="_blank" href="' . base_url('upload/ptk/kgb') . '/' . $list->doc_kgb_terakhir . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_kgb_terakhir . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Berkala Terakhir\',\'kgb\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_pernyataan_24jam ? '<a target="_blank" href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->doc_pernyataan_24jam . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_pernyataan_24jam . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_cuti ? '<a target="_blank" href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->doc_cuti . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_pensiun ? '<a target="_blank" href="' . base_url('upload/ptk/pensiun') . '/' . $list->doc_pensiun . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_kematian ? '<a target="_blank" href="' . base_url('upload/ptk/kematian') . '/' . $list->doc_kematian . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_attr_lainnya ? '<a target="_blank" href="' . base_url('upload/ptk/lainnya') . '/' . $list->doc_attr_lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_attr_lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    } else {
                        $row[] = '-';
                        $row[] = '-';
                        $row[] = $list->doc_pernyataan_24jam ? '<a target="_blank" href="' . base_url('upload/ptk/pernyataanindividu') . '/' . $list->doc_pernyataan_24jam . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_pernyataan_24jam . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Pernyataan 24Jam\',\'pernyataan24\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                        $row[] = $list->doc_cuti ? '<a target="_blank" href="' . base_url('upload/ptk/keterangancuti') . '/' . $list->doc_cuti . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_cuti . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Cuti\',\'cuti\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->doc_pensiun ? '<a target="_blank" href="' . base_url('upload/ptk/pensiun') . '/' . $list->doc_pensiun . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_pensiun . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Pensiun\',\'pensiun\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->doc_kematian ? '<a target="_blank" href="' . base_url('upload/ptk/kematian') . '/' . $list->doc_kematian . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-show font-size-16 align-middle"></i></button>
                </a>
                <a href="javascript:actionEditFile(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_kematian . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                    <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                </a>' :
                            '<a href="javascript:actionUpload(\'Kematian\',\'kematian\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                </a>';
                        $row[] = $list->doc_attr_lainnya ? '<a target="_blank" href="' . base_url('upload/ptk/lainnya') . '/' . $list->doc_attr_lainnya . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->doc_attr_lainnya . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Dokumen Atribut Lainnya\',\'attr_lainnya\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    }
                    $row[] = '<div class="text-center">
                <span class="badge rounded-pill badge-soft-danger font-size-11">Terbuka</span>
            </div>';
                    break;
            }

            switch ($list->is_locked) {
                case 1:
                    $row[] = $list->lampiran_foto ? '<a href="' . base_url('upload/ptk/foto') . '/' . $list->lampiran_foto . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Foto</span></a>' : '-';
                    $row[] = $list->lampiran_karpeg ? '<a href="' . base_url('upload/ptk/karpeg') . '/' . $list->lampiran_karpeg . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Karpeg</span></a>' : '-';
                    $row[] = $list->lampiran_ktp ? '<a href="' . base_url('upload/ptk/ktp') . '/' . $list->lampiran_ktp . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran KTP</span></a>' : '-';
                    $row[] = $list->lampiran_nrg ? '<a href="' . base_url('upload/ptk/nrg') . '/' . $list->lampiran_nrg . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NRG</span></a>' : '-';
                    $row[] = $list->lampiran_nuptk ? '<a href="' . base_url('upload/ptk/nuptk') . '/' . $list->lampiran_nuptk . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NUPTK</span></a>' : '-';
                    $row[] = $list->lampiran_npwp ? '<a href="' . base_url('upload/ptk/npwp') . '/' . $list->lampiran_npwp . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NPWP</span></a>' : '-';
                    $row[] = $list->lampiran_serdik ? '<a href="' . base_url('upload/ptk/serdik') . '/' . $list->lampiran_serdik . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Serdik</span></a>' : '-';
                    $row[] = $list->lampiran_buku_rekening ? '<a href="' . base_url('upload/ptk/bukurekening') . '/' . $list->lampiran_buku_rekening . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Buku Rekening</span></a>' : '-';
                    $row[] = $list->lampiran_ijazah ? '<a href="' . base_url('upload/ptk/ijazah') . '/' . $list->lampiran_ijazah . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Ijazah</span></a>' : '-';
                    $row[] = $list->lampiran_impassing ? '<a href="' . base_url('upload/ptk/impassing') . '/' . $list->lampiran_impassing . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Inpassing</span></a>' : '-';
                    $row[] = '<div class="text-center">
                    <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                    </div>';
                    break;
                default:

                    $row[] = $list->lampiran_foto ? '<a target="_blank" href="' . base_url('upload/ptk/foto') . '/' . $list->lampiran_foto . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Foto\',\'foto\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_foto . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Foto\',\'foto\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    if ($list->status_kepegawaian === "PNS" || $list->status_kepegawaian === "PPPK" || $list->status_kepegawaian === "PNS Diperbantukan" || $list->status_kepegawaian === "PNS Depag" || $list->status_kepegawaian === "CPNS") {
                        $row[] = $list->lampiran_karpeg ? '<a target="_blank" href="' . base_url('upload/ptk/karpeg') . '/' . $list->lampiran_karpeg . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Karpeg\',\'karpeg\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_karpeg . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Karpeg\',\'karpeg\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    } else {
                        $row[] = '-';
                    }
                    $row[] = $list->lampiran_ktp ? '<a target="_blank" href="' . base_url('upload/ptk/ktp') . '/' . $list->lampiran_ktp . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'KTP\',\'ktp\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_ktp . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'KTP\',\'ktp\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_nrg ? '<a target="_blank" href="' . base_url('upload/ptk/nrg') . '/' . $list->lampiran_nrg . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'NRG\',\'nrg\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_nrg . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'NRG\',\'nrg\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_nuptk ? '<a target="_blank" href="' . base_url('upload/ptk/nuptk') . '/' . $list->lampiran_nuptk . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'NUPTK\',\'nuptk\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_nuptk . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'NUPTK\',\'nuptk\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_serdik ? '<a target="_blank" href="' . base_url('upload/ptk/serdik') . '/' . $list->lampiran_serdik . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Sertifikat Pendidik\',\'serdik\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_serdik . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Sertifikat Pendidik\',\'serdik\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_npwp ? '<a target="_blank" href="' . base_url('upload/ptk/npwp') . '/' . $list->lampiran_npwp . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'NPWP\',\'npwp\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_npwp . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'NPWP\',\'npwp\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_buku_rekening ? '<a target="_blank" href="' . base_url('upload/ptk/bukurekening') . '/' . $list->lampiran_buku_rekening . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Buku Rekening\',\'buku_rekening\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_buku_rekening . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Buku Rekening\',\'buku_rekening\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    $row[] = $list->lampiran_ijazah ? '<a target="_blank" href="' . base_url('upload/ptk/ijazah') . '/' . $list->lampiran_ijazah . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Ijazah\',\'ijazah\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_ijazah . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                        '<a href="javascript:actionUpload(\'Ijazah\',\'ijazah\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
                        <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                    </a>';
                    if ($list->status_kepegawaian === "PNS" || $list->status_kepegawaian === "PPPK" || $list->status_kepegawaian === "PNS Diperbantukan" || $list->status_kepegawaian === "PNS Depag" || $list->status_kepegawaian === "CPNS") {
                        $row[] = '-';
                    } else {
                        $row[] = $list->lampiran_impassing ? '<a target="_blank" href="' . base_url('upload/ptk/impassing') . '/' . $list->lampiran_impassing . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-show font-size-16 align-middle"></i></button>
                    </a>
                    <a href="javascript:actionEditFile(\'Inpassing\',\'inpassing\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\',\'' . $list->lampiran_impassing . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                        <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                    </a>' :
                            '<a href="javascript:actionUpload(\'Inpassing\',\'inpassing\',\'' . $list->id_tahun_tw . '\',\'' . $list->npsn . '\')" class="btn btn-primary waves-effect waves-light">
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
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('situgu/ops/doc/ptk/data'));
    }

    public function data()
    {
        $data['title'] = 'DOKUMEN PTK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('situgu/ops/doc/ptk/index', $data);
    }

    public function detail()
    {
        $data['title'] = 'DOKUMEN PTK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['id'] = htmlspecialchars($this->request->getGet('id'), true);

        $data['ptk'] = $this->_db->table('_ptk_tb')->select('nama, nip, nik, nuptk')->where('id', $data['id'])->get()->getRowObject();

        return view('situgu/ops/doc/ptk/detail', $data);
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
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
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
                . $this->validator->getError('id_ptk')
                . $this->validator->getError('npsn');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['npsn'] = $npsn;
            $data['title'] = $title;
            $data['id_ptk'] = $id_ptk;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ops/doc/ptk/upload', $data);
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
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
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
                . $this->validator->getError('id_ptk')
                . $this->validator->getError('npsn');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['npsn'] = $npsn;
            $data['title'] = $title;
            $data['old'] = $old;
            $data['id_ptk'] = $id_ptk;
            switch ($bulan) {
                case 'bulan1':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'bulan2':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'bulan3':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'pembagian_tugas':
                    $data['old_url'] = base_url('upload/sekolah/pembagian-tugas') . '/' . $old;
                    break;
                case 'slip_gaji':
                    $data['old_url'] = base_url('upload/sekolah/slip-gaji') . '/' . $old;
                    break;
                case 'doc_lainnya':
                    $data['old_url'] = base_url('upload/sekolah/doc-lainnya') . '/' . $old;
                    break;
                case 'pangkat':
                    $data['old_url'] = base_url('upload/ptk/pangkat') . '/' . $old;
                    break;
                case 'kgb':
                    $data['old_url'] = base_url('upload/ptk/kgb') . '/' . $old;
                    break;
                case 'pernyataan24':
                    $data['old_url'] = base_url('upload/ptk/pernyataanindividu') . '/' . $old;
                    break;
                case 'cuti_pensiun_kematian':
                    $data['old_url'] = base_url('upload/ptk/keterangancuti') . '/' . $old;
                    break;
                case 'attr_lainnya':
                    $data['old_url'] = base_url('upload/ptk/lainnya') . '/' . $old;
                    break;
                case 'foto':
                    $data['old_url'] = base_url('upload/ptk/foto') . '/' . $old;
                    break;
                case 'karpeg':
                    $data['old_url'] = base_url('upload/ptk/karpeg') . '/' . $old;
                    break;
                case 'ktp':
                    $data['old_url'] = base_url('upload/ptk/ktp') . '/' . $old;
                    break;
                case 'nrg':
                    $data['old_url'] = base_url('upload/ptk/nrg') . '/' . $old;
                    break;
                case 'nuptk':
                    $data['old_url'] = base_url('upload/ptk/nuptk') . '/' . $old;
                    break;
                case 'serdik':
                    $data['old_url'] = base_url('upload/ptk/serdik') . '/' . $old;
                    break;
                case 'npwp':
                    $data['old_url'] = base_url('upload/ptk/npwp') . '/' . $old;
                    break;
                case 'buku_rekening':
                    $data['old_url'] = base_url('upload/ptk/bukurekening') . '/' . $old;
                    break;
                case 'ijazah':
                    $data['old_url'] = base_url('upload/ptk/ijazah') . '/' . $old;
                    break;
                case 'inpassing':
                    $data['old_url'] = base_url('upload/ptk/impassing') . '/' . $old;
                    break;
                default:
                    $data['old_url'] = base_url('upload/sekolah/doc-lainnya') . '/' . $old;
                    break;
            }

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ops/doc/ptk/editupload', $data);
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
            'npsn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
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
                . $this->validator->getError('npsn')
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
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';
            $table_db = '';

            switch ($name) {
                case 'bulan1':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen1';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'bulan2':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen2';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'bulan3':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen3';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'pembagian_tugas':
                    $dir = FCPATH . "upload/sekolah/pembagian-tugas";
                    $field_db = 'pembagian_tugas';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'slip_gaji':
                    $dir = FCPATH . "upload/sekolah/slip-gaji";
                    $field_db = 'slip_gaji';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'doc_lainnya':
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '_absen_kehadiran';
                    break;
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
                case 'foto':
                    $dir = FCPATH . "upload/ptk/foto";
                    $field_db = 'lampiran_foto';
                    $table_db = '_ptk_tb';
                    break;
                case 'karpeg':
                    $dir = FCPATH . "upload/ptk/karpeg";
                    $field_db = 'lampiran_karpeg';
                    $table_db = '_ptk_tb';
                    break;
                case 'ktp':
                    $dir = FCPATH . "upload/ptk/ktp";
                    $field_db = 'lampiran_ktp';
                    $table_db = '_ptk_tb';
                    break;
                case 'nrg':
                    $dir = FCPATH . "upload/ptk/nrg";
                    $field_db = 'lampiran_nrg';
                    $table_db = '_ptk_tb';
                    break;
                case 'nuptk':
                    $dir = FCPATH . "upload/ptk/nuptk";
                    $field_db = 'lampiran_nuptk';
                    $table_db = '_ptk_tb';
                    break;
                case 'serdik':
                    $dir = FCPATH . "upload/ptk/serdik";
                    $field_db = 'lampiran_serdik';
                    $table_db = '_ptk_tb';
                    break;
                case 'npwp':
                    $dir = FCPATH . "upload/ptk/npwp";
                    $field_db = 'lampiran_npwp';
                    $table_db = '_ptk_tb';
                    break;
                case 'buku_rekening':
                    $dir = FCPATH . "upload/ptk/bukurekening";
                    $field_db = 'lampiran_buku_rekening';
                    $table_db = '_ptk_tb';
                    break;
                case 'ijazah':
                    $dir = FCPATH . "upload/ptk/ijazah";
                    $field_db = 'lampiran_ijazah';
                    $table_db = '_ptk_tb';
                    break;
                case 'inpassing':
                    $dir = FCPATH . "upload/ptk/impassing";
                    $field_db = 'lampiran_impassing';
                    $table_db = '_ptk_tb';
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

            $this->_db->transBegin();
            try {
                if ($table_db == '_ptk_tb') {
                    $this->_db->table($table_db)->where(['id' => $id_ptk, 'is_locked' => 0])->update($data);
                } else {
                    $cekCurrent = $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk])->countAllResults();
                    if ($table_db == '_upload_data_attribut') {

                        $ptkNya = $this->_db->table('_ptk_tb')->where('id', $id_ptk)->get()->getRowObject();

                        if (!$ptkNya) {
                            $this->_db->transRollback();
                            unlink($dir . '/' . $newNamelampiran);
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "PTK Tidak ditemukan.";
                            return json_encode($response);
                        }
                        $data['pang_golongan'] = $ptkNya->pangkat_golongan;
                        $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
                        $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
                        $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
                        $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
                        $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
                        $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);
                    }
                    if ($cekCurrent > 0) {
                        $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk, 'is_locked' => 0])->update($data);
                    } else {
                        $uuidLib = new Uuid();
                        $data['id'] = $uuidLib->v4();
                        $data['id_tahun_tw'] = $tw;
                        $data['id_ptk'] = $id_ptk;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $this->_db->table($table_db)->insert($data);
                    }
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
            'npsn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
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
                . $this->validator->getError('npsn')
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
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);
            $id_ptk = htmlspecialchars($this->request->getVar('id_ptk'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';
            $table_db = '';

            switch ($name) {
                case 'bulan1':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen1';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'bulan2':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen2';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'bulan3':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen3';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'pembagian_tugas':
                    $dir = FCPATH . "upload/sekolah/pembagian-tugas";
                    $field_db = 'pembagian_tugas';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'slip_gaji':
                    $dir = FCPATH . "upload/sekolah/slip-gaji";
                    $field_db = 'slip_gaji';
                    $table_db = '_absen_kehadiran';
                    break;
                case 'doc_lainnya':
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    $table_db = '_absen_kehadiran';
                    break;
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
                case 'foto':
                    $dir = FCPATH . "upload/ptk/foto";
                    $field_db = 'lampiran_foto';
                    $table_db = '_ptk_tb';
                    break;
                case 'karpeg':
                    $dir = FCPATH . "upload/ptk/karpeg";
                    $field_db = 'lampiran_karpeg';
                    $table_db = '_ptk_tb';
                    break;
                case 'ktp':
                    $dir = FCPATH . "upload/ptk/ktp";
                    $field_db = 'lampiran_ktp';
                    $table_db = '_ptk_tb';
                    break;
                case 'nrg':
                    $dir = FCPATH . "upload/ptk/nrg";
                    $field_db = 'lampiran_nrg';
                    $table_db = '_ptk_tb';
                    break;
                case 'nuptk':
                    $dir = FCPATH . "upload/ptk/nuptk";
                    $field_db = 'lampiran_nuptk';
                    $table_db = '_ptk_tb';
                    break;
                case 'serdik':
                    $dir = FCPATH . "upload/ptk/serdik";
                    $field_db = 'lampiran_serdik';
                    $table_db = '_ptk_tb';
                    break;
                case 'npwp':
                    $dir = FCPATH . "upload/ptk/npwp";
                    $field_db = 'lampiran_npwp';
                    $table_db = '_ptk_tb';
                    break;
                case 'buku_rekening':
                    $dir = FCPATH . "upload/ptk/bukurekening";
                    $field_db = 'lampiran_buku_rekening';
                    $table_db = '_ptk_tb';
                    break;
                case 'ijazah':
                    $dir = FCPATH . "upload/ptk/ijazah";
                    $field_db = 'lampiran_ijazah';
                    $table_db = '_ptk_tb';
                    break;
                case 'inpassing':
                    $dir = FCPATH . "upload/ptk/impassing";
                    $field_db = 'lampiran_impassing';
                    $table_db = '_ptk_tb';
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

            $this->_db->transBegin();
            try {
                if ($table_db == '_ptk_tb') {
                    $this->_db->table($table_db)->where(['id' => $id_ptk, 'is_locked' => 0])->update($data);
                } else {
                    if ($table_db == '_upload_data_attribut') {

                        $ptkNya = $this->_db->table('_ptk_tb')->where('id', $id_ptk)->get()->getRowObject();

                        if (!$ptkNya) {
                            $this->_db->transRollback();
                            unlink($dir . '/' . $newNamelampiran);
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "PTK Tidak ditemukan.";
                            return json_encode($response);
                        }
                        $data['pang_golongan'] = $ptkNya->pangkat_golongan;
                        $data['pang_jenis'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? 'kgb' : 'pangkat';
                        $data['pang_no'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->sk_kgb : $ptkNya->nomor_sk_pangkat;
                        $data['pang_tmt'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tmt_sk_kgb : $ptkNya->tmt_pangkat;
                        $data['pang_tgl'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? $ptkNya->tgl_sk_kgb : $ptkNya->tgl_sk_pangkat;
                        $data['pang_tahun'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_tahun_kgb !== null ? $ptkNya->masa_kerja_tahun_kgb : 0) : ($ptkNya->masa_kerja_tahun !== null ? $ptkNya->masa_kerja_tahun : 0);
                        $data['pang_bulan'] = ($ptkNya->tmt_sk_kgb > $ptkNya->tmt_pangkat) ? ($ptkNya->masa_kerja_bulan_kgb !== null ? $ptkNya->masa_kerja_bulan_kgb : 0) : ($ptkNya->masa_kerja_bulan !== null ? $ptkNya->masa_kerja_bulan : 0);
                    }
                    $this->_db->table($table_db)->where(['id_tahun_tw' => $tw, 'id_ptk' => $id_ptk, 'is_locked' => 0])->update($data);
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
                $response->data = view('a/setting/pengguna/edit', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function syncAll()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('npsn');
            return json_encode($response);
        } else {
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);

            $apiLib = new Apilib();
            $result = $apiLib->syncPtk($npsn);

            if ($result) {
                if ($result->status == 200) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Syncrone Data Semua PTK Berhasil Dilakukan.";
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

    public function sync()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'ptk_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('ptk_id')
                . $this->validator->getError('nama')
                . $this->validator->getError('npsn');
            return json_encode($response);
        } else {
            $idPtk = htmlspecialchars($this->request->getVar('ptk_id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);

            $apiLib = new Apilib();
            $result = $apiLib->syncPtkId($idPtk, $npsn);

            if ($result) {
                if ($result->status == 200) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Syncrone Data PTK $nama Berhasil Dilakukan.";
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
                ->where('uid', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_users_tb')->where('uid', $id)->delete();

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
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong. ',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                'file' => [
                    'rules' => 'uploaded[file]|max_size[file,512]|is_image[file]',
                    'errors' => [
                        'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
                        'max_size' => 'Ukuran gambar profil terlalu besar. ',
                        'is_image' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('id')
                . $this->validator->getError('email')
                . $this->validator->getError('nohp')
                . $this->validator->getError('nip')
                . $this->validator->getError('alamat')
                . $this->validator->getError('status')
                . $this->validator->getError('file');
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
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $alamat = htmlspecialchars($this->request->getVar('alamat'), true);
            $status = htmlspecialchars($this->request->getVar('status'), true);

            $oldData =  $this->_db->table('_users_tb')->where('uid', $id)->get()->getRowObject();

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
                && $nip === $oldData->nip
                && $alamat === $oldData->alamat
                && (int)$status === (int)$oldData->is_active
            ) {
                if ($filenamelampiran == '') {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('a/setting/pengguna/data');
                    return json_encode($response);
                }
            }

            if ($email !== $oldData->email) {
                $cekData = $this->_db->table('_users_tb')->where(['email' => $email])->get()->getRowObject();
                if ($cekData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Email sudah terdaftar.";
                    return json_encode($response);
                }
            }

            $data = [
                'email' => $email,
                'fullname' => $nama,
                'no_hp' => $nohp,
                'nip' => $nip,
                'alamat' => $alamat,
                'is_active' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dir = FCPATH . "uploads/user";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['image'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload gambar.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_users_tb')->where('uid', $oldData->uid)->update($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan gambar baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    unlink($dir . '/' . $oldData->image);
                } catch (\Throwable $th) {
                }
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                $response->redirect = base_url('a/setting/pengguna/data');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
