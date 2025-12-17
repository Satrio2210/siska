<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_GET['q'];
//$kode = 'IDR'; 

if($kode)
{
        $sql = "SELECT * FROM tbledivi WHERE TBLE_DIVI_CODE = '$kode' AND TBLE_DIVI_STAT='Y'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $divicode = "$r[TBLE_DIVI_CODE]";
            $diviname = "$r[TBLE_DIVI_NAME]";
 
            echo "|$divicode|$diviname|";
        }
}
?>	
