<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xpostcode = 'B4527bxb'; 
$postcode = xss_clean($rawdata);

$periksapostcode = "SELECT COUNT(*) FROM tblepost WHERE TBLE_POST_CODE='$postcode' AND TBLE_POST_STAT='Y'";
$periksapostcode_di_query=$db->query($periksapostcode) or die ("Cek Fail");
$ketersediaan = $periksapostcode_di_query->fetchColumn();
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
