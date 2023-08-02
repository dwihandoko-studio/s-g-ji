<?php

namespace App\Controllers\Silastri\Peng;

use App\Controllers\BaseController;
use App\Models\Silastri\Peng\PengaduanModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;
use App\Libraries\Silastri\Riwayatpengaduanlib;

class Pengaduan extends BaseController
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
        $datamodel = new PengaduanModel($request);

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $lists = $datamodel->get_datatables($user->data->id);
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
            "recordsTotal" => $datamodel->count_all($user->data->id),
            "recordsFiltered" => $datamodel->count_filtered($user->data->id),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('silastri/peng/pengaduan/data'));
    }

    public function data()
    {
        $data['title'] = 'Layanan Pengaduan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        // $data['jeniss'] = ['Surat Keterangan DTKS untuk Pengajuan PIP', 'Surat Keterangan DTKS untuk Pendaftaran PPDB', 'Surat Keterangan DTKS untuk Pengajuan PLN', 'Lainnya'];

        return view('silastri/peng/pengaduan/index', $data);
    }

    public function add()
    {
        $data['title'] = 'Layanan Pengaduan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['data'] = $user->data;

        $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'asc')->get()->getResult();

        $data['jeniss'] = ['Pengaduan Program Bantuan Sosial', 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)', 'Pengaduan Layanan Sosial', 'Lainnya'];

        return view('silastri/peng/pengaduan/add', $data);
    }

    public function detail()
    {
        if ($this->request->getMethod() != 'get') {
            return view('404', ['error' => "Akses tidak diizinkan."]);
        }

        $data['title'] = 'Detail Layanan Pengaduan';
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
            ->where(['a.id' => $id, 'a.status_permohonan' => 5])->get()->getRowObject();

        if ($current) {
            $data['data'] = $current;
            return view('silastri/peng/pengaduan/detail', $data);
        } else {
            return view('404', ['error' => "Data tidak ditemukan."]);
        }
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
                    'required' => 'Nama pemohon tidak boleh kosong. ',
                ]
            ],
            'nik' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nik pemohon tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nohp pemohon tidak boleh kosong. ',
                ]
            ],
            'alamat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat pemohon tidak boleh kosong. ',
                ]
            ],
            'kecamatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kecamatan pemohon tidak boleh kosong. ',
                ]
            ],
            'kelurahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kelurahan pemohon tidak boleh kosong. ',
                ]
            ],
            'nama_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama yang diadukan tidak boleh kosong. ',
                ]
            ],
            'nik_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nik yang diadukan tidak boleh kosong. ',
                ]
            ],
            'nohp_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nohp yang diadukan tidak boleh kosong. ',
                ]
            ],
            'alamat_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat yang diadukan tidak boleh kosong. ',
                ]
            ],
            'kecamatan_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kecamatan yang diadukan tidak boleh kosong. ',
                ]
            ],
            'kelurahan_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kelurahan yang diadukan tidak boleh kosong. ',
                ]
            ],
            'kategori' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori pengaduan tidak boleh kosong. ',
                ]
            ],
            'identitas_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Identitas aduan tidak boleh kosong. ',
                ]
            ],
            'uraian_aduan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Uraian aduan tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                    'errors' => [
                        'uploaded' => 'Pilih lampiran dokumen pengaduan terlebih dahulu. ',
                        'max_size' => 'Ukuran lampiran dokumen pengaduan terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nik')
                . $this->validator->getError('nohp')
                . $this->validator->getError('alamat')
                . $this->validator->getError('kecamatan')
                . $this->validator->getError('kelurahan')
                . $this->validator->getError('nama_aduan')
                . $this->validator->getError('nik_aduan')
                . $this->validator->getError('nohp_aduan')
                . $this->validator->getError('alamat_aduan')
                . $this->validator->getError('kecamatan_aduan')
                . $this->validator->getError('kelurahan_aduan')
                . $this->validator->getError('kategori')
                . $this->validator->getError('identitas_aduan')
                . $this->validator->getError('uraian_aduan')
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

            $kategori = htmlspecialchars($this->request->getVar('kategori'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $alamat = htmlspecialchars($this->request->getVar('alamat'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);
            $kelurahan = htmlspecialchars($this->request->getVar('kelurahan'), true);
            $nama_aduan = htmlspecialchars($this->request->getVar('nama_aduan'), true);
            $nik_aduan = htmlspecialchars($this->request->getVar('nik_aduan'), true);
            $nohp_aduan = htmlspecialchars($this->request->getVar('nohp_aduan'), true);
            $alamat_aduan = htmlspecialchars($this->request->getVar('alamat_aduan'), true);
            $kecamatan_aduan = htmlspecialchars($this->request->getVar('kecamatan_aduan'), true);
            $kelurahan_aduan = htmlspecialchars($this->request->getVar('kelurahan_aduan'), true);
            $identitas_aduan = htmlspecialchars($this->request->getVar('identitas_aduan'), true);
            $uraian_aduan = htmlspecialchars($this->request->getVar('uraian_aduan'), true);
            $keterangan = (int)htmlspecialchars($this->request->getVar('keterangan'), true);

            if ($keterangan === NULL || $keterangan === "") {
                $jenisFix = $kategori;
            } else {
                $jenisFix = $kategori;
            }

            $uuidLib = new Uuid();

            $kodeUsulan = "ADUAN-" . $nik_aduan . '-' . time();

            $data = [
                'id' => $uuidLib->v4(),
                'kode_aduan' => $kodeUsulan,
                'nama' => $nama,
                'nik' => $nik,
                'nohp' => $nohp,
                'alamat' => $alamat,
                'kelurahan' => $kelurahan,
                'kecamatan' => $kecamatan,
                'nama_aduan' => $nama_aduan,
                'nik_aduan' => $nik_aduan,
                'nohp_aduan' => $nohp_aduan,
                'alamat_aduan' => $alamat_aduan,
                'kelurahan_aduan' => $kelurahan_aduan,
                'kecamatan_aduan' => $kecamatan_aduan,
                'user_id' => $user->data->id,
                'kategori' => $jenisFix,
                'identitas_aduan' => $identitas_aduan,
                'uraian_aduan' => $uraian_aduan,
                'status_aduan' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/aduan";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('_file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['lampiran_aduan'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload lampiran pengaduan.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_pengaduan')->insert($data);
            } catch (\Exception $e) {
                if ($filenamelampiran != '') {
                    unlink($dir . '/' . $newNamelampiran);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->error = $e;
                $response->message = "Gagal mengirim pengaduan.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $riwayatLib = new Riwayatpengaduanlib();
                try {
                    $riwayatLib->create($user->data->id, "Mengirim pengaduan dengan kode antrian: " . $data['kode_aduan'], "submit", "bx bx-send", "riwayat/detailpengaduan?token=" . $data['id'], $data['id']);
                } catch (\Throwable $th) {
                    $response->error = $th;
                }
                $response->status = 200;
                $response->message = "Pengaduan Berhasil di Kirim.";
                $response->redirect = base_url('silastri/peng/riwayat');
                return json_encode($response);
            } else {
                if ($filenamelampiran != '') {
                    unlink($dir . '/' . $newNamelampiran);
                }
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengirim pengaduan.";
                return json_encode($response);
            }
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
}
