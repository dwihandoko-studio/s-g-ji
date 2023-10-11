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
        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'asc')->get()->getResult();

        return view('silastri/peng/layanan/lks/add', $data);
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

    public function location()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $data['lat'] = htmlspecialchars($this->request->getVar('lat'), true) ?? "";
        $data['long'] = htmlspecialchars($this->request->getVar('long'), true) ?? "";

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('portal/pick-maps', $data);
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
            'nama_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama lembaga tidak boleh kosong. ',
                ]
            ],
            'jenis_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis lembaga tidak boleh kosong. ',
                ]
            ],
            'tgl_berdiri' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal berdiri tidak boleh kosong. ',
                ]
            ],
            'nama_notaris' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama notaris tidak boleh kosong. ',
                ]
            ],
            'no_tanggal_notaris' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No tanggal notaris tidak boleh kosong. ',
                ]
            ],
            'no_pendaftaran_kemenkumham' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No pendaftaran kemenkumham tidak boleh kosong. ',
                ]
            ],
            'akreditasi_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Akreditasi lembaga tidak boleh kosong. ',
                ]
            ],
            'no_surat_akreditasi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No surat akreditasi tidak boleh kosong. ',
                ]
            ],
            'tgl_habis_berlaku_akreditasi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal habis berlaku akreditasi tidak boleh kosong. ',
                ]
            ],
            'nomor_wajib_pajak' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Npwp Lembaga tidak boleh kosong. ',
                ]
            ],
            'modal_usaha' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Modal Usaha Lembaga tidak boleh kosong. ',
                ]
            ],
            'status_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Status Lembaga tidak boleh kosong. ',
                ]
            ],
            'lingkup_wilayah_kerja' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Lingkup Wilayah Kerja Lembaga tidak boleh kosong. ',
                ]
            ],
            'bidang_kegiatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bidang Kegiatan Lembaga tidak boleh kosong. ',
                ]
            ],
            'no_telp_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No telepon Lembaga tidak boleh kosong. ',
                ]
            ],
            'email_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Email Lembaga tidak boleh kosong. ',
                ]
            ],
            'alamat_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat Lembaga tidak boleh kosong. ',
                ]
            ],
            'rt_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat RT Lembaga tidak boleh kosong. ',
                ]
            ],
            'rw_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat RW Lembaga tidak boleh kosong. ',
                ]
            ],
            'kecamatan_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat Kecamatan Lembaga tidak boleh kosong. ',
                ]
            ],
            'kelurahan_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat Kelurahan Lembaga tidak boleh kosong. ',
                ]
            ],
            'nama_ketua' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama Ketua Lembaga tidak boleh kosong. ',
                ]
            ],
            'nik_ketua' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK Ketua Lembaga tidak boleh kosong. ',
                ]
            ],
            'nohp_ketua' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No Handphone Ketua Lembaga tidak boleh kosong. ',
                ]
            ],
            'nama_sekretaris' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama Sekretaris Lembaga tidak boleh kosong. ',
                ]
            ],
            'nik_sekretaris' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK Sekretaris Lembaga tidak boleh kosong. ',
                ]
            ],
            'nohp_sekretaris' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No Handphone Sekretaris Lembaga tidak boleh kosong. ',
                ]
            ],
            'nama_bendahara' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama Bendahara Lembaga tidak boleh kosong. ',
                ]
            ],
            'nik_bendahara' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIK Bendahara Lembaga tidak boleh kosong. ',
                ]
            ],
            'nohp_bendahara' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No Handphone Bendahara Lembaga tidak boleh kosong. ',
                ]
            ],
            'jumlah_pengurus' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jumlah Pengurus Lembaga tidak boleh kosong. ',
                ]
            ],
            'jumlah_binaan_dalam_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jumlah Binaan dalam Lembaga tidak boleh kosong. ',
                ]
            ],
            'jumlah_binaan_luar_lembaga' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jumlah Binaan Luar Lembaga tidak boleh kosong. ',
                ]
            ],
            'koordinat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Koordinat Alamat Lembaga tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiranKtpKetua = dot_array_search('_file_ktp_ketua.name', $_FILES);
        if ($filenamelampiranKtpKetua != '') {
            $lampiranValKtpKetua = [
                '_file_ktp_ketua' => [
                    'rules' => 'uploaded[_file_ktp_ketua]|max_size[_file_ktp_ketua,2048]|mime_in[_file_ktp_ketua,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen KTP Ketua terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen KTP Ketua terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKtpKetua);
        }

        $filenamelampiranKtpSekretaris = dot_array_search('_file_ktp_sekretaris.name', $_FILES);
        if ($filenamelampiranKtpSekretaris != '') {
            $lampiranValKtpSekretaris = [
                '_file_ktp_sekretaris' => [
                    'rules' => 'uploaded[_file_ktp_sekretaris]|max_size[_file_ktp_sekretaris,2048]|mime_in[_file_ktp_sekretaris,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen KTP Sekretaris terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen KTP Sekretaris terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKtpSekretaris);
        }

        $filenamelampiranKtpBendahara = dot_array_search('_file_ktp_bendahara.name', $_FILES);
        if ($filenamelampiranKtpBendahara != '') {
            $lampiranValKtpBendahara = [
                '_file_ktp_bendahara' => [
                    'rules' => 'uploaded[_file_ktp_bendahara]|max_size[_file_ktp_bendahara,2048]|mime_in[_file_ktp_bendahara,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen KTP Bendahara terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen KTP Bendahara terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKtpBendahara);
        }

        $filenamelampiranAktaNotaris = dot_array_search('_file_akta_notaris.name', $_FILES);
        if ($filenamelampiranAktaNotaris != '') {
            $lampiranValAktaNotaris = [
                '_file_akta_notaris' => [
                    'rules' => 'uploaded[_file_akta_notaris]|max_size[_file_akta_notaris,2048]|mime_in[_file_akta_notaris,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Akta Notaris terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Akta Notaris terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValAktaNotaris);
        }

        $filenamelampiranPengesahanKemenkumham = dot_array_search('_file_pengesahan_kemenkumham.name', $_FILES);
        if ($filenamelampiranPengesahanKemenkumham != '') {
            $lampiranValPengesahanKemenkumham = [
                '_file_pengesahan_kemenkumham' => [
                    'rules' => 'uploaded[_file_pengesahan_kemenkumham]|max_size[_file_pengesahan_kemenkumham,2048]|mime_in[_file_pengesahan_kemenkumham,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Pengesahan Kemenkumham terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Pengesahan Kemenkumham terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValPengesahanKemenkumham);
        }

        $filenamelampiranAdrt = dot_array_search('_file_adrt.name', $_FILES);
        if ($filenamelampiranAdrt != '') {
            $lampiranValAdrt = [
                '_file_adrt' => [
                    'rules' => 'uploaded[_file_adrt]|max_size[_file_adrt,2048]|mime_in[_file_adrt,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen ADRT terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen ADRT terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValAdrt);
        }

        $filenamelampiranKeteranganDomisili = dot_array_search('_file_keterangan_domisili.name', $_FILES);
        if ($filenamelampiranKeteranganDomisili != '') {
            $lampiranValKeteranganDomisili = [
                '_file_keterangan_domisili' => [
                    'rules' => 'uploaded[_file_keterangan_domisili]|max_size[_file_keterangan_domisili,2048]|mime_in[_file_keterangan_domisili,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Keterangan Domisili terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Keterangan Domisili terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValKeteranganDomisili);
        }

        $filenamelampiranAkreditasi = dot_array_search('_file_akreditasi.name', $_FILES);
        if ($filenamelampiranAkreditasi != '') {
            $lampiranValAkreditasi = [
                '_file_akreditasi' => [
                    'rules' => 'uploaded[_file_akreditasi]|max_size[_file_akreditasi,2048]|mime_in[_file_akreditasi,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Akreditasi terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Akreditasi terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValAkreditasi);
        }

        $filenamelampiranStrukturOrganisasi = dot_array_search('_file_struktur_organisasi.name', $_FILES);
        if ($filenamelampiranStrukturOrganisasi != '') {
            $lampiranValStrukturOrganisasi = [
                '_file_struktur_organisasi' => [
                    'rules' => 'uploaded[_file_struktur_organisasi]|max_size[_file_struktur_organisasi,2048]|mime_in[_file_struktur_organisasi,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Struktur Organisasi terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Struktur Organisasi terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValStrukturOrganisasi);
        }

        $filenamelampiranNpwp = dot_array_search('_file_npwp.name', $_FILES);
        if ($filenamelampiranNpwp != '') {
            $lampiranValNpwp = [
                '_file_npwp' => [
                    'rules' => 'uploaded[_file_npwp]|max_size[_file_npwp,2048]|mime_in[_file_npwp,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen NPWP terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen NPWP terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValNpwp);
        }

        $filenamelampiranFotoLokasi = dot_array_search('_file_foto_lokasi.name', $_FILES);
        if ($filenamelampiranFotoLokasi != '') {
            $lampiranValFotoLokasi = [
                '_file_foto_lokasi' => [
                    'rules' => 'uploaded[_file_foto_lokasi]|max_size[_file_foto_lokasi,2048]|mime_in[_file_foto_lokasi,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Foto Lokasi terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Foto Lokasi terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValFotoLokasi);
        }

        $filenamelampiranFotoUsahaEkonomiProduktif = dot_array_search('_file_foto_usaha_ekonomi_produktif.name', $_FILES);
        if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
            $lampiranValFotoUsahaEkonomiProduktif = [
                '_file_foto_usaha_ekonomi_produktif' => [
                    'rules' => 'uploaded[_file_foto_usaha_ekonomi_produktif]|max_size[_file_foto_usaha_ekonomi_produktif,2048]|mime_in[_file_foto_usaha_ekonomi_produktif,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Foto Usaha Ekonomi Produktif terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Foto Usaha Ekonomi Produktif terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValFotoUsahaEkonomiProduktif);
        }

        $filenamelampiranLogoLembaga = dot_array_search('_file_logo_lembaga.name', $_FILES);
        if ($filenamelampiranLogoLembaga != '') {
            $lampiranValLogoLembaga = [
                '_file_logo_lembaga' => [
                    'rules' => 'uploaded[_file_logo_lembaga]|max_size[_file_logo_lembaga,2048]|mime_in[_file_logo_lembaga,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih dokumen Logo Lembaga terlebih dahulu. ',
                        'max_size' => 'Ukuran dokumen Logo Lembaga terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValLogoLembaga);
        }

        $filenamelampiranDataBinaan = dot_array_search('_file_data_binaan.name', $_FILES);
        if ($filenamelampiranDataBinaan != '') {
            $lampiranValDataBinaan = [
                '_file_data_binaan' => [
                    'rules' => 'uploaded[_file_data_binaan]|max_size[_file_data_binaan,2048]|mime_in[_file_data_binaan,application/vnd.ms-excel,application/msexcel,application/x-msexcel,application/x-ms-excel,application/x-excel,application/x-dos_ms_excel,application/xls,application/x-xls,application/excel,application/download,application/vnd.ms-office,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip]',
                    'errors' => [
                        'uploaded' => 'Pilih Data Binaan Lembaga terlebih dahulu. ',
                        'max_size' => 'Ukuran Data Binaan Lembaga terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi xls atau xlsx. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranValDataBinaan);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nik')
                . $this->validator->getError('nama_lembaga')
                . $this->validator->getError('jenis_lembaga')
                . $this->validator->getError('tgl_berdiri')
                . $this->validator->getError('nama_notaris')
                . $this->validator->getError('no_tanggal_notaris')
                . $this->validator->getError('no_pendaftaran_kemenkumham')
                . $this->validator->getError('akreditasi_lembaga')
                . $this->validator->getError('no_surat_akreditasi')
                . $this->validator->getError('tgl_habis_berlaku_akreditasi')
                . $this->validator->getError('nomor_wajib_pajak')
                . $this->validator->getError('modal_usaha')
                . $this->validator->getError('status_lembaga')
                . $this->validator->getError('lingkup_wilayah_kerja')
                . $this->validator->getError('bidang_kegiatan')
                . $this->validator->getError('no_telp_lembaga')
                . $this->validator->getError('email_lembaga')
                . $this->validator->getError('alamat_lembaga')
                . $this->validator->getError('rt_lembaga')
                . $this->validator->getError('rw_lembaga')
                . $this->validator->getError('kecamatan_lembaga')
                . $this->validator->getError('kelurahan_lembaga')
                . $this->validator->getError('nama_ketua')
                . $this->validator->getError('nik_ketua')
                . $this->validator->getError('nohp_ketua')
                . $this->validator->getError('nama_sekretaris')
                . $this->validator->getError('nik_sekretaris')
                . $this->validator->getError('nohp_sekretaris')
                . $this->validator->getError('nama_bendahara')
                . $this->validator->getError('nik_bendahara')
                . $this->validator->getError('nohp_bendahara')
                . $this->validator->getError('jumlah_pengurus')
                . $this->validator->getError('jumlah_binaan_dalam_lembaga')
                . $this->validator->getError('jumlah_binaan_luar_lembaga')
                . $this->validator->getError('koordinat')
                . $this->validator->getError('_file_ktp_ketua')
                . $this->validator->getError('_file_ktp_sekretaris')
                . $this->validator->getError('_file_ktp_bendahara')
                . $this->validator->getError('_file_akta_notaris')
                . $this->validator->getError('_file_pengesahan_kemenkumham')
                . $this->validator->getError('_file_adrt')
                . $this->validator->getError('_file_keterangan_domisili')
                . $this->validator->getError('_file_akreditasi')
                . $this->validator->getError('_file_struktur_organisasi')
                . $this->validator->getError('_file_npwp')
                . $this->validator->getError('_file_foto_lokasi')
                . $this->validator->getError('_file_foto_usaha_ekonomi_produktif')
                . $this->validator->getError('_file_logo_lembaga')
                . $this->validator->getError('_file_data_binaan');
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

            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $nama_lembaga = htmlspecialchars($this->request->getVar('nama_lembaga'), true);
            $jenis_lembaga = htmlspecialchars($this->request->getVar('jenis_lembaga'), true);
            $tgl_berdiri = htmlspecialchars($this->request->getVar('tgl_berdiri'), true);
            $nama_notaris = htmlspecialchars($this->request->getVar('nama_notaris'), true);
            $no_tanggal_notaris = htmlspecialchars($this->request->getVar('no_tanggal_notaris'), true);
            $no_pendaftaran_kemenkumham = htmlspecialchars($this->request->getVar('no_pendaftaran_kemenkumham'), true);
            $akreditasi_lembaga = htmlspecialchars($this->request->getVar('akreditasi_lembaga'), true);
            $no_surat_akreditasi = htmlspecialchars($this->request->getVar('no_surat_akreditasi'), true);
            $tgl_habis_berlaku_akreditasi = htmlspecialchars($this->request->getVar('tgl_habis_berlaku_akreditasi'), true);
            $nomor_wajib_pajak = htmlspecialchars($this->request->getVar('nomor_wajib_pajak'), true);
            $modal_usaha = htmlspecialchars($this->request->getVar('modal_usaha'), true);
            $status_lembaga = htmlspecialchars($this->request->getVar('status_lembaga'), true);
            $lingkup_wilayah_kerja = htmlspecialchars($this->request->getVar('lingkup_wilayah_kerja'), true);
            $bidang_kegiatan = htmlspecialchars($this->request->getVar('bidang_kegiatan'), true);
            $no_telp_lembaga = htmlspecialchars($this->request->getVar('no_telp_lembaga'), true);
            $email_lembaga = htmlspecialchars($this->request->getVar('email_lembaga'), true);
            $alamat_lembaga = htmlspecialchars($this->request->getVar('alamat_lembaga'), true);
            $rt_lembaga = htmlspecialchars($this->request->getVar('rt_lembaga'), true);
            $rw_lembaga = htmlspecialchars($this->request->getVar('rw_lembaga'), true);
            $kecamatan_lembaga = htmlspecialchars($this->request->getVar('kecamatan_lembaga'), true);
            $kelurahan_lembaga = htmlspecialchars($this->request->getVar('kelurahan_lembaga'), true);
            $nama_ketua = htmlspecialchars($this->request->getVar('nama_ketua'), true);
            $nik_ketua = htmlspecialchars($this->request->getVar('nik_ketua'), true);
            $nohp_ketua = htmlspecialchars($this->request->getVar('nohp_ketua'), true);
            $nama_sekretaris = htmlspecialchars($this->request->getVar('nama_sekretaris'), true);
            $nik_sekretaris = htmlspecialchars($this->request->getVar('nik_sekretaris'), true);
            $nohp_sekretaris = htmlspecialchars($this->request->getVar('nohp_sekretaris'), true);
            $nama_bendahara = htmlspecialchars($this->request->getVar('nama_bendahara'), true);
            $nik_bendahara = htmlspecialchars($this->request->getVar('nik_bendahara'), true);
            $nohp_bendahara = htmlspecialchars($this->request->getVar('nohp_bendahara'), true);
            $jumlah_pengurus = htmlspecialchars($this->request->getVar('jumlah_pengurus'), true);
            $jumlah_binaan_dalam_lembaga = htmlspecialchars($this->request->getVar('jumlah_binaan_dalam_lembaga'), true);
            $jumlah_binaan_luar_lembaga = htmlspecialchars($this->request->getVar('jumlah_binaan_luar_lembaga'), true);
            $koordinat = htmlspecialchars($this->request->getVar('koordinat'), true);

            $uuidLib = new Uuid();

            $kodeUsulan = "LKS-" . $user->data->nik . '-' . time();

            $data = [
                'id' => $uuidLib->v4(),
                'kode_permohonan' => $kodeUsulan,
                'kelurahan' => $user->data->kelurahan,
                'ttd' => 'kadis',
                'nik' => $user->data->nik,
                'nama' => $user->data->fullname,
                'user_id' => $user->data->id,
                'jenis' => "Rekomendasi LKS/LKSA",
                'layanan' => "LKS",
                'status_permohonan' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dataLks = [
                'id_permohonan' => $data['id'],
                'nama_lembaga' => $nama_lembaga,
                'jenis_lembaga' => $jenis_lembaga,
                'tgl_berdiri_lembaga' => $tgl_berdiri,
                'nama_notaris_lembaga' => $nama_notaris,
                'nomor_notaris_lembaga' => $no_tanggal_notaris,
                'nomor_kemenkumham_lembaga' => $no_pendaftaran_kemenkumham,
                'akreditasi_lembaga' => $akreditasi_lembaga,
                'nomor_surat_akreditasi_lembaga' => $no_surat_akreditasi,
                'tgl_expired_akreditasi_lembaga' => $tgl_habis_berlaku_akreditasi,
                'npwp_lembaga' => $nomor_wajib_pajak,
                'modal_usaha_lembaga' => $modal_usaha,
                'status_lembaga' => $status_lembaga,
                'lingkup_wilayah_kerja_lembaga' => $lingkup_wilayah_kerja,
                'bidang_kegiatan_lembaga' => $bidang_kegiatan,
                'no_telp_lembaga' => $no_telp_lembaga,
                'email_lembaga' => $email_lembaga,
                'lat_long_lembaga' => $koordinat,
                'alamat_lembaga' => $alamat_lembaga,
                'rt_lembaga' => $rt_lembaga,
                'rw_lembaga' => $rw_lembaga,
                'kecamatan_lembaga' => $kecamatan_lembaga,
                'kelurahan_lembaga' => $kelurahan_lembaga,
                'nama_ketua_pengurus' => $nama_ketua,
                'nik_ketua_pengurus' => $nik_ketua,
                'nohp_ketua_pengurus' => $nohp_ketua,
                'nama_sekretaris_pengurus' => $nama_sekretaris,
                'nik_sekretaris_pengurus' => $nik_sekretaris,
                'nohp_sekretaris_pengurus' => $nohp_sekretaris,
                'nama_bendahara_pengurus' => $nama_bendahara,
                'nik_bendahara_pengurus' => $nik_bendahara,
                'nohp_bendahara_pengurus' => $nohp_bendahara,
                'jumlah_pengurus' => $jumlah_pengurus,
                'jumlah_binaan_dalam' => $jumlah_binaan_dalam_lembaga,
                'jumlah_binaan_luar' => $jumlah_binaan_luar_lembaga,
                'created_at' => $data['created_at']
            ];

            $dir = FCPATH . "uploads/lks";

            if ($filenamelampiranKtpKetua != '') {
                $lampiranKtpKetua = $this->request->getFile('_file_ktp_ketua');
                $filesNamelampiranKtpKetua = $lampiranKtpKetua->getName();
                $newNamelampiranKtpKetua = _create_name_foto($filesNamelampiranKtpKetua);

                if ($lampiranKtpKetua->isValid() && !$lampiranKtpKetua->hasMoved()) {
                    $lampiranKtpKetua->move($dir, $newNamelampiranKtpKetua);
                    $dataLks['lampiran_ktp_ketua'] = $newNamelampiranKtpKetua;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran KTP Ketua.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranKtpSekretaris != '') {
                $lampiranKtpSekretaris = $this->request->getFile('_file_ktp_sekretaris');
                $filesNamelampiranKtpSekretaris = $lampiranKtpSekretaris->getName();
                $newNamelampiranKtpSekretaris = _create_name_foto($filesNamelampiranKtpSekretaris);

                if ($lampiranKtpSekretaris->isValid() && !$lampiranKtpSekretaris->hasMoved()) {
                    $lampiranKtpSekretaris->move($dir, $newNamelampiranKtpSekretaris);
                    $dataLks['lampiran_ktp_sekretaris'] = $newNamelampiranKtpSekretaris;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran KTP Sekretaris.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranKtpBendahara != '') {
                $lampiranKtpBendahara = $this->request->getFile('_file_ktp_bendahara');
                $filesNamelampiranKtpBendahara = $lampiranKtpBendahara->getName();
                $newNamelampiranKtpBendahara = _create_name_foto($filesNamelampiranKtpBendahara);

                if ($lampiranKtpBendahara->isValid() && !$lampiranKtpBendahara->hasMoved()) {
                    $lampiranKtpBendahara->move($dir, $newNamelampiranKtpBendahara);
                    $dataLks['lampiran_ktp_bendahara'] = $newNamelampiranKtpBendahara;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran KTP Bendahara.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranAktaNotaris != '') {
                $lampiranAktaNotaris = $this->request->getFile('_file_akta_notaris');
                $filesNamelampiranAktaNotaris = $lampiranAktaNotaris->getName();
                $newNamelampiranAktaNotaris = _create_name_foto($filesNamelampiranAktaNotaris);

                if ($lampiranAktaNotaris->isValid() && !$lampiranAktaNotaris->hasMoved()) {
                    $lampiranAktaNotaris->move($dir, $newNamelampiranAktaNotaris);
                    $dataLks['lampiran_akta_notaris'] = $newNamelampiranAktaNotaris;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Akta Notaris.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranPengesahanKemenkumham != '') {
                $lampiranPengesahanKemenkumham = $this->request->getFile('_file_pengesahan_kemenkumham');
                $filesNamelampiranPengesahanKemenkumham = $lampiranPengesahanKemenkumham->getName();
                $newNamelampiranPengesahanKemenkumham = _create_name_foto($filesNamelampiranPengesahanKemenkumham);

                if ($lampiranPengesahanKemenkumham->isValid() && !$lampiranPengesahanKemenkumham->hasMoved()) {
                    $lampiranPengesahanKemenkumham->move($dir, $newNamelampiranPengesahanKemenkumham);
                    $dataLks['lampiran_kemenkumham'] = $newNamelampiranPengesahanKemenkumham;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Pengesahan Kemenkumham.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranAdrt != '') {
                $lampiranAdrt = $this->request->getFile('_file_adrt');
                $filesNamelampiranAdrt = $lampiranAdrt->getName();
                $newNamelampiranAdrt = _create_name_foto($filesNamelampiranAdrt);

                if ($lampiranAdrt->isValid() && !$lampiranAdrt->hasMoved()) {
                    $lampiranAdrt->move($dir, $newNamelampiranAdrt);
                    $dataLks['lampiran_adrt'] = $newNamelampiranAdrt;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran ADRT.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranKeteranganDomisili != '') {
                $lampiranKeteranganDomisili = $this->request->getFile('_file_keterangan_domisili');
                $filesNamelampiranKeteranganDomisili = $lampiranKeteranganDomisili->getName();
                $newNamelampiranKeteranganDomisili = _create_name_foto($filesNamelampiranKeteranganDomisili);

                if ($lampiranKeteranganDomisili->isValid() && !$lampiranKeteranganDomisili->hasMoved()) {
                    $lampiranKeteranganDomisili->move($dir, $newNamelampiranKeteranganDomisili);
                    $dataLks['lampiran_domisili'] = $newNamelampiranKeteranganDomisili;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Keterangan Domisili.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranAkreditasi != '') {
                $lampiranAkreditasi = $this->request->getFile('_file_akreditasi');
                $filesNamelampiranAkreditasi = $lampiranAkreditasi->getName();
                $newNamelampiranAkreditasi = _create_name_foto($filesNamelampiranAkreditasi);

                if ($lampiranAkreditasi->isValid() && !$lampiranAkreditasi->hasMoved()) {
                    $lampiranAkreditasi->move($dir, $newNamelampiranAkreditasi);
                    $dataLks['lampiran_akreditasi'] = $newNamelampiranAkreditasi;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Akreditasi.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranStrukturOrganisasi != '') {
                $lampiranStrukturOrganisasi = $this->request->getFile('_file_struktur_organisasi');
                $filesNamelampiranStrukturOrganisasi = $lampiranStrukturOrganisasi->getName();
                $newNamelampiranStrukturOrganisasi = _create_name_foto($filesNamelampiranStrukturOrganisasi);

                if ($lampiranStrukturOrganisasi->isValid() && !$lampiranStrukturOrganisasi->hasMoved()) {
                    $lampiranStrukturOrganisasi->move($dir, $newNamelampiranStrukturOrganisasi);
                    $dataLks['lampiran_struktur_organisasi'] = $newNamelampiranStrukturOrganisasi;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Struktur Organisasi.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranNpwp != '') {
                $lampiranNpwp = $this->request->getFile('_file_npwp');
                $filesNamelampiranNpwp = $lampiranNpwp->getName();
                $newNamelampiranNpwp = _create_name_foto($filesNamelampiranNpwp);

                if ($lampiranNpwp->isValid() && !$lampiranNpwp->hasMoved()) {
                    $lampiranNpwp->move($dir, $newNamelampiranNpwp);
                    $dataLks['lampiran_npwp'] = $newNamelampiranNpwp;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran NPWP.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranFotoLokasi != '') {
                $lampiranFotoLokasi = $this->request->getFile('_file_foto_lokasi');
                $filesNamelampiranFotoLokasi = $lampiranFotoLokasi->getName();
                $newNamelampiranFotoLokasi = _create_name_foto($filesNamelampiranFotoLokasi);

                if ($lampiranFotoLokasi->isValid() && !$lampiranFotoLokasi->hasMoved()) {
                    $lampiranFotoLokasi->move($dir, $newNamelampiranFotoLokasi);
                    $dataLks['lampiran_foto_lokasi'] = $newNamelampiranFotoLokasi;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Foto Lokasi.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
                $lampiranFotoUsahaEkonomiProduktif = $this->request->getFile('_file_foto_usaha_ekonomi_produktif');
                $filesNamelampiranFotoUsahaEkonomiProduktif = $lampiranFotoUsahaEkonomiProduktif->getName();
                $newNamelampiranFotoUsahaEkonomiProduktif = _create_name_foto($filesNamelampiranFotoUsahaEkonomiProduktif);

                if ($lampiranFotoUsahaEkonomiProduktif->isValid() && !$lampiranFotoUsahaEkonomiProduktif->hasMoved()) {
                    $lampiranFotoUsahaEkonomiProduktif->move($dir, $newNamelampiranFotoUsahaEkonomiProduktif);
                    $dataLks['lampiran_foto_usaha'] = $newNamelampiranFotoUsahaEkonomiProduktif;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Foto Usaha Ekonomi Produktif.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranLogoLembaga != '') {
                $lampiranLogoLembaga = $this->request->getFile('_file_logo_lembaga');
                $filesNamelampiranLogoLembaga = $lampiranLogoLembaga->getName();
                $newNamelampiranLogoLembaga = _create_name_foto($filesNamelampiranLogoLembaga);

                if ($lampiranLogoLembaga->isValid() && !$lampiranLogoLembaga->hasMoved()) {
                    $lampiranLogoLembaga->move($dir, $newNamelampiranLogoLembaga);
                    $dataLks['lampiran_logo'] = $newNamelampiranLogoLembaga;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Logo Lembaga.";
                    return json_encode($response);
                }
            }

            if ($filenamelampiranDataBinaan != '') {
                $lampiranDataBinaan = $this->request->getFile('_file_data_binaan');
                $filesNamelampiranDataBinaan = $lampiranDataBinaan->getName();
                $newNamelampiranDataBinaan = _create_name_excel($filesNamelampiranDataBinaan);

                if ($lampiranDataBinaan->isValid() && !$lampiranDataBinaan->hasMoved()) {
                    $lampiranDataBinaan->move($dir, $newNamelampiranDataBinaan);
                    $dataLks['lampiran_data_binaan'] = $newNamelampiranDataBinaan;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran Data Binaan Lembaga.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_permohonan_temp')->insert($data);
            } catch (\Exception $e) {
                if ($filenamelampiranKtpKetua != '') {
                    unlink($dir . '/' . $newNamelampiranKtpKetua);
                }
                if ($filenamelampiranKtpSekretaris != '') {
                    unlink($dir . '/' . $newNamelampiranKtpSekretaris);
                }
                if ($filenamelampiranKtpBendahara != '') {
                    unlink($dir . '/' . $newNamelampiranKtpBendahara);
                }
                if ($filenamelampiranAktaNotaris != '') {
                    unlink($dir . '/' . $newNamelampiranAktaNotaris);
                }
                if ($filenamelampiranPengesahanKemenkumham != '') {
                    unlink($dir . '/' . $newNamelampiranPengesahanKemenkumham);
                }
                if ($filenamelampiranAdrt != '') {
                    unlink($dir . '/' . $newNamelampiranAdrt);
                }
                if ($filenamelampiranKeteranganDomisili != '') {
                    unlink($dir . '/' . $newNamelampiranKeteranganDomisili);
                }
                if ($filenamelampiranAkreditasi != '') {
                    unlink($dir . '/' . $newNamelampiranAkreditasi);
                }
                if ($filenamelampiranStrukturOrganisasi != '') {
                    unlink($dir . '/' . $newNamelampiranStrukturOrganisasi);
                }
                if ($filenamelampiranNpwp != '') {
                    unlink($dir . '/' . $newNamelampiranNpwp);
                }
                if ($filenamelampiranFotoLokasi != '') {
                    unlink($dir . '/' . $newNamelampiranFotoLokasi);
                }
                if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
                    unlink($dir . '/' . $newNamelampiranFotoUsahaEkonomiProduktif);
                }
                if ($filenamelampiranLogoLembaga != '') {
                    unlink($dir . '/' . $newNamelampiranLogoLembaga);
                }
                if ($filenamelampiranDataBinaan != '') {
                    unlink($dir . '/' . $newNamelampiranDataBinaan);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan permohonan baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                try {
                    $this->_db->table('_permohonan_lksa')->insert($dataLks);
                } catch (\Exception $e) {
                    if ($filenamelampiranKtpKetua != '') {
                        unlink($dir . '/' . $newNamelampiranKtpKetua);
                    }
                    if ($filenamelampiranKtpSekretaris != '') {
                        unlink($dir . '/' . $newNamelampiranKtpSekretaris);
                    }
                    if ($filenamelampiranKtpBendahara != '') {
                        unlink($dir . '/' . $newNamelampiranKtpBendahara);
                    }
                    if ($filenamelampiranAktaNotaris != '') {
                        unlink($dir . '/' . $newNamelampiranAktaNotaris);
                    }
                    if ($filenamelampiranPengesahanKemenkumham != '') {
                        unlink($dir . '/' . $newNamelampiranPengesahanKemenkumham);
                    }
                    if ($filenamelampiranAdrt != '') {
                        unlink($dir . '/' . $newNamelampiranAdrt);
                    }
                    if ($filenamelampiranKeteranganDomisili != '') {
                        unlink($dir . '/' . $newNamelampiranKeteranganDomisili);
                    }
                    if ($filenamelampiranAkreditasi != '') {
                        unlink($dir . '/' . $newNamelampiranAkreditasi);
                    }
                    if ($filenamelampiranStrukturOrganisasi != '') {
                        unlink($dir . '/' . $newNamelampiranStrukturOrganisasi);
                    }
                    if ($filenamelampiranNpwp != '') {
                        unlink($dir . '/' . $newNamelampiranNpwp);
                    }
                    if ($filenamelampiranFotoLokasi != '') {
                        unlink($dir . '/' . $newNamelampiranFotoLokasi);
                    }
                    if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
                        unlink($dir . '/' . $newNamelampiranFotoUsahaEkonomiProduktif);
                    }
                    if ($filenamelampiranLogoLembaga != '') {
                        unlink($dir . '/' . $newNamelampiranLogoLembaga);
                    }
                    if ($filenamelampiranDataBinaan != '') {
                        unlink($dir . '/' . $newNamelampiranDataBinaan);
                    }
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan permohonan baru lksa.";
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
                    if ($filenamelampiranKtpKetua != '') {
                        unlink($dir . '/' . $newNamelampiranKtpKetua);
                    }
                    if ($filenamelampiranKtpSekretaris != '') {
                        unlink($dir . '/' . $newNamelampiranKtpSekretaris);
                    }
                    if ($filenamelampiranKtpBendahara != '') {
                        unlink($dir . '/' . $newNamelampiranKtpBendahara);
                    }
                    if ($filenamelampiranAktaNotaris != '') {
                        unlink($dir . '/' . $newNamelampiranAktaNotaris);
                    }
                    if ($filenamelampiranPengesahanKemenkumham != '') {
                        unlink($dir . '/' . $newNamelampiranPengesahanKemenkumham);
                    }
                    if ($filenamelampiranAdrt != '') {
                        unlink($dir . '/' . $newNamelampiranAdrt);
                    }
                    if ($filenamelampiranKeteranganDomisili != '') {
                        unlink($dir . '/' . $newNamelampiranKeteranganDomisili);
                    }
                    if ($filenamelampiranAkreditasi != '') {
                        unlink($dir . '/' . $newNamelampiranAkreditasi);
                    }
                    if ($filenamelampiranStrukturOrganisasi != '') {
                        unlink($dir . '/' . $newNamelampiranStrukturOrganisasi);
                    }
                    if ($filenamelampiranNpwp != '') {
                        unlink($dir . '/' . $newNamelampiranNpwp);
                    }
                    if ($filenamelampiranFotoLokasi != '') {
                        unlink($dir . '/' . $newNamelampiranFotoLokasi);
                    }
                    if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
                        unlink($dir . '/' . $newNamelampiranFotoUsahaEkonomiProduktif);
                    }
                    if ($filenamelampiranLogoLembaga != '') {
                        unlink($dir . '/' . $newNamelampiranLogoLembaga);
                    }
                    if ($filenamelampiranDataBinaan != '') {
                        unlink($dir . '/' . $newNamelampiranDataBinaan);
                    }
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengajukan permohonan lksa.";
                    return json_encode($response);
                }
            } else {
                if ($filenamelampiranKtpKetua != '') {
                    unlink($dir . '/' . $newNamelampiranKtpKetua);
                }
                if ($filenamelampiranKtpSekretaris != '') {
                    unlink($dir . '/' . $newNamelampiranKtpSekretaris);
                }
                if ($filenamelampiranKtpBendahara != '') {
                    unlink($dir . '/' . $newNamelampiranKtpBendahara);
                }
                if ($filenamelampiranAktaNotaris != '') {
                    unlink($dir . '/' . $newNamelampiranAktaNotaris);
                }
                if ($filenamelampiranPengesahanKemenkumham != '') {
                    unlink($dir . '/' . $newNamelampiranPengesahanKemenkumham);
                }
                if ($filenamelampiranAdrt != '') {
                    unlink($dir . '/' . $newNamelampiranAdrt);
                }
                if ($filenamelampiranKeteranganDomisili != '') {
                    unlink($dir . '/' . $newNamelampiranKeteranganDomisili);
                }
                if ($filenamelampiranAkreditasi != '') {
                    unlink($dir . '/' . $newNamelampiranAkreditasi);
                }
                if ($filenamelampiranStrukturOrganisasi != '') {
                    unlink($dir . '/' . $newNamelampiranStrukturOrganisasi);
                }
                if ($filenamelampiranNpwp != '') {
                    unlink($dir . '/' . $newNamelampiranNpwp);
                }
                if ($filenamelampiranFotoLokasi != '') {
                    unlink($dir . '/' . $newNamelampiranFotoLokasi);
                }
                if ($filenamelampiranFotoUsahaEkonomiProduktif != '') {
                    unlink($dir . '/' . $newNamelampiranFotoUsahaEkonomiProduktif);
                }
                if ($filenamelampiranLogoLembaga != '') {
                    unlink($dir . '/' . $newNamelampiranLogoLembaga);
                }
                if ($filenamelampiranDataBinaan != '') {
                    unlink($dir . '/' . $newNamelampiranDataBinaan);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengajukan permohonan.";
                return json_encode($response);
            }
        }
    }
}
