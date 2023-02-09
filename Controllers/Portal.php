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
}
