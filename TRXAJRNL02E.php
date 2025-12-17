<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include "inc/sanie.php";

$inputjurnal = xss_clean($_POST['q']);

list($jrnlcode, $jrnldate, $coaccode, $coacname, $xjrnldebt, $xjrnlcrdt, $divicode, $diviname, $jrnlnote) = explode("|",$inputjurnal);

$jrnldebt = str_replace(".","",$xjrnldebt);
$jrnlcrdt = str_replace(".","",$xjrnlcrdt);
$jrnlstat = 'Y';
$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$input = "INSERT INTO trxajrnl (
        TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME,
        TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,        
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE,
        TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_JRNL_CODE, :TRXA_JRNL_DATE,  
        :TRXA_COAC_CODE, :TRXA_COAC_NAME,
        :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE,
        :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$coaccode, ':TRXA_COAC_NAME' =>$coacname,                  
        ':TRXA_JRNL_DEBT' =>$jrnldebt, ':TRXA_JRNL_CRDT' =>$jrnlcrdt, 
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

?>      
