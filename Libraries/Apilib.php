<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Apilib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    private function _send_get($methode, $jwt)
    {
        $urlendpoint = getenv('be.default.url') . $methode;
        $apiToken = getenv('be.default.api_token');

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'X-API-TOKEN: ' . $apiToken,
            'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

        return $curlHandle;
    }

    private function _send_post($data, $methode, $jwt)
    {
        $urlendpoint = getenv('be.default.url') . $methode;
        $apiToken = getenv('be.default.api_token');

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'X-API-TOKEN: ' . $apiToken,
            'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 120);


        return $curlHandle;
    }

    private function _send_post_upload($data, $methode, $jwt)
    {
        $urlendpoint = getenv('be.default.url') . $methode;
        $apiToken = getenv('be.default.api_token');

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'X-API-TOKEN: ' . $apiToken,
            'Authorization: Bearer ' . $jwt,
            // 'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 120);


        return $curlHandle;
    }

    public function getUser()
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $add         = $this->_send_get('user', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadMeninggal($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importmeninggal', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadGajiSipd($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importgajisipd', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanZakat($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importzakat', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanShodaqoh($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importshodaqoh', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanWajibKpn($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importwajibkpn', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanKpn($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "6",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importkpn', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBri($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "7",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbri', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBni($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "9",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbni', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankEkaBandar($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "1",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importekabandar', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankEkaMetro($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "2",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importekametro', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBpdBandar($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "3",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbpdbandar', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBpdKoga($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "4",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbpdkoga', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBpdMetro($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "10",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbpdmetro', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function uploadTagihanBankBpdKalirejo($tahun, $file)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun_bulan' => $tahun,
                'bank' => "5",
                'lampiran' => new CURLFile($file),
            ];

            $add         = $this->_send_post_upload($data, 'importbpdkalirejo', $jwt);

            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function downloadLaporanIsntansi($tahun, $instansi, $type)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun' => $tahun,
                'instansi' => $instansi,
            ];
            if ($type == "pdf") {
                $add         = $this->_send_post($data, 'exportlaporaninstansipdf', $jwt);
            } else {
                $add         = $this->_send_post($data, 'exportlaporaninstansi', $jwt);
            }
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function generatePotonganInfak($tahun)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun' => $tahun,
                'jenis_potongan' => 'infak',
            ];
            $add         = $this->_send_post($data, 'generatepotongan', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function generatePotonganDharmaWanita($tahun)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun' => $tahun,
                'jenis_potongan' => 'dharmawanita',
            ];
            $add         = $this->_send_post($data, 'generatepotongan', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function generatePotonganKorpri($tahun)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'tahun' => $tahun,
                'jenis_potongan' => 'korpri',
            ];
            $add         = $this->_send_post($data, 'generatepotongan', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function syncPtk($npsn, $tw)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'npsn' => $npsn,
                'tw' => $tw,
                'batas_tmt' => "2023-01-01",
            ];
            $add         = $this->_send_post($data, 'syncptk', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function syncPtkId($idPtk, $npsn, $tw)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'id_ptk' => $idPtk,
                'npsn' => $npsn,
                'tw' => $tw,
                'batas_tmt' => "2023-01-01",
            ];
            $add         = $this->_send_post($data, 'syncptkid', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPtkById($idPtk)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'id' => $idPtk,
            ];
            $add         = $this->_send_post($data, 'getptkid', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPtkByNuptk($idPtk)
    {
        $jwt = get_cookie('jwt');
        if ($jwt) {
            $data = [
                'nuptk' => $idPtk,
            ];
            $add         = $this->_send_post($data, 'getptknuptk', $jwt);
            $send_data         = curl_exec($add);

            $result = json_decode($send_data);


            if (isset($result->error)) {
                return false;
            }

            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
