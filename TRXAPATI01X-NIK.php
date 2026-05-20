<?php
include "conf/config.php";

header('Content-Type: application/json; charset=utf-8');

$nik = $_POST['q'] ?? '';
$nik = trim($nik);

if ($nik === '' || strlen($nik) !== 16) {
  echo json_encode(['exists' => false]);
  exit;
}

/*
  SESUAIKAN NAMA TABEL / KOLOM DB LU:
  - patimast   : tabel pasien
  - PATI_PIDN  : kolom NIK (atau yang lu pakai)
  - PATI_NAME  : kolom nama pasien
*/
$sql = "SELECT PATI_MAIN_NAME, PATI_MAIN_BIRT
        FROM patimast
        WHERE PATI_MAIN_PIDN = :nik
        LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->execute([':nik' => $nik]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
  echo json_encode([
    'exists' => true,
    'name' => $row['PATI_MAIN_NAME'] ?? '',
    'tgllahir' => $row['PATI_MAIN_BIRT'] ?? ''
  ]);
} else {
  echo json_encode(['exists' => false]);
}
