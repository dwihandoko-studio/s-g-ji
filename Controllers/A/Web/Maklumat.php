<?php

namespace App\Controllers\A\Web;

use App\Controllers\BaseController;
use Config\Services;
use App\Libraries\Profilelib;

class Maklumat extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function index()
    {
        $data['title'] = 'Maklumat Instansi';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $oldData = $this->_db->table('_web_profil')->where('menu', 'maklumat')->get()->getRowObject();
        if ($oldData) {
            $data['data'] = $oldData;
        }

        return view('a/web/maklumat/index', $data);
    }

    public function edit()
    {
        $data['title'] = 'Ubah Maklumat Instansi';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $oldData = $this->_db->table('_web_profil')->where('menu', 'maklumat')->get()->getRowObject();
        if ($oldData) {
            $data['data'] = $oldData;
        }

        return view('a/web/maklumat/edit', $data);
    }

    public function save()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'isi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Content tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('isi');
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

            $isi = $this->request->getVar('isi');

            $isi = str_replace('<img src=', '<img style="max-width: 100%;" src=', $isi);

            $data = [
                'isi' => $isi,
                'menu' => 'maklumat',
                'url' => 'maklumat.html',
            ];

            $current = $this->_db->table('_web_profil')
                ->where('menu', 'maklumat')->get()->getRowObject();

            if ($current) {
                if ($current->isi === $isi) {
                    $response = new \stdClass;
                    $response->status = 201;
                    $response->redirect = base_url('a/web/maklumat');
                    $response->message = "Tidak ada perubahan data yang disimpan.";
                    return json_encode($response);
                }
                $data['user_updated'] = $user->data->uid;
                $data['updated_at'] = date('Y-m-d H:i:s');

                $this->_db->table('_web_profil')->where('id', $current->id)->update($data);

                if ($this->_db->affectedRows() > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->redirect = base_url('a/web/maklumat');
                    $response->message = "Maklumat Instansi Berhasil Disimpan.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            } else {
                $data['user_created'] = $user->data->uid;
                $data['created_at'] = date('Y-m-d H:i:s');

                $this->_db->table('_web_profil')->insert($data);

                if ($this->_db->affectedRows() > 0) {
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->redirect = base_url('a/web/maklumat');
                    $response->message = "Maklumat Instansi Berhasil Disimpan.";
                    return json_encode($response);
                } else {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data.";
                    return json_encode($response);
                }
            }
        }
    }

    public function uploadImage()
    {
        $validated = $this->validate([
            'upload' => [
                'uploaded[upload]',
                'max_size[upload, 1024]',
                'is_image[upload]',
            ],
        ]);

        if ($validated) {
            $lampiran = $this->request->getFile('upload');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_foto($filesNamelampiran);
            $writePath = FCPATH . "uploads/setting/widget";

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($writePath, $newNamelampiran);
                $data = [
                    "uploaded" => true,
                    "url" => base_url('uploads/setting/widget/' . $newNamelampiran),
                ];
            } else {
                $data = [
                    "uploaded" => false,
                    "error" => [
                        "message" => $lampiran
                    ],
                ];
            }
        } else {
            $data = [
                "uploaded" => false,
                "error" => [
                    "message" => $this->validator->getError('upload')
                ],
            ];
        }
        return $this->response->setJSON($data);
    }
}
