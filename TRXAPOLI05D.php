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
        $sgnacode = $_POST['q'];

  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tblpsgna SET TBLP_SGNA_STAT='N',
                    TBLP_UPDT_DATE='$dateinput',
                    TBLP_UPDT_TIME='$timeinput',
                    TBLP_UPDT_USER='$userid'    
				WHERE TBLP_SGNA_CODE='$sgnacode'";
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