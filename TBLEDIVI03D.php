<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['hiddivicode']))
    {
        $divicode = $_POST['hiddivicode'];

        if(isset($_POST['txtdivicode']) && ($_POST['txtdivicode'] != '')) 
        {
         $divicode = $_POST['txtdivicode'];
        }

        if(isset($_POST['txtdiviname']) && ($_POST['txtdiviname'] != '')) 
        {
         $diviname = $_POST['txtdiviname'];
        }

 
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tbledivi SET TBLE_DIVI_STAT = 'N',
                    TBLE_UPDT_DATE='$dateinput',
                    TBLE_UPDT_TIME='$timeinput',
                    TBLE_UPDT_USER='$userid'    
				WHERE TBLE_DIVI_CODE='$divicode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: TBLEDIVI03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>