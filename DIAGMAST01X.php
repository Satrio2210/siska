<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xsgnacode = 'B4527bxb'; 
$icdcode = xss_clean($rawdata);

$periksaicdcode = "SELECT COUNT(*) FROM diagmast WHERE DIAG_ICD_CODE='$icdcode' AND DIAG_VIEW_STAT='Y'";
$periksaicdcode_di_query=$db->query($periksaicdcode) or die ("Cek Fail");
$ketersediaan = $periksaicdcode_di_query->fetchColumn();
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
