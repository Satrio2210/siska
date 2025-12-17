<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($unitcode, $unitname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatbllunit = "SELECT COUNT(*) FROM tbllunit WHERE TBLL_UNIT_CODE='$unitcode'";
$periksatbllunit_di_query=$db->query($periksatbllunit) or die ("Cek Fail");
$ketersediaan = $periksatbllunit_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tbllunit (
        TBLL_UNIT_CODE, TBLL_UNIT_NAME, TBLL_VIEW_STAT,
        TBLL_ENTR_DATE, TBLL_ENTR_TIME, TBLL_ENTR_USER,  
        TBLL_UPDT_DATE, TBLL_UPDT_TIME, TBLL_UPDT_USER) 
        VALUES (
        :TBLL_UNIT_CODE, :TBLL_UNIT_NAME, :TBLL_VIEW_STAT,
        :TBLL_ENTR_DATE, :TBLL_ENTR_TIME, :TBLL_ENTR_USER,  
        :TBLL_UPDT_DATE, :TBLL_UPDT_TIME, :TBLL_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLL_UNIT_CODE' =>$unitcode,':TBLL_UNIT_NAME' =>$unitname, 
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
$update = "UPDATE tbllunit SET TBLL_UNIT_NAME='$unitname',
                    TBLL_UPDT_DATE='$dateinput',
                    TBLL_UPDT_TIME='$timeinput',
                    TBLL_UPDT_USER='$userid'    
            WHERE TBLL_UNIT_CODE='$unitcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
