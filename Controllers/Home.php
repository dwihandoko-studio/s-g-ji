<?php

namespace App\Controllers;

use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Home extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
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
                    $userId = $decoded->data->id;
                    $level = $decoded->data->level;

                    // if ($level === 1) {
                    return redirect()->to(base_url('a/home'));
                    // } else if ($level === 2) {
                    //     return redirect()->to(base_url('sp/home'));
                    // } else if ($level === 3) {
                    //     return redirect()->to(base_url('bp/home'));
                    // } else {
                    //     return redirect()->to(base_url('p/home'));
                    // }
                } else {
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {

                return redirect()->to(base_url('auth'));
            }
        } else {

            return redirect()->to(base_url('auth'));
        }
        // $data = [];
        // $kategoris = $this->_db->table('_tb_kategori_buku')
        //     ->orderBy('kategori', 'asc')
        //     ->get()->getResult();

        // if (count($kategoris) > 0) {
        //     $data['kategories'] = $kategoris;
        // }
        // $bukus = $this->_db->table('_tb_buku a')
        //     ->select("a.*, b.kategori")
        //     ->join('_tb_kategori_buku b', 'a.k_id = b.kid')
        //     ->orderBy('nama_buku', 'asc')
        //     ->get()->getResult();

        // if (count($bukus) > 0) {
        //     $data['bukus'] = $bukus;
        // }

        // $Profilelib = new Profilelib();
        // $user = $Profilelib->user();
        // if ($user->status == 200) {
        //     $data['user_login'] = $user->data;
        // }

        // return view('toko/home', $data);
    }
}
