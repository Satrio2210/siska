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
        $mastcode = $_POST['txtmastcode'];

        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $delete = "UPDATE invemast SET INVE_VIEW_STAT='N', 
                                      INVE_UPDT_DATE='$dateinput',
                                      INVE_UPDT_TIME='$timeinput',
                                      INVE_UPDT_USER='$userid'         
				   WHERE INVE_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_delete = $db->prepare($delete);

                // Mulai Input
                $db->beginTransaction();
                $query_delete->execute();
                $db->commit();
                header("location: INVEMAST03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>