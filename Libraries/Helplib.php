<?php

namespace App\Libraries;

class Helplib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function getSekolahNaungan($userId)
    {

        $user = $this->_db->table('sekolah_naungan')
            ->select("npsn")
            ->where('user_id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return explode(",", $user->npsn);
        }

        return [];
    }

    public function getSekolahNaunganString($userId)
    {

        $user = $this->_db->table('sekolah_naungan')
            ->select("npsn")
            ->where('user_id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->npsn;
        }

        return '';
    }

    public function getSekolahKecamatanString($kecamatan, $listLevel)
    {

        $user = $this->_db->table('ref_sekolah')
            ->select("npsn")
            ->where('kode_kecamatan', $kecamatan)
            ->whereIn('bentuk_pendidikan_id', $listLevel)
            ->get()->getResult();

        if (count($user) > 0) {
            $npsn = "";
            foreach ($user as $key => $value) {
                if ($key === 0) {
                    $npsn .= $value->npsn;
                } else {
                    $npsn .= "," . $value->npsn;
                }
            }
            return $npsn;
        }

        return '';
    }

    public function getSekolahKecamatanArray($kecamatan, $listLevel)
    {

        $user = $this->_db->table('ref_sekolah')
            ->select("npsn")
            ->where('kode_kecamatan', $kecamatan)
            ->whereIn('bentuk_pendidikan_id', $listLevel)
            ->get()->getResult();

        if (count($user) > 0) {
            $npsn = [];
            foreach ($user as $key => $value) {
                $npsn[] = $value->npsn;
            }
            return $npsn;
        }

        return [];
    }

    public function getNaunganPengawasArray($id_user)
    {

        $user = $this->_db->table('__pengawas_tb')
            ->select("guru_naungan")
            ->where("id = (SELECT ptk_id FROM v_user_pengawas where id = '$id_user')")
            ->get()->getRowObject();

        if ($user) {
            $gurus = explode(",", $user->guru_naungan);
            if (count($gurus) > 0) {
                return $gurus;
            }
            return ['nulle'];
        }

        return ['nulle'];
    }

    public function getNaunganPengawasSekolahArray($id_user)
    {

        $user = $this->_db->table('__pengawas_tb')
            ->select("npsn_naungan")
            ->where("id = (SELECT ptk_id FROM v_user_pengawas where id = '$id_user')")
            ->get()->getRowObject();

        if ($user) {
            $gurus = explode(",", $user->npsn_naungan);
            if (count($gurus) > 0) {
                return $gurus;
            }
            return ['nulle'];
        }

        return ['nulle'];
    }

    public function getCurrentTw()
    {

        $user = $this->_db->table('_ref_tahun_tw')
            ->select("id")
            ->where('is_current', 1)
            ->get()->getRowObject();

        if ($user) {
            return $user->id;
        }

        return false;
    }

    public function getNpsn($userId)
    {

        $user = $this->_db->table('_profil_users_tb')
            ->select("npsn")
            ->where('id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->npsn;
        }

        return false;
    }

    public function getKecamatan($userId)
    {

        $user = $this->_db->table('_profil_users_tb')
            ->select("kecamatan")
            ->where('id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->kecamatan;
        }

        return false;
    }

    public function getPengawasId($userId)
    {

        $user = $this->_db->table('v_user_pengawas a')
            ->select("a.ptk_id, b.id")
            ->where('a.id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->ptk_id;
        }

        return false;
    }

    public function getPtkId($userId)
    {

        $user = $this->_db->table('_profil_users_tb a')
            ->select("a.ptk_id, b.id")
            ->join('_ptk_tb b', 'a.ptk_id = b.id_ptk', 'LEFT')
            ->where('a.id', $userId)
            ->get()->getRowObject();

        if ($user) {
            return $user->id;
        }

        return false;
    }

    public function nilaiTamsil()
    {
        $val = $this->_db->table('ref_gaji')
            ->select('gaji_pokok')
            ->where('pangkat', 'tamsil')
            ->get()->getRowObject();

        if ($val) {
            return $val->gaji_pokok;
        }

        return 0;
    }

    public function nilaiPghm()
    {
        $val = $this->_db->table('ref_gaji')
            ->select('gaji_pokok')
            ->where('pangkat', 'pghm')
            ->get()->getRowObject();

        if ($val) {
            return $val->gaji_pokok;
        }

        return 0;
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
