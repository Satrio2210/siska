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
        $oldcoaccode = $_POST['hidcoaccode'];

        if(isset($_POST['optparentcode']) && ($_POST['optparentcode'] != '')) 
        {
         $parentcode = $_POST['optparentcode'];
        }

        if(isset($_POST['txtcoaccode']) && ($_POST['txtcoaccode'] != '')) 
        {
         $coaccode = $_POST['txtcoaccode'];
        }

        if(isset($_POST['txtcoacname']) && ($_POST['txtcoacname'] != '')) 
        {
         $coacname = $_POST['txtcoacname'];
        }

        $incoaccode = ''.$parentcode.''.$coaccode;
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tblacoac SET TBLA_COAC_CODE = '$incoaccode', TBLA_COAC_NAME='$coacname',
                    TBLA_UPDT_DATE='$dateinput',
                    TBLA_UPDT_TIME='$timeinput',
                    TBLA_UPDT_USER='$userid'    
				WHERE TBLA_COAC_CODE='$oldcoaccode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: TBLACOAC02.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>