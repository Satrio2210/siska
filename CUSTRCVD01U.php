<?php
session_start();
include "conf/config.php";

if (isset($_POST['q']))
    {

    $rawdata = $_POST['q'];

    list($regicode,$salecode,$paymmode) = explode("|", $rawdata);

    $viewstat = 'Y';

    $userid = $_SESSION['username'];
    $dateinput = date("Y-m-d");
    $timeinput = date("H:i:s");

    $update = "UPDATE trxasale SET TRXA_PAYM_MODE='$paymmode',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_SALE_CODE='$salecode' AND TRXA_REGI_CODE='$regicode' 
                   AND TRXA_VIEW_STAT='Y'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
    }

?>      
