<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//inlistcode,ininvecode,incustcode,incusttype

$rawdata = xss_clean($_POST['q']);
list($listcode,$invecode,$custcode,$custtype) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksalist = "SELECT COUNT(*) FROM trxacust WHERE TRXA_LIST_CODE='$listcode'";
$periksalist_di_query=$db->query($periksalist) or die ("Cek Fail");
$ketersediaan = $periksalist_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxacust (
          TRXA_LIST_CODE, TRXA_INVE_CODE, TRXA_CUST_CODE, TRXA_CUST_TYPE,
          TRXA_VIEW_STAT, 
          TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
          TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
          :TRXA_LIST_CODE, :TRXA_INVE_CODE, :TRXA_CUST_CODE, :TRXA_CUST_TYPE,
          :TRXA_VIEW_STAT, 
          :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
          :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//inlistcode,ininvecode,incustcode,incusttype

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_LIST_CODE' =>$listcode,':TRXA_INVE_CODE' =>$invecode,':TRXA_CUST_CODE' =>$custcode,':TRXA_CUST_TYPE' =>$custtype,
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
$update = "UPDATE trxacust SET TRXA_INVE_CODE='$invecode', TRXA_CUST_CODE='$custcode',TRXA_CUST_TYPE='$custtype', 
                               TRXA_VIEW_STAT='$viewstat',            
                               TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',TRXA_UPDT_USER='$userid'    
            WHERE TRXA_LIST_CODE='$listcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
