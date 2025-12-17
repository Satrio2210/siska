<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_GET['q'];
//$kode = 'ASR'; 

if($kode)
{
        $sql = "SELECT * FROM passiden WHERE PASS_USER_IDEN = '$kode'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $useriden = "$r[PASS_USER_IDEN]";
            $username = "$r[PASS_USER_NAME]";
            $userpswd = "$r[PASS_USER_PSWD]";

            echo "|$useriden|$username|$userpswd|";
        }
}
?>  
