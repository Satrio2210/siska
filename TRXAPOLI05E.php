<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
list($sgnacode, $sgnaname) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblpsgna = "SELECT COUNT(*) FROM tblpsgna WHERE TBLP_SGNA_CODE='$sgnacode'";
$periksatblpsgna_di_query=$db->query($periksatblpsgna) or die ("Cek Fail");
$ketersediaan = $periksatblpsgna_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblpsgna (
        TBLP_SGNA_CODE, TBLP_SGNA_NAME, TBLP_SGNA_STAT,
        TBLP_ENTR_DATE, TBLP_ENTR_TIME, TBLP_ENTR_USER,  
        TBLP_UPDT_DATE, TBLP_UPDT_TIME, TBLP_UPDT_USER) 
        VALUES (
        :TBLP_SGNA_CODE, :TBLP_SGNA_NAME, :TBLP_SGNA_STAT,
        :TBLP_ENTR_DATE, :TBLP_ENTR_TIME, :TBLP_ENTR_USER,  
        :TBLP_UPDT_DATE, :TBLP_UPDT_TIME, :TBLP_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLP_SGNA_CODE' =>$sgnacode,':TBLP_SGNA_NAME' =>$sgnaname,':TBLP_SGNA_STAT' =>$viewstat,                   
        ':TBLP_ENTR_DATE' =>$dateinput, ':TBLP_ENTR_TIME' =>$timeinput, ':TBLP_ENTR_USER' =>$userid,
        ':TBLP_UPDT_DATE' =>$dateinput, ':TBLP_UPDT_TIME' =>$timeinput, ':TBLP_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblpsgna SET TBLP_SGNA_NAME='$sgnaname',
                    TBLP_UPDT_DATE='$dateinput',
                    TBLP_UPDT_TIME='$timeinput',
                    TBLP_UPDT_USER='$userid'    
            WHERE TBLP_SGNA_CODE='$sgnacode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
