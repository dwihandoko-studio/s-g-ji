<?php

namespace App\Controllers\Situgu\Opsr;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;

// header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Home extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function index()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $npsns = $this->_helpLib->getSekolahNaunganString($user->data->id);

        // var_dump($npsns);
        // die;

        $data['user'] = $user->data;
        $data['registered'] = $this->_db->table('_profil_users_tb')->select('surat_tugas')->where('id', $user->data->id)->get()->getRowObject();
        $data['title'] = 'Dashboard';
        $data['admin'] = true;
        $data['jumlah'] = $this->_db->table('_ptk_tb')
            ->select("(SELECT count(id) FROM _ptk_tb WHERE npsn IN (select npsn from ref_sekolah WHERE FIND_IN_SET(npsn, '" . $npsns . "') > 0)) as jumlah_ptk,
            (SELECT count(id) FROM _ptk_tb WHERE no_peserta IS NOT NULL AND npsn IN (select npsn from ref_sekolah WHERE FIND_IN_SET(npsn, '" . $npsns . "') > 0)) as jumlah_ptk_tpg,
            (SELECT count(id) FROM _ptk_tb WHERE npsn IN (select npsn from ref_sekolah WHERE FIND_IN_SET(npsn, '" . $npsns . "') > 0) AND no_peserta IS NULL AND nuptk IS NOT NULL AND (status_kepegawaian IN ('PNS', 'PPPK', 'CPNS', 'PNS Depag', 'PNS Diperbantukan'))) as jumlah_ptk_tamsil,
            (SELECT count(id) FROM _ptk_tb WHERE npsn IN (select npsn from ref_sekolah WHERE FIND_IN_SET(npsn, '" . $npsns . "') > 0) AND no_peserta IS NULL AND nuptk IS NOT NULL AND (status_kepegawaian IN ('Guru Honor Sekolah', 'Honor Daerah TK.I Provinsi', 'Honor Daerah TK.II Kab/Kota','GTY/PTY'))) as jumlah_ptk_pghm")
            // ->select("(SELECT count(b.id) FROM _ptk_tb b  WHERE b.npsn IN (select c.npsn from ref_sekolah c  WHERE FIND_IN_SET(c.npsn, '$npsns') > 0)) as jumlah_ptk, (SELECT count(d.id) FROM _ptk_tb d WHERE d.no_peserta IS NOT NULL AND d.npsn IN (select e.npsn from ref_sekolah e WHERE FIND_IN_SET(e.npsn, '$npsns') > 0)) as jumlah_ptk_tpg, (SELECT count(f.id) FROM _ptk_tb f WHERE f.npsn IN (select g.npsn from ref_sekolah g WHERE FIND_IN_SET(g.npsn, '$npsns') > 0) AND f.no_peserta IS NULL AND f.nuptk IS NOT NULL AND (f.status_kepegawaian IN ('PNS', 'PPPK', 'CPNS', 'PNS Depag', 'PNS Diperbantukan')) ) as jumlah_ptk_tamsil, (SELECT count(h.id) FROM _ptk_tb h WHERE h.npsn IN (select i.npsn from ref_sekolah i WHERE FIND_IN_SET(i.npsn, '$npsns') > 0) AND h.no_peserta IS NULL AND h.nuptk IS NOT NULL AND (h.status_kepegawaian IN ('Guru Honor Sekolah', 'Honor Daerah TK.I Provinsi', 'Honor Daerah TK.II Kab/Kota','GTY/PTY')) ) as jumlah_ptk_pghm")
            // ->where('a.id_kecamatan', $user->data->kecamatan)
            ->limit(1)
            ->get()->getRowObject();
        $data['cut_off_pengajuan'] = $this->_db->table('_setting_sptjm_tb')->get()->getResult();
        $data['cut_off_spj'] = $this->_db->table('_setting_upspj_tb')->get()->getResult();
        $data['informasis'] = $this->_db->table('_tb_infopop')->select("*, (SELECT count(*) FROM _tb_infopop WHERE tampil = 1 AND tujuan_role LIKE '%OPS%') as jumlah_all")->where("tampil = 1 AND tujuan_role LIKE '%OPS%'")->orderBy('created_at', 'DESC')->limit(5)->get()->getResult();

        return view('situgu/opsr/home/index', $data);
    }

    public function getAktivasi()
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

            if (!$user || $user->status !== 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session expired.";
                return json_encode($response);
            }

            if ($id == "admin") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/opsr/home/aktivasi/admin', $x);
                return json_encode($response);
            } else if ($id == "email") {
                $x['user'] = $user->data;
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Permintaan diizinkan";
                $response->data = view('situgu/opsr/home/aktivasi/email', $x);
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
        }
    }

    public function kirimAktivasi()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'jk' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis kelamin tidak boleh kosong. ',
                ]
            ],
            'nohp' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'No handphone tidak boleh kosong. ',
                ]
            ],
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong. ',
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|max_size[file,512]|is_image[file]',
                'errors' => [
                    'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
                    'max_size' => 'Ukuran gambar profil terlalu besar. ',
                    'is_image' => 'Ekstensi yang anda upload harus berekstensi gambar. '
                ]
            ],
            'surat_tugas' => [
                'rules' => 'uploaded[surat_tugas]|max_size[surat_tugas,2048]|mime_in[surat_tugas,image/jpeg,image/jpg,image/png,application/pdf]',
                'errors' => [
                    'uploaded' => 'Pilih gambar profil terlebih dahulu. ',
                    'max_size' => 'Ukuran gambar profil terlalu besar. ',
                    'mime_in' => 'Ekstensi yang anda upload harus berekstensi gambar atau pdf. '
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('jk')
                . $this->validator->getError('nohp')
                . $this->validator->getError('nip')
                . $this->validator->getError('surat_tugas')
                . $this->validator->getError('file');
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

            $jk = htmlspecialchars($this->request->getVar('jk'), true);
            $nohp = htmlspecialchars($this->request->getVar('nohp'), true);
            $nip = htmlspecialchars($this->request->getVar('nip'), true);

            $data = [
                'jenis_kelamin' => $jk,
                'no_hp' => $nohp,
                'nip' => $nip,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $dir = FCPATH . "upload/user";
            $dirSurat = FCPATH . "upload/surat-tugas";

            $lampiran = $this->request->getFile('file');
            $filesNamelampiran = $lampiran->getName();
            $newNamelampiran = _create_name_foto($filesNamelampiran);

            if ($lampiran->isValid() && !$lampiran->hasMoved()) {
                $lampiran->move($dir, $newNamelampiran);
                $data['profile_picture'] = $newNamelampiran;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload gambar.";
                return json_encode($response);
            }

            $lampiranSurat = $this->request->getFile('surat_tugas');
            $filesNamelampiranSurat = $lampiranSurat->getName();
            $newNamelampiranSurat = _create_name_foto($filesNamelampiranSurat);

            if ($lampiranSurat->isValid() && !$lampiranSurat->hasMoved()) {
                $lampiranSurat->move($dirSurat, $newNamelampiranSurat);
                $data['surat_tugas'] = $newNamelampiranSurat;
            } else {
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengupload file.";
                return json_encode($response);
            }

            $this->_db->transBegin();

            try {
                $this->_db->table('_profil_users_tb')->where('id', $user->data->id)->update($data);
            } catch (\Exception $e) {
                unlink($dir . '/' . $newNamelampiran);
                unlink($dirSurat . '/' . $newNamelampiranSurat);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengajukan verifikasi.";
                return json_encode($response);
            }
            if ($this->_db->affectedRows() > 0) {
                $this->_db->transCommit();
                $response = new \stdClass;
                $response->status = 200;
                $response->message = "Akun berhasil diajukan untuk diverifikasi.";
                return json_encode($response);
            } else {
                unlink($dir . '/' . $newNamelampiran);
                unlink($dirSurat . '/' . $newNamelampiranSurat);
                $this->_db->transRollback();
                $response = new \stdClass;
                $response->status = 400;
                $response->message = "Gagal mengajukan verifikasi.";
                return json_encode($response);
            }
        }
    }
}
