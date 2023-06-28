<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function nested_array_search($needle, $array)
{
	foreach ($array as $key => $value) {
		$array_key = array_search($needle, $value);
		if ($array_key !== FALSE) return $key;
	}
}

function Parse_Data($data, $p1, $p2)
{
	$data = " " . $data;
	$hasil = "";
	$awal = strpos($data, $p1);
	if ($awal != "") {
		$akhir = strpos(strstr($data, $p1), $p2);
		if ($akhir != "") {
			$hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
		}
	}
	return $hasil;
}

function Rupiah($nil = 0)
{
	$nil = $nil + 0;
	if (($nil * 100) % 100 == 0) {
		$nil = $nil . ".00";
	} elseif (($nil * 100) % 10 == 0) {
		$nil = $nil . "0";
	}
	$nil = str_replace('.', ',', $nil);
	$str1 = $nil;
	$str2 = "";
	$dot = "";
	$str = strrev($str1);
	$arr = str_split($str, 3);
	$i = 0;
	foreach ($arr as $str) {
		$str2 = $str2 . $dot . $str;
		if (strlen($str) == 3 and $i > 0) $dot = '.';
		$i++;
	}
	$rp = strrev($str2);
	if ($rp != "" and $rp > 0) {
		return "Rp. $rp";
	} else {
		return "Rp. 0,00";
	}
}

function Rupiah2($nil = 0)
{
	$nil = $nil + 0;
	if (($nil * 100) % 100 == 0) {
		$nil = $nil . ".00";
	} elseif (($nil * 100) % 10 == 0) {
		$nil = $nil . "0";
	}
	$nil = str_replace('.', ',', $nil);
	$str1 = $nil;
	$str2 = "";
	$dot = "";
	$str = strrev($str1);
	$arr = str_split($str, 3);
	$i = 0;
	foreach ($arr as $str) {
		$str2 = $str2 . $dot . $str;
		if (strlen($str) == 3 and $i > 0) $dot = '.';
		$i++;
	}
	$rp = strrev($str2);
	if ($rp != "" and $rp > 0) {
		return "Rp.$rp";
	} else {
		return "-";
	}
}

function Rupiah3($nil = 0)
{
	$nil = $nil + 0;
	if (($nil * 100) % 100 == 0) {
		$nil = $nil . ".00";
	} elseif (($nil * 100) % 10 == 0) {
		$nil = $nil . "0";
	}
	$nil = str_replace('.', ',', $nil);
	$str1 = $nil;
	$str2 = "";
	$dot = "";
	$str = strrev($str1);
	$arr = str_split($str, 3);
	$i = 0;
	foreach ($arr as $str) {
		$str2 = $str2 . $dot . $str;
		if (strlen($str) == 3 and $i > 0) $dot = '.';
		$i++;
	}
	$rp = strrev($str2);
	if ($rp != 0) {
		return "$rp";
	} else {
		return "-";
	}
}

function to_rupiah($inp = '')
{
	$outp = str_replace('.', '', $inp);
	$outp = str_replace(',', '.', $outp);
	return $outp;
}

function rp($inp = 0)
{
	return number_format($inp, 2, ',', '.');
}

function rpAwalan($inp = 0)
{
	if ($inp == NULL) {
		return 'Rp. 0';
	}
	return 'Rp. ' . number_format($inp, 0, ',', '.');
}

function rpTanpaAwalan($inp = 0)
{
	return number_format($inp, 0, ',', '.');
}

function rupiah24($angka)
{
	$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $hasil_rupiah;
}

function jecho($a, $b, $str)
{
	if ($a == $b) {
		echo $str;
	}
}

function compared_return($a, $b, $retval = null)
{
	($a === $b) and print('active');
}

function selected($a, $b, $opt = 0)
{
	if ($a == $b) {
		if ($opt)
			echo "checked='checked'";
		else echo "selected='selected'";
	}
}

function date_is_empty($tgl)
{
	return (is_null($tgl) || substr($tgl, 0, 10) == '0000-00-00');
}

function rev_tgl($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$ar = explode('-', $tgl);
	$o = $ar[2] . '-' . $ar[1] . '-' . $ar[0];
	return $o;
}

function penetration($str)
{
	$str = str_replace("'", "-", $str);
	return $str;
}

function penetration1($str)
{
	$str = str_replace("'", " ", $str);
	return $str;
}

