<?php
include "conf/config.php"; // pastiin ada $db (PDO) di sini

$regicode = isset($_POST['regicode']) ? $_POST['regicode'] : '';
$pname = isset($_POST['pname']) ? $_POST['pname'] : '';

if ($regicode != '' && $pname != '') {
    $stmt = $db->prepare("INSERT INTO queue_calls (regicode, pname, created_at)
                          VALUES (:regicode, :pname, NOW())");
    $stmt->execute([
        ':regicode' => $regicode,
        ':pname' => $pname
    ]);

    echo "OK";
} else {
    http_response_code(400);
    echo "INVALID";
}