<?php
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
include "inc/sanie.php";

if (isset($_POST['q']))
    {
        $rawinput = xss_clean($_POST['q']);
        list($prsccode, $stockcode, $prscconc, $stockbtch) = explode("|",$rawinput);  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update_trxaprsc = "UPDATE trxaprsc SET TRXA_STOCK_BTCH='$stockbtch',
                    TRXA_PRSC_CONC='$prscconc',
                    TRXA_PRSC_STAT='I',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_PRSC_CODE='$prsccode' AND TRXA_STOCK_CODE='$stockcode'";
                // Prepare Request  
                $query_update_trxaprsc = $db->prepare($update_trxaprsc);

                // Mulai Input
                $db->beginTransaction();
                $query_update_trxaprsc->execute();
                $db->commit();

    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>