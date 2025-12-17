<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xpolicode = 'B4527bxb'; 
$policode = xss_clean($rawdata);

$periksapolicode = "SELECT COUNT(*) FROM tblapoli WHERE TBLA_POLI_CODE='$policode' AND TBLA_POLI_STAT='Y'";
$periksapolicode_di_query=$db->query($periksapolicode) or die ("Cek Fail");
$ketersediaan = $periksapolicode_di_query->fetchColumn();
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