function unpenetration($str)
{
	$str = str_replace("-", "'", $str);
	return $str;
}
function spaceunpenetration($str)
{
	$str = str_replace("-", " ", $str);
	return $str;
}

function underscore($str)
{
	$str = str_replace(" ", "_", $str);
	return $str;
}

function ununderscore($str)
{
	$str = str_replace("_", " ", $str);
	return $str;
}

function bulan($bln)
{
	$bulan = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
	return $bulan[(int)$bln];
}

function getBulan($bln)
{
	return bulan($bln);
}

function nama_bulan($tgl)
{
	$ar = explode('-', $tgl);
	$nm = bulan($ar[1]);
	$o = $ar[0] . ' ' . $nm . ' ' . $ar[2];
	return $o;
}

function hari($tgl)
{
	$hari = array(
		0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
	);
	$dayofweek = date('w', $tgl);
	return $hari[$dayofweek];
}

function dua_digit($i)
{
	if ($i < 10) $o = '0' . $i;
	else $o = $i;
	return $o;
}

function tiga_digit($i)
{
	if ($i < 10) $o = '00' . $i;
	else if ($i < 100) $o = '0' . $i;
	else $o = $i;
	return $o;
}

function pertumbuhan($a = 1, $b = 1, $c = 1, $d = 1)
{
	$x = 0;
	$y = 0;
	$z = 0;
	if ($a > 1) $x = (($b - $a) / $a);
	if ($b > 1) $y = (($c - $b) / $b);
	if ($c > 1) $z = (($d - $c) / $c);
	$outp = (($x + $y + $z) / 3) * 100;
	$outp = round($outp, 2);
	$outp = str_replace('.', ',', $outp) . ' %';;
	return $outp;
}

function koma($a = 1)
{
	if (substr_count($a, '.'))

		$a = str_replace(".", ",", $a);
	else $a = number_format($a, 0, ',', '.');
	return $a;
}

function tgl_indo2($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$tanggal = substr($tgl, 8, 2);
	$jam = substr($tgl, 11, 8);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun . ' ' . $jam;
}

function tgl_indo_dari_str($tgl_str, $kosong = '-')
{
	$time = strtotime($tgl_str);
	$tanggal = $time ? tgl_indo(date('Y m d', strtotime($tgl_str))) : $kosong;
	return $tanggal;
}

