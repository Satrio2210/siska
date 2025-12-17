<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['hidcoaccode']))
    {
        $coaccode = $_POST['hidcoaccode'];
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tblacoac SET TBLA_COAC_STAT = 'N',
                    TBLA_UPDT_DATE='$dateinput',
                    TBLA_UPDT_TIME='$timeinput',
                    TBLA_UPDT_USER='$userid'    
				WHERE TBLA_COAC_CODE='$coaccode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: TBLACOAC03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>