<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xmanucode = 'B4527bxb'; 
$manucode = xss_clean($rawdata);

$periksamanucode = "SELECT COUNT(*) FROM tbllmanu WHERE TBLL_MANU_CODE='$manucode' AND TBLL_VIEW_STAT='Y'";
$periksamanucode_di_query=$db->query($periksamanucode) or die ("Cek Fail");
$ketersediaan = $periksamanucode_di_query->fetchColumn();
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
