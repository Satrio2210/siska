<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xlocacode = 'B4527bxb'; 
$locacode = xss_clean($rawdata);

$periksalocacode = "SELECT COUNT(*) FROM fixeloca WHERE FIXE_LOCA_CODE='$locacode' AND FIXE_VIEW_STAT='Y'";
$periksalocacode_di_query=$db->query($periksalocacode) or die ("Cek Fail");
$ketersediaan = $periksalocacode_di_query->fetchColumn();
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
