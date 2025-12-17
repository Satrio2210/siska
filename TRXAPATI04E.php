<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];

//$rawdata = 'INNAA|INNA  A THOILLAH|KB|3|09:00:00|09:00:00|15:00:00|15:00:00|bidan';
list($doctuser, $doctname, $mediroom, $schddays,$xschddays, $schdstart, $xschdstart, $schdend, $xschdend, $schdnote, $xentrtime) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxaschd = "SELECT COUNT(*) FROM trxaschd WHERE TRXA_DOCT_USER='$doctuser' 
					AND TRXA_MEDI_ROOM='$mediroom' AND TRXA_SCHD_DAYS='$xschddays'
					AND TRXA_SCHD_START='$xschdstart' AND TRXA_SCHD_END='$xschdend'
                    AND TRXA_ENTR_TIME='$xentrtime'  
					AND TRXA_VIEW_STAT='Y'";

//var_dump($periksatrxaschd);
//exit();

$periksatrxaschd_di_query=$db->query($periksatrxaschd) or die ("Cek Fail");
$ketersediaan = $periksatrxaschd_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO trxaschd (
        TRXA_DOCT_USER, TRXA_DOCT_NAME, TRXA_MEDI_ROOM,
        TRXA_SCHD_DAYS, TRXA_SCHD_START, TRXA_SCHD_END,
        TRXA_SCHD_NOTE, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_DOCT_USER, :TRXA_DOCT_NAME, :TRXA_MEDI_ROOM,
        :TRXA_SCHD_DAYS, :TRXA_SCHD_START, :TRXA_SCHD_END,
        :TRXA_SCHD_NOTE, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_DOCT_USER' =>$doctuser,':TRXA_DOCT_NAME' =>$doctname,':TRXA_MEDI_ROOM' =>$mediroom,                
        ':TRXA_SCHD_DAYS' =>$schddays,':TRXA_SCHD_START' =>$schdstart,':TRXA_SCHD_END' =>$schdend,                
        ':TRXA_SCHD_NOTE' =>$schdnote,':TRXA_VIEW_STAT' =>$viewstat,                 
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE trxaschd SET TRXA_SCHD_DAYS='$schddays', TRXA_SCHD_START='$schdstart',
                    TRXA_SCHD_END='$schdend', TRXA_SCHD_NOTE='$schdnote',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_DOCT_USER='$doctuser' AND TRXA_MEDI_ROOM='$mediroom'
            AND TRXA_SCHD_DAYS='$xschddays' 
            AND TRXA_SCHD_START='$xschdstart' AND TRXA_SCHD_END='$xschdend'
            AND TRXA_ENTR_TIME='$xentrtime' 
            AND TRXA_VIEW_STAT='Y'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
