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
        $manucode = $_POST['q'];

  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");


        $update = "UPDATE tbllmanu SET TBLL_VIEW_STAT='N',
                    TBLL_UPDT_DATE='$dateinput',
                    TBLL_UPDT_TIME='$timeinput',
                    TBLL_UPDT_USER='$userid'    
				WHERE TBLL_MANU_CODE='$manucode'";
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