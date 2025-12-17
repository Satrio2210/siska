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
        $icdcode = $_POST['q'];

  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE diagmast SET DIAG_VIEW_STAT='N',
                    DIAG_UPDT_DATE='$dateinput',
                    DIAG_UPDT_TIME='$timeinput',
                    DIAG_UPDT_USER='$userid'    
				WHERE DIAG_ICD_CODE='$icdcode'";
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