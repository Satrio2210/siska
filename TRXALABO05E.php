<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

$rawdata = xss_clean($_POST['q']);
list($laboregi,$labodoct,$mastcode,$laborslt,$labonote) = explode("|", $rawdata);

$labostat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxalabo = "SELECT COUNT(*) FROM trxalabo WHERE TRXA_LABO_REGI = '$laboregi' AND TRXA_MAST_CODE='$mastcode'";
$periksatrxalabo_di_query=$db->query($periksatrxalabo) or die ("Cek Fail");
$ketersediaan = $periksatrxalabo_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxalabo (
          TRXA_LABO_REGI, TRXA_LABO_DOCT, TRXA_MAST_CODE, 
          TRXA_LABO_RSLT, TRXA_LABO_NOTE, TRXA_LABO_STAT, 
          TRXA_VIEW_STAT, 
          TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
          TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
          VALUES (
          :TRXA_LABO_REGI, :TRXA_LABO_DOCT, :TRXA_MAST_CODE, 
          :TRXA_LABO_RSLT, :TRXA_LABO_NOTE, :TRXA_LABO_STAT, 
          :TRXA_VIEW_STAT, 
          :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
          :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//$laboregi,$labodoct,$mastcode,$laborslt,$labonote

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_LABO_REGI' =>$laboregi,':TRXA_LABO_DOCT' =>$labodoct,':TRXA_MAST_CODE' =>$mastcode, 
        ':TRXA_LABO_RSLT' =>$laborslt,':TRXA_LABO_NOTE' =>$labonote,':TRXA_LABO_STAT' =>$labostat,           
        ':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE trxalabo SET TRXA_LABO_DOCT='$labodoct', TRXA_LABO_RSLT='$laborslt', 
            TRXA_LABO_NOTE='$labonote', TRXA_VIEW_STAT='Y',             
            TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',TRXA_UPDT_USER='$userid'    
            WHERE TRXA_LABO_REGI = '$laboregi' AND TRXA_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
