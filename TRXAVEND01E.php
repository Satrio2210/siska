<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

$rawinput = xss_clean($_POST['q']);
//invendcode,invenddate,inproccode,inprocdivi,insuplcode,inprocvatx, indownpaid, inremapaid, ininvccode, indueddate

list($vendcode,$venddate,$proccode,$procdivi,$suplcode,$procvatx,$downpaid,$remapaid,$invccode,$dueddate) = explode("|",$rawinput);

$vendstat = 'R';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksapayment = "SELECT COUNT(*) FROM trxavend WHERE TRXA_VEND_CODE='$vendcode'";
$periksapayment_di_query=$db->query($periksapayment) or die ("Cek Code Payment Fail");
$ketersediaan = $periksapayment_di_query->fetchColumn();
//Cek adanya Kode paymen yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode payment baru
if ($ketersediaan == 0)
{

        $input_payment = "INSERT INTO trxavend (TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_PROC_CODE,
        TRXA_PROC_DIVI, TRXA_SUPL_CODE, TRXA_PROC_VATX,
        TRXA_DOWN_PAID, TRXA_REMA_PAID, TRXA_INVC_CODE, 
        TRXA_DUED_DATE, TRXA_VEND_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_VEND_CODE, :TRXA_VEND_DATE, :TRXA_PROC_CODE, 
        :TRXA_PROC_DIVI, :TRXA_SUPL_CODE, :TRXA_PROC_VATX,
        :TRXA_DOWN_PAID, :TRXA_REMA_PAID, :TRXA_INVC_CODE, 
        :TRXA_DUED_DATE, :TRXA_VEND_STAT, :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_payment = $db->prepare($input_payment);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_payment->execute(array(
        ':TRXA_VEND_CODE' =>$vendcode, ':TRXA_VEND_DATE' =>$venddate, ':TRXA_PROC_CODE' =>$proccode, 
        ':TRXA_PROC_DIVI' =>$procdivi, ':TRXA_SUPL_CODE' =>$suplcode, ':TRXA_PROC_VATX' =>$procvatx,
        ':TRXA_DOWN_PAID' =>$downpaid, ':TRXA_REMA_PAID' =>$remapaid, ':TRXA_INVC_CODE' =>$invccode,
        ':TRXA_DUED_DATE' =>$dueddate, ':TRXA_VEND_STAT' =>$vendstat, ':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_payment);
        ///exit();
        $db->commit();
        // Ubah status Invoice dari U menjadi O
        $update_invoice = "UPDATE trxainvc SET TRXA_INVC_STAT='O', 
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_INVC_CODE='$invccode'";
                // Prepare Request  
                $query_update = $db->prepare($update_invoice);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}
else
{
        $update = "UPDATE trxavend SET TRXA_VEND_STAT='$vendstat', 
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_VEND_CODE='$vendcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
}
?>      
