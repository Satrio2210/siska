<?php
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $vstcode = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE vstmast SET VST_VIEW_STAT='N',
                    VST_UPDT_DATE='$dateinput',
                    VST_UPDT_TIME='$timeinput',
                    VST_UPDT_USER='$userid'    
				WHERE VST_MAST_CODE='$vstcode'";


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