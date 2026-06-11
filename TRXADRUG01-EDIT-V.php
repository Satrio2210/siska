<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$prsccode = $_POST['prsccode'];
$stockcode = $_POST['stockcode'];

$xquery = "SELECT
          p.TRXA_PRSC_CODE,
          p.TRXA_STOCK_CODE,
          p.TRXA_STOCK_QUTY,
          p.TRXA_STOCK_BTCH,
          p.TRXA_PRSC_CONC,
          i.INVE_PART_NAME,
          s.TBLI_SPEC_NAME
          FROM trxaprsc p
          LEFT JOIN invemast i
          ON i.INVE_MAST_CODE=p.TRXA_STOCK_CODE
          LEFT JOIN tblispec s
          ON s.TBLI_SPEC_CODE=i.INVE_MAIN_SPEC
          WHERE
          p.TRXA_PRSC_CODE='$prsccode'
          AND p.TRXA_STOCK_CODE='$stockcode'
          AND p.TRXA_VIEW_STAT='Y'
          LIMIT 1
          ";

$q = $db->query($xquery) or die($db->errorInfo()[2]);

$row = $q->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    "prsccode" => $row['TRXA_PRSC_CODE'],
    "stockcode" => $row['TRXA_STOCK_CODE'],
    "stockname" => $row['INVE_PART_NAME'] . ' ' . $row['TBLI_SPEC_NAME'],
    "qty" => $row['TRXA_STOCK_QUTY'],
    "batch" => $row['TRXA_STOCK_BTCH'],
    "conc" => $row['TRXA_PRSC_CONC']
));
?>