<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//inpaymcode,inpaymdate,incoaccode,incheqcode,indivicode,inpayecode,inpaymamnt,inpaymnote

$rawdata = xss_clean($_POST['q']);
list($paymcode,$paymdate,$coaccode,$cheqcode,$divicode,$payecode,$xpaymamnt,$paymnote) = explode("|", $rawdata);

$paymamnt = str_replace(".","",$xpaymamnt);
$paymstat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksapaymen = "SELECT COUNT(*) FROM trxapaym WHERE TRXA_PAYM_CODE='$paymcode'";
$periksapaymen_di_query=$db->query($periksapaymen) or die ("Cek Fail");
$ketersediaan = $periksapaymen_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxapaym (
          TRXA_PAYM_CODE, TRXA_PAYM_DATE, TRXA_COAC_CODE, TRXA_CHEQ_CODE, 
          TRXA_DIVI_CODE, TRXA_PAYE_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_NOTE, 
          TRXA_PAYM_STAT, TRXA_VIEW_STAT, 
          TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
          TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
          :TRXA_PAYM_CODE, :TRXA_PAYM_DATE, :TRXA_COAC_CODE, :TRXA_CHEQ_CODE, 
          :TRXA_DIVI_CODE, :TRXA_PAYE_CODE, :TRXA_PAYM_AMNT, :TRXA_PAYM_NOTE,
          :TRXA_PAYM_STAT, :TRXA_VIEW_STAT, 
          :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
          :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//inmastcode,insubscode,insizename,inunitname,invalumin,invalumax,inpatigend

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_PAYM_CODE' =>$paymcode,':TRXA_PAYM_DATE' =>$paymdate,':TRXA_COAC_CODE' =>$coaccode,
        ':TRXA_CHEQ_CODE' =>$cheqcode,':TRXA_DIVI_CODE' =>$divicode,':TRXA_PAYE_CODE' =>$payecode,
        ':TRXA_PAYM_AMNT' =>$paymamnt,':TRXA_PAYM_NOTE' =>$paymnote,           
        ':TRXA_PAYM_STAT' =>$paymstat,':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE trxapaym SET TRXA_PAYM_DATE='$paymdate', TRXA_COAC_CODE='$coaccode',TRXA_CHEQ_CODE='$cheqcode', 
            TRXA_DIVI_CODE='$divicode', TRXA_PAYE_CODE='$payecode', TRXA_PAYM_AMNT='$paymamnt', TRXA_PAYM_NOTE='$paymnote',
            TRXA_PAYM_STAT='$paymstat', TRXA_VIEW_STAT='$viewstat',            
            TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',TRXA_UPDT_USER='$userid'    
            WHERE TRXA_PAYM_CODE='$paymcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
