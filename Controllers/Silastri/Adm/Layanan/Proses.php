<?php

namespace App\Controllers\Silastri\Adm\Layanan;

use App\Controllers\BaseController;
use App\Models\Silastri\Adm\Layanan\ProsesModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Silastri\Ttelib;
use App\Libraries\Uuid;

class Proses extends BaseController
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
        $datamodel = new ProsesModel($request);

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $layanans = getGrantedAccessLayanan($user->data->id);
        $lists = $datamodel->get_datatables($layanans);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="./detail?token=' . $list->id_permohonan . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
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
            "recordsTotal" => $datamodel->count_all($layanans),
            "recordsFiltered" => $datamodel->count_filtered($layanans),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('silastri/adm/layanan/proses/data'));
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

        return view('silastri/adm/layanan/proses/index', $data);
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
            ->where("a.id = '$id' AND (a.status_permohonan = 1 OR a.status_permohonan = 2)")->get()->getRowObject();

        if ($current) {
            $data['data'] = $current;
            return view('silastri/adm/layanan/proses/detail-page', $data);
        } else {
            return view('404', ['error' => "Data tidak ditemukan."]);
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

    public function prosesttefromtemp()
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

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_approve'] = $date;
            $oldData['admin_approve'] = $user->data->id;
            $oldData['status_permohonan'] = 2;

            $contentCreator = [
                'author' => $user->data->fullname,
                'title' => $oldData['jenis'] . ' (' . $oldData['nama'] . ')',
                'subject' => $oldData['jenis'] . ' (' . $oldData['nama'] . ') - ' . $oldData['kode_permohonan'],
                'keyword' => 'TTE, Signature, Lampung Tengah, ' . $oldData['jenis'] . ', ' . $oldData['kode_permohonan'],
            ];

            $dir = FCPATH . "upload/dtks";
            $dir_temp = FCPATH . "upload/dtks-temp/";

            $tteUpload = new Ttelib();
            $uploaded = $tteUpload->createUploadFile($dir_temp . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['id'] . '&choe=UTF-8');
            // $uploaded = $tteUpload->createUploadFile($dir_pdf_tte, $dir, $newNamelampiran, $contentCreator);
            // var_dump($uploaded);
            // die;
            if ($uploaded->code === 200) {
                $data['lampiran_selesai'] = $oldData['nik'] . '.pdf';
            } else {
                $response = new \stdClass;
                $response->status = 400;
                // $response->erronya = var_dump($uploaded->message);
                $response->message = "Kesalahan dalam mengupload file, file pdf max versi 1.5.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            $this->_db->table('_permohonan')->where('id', $oldData['id'])->update($oldData);
            if ($this->_db->affectedRows() > 0) {
                // $this->_db->table('_permohonan_temp')->where('id', $oldData['id'])->delete();
                // if ($this->_db->affectedRows() > 0) {
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
                $response->redirrect = base_url('silastri/adm/layanan/approval');
                $response->message = "Selesaikan Permohonan $nama berhasil dilakukan.";
                return json_encode($response);
                // } else {
                //     $this->_db->transRollback();
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal menyelesaikan permohonan $nama";
                //     return json_encode($response);
                // }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyelesaikan permohonan $nama";
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

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_approve'] = $date;
            $oldData['admin_approve'] = $user->data->id;
            $oldData['status_permohonan'] = 2;

            $this->_db->transBegin();
            $this->_db->table('_permohonan')->where('id', $oldData['id'])->update($oldData);
            if ($this->_db->affectedRows() > 0) {
                // $this->_db->table('_permohonan_temp')->where('id', $oldData['id'])->delete();
                // if ($this->_db->affectedRows() > 0) {
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
                $response->redirrect = base_url('silastri/adm/layanan/approval');
                $response->message = "Selesaikan Permohonan $nama berhasil dilakukan.";
                return json_encode($response);
                // } else {
                //     $this->_db->transRollback();
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal menyelesaikan permohonan $nama";
                //     return json_encode($response);
                // }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyelesaikan permohonan $nama";
                return json_encode($response);
            }
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
            $response->data = view('silastri/adm/layanan/proses/tolak', $data);
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

            $oldData = $this->_db->table('_permohonan')->where('id', $id)->get()->getRowObject();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data permohonan layanan tidak ditemukan.";
                return json_encode($response);
            }

            $data['id'] = $id;
            $data['nama'] = $nama;
            $data['data'] = $oldData;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";

            switch ($oldData->layanan) {
                case 'SKDTKS':
                    $response->data = view('silastri/adm/layanan/proses/form-upload', $data);
                    break;
                case 'SKTM':
                    $response->data = view('silastri/adm/layanan/proses/form-input', $data);
                    break;
                case 'PBI':
                    $response->data = view('silastri/adm/layanan/proses/form-input', $data);
                    break;

                default:
                    $response->data = view('silastri/adm/layanan/proses/form-upload', $data);
                    break;
            }
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
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi pdf. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
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

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $dir = "";
            $dir_temp = '';
            $table_db = '';

            switch ($oldData['layanan']) {
                case 'SKDTKS':
                    $dir = FCPATH . "upload/dtks";
                    $dir_temp = FCPATH . "upload/dtks-temp";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'SKTM':
                    $dir = FCPATH . "upload/sktm";
                    $dir_temp = FCPATH . "upload/sktm-temp";
                    $field_db = 'kgb_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'PBI':
                    $dir = FCPATH . "upload/pbi";
                    $dir_temp = FCPATH . "upload/pbi-temp";
                    $field_db = 'pernyataan_24jam';
                    $table_db = '_upload_data_attribut';
                    break;
                case 'LKS':
                    $dir = FCPATH . "upload/lks";
                    $dir_temp = FCPATH . "upload/lks-temp";
                    $field_db = 'cuti';
                    $table_db = '_upload_data_attribut';
                    break;
                default:
                    $dir = FCPATH . "upload/dtks";
                    $dir_temp = FCPATH . "upload/dtks-temp";
                    $field_db = 'pangkat_terakhir';
                    $table_db = '_upload_data_attribut';
                    break;
            }

            $lampiran = $this->request->getFile('_file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = $oldData['nik'] . ".pdf";

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir_temp, $newNamelampiran);
                // $data[$field_db] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_approve'] = $date;
            $oldData['admin_approve'] = $user->data->id;
            $oldData['status_permohonan'] = 2;

            $contentCreator = [
                'author' => $user->data->fullname,
                'title' => $oldData['jenis'] . ' (' . $oldData['nama'] . ')',
                'subject' => $oldData['jenis'] . ' (' . $oldData['nama'] . ') - ' . $oldData['kode_permohonan'],
                'keyword' => 'TTE, Signature, Lampung Tengah, ' . $oldData['jenis'] . ', ' . $oldData['kode_permohonan'],
            ];

            $tteUpload = new Ttelib();
            $uploaded = $tteUpload->createUploadFile($dir_temp . '/' . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['id'] . '&choe=UTF-8');
            // $uploaded = $tteUpload->createUploadFile($dir_pdf_tte, $dir, $newNamelampiran, $contentCreator);
            // var_dump($uploaded);
            // die;
            if ($uploaded->code === 200) {
                $oldData['lampiran_selesai'] = $oldData['nik'] . '.pdf';
            } else {
                unlink($dir_temp . '/' . $newNamelampiran);
                $response = new \stdClass;
                $response->status = 400;
                // $response->erronya = var_dump($uploaded->message);
                $response->message = "Kesalahan dalam mengupload file, file pdf max versi 1.5.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            $this->_db->table('_permohonan')->where('id', $oldData['id'])->update($oldData);
            if ($this->_db->affectedRows() > 0) {
                // $this->_db->table('_permohonan_temp')->where('id', $oldData['id'])->delete();
                // if ($this->_db->affectedRows() > 0) {
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
                $response->redirrect = base_url('silastri/adm/layanan/approval');
                $response->message = "Selesaikan Permohonan $nama berhasil dilakukan.";
                return json_encode($response);
                // } else {
                //     $this->_db->transRollback();
                //     $response = new \stdClass;
                //     $response->status = 400;
                //     $response->message = "Gagal menyelesaikan permohonan $nama";
                //     return json_encode($response);
                // }
            } else {
                unlink($dir_temp . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyelesaikan permohonan $nama";
                return json_encode($response);
            }
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

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Permohonan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $oldData['updated_at'] = $date;
            $oldData['date_reject'] = $date;
            $oldData['admin_reject'] = $user->data->id;
            $oldData['keterangan_reject'] = $keterangan;
            $oldData['status_permohonan'] = 4;

            $this->_db->transBegin();
            $this->_db->table('_permohonan_tolak')->insert($oldData);
            if ($this->_db->affectedRows() > 0) {
                $this->_db->table('_permohonan')->where('id', $oldData['id'])->delete();
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
                    $response->redirrect = base_url('silastri/adm/layanan/antrian');
                    $response->message = "Tolak Selesai Permohonan $nama berhasil dilakukan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menolak selesai permohonan $nama";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menolak selesai permohonan $nama";
                return json_encode($response);
            }
        }
    }
}
