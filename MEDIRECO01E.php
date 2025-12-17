<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//regicode,paticode,regidoct,regipoli,paymtota,paymamnt,paymdisc,paymmode

$rawinput = xss_clean($_POST['q']);
list($paticode, $allenote) = explode("|",$rawinput);
// kode invoice 26112020-00001

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaallenote = "SELECT COUNT(*) FROM trxaalle WHERE TRXA_PATI_CODE='$paticode'";
$periksaallenote_di_query=$db->query($periksaallenote) or die ("Cek Fail");
$ketersediaan = $periksaallenote_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input_note = "INSERT INTO trxaalle (
    TRXA_PATI_CODE, TRXA_ALLE_NOTE, TRXA_VIEW_STAT,          
    TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
    TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
    VALUES (
    :TRXA_PATI_CODE, :TRXA_ALLE_NOTE, :TRXA_VIEW_STAT,          
    :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
    :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
    // Prepare Request  
    $query_input_note = $db->prepare($input_note);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_note->execute(array(
    ':TRXA_PATI_CODE' =>$paticode, ':TRXA_ALLE_NOTE' =>$allenote, ':TRXA_VIEW_STAT' =>$viewstat, 
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input_header);
    ///exit();
    $db->commit();
}
else
{

$update = "UPDATE trxaalle SET TRXA_ALLE_NOTE='$allenote',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_PATI_CODE='$paticode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}



?>      
