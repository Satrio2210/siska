<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$prsccode = trim($_POST['prsccode']);

if ($prsccode == '') {
    die("Kode resep kosong");
}

$sql = "
UPDATE trxaprsc
SET
    TRXA_PRSC_STAT='I',
    TRXA_UPDT_DATE=CURDATE(),
    TRXA_UPDT_TIME=CURTIME()
WHERE
    TRXA_PRSC_CODE='$prsccode'
    AND TRXA_VIEW_STAT='Y'
";

$q = $db->query($sql);

if (!$q) {
    print_r($db->errorInfo());
    exit;
}

echo "OK";
?>