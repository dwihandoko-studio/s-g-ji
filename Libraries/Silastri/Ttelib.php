<?php

namespace App\Libraries\Silastri;

use setasign\Fpdi\Tcpdf\Fpdi;

class CREATEPDF extends FPDI
{
    public function Footer()
    {
        $this->SetY(-10);
        $logo = 'UU ITE NO. 11 tahun 2008 Pasal 5 ayat 1 "Informasi elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah".';
        $logo1 = "Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik, Badan Siber dan Sandi Negara.";

        $this->SetFont('helvetica', 'I', 8);
        $this->Image($this->CustomFooterText, $this->w - 10 - 20, $this->GetY() - 15, 20, 20, 'PNG', '', 'T', false, 200, '', false, false, 1, true, false, false);
        $this->SetX($this->w - 10 - 15 - 20); // documentRightMargin = 18
        $this->MultiCell($this->w - 10 - 15 - 40 - 10, 30, "\n\n\n" . $logo1, 0, 'R', 0, '', 40, $this->GetY(), true);
    }
}

class Ttelib
{
    private $_db;
    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
    }

    public function createTte($data, $path, $sertificate, $privateSertificate, $passwordPrivateSertificate, $outputName, $contentCreator, $info)
    {

        $dataUser = $this->_db->table('_profil_users_tb')->where('id', session()->get('id_user'))->get()->getRowObject();

        if (!$dataUser) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = "Gagal mengambil informasi user.";
            return $response;
        }

        $pdf = new CREATEPDF('silat'); // Array sets the X, Y dimensions in mm
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($contentCreator['author']);
        $pdf->SetTitle($contentCreator['title']);
        $pdf->SetSubject($contentCreator['subject']);
        $pdf->SetKeywords($contentCreator['keyword']);
        $pagecount = $pdf->setSourceFile($path . '/' . $data->dokumen);

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {

            $tplIdx = $pdf->importPage($pageNo);

            $size = $pdf->getTemplateSize($tplIdx);

            $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
            $pdf->useTemplate($tplIdx);

            $posisiW = (int)$data->nilai_x;
            $posisiH = (($size['height'] - 42.678) - 15) - ((int)$data->nilai_y - 14.99);

            if ((int)$pageNo == (int)$data->poses_halaman_tte) {
                try {
                    $pdf->setSignature($sertificate, $privateSertificate, $passwordPrivateSertificate, '', 1, $info);
                } catch (\Exception $e) {
                    $response = new \stdClass;
                    $response->code = 400;
                    $response->message = "Password untuk tte tidak sesuai.";
                    return $response;
                }
                $pdf->Image('/www/wwwroot/tte.lampungtengahkab.go.id/dev/public/upload/sample/sample-tte.jpeg', $posisiW, $posisiH, 76.59, 42.678, "JPEG"); // X start, Y start, X width, Y width in mm

                $pdf->setSignatureAppearance($posisiW, $posisiH, 76.59, 42.678);
            }
        }

        $namaDokumentTte = _create_name_dokumen_tte($outputName);

        $pdf->Output($path . "/telah_ditandatangani/" . $namaDokumentTte, 'F');

        $fileDocNya = $pdf->Output($namaDokumentTte, 'E');

        $response = new \stdClass;
        $response->code = 200;
        $response->data = base64_encode($fileDocNya);
        return $response;
    }

    public function createImageTteFile($dokument, $path, $outputName, $contentCreator, $images)
    {
        $pdf = new FPDI(); // Array sets the X, Y dimensions in mm
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($contentCreator['author']);
        $pdf->SetTitle($contentCreator['title']);
        $pdf->SetSubject($contentCreator['subject']);
        $pdf->SetKeywords($contentCreator['keyword']);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pagecount = $pdf->setSourceFile($dokument);

        for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
            $tplIdx = $pdf->importPage($pageNo);

            $size = $pdf->getTemplateSize($tplIdx);

            $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

            $pdf->useTemplate($tplIdx);

            $posisiX = (int)$images->x;
            $posisiY = (($size['height'] - 42.678) - 15) - ((int)$images->y - 14.99);

            if ((int)$pageNo == (int)$images->poses_halaman_tte) {
                $pdf->Image($images->path . '/' . $images->name, $posisiX, $posisiY, $images->width, $images->height, "JPEG"); // X start, Y start, X width, Y width in mm

            }
        }

        $pdf->Output($path . "/" . $outputName, 'F');

        $response = new \stdClass;
        $response->code = 200;
        return $response;
    }

    public function createUploadFile($dokument, $path, $outputName, $contentCreator, $url)
    {
        $pdf = new CREATEPDF(); // Array sets the X, Y dimensions in mm
        $pdf->CustomFooterText = $url;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($contentCreator['author'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetTitle($contentCreator['title'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetSubject($contentCreator['subject'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetKeywords($contentCreator['keyword'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(true);
        try {
            $pagecount = $pdf->setSourceFile($dokument);
        } catch (\Throwable $th) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = var_dump($th);
            return $response;
        }

        try {

            for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
                $tplIdx = $pdf->importPage($pageNo);

                $size = $pdf->getTemplateSize($tplIdx);
                $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
                $pdf->useTemplate($tplIdx);

                $pageWidth = $pdf->GetPageWidth();
                $imageX = $pageWidth - 90; // Mengatur posisi gambar dari kanan
                $imageY = $pdf->GetPageHeight() - 79; // Mengatur posisi gambar dari atas
                $imageWidth = 75; // Mengatur lebar gambar
                $imageHeight = 50; // Mengatur tinggi gambar
                $pdf->Image(FCPATH . "upload/my-image-tte.png", $imageX, $imageY, $imageWidth, $imageHeight);
            }

            $pdf->Output($path . "/" . $outputName, 'F');
        } catch (\Throwable $th) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = var_dump($th);
            return $response;
        }

        $response = new \stdClass;
        $response->code = 200;
        $response->data = $outputName;
        return $response;
    }

    public function createUploadFileGenerate($dokument, $path, $outputName, $contentCreator, $url)
    {
        $pdf = new CREATEPDF(); // Array sets the X, Y dimensions in mm
        $pdf->CustomFooterText = $url;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($contentCreator['author'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetTitle($contentCreator['title'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetSubject($contentCreator['subject'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetKeywords($contentCreator['keyword'] ?? "TTE Kabupaten Lampung Tengah");
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(true);
        try {
            $pagecount = $pdf->setSourceFile($dokument);
        } catch (\Throwable $th) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = var_dump($th);
            return $response;
        }

        try {

            for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
                $tplIdx = $pdf->importPage($pageNo);

                $size = $pdf->getTemplateSize($tplIdx);
                $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
                $pdf->useTemplate($tplIdx);

                // $pageWidth = $pdf->GetPageWidth();
                // $imageX = $pageWidth - 90; // Mengatur posisi gambar dari kanan
                // $imageY = $pdf->GetPageHeight() - 79; // Mengatur posisi gambar dari atas
                // $imageWidth = 75; // Mengatur lebar gambar
                // $imageHeight = 50; // Mengatur tinggi gambar
                // $pdf->Image(FCPATH . "upload/my-image-tte.png", $imageX, $imageY, $imageWidth, $imageHeight);
            }

            $pdf->Output($path . "/" . $outputName, 'F');
        } catch (\Throwable $th) {
            $response = new \stdClass;
            $response->code = 400;
            $response->message = var_dump($th);
            return $response;
        }

        $response = new \stdClass;
        $response->code = 200;
        $response->data = $outputName;
        return $response;
    }
}
