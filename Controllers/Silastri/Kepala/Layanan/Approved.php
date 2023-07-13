<?php

namespace App\Controllers\Silastri\Kepala\Layanan;

use App\Controllers\BaseController;
use App\Models\Silastri\Kepala\Layanan\ApprovedModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Tte\Bsrelib;
use App\Libraries\Uuid;

class Approved extends BaseController
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
        $datamodel = new ApprovedModel($request);

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
            // $action = '<a href="./detail?token=' . $list->id_permohonan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
            //     </a>';
            $action = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="./detail?token=' . $list->id_permohonan . '"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                                <a class="dropdown-item" href="javascript:actionDownload(\'' . $list->id . '\', \'' . $list->kode_permohonan  . '\');"><i class="bx bx-cloud-download font-size-16 align-middle"></i> &nbsp;Download</a>
                            </div>
                        </div>';
            $row[] = $action;
            $row[] = $list->layanan;
            $row[] = $list->kode_permohonan;
            $row[] = $list->nik;
            $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->kk;
            $row[] = $list->jenis;

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
        return redirect()->to(base_url('silastri/kepala/layanan/approved/data'));
    }

    public function data()
    {
        $data['title'] = 'Proses Permohonan Layanan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        // $data['jeniss'] = ['Surat Keterangan DTKS untuk Pengajuan PIP', 'Surat Keterangan DTKS untuk Pendaftaran PPDB', 'Surat Keterangan DTKS untuk Pengajuan PLN', 'Lainnya'];

        return view('silastri/kepala/layanan/approved/index', $data);
    }

    public function detail()
    {
        if ($this->request->getMethod() != 'get') {
            return view('404', ['error' => "Akses tidak diizinkan."]);
        }

        $data['title'] = 'Detail Proses Permohonan Layanan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        $id = htmlspecialchars($this->request->getGet('token') ?? "", true);

        $current = $this->_db->table('_permohonan a')
            ->select("a.*, 
                b.nik as nik_pemohon, 
                b.kk as kk, 
                b.email as email, 
                b.no_hp as no_hp, 
                b.tempat_lahir, 
                b.tgl_lahir, 
                b.jenis_kelamin, 
                b.alamat, 
                c.id as id_kecamatan, 
                c.kecamatan as nama_kecamatan, 
                d.id as id_kelurahan, 
                d.kelurahan as nama_kelurahan")
            ->join('_profil_users_tb b', 'b.id = a.user_id')
            ->join('ref_kecamatan c', 'c.id = b.kecamatan')
            ->join('ref_kelurahan d', 'd.id = b.kelurahan')
            ->where(['a.id' => $id, 'a.status_permohonan' => 1])->get()->getRowObject();

        if ($current) {
            $data['data'] = $current;
            return view('silastri/kepala/layanan/approved/detail-page', $data);
        } else {
            return view('404', ['error' => "Data tidak ditemukan."]);
        }
    }

    public function download()
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
            'kode' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'KOde tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('kode');
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

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $kode = htmlspecialchars($this->request->getVar('kode'), true);

            $data = $this->_db->table('_file_tte')->where('id', $id)->get()->getRowObject();

            if (!$data) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Dokumen tidak ditemukan";
                return json_encode($response);
            }

            if ($data->file_dokumen_tte) {
                $response = new \stdClass;
                $response->code = 200;
                $response->message = "Dokumen ditemukan";
                $response->data = base64_encode($data->file_dokumen_tte);
                return json_encode($response);
            }

            $bsreLib = new Bsrelib();

            $data = $bsreLib->downloadDocument($data->dokumen_tte);

            switch ($http_code = $data->status) {

                case "SUCCESS":  # OK
                    $builder = $this->_db->table('__surat');
                    $builder->where('id', $id)->update([
                        'file_dokumen_tte' => $data->data->dokumen
                    ]);

                    if ($this->_db->affectedRows() > 0) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = $data->message;
                        $response->data = base64_encode($data->data->dokumen);
                        // $response->data = $data->data->dokumen;
                        return json_encode($response);
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupdate dokumen.";
                        return json_encode($response);
                    }
                    break;
                case "UNAUTHORIZED":
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Proses download gagal : User tidak terdaftar.";
                    return json_encode($response);
                    break;
                case "NOT_FOUND":
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Url tidak ditemukan.";
                    return json_encode($response);
                    break;
                default:
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.";
                    return json_encode($response);
            }
        }
    }
}
