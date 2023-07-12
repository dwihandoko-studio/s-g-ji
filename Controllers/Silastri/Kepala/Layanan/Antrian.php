<?php

namespace App\Controllers\Silastri\Kepala\Layanan;

use App\Controllers\BaseController;
use App\Models\Silastri\Kepala\Layanan\AntrianModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Tte\Bsrelib;
use App\Libraries\Uuid;

class Antrian extends BaseController
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
        $datamodel = new AntrianModel($request);

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
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="javascript:actionDetail(\'' . $list->id_permohonan . '\', \'' . $list->nik . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
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
        return redirect()->to(base_url('silastri/kepala/layanan/antrian/data'));
    }

    public function data()
    {
        $data['title'] = 'Antrian TTE Surat';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        // $data['jeniss'] = ['Surat Keterangan DTKS untuk Pengajuan PIP', 'Surat Keterangan DTKS untuk Pendaftaran PPDB', 'Surat Keterangan DTKS untuk Pengajuan PLN', 'Lainnya'];

        return view('silastri/kepala/layanan/antrian/index', $data);
    }

    public function detail()
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
            'nik' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK tidak boleh kosong. ',
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
                . $this->validator->getError('nik')
                . $this->validator->getError('nama');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);

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
                ->where(['a.id' => $id, 'a.status_permohonan' => 2])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;

                switch ($current->layanan) {
                    case 'SKTM':
                        $dirFile = 'sktm';
                        break;
                    case 'SKDTKS':
                        $dirFile = 'dtks';
                        break;

                    default:
                        $dirFile = 'notfound';
                        break;
                }

                $data['file'] = $dirFile . '/' . $current->nik . '.pdf';
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('silastri/kepala/layanan/antrian/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function prosestte()
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
            'password' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Password tidak boleh kosong.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('password');
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
            $password = htmlspecialchars($this->request->getVar('password'), true);

            $oldData = $this->_db->table('_permohonan')->where(['id' => $id])->get()->getRowObject();
            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Usulan tidak ditemukan.";
                return json_encode($response);
            }

            switch ($oldData->layanan) {
                case 'SKTM':
                    $dirFile = 'sktm';
                    break;
                case 'SKDTKS':
                    $dirFile = 'dtks';
                    break;

                default:
                    $dirFile = 'notfound';
                    break;
            }

            $dataSend = [
                'nik' => $user->data->nik,
                'passphrase' => $password,
                'tampilan' => 'INVISIBLE',
                'page' => 1,
                'xAxis' => '1',
                'yAxis' => '1',
                'width' => '1',
                'height' => '1',
                'reason' => $oldData->jenis . '(' . $oldData->nik . ')',
                'location' => 'Kabupaten Lampung Tengah',
                'file' => new \CURLFile('/var/www/public/upload/' . $dirFile . '/' . $oldData->nik . '.pdf', 'application/pdf', $oldData->nik . '.pdf'),
            ];

            $bsreLib = new Bsrelib();
            $data = $bsreLib->signDocument($dataSend);
            switch ($http_code = $data->status) {

                case "SUCCESS":  # OK
                    // var_dump($data->data->dokumen);die;
                    $this->_db->transBegin();
                    $dateNya = date('Y-m-d H:i:s');
                    $builder = $this->_db->table('_permohonan');
                    $builder->where('id', $id)->update([
                        'status_permohonan' => 5,
                        'updated_at' => $dateNya,
                    ]);
                    if ($this->_db->affectedRows() > 0) {
                        $builderInsert = $this->_db->table('_file_tte');
                        $builderInsert->insert([
                            'id' => $oldData->id,
                            'user_id' => $user->data->id,
                            'created_at' => $dateNya,
                            'dokumen_tte' => $data->data->idDokumen,
                            'file_dokumen_tte' => $data->data->dokumen
                        ]);

                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();
                            $response = new \stdClass;
                            $response->code = 200;
                            $response->message = $data->message;
                            $response->redirrect = base_url('silastri/kepala/layanan/approved/detail') . '?token=' . $id;
                            $response->filename = $oldData->kode_permohonan . ".pdf";
                            $response->data = base64_encode($data->data->dokumen);
                            // $response->data = $data->data->dokumen;
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->code = 400;
                            $response->message = "Gagal mengupdate dokumen.";
                            return json_encode($response);
                        }
                    } else {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->code = 400;
                        $response->message = "Gagal mengupdate dokumen.";
                        return json_encode($response);
                    }
                    break;
                case "UNAUTHORIZED":
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = $data->message;
                    return json_encode($response);
                    break;
                case "NOT_FOUND":
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Url tidak ditemukan.";
                    return json_encode($response);
                    break;
                default:
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = $data->message;
                    // $response->message = "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.";
                    return json_encode($response);
            }



            // if ($this->_db->affectedRows() > 0) {
            //     $this->_db->transCommit();
            //     $response = new \stdClass;
            //     $response->status = 200;
            //     $response->redirrect = base_url('silastri/kepala/layanan/proses/detail') . '?token=' . $id;
            //     $response->message = "Proses Permohonan $nama berhasil dilakukan.";
            //     return json_encode($response);
            // } else {
            //     $this->_db->transRollback();
            //     $response = new \stdClass;
            //     $response->status = 400;
            //     $response->message = "Gagal memproses permohonan $nama";
            //     return json_encode($response);
            // }
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
            $response->data = view('silastri/kepala/layanan/antrian/tolak', $data);
            return json_encode($response);
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

            $oldData = $this->_db->table('_permohonan_temp')->where(['id' => $id])->get()->getRowArray();
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
            $oldData['status_permohonan'] = 3;

            $this->_db->transBegin();
            $this->_db->table('_permohonan_tolak')->insert($oldData);
            if ($this->_db->affectedRows() > 0) {
                $this->_db->table('_permohonan_temp')->where('id', $oldData['id'])->delete();
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
                    $response->redirrect = base_url('silastri/kepala/layanan/antrian');
                    $response->message = "Tolak Proses Permohonan $nama berhasil dilakukan.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menolak proses permohonan $nama";
                    return json_encode($response);
                }
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menolak proses permohonan $nama";
                return json_encode($response);
            }
        }
    }
}
