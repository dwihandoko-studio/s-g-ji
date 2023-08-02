<?php

namespace App\Controllers\Silastri\Peng;

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

    public function getAllPengaduan()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $datas = $this->_db->table('riwayat_pengaduan a')
            // ->select("a.*, (SELECT count(*) FROM _notification_tb WHERE send_to = '$id' AND (readed = 0)) as jumlah, b.fullname, b.profile_picture as image_user")
            // ->join('_profil_users_tb b', 'a.send_from = b.id', 'LEFT')
            ->where('a.user_id', $user->data->id)
            ->limit(5)
            ->orderBy('a.created_at', 'DESC')
            ->get()->getResult();

        if (count($datas) > 0) {
            $x['datas'] = $datas;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "success";
            $response->data = $datas;
            return json_encode($response);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Belum ada riwayat.";
            $response->data = [];
            return json_encode($response);
        }
    }

    public function getAllPermohonan()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $datas = $this->_db->table('riwayat_permohonan a')
            // ->select("a.*, (SELECT count(*) FROM _notification_tb WHERE send_to = '$id' AND (readed = 0)) as jumlah, b.fullname, b.profile_picture as image_user")
            // ->join('_profil_users_tb b', 'a.send_from = b.id', 'LEFT')
            ->where('a.user_id', $user->data->id)
            ->limit(5)
            ->orderBy('a.created_at', 'DESC')
            ->get()->getResult();

        if (count($datas) > 0) {
            $x['datas'] = $datas;
            $response = new \stdClass;
            $response->status = 200;
            $response->message = "success";
            $response->data = $datas;
            return json_encode($response);
        } else {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Belum ada riwayat.";
            $response->data = [];
            return json_encode($response);
        }
    }

    public function index()
    {
        return redirect()->to(base_url('silastri/peng/riwayat/data'));
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
        return view('silastri/peng/riwayat/index', $data);
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
}
