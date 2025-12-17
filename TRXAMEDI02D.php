<?php
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $feecode = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE feemast SET FEE_VIEW_STAT='N',
                    FEE_UPDT_DATE='$dateinput',
                    FEE_UPDT_TIME='$timeinput',
                    FEE_UPDT_USER='$userid'    
				WHERE FEE_MAST_CODE='$feecode'";


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