<?php

namespace App\Controllers\Silastri\Peksos\Assesment;

use App\Controllers\BaseController;
use App\Models\Silastri\Peksos\Assesment\SelesaiModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Profilelib;
use App\Libraries\Apilib;
use App\Libraries\Helplib;
use App\Libraries\Uuid;
use App\Libraries\Silastri\Riwayatpengaduanlib;
use iio\libmergepdf\Merger;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\TemplateProcessor;

class Selesai extends BaseController
{
    var $folderImage = 'masterdata';
    private $_db;
    private $model;
    private $_helpLib;

    function __construct()
    {
        helper(['text', 'file', 'form', 'session', 'array', 'imageurl', 'web', 'filesystem']);
        $this->_db      = \Config\Database::connect();
        $this->_helpLib = new Helplib();
    }

    public function getAll()
    {
        $request = Services::request();
        $datamodel = new SelesaiModel($request);

        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        // $bidangs = getBidangNaungan($user->data->id);

        $lists = $datamodel->get_datatables($user->data->nik);
        $data = [];
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $row = [];

            $row[] = $no;
            // $action = '<div class="btn-group">
            //             <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
            //             <div class="dropdown-menu" style="">
            //                 <a class="dropdown-item" href="javascript:actionDetail(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama) . '\');"><i class="bx bxs-show font-size-16 align-middle"></i> &nbsp;Detail</a>
            //                 <a class="dropdown-item" href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><i class="bx bx-transfer-alt font-size-16 align-middle"></i> &nbsp;Sync Dapodik</a>
            //             </div>
            //         </div>';
            $action = '<a href="javascript:actionDownload(\'' . $list->id . '\', \'' . $list->kode_aduan . '\', \'' . $list->jenis . '\');"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                <i class="mdi mdi-cloud-download font-size-16 align-middle"></i> Download</button>
                </a>';
            //     <a href="javascript:actionSync(\'' . $list->id . '\', \'' . $list->id_ptk . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk  . '\', \'' . $list->npsn . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-transfer-alt font-size-16 align-middle"></i></button>
            //     </a>
            //     <a href="javascript:actionHapus(\'' . $list->id . '\', \'' . str_replace("'", "", $list->nama)  . '\', \'' . $list->nuptk . '\');" class="delete" id="delete"><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
            //     <i class="bx bx-trash font-size-16 align-middle"></i></button>
            //     </a>';
            $row[] = $action;
            $row[] = $list->jenis;
            $row[] = $list->kode_aduan;
            $row[] = $list->nik_orang_assesment;
            $row[] = $list->nama_orang_assesment;

            $data[] = $row;
        }
        $output = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $datamodel->count_all($user->data->nik),
            "recordsFiltered" => $datamodel->count_filtered($user->data->nik),
            "data" => $data
        ];
        echo json_encode($output);
    }

    public function index()
    {
        return redirect()->to(base_url('silastri/peksos/assesment/selesai/data'));
    }

    public function data()
    {
        $data['title'] = 'Data Asesment Pengaduan Layanan PPKS';
        $Profilelib = new Profilelib();
        $user = $Profilelib->user();
        if ($user->status != 200) {
            session()->destroy();
            delete_cookie('jwt');
            return redirect()->to(base_url('auth'));
        }

        $data['user'] = $user->data;

        // $data['jeniss'] = ['Pengaduan Program Bantuan Sosial', 'Pengaduan Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)', 'Pengaduan Layanan Sosial', 'Lainnya'];

        return view('silastri/peksos/assesment/selesai/index', $data);
    }

    // public function download()
    // {
    //     if ($this->request->getMethod() != 'post') {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = "Permintaan tidak diizinkan";
    //         return json_encode($response);
    //     }

    //     $rules = [
    //         'id' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Id tidak boleh kosong. ',
    //             ]
    //         ],
    //         'kode' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Kode tidak boleh kosong. ',
    //             ]
    //         ],
    //         'jenis' => [
    //             'rules' => 'required|trim',
    //             'errors' => [
    //                 'required' => 'Jenis tidak boleh kosong. ',
    //             ]
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         $response = new \stdClass;
    //         $response->status = 400;
    //         $response->message = $this->validator->getError('id')
    //             . $this->validator->getError('kode')
    //             . $this->validator->getError('jenis');
    //         return json_encode($response);
    //     } else {
    //         $id = htmlspecialchars($this->request->getVar('id'), true);
    //         $kode = htmlspecialchars($this->request->getVar('kode'), true);
    //         $jenis = htmlspecialchars($this->request->getVar('jenis'), true);

    //         $Profilelib = new Profilelib();
    //         $user = $Profilelib->user();
    //         if ($user->status != 200) {
    //             session()->destroy();
    //             delete_cookie('jwt');
    //             $response = new \stdClass;
    //             $response->status = 401;
    //             $response->message = "Session telah habis";
    //             return json_encode($response);
    //         }

    //         $oldData = $this->_db->table('_data_assesment')->where('id', $id)->get()->getRowObject();
    //         if (!$oldData) {
    //             $response = new \stdClass;
    //             $response->status = 400;
    //             $response->message = "Data tidak ditemukan.";
    //             return json_encode($response);
    //         }

    //         $response = new \stdClass;
    //         $response->status = 200;
    //         $response->redirrect = base_url('silastri/peksos/pengaduan/selesai');
    //         $response->filenya = base_url('upload/generate/surat/pdf') . '/' . $oldData->kode_assesment . ".pdf";
    //         $response->filename = $oldData->kode_assesment . ".pdf";
    //         $response->message = "Assesment Pengaduan / Layanan " . $oldData->kode_assesment . " berhasil didownload.";
    //         return json_encode($response);
    //     }
    // }

    public function download()
    {
        if ($this->request->getMethod() != 'post') {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Permintaan tidak diizinkan";
            return json_encode($response);
        }

        $rules = [
            'id' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Id tidak boleh kosong. ',
                ]
            ],
            'kode' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Kode tidak boleh kosong. ',
                ]
            ],
            'jenis' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Jenis tidak boleh kosong. ',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $response = new \stdClass;
            $response->status = 400;
            $response->message = $this->validator->getError('id')
                . $this->validator->getError('kode')
                . $this->validator->getError('jenis');
            return json_encode($response);
        } else {
            $id = htmlspecialchars($this->request->getVar('id'), true);
            $kode = htmlspecialchars($this->request->getVar('kode'), true);
            $jenis = htmlspecialchars($this->request->getVar('jenis'), true);

            $Profilelib = new Profilelib();
            $user = $Profilelib->user();
            if ($user->status != 200) {
                session()->destroy();
                delete_cookie('jwt');
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Session telah habis";
                return json_encode($response);
            }
            $dataAssesment = $this->_db->table('_data_assesment')->where("id = '$id' AND (status > 0)")->get()->getRowArray();
            if (!$dataAssesment) {
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }
            $dataTindakLanjut = $this->_db->table('_pengaduan_tanggapan_ppks')->where("id = '$id'")->get()->getRowArray();
            if (!$dataTindakLanjut) {
                $response = new \stdClass;
                $response->status = 401;
                $response->message = "Data tidak ditemukan";
                return json_encode($response);
            }

            if ($dataAssesment['jenis'] == "PENGADUAN PPKS") {
                $oldData = $this->_db->table('_pengaduan a')
                    ->select("a.*,b.peserta_spt, b.tgl_spt, b.lokasi_spt, b.kode_aduan as kode")
                    ->join('_pengaduan_tanggapan_spt b', 'b.id = a.id')
                    // ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                    // ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                    ->where(['a.id' => $id])->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pengaduan tidak ditemukan.";
                    return json_encode($response);
                }
            } else {
                $oldData = $this->_db->table('_permohonan a')
                    ->select("a.*,b.peserta_spt, b.tgl_spt, b.lokasi_spt, b.kode_aduan as kode")
                    ->join('_pengaduan_tanggapan_spt b', 'b.id = a.id')
                    // ->join('ref_kecamatan c', 'c.id = a.kecamatan')
                    // ->join('ref_kelurahan d', 'd.id = a.kelurahan')
                    ->where(['a.id' => $id])->get()->getRowObject();

                if (!$oldData) {
                    $response = new \stdClass;
                    $response->status = 400;
                    $response->message = "Pengaduan tidak ditemukan.";
                    return json_encode($response);
                }
            }

            $dataPetugas = getPetugasFromNik($user->data->nik);
            $spt = json_decode($oldData->peserta_spt);

            $petugasTerlibatss = $this->_db->table('ref_sdm')
                ->select("nik, nip, nama, jabatan, kelurahan")
                ->whereIn('nik', $spt)
                ->get()->getResult();

            $generateDokumen = $this->_download($user, $dataAssesment['date_assesment'], $dataTindakLanjut, $dataAssesment, json_decode($dataAssesment['bansos_orang_assesment']), json_decode($dataAssesment['bansos_pengampu_assesment']), json_decode($dataAssesment['skor_assesment']), $dataAssesment['skor_total'], $oldData, json_decode($dataTindakLanjut['kepersertaan_bansos']), $dataPetugas, $petugasTerlibatss, $dataAssesment['lampiran']);

            if ($generateDokumen->status !== 200) {
                $response = new \stdClass;
                $response->status = 400;
                $response->eror = $generateDokumen->message;
                $response->message = "1. Gagal mengassesment aduan " . $oldData->kode_aduan;
                return json_encode($response);
            }

            $response = new \stdClass;
            $response->status = 200;
            $response->redirrect = base_url('silastri/peksos/assesment/selesai');
            $response->filenya = base_url('upload/generate/surat/pdf') . '/' . $generateDokumen->filename;
            $response->filename = $generateDokumen->filename;
            $response->message = "Assesment Pengaduan / Layanan " . $oldData->kode . " berhasil didownload.";
            return json_encode($response);
        }
    }

    private function _download($user, $tgl_assesment, $dataTindakLanjut, $dataAssesment, $bansosIdentitas, $bansosPengampu, $skor_assesment, $skor_total, $oldData, $kepersertaan_bansos, $dataPetugas, $petugasTerlibat, $lampiran = "")
    {
        $file = FCPATH . "upload/template/nota-assesmen.docx";
        $template_processor = new TemplateProcessor($file);
        $template_processor->setValue('NAMA_PETUGAS_ASSESMENT', $user->data->fullname);
        $template_processor->setValue('TGL_ASSESMENT', tgl_indo($tgl_assesment));

        $tembusan = [];
        if ($dataTindakLanjut['tembusan_dinas'] !== NULL) {
            $tembusan[] = 'Kepala Dinas ' . getNamaDinas($dataTindakLanjut['tembusan_dinas']);
        }
        if ($dataTindakLanjut['tembusan_camat'] !== NULL) {
            $tembusan[] = 'Camat ' . getNamaKecamatan($dataTindakLanjut['tembusan_camat']);
        }
        if ($dataTindakLanjut['tembusan_kampung'] !== NULL) {
            $tembusan[] = 'Kepala Kampung/Lurah ' . getNamaKelurahan($dataTindakLanjut['tembusan_kampung']);
        }
        $tembusan[] = 'Kepada Yang Bersangkutan <i>(Pelapor)</i>';

        $tembusanFix = [];
        foreach ($tembusan as $keyTT => $vT) {
            $tembusanFix[] = [
                'TEMBUSAN' => ($keyTT + 1) . ". " . $vT,
            ];
            // 'nt' => $keyTT + 1,
            // 'tembusan' => $vT,
        }
        $template_processor->cloneRowAndSetValues('TEMBUSAN', $tembusanFix);

        // $template_processor->setValue('TEMBUSAN', $tembusan == "" || $tembusan == NULL ? "-" : $tembusan);
        $template_processor->setValue('NAMA_PPKS', $dataAssesment['nama_orang_assesment'] == "" || $dataAssesment['nama_orang_assesment'] == NULL ? "-" : $dataAssesment['nama_orang_assesment']);
        $template_processor->setValue('KODE_PENGADUAN', $oldData->kode ?? "-");
        $template_processor->setValue('TGL_PENGADUAN', tgl_hari_indo($oldData->created_at));
        $template_processor->setValue('MEDIA_PENGADUAN', isset($oldData->media_pengaduan) ? ($oldData->media_pengaduan ?? "-") : "-");
        $template_processor->setValue('NAMA_PENGADU', ucwords($oldData->nama));
        $template_processor->setValue('NIK_PENGADU', $oldData->nik ?? "-");
        $template_processor->setValue('NOHP_PENGADU', isset($oldData->nohp) ? ($oldData->nohp ?? "-") : "-");
        $template_processor->setValue('ALAMAT_PENGADU', isset($oldData->alamat) ? ($oldData->alamat ?? "-") : "-");
        $template_processor->setValue('KECAMATAN_PENGADU', getNamaKecamatan(substr($oldData->kelurahan, 0, 7)));
        $template_processor->setValue('KELURAHAN_PENGADU', getNamaKelurahan($oldData->kelurahan));
        $template_processor->setValue('NAMA_ADUAN', ucwords($dataAssesment['nama_orang_assesment']));
        $template_processor->setValue('NIK_ADUAN', $dataAssesment['nik_orang_assesment'] ?? "-");
        $template_processor->setValue('NOHP_ADUAN', '-');
        $template_processor->setValue('ALAMAT_ADUAN', $dataAssesment['alamat_domisili_orang_assesment'] ?? "-");
        $template_processor->setValue('KECAMATAN_ADUAN', getNamaKecamatan($dataAssesment['kecamatan_domisili_orang_assesment']));
        $template_processor->setValue('KELURAHAN_ADUAN', getNamaKelurahan($dataAssesment['kelurahan_domisili_orang_assesment']));
        $template_processor->setValue('KATEGORI_PPKS', getNameKategoriPPKS($dataAssesment['kategori_ppks']));

        $kepersertaan_bansos_fix = [];
        if (count($kepersertaan_bansos) > 0) {
            foreach ($kepersertaan_bansos as $key => $v) {
                $kepersertaan_bansos_fix[] = [
                    'NKB' => $key + 1,
                    'NAMA_KB' => ucwords($v->nama_anggota),
                    'NIK_KB' => $v->nik_anggota,
                    'DTKS_KB' => ucwords($v->dtks),
                    'PKH_KB' => ucwords($v->pkh),
                    'BPNT_KB' => ucwords($v->bpnt),
                    'PBI_KB' => ucwords($v->pbi_jk),
                    'RST_KB' => ucwords($v->rst),
                    'LAIN_KB' => ucwords($v->bansos_lain),
                    'KET_KB' => $v->keterangan_anggota,
                ];
            }
        } else {
            $kepersertaan_bansos_fix[] = [
                'NKB' => "-",
                'NAMA_KB' => "-",
                'NIK_KB' => "-",
                'DTKS_KB' => "-",
                'PKH_KB' => "-",
                'BPNT_KB' => "-",
                'PBI_KB' => "-",
                'RST_KB' => "-",
                'LAIN_KB' => "-",
                'KET_KB' => "-",
            ];
        }
        $template_processor->cloneRowAndSetValues('NKB', $kepersertaan_bansos_fix);

        $template_processor->setValue('GAMBARAN_KASUS', $dataTindakLanjut['gambaran_kasus'] ?? "-");
        $template_processor->setValue('DETAIL_KONDISI_FISIK_PPKS', $dataAssesment['detail_kondisi_fisik_ppks'] ?? "-");
        $template_processor->setValue('KONDISI_PEREKONOMIAN', $dataTindakLanjut['kondisi_perekonomian_keluarga'] ?? "-");
        $template_processor->setValue('PERMASALAHAN', $dataTindakLanjut['permasalahan'] ?? "-");
        $identifikasi_kebutuhans = explode(";", $dataTindakLanjut['identifikasi_kebutuhan']);
        if (count($identifikasi_kebutuhans) > 0) {
            $identifikasi_kebutuhans_fix = [];
            foreach ($identifikasi_kebutuhans as $keyIK => $value) {
                if (!($value == NULL || $value == "")) {
                    $identifikasi_kebutuhans_fix[] = [
                        'IDENTIFIKASI_KEBUTUHAN' => ($keyIK + 1) . ". " . $value,
                    ];
                }
            }
            $template_processor->cloneRowAndSetValues('IDENTIFIKASI_KEBUTUHAN', $identifikasi_kebutuhans_fix);
        } else {
            $template_processor->setValue('IDENTIFIKASI_KEBUTUHAN', $dataTindakLanjut['identifikasi_kebutuhan'] ?? "-");
        }

        $intervensi_telah_dilakukans = explode(";", $dataTindakLanjut['intervensi_telah_dilakukan']);
        if (count($intervensi_telah_dilakukans) > 0) {
            $intervensi_telah_dilakukans_fix = [];
            foreach ($intervensi_telah_dilakukans as $keyIY => $valueIY) {
                if (!($valueIY == NULL || $valueIY == "")) {
                    $intervensi_telah_dilakukans_fix[] = [
                        'INTERVENSI_YANG_TELAH_DILAKUKAN' => ($keyIY + 1) . ". " . $valueIY,
                    ];
                }
            }
            $template_processor->cloneRowAndSetValues('INTERVENSI_YANG_TELAH_DILAKUKAN', $intervensi_telah_dilakukans_fix);
        } else {
            $template_processor->setValue('INTERVENSI_YANG_TELAH_DILAKUKAN', $dataTindakLanjut['intervensi_telah_dilakukan'] ?? "-");
        }

        $saran_tindaklanjuts = explode(";", $dataTindakLanjut['saran_tindaklanjut']);
        if (count($saran_tindaklanjuts) > 0) {
            $saran_tindaklanjuts_fix = [];
            foreach ($saran_tindaklanjuts as $keyST => $valueST) {
                if (!($valueST == NULL || $valueST == "")) {
                    $saran_tindaklanjuts_fix[] = [
                        'SARAN_TINDAK_LANJUT' => ($keyST + 1) . ". " . $valueST,
                    ];
                }
            }
            $template_processor->cloneRowAndSetValues('SARAN_TINDAK_LANJUT', $saran_tindaklanjuts_fix);
        } else {
            $template_processor->setValue('SARAN_TINDAK_LANJUT', $dataTindakLanjut['saran_tindaklanjut'] ?? "-");
        }
        // $petugasTerlibat = "";
        // $petugasTerlibat .= "1. " . ucwords($oldData->nama);

        if (count($petugasTerlibat) > 0) {
            $petugasTerlibatFix = [];
            foreach ($petugasTerlibat as $keyPT => $vpT) {
                $petugasTerlibatFix[] = [
                    'PETUGAS_TERLIBAT' => ($keyPT + 1) . ". " . ucwords($vpT->nama) . " (" . $vpT->nip . " - " . ucwords($vpT->jabatan) . ")",
                ];
            }
            $template_processor->cloneRowAndSetValues('PETUGAS_TERLIBAT', $petugasTerlibatFix);
        }
        // $template_processor->setValue('PETUGAS_TERLIBAT', $user->data->fullname);

        $template_processor->setValue('NAMA_PETUGAS_ASSESMENT', ucwords($user->data->fullname));

        $template_processor->setValue('NOMOR_ASSESMENT', $dataAssesment['kode_assesment']);
        $template_processor->setValue('SATUAN_KERJA_PETUGAS', ucwords($dataPetugas ? $dataPetugas->jabatan : "Dinas Soisial"));
        $template_processor->setValue('KECAMATAN_KTP', getNamaKecamatan($dataAssesment['kabupaten_ktp_orang_assesment']));
        $template_processor->setValue('KELURAHAN_KTP', getNamaKelurahan($dataAssesment['kelurahan_ktp_orang_assesment']));
        $template_processor->setValue('ALAMAT_KTP', $dataAssesment['alamat_ktp_orang_assesment']);
        $template_processor->setValue('PROVINSI_DOMISILI', $dataAssesment['provinsi_domisili_orang_assesment']);
        $template_processor->setValue('KABUPATEN_DOMISILI', $dataAssesment['kabupaten_domisili_orang_assesment']);
        $template_processor->setValue('KECAMATAN_DOMISILI', getNamaKecamatan($dataAssesment['kabupaten_domisili_orang_assesment']));
        $template_processor->setValue('KELURAHAN_DOMISILI', getNamaKelurahan($dataAssesment['kelurahan_domisili_orang_assesment']));
        $template_processor->setValue('ALAMAT_DOMISILI', $dataAssesment['alamat_domisili_orang_assesment']);
        $template_processor->setValue('NAMA_PPKS', ucwords($dataAssesment['nama_orang_assesment']));
        $template_processor->setValue('TEMPAT_LAHIR_PPKS', ucwords($dataAssesment['tempat_lahir_orang_assesment']));
        $template_processor->setValue('TGL_LAHIR_PPKS', tgl_indo($dataAssesment['tgl_lahir_orang_assesment']));
        $template_processor->setValue('JK_PPKS', getJenisKelamin($dataAssesment['jk_orang_assesment']));
        $template_processor->setValue('AGAMA_PPKS', $dataAssesment['agama_orang_assesment']);
        $template_processor->setValue('NIK_PPKS', $dataAssesment['nik_orang_assesment']);
        $template_processor->setValue('KK_PPKS', $dataAssesment['kk_orang_assesment']);
        $template_processor->setValue('NO_AKTA_PPKS', $dataAssesment['akta_orang_assesment']);
        $template_processor->setValue('PENDIDIKAN_PPKS', $dataAssesment['pendidikan_terakhir_orang_assesment']);
        $template_processor->setValue('STATUS_KAWIN_PPKS', $dataAssesment['status_kawin_orang_assesment']);
        $template_processor->setValue('DTKS_PPKS', $dataAssesment['dtks_orang_assesment'] == "1" ? "Sudah" : "Belum");

        if (count($bansosIdentitas) > 0) {
            $bansosIdentitasFix = [];
            foreach ($bansosIdentitas as $keyB => $vb) {
                $bansosIdentitasFix[] = [
                    'NB' => $keyB + 1,
                    'WAKTU' => $vb->waktu_bansos,
                    'NAMA_BANSOS' => $vb->nama_bansos,
                    'JML_BAN' => $vb->jumlah_bansos,
                    'SAT_BAN' => $vb->satuan_bansos,
                    'SMB_DN' => $vb->sumber_anggaran_bansos,
                    'KET' => $vb->keterangan_bansos,
                ];
            }
        } else {
            $bansosIdentitasFix[] = [
                'NB' => "-",
                'WAKTU' => "-",
                'NAMA_BANSOS' => "-",
                'JML_BAN' => "-",
                'SAT_BAN' => "-",
                'SMB_DN' => "-",
                'KET' => "-",
            ];
        }
        $template_processor->cloneRowAndSetValues('NB', $bansosIdentitasFix);

        if ($dataAssesment['nama_pengampu_assesment'] == "" || $dataAssesment['nama_pengampu_assesment'] == NULL) {
        } else {
            $template_processor->setValue('NAMA_PENGAMPU', $dataAssesment['nama_pengampu_assesment']);
            $template_processor->setValue('NOHP_PENGAMPU', $dataAssesment['nohp_pengampu_assesment']);
            $template_processor->setValue('HUBUNGAN_PENGAMPU', $dataAssesment['hubungan_pengampu_assesment']);
            $template_processor->setValue('TEMPAT_LAHIR_PENGAMPU', $dataAssesment['tempat_lahir_pengampu_assesment']);
            $template_processor->setValue('TGL_LAHIR_PENGAMPU', tgl_indo($dataAssesment['tgl_lahir_pengampu_assesment']));
            $template_processor->setValue('JK_PENGAMPU', getJenisKelamin($dataAssesment['jk_pengampu_assesment']));
            $template_processor->setValue('AGAMA_PENGAMPU', $dataAssesment['agama_pengampu_assesment']);
            $template_processor->setValue('NIK_PENGAMPU', $dataAssesment['nik_pengampu_assesment']);
            $template_processor->setValue('KK_PENGAMPU', $dataAssesment['kk_pengampu_assesment']);
            $template_processor->setValue('PENDIDIKAN_PENGAMPU', $dataAssesment['pendidikan_terakhir_pengampu_assesment']);
            $template_processor->setValue('STATUS_KAWIN_PENGAMPU', $dataAssesment['status_kawin_pengampu_assesment']);
            $template_processor->setValue('PEKERJAAN_PENGAMPU', $dataAssesment['pekerjaan_pengampu_assesment']);
            $template_processor->setValue('PENGELUARAN_PER_BULAN_PENGAMPU', $dataAssesment['pengeluaran_perbulan_pengampu_assesment']);
            $template_processor->setValue('DTKS_PENGAMPU', $dataAssesment['dtks_pengampu_assesment'] == "1" ? "Sudah" : "Belum");

            if (count($bansosPengampu) > 0) {
                $bansosPengampuFix = [];
                foreach ($bansosPengampu as $keyP => $vp) {
                    $bansosPengampuFix[] = [
                        'NP' => $keyP + 1,
                        'NAMA_BANSOS_PENGAMPU' => $vp->nama_bansos,
                        'TAHUN_PENGAMPU' => $vp->tahun_bansos,
                    ];
                }
            } else {
                $bansosPengampuFix[] = [
                    'NP' => "-",
                    'NAMA_BANSOS_PENGAMPU' => "-",
                    'TAHUN_PENGAMPU' => "-",
                ];
            }
            $template_processor->cloneRowAndSetValues('NP', $bansosPengampuFix);
        }

        $template_processor->setValue('KONDISI_FISIK_PPKS', $dataAssesment['kondisi_fisik_ppks']);
        $template_processor->setValue('RATA_PENGHASILAN_E', getNamePenghasilanEkonomi($dataAssesment['penghasilan_ekonomi']));
        $template_processor->setValue('PENGHASILAN_MAKAN_E', getNamePenghasilanMakanEkonomi($dataAssesment['penghasilan_makan_ekonomi']));
        $template_processor->setValue('MAKAN_E', getNameMakanEkonomi($dataAssesment['makan_ekonomi']));
        $template_processor->setValue('PAKAIAN_E', getNameKemampuanPakaianEkonomi($dataAssesment['kemampuan_pakaian_ekonomi']));
        $template_processor->setValue('TEMPAT_TINGGAL_E', getNameTempatTinggalEkonomi($dataAssesment['tempat_tinggal_ekonomi']));
        $template_processor->setValue('TINGGAL_BERSAMA_E', getTinggalBersamaEkonomi($dataAssesment['tinggal_bersama_ekonomi']));
        $template_processor->setValue('LUAS_LANTAI_E', getNameLuasLantaiEkonomi($dataAssesment['luas_lantai_ekonomi']));
        $template_processor->setValue('JENIS_LANTAI_E', getNameJenisLantaiEkonomi($dataAssesment['jenis_lantai_ekonomi']));
        $template_processor->setValue('JENIS_DINDING_E', getNameJenisDindingEkonomi($dataAssesment['jenis_dinding_ekonomi']));
        $template_processor->setValue('JENIS_ATAP_E', getNameJenisAtapEkonomi($dataAssesment['jenis_atap_ekonomi']));
        $template_processor->setValue('MILIK_WC_E', getNameMilikWcEkonomi($dataAssesment['milik_wc_ekonomi']));
        $template_processor->setValue('JENIS_WC_E', getNameJenisWcEkonomi($dataAssesment['jenis_wc_ekonomi']));
        $template_processor->setValue('LISTRIK_E', getNamePeneranganEkonomi($dataAssesment['penerangan_ekonomi']));
        $template_processor->setValue('SUMBER_AIR_E', getNameSumberAirMinumEkonomi($dataAssesment['sumber_air_minum_ekonomi']));
        $template_processor->setValue('BAHAN_BAKAR_E', getNameBahanBakarMasakEkonomi($dataAssesment['bahan_bakar_masak_ekonomi']));
        $template_processor->setValue('BEROBAT_E', getNameBerobatEkonomi($dataAssesment['berobat_ekonomi']));
        $template_processor->setValue('RATA_PENDIDIKAN_E', getNameRataPendidikanEkonomi($dataAssesment['rata_pendidikan_ekonomi']));
        $template_processor->setValue('JUMLAH_SKOR', $skor_total);
        $template_processor->setValue('1', $skor_assesment->penghasilan);
        $template_processor->setValue('2', $skor_assesment->penghasilan_makan);
        $template_processor->setValue('3', $skor_assesment->makan);
        $template_processor->setValue('4', $skor_assesment->kemampuan_pakaian);
        $template_processor->setValue('5', $skor_assesment->tempat_tinggal);
        $template_processor->setValue('6', '-');
        $template_processor->setValue('7', $skor_assesment->luas_lantai);
        $template_processor->setValue('8', $skor_assesment->jenis_lantai);
        $template_processor->setValue('9', $skor_assesment->jenis_dinding);
        $template_processor->setValue('10', $skor_assesment->jenis_atap);
        $template_processor->setValue('11', $skor_assesment->milik_wc);
        $template_processor->setValue('12', $skor_assesment->jenis_wc);
        $template_processor->setValue('13', $skor_assesment->penerangan);
        $template_processor->setValue('14', $skor_assesment->sumber_air_minum);
        $template_processor->setValue('15', $skor_assesment->bahan_bakar_masak);
        $template_processor->setValue('16', $skor_assesment->berobat);
        $template_processor->setValue('17', $skor_assesment->rata_pendidikan);

        $fileLampiran = explode(";", $lampiran);
        if ((count($fileLampiran) - 1) > 0) {
            $fileLampiranFix = [];
            foreach ($fileLampiran as $keyLf => $lf) {
                if (!($lf == NULL || $lf == "")) {
                    $fileLampiranFix[] = [
                        'NOF' => $keyLf + 1,
                        'LAMPIRAN_FOTO' => '${LAMPIRAN_FOTO_' . $keyLf . '}',
                        '_path' => FCPATH . 'uploads/assesment/lampiran/' . $lf,
                    ];
                    // 'LAMPIRAN_FOTO' => FCPATH . 'uploads/assesment/lampiran/' . $lf,
                }
            }

            $template_processor->cloneRowAndSetValues('NOF', $fileLampiranFix);
            foreach ($fileLampiranFix as $iI => $itemI) {
                // $template_processor->setImageValue(sprintf('LAMPIRAN_FOTO#%d', $iI + 1), array('path' => FCPATH . 'uploads/assesment/lampiran/' . $itemI['_path'], 'width' => 100, 'height' => 100, 'ratio' => true));
                $template_processor->setImageValue('LAMPIRAN_FOTO_' .  $iI, array('path' => $itemI['_path'], 'width' => 500, 'height' => 280, 'ratio' => false));
                // $template_processor->setImageValue(sprintf('LAMPIRAN_FOTO#%d', $iI + 1), $itemI['_path']);
            }
            // $template_processor->setImageValue('FOTO_PPKS', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[0], 'width' => 100, 'height' => 100, 'ratio' => true));
        } else {
            $fileLampiranFix[] = [
                'NOF' => "-",
                'LAMPIRAN_FOTO' => '-',
            ];
            $template_processor->cloneRowAndSetValues('NOF', $fileLampiranFix);
        }
        // if (count($fileLampiran) > 1) {
        //     $template_processor->setImageValue('RUMAH_1', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[1], 'width' => 100, 'height' => 100, 'ratio' => true));
        // }
        // if (count($fileLampiran) > 2) {
        //     $template_processor->setImageValue('RUMAH_2', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[2], 'width' => 100, 'height' => 100, 'ratio' => true));
        // }
        // if (count($fileLampiran) > 3) {
        //     $template_processor->setImageValue('RUMAH_3', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[3], 'width' => 100, 'height' => 100, 'ratio' => true));
        // }
        // if (count($fileLampiran) > 4) {
        //     $template_processor->setImageValue('RUMAH_4', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[4], 'width' => 100, 'height' => 100, 'ratio' => true));
        // }
        // if (count($fileLampiran) > 5) {
        //     $template_processor->setImageValue('ASSET', array('path' => FCPATH . 'uploads/assesment/lampiran/' . $fileLampiran[5], 'width' => 100, 'height' => 100, 'ratio' => true));
        // }

        $template_processor->setImageValue('QR_CODE_NOTA', array('path' => 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData->kode, 'width' => 100, 'height' => 100, 'ratio' => false));
        // $template_processor->setImageValue('QR_CODE_NOTA', array('path' => 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $oldData->kode . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));
        $template_processor->setImageValue('QR_CODE_ASSESMENT', array('path' => 'http://192.168.33.16:8020/generate?data=https://layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $dataAssesment['kode_assesment'], 'width' => 100, 'height' => 100, 'ratio' => false));
        // $template_processor->setImageValue('QR_CODE_ASSESMENT', array('path' => 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=layanan.dinsos.lampungtengahkab.go.id/verifiqrcode?token=' . $dataAssesment['kode_assesment'] . '&choe=UTF-8', 'width' => 100, 'height' => 100, 'ratio' => false));

        $filed = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";

        $template_processor->saveAs($filed);

        sleep(3);

        // $response = new \stdClass;
        // $response->status = 200;
        // // $response->result = $result;
        // $response->dir = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";
        // $response->dir_temp = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";
        // $response->filename = $dataAssesment['kode_assesment'] . ".docx";
        // return $response;

        $datas = [
            'nama_file' => $dataAssesment['kode_assesment'] . '.docx',
            'file_folder' => $filed,
        ];

        // $curlHandle = curl_init("http://10.20.30.99:1890/convert");
        $curlHandle = curl_init("http://192.168.33.30:1890/convert");
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
            // 'X-API-TOKEN: ' . $apiToken,
            // 'Authorization: Bearer ' . $jwt,
            'Content-Type: application/json'
        ));
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 120);

        $send_data         = curl_exec($curlHandle);

        $result = json_decode($send_data);


        if (isset($result->error)) {
            try {
                unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
            } catch (\Throwable $th) {
                //throw $th;
            }
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mengenerate dokumen.";
            return $response;
        }

        if ($result) {
            if ($result->status == 200) {
                $response = new \stdClass;
                $response->status = 200;
                $response->result = $result;
                $response->dir = FCPATH . "upload/generate/surat/pdf/" . $dataAssesment['kode_assesment'] . ".pdf";
                $response->dir_temp = FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx";
                $response->filename = $dataAssesment['kode_assesment'] . ".pdf";
                return $response;
            } else {
                try {
                    unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $response = new \stdClass;
                $response->status = 400;
                $response->message = $result->message;
                // $response->message = "Gagal mengenerate dokumen.";
                return $response;
            }
            // return $result;
        } else {
            try {
                unlink(FCPATH . "upload/generate/surat/word/" . $dataAssesment['kode_assesment'] . ".docx");
            } catch (\Throwable $th) {
                //throw $th;
            }
            $response = new \stdClass;
            $response->status = 400;
            $response->message = "Gagal mengenerate dokumen.";
            return $response;
        }
    }
}
