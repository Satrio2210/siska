<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($manucode, $manuname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatbllmanu = "SELECT COUNT(*) FROM tbllmanu WHERE TBLL_MANU_CODE='$manucode'";
$periksatbllmanu_di_query=$db->query($periksatbllmanu) or die ("Cek Fail");
$ketersediaan = $periksatbllmanu_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tbllmanu (
        TBLL_MANU_CODE, TBLL_MANU_NAME, TBLL_VIEW_STAT,
        TBLL_ENTR_DATE, TBLL_ENTR_TIME, TBLL_ENTR_USER,  
        TBLL_UPDT_DATE, TBLL_UPDT_TIME, TBLL_UPDT_USER) 
        VALUES (
        :TBLL_MANU_CODE, :TBLL_MANU_NAME, :TBLL_VIEW_STAT,
        :TBLL_ENTR_DATE, :TBLL_ENTR_TIME, :TBLL_ENTR_USER,  
        :TBLL_UPDT_DATE, :TBLL_UPDT_TIME, :TBLL_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLL_MANU_CODE' =>$manucode,':TBLL_MANU_NAME' =>$manuname, 
        ':TBLL_VIEW_STAT' =>$viewstat,                   
        ':TBLL_ENTR_DATE' =>$dateinput, ':TBLL_ENTR_TIME' =>$timeinput, ':TBLL_ENTR_USER' =>$userid,
        ':TBLL_UPDT_DATE' =>$dateinput, ':TBLL_UPDT_TIME' =>$timeinput, ':TBLL_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tbllmanu SET TBLL_MANU_NAME='$manuname',
                    TBLL_UPDT_DATE='$dateinput',
                    TBLL_UPDT_TIME='$timeinput',
                    TBLL_UPDT_USER='$userid'    
            WHERE TBLL_MANU_CODE='$manucode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
