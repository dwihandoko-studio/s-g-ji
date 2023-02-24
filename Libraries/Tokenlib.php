<?php

namespace App\Libraries;

class Tokenlib
{
    private $_db;
    private $tb_user;
    private $tb_profil_user;
    private $tb_token;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_token  = $this->_db->table('_token_activation_tb');
        $this->tb_profil_user  = $this->_db->table('_profil_users_tb');
    }

    private function _getUser($id)
    {
        return $this->tb_user->where(['id' => $id, 'email_verified' => 0])->get()->getRowObject();
    }

    private function _getUserInfo($id)
    {
        $select = "a.id, a.fullname, a.email, a.no_hp as noHp, a.profile_picture as imageProfile, a.role_user as roleUser, a.created_at as createdAt, a.updated_at as updated_at, a.last_active as lastActive, b.id as npsn, b.nama_sekolah as namaSekolah, b.alamat_sekolah as alamatSekolah, b.jenis_sekolah as statusSekolah, b.status_kepala_sekolah as statusKepalaSekolah, c.id as idKecamatan, c.nama_kecamatan as namaKecamatan";
        return $this->_db->table('_profil_users_tb a')
            ->select($select)
            ->join('_sekolah_tb b', 'a.npsn = b.id', 'LEFT')
            ->join('ref_kecamatan c', 'b.kecamatan = c.id', 'LEFT')
            ->where('a.id', $id)
            ->get()->getRowObject();
    }

    public function createTokenActivation($userId)
    {
        $token = random_string('alnum', 8);
        $data = [
            'user_id' => $userId,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->tb_token->insert($data);
        $response = $this->_db->affectedRows();
        if ($response > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function validationToken($id, $token)
    {
        $user = $this->tb_token->where(['user_id' => $id, 'token' => $token])->orderBy('id', 'DESC')->limit(1)->get()->getRowObject();

        if ($user) {
            // $today = date("Y-m-d H:i:s");  
            // $startdate = $user->created_at;   
            // $offset = strtotime("+7 day");
            // $enddate = date($startdate, $offset);    
            // $today_date = new \DateTime($today);
            // $expiry_date = new \DateTime($enddate);

            // var_dump($expiry_date);die;

            // if ($today < $enddate) {
            $response = new \stdClass;
            $response->code = 200;
            $response->user = $this->_getUserInfo($id);
            $response->message = "Aktivasi Akun Berhasil.";
            return $response;
            // } else {
            //     $response = new \stdClass;
            //     $response->code = 401;
            //     $response->message = "Kode aktivasi telah expired, silahkan request ulang.";
            //     return $response;
            // }

        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Kode aktivasi salah.";
            return $response;
        }
    }
}
