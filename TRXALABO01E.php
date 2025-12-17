<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];

list($tretcode,$tretdoct,$medicode,$medirate,$tretquty,$mediroom) = explode("|", $rawdata);

$tretstat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxatret = "SELECT COUNT(*) FROM trxatret WHERE TRXA_TRET_CODE='$tretcode' AND TRXA_MEDI_CODE='$medicode' 
                    AND TRXA_VIEW_STAT='Y'";
$periksatrxatret_di_query=$db->query($periksatrxatret) or die ("Cek Fail");
$ketersediaan = $periksatrxatret_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO trxatret (
         TRXA_TRET_CODE, TRXA_TRET_DOCT, TRXA_MEDI_CODE,
         TRXA_MEDI_RATE, TRXA_TRET_QUTY, TRXA_MEDI_ROOM,
         TRXA_TRET_STAT, TRXA_VIEW_STAT, 
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_TRET_CODE, :TRXA_TRET_DOCT, :TRXA_MEDI_CODE,
        :TRXA_MEDI_RATE, :TRXA_TRET_QUTY, :TRXA_MEDI_ROOM,
        :TRXA_TRET_STAT, :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TRXA_TRET_CODE' =>$tretcode,':TRXA_TRET_DOCT' =>$tretdoct,':TRXA_MEDI_CODE' =>$medicode,                
        ':TRXA_MEDI_RATE' =>$medirate,':TRXA_TRET_QUTY' =>$tretquty,':TRXA_MEDI_ROOM' =>$mediroom,                
        ':TRXA_TRET_STAT' =>$tretstat,':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
        ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

// update status pasien menjadi telah diperiksa

 $update_status = "UPDATE trxaregi SET TRXA_REGI_STAT='C',
                                TRXA_UPDT_DATE='$dateinput',
                                TRXA_UPDT_TIME='$timeinput',
                                TRXA_UPDT_USER='$userid'    
                        WHERE TRXA_REGI_CODE='$tretcode'";
                // Prepare Request  
                $query_update_status = $db->prepare($update_status);

                // Mulai Input
                $db->beginTransaction();
                $query_update_status->execute();
                $db->commit();

}
else
{
$update = "UPDATE trxatret SET TRXA_MEDI_RATE='$medirate',
                    TRXA_TRET_QUTY='$tretquty',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_TRET_CODE='$tretcode' AND TRXA_MEDI_CODE='$medicode' 
                    AND TRXA_TRET_STAT='I' AND TRXA_VIEW_STAT='Y'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

// update status pasien menjadi telah diperiksa

 $update_status = "UPDATE trxaregi SET TRXA_REGI_STAT='C',
                                TRXA_UPDT_DATE='$dateinput',
                                TRXA_UPDT_TIME='$timeinput',
                                TRXA_UPDT_USER='$userid'    
                        WHERE TRXA_REGI_CODE='$tretcode'";
                // Prepare Request  
                $query_update_status = $db->prepare($update_status);

                // Mulai Input
                $db->beginTransaction();
                $query_update_status->execute();
                $db->commit();

}


?>      
