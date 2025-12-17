<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
//input(medicode,mediname,medirate,mediroom,meditype,medipaym,medinote,mediacti)
//$rawdata = 'TND-00100|SWAB Antigen|95.000|LB|N|U|Swab Antigen|A';
$rawdata = xss_clean($_POST['q']);
list($medicode,$mediname,$xmedirate,$mediroom,$meditype,$medipaym,$medinote,$mediacti) = explode("|", $rawdata);

$medirate = str_replace(".","",$xmedirate);
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblfmedi = "SELECT COUNT(*) FROM tblfmedi WHERE TBLF_MEDI_CODE='$medicode'";
$periksatblfmedi_di_query=$db->query($periksatblfmedi) or die ("Cek Fail");
$ketersediaan = $periksatblfmedi_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode tindakan baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblfmedi (
        TBLF_MEDI_CODE, TBLF_MEDI_NAME, TBLF_MEDI_RATE, 
        TBLF_MEDI_ROOM, TBLF_MEDI_TYPE, TBLF_MEDI_PAYM, 
        TBLF_MEDI_NOTE, TBLF_MEDI_ACTI, TBLF_VIEW_STAT,
        TBLF_ENTR_DATE, TBLF_ENTR_TIME, TBLF_ENTR_USER,  
        TBLF_UPDT_DATE, TBLF_UPDT_TIME, TBLF_UPDT_USER) 
        VALUES (
        :TBLF_MEDI_CODE, :TBLF_MEDI_NAME, :TBLF_MEDI_RATE, 
        :TBLF_MEDI_ROOM, :TBLF_MEDI_TYPE, :TBLF_MEDI_PAYM, 
        :TBLF_MEDI_NOTE, :TBLF_MEDI_ACTI, :TBLF_VIEW_STAT,
        :TBLF_ENTR_DATE, :TBLF_ENTR_TIME, :TBLF_ENTR_USER,  
        :TBLF_UPDT_DATE, :TBLF_UPDT_TIME, :TBLF_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLF_MEDI_CODE' =>$medicode,':TBLF_MEDI_NAME' =>$mediname,':TBLF_MEDI_RATE' =>$medirate, 
        ':TBLF_MEDI_ROOM' =>$mediroom,':TBLF_MEDI_TYPE' =>$meditype,':TBLF_MEDI_PAYM' =>$medipaym,           
        ':TBLF_MEDI_NOTE' =>$medinote,':TBLF_MEDI_ACTI' =>$mediacti,':TBLF_VIEW_STAT' =>$viewstat,        
        ':TBLF_ENTR_DATE' =>$dateinput, ':TBLF_ENTR_TIME' =>$timeinput, ':TBLF_ENTR_USER' =>$userid,
        ':TBLF_UPDT_DATE' =>$dateinput, ':TBLF_UPDT_TIME' =>$timeinput, ':TBLF_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblfmedi SET TBLF_MEDI_NAME='$mediname', TBLF_MEDI_RATE='$medirate', 
            TBLF_MEDI_ROOM='$mediroom', TBLF_MEDI_TYPE='$meditype', TBLF_MEDI_PAYM='$medipaym',
            TBLF_MEDI_NOTE='$medinote', TBLF_MEDI_ACTI='$mediacti', TBLF_VIEW_STAT='$viewstat',            
            TBLF_UPDT_DATE='$dateinput',TBLF_UPDT_TIME='$timeinput',TBLF_UPDT_USER='$userid'    
            WHERE TBLF_MEDI_CODE='$medicode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
