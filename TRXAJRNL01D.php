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
        $hapusjurnal = $_POST['q'];
        //$hapusjurnal = 'TA-0001|2020-01-01|11.1.20000.00|BNI 46 (IDR) ( NO REK 0156788887 )|IDR|95.000.000|0|test aja';
        list($outjrnlcode, $outcoaccode, $outentrtime) = explode("|",$hapusjurnal);

        $delete = "DELETE FROM trxajrnl 
				WHERE TRXA_JRNL_CODE='$outjrnlcode' AND TRXA_COAC_CODE='$outcoaccode' AND TRXA_ENTR_TIME='$outentrtime'";

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