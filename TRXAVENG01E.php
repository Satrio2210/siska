<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

$rawinput = xss_clean($_POST['q']);
//$rawinput='RETPO-0002|2021-04-12|PO-0001|PRO|VE-0002|testing';

list($retucode,$retudate,$proccode,$retudivi,$retustat,$suplcode,$retunote) = explode("|",$rawinput);
//$retustat = 'E';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaretur = "SELECT COUNT(*) FROM trxaretu WHERE TRXA_RETU_CODE='$retucode'";
$periksaretur_di_query=$db->query($periksaretur) or die ("Cek Code retur Fail");
$ketersediaan = $periksaretur_di_query->fetchColumn();
//Cek adanya Kode retur yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode Retur baru
if ($ketersediaan == 0)
{

        $input_return = "INSERT INTO trxaretu (TRXA_RETU_CODE, TRXA_RETU_DATE, TRXA_PROC_CODE, 
        TRXA_RETU_DIVI, TRXA_SUPL_CODE, TRXA_RETU_NOTE, 
        TRXA_RETU_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_RETU_CODE, :TRXA_RETU_DATE, :TRXA_PROC_CODE, 
        :TRXA_RETU_DIVI, :TRXA_SUPL_CODE, :TRXA_RETU_NOTE, 
        :TRXA_RETU_STAT, :TRXA_VIEW_STAT,          
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_return = $db->prepare($input_return);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_return->execute(array(
        ':TRXA_RETU_CODE' =>$retucode, ':TRXA_RETU_DATE' =>$retudate, ':TRXA_PROC_CODE' =>$proccode,   
        ':TRXA_RETU_DIVI' =>$retudivi, ':TRXA_SUPL_CODE' =>$suplcode, ':TRXA_RETU_NOTE' =>$retunote,
        ':TRXA_RETU_STAT' =>$retustat, ':TRXA_VIEW_STAT' =>$viewstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_return);
        ///exit();
        $db->commit();
}
else
{
        $update = "UPDATE trxaretu SET TRXA_RETU_STAT='$retustat', 
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_RETU_CODE='$retucode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}
?>      
