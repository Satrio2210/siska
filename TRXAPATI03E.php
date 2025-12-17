<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
list($policode, $poliname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblapoli = "SELECT COUNT(*) FROM tblapoli WHERE TBLA_POLI_CODE='$policode'";
$periksatblapoli_di_query=$db->query($periksatblapoli) or die ("Cek Fail");
$ketersediaan = $periksatblapoli_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblapoli (
        TBLA_POLI_CODE, TBLA_POLI_NAME, TBLA_POLI_STAT,
        TBLA_ENTR_DATE, TBLA_ENTR_TIME, TBLA_ENTR_USER,  
        TBLA_UPDT_DATE, TBLA_UPDT_TIME, TBLA_UPDT_USER) 
        VALUES (
        :TBLA_POLI_CODE, :TBLA_POLI_NAME, :TBLA_POLI_STAT,
        :TBLA_ENTR_DATE, :TBLA_ENTR_TIME, :TBLA_ENTR_USER,  
        :TBLA_UPDT_DATE, :TBLA_UPDT_TIME, :TBLA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLA_POLI_CODE' =>$policode,':TBLA_POLI_NAME' =>$poliname,':TBLA_POLI_STAT' =>$viewstat,                   
        ':TBLA_ENTR_DATE' =>$dateinput, ':TBLA_ENTR_TIME' =>$timeinput, ':TBLA_ENTR_USER' =>$userid,
        ':TBLA_UPDT_DATE' =>$dateinput, ':TBLA_UPDT_TIME' =>$timeinput, ':TBLA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblapoli SET TBLA_POLI_NAME='$poliname',
                    TBLA_UPDT_DATE='$dateinput',
                    TBLA_UPDT_TIME='$timeinput',
                    TBLA_UPDT_USER='$userid'    
            WHERE TBLA_POLI_CODE='$policode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
