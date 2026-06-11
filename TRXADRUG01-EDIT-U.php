<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$prsccode = trim($_POST['prsccode']);
$stockcode = trim($_POST['stockcode']);

$qty = trim($_POST['qty']);
$batch = trim($_POST['batch']);
$conc = trim($_POST['conc']);

if (
    $prsccode == '' ||
    $stockcode == '' ||
    $qty == ''
) {
    die("Data tidak lengkap");
}

$update = "UPDATE trxaprsc
SET
    TRXA_STOCK_QUTY = '$qty',
    TRXA_STOCK_BTCH = '$batch',
    TRXA_PRSC_CONC  = '$conc'
WHERE
    TRXA_PRSC_CODE  = '$prsccode'
AND TRXA_STOCK_CODE = '$stockcode'
AND TRXA_VIEW_STAT = 'Y'
";

$q = $db->query($update);

if (!$q) {
    print_r($db->errorInfo());
    exit;
}

echo "OK";
?>