<?php
session_start();
include "conf/config.php";

//$rawdata = '17112021-00274|A00|Cholera';

$rawdata = $_POST['q'];
list($examcode,$diagcode,$diagname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxadiag = "SELECT COUNT(*) FROM trxadiag WHERE TRXA_EXAM_CODE='$examcode' AND TRXA_DIAG_CODE='$diagcode'";
$periksatrxadiag_di_query=$db->query($periksatrxadiag) or die ("Cek Fail");
$ketersediaan = $periksatrxadiag_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxadiag (
         TRXA_EXAM_CODE, TRXA_DIAG_CODE, TRXA_DIAG_NAME,
         TRXA_VIEW_STAT, 
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_EXAM_CODE, :TRXA_DIAG_CODE, :TRXA_DIAG_NAME,
        :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_EXAM_CODE' =>$examcode,':TRXA_DIAG_CODE' =>$diagcode,':TRXA_DIAG_NAME' =>$diagname,                
        ':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

}
else
{
$update = "UPDATE trxadiag SET TRXA_DIAG_CODE='$diagcode',
                    TRXA_DIAG_NAME='$diagname',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_EXAM_CODE='$examcode' AND TRXA_DIAG_CODE='$diagcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}




?>      
