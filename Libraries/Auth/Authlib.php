<?php

namespace App\Libraries\Auth;

class Authlib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
    }


    private function _send_post($data, $methode)
    {
        $urlendpoint = getenv('be.default.url') . $methode;
        $apiToken = getenv('be.default.api_token');

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'X-API-TOKEN: ' . $apiToken,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);


        return $curlHandle;
    }

    private function _send_post_upload($data, $methode)
    {
        $urlendpoint = getenv('apibsre.default.url') . $methode;

        //var_dump($urlendpoint);
        // $accessToken = session()->get('accessToken');

        $curlHandle = curl_init($urlendpoint);
        // curl_setopt($curlHandle, CURLOPT_UPLOAD, false);
        // curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        // curl_setopt($curlHandle, CURLOPT_HEADER, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode(getenv('apibsre.default.user') . ":" . getenv('apibsre.default.secret')),
            'Content-Type:multipart/form-data'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 12000);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 12000);


        return $curlHandle;
    }

    private function _send_get($methode)
    {
        $urlendpoint = getenv('apibsre.default.url') . $methode;

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            // 'Authorization: Bearer ' . $accessToken
            'Authorization: Basic ' . base64_encode(getenv('apibsre.default.user') . ":" . getenv('apibsre.default.secret'))
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 1200);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 1200);

        return $curlHandle;
    }

    public function cekStatusUser($nik)
    {
        $add         = $this->_send_get("api/user/status/{$nik}");
        $send_data         = curl_exec($add);

        if (!curl_errno($add)) {
            $info = curl_getinfo($add);
            curl_close($add);
            switch ($http_code = $info['http_code']) {

                case 200:  # OK
                    return json_decode($send_data);
                    break;
                case 401:
                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = "Authorization ke sdk gagal.";
                    return $response;
                    break;
                case 404:
                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "NOT_FOUND";
                    $response->message = "Url tidak ditemukan.";
                    return $response;
                default:
                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = "Server sedang sibuk, silahkan ulangi beberapa saat lagi.";
                    return $response;
            }
        } else {
            curl_close($add);
            $response = new \stdClass;
            $response->code = 400;
            $response->message = $add;
            return $response;
        }

        // var_dump($send_data); die;

        // $result = json_decode($send_data);
        // if (isset($result->error)) {
        //     return false;
        // }

        // if ($send_data != "false") {
        //     return $result;
        // } else {
        //     return false;
        // }
    }

    public function signDocument($data)
    {
        $add         = $this->_send_post_upload($data, 'api/sign/pdf');
        $headers = [];
        curl_setopt(
            $add,
            CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))] = trim($header[1]);

                return $len;
            }
        );
        $send_data         = curl_exec($add);

        $httpCodeCure = curl_getinfo($add, CURLINFO_HTTP_CODE);

        if (!curl_errno($add)) {
            $info = curl_getinfo($add);
            $header_size = $info['header_size'];
            // $header = substr($send_data, 0, $header_size);
            $body = substr($send_data, $header_size);
            // var_dump($info); die;
            curl_close($add);
            switch ($http_code = $info['http_code']) {

                case 200:  # OK
                    $headerConvert = json_decode(json_encode($headers));
                    $dataFile = new \stdClass;
                    $dataFile->idDokumen = $headerConvert->id_dokumen;
                    $dataFile->dokumen = $send_data;

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = $info['http_code'];
                    $response->status = "SUCCESS";
                    $response->header = $headerConvert;
                    $response->data = $dataFile;
                    $response->message = "Dokument Berhasil ditandatangani.";
                    return $response;
                    break;
                    // return json_decode($send_data);
                    // break;
                case 401:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
                    break;
                case 404:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "NOT_FOUND";
                    $response->message = $result->error;
                    return $response;
                default:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
            }
        } else {
            $inputLogGagal = new \stdClass;
            $inputLogGagal->body = curl_errno($add);

            // $historyBsrelib = new Historybsrelib();
            try {
                $datalog = [
                    'log' => json_encode($inputLogGagal),
                    'user_eksekusi' => session()->get('id_user'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->_db->table('__log_error_bsre')->insert($datalog);
            } catch (Exception $a) {
            }

            curl_close($add);
            $response = new \stdClass;
            $response->code = 400;
            $response->status = "ERROR";
            $response->message = $inputLogGagal->body . " . HTTP_CODE:" . $httpCodeCure;
            return $response;
        }

        // 

        // $result = json_decode($send_data);
        // if (isset($result->error)) {
        //     return false;
        // }

        // if ($send_data != "false") {
        //     return $result;
        // } else {
        //     return false;
        // }
    }

    public function downloadDocument($token)
    {
        $add         = $this->_send_get("api/sign/download//{$token}");
        $headers = [];
        curl_setopt(
            $add,
            CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))] = trim($header[1]);

                return $len;
            }
        );
        $send_data         = curl_exec($add);

        if (!curl_errno($add)) {
            $info = curl_getinfo($add);
            $header_size = $info['header_size'];
            // $header = substr($send_data, 0, $header_size);
            $body = substr($send_data, $header_size);
            // var_dump($info); die;
            curl_close($add);
            switch ($http_code = $info['http_code']) {

                case 200:  # OK
                    $headerConvert = json_decode(json_encode($headers));
                    $dataFile = new \stdClass;
                    $dataFile->idDokumen = $headerConvert->id_dokumen;
                    $dataFile->dokumen = $send_data;

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = $info['http_code'];
                    $response->status = "SUCCESS";
                    $response->header = $headerConvert;
                    $response->data = $dataFile;
                    $response->message = "Dokument Berhasil didownload.";
                    return $response;
                    break;
                    // return json_decode($send_data);
                    // break;
                case 401:
                    $headerConvert = json_decode(json_encode($headers));

                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;
                    // $inputLogGagal->body = $body;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }


                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
                    break;
                case 404:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "NOT_FOUND";
                    $response->message = $result->error;
                    return $response;
                default:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
            }
        } else {
            $inputLogGagal = new \stdClass;
            $inputLogGagal->body = curl_errno($add);

            // $historyBsrelib = new Historybsrelib();
            try {
                $datalog = [
                    'log' => json_encode($inputLogGagal),
                    'user_eksekusi' => session()->get('id_user'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->_db->table('__log_error_bsre')->insert($datalog);
            } catch (Exception $a) {
            }

            curl_close($add);
            $response = new \stdClass;
            $response->code = 400;
            $response->status = "ERROR";
            $response->message = curl_errno($add);
            return $response;
        }
    }

    public function verifiPdf($data)
    {
        $add         = $this->_send_post_upload($data, 'api/sign/verify');
        $headers = [];
        curl_setopt(
            $add,
            CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))] = trim($header[1]);

                return $len;
            }
        );
        $send_data         = curl_exec($add);
        // var_dump($send_data);die;

        $httpCodeCure = curl_getinfo($add, CURLINFO_HTTP_CODE);

        if (!curl_errno($add)) {
            $info = curl_getinfo($add);
            $header_size = $info['header_size'];
            // $header = substr($send_data, 0, $header_size);
            $body = substr($send_data, $header_size);
            $bodyContent = json_decode($send_data);
            curl_close($add);
            switch ($http_code = $info['http_code']) {

                case 200:  # OK
                    $headerConvert = json_decode(json_encode($headers));

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = $info['http_code'];
                    $response->status = "SUCCESS";
                    $response->header = $headerConvert;
                    $response->data = $bodyContent;
                    $response->message = "Dokument Berhasil diverifikasi.";
                    return $response;
                    break;
                    // return json_decode($send_data);
                    // break;
                case 401:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (\Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
                    break;
                case 404:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (\Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "NOT_FOUND";
                    $response->message = $result->error;
                    return $response;
                default:
                    $headerConvert = json_decode(json_encode($headers));
                    $inputLogGagal = new \stdClass;
                    $inputLogGagal->header = $headerConvert;

                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $inputLogGagal->body = $result->error;
                    }

                    // $historyBsrelib = new Historybsrelib();
                    try {
                        $datalog = [
                            'log' => json_encode($inputLogGagal),
                            'user_eksekusi' => session()->get('id_user'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $this->_db->table('__log_error_bsre')->insert($datalog);
                    } catch (\Exception $a) {
                    }

                    $response = new \stdClass;
                    $response->code = $info['http_code'];
                    $response->status_code = 1000;
                    $response->status = "UNAUTHORIZED";
                    $response->message = $result->error;
                    return $response;
            }
        } else {
            $inputLogGagal = new \stdClass;
            $inputLogGagal->body = curl_errno($add);

            // $historyBsrelib = new Historybsrelib();
            try {
                $datalog = [
                    'log' => json_encode($inputLogGagal),
                    'user_eksekusi' => session()->get('id_user'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->_db->table('__log_error_bsre')->insert($datalog);
            } catch (\Exception $a) {
            }

            curl_close($add);
            $response = new \stdClass;
            $response->code = 400;
            $response->status = "ERROR";
            $response->message = $inputLogGagal->body . " . HTTP_CODE:" . $httpCodeCure;
            return $response;
        }
    }


    public function getRefWilayahLuarKabupaten($kode)
    {
        $add         = $this->_send_get("getWilayah?kode_wilayah=120200&token=CD04B72E-17EB-4C2D-9421-DCF4240C7138&mst_kode_wilayah=$kode");
        $send_data         = curl_exec($add);

        if (!curl_errno($add)) {
            switch ($http_code = curl_getinfo($add, CURLINFO_HTTP_CODE)) {

                case 200:  # OK
                    $result = json_decode($send_data);
                    if (isset($result->error)) {
                        $response = new \stdClass;
                        $response->code = 400;
                        $response->message = $result->error;
                        return $response;
                    }

                    if ($send_data != "false") {
                        $response = new \stdClass;
                        $response->code = 200;
                        $response->data = $result;
                        return $response;
                    } else {
                        $response = new \stdClass;
                        $response->code = 400;
                        $response->message = $result->error;
                        return $response;
                    }

                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = $add;
            return $response;
        }

        // var_dump($send_data); die;

        $result = json_decode($send_data);
        if (isset($result->error)) {
            return false;
        }

        if ($send_data != "false") {
            return $result;
        } else {
            return false;
        }
    }




    public function postLogin($username, $password)
    {
        $data = [
            'username' => $username,
            'password' => $password,
        ];
        $add         = $this->_send_post($data, "login");
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

        // $headers = [];
        // curl_setopt(
        //     $add,
        //     CURLOPT_HEADERFUNCTION,
        //     function ($curl, $header) use (&$headers) {
        //         $len = strlen($header);
        //         $header = explode(':', $header, 2);
        //         if (count($header) < 2) // ignore invalid headers
        //             return $len;

        //         $headers[strtolower(trim($header[0]))] = trim($header[1]);

        //         return $len;
        //     }
        // );
        // $send_data         = curl_exec($add);

        // $httpCodeCure = curl_getinfo($add, CURLINFO_HTTP_CODE);

        // if (!curl_errno($add)) {
        //     $info = curl_getinfo($add);
        //     $header_size = $info['header_size'];
        //     // $header = substr($send_data, 0, $header_size);
        //     $body = substr($send_data, $header_size);
        //     // var_dump($info); die;
        //     curl_close($add);
        //     switch ($http_code = $info['http_code']) {

        //         case 200:  # OK
        //             $headerConvert = json_decode(json_encode($headers));
        //             $dataFile = new \stdClass;
        //             $dataFile->idDokumen = $headerConvert->id_dokumen;
        //             $dataFile->dokumen = $send_data;

        //             $response = new \stdClass;
        //             $response->code = $info['http_code'];
        //             $response->header = $headerConvert;
        //             $response->data = $send_data;
        //             return $response;
        //             break;
        //             // return json_decode($send_data);
        //             // break;
        //         case 401:
        //             $headerConvert = json_decode(json_encode($headers));
        //             $inputLogGagal = new \stdClass;
        //             $inputLogGagal->header = $headerConvert;

        //             $result = json_decode($send_data);
        //             $response = new \stdClass;
        //             $response->code = $info['http_code'];
        //             $response->status = "UNAUTHORIZED";
        //             $response->message = $result->error;
        //             return $response;
        //             break;
        //         case 404:
        //             $headerConvert = json_decode(json_encode($headers));
        //             $inputLogGagal = new \stdClass;
        //             $inputLogGagal->header = $headerConvert;

        //             $result = json_decode($send_data);

        //             $response = new \stdClass;
        //             $response->code = $info['http_code'];
        //             $response->status = "NOT_FOUND";
        //             $response->message = $result->error;
        //             return $response;
        //         default:
        //             $headerConvert = json_decode(json_encode($headers));
        //             $inputLogGagal = new \stdClass;
        //             $inputLogGagal->header = $headerConvert;

        //             $result = json_decode($send_data);

        //             $response = new \stdClass;
        //             $response->code = $info['http_code'];
        //             $response->status = "UNAUTHORIZED";
        //             $response->message = $result->error;
        //             return $response;
        //     }
        // } else {
        //     $err = curl_errno($add);

        //     curl_close($add);
        //     $response = new \stdClass;
        //     $response->code = 400;
        //     $response->status = "ERROR";
        //     $response->message = $err . " . HTTP_CODE:" . $httpCodeCure;
        //     return $response;
        // }
    }

    public function profileUser($userId, $accessToken, $refreshToken)
    {
        $add         = $this->_send_get("profiluser/detail?id=" . $userId, $accessToken, $refreshToken);
        $send_data         = curl_exec($add);

        // var_dump($send_data);die;

        $result = json_decode($send_data);
        if (isset($result->error)) {
            if ($result->error == "invalid_token" && $result->error_description == "The access token provided has expired") {
                $refreshed = $this->_requestRefreshToken($refreshToken);
                if ($refreshed != false) {
                    $addRetry         = $this->_send_get("profiluser/detail?id=" . $userId, $refreshed->access_token, $refreshed->refresh_token);
                    $send_data_retry         = curl_exec($addRetry);

                    $resultRetry = json_decode($send_data_retry);
                    if (isset($resultRetry->error)) {
                        return false;
                    }
                    if ($send_data_retry != "false") {
                        $resultRetry->access_token = $refreshed->access_token;
                        $resultRetry->refresh_token = $refreshed->refresh_token;
                        return $resultRetry;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        if ($send_data != "false") {
            $result->access_token = $accessToken;
            $result->refresh_token = $refreshToken;
            return $result;
        } else {
            return false;
        }
    }


    private function _send_refresh_token($data, $methode)
    {
        $urlendpoint = getenv('api.default.url') . "v1/" . $methode;

        //var_dump($urlendpoint);

        $curlHandle = curl_init($urlendpoint);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic dGVzdGNsaWVudDp0ZXN0c2NyZXQ='
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);


        return $curlHandle;
    }

    private function _requestRefreshToken($refreshToken)
    {
        $data = [
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token'
        ];
        $add         = $this->_send_refresh_token($data, "user/login");
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
    }
}
