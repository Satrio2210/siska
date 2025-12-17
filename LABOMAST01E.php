<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//inmastcode,insubscode,insizecode,insizename,inunitname,invalumin,invalumax,invalustring,inpatigend

$rawdata = xss_clean($_POST['q']);
list($mastcode,$subscode,$sizecode,$sizename,$unitname,$valumin,$valumax,$valustring,$patigend) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksalabomast = "SELECT COUNT(*) FROM labomast WHERE LABO_MAST_CODE='$mastcode'";
$periksalabomast_di_query=$db->query($periksalabomast) or die ("Cek Fail");
$ketersediaan = $periksalabomast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO labomast (
          LABO_MAST_CODE, LABO_SUBS_CODE, LABO_SIZE_CODE, LABO_SIZE_NAME, 
          LABO_UNIT_NAME, LABO_VALU_MIN, LABO_VALU_MAX, LABO_VALU_STRG, 
          LABO_PATI_GEND, LABO_VIEW_STAT, 
          LABO_ENTR_DATE, LABO_ENTR_TIME, LABO_ENTR_USER, 
          LABO_UPDT_DATE, LABO_UPDT_TIME, LABO_UPDT_USER) 
        VALUES (
          :LABO_MAST_CODE, :LABO_SUBS_CODE, :LABO_SIZE_CODE, :LABO_SIZE_NAME, 
          :LABO_UNIT_NAME, :LABO_VALU_MIN, :LABO_VALU_MAX, :LABO_VALU_STRG,
          :LABO_PATI_GEND, :LABO_VIEW_STAT, 
          :LABO_ENTR_DATE, :LABO_ENTR_TIME, :LABO_ENTR_USER, 
          :LABO_UPDT_DATE, :LABO_UPDT_TIME, :LABO_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//inmastcode,insubscode,insizename,inunitname,invalumin,invalumax,inpatigend

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':LABO_MAST_CODE' =>$mastcode,':LABO_SUBS_CODE' =>$subscode,':LABO_SIZE_CODE' =>$sizecode,
        ':LABO_SIZE_NAME' =>$sizename,':LABO_UNIT_NAME' =>$unitname,':LABO_VALU_MIN' =>$valumin,
        ':LABO_VALU_MAX' =>$valumax,':LABO_VALU_STRG' =>$valustring,           
        ':LABO_PATI_GEND' =>$patigend,':LABO_VIEW_STAT' =>$viewstat,
        ':LABO_ENTR_DATE' =>$dateinput, ':LABO_ENTR_TIME' =>$timeinput, ':LABO_ENTR_USER' =>$userid,
        ':LABO_UPDT_DATE' =>$dateinput, ':LABO_UPDT_TIME' =>$timeinput, ':LABO_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE labomast SET LABO_SUBS_CODE='$subscode', LABO_SIZE_CODE='$sizecode',LABO_SIZE_NAME='$sizename', 
            LABO_UNIT_NAME='$unitname', LABO_VALU_MIN='$valumin', LABO_VALU_MAX='$valumax', LABO_VALU_STRG='$valustring',
            LABO_PATI_GEND='$patigend', LABO_VIEW_STAT='$viewstat',            
            LABO_UPDT_DATE='$dateinput',LABO_UPDT_TIME='$timeinput',LABO_UPDT_USER='$userid'    
            WHERE LABO_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