function tgl_indo($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	$tahun = substr($tgl, 0, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function tgl_bulan_indo($tgl, $length_bulan = 3, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$tanggal = substr($tgl, 8, 2);
	$bulan = getBulan(substr($tgl, 5, 2));
	return $tanggal . ' ' . substr($bulan, 0, $length_bulan);
}

function tgl_indo_out($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}

	if ($tgl) {
		$tanggal = substr($tgl, 8, 2);
		$bulan = substr($tgl, 5, 2);
		$tahun = substr($tgl, 0, 4);
		return $tanggal . '-' . $bulan . '-' . $tahun;
	}
}

function tgl_indo_in($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$tanggal = substr($tgl, 0, 2);
	$bulan = substr($tgl, 3, 2);
	$tahun = substr($tgl, 6, 4);
	$jam = substr($tgl, 11);
	$jam = empty($jam) ? '' : ' ' . $jam;
	return $tahun . '-' . $bulan . '-' . $tanggal . $jam;
}

function tgl_indo_in_no_jam($tgl, $replace_with = '-')
{
	if (date_is_empty($tgl)) {
		return $replace_with;
	}
	$tanggal = substr($tgl, 0, 2);
	$bulan = substr($tgl, 3, 2);
	$tahun = substr($tgl, 6, 4);
	return $tahun . '-' . $bulan . '-' . $tanggal;
}

function waktu_ind($time)
{
	$str = "";
	if (($time / 360) > 1) {
		$jam = ($time / 360);
		$jam = explode('.', $jam);
		$str .= $jam . " Jam ";
	}
	if (($time / 60) > 1) {
		$menit = ($time / 60);
		$menit = explode('.', $menit);
		$str .= $menit[0] . " Menit ";
	}
	$detik = $time % 60;
	$str .= $detik;

	return $str . ' Detik';
}

function fixTag($varString)
{
	// edited : filter <i> tag for exception
	return strip_tags($varString, '<i>');
}

/*
	 * Format tampilan tanggal rentang
	 * */

function fTampilTgl($sdate, $edate)
{
	if ($sdate == $edate) {
		$tgl =  date("j M Y", strtotime($sdate));
	} elseif ($edate > $sdate) {
		if (date("Y", strtotime($sdate)) == date("Y", strtotime($edate))) {
			if (date("M Y", strtotime($sdate)) == date("M Y", strtotime($edate))) {
				if (date("j M Y", strtotime($sdate)) == date("j M Y", strtotime($edate))) {
					if (date("j M Y H", strtotime($sdate)) == date("j M Y H", strtotime($edate))) {
						$tgl = date("j M Y H:i", strtotime($sdate));
					} else {
						$tgl = date("j M Y H:i", strtotime($sdate)) . " - " . date("H:i", strtotime($edate));
					}
				} else {
					$tgl = date("j", strtotime($sdate)) . " - " . date("j M Y", strtotime($edate));
				}
			} else {
				$tgl = date("j M", strtotime($sdate)) . " - " . date("j M Y", strtotime($edate));
			}
		} else {
			$tgl = date("j M Y", strtotime($sdate)) . " - " . date("j M Y", strtotime($edate));
		}
	}
	return $tgl;
}

// https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
function validate_date($date, $format = 'd-m-Y')
{
	$d = DateTime::createFromFormat($format, $date);
	// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	return $d && $d->format($format) === $date;
}

// Potong teks pada batasan kata
function potong_teks($teks, $panjang)
{
	$abstrak = fixTag($teks);
	if (strlen($abstrak) > $panjang + 10) {
		$abstrak = substr($abstrak, 0, strpos($abstrak, " ", $panjang));
	}
	return $abstrak;
}


function make_time_long_ago($datetime, $full = false)
{
	// $now = new DateTime;
	// $ago = new DateTime($datetime);
	// $diff = $now->diff($ago);

	// $diff->w = floor($diff->d / 7);
	// $diff->d -= $diff->w * 7;

	// $string = array(
	// 	'y' => 'year',
	// 	'm' => 'month',
	// 	'w' => 'week',
	// 	'd' => 'day',
	// 	'h' => 'hour',
	// 	'i' => 'minute',
	// 	's' => 'second',
	// );
	// foreach ($string as $k => &$v) {
	// 	if ($diff->$k) {
	// 		$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	// 	} else {
	// 		unset($string[$k]);
	// 	}
	// }

	// if (!$full) $string = array_slice($string, 0, 1);
	// return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function make_time_long_ago_new($datetime, $full = false)
{
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function access_checked($array, $menu, $submenu)
{
	$key = false;
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu && $v['sub_menu'] === $submenu) {
			$key = true;
			break;
		}
	}

	return $key;
}

function access_checked_new($array, $menu, $submenu, $aksi)
{
	$key = false;
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu && $v['sub_menu'] === $submenu && $v['aksi'] === $aksi) {
			$key = true;
			break;
		}
	}

	return $key;
}

function access_allowed($array, $menu, $submenu)
{
	$key = false;
	$smenu = $submenu;
	if ($smenu == "" || $smenu == "getAll") {
		$smenu = "index";
	}
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu && $v['sub_menu'] === $smenu) {
			$key = true;
			break;
		}
	}

	return $key;
}

function access_allowed_new($array, $menu, $submenu, $aksi)
{
	$key = false;
	$smenu = $aksi;
	if ($smenu == "" || $smenu == "getAll") {
		$smenu = "index";
	}
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu && $v['sub_menu'] === $submenu && $v['aksi'] === $smenu) {
			$key = true;
			break;
		}
	}

	return $key;
}

function menu_showed_access($array, $menu)
{
	$key = false;
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu) {
			$key = true;
			break;
		}
	}

	return $key;
}

function submenu_showed_access($array, $menu, $submenu)
{
	$key = false;
	foreach ($array as $k => $v) {
		if ($v['menu'] === $menu && $v['sub_menu'] === $submenu) {
			$key = true;
			break;
		}
	}

	return $key;
}

