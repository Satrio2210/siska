<?php
include "conf/config.php";

header('Content-Type: application/json');

$channel = isset($_GET['channel']) ? trim($_GET['channel']) : 'POLI';

$sql = "SELECT id, channel, queue_no, patient_name, poli_name
        FROM queue_calls
        WHERE channel = :channel
        ORDER BY id DESC
        LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->execute([':channel' => $channel]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(null);
    exit;
}

echo json_encode($row);
