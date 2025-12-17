<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include "inc/sanie.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $rawdata = xss_clean($_POST['q']);
        list($jrnlcode, $coaccode, $entrtime) = explode("|",$rawdata);

$jrnlstat = 'N';
$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

        $update = "UPDATE trxajrnl SET TRXA_JRNL_STAT = 'N',
                TRXA_UPDT_DATE='$dateinput', TRXA_UPDT_TIME='$timeinput', TRXA_UPDT_USER='$userid'
				WHERE TRXA_JRNL_CODE='$jrnlcode' AND TRXA_COAC_CODE='$coaccode' AND TRXA_ENTR_TIME='$entrtime'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
    
    }
}
?>