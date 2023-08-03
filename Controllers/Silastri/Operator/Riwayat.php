<?php

namespace App\Controllers\Silastri\Adm;

use App\Controllers\BaseController;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;

class Riwayat extends BaseController
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
        return redirect()->to(base_url('silastri/adm/riwayat/data'));
    }

    public function data()
    {
        $data['title'] = 'Riwayat Permohonan';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            delete_cookie('jwt');
            session()->destroy();
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        // $id = $this->_helpLib->getPtkId($user->data->id);
        // $data['notifs'] = $this->_db->table('_notification_tb a')
        //     ->select("a.*")
        //     ->where('a.send_to', $id)
        //     ->get()->getResult();
        return view('silastri/adm/riwayat/index', $data);
    }

    public function getNotifShowed()
    {
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

        $data['user'] = $user->data;
        $id = $this->_helpLib->getPtkId($user->data->id);
        $notifs = $this->_db->table('_notification_tb a')
            ->select("a.*, (SELECT count(*) FROM _notification_tb WHERE send_to = '$id' AND (readed = 0)) as jumlah, b.fullname, b.profile_picture as image_user")
            ->join('_profil_users_tb b', 'a.send_from = b.id', 'LEFT')
            ->where('a.send_to', $id)
            ->limit(5)
            ->orderBy('a.created_at', 'DESC')
            ->get()->getResult();

        if (count($notifs) > 0) {
            $x['datas'] = $notifs;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "success";
            $response->data = $notifs;
            $response->content = view('situgu/ptk/notification/pop', $x);
            $response->jumlah = $notifs[0]->jumlah;
            return json_encode($response);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Belum ada notifikasi.";
            $response->data = [];
            return json_encode($response);
        }
    }

    public function hapus()
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

            $current = $this->_db->table('_info_gtk')
                ->where('ptk_id', $id)->get()->getRowObject();

            if ($current) {
                $this->_db->transBegin();
                try {
                    $this->_db->table('_info_gtk')->where('ptk_id', $id)->delete();
                } catch (\Exception $e) {
                    $this->_db->transRollback();

                    $response = new \stdClass;
                    $response->status = 400;
                    $response->error = var_dump($e);
                    $response->message = "Gagal menghapus tautan Info GTK Digital.";
                    return json_encode($response);
                }

                if ($this->_db->affectedRows() > 0) {
                    createAktifitas($user->data->id, "Menghapus tautan Info GTK Digital", "Menghapus Tautan Info GTK Digital", "delete");
                    $this->_db->transCommit();
                    $response = new \stdClass;
                    $response->status = 200;
                    $response->message = "Info GTK Digital berhasil dihapus.";
                    return json_encode($response);
                } else {
                    $this->_db->transRollback();
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Gagal memhapus tautan Info GTK Digital.";
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
