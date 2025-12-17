<?php
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($examcode, $examname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatbllexam = "SELECT COUNT(*) FROM tbllexam WHERE TBLL_EXAM_CODE='$examcode'";
$periksatbllexam_di_query=$db->query($periksatbllexam) or die ("Cek Fail");
$ketersediaan = $periksatbllexam_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tbllexam (
        TBLL_EXAM_CODE, TBLL_EXAM_NAME, TBLL_VIEW_STAT,
        TBLL_ENTR_DATE, TBLL_ENTR_TIME, TBLL_ENTR_USER,  
        TBLL_UPDT_DATE, TBLL_UPDT_TIME, TBLL_UPDT_USER) 
        VALUES (
        :TBLL_EXAM_CODE, :TBLL_EXAM_NAME, :TBLL_VIEW_STAT,
        :TBLL_ENTR_DATE, :TBLL_ENTR_TIME, :TBLL_ENTR_USER,  
        :TBLL_UPDT_DATE, :TBLL_UPDT_TIME, :TBLL_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLL_EXAM_CODE' =>$examcode,':TBLL_EXAM_NAME' =>$examname, 
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
$update = "UPDATE tbllexam SET TBLL_EXAM_NAME='$examname',
                    TBLL_UPDT_DATE='$dateinput',
                    TBLL_UPDT_TIME='$timeinput',
                    TBLL_UPDT_USER='$userid'    
            WHERE TBLL_EXAM_CODE='$examcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
