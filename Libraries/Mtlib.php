<?php

namespace App\Libraries;

class Mtlib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function get()
    {

        $user = $this->_db->table('_tb_maintenance')
            ->where('status', 1)
            ->countAllResults();

        if ($user > 0) {
            return true;
        }

        return false;
    }

    public function getAccess($userId)
    {

        $granted = $this->_db->table('granted_mt')
            ->where('id', $userId)
            ->countAllResults();

        if ($granted > 0) {
            return true;
        }

        return false;
    }
}