function listHakAkses()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$jwt = get_cookie('jwt');
	$token_jwt = getenv('token_jwt.default.key');
	if ($jwt) {
		try {
			$decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
			if ($decoded) {
				$userId = $decoded->data->id;
				$access = $db->table('_user_hak_access')
					->where('u_id', $userId)
					->groupBy('menu')
					->get()->getResultArray();
				if (count($access) > 0) {
					$menus = json_decode(file_get_contents(FCPATH . "uploads/hakaccess.json"), true);

					$datas = [
						'access' => $access,
						'accesses' => listHakAksesAllow(),
						'menus' => $menus,
					];
					return $datas;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	} else {
		return false;
	}
}

function listHakAksesAllow()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$jwt = get_cookie('jwt');
	$token_jwt = getenv('token_jwt.default.key');
	if ($jwt) {
		try {
			$decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
			if ($decoded) {
				$userId = $decoded->data->id;
				$access = $db->table('_user_hak_access')
					->where('u_id', $userId)
					->get()->getResultArray();
				if (count($access) > 0) {
					return $access;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	} else {
		return false;
	}
}

function listHakAksesCustomAllow($menu, $submenu)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$jwt = get_cookie('jwt');
	$token_jwt = getenv('token_jwt.default.key');
	if ($jwt) {
		try {
			$decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
			if ($decoded) {
				$userId = $decoded->data->id;
				$access = $db->table('_user_hak_access')
					->where('u_id', $userId)
					->get()->getResultArray();
				if (count($access) > 0) {
					return access_allowed($access, $menu, $submenu);
					// return $access;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	} else {
		return false;
	}
}

function listHakAksesCustomAllowNew($menu, $submenu, $aksi)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$jwt = get_cookie('jwt');
	$token_jwt = getenv('token_jwt.default.key');
	if ($jwt) {
		try {
			$decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
			if ($decoded) {
				$userId = $decoded->data->id;
				$access = $db->table('_user_hak_access')
					->where('u_id', $userId)
					->get()->getResultArray();
				if (count($access) > 0) {
					return access_allowed_new($access, $menu, $submenu, $aksi);
					// return $access;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	} else {
		return false;
	}
}

function canSptjmTamsil()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 3)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Upload SPTJM Tamsil sudah Ditutup, Batas akhir Upload SPTJM Tamsil adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Generate SPTJM Tamsil belum dibuka, Jadwal Generate SPTJM Tamsil adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canUsulTamsil()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 3)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan Tamsil sudah Ditutup, Batas akhir Usulan Tamsil adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan Tamsil belum dibuka, Jadwal Usulan Tamsil adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function cekGrantedVerifikasi($user_id)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('access_verifikasi')->where('user_id', $user_id)->get()->getRowObject();
	if (!$grandted) {
		return false;
	}
	return true;
}

function getDetailSekolahNaungan($npsn)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('ref_sekolah')->where('npsn', $npsn)->get()->getRowObject();
	if (!$grandted) {
		return false;
	}
	return $grandted;
}

function getDetailGuruNaungan($idPtk)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('_ptk_tb')->where('id_ptk', $idPtk)->get()->getRowObject();
	if (!$grandted) {
		return false;
	}
	return $grandted;
}

function canGrantedPengajuan($id_ptk, $tw)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('_tb_temp_usulan_detail')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5))")->get()->getRowObject();
	if ($grandted) {
		if ($grandted->status_usulan == 5) {
			if ($grandted->jenis_tunjangan == 'tpg') {
				$grandtedAntrianTransfer = $db->table('_tb_usulan_tpg_siap_sk')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
				if ($grandtedAntrianTransfer) {
					$response = new \stdClass;
					$response->code = 400;
					$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
					$response->redirect = "";
					return $response;
				}

				$grandtedAntrian = $db->table('_tb_usulan_detail_tpg')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
				if ($grandtedAntrian) {
					$response = new \stdClass;
					$response->code = 400;
					$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
					$response->redirect = "";
					return $response;
				}
			}
			if ($grandted->jenis_tunjangan == 'tamsil') {
				$grandtedAntrian = $db->table('_tb_usulan_tamsil_transfer')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
				if ($grandtedAntrianTransfer) {
					$response = new \stdClass;
					$response->code = 400;
					$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
					$response->redirect = "";
					return $response;
				}

				$grandtedAntrian = $db->table('_tb_usulan_detail_tamsil')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
				if ($grandtedAntrian) {
					$response = new \stdClass;
					$response->code = 400;
					$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
					$response->redirect = "";
					return $response;
				}
			}
		} else {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
			$response->redirect = "";
			return $response;
		}
	} else {
		$grandtedAntrianTransfer = $db->table('_tb_usulan_tpg_siap_sk')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
		if ($grandtedAntrianTransfer) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
			$response->redirect = "";
			return $response;
		}

		$grandtedAntrian = $db->table('_tb_usulan_detail_tpg')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
		if ($grandtedAntrian) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
			$response->redirect = "";
			return $response;
		}

		$grandtedTransferTamsil = $db->table('_tb_usulan_tamsil_transfer')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
		if ($grandtedTransferTamsil) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
			$response->redirect = "";
			return $response;
		}

		$grandtedAntrianTamsil = $db->table('_tb_usulan_detail_tamsil')->where("id_ptk = '$id_ptk' AND id_tahun_tw = '$tw' AND (status_usulan IN (0,2,5,6,7))")->get()->getRowObject();
		if ($grandtedAntrianTamsil) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Anda sebelumnya sudah mengajukan usulan tunjangan dan masih dalam proses. Silahkan cek pada Progres Usulan Anda.";
			$response->redirect = "";
			return $response;
		}
	}

	$response = new \stdClass;
	$response->code = 200;
	$response->message = "";
	return $response;
}

