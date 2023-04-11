<?php

namespace App\Libraries\Situgu;

use App\Libraries\Uuid;

class Verifikasiadminlib
{
    private $_db;
    private $tb_setting;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_setting  = $this->_db->table('_tb_sptjm_verifikasi_pengawas');
    }

    public function create($user_id, $kode_usulan, $jenis_usulan, $id_ptks, $id_tahun_tw, $aksi, $keterangan = NULL)
    {
        $data = [
            'user_id' => $user_id,
            'id_ptks' => $id_ptks,
            'kode_usulan' => $kode_usulan,
            'id_tahun_tw' => $id_tahun_tw,
            'jenis_usulan' => $jenis_usulan,
            'is_locked' => 0,
            'generate_sptjm' => 0,
            'aksi' => $aksi,
            'keterangan' => $keterangan,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $uuidLib = new Uuid();
        $data['id'] = $uuidLib->v4();

        $this->_db->transBegin();
        try {
            $builder = $this->tb_setting->insert($data);
        } catch (\Throwable $th) {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Verifikasi.";
            return $response;
        }

        if ($this->_db->affectedRows() > 0) {
            $this->_db->transCommit();
            $response = new \stdClass;
            $response->status = 200;
            $response->data = $data;
            $response->message = "Verifikasi berhasil di simpan";
            return $response;
        } else {
            $this->_db->transRollback();
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal Menyimpan Verifikasi.";
            return $response;
        }
    }

    private function currentData($id_ptk, $id_tw)
    {
        return $this->tb_setting->where(['id_ptk' => $id_ptk, 'id_tahun_tw' => $id_tw])->get()->getRowObject();
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
