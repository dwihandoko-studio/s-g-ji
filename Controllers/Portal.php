<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Portal extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                    $layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans.json"), true);

                    $Profilelib = new Profilelib();
                    $user = $Profilelib->user();

                    if (!$user || $user->status !== 200) {
                        session()->destroy();
                        delete_cookie('jwt');
                        return redirect()->to(base_url('auth'));
                    }
                    $data['user'] = $user->data;

                    $data['title'] = "Portal Layanan";
                    $data['level'] = $level;
                    $data['layanans'] = $layanan['layanans'];
                    // var_dump($user->data)
                    $data['completeAccount'] = ($user->data->kk == NULL || $user->data->kk == "") ? false : true;
                    return view('portal/index', $data);
                } else {
                    session()->destroy();
                    delete_cookie('jwt');
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {
                session()->destroy();
                delete_cookie('jwt');
                return redirect()->to(base_url('auth'));
            }
        } else {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }
    }

    public function getCompletedAccount()
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
                $response->message = "Session telah habis.";
                return json_encode($response);
            }

            $data['data'] = $user->data;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "Permintaan diizinkan";
            switch ($id) {
                case 'lengkapi':
                    $data['kecamatans'] = $this->_db->table('ref_kecamatan')->orderBy('kecamatan', 'ASC')->get()->getResult();
                    if ($user->data->kelurahan == NULL || $user->data->kelurahan == "") {
                    } else {
                        $data['kelurahans'] = $this->_db->table('ref_kelurahan')->where('id_kecamatan', $user->data->kecamatan)->orderBy('kelurahan', 'ASC')->get()->getResult();
                    }
                    $data['pekerjaans'] = $this->_db->table('_profil_users_tb')->select("pekerjaan, count(pekerjaan) as jumlah")->groupBy('pekerjaan')->orderBy('pekerjaan', 'ASC')->get()->getResult();
                    $response->data = view('portal/edit-account', $data);
                    break;
                case 'password':
                    $response->data = view('portal/password', $data);
                    break;
                case 'foto':
                    $response->data = view('portal/foto', $data);
                    break;
                case 'aktivasi_wa':
                    $response->data = view('portal/aktivasi_wa', $data);
                    break;
                case 'aktivasi_email':
                    $response->data = view('portal/aktivasi_email', $data);
                    break;

                default:
                    $response->data = view('portal/edit-account', $data);
                    break;
            }

            return json_encode($response);
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
                    'required' => 'Id buku tidak boleh kosong. ',
                ]
            ],
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong. ',
                ]
            ],
            'nik' => [
                'rules' => 'required|trim|min_length[16]',
                'errors' => [
                    'required' => 'NIK tidak boleh kosong. ',
                    'min_length' => 'NIK harus 16 karakter. ',
                ]
            ],
            'kk' => [
                'rules' => 'required|trim|min_length[16]',
                'errors' => [
                    'required' => 'KK tidak boleh kosong. ',
                    'min_length' => 'KK harus 16 karakter. ',
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tempat lahir tidak boleh kosong. ',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong. ',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis kelamin tidak boleh kosong. ',
                ]
            ],
            'kecamatan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kecamatan tidak boleh kosong. ',
                ]
            ],
            'kelurahan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kelurahan tidak boleh kosong. ',
                ]
            ],
            'pekerjaan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pekerjaan tidak boleh kosong. ',
                ]
            ],
            'alamat' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Alamat tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No Handphone tidak boleh kosong. ',
                ]
            ],
            'email' => [
                'rules' => 'required|trim|valid_email',
                'errors' => [
                    'required' => 'Email tidak boleh kosong. ',
                    'valid_email' => 'Email tidak valid. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('nama')
                . $this->validator->getError('id')
                . $this->validator->getError('nik')
                . $this->validator->getError('kk')
                . $this->validator->getError('tempat_lahir')
                . $this->validator->getError('tgl_lahir')
                . $this->validator->getError('jenis_kelamin')
                . $this->validator->getError('kecamatan')
                . $this->validator->getError('kelurahan')
                . $this->validator->getError('pekerjaan')
                . $this->validator->getError('alamat')
                . $this->validator->getError('email')
                . $this->validator->getError('nohp');
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

            $id = htmlspecialchars($this->request->getVar('id'), true);
            $nama = htmlspecialchars($this->request->getVar('nama'), true);
            $nik = htmlspecialchars($this->request->getVar('nik'), true);
            $kk = htmlspecialchars($this->request->getVar('kk'), true);
            $tempat_lahir = htmlspecialchars($this->request->getVar('tempat_lahir'), true);
            $tgl_lahir = htmlspecialchars($this->request->getVar('tgl_lahir'), true);
            $jk = htmlspecialchars($this->request->getVar('jenis_kelamin'), true);
            $kecamatan = htmlspecialchars($this->request->getVar('kecamatan'), true);
            $kelurahan = htmlspecialchars($this->request->getVar('kelurahan'), true);
            $pekerjaan = htmlspecialchars($this->request->getVar('pekerjaan'), true);
            $alamat = htmlspecialchars($this->request->getVar('alamat'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $email = htmlspecialchars($this->request->getVar('email'), true);

            $oldDataProfile =  $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->get()->getRowObject();

            if ($oldDataProfile) {
                $dataUserProfil = [
                    'fullname' => $nama,
                    'nik' => $nik,
                    'kk' => $kk,
                    'tempat_lahir' => $tempat_lahir,
                    'tgl_lahir' => $tgl_lahir,
                    'jenis_kelamin' => $jk,
                    'kecamatan' => $kecamatan,
                    'kelurahan' => $kelurahan,
                    'pekerjaan' => $pekerjaan,
                    'alamat' => $alamat,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->_db->transBegin();

                try {
                    $this->_db->table('_profil_users_tb')->where('id', $oldDataProfile->id)->update($dataUserProfil);
                } catch (\Exception $e) {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal mengupdate data.";
                    return json_encode($response);
                }
                if ($this->_db->affectedRows() > 0) {
                    if ($email !== $oldDataProfile->email) {
                        $cekExistEmail = $this->_db->table('_users_tb')->where('email', $email)->countAllResults();
                        if ($cekExistEmail > 0) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "Email sudah terdaftar.";
                            return json_encode($response);
                        }
                    }

                    if ($nik !== $oldDataProfile->nik) {
                        $cekExistNik = $this->_db->table('_users_tb')->where('nik', $nik)->countAllResults();
                        if ($cekExistNik > 0) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "NIK sudah terdaftar.";
                            return json_encode($response);
                        }
                    }
                    if ($nohp !== $oldDataProfile->no_hp) {
                        $cekExistNohp = $this->_db->table('_users_tb')->where(['no_hp' => $nohp, 'wa_verified' => 1])->countAllResults();
                        if ($cekExistNohp > 0) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->message = "No handphone sudah terdaftar.";
                            return json_encode($response);
                        }
                    }

                    if ($nik === $oldDataProfile->nik && $email === $oldDataProfile->email && $nohp !== "" && $nohp === $oldDataProfile->no_hp) {
                        $this->_db->transCommit();
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->message = "Data berhasil diupdate.";
                        return json_encode($response);
                    } else {
                        try {
                            $this->_db->table('_users_tb')->where('id', $oldDataProfile->id)->update([
                                'email' => $email,
                                'nik' => $nik,
                                'no_hp' => $nohp,
                                'updated_at' => $dataUserProfil['updated_at'],
                            ]);
                        } catch (\Exception $e) {
                            $this->_db->transRollback();
                            $response = new \stdClass;
                            $response->status = 400;
                            $response->error = var_dump($e);
                            $response->message = "Gagal mengupdate data.";
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
                            $response->message = "Gagal mengupate data profil";
                            return json_encode($response);
                        }
                    }
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal mengupate data profil";
                    return json_encode($response);
                }
            } else {

                $response = new \stdClass;
                $response->status = 400;
                $response->message = "User tidak ditemukan.";
                return json_encode($response);
            }
        }
    }
}
