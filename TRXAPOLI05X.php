<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xsgnacode = 'B4527bxb'; 
$sgnacode = xss_clean($rawdata);

$periksasgnacode = "SELECT COUNT(*) FROM tblpsgna WHERE TBLP_SGNA_CODE='$sgnacode' AND TBLP_SGNA_STAT='Y'";
$periksasgnacode_di_query=$db->query($periksasgnacode) or die ("Cek Fail");
$ketersediaan = $periksasgnacode_di_query->fetchColumn();
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
