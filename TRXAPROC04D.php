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
        $proccode = xss_clean($_POST['q']);
        //$proccode = 'PO-0002';  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update_trxaproc = "UPDATE trxaproc SET TRXA_PROC_STAT='OP',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_PROC_CODE='$proccode'";
                // Prepare Request  
                $query_update_trxaproc = $db->prepare($update_trxaproc);

                // Mulai Input
                $db->beginTransaction();
                $query_update_trxaproc->execute();
                $db->commit();

        $update_itemproc = "UPDATE itemproc SET ITEM_QUTY_RCVE='0',ITEM_VIEW_STAT='Y',
                    ITEM_UPDT_DATE='$dateinput',
                    ITEM_UPDT_TIME='$timeinput',
                    ITEM_UPDT_USER='$userid'    
                WHERE ITEM_PROC_CODE='$proccode'";
                // Prepare Request  
                $query_update_itemproc = $db->prepare($update_itemproc);

                // Mulai Input
                $db->beginTransaction();
                $query_update_itemproc->execute();
                $db->commit();

        $delete_itemstock = "DELETE FROM investock 
                WHERE INVE_PROC_CODE='$proccode'";
                // Prepare Request  
                $query_delete_itemstock = $db->prepare($delete_itemstock);

                // Mulai Input
                $db->beginTransaction();
                $query_delete_itemstock->execute();
                $db->commit();


    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>