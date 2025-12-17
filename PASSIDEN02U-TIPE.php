<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

include "conf/config.php";
if (isset($_POST['q']))
    {
        //$rawinput = $_POST['q'];
        //list($userakses, $tipeid) = explode("|", $rawinput);

        $userakses = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $query_akses = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN = '$userakses' AND PASS_USER_TYPE = 'Y'";
        $qakses = $db->query($query_akses) or die("Field Akses Salah");
        $row = $qakses->fetchColumn();

        if ($row == 0)
        {
            // Tipe User Dokter
            $update_yes = "UPDATE passiden SET PASS_USER_TYPE='Y',
                    PASS_UPDT_DATE='$dateinput',
                    PASS_UPDT_TIME='$timeinput',
                    PASS_UPDT_USER='$userid'    
                WHERE PASS_USER_IDEN='$userakses'";
                // Prepare Request  
                $query_update_yes = $db->prepare($update_yes);

                // Mulai Input
                $db->beginTransaction();
                $query_update_yes->execute();
                $db->commit();
        }
        else
        {
            // Tipe user Non Dokter
            $update_no = "UPDATE passiden SET PASS_USER_TYPE='N',
                    PASS_UPDT_DATE='$dateinput',
                    PASS_UPDT_TIME='$timeinput',
                    PASS_UPDT_USER='$userid'    
                WHERE PASS_USER_IDEN='$userakses'";
                // Prepare Request  
                $query_update_no = $db->prepare($update_no);

                // Mulai Input
                $db->beginTransaction();
                $query_update_no->execute();
                $db->commit();
        }


    
    }
?>