function createAktifitas($user_id, $keterangan, $aksi, $icon, $tw = "")
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	if ($tw == "") {
		$twa = $db->table('_ref_tahun_tw')->select('id')->where('is_current', 1)->orderBy('tahun', 'desc')->orderBy('tw', 'desc')->get()->getRowObject();
		if ($twa) {
			$tw = $twa->id;
		}
	}

	$grandted = $db->table('riwayat_system')->insert([
		'user_id' => $user_id,
		'keterangan' => $keterangan,
		'aksi' => $aksi,
		'icon' => $icon,
		'id_tahun_tw' => $tw,
	]);

	return true;
}

function grantAccessSitugu($user_id)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('granted_situgu')->where('id', $user_id)->get()->getRowObject();
	if (!$grandted) {
		return false;
	}

	return true;
}

function grantedVerifikasiPengawas($user_id)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('access_verifikasi_pengawas')->where('user_id', $user_id)->get()->getRowObject();
	if (!$grandted) {
		return false;
	}

	return true;
}

function canGrantedVerifikasiPengawas($user_id)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('access_verifikasi_pengawas')->where('user_id', $user_id)->get()->getRowObject();
	if (!$grandted) {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Akses untuk proses verval terkunci. Silahkan hubungi Admin Tunjangan.";
		$response->redirect = "";
		return $response;
	}

	$response = new \stdClass;
	$response->code = 200;
	$response->message = "";
	return $response;
}

function canGrantedVerifikasi($user_id)
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('access_verifikasi')->where('user_id', $user_id)->get()->getRowObject();
	if (!$grandted) {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Akses untuk proses verval terkunci. Silahkan hubungi Admin Tunjangan.";
		$response->redirect = "";
		return $response;
	}

	$response = new \stdClass;
	$response->code = 200;
	$response->message = "";
	return $response;
}

function canVerifikasiTamsil()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_verifikasi_tb')
		->where('id', 3)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadVerifikasi = str_replace("-", "", $limit->max_download_verifikasi);
		$setinganDownloadVerifikasi = str_replace(" ", "", $setinganDownloadVerifikasi);
		$setinganDownloadVerifikasi = str_replace(":", "", $setinganDownloadVerifikasi);

		$setinganUplaodVerifikasi = str_replace("-", "", $limit->max_upload_verifikasi);
		$setinganUplaodVerifikasi = str_replace(" ", "", $setinganUplaodVerifikasi);
		$setinganUplaodVerifikasi = str_replace(":", "", $setinganUplaodVerifikasi);

		if ((int)$waktuSekarang > (int)$setinganUplaodVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi Tamsil sudah Ditutup, Batas akhir Verifikasi Tamsil adalah " . $limit->max_upload_verifikasi;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi Tamsil belum dibuka, Jadwal Verifikasi Tamsil adalah " . $limit->max_download_verifikasi;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function grantTarikDataBackbone()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$grandted = $db->table('granted_syncrone_backbone')->where(['id' => 1, 'status' => 1])->get()->getRowObject();
	if (!$grandted) {
		return false;
	}

	return true;
}

