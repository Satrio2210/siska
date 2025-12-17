<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $rawdata = $_POST['q'];
        //$rawdata='DTIAR|1|14:51:45'
        list($outdoctuser, $outschddays, $outschdstart, $outschdend, $outentrtime) = explode("|",$rawdata);
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE trxaschd SET TRXA_VIEW_STAT='N',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_DOCT_USER='$outdoctuser' 
                AND TRXA_SCHD_DAYS='$outschddays' 
                AND TRXA_SCHD_START='$outschdstart'
                AND TRXA_ENTR_TIME='$outentrtime'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
    
    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>