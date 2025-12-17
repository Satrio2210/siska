<?php
session_start();
include "conf/config.php";
include "inc/sanie.php";

$rawdata = xss_clean($_POST['q']);
//$rawdata='CIN|Cinerex|Cinere, Jakarta Selatanx|00320109|Gudang makanan';

list($locacode,$locaname,$locaaddr,$emplcode,$locanote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksafixeloca = "SELECT COUNT(*) FROM fixeloca WHERE FIXE_LOCA_CODE='$locacode'";
$periksafixeloca_di_query=$db->query($periksafixeloca) or die ("Cek Fail");
$ketersediaan = $periksafixeloca_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO fixeloca (
        FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR, 
        FIXE_EMPL_CODE, FIXE_LOCA_NOTE, FIXE_VIEW_STAT,
        FIXE_ENTR_DATE, FIXE_ENTR_TIME, FIXE_ENTR_USER,  
        FIXE_UPDT_DATE, FIXE_UPDT_TIME, FIXE_UPDT_USER) 
        VALUES (
        :FIXE_LOCA_CODE, :FIXE_LOCA_NAME, :FIXE_LOCA_ADDR, 
        :FIXE_EMPL_CODE, :FIXE_LOCA_NOTE, :FIXE_VIEW_STAT,
        :FIXE_ENTR_DATE, :FIXE_ENTR_TIME, :FIXE_ENTR_USER,  
        :FIXE_UPDT_DATE, :FIXE_UPDT_TIME, :FIXE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':FIXE_LOCA_CODE' =>$locacode,':FIXE_LOCA_NAME' =>$locaname,':FIXE_LOCA_ADDR' =>$locaaddr, 
        ':FIXE_EMPL_CODE' =>$emplcode,':FIXE_LOCA_NOTE' =>$locanote,':FIXE_VIEW_STAT' =>$viewstat,                   
        ':FIXE_ENTR_DATE' =>$dateinput,':FIXE_ENTR_TIME' =>$timeinput,':FIXE_ENTR_USER' =>$userid,
        ':FIXE_UPDT_DATE' =>$dateinput,':FIXE_UPDT_TIME' =>$timeinput,':FIXE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE fixeloca SET FIXE_LOCA_NAME='$locaname', FIXE_LOCA_ADDR='$locaaddr', 
            FIXE_EMPL_CODE='$emplcode', FIXE_LOCA_NOTE='$locanote', 
                    FIXE_UPDT_DATE='$dateinput',
                    FIXE_UPDT_TIME='$timeinput',
                    FIXE_UPDT_USER='$userid'    
            WHERE FIXE_LOCA_CODE='$locacode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
