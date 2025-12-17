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
        list($proccode,$partcode) = explode("|", $rawinput);
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        // Mengubah Status PO dari Barang dalam delivery menjadi telah di terima (Dari OP ke CL) 
        $update_trxaproc = "UPDATE trxaproc SET TRXA_PROC_STAT='CL',
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
        // Mengubah Status Item pada PO dari list yang di pesan menjadi list yang benar benar diterima (dari Y ke N)
        $update_itemproc = "UPDATE itemproc SET ITEM_VIEW_STAT='N',
                    ITEM_UPDT_DATE='$dateinput',
                    ITEM_UPDT_TIME='$timeinput',
                    ITEM_UPDT_USER='$userid'    
                WHERE ITEM_PROC_CODE='$proccode' AND ITEM_PART_CODE='$partcode'";
                // Prepare Request  
                $query_update_itemproc = $db->prepare($update_itemproc);

                // Mulai Input
                $db->beginTransaction();
                $query_update_itemproc->execute();
                $db->commit();

        // Mengubah Status Item Stock dari Item yang dalam proses delivery menjadi di terima dengan status belum di bayar lunas
        // dan memecah item dari satuan unit beli ke satuan unit jual retail
        $update_itemstock = "UPDATE investock SET INVE_VIEW_STAT='R',
                    INVE_UPDT_DATE='$dateinput',
                    INVE_UPDT_TIME='$timeinput',
                    INVE_UPDT_USER='$userid'    
                WHERE INVE_STOCK_CODE='$partcode' AND INVE_PROC_CODE='$proccode'";
                // Prepare Request  
                $query_update_itemstock = $db->prepare($update_itemstock);

                // Mulai Input
                $db->beginTransaction();
                $query_update_itemstock->execute();
                $db->commit();



    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>