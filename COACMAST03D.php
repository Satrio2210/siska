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
        $mastprnt = $_POST['txtprntcode'];

        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $delete = "UPDATE coacmast SET COAC_VIEW_STAT='N'     
				WHERE COAC_MAST_CODE='$mastcode'
                AND COAC_MAST_PRNT='$mastprnt'";
                // Prepare Request  
                $query_delete = $db->prepare($delete);

                // Mulai Input
                $db->beginTransaction();
                $query_delete->execute();
                $db->commit();
                header("location: COACMAST03.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>