<?php

namespace App\Controllers\Situgu;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Mtlib;

class Maintenance extends BaseController
{
    private $_db;

    function __construct()
    {
        helper(['text', 'file', 'form', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }
    public function index()
    {
        $mtLib = new Mtlib();
        if (!$mtLib->get()) {
            return redirect()->to(base_url('situgu'));
        }
        $data['title'] = "MAINTENANCE";
        $template = $this->_db->table('_tb_maintenance')->where('template_active', 1)->get()->getRowObject();
        if ($template) {
            if ($template->template !== null) {
                $activeTemplate = $template->template;
            } else {
                $activeTemplate = 'index';
            }
        } else {
            $activeTemplate = 'index';
        }
        return view('situgu/mt/' . $activeTemplate, $data);
    }
}
