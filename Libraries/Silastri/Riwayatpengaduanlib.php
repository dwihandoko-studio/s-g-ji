<?php

namespace App\Libraries\Silastri;

use App\Libraries\Uuid;

class Riwayatpengaduanlib
{
    private $_db;
    private $tb_setting;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_setting  = $this->_db->table('riwayat_pengaduan');
    }

    public function create($userId, $keterangan, $aksi, $icon, $url_detail, $idPengaduan)
    {
        $uuidLib = new Uuid();
        $data['id'] = $uuidLib->v4();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['keterangan'] = $keterangan;
        $data['user_id'] = $userId;
        $data['aksi'] = $aksi;
        $data['icon'] = $icon;
        $data['url_detail'] = $url_detail;
        $data['id_pengaduan'] = $idPengaduan;

        // $this->_db->transBegin();
        try {
            $builder = $this->tb_setting->insert($data);
        } catch (\Throwable $th) {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Riwayat.";
            return $response;
        }

        if ($this->_db->affectedRows() > 0) {
            // $this->_db->transCommit();
            $response = new \stdClass;
            $response->status = 200;
            $response->data = $data;
            $response->message = "Riwayat berhasil di simpan";
            return $response;
        } else {
            // $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Riwayat.";
            return $response;
        }
    }

    public function getCurrentData($id)
    {
        return $this->tb_setting->where('id', $id)->get()->getRowObject();
    }
}
