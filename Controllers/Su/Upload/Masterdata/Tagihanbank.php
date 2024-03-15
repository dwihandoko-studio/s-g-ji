<?php

namespace App\Controllers\Su\Upload\Masterdata;

use App\Controllers\BaseController;
use App\Models\Su\Masterdata\Upload\TagihanbankModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\NotificationLib;
use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Tagihanbank extends BaseController
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
        $datamodel = new TagihanbankModel($request);

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
            $action = '<div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->filename . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                            <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . $list->filename . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Delete</a>
                        </div>
                    </div>';
            // $action = '<a href="javascript:actionDetail(\'' . $list->id . '\', \'' . $list->filename . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bxs-show font-size-16 align-middle"></i> DETAIL</button>
            //     </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            // $row[] = str_replace('&#039;', "`", str_replace("'", "`", $list->nama));
            $row[] = $list->filename;
            $row[] = 'Tahun ' . $list->tahun . ' - Bulan.' . $list->bulan;
            $row[] = $list->jumlah;
            $row[] = $list->lolos;
            $row[] = $list->gagal;
            $row[] = $list->done;
            $row[] = $list->created_at;

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
        return redirect()->to(base_url('su/upload/masterdata/tagihanbank/data'));
    }

    public function data()
    {
        $data['title'] = 'DATA UPLOAD TAGIHAN BANK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }
        // $id = $this->_helpLib->getPtkId($user->data->id);
        $data['user'] = $user->data;
        $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getRowObject();
        $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
        return view('su/upload/masterdata/tagihanbank/index', $data);
    }

    public function upload()
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
            $data['tw'] = $this->_db->table('_ref_tahun_bulan')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getRowObject();
            $data['tws'] = $this->_db->table('_ref_tahun_bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get()->getResult();
            $data['banks'] = $this->_db->table('ref_bank')->orderBy('nama_bank', 'desc')->get()->getResult();
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('su/upload/masterdata/tagihanbank/upload', $data);
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
            'tw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
            '_bank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dari bank tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,10240]|mime_in[_file,application/vnd.ms-excel,application/msexcel,application/x-msexcel,application/x-ms-excel,application/x-excel,application/x-dos_ms_excel,application/xls,application/x-xls,application/excel,application/download,application/vnd.ms-office,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar, Maximum 5Mb. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi xls atau xlsx. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('tw');
            // . $this->validator->getError('_file');
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

            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $dari_bank = htmlspecialchars($this->request->getVar('_bank'), true);

            $lampiran = $this->request->getFile('_file');
            // $mimeType = $lampiran->getMimeType();

            // var_dump($mimeType);
            // die;
            $extension = $lampiran->getClientExtension();
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_file($filesNamelampiran);
            $fileLocation = $lampiran->getTempName();

            if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($fileLocation);
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            $total_line = (count($sheet) > 0) ? count($sheet) - 4 : 0;

            $dataImport = [];

            $nuptkImport = [];

            // var_dump($ketSimtunDokumen);
            // die;

            unset($sheet[0]);
            unset($sheet[1]);
            unset($sheet[2]);
            unset($sheet[3]);
            // unset($sheet[4]);

            foreach ($sheet as $key => $data) {

                if ($data[3] == "" || strlen($data[3]) < 5) {
                    // if($data[1] == "") {
                    continue;
                }

                $dataInsert = [
                    'nip' => str_replace("'", "", $data[3]),
                    'nama' => $data[1],
                    'instansi' => $data[2],
                    'tahun_bulan' => $tw,
                    'kecamatan' => $data[4],
                    'besar_pinjaman' => $data[5],
                    'jumlah_tagihan' => str_replace(",", "", $data[6]),
                    'jumlah_bulan_angsuran' => str_replace(",", "", $data[7]),
                    'angsuran_ke' => str_replace(",", "", $data[8]),
                    'dari_bank' => $dari_bank,
                ];

                $dataInsert['data_pegawai'] = $this->_db->table('tb_pegawai_ a')
                    // ->select("a.id as id_usulan, a.us_pang_golongan, a.us_pang_mk_tahun, a.us_gaji_pokok, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, e.cuti as lampiran_cuti, e.pensiun as lampiran_pensiun, e.kematian as lampiran_kematian")
                    // ->join('_ptk_tb b', 'a.id_ptk = b.id')
                    // ->join('_upload_data_attribut e', 'a.id_ptk = e.id_ptk AND (a.id_tahun_tw = e.id_tahun_tw)')
                    // ->where('a.status_usulan', 6)
                    // ->where('a.id_tahun_tw', $tw)
                    ->where('a.nip', str_replace("'", "", $data[3]))
                    ->get()->getRowObject();

                $dataImport[] = $dataInsert;
                $nuptkImport[] = str_replace("'", "", $data[3]);
            }

            $dataImports = [
                'total_line' => $total_line,
                'data' => $dataImport,
            ];

            if (count($nuptkImport) < 1) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Tidak ada data yang di import.";
                return json_encode($response);
            }

            // $x['import'] = $dataImports;

            $data = [
                'id_tahun_tw' => $tw,
                'jumlah' => $total_line,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $dir = FCPATH . "upload/tagihanbank";
            $field_db = 'filename';
            $table_db = 'tb_up_masterdata_tagihan_bank';

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data[$field_db] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            // $dataResult['us_ptk'] = $this->_db->table('_tb_usulan_detail_tpg a')
            //     ->select("a.id as id_usulan, a.us_pang_golongan, a.us_pang_mk_tahun, a.us_gaji_pokok, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan")
            //     ->join('_ptk_tb b', 'a.id_ptk = b.id')
            //     ->where('a.status_usulan', 2)
            //     ->where('a.id_tahun_tw', $tw)
            //     ->whereIn('b.nuptk', $nuptkImport)
            //     ->get()->getResult();

            $this->_db->transBegin();
            try {
                $cekCurrent = $this->_db->table($table_db)->insert($data);
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
                if (write_file($dir . '/' . $newNamelampiran . '.json', json_encode($dataImports))) {
                } else {
                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = "Gagal membuat file json";
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }

                // createAktifitas($user->data->id, "Mengupload matching simtun $filesNamelampiran", "Mengupload Matching Simtun filesNamelampiran", "upload", $tw);
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $x['data'] = [];
                $x['id'] = $newNamelampiran;
                $response->data = view('su/upload/masterdata/tagihanbank/verifi-upload', $x);
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

    public function get_data_json()
    {
        $id = htmlspecialchars($this->request->getGet('id'), true);
        $datas = json_decode(file_get_contents(FCPATH . "upload/tagihanbank/$id.json"), true);

        // var_dump($datas);
        // die;
        $result = [];
        if (isset($datas['data']) && count($datas['data']) > 0) {
            $result['total'] = count($datas['data']);
            $response = [];
            $response_aksi = [];
            $lolos = 0;
            $gagal = 0;
            $belumusul = 0;
            foreach ($datas['data'] as $key => $v) {
                $item = [];
                // $tgl_lahir = explode("-", $v['tgl_lahir']);
                // $tgl_lhr = $tgl_lahir[2] . $tgl_lahir[1] . $tgl_lahir[0];
                if ($v['data_pegawai'] == NULL || $v['data_pegawai'] == "") {
                    $item['number'] = $key + 1;
                    $item['nip'] = $v['nip'];
                    $item['nama'] = $v['nama'];
                    $item['instansi'] = $v['instansi'];
                    $item['kecamatan'] = $v['kecamatan'];
                    $item['besar_pinjaman'] = $v['besar_pinjaman'];
                    $item['jumlah_tagihan'] = $v['jumlah_tagihan'];
                    $item['jumlah_bulan_angsuran'] = $v['jumlah_bulan_angsuran'];
                    $item['angsuran_ke'] = $v['angsuran_ke'];
                    $item['aksi'] = "Aksi";
                    $item['status'] = "table-info";
                    $item['id_pegawai'] = "";
                    $item['id_tahun_tw'] = "";
                    $item['dari_bank'] = $v['dari_bank'];
                    $item['sort'] = "99";
                    $belumusul += 1;
                } else {
                    $item['number'] = $key + 1;
                    $item['nip'] = $v['nip'];
                    $item['nama'] = $v['nama'];
                    $item['instansi'] = $v['instansi'];
                    $item['kecamatan'] = $v['kecamatan'];
                    $item['besar_pinjaman'] = $v['besar_pinjaman'];
                    $item['jumlah_tagihan'] = $v['jumlah_tagihan'];
                    $item['jumlah_bulan_angsuran'] = $v['jumlah_bulan_angsuran'];
                    $item['angsuran_ke'] = $v['angsuran_ke'];
                    $item['aksi'] = "Aksi";
                    $item['status'] = "table-success";
                    $item['id_pegawai'] = $v['data_pegawai']['id'];
                    $item['id_tahun_tw'] = $v['tahun_bulan'];
                    $item['dari_bank'] = $v['dari_bank'];
                    $item['sort'] = "88";
                    $lolos += 1;

                    $response_aksi[] = $item;
                }

                $response[] = $item;
            }
            usort($response, function ($a, $b) {
                return $a['sort'] - $b['sort'];
            });

            $result['lolos'] = $lolos;
            $result['gagal'] = $gagal;
            $result['belumusul'] = $belumusul;
            $result['data'] = $response;
            $result['aksi'] = $response_aksi;
        } else {
            $result['total'] = 0;
            $result['lolos'] = 0;
            $result['gagal'] = 0;
            $result['belumusul'] = 0;
            $result['data'] = [];
        }

        return json_encode($result);
    }

    public function prosesmatching()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'id_pegawai' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id pegawai tidak boleh kosong. ',
                ]
            ],
            'id_tahun_tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'dari_bank' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Dari bank tidak boleh kosong. ',
                ]
            ],
            'status' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Status tidak boleh kosong. ',
                ]
            ],
            'jumlah_tagihan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jumlah tagihan tidak boleh kosong. ',
                ]
            ],
            'angsuran_ke' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Angsuran ke tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id_pegawai')
                . $this->validator->getError('id_tahun_tw')
                . $this->validator->getError('dari_bank')
                . $this->validator->getError('status')
                . $this->validator->getError('jumlah_tagihan')
                . $this->validator->getError('angsuran_ke');
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

            $status = htmlspecialchars($this->request->getVar('status'), true);
            $id_pegawai = htmlspecialchars($this->request->getVar('id_pegawai'), true);
            $dari_bank = htmlspecialchars($this->request->getVar('dari_bank'), true);
            $id_tahun_tw = htmlspecialchars($this->request->getVar('id_tahun_tw'), true);

            $instansi = htmlspecialchars($this->request->getVar('instansi'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);
            $besar_pinjaman = htmlspecialchars($this->request->getVar('besar_pinjaman'), true);
            $jumlah_tagihan = htmlspecialchars($this->request->getVar('jumlah_tagihan'), true);
            $jumlah_bulan_angsuran = htmlspecialchars($this->request->getVar('jumlah_bulan_angsuran'), true);
            $angsuran_ke = htmlspecialchars($this->request->getVar('angsuran_ke'), true);

            $current = $this->_db->table('tb_tagihan_bank a')
                // ->select("a.id as id_usulan, a.us_pang_golongan, a.us_pang_mk_tahun, a.us_gaji_pokok, a.date_approve, a.kode_usulan, a.id_ptk, a.id_tahun_tw, a.status_usulan, a.date_approve_sptjm, b.nama, b.nik, b.nuptk, b.jenis_ptk, b.kecamatan, e.cuti as lampiran_cuti, e.pensiun as lampiran_pensiun, e.kematian as lampiran_kematian")
                // ->join('_ptk_tb b', 'a.id_ptk = b.id')
                // ->join('_upload_data_attribut e', 'a.id_ptk = e.id_ptk AND (a.id_tahun_tw = e.id_tahun_tw)')
                ->where('a.id_pegawai', $id_pegawai)
                ->where('a.tahun', $id_tahun_tw)
                ->get()->getRowObject();

            if (!$current) {
                $this->_db->transBegin();

                if ($status == "table-success") {
                    $uuidLib = new Uuid();
                    // $this->_db->table('_tb_usulan_tpg_siap_sk')->where('id', $current->id_usulan)->update(['status_usulan' => 7, 'updated_at' => date('Y-m-d H:i:s'), 'date_prosestransfer' => date('Y-m-d H:i:s'), 'admin_prosestransfer' => $user->data->id]);
                    // if ($this->_db->affectedRows() > 0) {

                    // $ptk = $this->_db->table('tb_tagihan_bank')->where('id', $current->id_usulan)->get()->getRowObject();
                    // if ($ptk) {
                    // if ($this->_db->affectedRows() > 0) {
                    try {
                        $this->_db->table('tb_tagihan_bank')->insert([
                            'id' => $uuidLib->v4(),
                            'tahun' => $id_tahun_tw,
                            'id_pegawai' => $id_pegawai,
                            'dari_bank' => $dari_bank,
                            'nip' => $nip,
                            'instansi' => $instansi,
                            'kecamatan' => $kecamatan,
                            'besar_pinjaman' => $besar_pinjaman,
                            'jumlah_tagihan' => $jumlah_tagihan,
                            'jumlah_bulan_angsuran' => $jumlah_bulan_angsuran,
                            'angsuran_ke' => $angsuran_ke,
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        if ($this->_db->affectedRows() > 0) {
                            $this->_db->transCommit();

                            // $dataNotif = [
                            //     "SKTP Telah Terbit", "Usulan " . $ptk->kode_usulan . " telah Terbit dengan No SK: " . $no_sktp . " No Urut: " . $no_urut, "success", $user->data->id, $ptk->id_ptk, base_url('situgu/ptk/us/tpg/skterbit')
                            // ];

                            // try {
                            //     $notifLib = new NotificationLib();
                            //     $notifLib->create("Proses Transfer", "Usulan " . $ptk->kode_usulan . " telah memasuki tahap proses trasnfer dengan total nominal: " . Rupiah($jumlah_diterima), "success", $user->data->id, $ptk->id_ptk, base_url('situgu/ptk/us/tpg/prosestransfer'));
                            // } catch (\Throwable $th) {
                            //     //throw $th;
                            // }
                            $response = new \stdClass;
                            $response->status = 200;
                            $response->message = "Data berhasil disimpan.";
                            // $response->suce = $dataNotif;
                            return json_encode($response);
                        } else {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Gagal menyimpan data import.";
                            return json_encode($response);
                        }
                        //code...
                    } catch (\Throwable $th) {
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data import.";
                        return json_encode($response);
                    }
                    // } else {
                    //     $this->_db->transRollback();
                    //     $response = new \stdClass;
                    //     $response->status = 400;
                    //     $response->message = "Gagal memindahkan data usulan.";
                    //     return json_encode($response);
                    // }
                    // } else {
                    //     $this->_db->transRollback();
                    //     $response = new \stdClass;
                    //     $response->status = 400;
                    //     $response->message = "Gagal mengupdate data usulan.";
                    //     return json_encode($response);
                    // }
                    // } else {
                    //     $this->_db->transRollback();
                    //     $response = new \stdClass;
                    //     $response->status = 400;
                    //     $response->message = "Gagal mengupdate data usulan.";
                    //     return json_encode($response);
                    // }
                } else {
                    // $this->_db->table('_tb_usulan_detail_tpg')->where('id', $current->id_usulan)->update(['status_usulan' => 4, 'updated_at' => date('Y-m-d H:i:s'), 'date_matching' => date('Y-m-d H:i:s'), 'admin_matching' => $user->data->id, 'keterangan_reject' => $keterangan]);
                    // if ($this->_db->affectedRows() > 0) {
                    //     $this->_db->transCommit();
                    //     try {
                    //         $notifLib = new NotificationLib();
                    //         $notifLib->create("Gagal Matching Simtun", "Usulan " . $current->kode_usulan . " gagal untuk lolos matching simtun dengan keterangan: " . $keterangan, "danger", $user->data->id, $current->id_ptk, base_url('situgu/ptk/us/tpg/siapsk'));
                    //     } catch (\Throwable $th) {
                    //         //throw $th;
                    //     }
                    //     $response = new \stdClass;
                    //     $response->status = 200;
                    //     $response->message = "Data berhasil disimpan.";
                    //     return json_encode($response);
                    // } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data import.";
                    return json_encode($response);
                    // }
                }
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
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
            'filename' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Filename tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('filename');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $filename = htmlspecialchars($this->request->getVar('filename'), true);

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

            $current = $this->_db->table('tb_up_masterdata_tagihan_bank')
                ->where('id', $id)
                ->get()->getRowObject();

            if ($current) {

                $this->_db->transBegin();
                try {
                    $this->_db->table('tb_up_masterdata_tagihan_bank')->where('id', $current->id)->delete();
                } catch (\Throwable $th) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($th);
                    $response->message = "Data matching gagal dihapus.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    $this->_db->transCommit();
                    try {
                        $file = $current->filename;
                        unlink(FCPATH . "upload/tagihanbank/$file.json");
                        unlink(FCPATH . "upload/tagihanbank/$file");
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Data upload tagihanbank berhasil dihapus.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Data upload tagihanbank gagal dihapus.";
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
