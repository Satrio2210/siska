<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
list($postcode, $postname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblepost = "SELECT COUNT(*) FROM tblepost WHERE TBLE_POST_CODE='$postcode'";
$periksatblepost_di_query=$db->query($periksatblepost) or die ("Cek Fail");
$ketersediaan = $periksatblepost_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblepost (
        TBLE_POST_CODE, TBLE_POST_NAME, TBLE_POST_STAT,
        TBLE_ENTR_DATE, TBLE_ENTR_TIME, TBLE_ENTR_USER,  
        TBLE_UPDT_DATE, TBLE_UPDT_TIME, TBLE_UPDT_USER) 
        VALUES (
        :TBLE_POST_CODE, :TBLE_POST_NAME, :TBLE_POST_STAT,
        :TBLE_ENTR_DATE, :TBLE_ENTR_TIME, :TBLE_ENTR_USER,  
        :TBLE_UPDT_DATE, :TBLE_UPDT_TIME, :TBLE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLE_POST_CODE' =>$postcode,':TBLE_POST_NAME' =>$postname,':TBLE_POST_STAT' =>$viewstat,                   
        ':TBLE_ENTR_DATE' =>$dateinput, ':TBLE_ENTR_TIME' =>$timeinput, ':TBLE_ENTR_USER' =>$userid,
        ':TBLE_UPDT_DATE' =>$dateinput, ':TBLE_UPDT_TIME' =>$timeinput, ':TBLE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblepost SET TBLE_POST_NAME='$postname',
                    TBLE_UPDT_DATE='$dateinput',
                    TBLE_UPDT_TIME='$timeinput',
                    TBLE_UPDT_USER='$userid'    
            WHERE TBLE_POST_CODE='$postcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
