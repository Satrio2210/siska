<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
//$rawdata = "08012022-00032|TUN|0|0|0030|345|A01753|1|N|03|Oral";

list($drugcode,$paymmode,$xpaymamnt,$xpaymdisc,$stockcode,$xstockpric,$stockbtch,$stockquty,$drugconc,$drugsgna,$drugusag) = explode("|", $rawdata);

$drugstat = 'I';
$viewstat = 'Y';
$paymamnt = str_replace(".","",$xpaymamnt);
$paymdisc = str_replace(".","",$xpaymdisc);
$stockpric = str_replace(".","",$xstockpric);
//$realpric = str_replace(".","",$xstockpric);

$paymouts = 0;
//$stockpric = $realpric * $profit;

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxadrug = "SELECT COUNT(*) FROM trxadrug WHERE TRXA_DRUG_CODE='$drugcode' AND TRXA_DRUG_STAT='I' 
                    AND TRXA_VIEW_STAT='Y'";

$periksatrxadrug_di_query=$db->query($periksatrxadrug) or die ("Cek Fail");
$ketersediaan = $periksatrxadrug_di_query->fetchColumn();

if ($ketersediaan == 0)
{

         $input = "INSERT INTO trxadrug (
         TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, 
         TRXA_PAYM_OUTS, TRXA_PAYM_MODE, TRXA_DRUG_STAT, 
         TRXA_VIEW_STAT,
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_DRUG_CODE, :TRXA_PAYM_AMNT, :TRXA_PAYM_DISC, 
        :TRXA_PAYM_OUTS, :TRXA_PAYM_MODE, :TRXA_DRUG_STAT, 
        :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input Tabel trxadrug
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_DRUG_CODE' =>$drugcode,':TRXA_PAYM_AMNT' =>$paymamnt,':TRXA_PAYM_DISC' =>$paymdisc,
        ':TRXA_PAYM_OUTS' =>$paymouts,':TRXA_PAYM_MODE' =>$paymmode,':TRXA_DRUG_STAT' =>$drugstat,
        ':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        $inputitem = "INSERT INTO itemdrug (
        ITEM_DRUG_CODE, ITEM_STOCK_CODE, ITEM_STOCK_BTCH,  
        ITEM_DRUG_CONC, ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, 
        ITEM_DRUG_SGNA, ITEM_DRUG_USAG, ITEM_DRUG_STAT,
        ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (
        :ITEM_DRUG_CODE, :ITEM_STOCK_CODE, :ITEM_STOCK_BTCH,  
        :ITEM_DRUG_CONC, :ITEM_STOCK_PRIC, :ITEM_STOCK_QUTY, 
        :ITEM_DRUG_SGNA, :ITEM_DRUG_USAG, :ITEM_DRUG_STAT,
        :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";
        // Prepare Request  
        $query_inputitem = $db->prepare($inputitem);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_inputitem->execute(array(
        ':ITEM_DRUG_CODE' =>$drugcode, ':ITEM_STOCK_CODE' =>$stockcode, ':ITEM_STOCK_BTCH' =>$stockbtch,   
        ':ITEM_DRUG_CONC' =>$drugconc, ':ITEM_STOCK_PRIC' =>$stockpric, ':ITEM_STOCK_QUTY' =>$stockquty, 
        ':ITEM_DRUG_SGNA' =>$drugsgna, ':ITEM_DRUG_USAG' =>$drugusag, ':ITEM_DRUG_STAT' =>$drugstat,
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

$update = "UPDATE trxadrug SET TRXA_PAYM_MODE='$paymmode',
           TRXA_UPDT_DATE='$dateinput', TRXA_UPDT_TIME='$timeinput',
           TRXA_UPDT_USER='$userid'    
           WHERE TRXA_DRUG_CODE='$drugcode' 
           AND TRXA_DRUG_STAT='I' AND TRXA_VIEW_STAT='Y'";
           // Prepare Request  
           $query_update = $db->prepare($update);

           // Mulai Input
           $db->beginTransaction();
           $query_update->execute();
           $db->commit();

        $inputitem = "INSERT INTO itemdrug (
        ITEM_DRUG_CODE, ITEM_STOCK_CODE, ITEM_STOCK_BTCH,  
        ITEM_DRUG_CONC, ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, 
        ITEM_DRUG_SGNA, ITEM_DRUG_USAG, ITEM_DRUG_STAT,
        ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (
        :ITEM_DRUG_CODE, :ITEM_STOCK_CODE, :ITEM_STOCK_BTCH,  
        :ITEM_DRUG_CONC, :ITEM_STOCK_PRIC, :ITEM_STOCK_QUTY, 
        :ITEM_DRUG_SGNA, :ITEM_DRUG_USAG, :ITEM_DRUG_STAT,
        :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";
        // Prepare Request  
        $query_inputitem = $db->prepare($inputitem);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_inputitem->execute(array(
        ':ITEM_DRUG_CODE' =>$drugcode, ':ITEM_STOCK_CODE' =>$stockcode, ':ITEM_STOCK_BTCH' =>$stockbtch,   
        ':ITEM_DRUG_CONC' =>$drugconc, ':ITEM_STOCK_PRIC' =>$stockpric, ':ITEM_STOCK_QUTY' =>$stockquty, 
        ':ITEM_DRUG_SGNA' =>$drugsgna, ':ITEM_DRUG_USAG' =>$drugusag, ':ITEM_DRUG_STAT' =>$drugstat,
        ':ITEM_VIEW_STAT' =>$viewstat,
        ':ITEM_ENTR_DATE' =>$dateinput,':ITEM_ENTR_TIME' =>$timeinput,':ITEM_ENTR_USER' =>$userid,  
        ':ITEM_UPDT_DATE' =>$dateinput,':ITEM_UPDT_TIME' =>$timeinput,':ITEM_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_item);
        ///exit();
        $db->commit();

}



?>      
