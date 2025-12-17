<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtjrnlcode']) && ($_POST['txtjrnlcode'] != ''))
    {
        $jrnlcode = $_POST['txtjrnlcode'];

        $update = "UPDATE trxajrnl SET TRXA_JRNL_STAT='Y'
				WHERE TRXA_JRNL_CODE='$jrnlcode'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: TRXAJRNL01.php");
    
    }
}
//else
//{
//  header("Location: "."index.php");
//}
?>