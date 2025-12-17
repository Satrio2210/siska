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
        if(isset($_POST['tglrsgndate']) && ($_POST['tglrsgndate'] != ''))
        { $rsgndate = $_POST['tglrsgndate']; }

        if(isset($_POST['txtrsgnnote']) && ($_POST['txtrsgnnote'] != ''))
        { $rsgnnote = $_POST['txtrsgnnote']; }

 
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE emplmast SET EMPL_RSGN_DATE='$rsgndate', EMPL_RSGN_NOTE='$rsgnnote', EMPL_VIEW_STAT='N', 
                    EMPL_UPDT_DATE='$dateinput',
                    EMPL_UPDT_TIME='$timeinput',
                    EMPL_UPDT_USER='$userid'    
				WHERE EMPL_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: EMPLMAST03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>