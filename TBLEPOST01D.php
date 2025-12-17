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
        $postcode = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tblepost SET TBLE_POST_STAT='N',
                    TBLE_UPDT_DATE='$dateinput',
                    TBLE_UPDT_TIME='$timeinput',
                    TBLE_UPDT_USER='$userid'    
				WHERE TBLE_POST_CODE='$postcode'";
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