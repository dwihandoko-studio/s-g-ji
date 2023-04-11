<?php

namespace App\Controllers\Situpeng\Adm\Masterdata;

use App\Controllers\BaseController;
use App\Models\Situpeng\Adm\PengawasModel;
use Config\Services;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;

use App\Libraries\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengawas extends BaseController
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
        $datamodel = new PengawasModel($request);


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
                            <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama)) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
                            <!--<a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk  . '\', \'' . $list->jenis_pengawas . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Tarik Data</a>
                            <a class="dropdown-item" href="javascript:actionEdit(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk  . '\', \'' . $list->jenis_pengawas . '\');"><i class="bx bx-edit-alt font-size-16 align-middle"></i> &nbsp;Edit</a> -->
                            <a class="dropdown-item" href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk . '\');"><i class="bx bx-trash font-size-16 align-middle"></i> &nbsp;Hapus</a>
                            <!-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:actionUnlockSpj(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk . '\');"><i class="bx bx-lock-open-alt font-size-16 align-middle"></i> &nbsp;Unlock SPJ</i></a>
                            <a class="dropdown-item" href="javascript:actionDetailBackbone(\'' . $list->id . '\', \'' . str_replace('&#039;', "`", str_replace("'", "`", $list->nama))  . '\', \'' . $list->nuptk . '\');"><i class="mdi mdi-bullseye font-size-16 align-middle"></i> &nbsp;Detail Data Backbone</i></a> -->
                        </div>
                    </div>';
            $row[] = $action;
            $row[] = $list->nama;
            $row[] = $list->nik;
            $row[] = $list->nuptk;
            $row[] = $list->nip;
            $row[] = $list->keaktifan;

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
        return redirect()->to(base_url('situpeng/adm/masterdata/pengawas/data'));
    }

    public function data()
    {
        $data['title'] = 'PENGAWAS';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('situpeng/adm/masterdata/pengawas/index', $data);
    }

    public function detailbackbone()
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
            'nuptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NUPTK tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('nuptk');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nuptk = htmlspecialchars($this->request->getVar('nuptk'), true);

            $current = $this->_db->table('_ptk_tb')->select("id_ptk, nuptk")
                ->where('id', $id)->get()->getRowObject();

            if ($current) {
                $apiLib = new Apilib();
                if ($current->id_ptk !== null) {
                    $result = $apiLib->getPtkById($current->id_ptk);

                    $ptk = $result;
                } else {
                    $result = $apiLib->getPtkByNuptk($current->nuptk);

                    $ptk = $result;
                }

                $data['data'] = $ptk;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengawas/get_detail_backbone', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function add()
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


            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situpeng/adm/masterdata/pengawas/add');
            return json_encode($response);
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
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'nuptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NUPTK tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong. ',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong. ',
                ]
            ],
            'jenis_pengawas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis pengawas tidak boleh kosong. ',
                ]
            ],
            'tmt_cpns' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt cpns tidak boleh kosong. ',
                ]
            ],
            'tmt_pns' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt pns tidak boleh kosong. ',
                ]
            ],
            'tmt_pengangkatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt pengangkatan tidak boleh kosong. ',
                ]
            ],
            'sk_pengangkatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'SK pengangkatan tidak boleh kosong. ',
                ]
            ],
            'tgl_pensiun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal pensiun tidak boleh kosong. ',
                ]
            ],
            'pendidikan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pendidikan tidak boleh kosong. ',
                ]
            ],
            'nomor_surat_tugas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor surat tugas tidak boleh kosong. ',
                ]
            ],
            'tmt_surat_tugas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TMT surat tugas tidak boleh kosong. ',
                ]
            ],
            'jenjang_pengawas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenjang pengawas tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nuptk')
                . $this->validator->getError('nip')
                . $this->validator->getError('tgl_lahir')
                . $this->validator->getError('jenis_pengawas')
                . $this->validator->getError('tmt_cpns')
                . $this->validator->getError('tmt_pns')
                . $this->validator->getError('tmt_pengangkatan')
                . $this->validator->getError('sk_pengangkatan')
                . $this->validator->getError('tgl_pensiun')
                . $this->validator->getError('pendidikan')
                . $this->validator->getError('nomor_surat_tugas')
                . $this->validator->getError('tmt_surat_tugas')
                . $this->validator->getError('jenjang_pengawas');
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
                return json_encode($response);
            }

            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nuptk = htmlspecialchars($this->request->getVar('nuptk'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $tgl_lahir = htmlspecialchars($this->request->getVar('tgl_lahir'), true);
            $jenis_pengawas = htmlspecialchars($this->request->getVar('jenis_pengawas'), true);
            $tmt_cpns = htmlspecialchars($this->request->getVar('tmt_cpns'), true);
            $tmt_pns = htmlspecialchars($this->request->getVar('tmt_pns'), true);
            $tmt_pengangkatan = htmlspecialchars($this->request->getVar('tmt_pengangkatan'), true);
            $sk_pengangkatan = htmlspecialchars($this->request->getVar('sk_pengangkatan'), true);
            $tgl_pensiun = htmlspecialchars($this->request->getVar('tgl_pensiun'), true);
            $pendidikan = htmlspecialchars($this->request->getVar('pendidikan'), true);
            $nomor_surat_tugas = htmlspecialchars($this->request->getVar('nomor_surat_tugas'), true);
            $tmt_surat_tugas = htmlspecialchars($this->request->getVar('tmt_surat_tugas'), true);
            $jenjang_pengawas = htmlspecialchars($this->request->getVar('jenjang_pengawas'), true);
            $keaktifan = 'Aktif';

            $data = [
                'nama' => $nama,
                'nuptk' => $nuptk,
                'nip' => $nip,
                'tgl_lahir' => $tgl_lahir,
                'jenis_pengawas' => $jenis_pengawas,
                'tmt_cpns' => $tmt_cpns,
                'tmt_pns' => $tmt_pns,
                'tmt_pengangkatan' => $tmt_pengangkatan,
                'sk_pengangkatan' => $sk_pengangkatan,
                'tgl_pensiun' => $tgl_pensiun,
                'pendidikan' => $pendidikan,
                'nomor_surat_tugas' => $nomor_surat_tugas,
                'tmt_surat_tugas' => $tmt_surat_tugas,
                'jenjang_pengawas' => $jenjang_pengawas,
                'keaktifan' => $keaktifan,
                'tgl_nonaktif' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->_db->transBegin();

            $uuidLib = new Uuid();
            $data['id'] = $uuidLib->v4();

            try {
                $this->_db->table('__pengawas_tb')->insert($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan data";
                return json_encode($response);
            }
        }
    }

    public function import()
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


            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situpeng/adm/masterdata/pengawas/import');
            return json_encode($response);
        }
    }

    public function aksiimport()
    {
        if ($this->request->getMethod() != 'post') {
            $response = [
                'status' => 400,
                'message' => "Hanya request post yang diperbolehkan."
            ];
        } else {

            $rules = [
                'file' => [
                    'rules' => 'uploaded[file]|max_size[file, 5120]|mime_in[file,application/vnd.ms-excel,application/msexcel,application/x-msexcel,application/x-ms-excel,application/x-excel,application/x-dos_ms_excel,application/xls,application/x-xls,application/excel,application/download,application/vnd.ms-office,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip]',
                    'errors' => [
                        'uploaded' => 'File import gagal di upload ',
                        'max_size' => 'Ukuran file melebihi batas file max file upload. ',
                        'mime_in' => 'Ekstensi file tidak diizinkan untuk di upload. ',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $response = [
                    'status' => 400,
                    'message' => $this->validator->getError('file')
                ];
            } else {
                $lampiran = $this->request->getFile('file');
                $extension = $lampiran->getClientExtension();
                $filesNamelampiran = $lampiran->getName();
                $fileLocation = $lampiran->getTempName();

                if ('xls' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $reader->load($fileLocation);
                $sheet = $spreadsheet->getActiveSheet()->toArray();

                $total_line = (count($sheet) > 0) ? count($sheet) - 1 : 0;

                $dataImport = [];

                unset($sheet[0]);

                foreach ($sheet as $key => $data) {

                    // if ($data[7] == "Non Induk") {
                    //     continue;
                    // }

                    $nuptk = ($data[2] === "null" || $data[2] === "") ? null : $data[2];
                    $nip = ($data[3] === "null" || $data[3] === "") ? null : $data[3];

                    $dataInsert = [
                        'nama' => $data[1],
                        'nuptk' => $nuptk,
                        'nip' => $nip,
                        'tgl_lahir' => $data[4],
                        'jenis_pengawas' => $data[5],
                        'tmt_cpns' => $data[6],
                        'tmt_pns' => $data[7],
                        'tmt_pengangkatan' => $data[8],
                        'sk_pengangkatan' => $data[9],
                        'tgl_pensiun' => $data[10],
                        'pendidikan' => $data[11],
                        'nomor_surat_tugas' => $data[12],
                        'tmt_surat_tugas' => $data[13],
                        'jenjang_pengawas' => $data[14],
                        'keaktifan' => $data[15],
                        'tgl_nonaktif' => $data[16],
                    ];

                    $dataImport[] = $dataInsert;
                }

                $response = [
                    'status' => 200,
                    'success' => true,
                    'total_line' => $total_line,
                    'data' => $dataImport,
                ];
                //     } else {
                //         $response =[
                //             'code' => 400,
                //             'error' => "Gagal upload file."
                //         ];
                //     }
                // } else {
                //     $response =[
                //         'code' => 400,
                //         'error' => "Gagal upload file."
                //     ];
                // }
            }
        }

        echo json_encode($response);
    }

    public function importData()
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
            'nuptk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NUPTK tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong. ',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong. ',
                ]
            ],
            'jenis_pengawas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis pengawas tidak boleh kosong. ',
                ]
            ],
            'tmt_cpns' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt cpns tidak boleh kosong. ',
                ]
            ],
            'tmt_pns' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt pns tidak boleh kosong. ',
                ]
            ],
            'tmt_pengangkatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tmt pengangkatan tidak boleh kosong. ',
                ]
            ],
            'sk_pengangkatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'SK pengangkatan tidak boleh kosong. ',
                ]
            ],
            'tgl_pensiun' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal pensiun tidak boleh kosong. ',
                ]
            ],
            'pendidikan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pendidikan tidak boleh kosong. ',
                ]
            ],
            'nomor_surat_tugas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor surat tugas tidak boleh kosong. ',
                ]
            ],
            'tmt_surat_tugas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TMT surat tugas tidak boleh kosong. ',
                ]
            ],
            'jenjang_pengawas' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenjang pengawas tidak boleh kosong. ',
                ]
            ],
            'keaktifan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Keaktifan tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('nuptk')
                . $this->validator->getError('nip')
                . $this->validator->getError('tgl_lahir')
                . $this->validator->getError('jenis_pengawas')
                . $this->validator->getError('tmt_cpns')
                . $this->validator->getError('tmt_pns')
                . $this->validator->getError('tmt_pengangkatan')
                . $this->validator->getError('sk_pengangkatan')
                . $this->validator->getError('tgl_pensiun')
                . $this->validator->getError('pendidikan')
                . $this->validator->getError('nomor_surat_tugas')
                . $this->validator->getError('tmt_surat_tugas')
                . $this->validator->getError('jenjang_pengawas')
                . $this->validator->getError('keaktifan');
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
                return json_encode($response);
            }

            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nuptk = htmlspecialchars($this->request->getVar('nuptk'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);
            $pangkat = htmlspecialchars($this->request->getVar('pangkat'), true);
            $tgl_lahir = htmlspecialchars($this->request->getVar('tgl_lahir'), true);
            $jenis_pengawas = htmlspecialchars($this->request->getVar('jenis_pengawas'), true);
            $tmt_cpns = htmlspecialchars($this->request->getVar('tmt_cpns'), true);
            $tmt_pns = htmlspecialchars($this->request->getVar('tmt_pns'), true);
            $tmt_pengangkatan = htmlspecialchars($this->request->getVar('tmt_pengangkatan'), true);
            $sk_pengangkatan = htmlspecialchars($this->request->getVar('sk_pengangkatan'), true);
            $tgl_pensiun = htmlspecialchars($this->request->getVar('tgl_pensiun'), true);
            $pendidikan = htmlspecialchars($this->request->getVar('pendidikan'), true);
            $nomor_surat_tugas = htmlspecialchars($this->request->getVar('nomor_surat_tugas'), true);
            $tmt_surat_tugas = htmlspecialchars($this->request->getVar('tmt_surat_tugas'), true);
            $jenjang_pengawas = htmlspecialchars($this->request->getVar('jenjang_pengawas'), true);
            $keaktifan = htmlspecialchars($this->request->getVar('keaktifan'), true);
            $tgl_nonaktif = htmlspecialchars($this->request->getVar('tgl_nonaktif'), true);

            $data = [
                'nama' => $nama,
                'nuptk' => $nuptk,
                'nip' => $nip,
                'tgl_lahir' => $tgl_lahir,
                'jenis_pengawas' => $jenis_pengawas,
                'tmt_cpns' => $tmt_cpns,
                'tmt_pns' => $tmt_pns,
                'tmt_pengangkatan' => $tmt_pengangkatan,
                'sk_pengangkatan' => $sk_pengangkatan,
                'tgl_pensiun' => $tgl_pensiun,
                'pendidikan' => $pendidikan,
                'nomor_surat_tugas' => $nomor_surat_tugas,
                'tmt_surat_tugas' => $tmt_surat_tugas,
                'jenjang_pengawas' => $jenjang_pengawas,
                'keaktifan' => $keaktifan,
                'tgl_nonaktif' => $tgl_nonaktif == "" ? NULL : $tgl_nonaktif,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $oldData =  $this->_db->table('__pengawas_tb')->where('nuptk', $nuptk)->get()->getRowObject();

            $this->_db->transBegin();
            if ($oldData) {
                try {
                    $this->_db->table('__pengawas_tb')->where('id', $oldData->id)->update($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupdate data baru.";
                    return json_encode($response);
                }
            } else {
                $uuidLib = new Uuid();
                $data['id'] = $uuidLib->v4();

                try {
                    $this->_db->table('__pengawas_tb')->insert($data);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data baru.";
                    return json_encode($response);
                }
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $current = $this->_db->table('_ptk_tb a')
                ->select("a.*, b.no_hp as nohpAkun, b.email as emailAkun, b.wa_verified, b.image, c.kecamatan as kecamatan_sekolah")
                ->join('v_user b', 'a.id_ptk = b.ptk_id', 'left')
                ->join('ref_sekolah c', 'a.npsn = c.npsn')
                ->where('a.id', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['penugasans'] = $this->_db->table('_ptk_tb_dapodik a')
                    ->select("a.*, b.npsn, b.nama as namaSekolah, b.kecamatan as kecamatan_sekolah, (SELECT SUM(jam_mengajar_per_minggu) FROM _pembelajaran_dapodik WHERE ptk_id = a.ptk_id AND sekolah_id = a.sekolah_id AND semester_id = a.semester_id) as jumlah_total_jam_mengajar_perminggu")
                    ->join('ref_sekolah b', 'a.sekolah_id = b.id')
                    ->where('a.ptk_id', $current->id_ptk)
                    ->where("a.jenis_keluar IS NULL")
                    ->orderBy('a.ptk_induk', 'DESC')->get()->getResult();
                $data['igd'] = $this->_db->table('_info_gtk')->where('ptk_id', $current->id_ptk)->get()->getRowObject();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengawas/detail', $data);
                return json_encode($response);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function edit()
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
            'ptk_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'PTK Id tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'npsn' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'NPSN tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('nama')
                . $this->validator->getError('npsn')
                . $this->validator->getError('ptk_id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $ptk_id = htmlspecialchars($this->request->getVar('ptk_id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $npsn = htmlspecialchars($this->request->getVar('npsn'), true);

            $current = $this->_db->table('_ptk_tb')
                ->where(['id' => $id, 'id_ptk' => $ptk_id, 'npsn' => $npsn])->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situpeng/adm/masterdata/pengawas/edit', $data);
                return json_encode($response);
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

    public function editSave()
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
                    'required' => 'Id PTK tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
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
            $nrg = htmlspecialchars($this->request->getVar('nrg'), true);
            $no_peserta = htmlspecialchars($this->request->getVar('no_peserta'), true);
            $bidang_studi_sertifikasi = htmlspecialchars($this->request->getVar('bidang_studi_sertifikasi'), true);
            $pangkat = htmlspecialchars($this->request->getVar('pangkat'), true);
            $no_sk_pangkat = htmlspecialchars($this->request->getVar('no_sk_pangkat'), true);
            $tgl_pangkat = htmlspecialchars($this->request->getVar('tgl_pangkat'), true);
            $tmt_pangkat = htmlspecialchars($this->request->getVar('tmt_pangkat'), true);
            $mkt_pangkat = htmlspecialchars($this->request->getVar('mkt_pangkat'), true);
            $mkb_pangkat = htmlspecialchars($this->request->getVar('mkb_pangkat'), true);
            $kgb = htmlspecialchars($this->request->getVar('kgb'), true);
            $no_sk_kgb = htmlspecialchars($this->request->getVar('no_sk_kgb'), true);
            $tgl_kgb = htmlspecialchars($this->request->getVar('tgl_kgb'), true);
            $tmt_kgb = htmlspecialchars($this->request->getVar('tmt_kgb'), true);
            $mkt_kgb = htmlspecialchars($this->request->getVar('mkt_kgb'), true);
            $mkb_kgb = htmlspecialchars($this->request->getVar('mkb_kgb'), true);

            $oldData =  $this->_db->table('_ptk_tb')->where('id', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($nrg !== "") {
                $data['nrg'] = $nrg;
            }
            if ($no_peserta !== "") {
                $data['no_peserta'] = $no_peserta;
            }
            if ($bidang_studi_sertifikasi !== "") {
                $data['bidang_studi_sertifikasi'] = $bidang_studi_sertifikasi;
            }
            if ($pangkat !== "") {
                $data['pangkat_golongan'] = $pangkat;
            }
            if ($no_sk_pangkat !== "") {
                $data['nomor_sk_pangkat'] = $no_sk_pangkat;
            }
            if ($tgl_pangkat !== "") {
                $data['tgl_sk_pangkat'] = $tgl_pangkat;
            }
            if ($tmt_pangkat !== "") {
                $data['tmt_pangkat'] = $tmt_pangkat;
            }
            if ($mkt_pangkat !== "") {
                $data['masa_kerja_tahun'] = $mkt_pangkat;
            }
            if ($mkb_pangkat !== "") {
                $data['masa_kerja_bulan'] = $mkb_pangkat;
            }
            if ($kgb !== "") {
                $data['pangkat_golongan_kgb'] = $kgb;
            }
            if ($no_sk_kgb !== "") {
                $data['sk_kgb'] = $no_sk_kgb;
            }
            if ($tgl_kgb !== "") {
                $data['tgl_sk_kgb'] = $tgl_kgb;
            }
            if ($tmt_kgb !== "") {
                $data['tmt_sk_kgb'] = $tmt_kgb;
            }
            if ($mkt_kgb !== "") {
                $data['masa_kerja_tahun_kgb'] = $mkt_kgb;
            }
            if ($mkb_kgb !== "") {
                $data['masa_kerja_bulan_kgb'] = $mkb_kgb;
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_ptk_tb')->where('id', $oldData->id)->update($data);
            } catch (\Exception $e) {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan gambar baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                return json_encode($response);
            } else {
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
