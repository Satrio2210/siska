<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $hapusitem = $_POST['q'];
        //$hapusitem = 'TA-0001|2020-01-01|11.1.20000.00|BNI 46 (IDR) ( NO REK 0156788887 )|IDR|95.000.000|0|test aja';
        list($outproccode, $outpartcode, $outentrtime) = explode("|",$hapusitem);

        $delete = "DELETE FROM itemproc 
				WHERE ITEM_PROC_CODE='$outproccode' AND ITEM_PART_CODE='$outpartcode' AND ITEM_ENTR_TIME='$outentrtime'";

                // Prepare Request  
                $query_delete = $db->prepare($delete);

                // Mulai Input
                $db->beginTransaction();
                $query_delete->execute();
                $db->commit();
                //header("location: TRXAJRNL01.php");
    
    }
}
//else
//{
//  header("Location: "."index.php");
//}
?>