<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtmastcode']))
    {
        if(isset($_POST['txtmastcode']) && ($_POST['txtmastcode'] != '')) 
        {
         $mastcode = $_POST['txtmastcode'];
        }

 
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE suplmast SET SUPL_VIEW_STAT='N', 
                    SUPL_UPDT_DATE='$dateinput',
                    SUPL_UPDT_TIME='$timeinput',
                    SUPL_UPDT_USER='$userid'    
				WHERE SUPL_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: SUPLMAST03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>