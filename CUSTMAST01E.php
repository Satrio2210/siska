<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//mastcode,mainname,maintype,mainaddr,maincity,mainctry,mainphne,crdtlimt,shipname,shipaddr

$rawdata = xss_clean($_POST['q']);
list($mastcode,$mainname,$maintype,$mainaddr,$maincity,$mainctry,$mainphne,$xcrdtlimt,$shipname,$shipaddr) = explode("|", $rawdata);

$crdtlimt = str_replace(".","",$xcrdtlimt);
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksacust = "SELECT COUNT(*) FROM custmast WHERE CUST_MAST_CODE='$mastcode'";
$periksacust_di_query=$db->query($periksacust) or die ("Cek Fail");
$ketersediaan = $periksacust_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO custmast (
          CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE, CUST_MAIN_ADDR, 
          CUST_MAIN_CITY, CUST_MAIN_CTRY, CUST_MAIN_PHNE, CUST_CRDT_LIMT, 
          CUST_SHIP_NAME, CUST_SHIP_ADDR, CUST_VIEW_STAT, 
          CUST_ENTR_DATE, CUST_ENTR_TIME, CUST_ENTR_USER, 
          CUST_UPDT_DATE, CUST_UPDT_TIME, CUST_UPDT_USER) 
        VALUES (
          :CUST_MAST_CODE, :CUST_MAIN_NAME, :CUST_MAIN_TYPE, :CUST_MAIN_ADDR, 
          :CUST_MAIN_CITY, :CUST_MAIN_CTRY, :CUST_MAIN_PHNE, :CUST_CRDT_LIMT,
          :CUST_SHIP_NAME, :CUST_SHIP_ADDR, :CUST_VIEW_STAT, 
          :CUST_ENTR_DATE, :CUST_ENTR_TIME, :CUST_ENTR_USER, 
          :CUST_UPDT_DATE, :CUST_UPDT_TIME, :CUST_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//inmastcode,insubscode,insizename,inunitname,invalumin,invalumax,inpatigend

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':CUST_MAST_CODE' =>$mastcode,':CUST_MAIN_NAME' =>$mainname,':CUST_MAIN_TYPE' =>$maintype,':CUST_MAIN_ADDR' =>$mainaddr,
        ':CUST_MAIN_CITY' =>$maincity,':CUST_MAIN_CTRY' =>$mainctry,':CUST_MAIN_PHNE' =>$mainphne,':CUST_CRDT_LIMT' =>$crdtlimt,           
        ':CUST_SHIP_NAME' =>$shipname,':CUST_SHIP_ADDR' =>$shipaddr,':CUST_VIEW_STAT' =>$viewstat,
        ':CUST_ENTR_DATE' =>$dateinput, ':CUST_ENTR_TIME' =>$timeinput, ':CUST_ENTR_USER' =>$userid,
        ':CUST_UPDT_DATE' =>$dateinput, ':CUST_UPDT_TIME' =>$timeinput, ':CUST_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE custmast SET CUST_MAIN_NAME='$mainname', CUST_MAIN_TYPE='$maintype',CUST_MAIN_ADDR='$mainaddr', 
                               CUST_MAIN_CITY='$maincity', CUST_MAIN_CTRY='$mainctry', CUST_MAIN_PHNE='$mainphne', 
                               CUST_CRDT_LIMT='$crdtlimt', CUST_SHIP_NAME='$shipname', CUST_SHIP_ADDR='$shipaddr', 
                               CUST_VIEW_STAT='$viewstat',            
                               CUST_UPDT_DATE='$dateinput',CUST_UPDT_TIME='$timeinput',CUST_UPDT_USER='$userid'    
            WHERE CUST_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
