<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//$inputorder = 'PO-0001|2021-03-09|2021-03-16|PRO|VE-0002|S|N|NLC|COD|500.000|12|0003|TBS Luar|4500|TON|1.230|1|P|2021-03-30|TBSG'; 
$inputorder = xss_clean($_POST['q']);
list($proccode, $procdate, $procdued, $procdivi, $suplcode, $procfrob, $procvatx, $proctype, $termpaid, $xdownpaid, $procterm, $partcode, $partname, $qutyordr, $partunit, $xpartpric, $chrgvalu, $chrgmthd, $arrvrequ, $warecode) = explode("|",$inputorder);

$downpaid = str_replace(".","",$xdownpaid);
$remapaid = '0';
$qutyrcve = '0';
$partpric = str_replace(".","",$xpartpric);

$procstat = 'AP';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaproccode = "SELECT COUNT(*) FROM trxaproc WHERE TRXA_PROC_CODE='$proccode' AND TRXA_PROC_STAT='AP'";
$periksaproccode_di_query=$db->query($periksaproccode) or die ("Cek Fail");
$ketersediaan = $periksaproccode_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode suplier baru
if ($ketersediaan == 0)
   {

        $inputheader = "INSERT INTO trxaproc (
        TRXA_PROC_CODE, TRXA_PROC_DATE, TRXA_PROC_DUED, TRXA_PROC_DIVI, TRXA_PROC_STAT, TRXA_SUPL_CODE,
        TRXA_PROC_FROB, TRXA_PROC_VATX, TRXA_PROC_TYPE, TRXA_TERM_PAID, TRXA_DOWN_PAID, TRXA_REMA_PAID, 
        TRXA_PROC_TERM, TRXA_VIEW_STAT,          
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_PROC_CODE, :TRXA_PROC_DATE, :TRXA_PROC_DUED, :TRXA_PROC_DIVI, :TRXA_PROC_STAT, :TRXA_SUPL_CODE,
        :TRXA_PROC_FROB, :TRXA_PROC_VATX, :TRXA_PROC_TYPE, :TRXA_TERM_PAID, :TRXA_DOWN_PAID, :TRXA_REMA_PAID, 
        :TRXA_PROC_TERM, :TRXA_VIEW_STAT,          
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_header = $db->prepare($inputheader);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_header->execute(array(
        ':TRXA_PROC_CODE' =>$proccode, ':TRXA_PROC_DATE' =>$procdate, ':TRXA_PROC_DUED' =>$procdued,   
        ':TRXA_PROC_DIVI' =>$procdivi, ':TRXA_PROC_STAT' =>$procstat, ':TRXA_SUPL_CODE' =>$suplcode,                 
        ':TRXA_PROC_FROB' =>$procfrob, ':TRXA_PROC_VATX' =>$procvatx, ':TRXA_PROC_TYPE' =>$proctype, 
        ':TRXA_TERM_PAID' =>$termpaid, ':TRXA_DOWN_PAID' =>$downpaid, ':TRXA_REMA_PAID' =>$remapaid, 
        ':TRXA_PROC_TERM' =>$procterm, ':TRXA_VIEW_STAT' =>$viewstat, 
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_header);
        ///exit();
        $db->commit();

        $inputitem = "INSERT INTO itemproc (
        ITEM_PROC_CODE, ITEM_PART_CODE, ITEM_PART_UNIT,  
        ITEM_QUTY_ORDR, ITEM_PART_PRIC, ITEM_CHRG_VALU, 
        ITEM_CHRG_MTHD, ITEM_ARRV_REQU, ITEM_WARE_CODE, ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (
        :ITEM_PROC_CODE, :ITEM_PART_CODE, :ITEM_PART_UNIT,  
        :ITEM_QUTY_ORDR, :ITEM_PART_PRIC, :ITEM_CHRG_VALU, 
        :ITEM_CHRG_MTHD, :ITEM_ARRV_REQU, :ITEM_WARE_CODE, :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";
        // Prepare Request  
        $query_input_item = $db->prepare($inputitem);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_item->execute(array(
        ':ITEM_PROC_CODE' =>$proccode, ':ITEM_PART_CODE' =>$partcode, ':ITEM_PART_UNIT' =>$partunit,   
        ':ITEM_QUTY_ORDR' =>$qutyordr, ':ITEM_PART_PRIC' =>$partpric, ':ITEM_CHRG_VALU' =>$chrgvalu, 
        ':ITEM_CHRG_MTHD' =>$chrgmthd, ':ITEM_ARRV_REQU' =>$arrvrequ, ':ITEM_WARE_CODE' =>$warecode,
        ':ITEM_VIEW_STAT' =>$viewstat,
        ':ITEM_ENTR_DATE' =>$dateinput,':ITEM_ENTR_TIME' =>$timeinput,':ITEM_ENTR_USER' =>$userid,  
        ':ITEM_UPDT_DATE' =>$dateinput,':ITEM_UPDT_TIME' =>$timeinput,':ITEM_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_item);
        ///exit();
        $db->commit();

   }
   else
   {
    $update_header = "UPDATE trxaproc SET TRXA_PROC_DATE='$procdate',
    TRXA_PROC_DUED='$procdued', TRXA_PROC_DIVI='$procdivi',
    TRXA_PROC_STAT='$procstat', TRXA_SUPL_CODE='$suplcode',  
    TRXA_PROC_FROB='$procfrob', TRXA_PROC_VATX='$procvatx',
    TRXA_PROC_TYPE='$proctype', TRXA_TERM_PAID='$termpaid',
    TRXA_DOWN_PAID='$downpaid', TRXA_REMA_PAID='$remapaid',
    TRXA_PROC_TERM='$procterm',  
    TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',
    TRXA_UPDT_USER='$userid'    
    WHERE TRXA_PROC_CODE='$proccode'";
    // Prepare Request  
    $query_update = $db->prepare($update_header);

    $db->beginTransaction();
    $query_update->execute();
    $db->commit();
/////
        $inputitem = "INSERT INTO itemproc (
        ITEM_PROC_CODE, ITEM_PART_CODE, ITEM_PART_UNIT,  
        ITEM_QUTY_ORDR, ITEM_PART_PRIC, ITEM_CHRG_VALU, 
        ITEM_CHRG_MTHD, ITEM_ARRV_REQU, ITEM_WARE_CODE, ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (
        :ITEM_PROC_CODE, :ITEM_PART_CODE, :ITEM_PART_UNIT,  
        :ITEM_QUTY_ORDR, :ITEM_PART_PRIC, :ITEM_CHRG_VALU, 
        :ITEM_CHRG_MTHD, :ITEM_ARRV_REQU, :ITEM_WARE_CODE, :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";
        // Prepare Request  
        $query_input_item = $db->prepare($inputitem);

        // Mulai Input
        ///var_dump(array(

        $db->beginTransaction();
        $query_input_item->execute(array(
        ':ITEM_PROC_CODE' =>$proccode, ':ITEM_PART_CODE' =>$partcode, ':ITEM_PART_UNIT' =>$partunit,   
        ':ITEM_QUTY_ORDR' =>$qutyordr, ':ITEM_PART_PRIC' =>$partpric, ':ITEM_CHRG_VALU' =>$chrgvalu, 
        ':ITEM_CHRG_MTHD' =>$chrgmthd, ':ITEM_ARRV_REQU' =>$arrvrequ, ':ITEM_WARE_CODE' =>$warecode,
        ':ITEM_VIEW_STAT' =>$viewstat,
        ':ITEM_ENTR_DATE' =>$dateinput,':ITEM_ENTR_TIME' =>$timeinput,':ITEM_ENTR_USER' =>$userid,  
        ':ITEM_UPDT_DATE' =>$dateinput,':ITEM_UPDT_TIME' =>$timeinput,':ITEM_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_item);
        ///exit();
        $db->commit();

   }
?>      
