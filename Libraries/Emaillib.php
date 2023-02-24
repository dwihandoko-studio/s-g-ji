<?php

namespace App\Libraries;

use App\Libraries\Tokenlib;

class Emaillib
{
    private $_db;
    private $tb_user;
    private $tb_profil_user;
    function __construct()
    {
        helper(['text', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->tb_user  = $this->_db->table('_users_tb');
        $this->tb_profil_user  = $this->_db->table('_profil_users_tb');
    }

    private function _getUser($email)
    {
        return $this->tb_user->where(['email' => $email, 'email_verified' => 0])->get()->getRowObject();
    }

    private function _sendEmail($emailTo, $title, $content)
    {
        $email = \Config\Services::email();
        $email->setFrom('noreplay.disdikbud@lampungtengahkab.go.id', 'SI-TUGU DISDIKBUD KAB. LAMPUNG TENGAH');
        // $email->setFrom('utpg.disdikbud.lamteng@kntechline.id', 'SI-UTPG DISDIKBUD KAB. LAMPUNG TENGAH');
        $email->setTo($emailTo);

        $email->setSubject($title);
        $email->setMessage($content);

        $sendd = $email->send();

        if ($sendd) {
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "Kode Aktivasi berhasil dikirim.";
            return $response;
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = $email->printDebugger();
            return $response;
        }
    }

    private function _sendEmailNotifikasi($emailTo, $title, $content)
    {
        $email = \Config\Services::email();
        $email->setFrom('noreplay.disdikbud@lampungtengahkab.go.id', 'SI-TUGU DISDIKBUD KAB. LAMPUNG TENGAH');
        // $email->setFrom('utpg.disdikbud.lamteng@kntechline.id', 'SI-UTPG DISDIKBUD KAB. LAMPUNG TENGAH');
        $email->setTo($emailTo);

        $email->setSubject($title);
        $email->setMessage($content);

        $sendd = $email->send();

        if ($sendd) {
            $response = new \stdClass;
            $response->code = 200;
            $response->message = "Email notifikasi berhasil dikirim.";
            return $response;
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = $email->printDebugger();
            return $response;
        }
    }

    public function sendActivation($email, $token)
    {
        $user = $this->_getUser($email);

        if ($user) {
            // $tokenLib = new Tokenlib();
            // $token = $tokenLib->createTokenActivation($user->id);

            // if ($token) {
            $content = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                            
                            <tbody><tr>
                                <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                    <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Halo ' . $email . '</h1>
                                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        Anda telah memasukkan alamat surat elektronik (surel) <strong><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></strong> sebagai kontak untuk akun SI-TUGU DISDIKBUD Kab. Lampung Tengah.
                                        Untuk menyelesaikan proses ini, kami akan melakukan verifikasi untuk memastikan bahwa surel ini milik anda.
                                    </p>

                                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        Kode untuk memverifikasi email akun SI-TUGU anda adalah sebagai berikut :
                                    </p>

                                    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
                                        <tbody><tr>
                                            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                    <tbody><tr>
                                                        <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                            <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                <tbody><tr>
                                                                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;font-size:18px;color: white;background-color: black; padding: 20px;">
                                                                        ' . $token . '
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>

                                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        Mengapa saya terima email ini?<br>
                                        Email ini dikirimkan jika seseroang atau perubahan terjadi atas akun SI-TUGU.
                                        Jika anda tidak melakukan perubahan apapun, jangan khawatir.
                                        Akun email anda tidak dapat digunakan sebagai kontak dalam akun SI-TUGU tanpa verifikasi yang anda lakukan
                                    </p>

                                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                        Terima kasih,<br>
                                        Tim SI-TUGU<br>
                                        DISDIKBUD<br>
                                        Kab. Lampung Tengah
                                    </p>

                                </td>
                            </tr>
                        </tbody></table>';
            // $content = "Silahkan masukkan kode aktivasi akun ini : <br><div style='display: inline-block;width: 200px;background-color: #000; padding: 5px;color: #fff;text-align: center;font-size: 15px;'><b>" . $token['token'] . "</b></div>";

            $sended = $this->_sendEmail($user->email, "Kode Aktivasi Akun", $content);

            if ($sended->code == 200) {
                $response = new \stdClass;
                $response->code = 200;
                $response->data = $sended;
                $response->user = $user;
                return $response;
            } else {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Gagal mengirim kode aktivasi.";
                return $response;
            }
            //     } else {
            //         $response = new \stdClass;
            //         $response->code = 400;
            //         $response->message = "Gagal membuat token.";
            //         return $response;
            //     }
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Email tidak terdaftar, silahkan hubungi admin.";
            return $response;
        }
    }

    public function sendNotifikasi($email, $judul, $text = '')
    {
        $content = '<table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                
                <tbody><tr>
                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Halo ' . $email . '</h1>
                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                            Anda telah memasukkan alamat surat elektronik (surel) <strong><a href="mailto:' . $email . '" target="_blank">' . $email . '</a></strong> sebagai kontak untuk akun SI-TUGU DISDIKBUD Kab. Lampung Tengah.
                        </p>';

        $content    .=  $text;

        $content    .=  '<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                            Terima kasih,<br>
                            Tim SI-TUGU<br>
                            DISDIKBUD<br>
                            Kab. Lampung Tengah
                        </p>

                    </td>
                </tr>
            </tbody></table>';

        $sended = $this->_sendEmailNotifikasi($email, $judul, $content);

        if ($sended->code == 200) {
            $response = new \stdClass;
            $response->code = 200;
            $response->data = $sended;
            return $response;
        } else {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Gagal mengirim notifikasi.";
            $response->error = $sended->message;
            return $response;
        }
    }
}
