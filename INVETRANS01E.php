<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
list($requcode, $requdate, $trandate, $rcvedate, $warefrom, $waredest) = explode("|", $rawdata);

$requstat = 'R';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxarequ = "SELECT COUNT(*) FROM trxarequ WHERE TRXA_REQU_CODE='$requcode'";
$periksatrxarequ_di_query=$db->query($periksatrxarequ) or die ("Cek Fail");
$ketersediaan = $periksatrxarequ_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO trxarequ (
        TRXA_REQU_CODE, TRXA_REQU_DATE, 
        TRXA_TRAN_DATE, TRXA_RCVE_DATE, 
        TRXA_WARE_FROM, TRXA_WARE_DEST, 
        TRXA_REQU_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_REQU_CODE, :TRXA_REQU_DATE, 
        :TRXA_TRAN_DATE, :TRXA_RCVE_DATE,
        :TRXA_WARE_FROM, :TRXA_WARE_DEST, 
        :TRXA_REQU_STAT, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_REQU_CODE' =>$requcode,':TRXA_REQU_DATE' =>$requdate,
        ':TRXA_TRAN_DATE' =>$trandate,':TRXA_RCVE_DATE' =>$rcvedate,                   
        ':TRXA_WARE_FROM' =>$warefrom,':TRXA_WARE_DEST' =>$waredest,
        ':TRXA_REQU_STAT' =>$requstat,':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE trxarequ SET TRXA_REQU_DATE='$requdate',
                  TRXA_TRAN_DATE='$trandate', TRXA_RCVE_DATE='$rcvedate',
                  TRXA_WARE_FROM='$warefrom', TRXA_WARE_DEST='$waredest',
                  TRXA_REQU_STAT='$requstat', TRXA_VIEW_STAT='$viewstat',
                  TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput', TRXA_UPDT_USER='$userid'    
            WHERE TRXA_REQU_CODE='$requcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
}

?>      
