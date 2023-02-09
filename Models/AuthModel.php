<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class AuthModel
{
    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function getUsername($email)
    {
        return $this->db->table('_users_tb')->where('email', $email)->get()->getRowObject();
    }
}
