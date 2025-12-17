<?php
session_start();
include "conf/config.php";
//inprsccode,inprscdoct,instockcode,instockpric,instockquty,inprscconc, inprscsgna, inprscusag, inmediroom

$rawdata = $_POST['q'];
list($prsccode,$prscdoct,$stockcode,$stockpric,$stockquty,$prscconc, $prscsgna,$prscusag,$mediroom) = explode("|", $rawdata);

$prscstat = 'A';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxaprsc = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$prsccode' AND TRXA_STOCK_CODE='$stockcode' 
                    AND TRXA_VIEW_STAT='Y'";

$periksatrxaprsc_di_query=$db->query($periksatrxaprsc) or die ("Cek Fail");
$ketersediaan = $periksatrxaprsc_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxaprsc (
         TRXA_PRSC_CODE, TRXA_PRSC_DOCT, TRXA_STOCK_CODE, TRXA_PRSC_CONC,
         TRXA_STOCK_PRIC,TRXA_STOCK_QUTY,TRXA_PRSC_SGNA,
        TRXA_PRSC_USAG,TRXA_MEDI_ROOM,TRXA_PRSC_STAT,
        TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER
) 
        VALUES (
        :TRXA_PRSC_CODE, :TRXA_PRSC_DOCT, :TRXA_STOCK_CODE, :TRXA_PRSC_CONC,
        :TRXA_STOCK_PRIC,:TRXA_STOCK_QUTY,:TRXA_PRSC_SGNA,
        :TRXA_PRSC_USAG,:TRXA_MEDI_ROOM,:TRXA_PRSC_STAT,
        :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);
//inprsccode,inprscdoct,instockcode,instockpric,instockquty,inprscsgna, inprscusag, inmediroom
        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_PRSC_CODE' =>$prsccode,':TRXA_PRSC_DOCT' =>$prscdoct,':TRXA_STOCK_CODE' =>$stockcode,
        ':TRXA_PRSC_CONC' =>$prscconc,                
        ':TRXA_STOCK_PRIC' =>$stockpric,':TRXA_STOCK_QUTY' =>$stockquty,':TRXA_PRSC_SGNA' =>$prscsgna,
        ':TRXA_PRSC_USAG' =>$prscusag,':TRXA_MEDI_ROOM' =>$mediroom,                
        ':TRXA_PRSC_STAT' =>$prscstat,':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

}
else
{
$update = "UPDATE trxaprsc SET TRXA_PRSC_CONC='$prscconc', 
                    TRXA_STOCK_PRIC='$stockpric',
                    TRXA_STOCK_QUTY='$stockquty',
                    TRXA_PRSC_SGNA='$prscsgna',
                    TRXA_PRSC_USAG='$prscusag',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_PRSC_CODE='$prsccode' AND TRXA_STOCK_CODE='$stockcode' 
                    AND TRXA_PRSC_STAT='A' AND TRXA_VIEW_STAT='Y'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
