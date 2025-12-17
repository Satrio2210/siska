<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_POST['q']; 

if($kode)
{
        $sql = "SELECT * FROM passiden WHERE PASS_USER_IDEN = '$kode'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $useriden = "$r[PASS_USER_IDEN]";
            $username = "$r[PASS_USER_NAME]";
            echo "|$useriden|$username|";
        }
}
?>	
