<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
list($csblcode,$csbldoct,$stockcode,$stockpric,$stockquty,$mediroom) = explode("|", $rawdata);

$csblstat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxacsbl = "SELECT COUNT(*) FROM trxacsbl WHERE TRXA_CSBL_CODE='$csblcode' AND TRXA_STOCK_CODE='$stockcode' 
                    AND TRXA_VIEW_STAT='Y'";
$periksatrxacsbl_di_query=$db->query($periksatrxacsbl) or die ("Cek Fail");
$ketersediaan = $periksatrxacsbl_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxacsbl (
         TRXA_CSBL_CODE, TRXA_CSBL_DOCT, TRXA_STOCK_CODE,
         TRXA_STOCK_PRIC,TRXA_STOCK_QUTY, TRXA_MEDI_ROOM,
         TRXA_CSBL_STAT, TRXA_VIEW_STAT,
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_CSBL_CODE, :TRXA_CSBL_DOCT, :TRXA_STOCK_CODE,
        :TRXA_STOCK_PRIC,:TRXA_STOCK_QUTY,:TRXA_MEDI_ROOM,
        :TRXA_CSBL_STAT, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);
//$csblcode,$csbldoct,$stockcode,$stockpric,$stockquty,$mediroom
        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_CSBL_CODE' =>$csblcode,':TRXA_CSBL_DOCT' =>$csbldoct,':TRXA_STOCK_CODE' =>$stockcode,                
        ':TRXA_STOCK_PRIC' =>$stockpric,':TRXA_STOCK_QUTY' =>$stockquty,':TRXA_MEDI_ROOM' =>$mediroom,                
        ':TRXA_CSBL_STAT' =>$csblstat,':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

}
else
{
$update = "UPDATE trxacsbl SET TRXA_STOCK_PRIC='$stockpric',
                    TRXA_STOCK_QUTY='$stockquty',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_CSBL_CODE='$csblcode' AND TRXA_STOCK_CODE='$stockcode' 
                    AND TRXA_CSBL_STAT='I' AND TRXA_VIEW_STAT='Y'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
