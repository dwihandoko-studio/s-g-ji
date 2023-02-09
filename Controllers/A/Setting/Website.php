<?php

namespace App\Controllers\A\Setting;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;

class Website extends BaseController
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
        $data['title'] = 'Managemen Website';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $oldData = $this->_db->table('_tb_web_information')->where('id', 1)->get()->getRowObject();
        if ($oldData) {
            $data['data'] = $oldData;
        }

        return view('a/setting/website/index', $data);
    }

    public function edit()
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
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $oldData = $this->_db->table('_tb_web_information')->where('id', 1)->get()->getRowObject();
        if ($oldData) {
            $data['data'] = $oldData;
        }

        $response = new \stdClass;
        $response->status = 200;
        $response->message = "Permintaan diizinkan";
        $response->data = view('a/setting/website/edit', $data);
        return json_encode($response);
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
            'judul' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong. ',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong. ',
                ]
            ],
            'alamat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            'telp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Telp tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                ]
            ],
            'facebook' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Facebook tidak boleh kosong. ',
                ]
            ],
            'twitter' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Twitter tidak boleh kosong. ',
                ]
            ],
            'instagram' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Instagram tidak boleh kosong. ',
                ]
            ],
            'maps' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Maps tidak boleh kosong. ',
                ]
            ],
            'maintenance' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Maintenance tidak boleh kosong. ',
                ]
            ],
            'warna' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Warna tidak boleh kosong. ',
                ]
            ],
            'thema' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Thema tidak boleh kosong. ',
                ]
            ],
            'css_map_googleapis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Maps css tidak boleh kosong. ',
                ]
            ],
            'js_map_googleapis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Maps css tidak boleh kosong. ',
                ]
            ],
        ];

        $filenamelampiran = dot_array_search('_file.name', $_FILES);
        if ($filenamelampiran != '') {
            $lampiranVal = [
                '_file' => [
                    'rules' => 'uploaded[_file]|max_size[_file,1024]|mime_in[_file,image/jpeg,image/jpg,image/png]',
                    'errors' => [
                        'uploaded' => 'Pilih logo terlebih dahulu. ',
                        'max_size' => 'Ukuran logo terlalu besar. ',
                        'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                    ]
                ],
            ];
            $rules = array_merge($rules, $lampiranVal);
        }

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('judul')
                . $this->validator->getError('deskripsi')
                . $this->validator->getError('alamat')
                . $this->validator->getError('telp')
                . $this->validator->getError('email')
                . $this->validator->getError('facebook')
                . $this->validator->getError('twitter')
                . $this->validator->getError('instagram')
                . $this->validator->getError('maps')
                . $this->validator->getError('maintenance')
                . $this->validator->getError('warna')
                . $this->validator->getError('thema')
                . $this->validator->getError('_file')
                . $this->validator->getError('js_map_googleapis')
                . $this->validator->getError('css_map_googleapis');
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

            $judul = htmlspecialchars($this->request->getVar('judul'), true);
            $deskripsi = htmlspecialchars($this->request->getVar('deskripsi'), true);
            $alamat = htmlspecialchars($this->request->getVar('alamat'), true);
            $telp = htmlspecialchars($this->request->getVar('telp'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);
            $facebook = htmlspecialchars($this->request->getVar('facebook'), true);
            $twitter = htmlspecialchars($this->request->getVar('twitter'), true);
            $instagram = htmlspecialchars($this->request->getVar('instagram'), true);
            $maps = htmlspecialchars($this->request->getVar('maps'), true);
            $maintenance = htmlspecialchars($this->request->getVar('maintenance'), true);
            $warna = htmlspecialchars($this->request->getVar('warna'), true);
            $thema = htmlspecialchars($this->request->getVar('thema'), true);
            $css_map_googleapis = htmlspecialchars($this->request->getVar('css_map_googleapis'), true);
            $js_map_googleapis = htmlspecialchars($this->request->getVar('js_map_googleapis'), true);

            if ($warna === "royalblue") {
                $warna = "blue";
            } else if ($warna === "#72b626") {
                $warna = "green";
            } else if ($warna === "#fa5b0f") {
                $warna = "orange";
            } else if ($warna === "#6957af") {
                $warna = "purple";
            } else if ($warna === "#ffb400") {
                $warna = "yellow";
            }

            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'alamat' => $alamat,
                'telp' => $telp,
                'email' => $email,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'instagram' => $instagram,
                'maps' => $maps,
                'maintenance' => $maintenance,
                'warna' => $warna,
                'thema' => $thema,
                'css_map_googleapis' => $css_map_googleapis,
                'js_map_googleapis' => $js_map_googleapis,
                'user_updated' => $user->data->uid,
            ];

            $current = $this->_db->table('_tb_web_information')
                ->where('id', 1)->get()->getRowObject();

            if ($current) {
                if (
                    $current->judul === $judul
                    && $current->deskripsi === $deskripsi
                    && $current->alamat === $alamat
                    && $current->telp === $telp
                    && $current->email === $email
                    && $current->facebook === $facebook
                    && $current->twitter === $twitter
                    && $current->instagram === $instagram
                    && $current->maps === $maps
                    && (int)$current->maintenance === (int)$maintenance
                    && $current->warna === $warna
                    && $current->thema === $thema
                    && $current->css_map_googleapis === $css_map_googleapis
                    && $current->js_map_googleapis === $js_map_googleapis
                ) {
                    if ($filenamelampiran == '') {
                        $response = new \stdClass;
                        $response->status = 201;
                        $response->message = "Tidak ada perubahan data yang disimpan.";
                        $response->redirect = base_url('a/setting/website');
                        return json_encode($response);
                    }
                }

                $dir = FCPATH . "uploads";

                if ($filenamelampiran != '') {
                    $lampiran = $this->request->getFile('_file');
                    $filesNamelampiran = $lampiran->getName();
                    $newNamelampiran = _create_name_foto($filesNamelampiran);

                    if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                        $lampiran->move($dir, $newNamelampiran);
                        $data['logo'] = $newNamelampiran;
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupload gambar.";
                        return json_encode($response);
                    }
                }

                $data['updated_at'] = date('Y-m-d H:i:s');

                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_web_information')->where('id', $current->id)->update($data);

                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->redirect = base_url('a/setting/website');
                        $response->message = "Informasi Website Berhasil Disimpan.";
                        return json_encode($response);
                    } else {
                        if ($filenamelampiran != '') {
                            unlink($dir . '/' . $newNamelampiran);
                        }
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data E.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    if ($filenamelampiran != '') {
                        unlink($dir . '/' . $newNamelampiran);
                    }
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data F.";
                    return json_encode($response);
                }
            } else {
                $data['id'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');

                $dir = FCPATH . "uploads";

                if ($filenamelampiran != '') {
                    $lampiran = $this->request->getFile('_file');
                    $filesNamelampiran = $lampiran->getName();
                    $newNamelampiran = _create_name_foto($filesNamelampiran);

                    if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                        $lampiran->move($dir, $newNamelampiran);
                        $data['logo'] = $newNamelampiran;
                    } else {
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal mengupload gambar.";
                        return json_encode($response);
                    }
                }

                $this->_db->transBegin();
                try {
                    $this->_db->table('_tb_web_information')->insert($data);

                    if ($this->_db->affectedRows() > 0) {
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->redirect = base_url('a/setting/website');
                        $response->message = "Informasi Website Berhasil Disimpan.";
                        return json_encode($response);
                    } else {
                        if ($filenamelampiran != '') {
                            unlink($dir . '/' . $newNamelampiran);
                        }
                        $this->_db->transRollback();
                        $response = new \stdClass;
                        $response->status = 400;
                        $response->message = "Gagal menyimpan data G.";
                        return json_encode($response);
                    }
                } catch (\Throwable $th) {
                    if ($filenamelampiran != '') {
                        unlink($dir . '/' . $newNamelampiran);
                    }
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal menyimpan data H.";
                    return json_encode($response);
                }
            }
        }
    }
}
