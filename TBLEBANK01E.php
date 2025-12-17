<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');
session_start();
include "conf/config.php";


$rawdata = $_POST['q'];
list($bankcode, $bankname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblebank = "SELECT COUNT(*) FROM tblebank WHERE TBLE_BANK_CODE='$bankcode'";
$periksatblebank_di_query=$db->query($periksatblebank) or die ("Cek Fail");
$ketersediaan = $periksatblebank_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblebank (
        TBLE_BANK_CODE, TBLE_BANK_NAME, TBLE_BANK_STAT,
        TBLE_ENTR_DATE, TBLE_ENTR_TIME, TBLE_ENTR_USER,  
        TBLE_UPDT_DATE, TBLE_UPDT_TIME, TBLE_UPDT_USER) 
        VALUES (
        :TBLE_BANK_CODE, :TBLE_BANK_NAME, :TBLE_BANK_STAT,
        :TBLE_ENTR_DATE, :TBLE_ENTR_TIME, :TBLE_ENTR_USER,  
        :TBLE_UPDT_DATE, :TBLE_UPDT_TIME, :TBLE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLE_BANK_CODE' =>$bankcode,':TBLE_BANK_NAME' =>$bankname,':TBLE_BANK_STAT' =>$viewstat,                   
        ':TBLE_ENTR_DATE' =>$dateinput, ':TBLE_ENTR_TIME' =>$timeinput, ':TBLE_ENTR_USER' =>$userid,
        ':TBLE_UPDT_DATE' =>$dateinput, ':TBLE_UPDT_TIME' =>$timeinput, ':TBLE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblebank SET TBLE_BANK_NAME='$bankname',
                    TBLE_UPDT_DATE='$dateinput',
                    TBLE_UPDT_TIME='$timeinput',
                    TBLE_UPDT_USER='$userid'    
            WHERE TBLE_BANK_CODE='$bankcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
