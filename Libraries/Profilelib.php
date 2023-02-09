<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Profilelib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function user()
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;

                    $user = $this->_db->table('v_user')
                        ->where('id', $userId)
                        ->get()->getRowObject();
                    if ($user) {
                        $response = new \stdClass;
                        $response->status = 200;
                        $response->data = $user;
                    } else {
                        $response = new \stdClass;
                        $response->status = 401;
                        $response->message = "User tidak ditemukan.";
                    }
                } else {
                    $response = new \stdClass;
                    $response->status = 401;
                    $response->message = "Session telah habis.";
                }
            } catch (\Exception $e) {

                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis.";
            }
        } else {
            $response = new \stdClass;
            $response->status = 401;
            $response->message = "Session telah habis.";
        }

        return $response;
    }
}
