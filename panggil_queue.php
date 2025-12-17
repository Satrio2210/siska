<?php
// panggil_queue.php
include "conf/config.php"; // ini file yang barusan lu kirim, sudah benar

header('Content-Type: application/json');

// Ambil data dari POST
$channel = isset($_POST['channel']) ? trim($_POST['channel']) : '';
$nomor = isset($_POST['nomor']) ? trim($_POST['nomor']) : '';
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$poli = isset($_POST['poli']) ? trim($_POST['poli']) : '';

// Kalau poli kosong, kasih default saja biar tidak bikin gagal
if ($poli === '') {
    $poli = 'Poli';
}

// DEBUG: kirim balik semua data POST biar kelihatan di Network > Response
// (kalau mau, nanti bisa dimatiin)
$debugPost = $_POST;

// Validasi minimal: channel & nomor Wajib
if ($channel === '' || $nomor === '') {
    echo json_encode([
        'ok' => false,
        'error' => 'Data tidak lengkap (channel / nomor kosong)',
        'post' => $debugPost,
        'parsed' => [
            'channel' => $channel,
            'nomor' => $nomor,
            'nama' => $nama,
            'poli' => $poli,
        ],
    ]);
    exit;
}

$now = date('Y-m-d H:i:s');

try {
    $sql = "INSERT INTO queue_calls (channel, queue_no, patient_name, poli_name, created_at)
            VALUES (:channel, :queue_no, :patient_name, :poli_name, :created_at)";

    $stmt = $db->prepare($sql);
    $ok = $stmt->execute([
        ':channel' => $channel,
        ':queue_no' => $nomor,
        ':patient_name' => $nama,
        ':poli_name' => $poli,
        ':created_at' => $now,
    ]);

    if (!$ok) {
        $err = $stmt->errorInfo();
        echo json_encode([
            'ok' => false,
            'error' => 'DB ERROR: ' . $err[2],
        ]);
    } else {
        echo json_encode([
            'ok' => true,
            'msg' => 'Inserted',
            'data' => [
                'channel' => $channel,
                'nomor' => $nomor,
                'nama' => $nama,
                'poli' => $poli,
            ],
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'error' => 'EXCEPTION: ' . $e->getMessage(),
    ]);
}
