<?php
include "conf/config.php";

$querylist = "SELECT COUNT(*) AS REGI_LIST FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow'";

$qlist = $db->query($querylist) or die("Gagal Ambil Nomor Antrian  terakhir!!");
$rlist = $qlist->fetch(PDO::FETCH_ASSOC);

//$listcode = $rlist['TRXA_REGI_LIST'] = isset($rlist['TRXA_REGI_LIST']) ? $rlist['TRXA_REGI_LIST'] : '';
$listcode = $rlist['REGI_LIST'] = isset($rlist['REGI_LIST']) ? $rlist['REGI_LIST'] : '';
// ambil 3 huruf dari kanan
$xcodel = substr($listcode, -3);
$intl = (int)$xcodel;
$intl++;

$xlistcode = sprintf("%'.03d\n", $intl);

$regilist = $xlistcode;

echo $regilist;
?>