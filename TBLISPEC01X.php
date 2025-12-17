<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xspeccode = 'B4527bxb'; 
$speccode = xss_clean($rawdata);

$periksaspeccode = "SELECT COUNT(*) FROM tblispec WHERE TBLI_SPEC_CODE='$speccode' AND TBLI_SPEC_STAT='Y'";
$periksaspeccode_di_query=$db->query($periksaspeccode) or die ("Cek Fail");
$ketersediaan = $periksaspeccode_di_query->fetchColumn();
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
