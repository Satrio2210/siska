<?php
session_start();
include "conf/config.php";

//$rawdata = 'Certain infectious and parasitic diseases|Intestinal infectious diseases|A00|Cholera';

$rawdata = $_POST['q'];
list($icdcategory, $icdsubcate, $icdcode, $icdnote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksadiagmast = "SELECT COUNT(*) FROM diagmast WHERE DIAG_ICD_CODE='$icdcode'";

$periksadiagmast_di_query=$db->query($periksadiagmast) or die ("Cek Fail");
$ketersediaan = $periksadiagmast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO diagmast (
        DIAG_ICD_CATEGORY, DIAG_ICD_SUBCATE, DIAG_ICD_CODE,
        DIAG_ICD_NOTE, DIAG_VIEW_STAT,
        DIAG_ENTR_DATE, DIAG_ENTR_TIME, DIAG_ENTR_USER,  
        DIAG_UPDT_DATE, DIAG_UPDT_TIME, DIAG_UPDT_USER) 
        VALUES (
        :DIAG_ICD_CATEGORY, :DIAG_ICD_SUBCATE, :DIAG_ICD_CODE,
        :DIAG_ICD_NOTE, :DIAG_VIEW_STAT,
        :DIAG_ENTR_DATE, :DIAG_ENTR_TIME, :DIAG_ENTR_USER,  
        :DIAG_UPDT_DATE, :DIAG_UPDT_TIME, :DIAG_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':DIAG_ICD_CATEGORY' =>$icdcategory, ':DIAG_ICD_SUBCATE' =>$icdsubcate, ':DIAG_ICD_CODE' =>$icdcode,
        ':DIAG_ICD_NOTE' =>$icdnote,         ':DIAG_VIEW_STAT' =>$viewstat,                   
        ':DIAG_ENTR_DATE' =>$dateinput,      ':DIAG_ENTR_TIME' =>$timeinput, ':DIAG_ENTR_USER' =>$userid,
        ':DIAG_UPDT_DATE' =>$dateinput,      ':DIAG_UPDT_TIME' =>$timeinput, ':DIAG_UPDT_USER' =>$userid));  
        //print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE diagmast SET DIAG_ICD_CATEGORY='$icdcategory', DIAG_ICD_SUBCATE='$icdsubcate',
            DIAG_ICD_NOTE='$icdnote',
                    DIAG_UPDT_DATE='$dateinput',
                    DIAG_UPDT_TIME='$timeinput',
                    DIAG_UPDT_USER='$userid'    
            WHERE DIAG_ICD_CODE='$icdcode'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
