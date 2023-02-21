<?php

namespace App\Controllers\Situgu\Ptk;

use App\Controllers\BaseController;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Situgu\Kehadiranptklib;

class Infogtk extends BaseController
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

    public function index()
    {
        return redirect()->to(base_url('situgu/ptk/infogtk/data'));
    }

    public function data()
    {
        $data['title'] = 'Info GTK';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        if ($user->data->ptk_id !== NULL) {
            $data['infogtk'] = $this->_db->table('_info_gtk')->where('ptk_id', $user->data->ptk_id)->get()->getRowObject();
        }
        return view('situgu/ptk/infogtk/index', $data);
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
            'bulan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bulan tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'title' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('bulan')
                . $this->validator->getError('tw')
                . $this->validator->getError('title')
                . $this->validator->getError('id');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['id'] = $id;
            $data['title'] = $title;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ptk/absen/upload', $data);
            return json_encode($response);
        }
    }

    public function editformupload()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'bulan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Bulan tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'TW tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'title' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Title tidak boleh kosong. ',
                ]
            ],
            'old' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Old tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('bulan')
                . $this->validator->getError('tw')
                . $this->validator->getError('title')
                . $this->validator->getError('old')
                . $this->validator->getError('id');
            return json_encode($response);
        } else {
            $bulan = htmlspecialchars($this->request->getVar('bulan'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $title = htmlspecialchars($this->request->getVar('title'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);

            $data['bulan'] = $bulan;
            $data['tw'] = $tw;
            $data['id'] = $id;
            $data['title'] = $title;
            $data['old'] = $old;
            switch ($bulan) {
                case 'bulan1':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'bulan2':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'bulan3':
                    $data['old_url'] = base_url('upload/sekolah/kehadiran') . '/' . $old;
                    break;
                case 'pembagian_tugas':
                    $data['old_url'] = base_url('upload/sekolah/pembagian-tugas') . '/' . $old;
                    break;
                case 'slip_gaji':
                    $data['old_url'] = base_url('upload/sekolah/slip-gaji') . '/' . $old;
                    break;
                default:
                    $data['old_url'] = base_url('upload/sekolah/doc-lainnya') . '/' . $old;
                    break;
            }

            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            $response->data = view('situgu/ptk/absen/editupload', $data);
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
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Name tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar dan pdf. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('name')
                . $this->validator->getError('tw')
                . $this->validator->getError('id')
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

            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id = htmlspecialchars($this->request->getVar('id'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';

            switch ($name) {
                case 'bulan1':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen1';
                    break;
                case 'bulan2':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen2';
                    break;
                case 'bulan3':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen3';
                    break;
                case 'pembagian_tugas':
                    $dir = FCPATH . "upload/sekolah/pembagian-tugas";
                    $field_db = 'pembagian_tugas';
                    break;
                case 'slip_gaji':
                    $dir = FCPATH . "upload/sekolah/slip-gaji";
                    $field_db = 'slip_gaji';
                    break;
                default:
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    break;
            }

            $lampiran = $this->request->getFile('_file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_file($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data[$field_db] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_absen_kehadiran')->where(['id_tahun_tw' => $tw, 'id_ptk' => $id, 'is_locked' => 0])->update($data);
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
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
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

    public function editUploadSave()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'name' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Name tidak boleh kosong. ',
                ]
            ],
            'tw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tw tidak boleh kosong. ',
                ]
            ],
            'id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'old' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Old tidak boleh kosong. ',
                ]
            ],
            '_file' => [
                'rules' => 'uploaded[_file]|max_size[_file,2048]|mime_in[_file,image/jpeg,image/jpg,image/png,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu. ',
                    'max_size' => 'Ukuran file terlalu besar, Maximum 2Mb. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar dan pdf. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('name')
                . $this->validator->getError('tw')
                . $this->validator->getError('id')
                . $this->validator->getError('old')
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

            $name = htmlspecialchars($this->request->getVar('name'), true);
            $tw = htmlspecialchars($this->request->getVar('tw'), true);
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $old = htmlspecialchars($this->request->getVar('old'), true);

            $data = [
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = "";
            $field_db = '';

            switch ($name) {
                case 'bulan1':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen1';
                    break;
                case 'bulan2':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen2';
                    break;
                case 'bulan3':
                    $dir = FCPATH . "upload/sekolah/kehadiran";
                    $field_db = 'lampiran_absen3';
                    break;
                case 'pembagian_tugas':
                    $dir = FCPATH . "upload/sekolah/pembagian-tugas";
                    $field_db = 'pembagian_tugas';
                    break;
                case 'slip_gaji':
                    $dir = FCPATH . "upload/sekolah/slip-gaji";
                    $field_db = 'slip_gaji';
                    break;
                default:
                    $dir = FCPATH . "upload/sekolah/doc-lainnya";
                    $field_db = 'doc_lainnya';
                    break;
            }

            $lampiran = $this->request->getFile('_file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_file($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data[$field_db] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            $this->_db->transBegin();
            try {
                $this->_db->table('_absen_kehadiran')->where(['id_tahun_tw' => $tw, 'id_ptk' => $id, 'is_locked' => 0])->update($data);
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
                $this->_db->transCommit();

                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Data berhasil diupdate.";
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
}
