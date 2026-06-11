<?php

include "conf/config.php";
include "inc/sanie.php";

$prsccode = $_POST['prsccode'];
$stockcode = $_POST['stockcode'];

$sql = "
UPDATE trxaprsc
SET
TRXA_VIEW_STAT='N'
WHERE
TRXA_PRSC_CODE='$prsccode'
AND TRXA_STOCK_CODE='$stockcode'
";

$q = $db->query($sql);

if (!$q) {
    print_r($db->errorInfo());
    exit;
}

echo "OK";