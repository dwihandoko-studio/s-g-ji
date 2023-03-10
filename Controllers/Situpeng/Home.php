<?php

namespace App\Controllers\Situpeng;

use App\Controllers\BaseController;
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
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    switch ($level) {
                        case 1:
                            return redirect()->to(base_url('situpeng/su/home'));
                        case 2:
                            return redirect()->to(base_url('situpeng/adm/home'));
                        case 8:
                            return redirect()->to(base_url('situgu/peng/home'));
                        default:
                            return redirect()->to(base_url('portal'));
                    }
                } else {
                    return redirect()->to(base_url('auth'));
                }
            } catch (\Exception $e) {

                return redirect()->to(base_url('auth'));
            }
        } else {

            return redirect()->to(base_url('auth'));
        }
    }
}
