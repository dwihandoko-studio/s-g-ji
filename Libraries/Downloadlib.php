<?php

namespace App\Libraries;

use PhpOffice\PhpWord\PhpWord;
use mPDF;

class Downloadlib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'session', 'cookie', 'file', 'array', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function download($path, $name)
    {

        $phpWord = new PhpWord();
        $template = $phpWord->loadTemplate($path);

        $html = $template->getMarkup();
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        return $mpdf->Output($name, 'D');
    }

    public function downloaded($path, $name)
    {
        $dir = FCPATH . "upload/generate/sptjm/tamsil/pdf";
        sleep(3);
        try {
            if (exec('libreoffice --headless --convert-to pdf ' . $path . ' --outdir ' . $dir, $output, $retval)) {
                // if (exec('libreoffice --headless --convert-to pdf ' . $dirUploadWord . '/' . $newNamelampiran . ' --outdir ' . $dir, $output, $retval)) {
                $file = $dir . '/' . $name;
                // $this->response->setHeader('Content-Type', 'application/octet-stream');
                // $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $name . '"');
                // $this->response->setHeader('Content-Length', filesize($file));
                return $file;


                // return $this->response->sendFile($file);
            } else {
                $response = new \stdClass;
                $response->code = 400;
                $response->message = "Gagal convert file.";
                return json_encode($response);
            }
        } catch (\Exception $err) {
            $response = new \stdClass;
            $response->code = 400;
            $response->error = var_dump($err);
            $response->message = "Gagal convert file.";
            return json_encode($response);
        }
    }
}
