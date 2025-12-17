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
        $rawinput = $_POST['q'];
        //$rawinput = 'ST-0001|ALFA|0001|16:14:43|118';

        list($opnacode, $warecode, $stockcode, $timecode, $qtyopname) = explode("|",$rawinput);


  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");


        $update = "UPDATE investock SET INVE_STOCK_QUTY='$qtyopname', INVE_VIEW_STAT='Y',
                    INVE_UPDT_DATE='$dateinput',
                    INVE_UPDT_TIME='$timeinput',
                    INVE_UPDT_USER='$userid'    
                WHERE INVE_STOCK_CODE='$stockcode' AND INVE_WARE_CODE='$warecode' AND INVE_ENTR_TIME='$timecode'";
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