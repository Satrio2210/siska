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
        $houscode = $_POST['q'];
        //$houscode = 'GULA';
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE waremast SET WARE_HOUS_STAT='N',
                    WARE_UPDT_DATE='$dateinput',
                    WARE_UPDT_TIME='$timeinput',
                    WARE_UPDT_USER='$userid'    
				WHERE WARE_HOUS_CODE='$houscode'";
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