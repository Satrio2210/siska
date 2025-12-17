<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xvarncode = 'B4527bxb'; 
$varncode = xss_clean($rawdata);

$periksavarncode = "SELECT COUNT(*) FROM tblivarn WHERE TBLI_VARN_CODE='$varncode' AND TBLI_VARN_STAT='Y'";
$periksavarncode_di_query=$db->query($periksavarncode) or die ("Cek Fail");
$ketersediaan = $periksavarncode_di_query->fetchColumn();
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
