<?php

namespace App\Libraries\Situgu;

use App\Libraries\Uuid;

class Kehadiranptklib
{
    private $_db;
    private $tb_setting;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_setting  = $this->_db->table('_absen_kehadiran');
    }

    public function createUpdate($npsn, $id_ptk, $id_tw, $bulan_1 = 0, $bulan_2 = 0, $bulan_3 = 0)
    {
        $data = [
            'id_ptk' => $id_ptk,
            'npsn' => $npsn,
            'id_tahun_tw' => $id_tw,
            'bulan_1' => $bulan_1,
            'bulan_2' => $bulan_2,
            'bulan_3' => $bulan_3,
        ];

        $oldData = $this->currentData($id_ptk, $id_tw);

        if ($oldData) {
            return $this->update($data, $oldData->id);
        } else {
            return $this->create($data);
        }
    }

    private function currentData($id_ptk, $id_tw)
    {
        return $this->tb_setting->where(['id_ptk' => $id_ptk, 'id_tahun_tw' => $id_tw])->get()->getRowObject();
    }

    private function create($data)
    {
        $uuidLib = new Uuid();
        $data['id'] = $uuidLib->v4();
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->_db->transBegin();
        try {
            $builder = $this->tb_setting->insert($data);
        } catch (\Throwable $th) {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Absen Kehadiran.";
            return $response;
        }

        if ($this->_db->affectedRows() > 0) {
            $this->_db->transCommit();
            $response = new \stdClass;
            $response->status = 200;
            $response->data = $data;
            $response->message = "Absen Kehadiran berhasil di simpan";
            return $response;
        } else {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Absen Kehadiran.";
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
