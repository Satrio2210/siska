<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
// Start Generate Kode Urut  
$sqllast = "SELECT TRXA_DRUG_CODE FROM trxadrug               
            ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
            LIMIT 1";
$q = $db->query($sqllast) or die("Gagal Ambil Kode Penjualan Terakhir!!");
$r = $q->fetch(PDO::FETCH_ASSOC);

$sequcode = $r['TRXA_DRUG_CODE'];
// ambil 4 huruf dari kanan
$xcode = substr($sequcode, -5);
$int = (int)$xcode;
$int++;

if ($int >= 10)
    { $xsequcode = "-000" . $int; }

else if ($int >= 100)

    { $xsequcode = "-00" . $int;}

else if ($int >= 1000)
    { $xsequcode = "-0" . $int;}

else if ($int >= 10000)
    { $xsequcode = "-" . $int;}

else { $xsequcode = "-0000" . $int;}

$drugcode = $daynow . '' . $monthnow . '' . $yearnow . '' . $xsequcode;
echo "$drugcode";
// End Generate Kode Pendaftaran         
}
else
{
  echo "0000";
}

?>	
