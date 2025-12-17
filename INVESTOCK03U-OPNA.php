<?php
session_start();
include "conf/config.php";

$opnacode = $_POST['q'];
//$opnacode = 'ST-0001';

//list($opnacode,$opnadate,$warecode,$opnadlay,$finsdate,$opnanote,$emplcode) = explode("|", $rawdata);

$opnastat = 'X';
$viewstat = 'Y';

$userid = $_SESSION['username'];
//$userid = 'ASRUL';
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$update = "UPDATE trxaopna SET TRXA_OPNA_STAT='$opnastat', TRXA_VIEW_STAT='$viewstat',
                              TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput', TRXA_UPDT_USER='$userid'    
            WHERE TRXA_OPNA_CODE='$opnacode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();


?>      
