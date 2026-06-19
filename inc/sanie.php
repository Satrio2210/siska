<?php

// Manipulasi String 
// menghilangkan spasi dobel dalam teks
function trimed($txt)
{
  $txt = trim($txt);
  while (strpos($txt, '  ')) {
    $txt = str_replace('  ', ' ', $txt);
  }
  return $txt;
}

// Start Validasi ////////////////////

// memeriksa string apakah enkripsi md5 atau bukan 
function isValidMd5($md5 = '')
{
  return preg_match('/^[a-f0-9]{32}$/', $md5);
}

// contoh : echo isValidMd5('testing');

// memeriksa string alamat email atau bukan 
function is_valid_email($email)
{
  $result = 'valid_email';
  if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
    $result = 'invalid_email';
  }
  return $result;
}

// end Validasi //////////////////////



// Start Sekuriti ////////////////////////

// mengatasi teks XSS 
function xss_clean($data)
{
  // Fix &entity\n;
  $data = str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $data);
  $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
  $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
  $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

  // Remove any attribute starting with "on" or xmlns
  $data = preg_replace('#(]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

  // Remove javascript: and vbscript: protocols
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

  // Only works in IE: 
  $data = preg_replace('#(]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

  // Remove namespaced elements (we do not need them)
  $data = preg_replace('#]*+>#i', '', $data);

  do {
    // Remove really unwanted tags
    $old_data = $data;
    $data = preg_replace('#]*+>#i', '', $data);
  }
  while ($old_data !== $data);

  // we are done...
  return $data;
}

// mengatasi HTTP Response Splitting
//$cr = '/\%0d/';
//$lf = '/\%0a/';

//$response = // whatever your response is generated in;
//$cr_check = preg_match($cr , $response);
//$lf_check = preg_match($lf , $response);

//if (($cr_check > 0) || ($lf_check > 0)){
//  throw new \Exception('CRLF detected');
//}  


// End Sekuriti ////////////////////////////////



function penyebut($nilai)
{
  $nilai = abs($nilai);
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " " . $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10) . " Belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " Seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " Seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

function terbilang($nilai)
{
  if ($nilai < 0) {
    $hasil = "minus " . trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai));
  }
  return $hasil;
}


function formatTanggal($date = null)
{
  //buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
  $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
  //buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
  $array_bulan = array(
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  if ($date == null) {
    //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
    $hari = $array_hari[date('N')];
    $tanggal = date('j');
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
  } else {
    //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
    $date = strtotime($date);
    $hari = $array_hari[date('N', $date)];
    $tanggal = date('j', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date);
  }
  //$formatTanggal = $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
  $formatTanggal = $tanggal . " " . $bulan . " " . $tahun;

  return $formatTanggal;
}

function formatTanggalBulan($date = null)
{
  //buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
  $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
  //buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
  $array_bulan = array(
    1 => 'Jan',
    'Feb',
    'Mar',
    'Apr',
    'Mei',
    'Jun',
    'Jul',
    'Agu',
    'Sep',
    'Okt',
    'Nov',
    'Des'
  );
  if ($date == null) {
    //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
    $hari = $array_hari[date('N')];
    $tanggal = date('j');
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
  } else {
    //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
    $date = strtotime($date);
    $hari = $array_hari[date('N', $date)];
    $tanggal = date('j', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date);
  }
  //$formatTanggal = $hari . ", " . $tanggal ." ". $bulan ." ". $tahun;
  $formatTanggal = $tanggal . "-" . $bulan;

  return $formatTanggal;
}

function formatHariTanggal($date = null)
{
  //buat array nama hari dalam bahasa Indonesia dengan urutan 1-7
  $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
  //buat array nama bulan dalam bahasa Indonesia dengan urutan 1-12
  $array_bulan = array(
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  if ($date == null) {
    //jika $date kosong, makan tanggal yang diformat adalah tanggal hari ini
    $hari = $array_hari[date('N')];
    $tanggal = date('j');
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
  } else {
    //jika $date diisi, makan tanggal yang diformat adalah tanggal tersebut
    $date = strtotime($date);
    $hari = $array_hari[date('N', $date)];
    $tanggal = date('j', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date);
  }
  $formatHariTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
  return $formatHariTanggal;
}

function hitungTanggal($date_1, $date_2, $differenceFormat = '%a')
{
  $datetime1 = date_create($date_1);
  $datetime2 = date_create($date_2);
  $interval = date_diff($datetime1, $datetime2);
  return $interval->format($differenceFormat);
}

function kadaluarsa($todays_date, $end_date)
{
  //$start_date = strtotime($start_date); 
  $end_date = strtotime($end_date);
  $todays_date = strtotime($todays_date);
  if ($todays_date <= $end_date) {
    return 0;//AKTIF = Masih Berlaku
  } else {
    return 1; //KILL = Sudah kadaluarsa
  }
}

// function pembulatan($uang)
// {
//  $ratusan = substr($uang, -2);
//  if($ratusan<50)
//  $akhir = $uang - $ratusan;
//  else
//  $akhir = $uang + (100-$ratusan);
//  return $akhir;
// }
// function pembulatan($uang)
// {
//   $sisa = $uang % 1000;

//   // Jika uang sudah bulat ribuan (misal: 5000), kembalikan nilai aslinya
//   if ($sisa == 0) {
//     return $uang;
//   } 
//   // Jika sisa 1 - 500 (misal: 5001 sisa 1), bulatkan ke 500
//   elseif ($sisa <= 500) {
//     return $uang + (500 - $sisa);
//   } 
//   // Jika sisa di atas 500 (misal: 5501 sisa 501), bulatkan ke 1000
//   else {
//     return $uang + (1000 - $sisa);
//   }
// }

function pembulatan($uang)
{
    // Aturan 1: Jika uang di bawah 1.000
    if ($uang < 1000) {
        // Membulatkan ke ratusan terdekat
        // (misal: 870 -> 900, 375 -> 400, 325 -> 300)
        return round($uang / 100) * 100;
    } 
    // Aturan 2: Jika uang 1.000 ke atas
    else {
        // Selalu membulatkan KE ATAS untuk kelipatan 500
        // (misal: 1001 -> 1500, 1501 -> 2000, 1000 -> 1000)
        return ceil($uang / 500) * 500;
    }
}
?>