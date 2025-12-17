<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_GET['q']; 

if($kode)
{
        $sql = "SELECT * FROM tblacoac WHERE TBLA_COAC_CODE = '$kode'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $coaccode = "$r[TBLA_COAC_CODE]";
            $coacname = "$r[TBLA_COAC_NAME]";
            echo "|$coaccode|$coacname|";
        }
}
?>	
