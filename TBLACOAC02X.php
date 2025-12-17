<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_GET['q'];
//$kode = '1.1'; 

if($kode)
{
        $sql = "SELECT * FROM tblacoac WHERE TBLA_COAC_CODE = '$kode' AND TBLA_COAC_STAT='Y'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $coaccode = "$r[TBLA_COAC_CODE]";
            $coacname = "$r[TBLA_COAC_NAME]";
 
            echo "|$coaccode|$coacname|";
        }
}
?>	
