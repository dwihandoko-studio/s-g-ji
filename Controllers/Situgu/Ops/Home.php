<?php

namespace App\Controllers\Situgu\Ops;

use App\Controllers\BaseController;
use App\Libraries\Profilelib;
use App\Libraries\Helplib;

// header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
class Home extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function index()
    {
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();

        if (!$user || $user->status !== 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;
        $data['title'] = 'Dashboard';
        $data['admin'] = true;
        $data['jumlah'] = $this->_db->table('_ptk_tb a')
            ->select("a.id, (SELECT count(id_ptk) FROM _ptk_tb WHERE npsn = a.npsn) as jumlah_ptk, (SELECT count(id_ptk) FROM _ptk_tb WHERE npsn = a.npsn AND no_peserta IS NOT NULL) as jumlah_ptk_tpg, (SELECT count(id_ptk) FROM _ptk_tb WHERE npsn = a.npsn AND no_peserta IS NULL AND nuptk IS NOT NULL AND (status_kepegawaian IN ('PNS', 'PPPK', 'CPNS', 'PNS Depag', 'PNS Diperbantukan')) ) as jumlah_ptk_tamsil, (SELECT count(id_ptk) FROM _ptk_tb WHERE npsn = a.npsn AND no_peserta IS NULL AND nuptk IS NOT NULL AND (status_kepegawaian IN ('Guru Honor Sekolah', 'Honor Daerah TK.I Provinsi', 'Honor Daerah TK.II Kab/Kota','GTY/PTY')) ) as jumlah_ptk_pghm")
            ->where('a.npsn', $user->data->npsn)
            ->get()->getRowObject();
        $data['cut_off_pengajuan'] = $this->_db->table('_setting_sptjm_tb')->get()->getResult();
        $data['cut_off_spj'] = $this->_db->table('_setting_upspj_tb')->get()->getResult();
        $data['informasis'] = $this->_db->table('_tb_infopop')->select("*, (SELECT count(*) FROM _tb_infopop WHERE tampil = 1 AND tujuan_role LIKE '%OPS%') as jumlah_all")->where("tampil = 1 AND tujuan_role LIKE '%OPS%'")->orderBy('created_at', 'DESC')->limit(5)->get()->getResult();

        return view('situgu/ops/home/index', $data);
    }
}
