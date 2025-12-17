<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata = 'PEL';
$typecode = xss_clean($rawdata);

$periksatypecode = "SELECT COUNT(*) FROM tblitype WHERE TBLI_TYPE_CODE='$typecode' AND TBLI_TYPE_STAT='Y'";
$periksatypecode_di_query=$db->query($periksatypecode) or die ("Cek Fail");
$ketersediaan = $periksatypecode_di_query->fetchColumn();
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
