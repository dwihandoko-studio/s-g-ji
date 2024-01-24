<?php

namespace App\Controllers\Silastri\Peksos\Layanan;

use App\Controllers\BaseController;
use App\Models\Silastri\Peksos\Layanan\ProsesModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Silastri\Ttelib;
use App\Libraries\Uuid;

use PhpOffice\PhpWord\TemplateProcessor;

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
        return redirect()->to(base_url('silastri/peksos/layanan/proses/data'));
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

        return view('silastri/peksos/layanan/proses/index', $data);
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
            return view('silastri/peksos/layanan/proses/detail-page', $data);
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
            $uploaded = $tteUpload->createUploadFile($dir_temp . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_permohonan']);
            // $uploaded = $tteUpload->createUploadFile($dir_temp . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['id'] . '&choe=UTF-8');
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
                $response->redirrect = base_url('silastri/peksos/layanan/approval');
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
                $response->redirrect = base_url('silastri/peksos/layanan/approval');
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
            $response->data = view('silastri/peksos/layanan/proses/tolak', $data);
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

            $formsktm = $this->_db->table('_permohonan_doc')->where('id', $oldData->id)->get()->getRowObject();

            if ($formsktm) {
                $response->data = view('silastri/peksos/layanan/proses/form-upload-download', $data);
                return json_encode($response);
            }


            switch ($oldData->layanan) {
                case 'SKDTKS':
                    $response->data = view('silastri/peksos/layanan/proses/form-upload', $data);
                    break;
                case 'SKTM':

                    $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
                    $response->data = view('silastri/peksos/layanan/proses/form-input-sktm', $data);
                    break;
                case 'PBI':
                    $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
                    $response->data = view('silastri/peksos/layanan/proses/form-input', $data);
                    break;

                default:
                    $response->data = view('silastri/peksos/layanan/proses/form-upload', $data);
                    break;
            }
            return json_encode($response);
        }
    }

    public function savesktm()
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
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kecamatan pengeluaran surat tidak boleh kosong. ',
                ]
            ],
            'kelurahan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kelurahan pengeluaran surat tidak boleh kosong. ',
                ]
            ],
            'nomor_sktm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor SKTM tidak boleh kosong. ',
                ]
            ],
            'tgl_sktm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal SKTM tidak boleh kosong. ',
                ]
            ],
            // '_file' => [
            //     'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,application/pdf]',
            //     'errors' => [
            //         'uploaded' => 'Pilih file terlebih dahulu. ',
            //         'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
            //         'mime_in' => 'Ekstensi yang anda upload harus berekstensi pdf. '
            //     ]
            // ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('kecamatan')
                . $this->validator->getError('kelurahan')
                . $this->validator->getError('nomor_sktm')
                . $this->validator->getError('tgl_sktm');
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
            $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);
            $kelurahan = htmlspecialchars($this->request->getVar('kelurahan'), true);
            $nomor_sktm = htmlspecialchars($this->request->getVar('nomor_sktm'), true);
            $tgl_sktm = htmlspecialchars($this->request->getVar('tgl_sktm'), true);

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowArray();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            $date = date('Y-m-d H:i:s');

            $nomor = $this->_db->table('_permohonan_doc')->select("no_surat")->orderBy('no_surat', 'DESC')->get()->getRowObject();

            if ($nomor) {
                $nomorFix = (int)$nomor->no_surat + 1;
            } else {
                $nomorFix = 1;
            }

            $data = [
                'id' => $oldData['id'],
                'no_surat' => $nomorFix,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'nomor_sktm' => $nomor_sktm,
                'tgl_sktm' => $tgl_sktm,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            switch ($oldData['layanan']) {
                case 'SKTM':
                    $tujuan_rss = $this->request->getVar('tujuan_rs');
                    $tujuan_surats = $this->request->getVar('tujuan_surat');
                    $tempat_surats = $this->request->getVar('tempat_surat');
                    $perihal_surats = $this->request->getVar('perihal_surat');

                    if ($tujuan_rss == "" || $tujuan_rss == NULL) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Tujuan rs tidak boleh kosong.";
                        return json_encode($response);
                    }

                    if ($tujuan_surats == "" || $tujuan_surats == NULL) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Tujuan surat tidak boleh kosong.";
                        return json_encode($response);
                    }

                    if ($tempat_surats == "" || $tempat_surats == NULL) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Tujuan tempat surat tidak boleh kosong.";
                        return json_encode($response);
                    }

                    if ($perihal_surats == "" || $perihal_surats == NULL) {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Perihal surat tidak boleh kosong.";
                        return json_encode($response);
                    }

                    $tujuan_rs = htmlspecialchars($tujuan_rss, true);
                    $tujuan_surat = htmlspecialchars($tujuan_surats, true);
                    $tempat_surat = htmlspecialchars($tempat_surats, true);
                    $perihal_surat = htmlspecialchars($perihal_surats, true);

                    $data['tujuan_rs'] = $tujuan_rs;
                    $data['tujuan_surat'] = $tujuan_surat;
                    $data['tempat_surat'] = $tempat_surat;
                    $data['perihal_surat'] = $perihal_surat;
                    $data['template'] = "sktm.docx";
                    $dir = FCPATH . "upload/sktm";
                    break;
                case 'PBI':
                    if ($oldData['jenis'] == "Rekomendasi Pengusulan Baru Peserta PBI APBD" || $oldData['jenis'] == "Rekomendasi Pengusulan Pengaktifan PBI APBD") {
                        $data['template'] = "pbi-apbd.docx";
                    } else {
                        $data['template'] = "pbi-jk.docx";
                    }
                    $dir = FCPATH . "upload/pbi";
                    break;

                default:
                    $data['template'] = "sktm.docx";
                    $dir = FCPATH . "upload/sktm";
                    break;
            }

            $this->_db->transBegin();
            $this->_db->table('_permohonan_doc')->insert($data);
            if ($this->_db->affectedRows() > 0) {
                $generateFile = $this->_download($oldData['id']);
                if (!$generateFile) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    // $response->erronya = var_dump($uploaded->message);
                    $response->message = "Gagal dalam mengenerate dokumen.";
                    return json_encode($response);
                }
                if ($generateFile->status !== 200) {
                    $this->_db->transRollback();
                    return json_encode($generateFile);
                }

                $oldData['updated_at'] = $date;
                $oldData['date_approve'] = $date;
                $oldData['admin_approve'] = $user->data->id;
                $oldData['status_permohonan'] = 2;

                $contentCreator = [
                    'author' => $user->data->fullname,
                    'title' => $oldData['jenis'] . ' (' . $oldData['nama'] . ')',
                    'subject' => $oldData['jenis'] . ' (' . $oldData['nama'] . ') - ' . $oldData['kode_permohonan'],
                    'keyword' => 'TTE, Signature, Lampung Tengah, Si-Lastri, ' . $oldData['jenis'] . ', ' . $oldData['kode_permohonan'],
                ];

                try {

                    $tteUpload = new Ttelib();
                    $uploaded = $tteUpload->createUploadFileGenerate($generateFile->dir, $dir, $generateFile->filename, $contentCreator, 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_permohonan']);
                    // $uploaded = $tteUpload->createUploadFileGenerate($generateFile->dir, $dir, $generateFile->filename, $contentCreator, 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['id'] . '&choe=UTF-8');
                    // $uploaded = $tteUpload->createUploadFile($dir_pdf_tte, $dir, $newNamelampiran, $contentCreator);
                    // var_dump($uploaded);
                    // die;
                    if ($uploaded->code === 200) {
                        $oldData['lampiran_selesai'] = $generateFile->filename;
                    } else {
                        try {
                            unlink($generateFile->dir);
                            unlink($generateFile->dir_temp);
                        } catch (\Throwable $th) {
                        }
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        // $response->erronya = var_dump($uploaded->message);
                        $response->message = "Kesalahan dalam mengenerate dokumen, dokumen pdf max versi 1.5.";
                        return json_encode($response);
                    }
                    //code...
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($th);
                    $response->erronya = $generateFile;
                    $response->message = "Kesalahan dalam mengenerate dokumen, dokumen pdf max versi 1.5.";
                    return json_encode($response);
                }

                $this->_db->table('_permohonan')->where('id', $oldData['id'])->update($oldData);

                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->redirrect = base_url('silastri/peksos/layanan/approval');
                $response->message = "Proses Permohonan Persetujuan $nama berhasil. Selanjutnya menunggu TTE Kepala Dinas.";
                $response->id = $oldData['id'];
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan keterangan SKTM permohonan $nama";
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
            $uploaded = $tteUpload->createUploadFile($dir_temp . '/' . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['kode_permohonan']);
            // $uploaded = $tteUpload->createUploadFile($dir_temp . '/' . $oldData['nik'] . '.pdf', $dir, $oldData['nik'] . '.pdf', $contentCreator, 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData['id'] . '&choe=UTF-8');
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
                $response->redirrect = base_url('silastri/peksos/layanan/approval');
                $response->message = "Proses Permohonan Persetujuan $nama berhasil. Selanjutnya menunggu TTE Kepala Dinas.";
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
                    $response->redirrect = base_url('silastri/peksos/layanan/antrian');
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

    public function downloadtemp()
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

        $id = htmlspecialchars($this->request->getVar('id'), true);

        $currents = $this->_db->table('_permohonan a')
            ->select("b.*, a.id as id_permohonan, a.kode_permohonan, a.layanan, a.jenis, c.template, c.no_surat, c.nomor_sktm, c.tgl_sktm, d.kecamatan as nama_kecamatan_sktm, e.kelurahan as nama_kelurahan_sktm, f.kecamatan as nama_kecamatan, g.kelurahan as nama_kelurahan")
            ->join('_permohonan_doc c', 'a.id = c.id')
            ->join('_profil_users_tb b', 'a.user_id = b.id')
            ->join('ref_kecamatan d', 'c.kecamatan = d.id', 'LEFT')
            ->join('ref_kelurahan e', 'c.kelurahan = e.id', 'LEFT')
            ->join('ref_kecamatan f', 'b.kecamatan = d.id', 'LEFT')
            ->join('ref_kelurahan g', 'b.kelurahan = e.id', 'LEFT')
            ->where('a.id', $id)
            ->get()->getRowObject();
        if (!$currents) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Data tidak ditemukan.";
            return json_encode($response);
        }

        return $this->_download($currents);
        // }
    }

    private function _download($id)
    {
        $data = $this->_db->table('_permohonan a')
            ->select("b.*, a.id as id_permohonan, a.kode_permohonan, a.layanan, a.jenis, c.template, c.no_surat, c.nomor_sktm, c.tgl_sktm, c.tujuan_rs, c.tujuan_surat, c.tempat_surat, c.perihal_surat, d.kecamatan as nama_kecamatan_sktm, e.kelurahan as nama_kelurahan_sktm, f.kecamatan as nama_kecamatan, g.kelurahan as nama_kelurahan")
            ->join('_permohonan_doc c', 'a.id = c.id')
            ->join('_profil_users_tb b', 'a.user_id = b.id')
            ->join('ref_kecamatan d', 'c.kecamatan = d.id', 'LEFT')
            ->join('ref_kelurahan e', 'c.kelurahan = e.id', 'LEFT')
            ->join('ref_kecamatan f', 'b.kecamatan = f.id', 'LEFT')
            ->join('ref_kelurahan g', 'b.kelurahan = g.id', 'LEFT')
            ->where('a.id', $id)
            ->get()->getRowObject();

        if ($data) {
            if ($data->layanan == "SKTM") {
                if ($data->jenis == "SKTM Rekomendasi Keringanan Biaya Pengobatan Rumah Sakit" || $data->jenis == 0) {
                    $file = FCPATH . "upload/template/$data->template";
                    $template_processor = new TemplateProcessor($file);
                    $template_processor->setValue('NOMOR_SURAT', "008/E-LS.$data->no_surat/D.a.VII/2023");
                    $template_processor->setValue('PERIHAL', $data->perihal_surat);
                    $template_processor->setValue('KELURAHAN_SKTM', $data->nama_kelurahan_sktm);
                    $template_processor->setValue('KECAMATAN_SKTM', $data->nama_kecamatan_sktm);
                    $template_processor->setValue('NOMOR_SKTM', $data->nomor_sktm);
                    $template_processor->setValue('TUJUAN_SURAT', $data->tujuan_surat);
                    $template_processor->setValue('TEMPAT_TUJUAN_SURAT', $data->tempat_surat);
                    $template_processor->setValue('TUJUAN_SKTM', $data->tujuan_rs);
                    $template_processor->setValue('DTKS_SIKS_NG',  "");
                    $template_processor->setValue('P3KE', " ");
                    $template_processor->setValue('TGL_SKTM', tgl_indo($data->tgl_sktm));

                    $template_processor->setValue('NAMA_PENGUSUL', $data->fullname);
                    // $template_processor->setValue('KK_PENGUSUL', $data->kk);
                    $template_processor->setValue('NIK_PENGUSUL', $data->nik);
                    // $template_processor->setValue('TEMPAT_LAHIR_PENGUSUL', $data->tempat_lahir);
                    // $template_processor->setValue('TGL_LAHIR_PENGUSUL', tgl_indo($data->tgl_lahir));
                    // $template_processor->setValue('PEKERJAAN_PENGUSUL', $data->pekerjaan);
                    $template_processor->setValue('ALAMAT_PENGUSUL', $data->alamat);
                    $template_processor->setValue('KELURAHAN_PENGUSUL', $data->nama_kelurahan);
                    $template_processor->setValue('KECAMATAN_PENGUSUL', $data->nama_kecamatan);
                    $template_processor->setValue('TGL_KELUAR', tgl_indo(date('Y-m-d')));
                    $template_processor->setValue('JABATAN_TTD', "KEPALA DINAS SOSIAL");
                    $template_processor->setValue('NAMA_KABUPATEN', "KABUPATEN LAMPUNG TENGAH");
                    $template_processor->setValue('NAMA_TTD', "ARI NUGRAHA MUKTI,S.STP.,M.M.");
                    $template_processor->setValue('PANGKAT_TTD', "Pembina (IV/a)");
                    $template_processor->setValue('NIP_TTD', "NIP. 19860720 200501 1 004");

                    // $template_processor->setImageValue('BARCODE', array('path' => 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=layanan.disdikbud.lampungtengahkab.go.id/verifiqrcodev?token=' . $ptks[0]->kode_verifikasi . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));
                    $template_processor->setImageValue('BARCODE', array('path' => 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcodev?token=' . $data->kode_permohonan, 'width' => 100, 'height' => 100, 'ratio' => false));

                    $filed = FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx";

                    $template_processor->saveAs($filed);

                    sleep(3);

                    $datas = [
                        'nama_file' => $data->kode_permohonan . '.docx',
                        'file_folder' => $filed,
                    ];

                    $curlHandle = curl_init("http://192.168.33.30:1890/convert");
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
                            unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
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
                            $response->redirrect = base_url('silastri/peksos/layanan/approval');
                            $response->message = "Selesaikan Permohonan $data->fullname berhasil dilakukan. Tinggal menunggu TTE kadis.";
                            $response->result = $result;
                            $response->dir = FCPATH . "upload/generate/surat/pdf/" . $data->kode_permohonan . ".pdf";
                            $response->dir_temp = FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx";
                            $response->filename = $data->kode_permohonan . ".pdf";
                            return $response;
                        } else {
                            try {
                                unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
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
                            unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengenerate dokumen.";
                        return $response;
                    }
                }
            } else {
                $file = FCPATH . "upload/template/$data->template";
                $template_processor = new TemplateProcessor($file);
                $template_processor->setValue('NOMOR_SURAT', "008/E-LS.$data->no_surat/D.a.VII/2023");
                $template_processor->setValue('KELURAHAN_SKTM', $data->nama_kelurahan_sktm);
                $template_processor->setValue('KECAMATAN_SKTM', $data->nama_kecamatan_sktm);
                $template_processor->setValue('NOMOR_SKTM', $data->nomor_sktm);
                $template_processor->setValue('TGL_SKTM', tgl_indo($data->tgl_sktm));

                $template_processor->setValue('NAMA_PENGUSUL', $data->fullname);
                $template_processor->setValue('KK_PENGUSUL', $data->kk);
                $template_processor->setValue('NIK_PENGUSUL', $data->nik);
                $template_processor->setValue('TEMPAT_LAHIR_PENGUSUL', $data->tempat_lahir);
                $template_processor->setValue('TGL_LAHIR_PENGUSUL', tgl_indo($data->tgl_lahir));
                $template_processor->setValue('PEKERJAAN_PENGUSUL', $data->pekerjaan);
                $template_processor->setValue('ALAMAT_PENGUSUL', $data->alamat);
                $template_processor->setValue('KELURAHAN_PENGUSUL', $data->nama_kelurahan);
                $template_processor->setValue('KECAMATAN_PENGUSUL', $data->nama_kecamatan);
                $template_processor->setValue('TGL_KELUAR', tgl_indo(date('Y-m-d')));
                $template_processor->setValue('JABATAN_TTD', "KEPALA DINAS SOSIAL");
                $template_processor->setValue('NAMA_KABUPATEN', "KABUPATEN LAMPUNG TENGAH");
                $template_processor->setValue('NAMA_TTD', "ARI NUGRAHA MUKTI,S.STP.,M.M.");
                $template_processor->setValue('PANGKAT_TTD', "Pembina (IV/a)");
                $template_processor->setValue('NIP_TTD', "NIP. 19860720 200501 1 004");

                // $template_processor->setImageValue('BARCODE', array('path' => 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=layanan.disdikbud.lampungtengahkab.go.id/verifiqrcodev?token=' . $ptks[0]->kode_verifikasi . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));
                $template_processor->setImageValue('BARCODE', array('path' => 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcodev?token=' . $data->kode_permohonan, 'width' => 70, 'height' => 70, 'ratio' => false));

                $filed = FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx";

                $template_processor->saveAs($filed);

                sleep(3);

                $datas = [
                    'nama_file' => $data->kode_permohonan . '.docx',
                    'file_folder' => $filed,
                ];

                $curlHandle = curl_init("http://192.168.33.30:1890/convert");
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
                        unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
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
                        $response->redirrect = base_url('silastri/peksos/layanan/approval');
                        $response->message = "Selesaikan Permohonan $data->fullname berhasil dilakukan. Tinggal menunggu TTE kadis.";
                        $response->result = $result;
                        $response->dir = FCPATH . "upload/generate/surat/pdf/" . $data->kode_permohonan . ".pdf";
                        $response->dir_temp = FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx";
                        $response->filename = $data->kode_permohonan . ".pdf";
                        return $response;
                    } else {
                        try {
                            unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
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
                        unlink(FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx");
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengenerate dokumen.";
                    return $response;
                }
            }


            // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // // header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment; filename="' . basename($filed) . '"');
            // header('Content-Length: ' . filesize($filed));
            // readfile($filed);
            // exit;

            // return;
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Data tidak ditemukan.";
            return $response;
        }
    }

    // private function _download($data)
    // {
    //     if ($data) {
    //         $file = FCPATH . "upload/template/$data->template";
    //         $template_processor = new TemplateProcessor($file);
    //         $template_processor->setValue('NOMOR_SURAT', "008/E-LS.$data->no_surat/D.a.VII/2023");
    //         $template_processor->setValue('KELURAHAN_SKTM', $data->nama_kelurahan_sktm);
    //         $template_processor->setValue('KECAMATAN_SKTM', $data->nama_kecamatan_sktm);
    //         $template_processor->setValue('NOMOR_SKTM', $data->nomor_sktm);
    //         $template_processor->setValue('TGL_SKTM', tgl_indo($data->tgl_sktm));

    //         $template_processor->setValue('NAMA_PENGUSUL', $data->fullname);
    //         $template_processor->setValue('KK_PENGUSUL', $data->kk);
    //         $template_processor->setValue('NIK_PENGUSUL', $data->nik);
    //         $template_processor->setValue('TEMPAT_LAHIR_PENGUSUL', $data->tempat_lahir);
    //         $template_processor->setValue('TGL_LAHIR_PENGUSUL', tgl_indo($data->tgl_lahir));
    //         $template_processor->setValue('PEKERJAAN_PENGUSUL', $data->pekerjaan);
    //         $template_processor->setValue('ALAMAT_PENGUSUL', $data->alamat);
    //         $template_processor->setValue('KELURAHAN_PENGUSUL', $data->nama_kelurahan);
    //         $template_processor->setValue('KECAMATAN_PENGUSUL', $data->nama_kecamatan);
    //         $template_processor->setValue('TGL_KELUAR', tgl_indo(date('Y-m-d')));
    //         $template_processor->setValue('JABATAN_TTD', "Plt. Kepala Dinas Sosial");
    //         $template_processor->setValue('NAMA_KABUPATEN', "Kabupaten Lampung Tengah");
    //         $template_processor->setValue('NAMA_TTD', "ARI NUGRAHA MUKTI,S.STP.,M.M.");
    //         $template_processor->setValue('NIP_TTD', "NIP. 19860720 200501 1 004");

    //         // $template_processor->setImageValue('BARCODE', array('path' => 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=layanan.disdikbud.lampungtengahkab.go.id/verifiqrcodev?token=' . $ptks[0]->kode_verifikasi . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));

    //         $filed = FCPATH . "upload/generate/surat/word/" . $data->kode_permohonan . ".docx";

    //         $template_processor->saveAs($filed);

    //         sleep(3);

    //         $datas = [
    //             'nama_file' => $data->kode_permohonan . '.docx',
    //             'file_folder' => $filed,
    //         ];

    //         $curlHandle = curl_init("http://10.20.30.99:1890/convert");
    //         curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
    //         curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($datas));
    //         curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
    //             // 'X-API-TOKEN: ' . $apiToken,
    //             // 'Authorization: Bearer ' . $jwt,
    //             'Content-Type: application/json'
    //         ));
    //         curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
    //         curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 120);

    //         $send_data         = curl_exec($curlHandle);

    //         $result = json_decode($send_data);


    //         if (isset($result->error)) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Gagal mendownload dokumen.";
    //             return json_encode($response);
    //         }

    //         if ($result) {
    //             $response = new \stdClass;
    //             $response->status = 200;
    //             $response->redirrect = base_url('silastri/peksos/layanan/approval');
    //             $response->message = "Selesaikan Permohonan $data->fullname berhasil dilakukan. Tinggal menunggu TTE kadis.";
    //             $response->result = $result;
    //             return json_encode($response);
    //             // return $result;
    //         } else {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Gagal mendownload dokumen.";
    //             return json_encode($response);
    //         }

    //         // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    //         // // header('Content-Type: application/pdf');
    //         // header('Content-Disposition: attachment; filename="' . basename($filed) . '"');
    //         // header('Content-Length: ' . filesize($filed));
    //         // readfile($filed);
    //         // exit;

    //         // return;
    //     } else {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Gagal mendownload dokumen.";
    //         return json_encode($response);
    //     }
    // }
}
