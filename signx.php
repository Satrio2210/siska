<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$xkodeid = $_GET['q']; 
$kodeid = xss_clean($xkodeid);
$kodepass = md5($_GET['r']);

if (($kodeid=="$idadmin") and ($kodepass=="$passadmin"))
{
	echo "|$kodeid|$kodepass|";
}
else
{
    $sql = "SELECT * FROM passiden WHERE PASS_USER_IDEN='$kodeid' AND PASS_USER_PSWD='$kodepass'";
    $q = $db->query($sql) or die("Gagal Login!!");
    while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
        	$userid = "$r[PASS_USER_IDEN]";
            $password = "$r[PASS_USER_PSWD]";
            echo "|$kodeid|$kodepass|";
        }
}
?>	
