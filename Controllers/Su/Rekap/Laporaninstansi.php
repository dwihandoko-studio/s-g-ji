<?php

namespace App\Controllers\Su\Rekap;

use App\Controllers\BaseController;
use App\Models\Su\Rekap\LaporaninstansiModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;

class Laporaninstansi
extends BaseController
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
        $datamodel = new LaporaninstansiModel($request);


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
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id_pegawai . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                        </div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->nip;
            $row[] = $list->golongan;
            $row[] = rpTanpaAwalan($list->jumlah_transfer);
            $row[] = rpTanpaAwalan($list->bank_eka_bandar_jaya);
            $row[] = rpTanpaAwalan($list->bank_eka_metro);
            $row[] = rpTanpaAwalan($list->bpd_bandar_jaya);
            $row[] = rpTanpaAwalan($list->bpd_koga);
            $row[] = rpTanpaAwalan($list->bpd_metro);
            $row[] = rpTanpaAwalan($list->bpd_kalirejo);
            $row[] = rpTanpaAwalan($list->wajib_kpn);
            $row[] = rpTanpaAwalan($list->kpn);
            $row[] = rpTanpaAwalan($list->bri);
            $row[] = rpTanpaAwalan($list->btn);
            $row[] = rpTanpaAwalan($list->bni);
            $row[] = rpTanpaAwalan($list->dharma_wanita);
            $row[] = rpTanpaAwalan($list->korpri);
            $row[] = rpTanpaAwalan($list->zakat_profesi);
            $row[] = rpTanpaAwalan($list->infak);
            $row[] = rpTanpaAwalan($list->shodaqoh);
            $jumlahTagihan = $list->bank_eka_bandar_jaya + $list->bank_eka_metro + $list->bpd_bandar_jaya + $list->bpd_koga + $list->bpd_metro + $list->bpd_kalirejo + $list->wajib_kpn + $list->kpn + $list->bri + $list->btn + $list->bni + $list->dharma_wanita + $list->korpri + $list->zakat_profesi + $list->infak + $list->shodaqoh;
            $row[] = rpTanpaAwalan($jumlahTagihan);
            $row[] = rpTanpaAwalan($list->jumlah_transfer - $jumlahTagihan);
            $row[] = $list->no_rekening_bank;
            $row[] = " ";
            // $row[] = $list->nama_kecamatan;
            // $row[] = $list->kode_instansi;

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
        return redirect()->to(base_url('su/rekap/laporaninstansi/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA LAPORAN INSTANSI';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getRowObject();
        $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
        $data['instansis'] = $this->_db->table('tb_pegawai_')
            ->select("kode_instansi, nama_instansi, nama_kecamatan, count(kode_instansi) as jumlah")->groupBy("kode_instansi")->orderBy('nama_kecamatan', 'asc')->orderBy('nama_instansi', 'asc')->get()->getResult();

        return view('su/rekap/laporaninstansi/index', $data);
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
                return redirect()->to(base_url('auth'));
            }

            $data['user'] = $user->data;
            $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getRowObject();
            $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
            $data['instansis'] = $this->_db->table('tb_pegawai_')
                ->select("kode_instansi, nama_instansi, nama_kecamatan, count(kode_instansi) as jumlah")->groupBy("kode_instansi")->orderBy('nama_kecamatan', 'asc')->orderBy('nama_instansi', 'asc')->get()->getResult();

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('su/rekap/laporaninstansi/download', $data);
            return json_encode($response);
            // } else {
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->message = "Data tidak ditemukan";
            //     return json_encode($response);
            // }
        }
    }

    public function aksidownload()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun bulan tidak boleh kosong. ',
                ]
            ],
            'instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Instansi tidak boleh kosong. ',
                ]
            ],
            'type_file' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Type file tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('tahun')
                . $this->validator->getError('instansi')
                . $this->validator->getError('type_file');
            return json_encode($response);
        } else {
            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                delete_cookie('jwt');
                session()->destroy();
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired";
                return json_encode($response);
            }

            $tahun = htmlspecialchars($this->request->getVar('tahun'), true);
            $instansi = htmlspecialchars($this->request->getVar('instansi'), true);
            $type_file = htmlspecialchars($this->request->getVar('type_file'), true);

            $apiLib = new Apilib();

            $result = $apiLib->downloadLaporanIsntansi($tahun, $instansi, $type_file);

            if ($result) {
                // var_dump($result);
                // die;
                if ($result->status == 200) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->data = $result;
                    $response->url = base_url() . "uploads/api/" . $result->data->url;
                    $response->message = "Download Data Berhasil Dilakukan.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = $result;
                    $response->message = "Gagal Tarik Data.";
                    return json_encode($response);
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal Tarik Data";
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
}
