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
        $unitcode = $_POST['q'];

  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");


        $update = "UPDATE tbliunit SET TBLI_UNIT_STAT='N',
                    TBLI_UPDT_DATE='$dateinput',
                    TBLI_UPDT_TIME='$timeinput',
                    TBLI_UPDT_USER='$userid'    
				WHERE TBLI_UNIT_CODE='$unitcode'";
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