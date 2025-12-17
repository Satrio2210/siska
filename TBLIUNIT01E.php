<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($unitcode, $unitname, $deviname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatbliunit = "SELECT COUNT(*) FROM tbliunit WHERE TBLI_UNIT_CODE='$unitcode'";
$periksatbliunit_di_query=$db->query($periksatbliunit) or die ("Cek Fail");
$ketersediaan = $periksatbliunit_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tbliunit (
        TBLI_UNIT_CODE, TBLI_UNIT_NAME, TBLI_UNIT_DEVI, TBLI_UNIT_STAT,
        TBLI_ENTR_DATE, TBLI_ENTR_TIME, TBLI_ENTR_USER,  
        TBLI_UPDT_DATE, TBLI_UPDT_TIME, TBLI_UPDT_USER) 
        VALUES (
        :TBLI_UNIT_CODE, :TBLI_UNIT_NAME, :TBLI_UNIT_DEVI, :TBLI_UNIT_STAT,
        :TBLI_ENTR_DATE, :TBLI_ENTR_TIME, :TBLI_ENTR_USER,  
        :TBLI_UPDT_DATE, :TBLI_UPDT_TIME, :TBLI_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLI_UNIT_CODE' =>$unitcode,':TBLI_UNIT_NAME' =>$unitname,':TBLI_UNIT_DEVI' =>$deviname, 
        ':TBLI_UNIT_STAT' =>$viewstat,                   
        ':TBLI_ENTR_DATE' =>$dateinput, ':TBLI_ENTR_TIME' =>$timeinput, ':TBLI_ENTR_USER' =>$userid,
        ':TBLI_UPDT_DATE' =>$dateinput, ':TBLI_UPDT_TIME' =>$timeinput, ':TBLI_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tbliunit SET TBLI_UNIT_NAME='$unitname', TBLI_UNIT_DEVI='$deviname',
                    TBLI_UPDT_DATE='$dateinput',
                    TBLI_UPDT_TIME='$timeinput',
                    TBLI_UPDT_USER='$userid'    
            WHERE TBLI_UNIT_CODE='$unitcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
