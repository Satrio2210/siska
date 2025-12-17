<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xbankcode = 'B4527bxb'; 
$bankcode = xss_clean($rawdata);

$periksabankcode = "SELECT COUNT(*) FROM tblebank WHERE TBLE_BANK_CODE='$bankcode' AND TBLE_BANK_STAT='Y'";
$periksabankcode_di_query=$db->query($periksabankcode) or die ("Cek Fail");
$ketersediaan = $periksabankcode_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
    {
        echo "";
    }
    else
    {
        echo "0$ketersediaan";
    }
?>	
