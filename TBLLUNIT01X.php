<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xunitcode = 'B4527bxb'; 
$unitcode = xss_clean($rawdata);

$periksaunitcode = "SELECT COUNT(*) FROM tbllunit WHERE TBLL_UNIT_CODE='$unitcode' AND TBLL_VIEW_STAT='Y'";
$periksaunitcode_di_query=$db->query($periksaunitcode) or die ("Cek Fail");
$ketersediaan = $periksaunitcode_di_query->fetchColumn();
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