function canSptjmPghm()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 4)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Upload SPTJM PGHM sudah Ditutup, Batas akhir Upload SPTJM PGHM adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Generate SPTJM PGHM belum dibuka, Jadwal Generate SPTJM PGHM adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canUsulPghm()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 4)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan PGHM sudah Ditutup, Batas akhir Usulan PGHM adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan PGHM belum dibuka, Jadwal Usulan PGHM adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canVerifikasiPghm()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_verifikasi_tb')
		->where('id', 4)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodVerifikasi = new \DateTime($settingVerifikasi->max_upload_verifikasi);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadVerifikasi = str_replace("-", "", $limit->max_download_verifikasi);
		$setinganDownloadVerifikasi = str_replace(" ", "", $setinganDownloadVerifikasi);
		$setinganDownloadVerifikasi = str_replace(":", "", $setinganDownloadVerifikasi);

		$setinganUplaodVerifikasi = str_replace("-", "", $limit->max_upload_verifikasi);
		$setinganUplaodVerifikasi = str_replace(" ", "", $setinganUplaodVerifikasi);
		$setinganUplaodVerifikasi = str_replace(":", "", $setinganUplaodVerifikasi);

		if ((int)$waktuSekarang > (int)$setinganUplaodVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi PGHM sudah Ditutup, Batas akhir Verifikasi PGHM adalah " . $limit->max_upload_verifikasi;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi PGHM belum dibuka, Jadwal Verifikasi PGHM adalah " . $limit->max_download_verifikasi;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canSptjmTpg()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 2)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Upload SPTJM TPG sudah Ditutup, Batas akhir Upload SPTJM TPG adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Generate SPTJM TPG belum dibuka, Jadwal Generate SPTJM TPG adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canUsulTpgPengawas()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb_pengawas')
		->where('id', 2)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan TPG sudah Ditutup, Batas akhir Usulan TPG adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan TPG belum dibuka, Jadwal Usulan TPG adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canVerifikasiTpgPengawas()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_verifikasi_tb_pengawas')
		->where('id', 2)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodVerifikasi = new \DateTime($settingVerifikasi->max_upload_verifikasi);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadVerifikasi = str_replace("-", "", $limit->max_download_verifikasi);
		$setinganDownloadVerifikasi = str_replace(" ", "", $setinganDownloadVerifikasi);
		$setinganDownloadVerifikasi = str_replace(":", "", $setinganDownloadVerifikasi);

		$setinganUplaodVerifikasi = str_replace("-", "", $limit->max_upload_verifikasi);
		$setinganUplaodVerifikasi = str_replace(" ", "", $setinganUplaodVerifikasi);
		$setinganUplaodVerifikasi = str_replace(":", "", $setinganUplaodVerifikasi);

		if ((int)$waktuSekarang > (int)$setinganUplaodVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi TPG sudah Ditutup, Batas akhir Verifikasi TPG adalah " . $limit->max_upload_verifikasi;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi TPG belum dibuka, Jadwal Verifikasi TPG adalah " . $limit->max_download_verifikasi;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canUsulTpg()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_sptjm_tb')
		->where('id', 2)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodSptjm = new \DateTime($settingSptjm->max_upload_sptjm);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadSptjm = str_replace("-", "", $limit->max_download_sptjm);
		$setinganDownloadSptjm = str_replace(" ", "", $setinganDownloadSptjm);
		$setinganDownloadSptjm = str_replace(":", "", $setinganDownloadSptjm);

		$setinganUplaodSptjm = str_replace("-", "", $limit->max_upload_sptjm);
		$setinganUplaodSptjm = str_replace(" ", "", $setinganUplaodSptjm);
		$setinganUplaodSptjm = str_replace(":", "", $setinganUplaodSptjm);

		if ((int)$waktuSekarang > (int)$setinganUplaodSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan TPG sudah Ditutup, Batas akhir Usulan TPG adalah " . $limit->max_upload_sptjm;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadSptjm) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Usulan TPG belum dibuka, Jadwal Usulan TPG adalah " . $limit->max_download_sptjm;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function canVerifikasiTpg()
{
	// SELECT COUNT(*) as total FROM _tb_pendaftar WHERE peserta_didik_id = ? AND via_jalur = 'PELIMPAHAN'
	$db      = \Config\Database::connect();

	$limit = $db->table('_setting_verifikasi_tb')
		->where('id', 2)
		->get()->getRowObject();
	if ($limit) {
		$waktuSekarang = date('Y-m-d H:i:s');
		// $setinganUplaodVerifikasi = new \DateTime($settingVerifikasi->max_upload_verifikasi);

		$waktuSekarang = str_replace("-", "", $waktuSekarang);
		$waktuSekarang = str_replace(" ", "", $waktuSekarang);
		$waktuSekarang = str_replace(":", "", $waktuSekarang);

		$setinganDownloadVerifikasi = str_replace("-", "", $limit->max_download_verifikasi);
		$setinganDownloadVerifikasi = str_replace(" ", "", $setinganDownloadVerifikasi);
		$setinganDownloadVerifikasi = str_replace(":", "", $setinganDownloadVerifikasi);

		$setinganUplaodVerifikasi = str_replace("-", "", $limit->max_upload_verifikasi);
		$setinganUplaodVerifikasi = str_replace(" ", "", $setinganUplaodVerifikasi);
		$setinganUplaodVerifikasi = str_replace(":", "", $setinganUplaodVerifikasi);

		if ((int)$waktuSekarang > (int)$setinganUplaodVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi TPG sudah Ditutup, Batas akhir Verifikasi TPG adalah " . $limit->max_upload_verifikasi;
			return $response;
		}
		if ((int)$waktuSekarang < (int)$setinganDownloadVerifikasi) {
			$response = new \stdClass;
			$response->code = 400;
			$response->message = "Verifikasi TPG belum dibuka, Jadwal Verifikasi TPG adalah " . $limit->max_download_verifikasi;
			return $response;
		}
		$response = new \stdClass;
		$response->code = 200;
		$response->message = "";
		return $response;
	} else {
		$response = new \stdClass;
		$response->code = 400;
		$response->message = "Jadwal tidak ditemukan";
		return $response;
	}
}

function getCodePangkatFromMatching($code = "")
{
	switch ($code) {
		case '1A - Juru Muda':
			return 'I/a';
			break;
		case '1B - Juru Muda Tingkat I':
			return 'I/b';
			break;
		case '1C - Juru':
			return 'I/c';
			break;
		case '1D - Juru Tingkat I':
			return 'I/d';
			break;
		case '2A - Pengatur Muda':
			return 'II/a';
			break;
		case '2B - Pengatur Muda Tingkat I':
			return 'II/b';
			break;
		case '2C - Pengatur':
			return 'II/c';
			break;
		case '2D - Pengatur Tingkat I':
			return 'II/d';
			break;
		case '3A - Penata Muda':
			return 'III/a';
			break;
		case '3B - Penata Muda Tingkat I':
			return 'III/b';
			break;
		case '3C - Penata':
			return 'III/c';
			break;
		case '3D - Penata Tingkat I':
			return 'III/d';
			break;
		case '4A - Pembina':
			return 'IV/a';
			break;
		case '4B - Pembina Tingkat I':
			return 'IV/b';
			break;
		case '4C - Pembina Utama Muda':
			return 'IV/c';
			break;
		case '4D - Pembina Utama Madya':
			return 'IV/d';
			break;
		case '4E - Pembina Utama':
			return 'IV/e';
			break;

		default:
			return $code;
			break;
	}
}


function getNameWeb()
{
	return getenv('name.web.key') ?? "LAYANAN";
}

function getTitleWeb()
{
	return getenv('title.web.key') ?? "Unuknown";
}

function getKeywordWeb()
{
	return getenv('keyword.web.key') ?? "Unuknown";
}

function getDescriptionWeb()
{
	return getenv('description.web.key') ?? "Unuknown";
}

function getNamaKecamatan($id = null)
{
	if ($id === NULL || $id === "") {
		return "-";
	}
	$db      = \Config\Database::connect();

	$data = $db->table('ref_kecamatan')
		->select("kecamatan")
		->where('id', $id)
		->get()->getRowObject();
	if ($data) {
		return $data->kecamatan;
	}
	return "-";
}

function getNamaKelurahan($id = null)
{
	if ($id === NULL || $id === "") {
		return "-";
	}
	$db      = \Config\Database::connect();

	$data = $db->table('ref_kelurahan')
		->select("kelurahan")
		->where('id', $id)
		->get()->getRowObject();
	if ($data) {
		return $data->kelurahan;
	}
	return "-";
}

function getLayananSilastri()
{
	$layanan = json_decode(file_get_contents(FCPATH . "uploads/layanans_silastri.json"), true);
	$data = $layanan['layanans'];
	return $data;
}
