<?php

namespace App\Controllers\Silastri\Adm\Layanan;

use App\Controllers\BaseController;
// use App\Models\Silastri\Peng\PtkModel;
// use App\Models\Silastri\Peng\SekolahModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;

class Ketdtks extends BaseController
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

    // public function getAllPtk()
    // {
    //     $request = Services::request();
    //     $datamodel = new PtkModel($request);

    //     $jwt = get_cookie('jwt');
    //     $token_jwt = getenv('token_jwt.default.key');
    //     if ($jwt) {
    //         try {
    //             $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
    //             if ($decoded) {
    //                 $userId = $decoded->id;
    //                 $level = $decoded->level;
    //             } else {
    //                 $output = [
    //                     "draw" => $request->getPost('draw'),
    //                     "recordsTotal" => 0,
    //                     "recordsFiltered" => 0,
    //                     "data" => []
    //                 ];
    //                 echo json_encode($output);
    //                 return;
    //             }
    //         } catch (\Exception $e) {
    //             $output = [
    //                 "draw" => $request->getPost('draw'),
    //                 "recordsTotal" => 0,
    //                 "recordsFiltered" => 0,
    //                 "data" => []
    //             ];
    //             echo json_encode($output);
    //             return;
    //         }
    //     }

    //     $lists = $datamodel->get_datatables();
    //     $data = [];
    //     $no = $request->getPost("start");
    //     foreach ($lists as $list) {
    //         $no++;
    //         $row = [];

    //         $row[] = $no;
    //         $action = '<div class="btn-group">
    //                     <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
    //                     <div class="dropdown-menu" style="">
    //                         <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
    //                         <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Tarik Data</a>
    //                         <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Ajukan Hapus Data</a>
    //                     </div>
    //                 </div>';
    //         // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
    //         //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
    //         //     </a>
    //         //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
    //         //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
    //         //     </a>
    //         //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
    //         //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
    //         //     </a>';
    //         $row[] = $action;
    //         $row[] = $list->nama;
    //         $row[] = $list->nik;
    //         $row[] = $list->nip;
    //         $row[] = $list->nuptk;
    //         $row[] = $list->jenis_ptk;
    //         $row[] = $list->last_sync;

    //         $data[] = $row;
    //     }
    //     $output = [
    //         "draw" => $request->getPost('draw'),
    //         "recordsTotal" => $datamodel->count_all(),
    //         "recordsFiltered" => $datamodel->count_filtered(),
    //         "data" => $data
    //     ];
    //     echo json_encode($output);
    // }

    // public function getAll()
    // {
    //     $request = Services::request();
    //     $datamodel = new SekolahModel($request);

    //     $jwt = get_cookie('jwt');
    //     $token_jwt = getenv('token_jwt.default.key');
    //     if ($jwt) {
    //         try {
    //             $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
    //             if ($decoded) {
    //                 $userId = $decoded->id;
    //                 $level = $decoded->level;
    //             } else {
    //                 $output = [
    //                     "draw" => $request->getPost('draw'),
    //                     "recordsTotal" => 0,
    //                     "recordsFiltered" => 0,
    //                     "data" => []
    //                 ];
    //                 echo json_encode($output);
    //                 return;
    //             }
    //         } catch (\Exception $e) {
    //             $output = [
    //                 "draw" => $request->getPost('draw'),
    //                 "recordsTotal" => 0,
    //                 "recordsFiltered" => 0,
    //                 "data" => []
    //             ];
    //             echo json_encode($output);
    //             return;
    //         }
    //     }

    //     $npsns = $this->_helpLib->getSekolahNaungan($userId);

    //     $lists = $datamodel->get_datatables($npsns);
    //     $data = [];
    //     $no = $request->getPost("start");
    //     foreach ($lists as $list) {
    //         $no++;
    //         $row = [];

    //         $row[] = $no;

    //         $action = '<a href="./sekolah?n=' . $list->id . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
    //             <i class="bx bxs-show font-size-16 align-middle"> Detail</i></button>
    //             </a>';
    //         $row[] = $action;
    //         $row[] = $list->nama;
    //         $row[] = $list->npsn;
    //         $row[] = $list->bentuk_pendidikan;
    //         $row[] = $list->status_sekolah;
    //         $row[] = $list->kecamatan;

    //         $data[] = $row;
    //     }
    //     $output = [
    //         "draw" => $request->getPost('draw'),
    //         "recordsTotal" => $datamodel->count_all($npsns),
    //         "recordsFiltered" => $datamodel->count_filtered($npsns),
    //         "data" => $data
    //     ];
    //     echo json_encode($output);
    // }

    public function index()
    {
        return redirect()->to(base_url('silastri/adm/layanan/ketdtks/data'));
    }

    public function add()
    {
        $data['title'] = 'Layanan SKDTKS';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['data'] = $user->data;

        $data['jeniss'] = ['Surat Keterangan DTKS untuk Pengajuan PIP', 'Surat Keterangan DTKS untuk Pendaftaran PPDB', 'Surat Keterangan DTKS untuk Pengajuan PLN', 'Lainnya'];

        return view('silastri/peng/layanan/ketdtks/add', $data);
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
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'nik' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nik boleh kosong. ',
                ]
            ],
            'jenis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis permohonan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nik')
                . $this->validator->getError('jenis');
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

            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $keterangan = (int)htmlspecialchars($this->request->getVar('keterangan'), true);

            if ($keterangan === NULL || $keterangan === "") {
                $jenisFix = $jenis;
            } else {
                $jenisFix = $jenis;
            }

            $uuidLib = new Uuid();

            $kodeUsulan = "SKDTKS-" . $user->data->nik . '-' . time();

            $data = [
                'id' => $uuidLib->v4(),
                'kode_permohonan' => $kodeUsulan,
                'kelurahan' => $user->data->kelurahan,
                'ttd' => 'kadis',
                'nik' => $user->data->nik,
                'nama' => $user->data->fullname,
                'user_id' => $user->data->id,
                'jenis' => $jenisFix,
                'status_permohonan' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();
            try {
                $this->_db->table('_permohonan')->insert($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan permohonan baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permohonan Berhasil di Ajukan.";
                $response->redirect = base_url('silastri/peng/riwayat');
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengajukan permohonan.";
                return json_encode($response);
            }
        }
    }
}
