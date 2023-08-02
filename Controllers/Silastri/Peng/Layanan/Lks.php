<?php

namespace App\Controllers\Silastri\Peng\Layanan;

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
use App\Libraries\Silastri\Riwayatpermohonanlib;

class Lks extends BaseController
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
        return redirect()->to(base_url('silastri/peng/layanan/lks/add'));
    }

    public function add()
    {
        $data['title'] = 'Layanan LKS';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['data'] = $user->data;

        $data['jeniss'] = ['SKTM Rekomendasi Keringanan Biaya Pengobatan Rumah Sakit Umum Daerah', 'SKTM Pengusulan Baru Peserta PBI APBD', 'SKTM Pengusulan Pengaktifan PBI APBD', 'Lainnya'];

        return view('silastri/peng/layanan/lks/add', $data);
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
            'indikator1' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 1 tidak boleh kosong. ',
                ]
            ],
            'indikator2' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 2 tidak boleh kosong. ',
                ]
            ],
            'indikator3' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 3 tidak boleh kosong. ',
                ]
            ],
            'indikator4' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 4 tidak boleh kosong. ',
                ]
            ],
            'indikator5' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 5 tidak boleh kosong. ',
                ]
            ],
            'indikator6' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Indikator 6 tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiranKtp = dot_array_search('_file_ktp.name', $_FILES);
        if ($filenamelampiranKtp != '') {
            $lampiranValKtp = [
                '_file_ktp' => [
                    'rules' => 'uploaded[_file_ktp]|max_size[_file_ktp,2048]|mime_in[_file_ktp,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen KTP terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen KTP terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKtp);
        }

        $filenamelampiranKk = dot_array_search('_file_kk.name', $_FILES);
        if ($filenamelampiranKk != '') {
            $lampiranValKk = [
                '_file_kk' => [
                    'rules' => 'uploaded[_file_kk]|max_size[_file_kk,2048]|mime_in[_file_kk,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen KK terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen KK terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKk);
        }

        $filenamelampiranPernyataan = dot_array_search('_file_pernyataan.name', $_FILES);
        if ($filenamelampiranPernyataan != '') {
            $lampiranValPernyataan = [
                '_file_pernyataan' => [
                    'rules' => 'uploaded[_file_pernyataan]|max_size[_file_pernyataan,2048]|mime_in[_file_pernyataan,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Pernyataan terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Pernyataan terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValPernyataan);
        }

        $filenamelampiranFotoRumah = dot_array_search('_file_foto_rumah.name', $_FILES);
        if ($filenamelampiranFotoRumah != '') {
            $lampiranValFotoRumah = [
                '_file_foto_rumah' => [
                    'rules' => 'uploaded[_file_foto_rumah]|max_size[_file_foto_rumah,2048]|mime_in[_file_foto_rumah,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen foto rumah terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen foto rumah terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValFotoRumah);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nik')
                . $this->validator->getError('jenis')
                . $this->validator->getError('indikator1')
                . $this->validator->getError('indikator2')
                . $this->validator->getError('indikator3')
                . $this->validator->getError('indikator4')
                . $this->validator->getError('indikator5')
                . $this->validator->getError('indikator6')
                . $this->validator->getError('_file_ktp')
                . $this->validator->getError('_file_kk')
                . $this->validator->getError('_file_pernyataan')
                . $this->validator->getError('_file_foto_rumah');
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
            $indikator1 = (int)htmlspecialchars($this->request->getVar('indikator1'), true);
            $indikator2 = (int)htmlspecialchars($this->request->getVar('indikator2'), true);
            $indikator3 = (int)htmlspecialchars($this->request->getVar('indikator3'), true);
            $indikator4 = (int)htmlspecialchars($this->request->getVar('indikator4'), true);
            $indikator5 = (int)htmlspecialchars($this->request->getVar('indikator5'), true);
            $indikator6 = (int)htmlspecialchars($this->request->getVar('indikator6'), true);
            $keterangan = (int)htmlspecialchars($this->request->getVar('keterangan'), true);

            if ($keterangan === NULL || $keterangan === "") {
                $jenisFix = $jenis;
            } else {
                $jenisFix = $jenis;
            }

            $skor = (($indikator1 + $indikator2 + $indikator3 + $indikator4 + $indikator5 + $indikator6) / 16) * 100;
            $uuidLib = new Uuid();

            $kodeUsulan = "SKTM-" . $user->data->nik . '-' . time();

            $data = [
                'id' => $uuidLib->v4(),
                'kode_permohonan' => $kodeUsulan,
                'kelurahan' => $user->data->kelurahan,
                'ttd' => 'kakam',
                'nik' => $user->data->nik,
                'nama' => $user->data->fullname,
                'user_id' => $user->data->id,
                'jenis' => $jenisFix,
                'layanan' => "SKTM",
                'indikator1' => $indikator1,
                'indikator2' => $indikator2,
                'indikator3' => $indikator3,
                'indikator4' => $indikator4,
                'indikator5' => $indikator5,
                'indikator6' => $indikator6,
                'skor' => $skor,
                'status_permohonan' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/sktm";

            $lampiranKtp = $this->request->getFile('_file_ktp');
            $filesNamelampiranKtp = $lampiranKtp->getName();
            $newNamelampiranKtp = _create_name_foto($filesNamelampiranKtp);

            if ($lampiranKtp->isValid() && !$lampiranKtp->hasMoved()) {
                $lampiranKtp->move($dir, $newNamelampiranKtp);
                $data['lampiran_ktp'] = $newNamelampiranKtp;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload lampiran KTP.";
                return json_encode($response);
            }

            $lampiranKk = $this->request->getFile('_file_kk');
            $filesNamelampiranKk = $lampiranKk->getName();
            $newNamelampiranKk = _create_name_foto($filesNamelampiranKk);

            if ($lampiranKk->isValid() && !$lampiranKk->hasMoved()) {
                $lampiranKk->move($dir, $newNamelampiranKk);
                $data['lampiran_kk'] = $newNamelampiranKk;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload lampiran KK.";
                return json_encode($response);
            }

            $lampiranPernyataan = $this->request->getFile('_file_pernyataan');
            $filesNamelampiranPernyataan = $lampiranPernyataan->getName();
            $newNamelampiranPernyataan = _create_name_foto($filesNamelampiranPernyataan);

            if ($lampiranPernyataan->isValid() && !$lampiranPernyataan->hasMoved()) {
                $lampiranPernyataan->move($dir, $newNamelampiranPernyataan);
                $data['lampiran_pernyataan'] = $newNamelampiranPernyataan;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload lampiran Pernyataan.";
                return json_encode($response);
            }

            $lampiranFotoRumah = $this->request->getFile('_file_foto_rumah');
            $filesNamelampiranFotoRumah = $lampiranFotoRumah->getName();
            $newNamelampiranFotoRumah = _create_name_foto($filesNamelampiranFotoRumah);

            if ($lampiranFotoRumah->isValid() && !$lampiranFotoRumah->hasMoved()) {
                $lampiranFotoRumah->move($dir, $newNamelampiranFotoRumah);
                $data['lampiran_foto_rumah'] = $newNamelampiranFotoRumah;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload lampiran Foto Rumah.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_permohonan_temp')->insert($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiranKtp);
                unlink($dir . '/' . $newNamelampiranKk);
                unlink($dir . '/' . $newNamelampiranPernyataan);
                unlink($dir . '/' . $newNamelampiranFotoRumah);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan permohonan baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $riwayatLib = new Riwayatpermohonanlib();
                try {
                    $riwayatLib->create($user->data->id, "Mengirim permohonan dengan kode antrian: " . $data['kode_permohonan'], "submit", "bx bx-send", "riwayat/detailpermohonan?token=" . $data['id'], $data['id']);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permohonan Berhasil di Ajukan.";
                $response->redirect = base_url('silastri/peng/riwayat');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiranKtp);
                unlink($dir . '/' . $newNamelampiranKk);
                unlink($dir . '/' . $newNamelampiranPernyataan);
                unlink($dir . '/' . $newNamelampiranFotoRumah);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengajukan permohonan.";
                return json_encode($response);
            }
        }
    }
}
