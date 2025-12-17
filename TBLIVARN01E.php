<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($varncode, $varnname, $varnnote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblivarn = "SELECT COUNT(*) FROM tblivarn WHERE TBLI_VARN_CODE='$varncode'";
$periksatblivarn_di_query=$db->query($periksatblivarn) or die ("Cek Fail");
$ketersediaan = $periksatblivarn_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblivarn (
        TBLI_VARN_CODE, TBLI_VARN_NAME, TBLI_VARN_NOTE, TBLI_VARN_STAT,
        TBLI_ENTR_DATE, TBLI_ENTR_TIME, TBLI_ENTR_USER,  
        TBLI_UPDT_DATE, TBLI_UPDT_TIME, TBLI_UPDT_USER) 
        VALUES (
        :TBLI_VARN_CODE, :TBLI_VARN_NAME, :TBLI_VARN_NOTE, :TBLI_VARN_STAT,
        :TBLI_ENTR_DATE, :TBLI_ENTR_TIME, :TBLI_ENTR_USER,  
        :TBLI_UPDT_DATE, :TBLI_UPDT_TIME, :TBLI_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLI_VARN_CODE' =>$varncode,':TBLI_VARN_NAME' =>$varnname,':TBLI_VARN_NOTE' =>$varnnote, 
        ':TBLI_VARN_STAT' =>$viewstat,                   
        ':TBLI_ENTR_DATE' =>$dateinput, ':TBLI_ENTR_TIME' =>$timeinput, ':TBLI_ENTR_USER' =>$userid,
        ':TBLI_UPDT_DATE' =>$dateinput, ':TBLI_UPDT_TIME' =>$timeinput, ':TBLI_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblivarn SET TBLI_VARN_NAME='$varnname', TBLI_VARN_NOTE='$varnnote',
                    TBLI_UPDT_DATE='$dateinput',
                    TBLI_UPDT_TIME='$timeinput',
                    TBLI_UPDT_USER='$userid'    
            WHERE TBLI_VARN_CODE='$varncode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
