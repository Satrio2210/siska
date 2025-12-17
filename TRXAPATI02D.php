<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
include "inc/sanie.php";

if (isset($_POST['q']))
    {
        $regicode = $_POST['q'];
        //$regicode = '09102021-00001';
        //list($outdoctuser, $outschddays, $outschdstart) = explode("|",$rawdata);
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");


        $update = "UPDATE trxaregi SET TRXA_REGI_STAT='X',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_REGI_CODE='$regicode'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Update
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

    }
?>