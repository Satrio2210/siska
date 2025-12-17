<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xhouscode = 'B4527bxb'; 
$houscode = xss_clean($rawdata);

$periksahouscode = "SELECT COUNT(*) FROM waremast WHERE WARE_HOUS_CODE='$houscode' AND WARE_HOUS_STAT='Y'";
$periksahouscode_di_query=$db->query($periksahouscode) or die ("Cek Fail");
$ketersediaan = $periksahouscode_di_query->fetchColumn();
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
