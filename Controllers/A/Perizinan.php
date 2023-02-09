<?php

namespace App\Controllers\A;

use App\Controllers\BaseController;
use App\Models\A\PerizinanModel;
use Config\Services;
use App\Libraries\Profilelib;

class Perizinan extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new PerizinanModel($request);


        $lists = $datamodel->get_datatables();
        // $lists = [];
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            $action = '<a href="javascript:actionDetail(\'' . $list->pid . '\', \'' . $list->nomor_izin . '\');"><button type="button" class="btn btn-sm btn-icon btn-info mr-1 mb-1">
                        <i class="feather icon-eye"></i></button>
                        </a>
                        <a href="javascript:actionEdit(\'' . $list->pid . '\', \'' . $list->nomor_izin . '\');"><button type="button" class="btn btn-sm btn-icon btn-light mr-1 mb-1">
                        <i class="feather icon-edit"></i></button>
                        </a>
                        <a href="javascript:actionHapus(\'' . $list->pid . '\', \'' . $list->nomor_izin . '\');" class="delete" id="delete"><button type="button" class="btn btn-sm btn-icon btn-danger mr-1 mb-1"><i class="feather icon-trash"></i></button></a>';
            // if ($list->image !== null) {
            //     $image = '<img alt="Image placeholder" src="' . base_url() . '/uploads/user/' . $list->image . '" width="60px" height="60px">';
            // } else {
            //     $image = "-";
            // }
            $row[] = $action;
            $row[] = $list->kategori;
            $row[] = $list->nomor_izin;
            $row[] = $list->nama_pemohon;
            $row[] = $list->deskripsi;
            $row[] = $list->kampung;
            $row[] = $list->kecamatan;
            $row[] = $list->tanggal_terbit;
            $row[] = $list->masa_berlaku;
            // switch ((int)$list->level) {
            //     case 1:
            //         $row[] = "Superadmin";
            //         break;
            //     case 2:
            //         $row[] = "Admin DPMPTSP";
            //         break;
            //     case 3:
            //         $row[] = "Admin Bapenda";
            //         break;

            //     default:
            //         $row[] = "Monitoring";
            //         break;
            // }

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            // "recordsTotal" => 0,
            // "recordsFiltered" => 0,
            "recordsTotal" => $datamodel->count_all(),
            "recordsFiltered" => $datamodel->count_filtered(),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('a/perizinan/data'));
    }

    public function data()
    {
        $data['title'] = 'Perizinan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        return view('a/perizinan/index', $data);
    }

    public function add()
    {
        $data['title'] = 'Tambah Perizinan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['kategoris'] = $this->_db->table('_tb_kategori_perizinan')->orderBy('kategori', 'asc')->get()->getResult();

        return view('a/perizinan/add', $data);
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
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $current = $this->_db->table('_tb_perizinan')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $data['data'] = $current;
                $data['kategoris'] = $this->_db->table('_tb_kategori_perizinan')->orderBy('kategori', 'asc')->get()->getResult();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('a/perizinan/edit', $data);
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
            $current = $this->_db->table('_tb_perizinan')
                ->where('pid', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_perizinan')->where('pid', $id)->delete();

                    if ($this->_db->affectedRows() > 0) {
                        if ($current->lampiran !== null) {
                            try {
                                $dir = FCPATH . "uploads/perizinan";
                                unlink($dir . '/' . $current->lampiran);
                            } catch (\Throwable $err) {
                            }
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

    public function addSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            '_kategori' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori tidak boleh kosong. ',
                ]
            ],
            '_nomor_izin' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor izin tidak boleh kosong. ',
                ]
            ],
            '_nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama pemohon tidak boleh kosong. ',
                ]
            ],
            '_merk_reklame' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Merk reklame tidak boleh kosong. ',
                ]
            ],
            '_rincian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rincian tidak boleh kosong. ',
                ]
            ],
            '_alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            '_kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kecamatan tidak boleh kosong. ',
                ]
            ],
            '_kampung' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kampung tidak boleh kosong. ',
                ]
            ],
            '_tanggal_terbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal terbit tidak boleh kosong. ',
                ]
            ],
            '_masa_berlaku' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masa berlaku tidak boleh kosong. ',
                ]
            ],
            '_keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,20480]|mime_in[_file,application/pdf,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
                        'max_size' => 'Ukuran gambar profil terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar / pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('_kategori')
                . $this->validator->getError('_nomor_izin')
                . $this->validator->getError('_nama')
                . $this->validator->getError('_merk_reklame')
                . $this->validator->getError('_rincian')
                . $this->validator->getError('_alamat')
                . $this->validator->getError('_kecamatan')
                . $this->validator->getError('_kampung')
                . $this->validator->getError('_tanggal_terbit')
                . $this->validator->getError('_masa_berlaku')
                . $this->validator->getError('_file')
                . $this->validator->getError('_keterangan');
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

            $kategori = htmlspecialchars($this->request->getVar('_kategori'), true);
            $nomor_izin = htmlspecialchars($this->request->getVar('_nomor_izin'), true);
            $nama = htmlspecialchars($this->request->getVar('_nama'), true);
            $merk_reklame = htmlspecialchars($this->request->getVar('_merk_reklame'), true);
            $rincian = htmlspecialchars($this->request->getVar('_rincian'), true);
            $alamat = htmlspecialchars($this->request->getVar('_alamat'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('_kecamatan'), true);
            $kampung = htmlspecialchars($this->request->getVar('_kampung'), true);
            $tanggal_terbit = htmlspecialchars($this->request->getVar('_tanggal_terbit'), true);
            $masa_berlaku = htmlspecialchars($this->request->getVar('_masa_berlaku'), true);
            $keterangan = htmlspecialchars($this->request->getVar('_keterangan'), true);

            $cekData = $this->_db->table('_tb_perizinan')->where(['nomor_izin' => $nomor_izin])->get()->getRowObject();

            if ($cekData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Nomor izin sudah terinput.";
                return json_encode($response);
            }

            $data = [
                'k_id' => $kategori,
                'nomor_izin' => $nomor_izin,
                'nama_pemohon' => $nama,
                'deskripsi' => $merk_reklame,
                'rincian' => $rincian,
                'alamat' => $alamat,
                'kampung' => $kampung,
                'kecamatan' => $kecamatan,
                'tanggal_terbit' => $tanggal_terbit,
                'masa_berlaku' => $masa_berlaku,
                'keterangan' => $keterangan,
                'user_created' => $user->data->uid,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "uploads/perizinan";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('_file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['lampiran'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload file.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_perizinan')->insert($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan perizinan baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil disimpan.";
                $response->redirect = base_url('a/perizinan/data');
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

    public function editSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            '_id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            '_kategori' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kategori tidak boleh kosong. ',
                ]
            ],
            '_nomor_izin' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nomor izin tidak boleh kosong. ',
                ]
            ],
            '_nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama pemohon tidak boleh kosong. ',
                ]
            ],
            '_merk_reklame' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Merk reklame tidak boleh kosong. ',
                ]
            ],
            '_rincian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rincian tidak boleh kosong. ',
                ]
            ],
            '_alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            '_kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kecamatan tidak boleh kosong. ',
                ]
            ],
            '_kampung' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kampung tidak boleh kosong. ',
                ]
            ],
            '_tanggal_terbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal terbit tidak boleh kosong. ',
                ]
            ],
            '_masa_berlaku' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masa berlaku tidak boleh kosong. ',
                ]
            ],
            '_keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,20480]|mime_in[_file,application/pdf,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
                        'max_size' => 'Ukuran gambar profil terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar / pdf. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('_kategori')
                . $this->validator->getError('_id')
                . $this->validator->getError('_nomor_izin')
                . $this->validator->getError('_nama')
                . $this->validator->getError('_merk_reklame')
                . $this->validator->getError('_rincian')
                . $this->validator->getError('_alamat')
                . $this->validator->getError('_kecamatan')
                . $this->validator->getError('_kampung')
                . $this->validator->getError('_tanggal_terbit')
                . $this->validator->getError('_masa_berlaku')
                . $this->validator->getError('_file')
                . $this->validator->getError('_keterangan');
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

            $id = htmlspecialchars($this->request->getVar('_id'), true);
            $kategori = htmlspecialchars($this->request->getVar('_kategori'), true);
            $nomor_izin = htmlspecialchars($this->request->getVar('_nomor_izin'), true);
            $nama = htmlspecialchars($this->request->getVar('_nama'), true);
            $merk_reklame = htmlspecialchars($this->request->getVar('_merk_reklame'), true);
            $rincian = htmlspecialchars($this->request->getVar('_rincian'), true);
            $alamat = htmlspecialchars($this->request->getVar('_alamat'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('_kecamatan'), true);
            $kampung = htmlspecialchars($this->request->getVar('_kampung'), true);
            $tanggal_terbit = htmlspecialchars($this->request->getVar('_tanggal_terbit'), true);
            $masa_berlaku = htmlspecialchars($this->request->getVar('_masa_berlaku'), true);
            $keterangan = htmlspecialchars($this->request->getVar('_keterangan'), true);

            $oldData =  $this->_db->table('_tb_perizinan')->where('pid', $id)->get()->getRowObject();

            if (!$oldData) {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan.";
                return json_encode($response);
            }

            if (
                (int)$kategori === (int)$oldData->k_id
                && $nomor_izin === $oldData->nomor_izin
                && $nama === $oldData->nama_pemohon
                && $merk_reklame === $oldData->deskripsi
                && $rincian === $oldData->rincian
                && $alamat === $oldData->alamat
                && $kecamatan === $oldData->kecamatan
                && $kampung === $oldData->kampung
                && $tanggal_terbit === $oldData->tanggal_terbit
                && $masa_berlaku === $oldData->masa_berlaku
                && $keterangan === $oldData->keterangan
            ) {
                if ($filenamelampiran == '') {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    $response->redirect = base_url('a/perizinan/data');
                    return json_encode($response);
                }
            }

            if ($nomor_izin !== $oldData->nomor_izin) {
                $cekData = $this->_db->table('_tb_perizinan')->where(['nomor_izin' => $nomor_izin])->get()->getRowObject();
                if ($cekData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Nomor izin sudah ada.";
                    return json_encode($response);
                }
            }

            $data = [
                'k_id' => $kategori,
                'nomor_izin' => $nomor_izin,
                'nama_pemohon' => $nama,
                'deskripsi' => $merk_reklame,
                'rincian' => $rincian,
                'alamat' => $alamat,
                'kampung' => $kampung,
                'kecamatan' => $kecamatan,
                'tanggal_terbit' => $tanggal_terbit,
                'masa_berlaku' => $masa_berlaku,
                'keterangan' => $keterangan,
                'user_updated' => $user->data->uid,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $dir = FCPATH . "uploads/perizinan";

            if ($filenamelampiran != '') {
                $lampiran = $this->request->getFile('_file');
                $filesNamelampiran = $lampiran->getName();
                $newNamelampiran = _create_name_foto($filesNamelampiran);

                if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                    $lampiran->move($dir, $newNamelampiran);
                    $data['lampiran'] = $newNamelampiran;
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupload file.";
                    return json_encode($response);
                }
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_tb_perizinan')->where('pid', $oldData->pid)->update($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal menyimpan file baru.";
                return json_encode($response);
            }

            if ($this->_db->affectedRows() > 0) {
                if ($oldData->lampiran !== null) {
                    try {
                        unlink($dir . '/' . $oldData->lampiran);
                    } catch (\Throwable $th) {
                    }
                }
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
                $response->redirect = base_url('a/perizinan/data');
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupate data";
                return json_encode($response);
            }
        }
    }
}
