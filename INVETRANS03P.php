<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtexeccode']) && ($_POST['txtexeccode'] != ''))
    {
        $execcode = $_POST['txtexeccode'];
        if(isset($_POST['txtrequcode']) && ($_POST['txtrequcode'] != ''))  {$requcode = $_POST['txtrequcode'];}//ok
        // update tabel trxaexec
        $update_exec = "UPDATE trxaexec SET TRXA_EXEC_STAT='P' 
                        WHERE TRXA_EXEC_CODE='$execcode'";

        $query_update_exec = $db->prepare($update_exec);

        $db->beginTransaction();
        $query_update_exec->execute();
        $db->commit();

        // update tabel trxarequ 
        $update_requ = "UPDATE trxarequ SET TRXA_REQU_STAT='X' 
                        WHERE TRXA_REQU_CODE='$requcode'";

        // Prepare Request  
        $query_update_requ = $db->prepare($update_requ);

        // Mulai Input
        $db->beginTransaction();
        $query_update_requ->execute();
        $db->commit();

        header("location: INVETRANS03.php");
    
    }
}
//else
//{
//  header("Location: "."index.php");
//}
?>