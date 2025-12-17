<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$facturcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$facturcode);
//24102021-00001
if (strlen($facturcode) == 14)
{

// Start Hitung Pembayaran  
$sqlcount = "SELECT SUM(ITEM_STOCK_PRIC * ITEM_STOCK_QUTY) AS SUB_TOTAL FROM itemdrug               
             WHERE ITEM_DRUG_CODE = '$facturcode' AND ITEM_DRUG_STAT = 'I' AND ITEM_VIEW_STAT = 'Y'";

$q = $db->query($sqlcount) or die("Gagal Ambil Jumlah Item !!");
$r = $q->fetch(PDO::FETCH_ASSOC);

$xharga = round($r['SUB_TOTAL']);
$int = (int)$xharga;

$subtotal = pembulatan($int);

$viewprice = number_format($subtotal, 0, '', '.');

echo "$viewprice";

}
else
{
  echo "0";
}


?>	
