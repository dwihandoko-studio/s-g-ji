<?php

namespace App\Libraries\Silastri;

use App\Libraries\Uuid;

class NotificationLib
{
    private $_db;
    private $tb_setting;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_setting  = $this->_db->table('_notification_tb');
    }

    public function create($judul, $isi, $token, $from, $to, $url)
    {
        $uuidLib = new Uuid();
        $data['id'] = $uuidLib->v4();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['judul'] = $judul;
        $data['isi'] = $isi;
        $data['token'] = $token;
        $data['send_from'] = $from;
        $data['send_to'] = $to;
        $data['readed'] = 0;
        $data['url'] = $url;

        // $this->_db->transBegin();
        try {
            $builder = $this->tb_setting->insert($data);
        } catch (\Throwable $th) {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Notification.";
            return $response;
        }

        if ($this->_db->affectedRows() > 0) {
            // $this->_db->transCommit();
            $response = new \stdClass;
            $response->status = 200;
            $response->data = $data;
            $response->message = "Notification berhasil di simpan";
            return $response;
        } else {
            // $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Notification.";
            return $response;
        }
    }

    private function update($data, $id)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->_db->transBegin();
        try {
            $builder = $this->tb_setting->where(['id' => $id, 'is_locked' => 0])->update($data);
        } catch (\Throwable $th) {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Mengupdate Absen Kehadiran.";
            return $response;
        }

        if ($this->_db->affectedRows() > 0) {
            $this->_db->transCommit();
            $response = new \stdClass;
            $response->status = 200;
            $response->data = $data;
            $response->message = "Absen Kehadiran berhasil di update";
            return $response;
        } else {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Mengupdate Absen Kehadiran.";
            return $response;
        }
    }

    public function getCurrentData($id)
    {
        return $this->tb_setting->where('id', $id)->get()->getRowObject();
    }
}
