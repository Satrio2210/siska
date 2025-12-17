<?php
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $mastcode = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE labomast SET LABO_VIEW_STAT='N',
                    LABO_UPDT_DATE='$dateinput',
                    LABO_UPDT_TIME='$timeinput',
                    LABO_UPDT_USER='$userid'    
				WHERE LABO_MAST_CODE='$mastcode'";


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