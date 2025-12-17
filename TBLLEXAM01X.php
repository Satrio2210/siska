<?php
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$xexamcode = 'B4527bxb'; 
$examcode = xss_clean($rawdata);

$periksaexamcode = "SELECT COUNT(*) FROM tbllexam WHERE TBLL_EXAM_CODE='$examcode' AND TBLL_VIEW_STAT='Y'";
$periksaexamcode_di_query=$db->query($periksaexamcode) or die ("Cek Fail");
$ketersediaan = $periksaexamcode_di_query->fetchColumn();
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
