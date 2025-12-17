<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

include "conf/config.php";
if (isset($_POST['q']))
    {
        $rawinput = $_POST['q'];
        list($userakses, $rawsandi) = explode("|", $rawinput);


        $sandi = md5($rawsandi);

        //$userakses = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

            // Password Baru
            $update_sandi = "UPDATE passiden SET PASS_USER_PSWD='$sandi',
                    PASS_UPDT_DATE='$dateinput',
                    PASS_UPDT_TIME='$timeinput',
                    PASS_UPDT_USER='$userid'    
                WHERE PASS_USER_IDEN='$userakses'";
                // Prepare Request  
                $query_update_sandi = $db->prepare($update_sandi);

                // Mulai Input
                $db->beginTransaction();
                $query_update_sandi->execute();
                $db->commit();
    
    }
?>