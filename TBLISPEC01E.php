<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($speccode, $specname, $specnote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblispec = "SELECT COUNT(*) FROM tblispec WHERE TBLI_SPEC_CODE='$speccode'";
$periksatblispec_di_query=$db->query($periksatblispec) or die ("Cek Fail");
$ketersediaan = $periksatblispec_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblispec (
        TBLI_SPEC_CODE, TBLI_SPEC_NAME, TBLI_SPEC_NOTE, TBLI_SPEC_STAT,
        TBLI_ENTR_DATE, TBLI_ENTR_TIME, TBLI_ENTR_USER,  
        TBLI_UPDT_DATE, TBLI_UPDT_TIME, TBLI_UPDT_USER) 
        VALUES (
        :TBLI_SPEC_CODE, :TBLI_SPEC_NAME, :TBLI_SPEC_NOTE, :TBLI_SPEC_STAT,
        :TBLI_ENTR_DATE, :TBLI_ENTR_TIME, :TBLI_ENTR_USER,  
        :TBLI_UPDT_DATE, :TBLI_UPDT_TIME, :TBLI_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLI_SPEC_CODE' =>$speccode,':TBLI_SPEC_NAME' =>$specname,':TBLI_SPEC_NOTE' =>$specnote, 
        ':TBLI_SPEC_STAT' =>$viewstat,                   
        ':TBLI_ENTR_DATE' =>$dateinput, ':TBLI_ENTR_TIME' =>$timeinput, ':TBLI_ENTR_USER' =>$userid,
        ':TBLI_UPDT_DATE' =>$dateinput, ':TBLI_UPDT_TIME' =>$timeinput, ':TBLI_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblispec SET TBLI_SPEC_NAME='$specname', TBLI_SPEC_NOTE='$specnote',
                    TBLI_UPDT_DATE='$dateinput',
                    TBLI_UPDT_TIME='$timeinput',
                    TBLI_UPDT_USER='$userid'    
            WHERE TBLI_SPEC_CODE='$speccode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
