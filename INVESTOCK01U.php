<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];

//opnacode, opnadate, warecode, opnadlay, finsdate, opnanote, emplcode

list($opnacode,$opnadate,$warecode,$opnadlay,$finsdate,$opnanote,$emplcode) = explode("|", $rawdata);

$opnastat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
//$userid = 'ASRUL';
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

//Cek adanya data Trans opname pada tabel trxaopna jika tidak ada input jika ada update

$periksainvestock = "SELECT COUNT(*) FROM trxaopna WHERE TRXA_OPNA_CODE='$opnacode' 
                     
                     AND TRXA_OPNA_STAT='I'";

$periksainvestock_di_query=$db->query($periksainvestock) or die ("Cek Fail");

$ketersediaan = $periksainvestock_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxaopna (
        TRXA_OPNA_CODE, TRXA_OPNA_DATE, TRXA_WARE_CODE, 
        TRXA_OPNA_DLAY, TRXA_FINS_DATE, TRXA_OPNA_NOTE, 
        TRXA_EMPL_CODE, TRXA_OPNA_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_OPNA_CODE, :TRXA_OPNA_DATE, :TRXA_WARE_CODE, 
        :TRXA_OPNA_DLAY, :TRXA_FINS_DATE, :TRXA_OPNA_NOTE, 
        :TRXA_EMPL_CODE, :TRXA_OPNA_STAT, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);
//opnacode, opnadate, warecode, opnadlay, finsdate, opnanote, emplcode

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
       ':TRXA_OPNA_CODE' =>$opnacode,':TRXA_OPNA_DATE' =>$opnadate,':TRXA_WARE_CODE' =>$warecode,
       ':TRXA_OPNA_DLAY' =>$opnadlay, ':TRXA_FINS_DATE' =>$finsdate,':TRXA_OPNA_NOTE' =>$opnanote,
       ':TRXA_EMPL_CODE' =>$emplcode,':TRXA_OPNA_STAT' =>$opnastat,':TRXA_VIEW_STAT' =>$viewstat,
       ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
       ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ////print_r($db->error_Info());
        ////var_dump($query_input);
        ////exit();
        $db->commit();


}
else
{
$update = "UPDATE trxaopna SET TRXA_OPNA_DATE='$opnadate', TRXA_WARE_CODE='$warecode', TRXA_OPNA_DLAY='$opnadlay',
                              TRXA_FINS_DATE='$finsdate', TRXA_OPNA_NOTE='$opnanote', TRXA_EMPL_CODE='$emplcode',
                              TRXA_OPNA_STAT='$opnastat', TRXA_VIEW_STAT='$viewstat',
                              TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput', TRXA_UPDT_USER='$userid'    
            WHERE ITEM_OPNA_CODE='$opnacode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
}

?>      
