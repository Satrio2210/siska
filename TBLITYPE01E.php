<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
//input(typecode,typename,typecate,typenote)
$rawdata = xss_clean($_POST['q']);
list($typecode, $typename, $typecate, $typenote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatblitype = "SELECT COUNT(*) FROM tblitype WHERE TBLI_TYPE_CODE='$typecode'";
$periksatblitype_di_query=$db->query($periksatblitype) or die ("Cek Fail");
$ketersediaan = $periksatblitype_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO tblitype (
        TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_CATE, TBLI_TYPE_NOTE, TBLI_TYPE_STAT,
        TBLI_ENTR_DATE, TBLI_ENTR_TIME, TBLI_ENTR_USER,  
        TBLI_UPDT_DATE, TBLI_UPDT_TIME, TBLI_UPDT_USER) 
        VALUES (
        :TBLI_TYPE_CODE, :TBLI_TYPE_NAME, :TBLI_TYPE_CATE, :TBLI_TYPE_NOTE, :TBLI_TYPE_STAT,
        :TBLI_ENTR_DATE, :TBLI_ENTR_TIME, :TBLI_ENTR_USER,  
        :TBLI_UPDT_DATE, :TBLI_UPDT_TIME, :TBLI_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':TBLI_TYPE_CODE' =>$typecode,':TBLI_TYPE_NAME' =>$typename,':TBLI_TYPE_CATE' =>$typecate, 
        ':TBLI_TYPE_NOTE' =>$typenote,':TBLI_TYPE_STAT' =>$viewstat,                   
        ':TBLI_ENTR_DATE' =>$dateinput, ':TBLI_ENTR_TIME' =>$timeinput, ':TBLI_ENTR_USER' =>$userid,
        ':TBLI_UPDT_DATE' =>$dateinput, ':TBLI_UPDT_TIME' =>$timeinput, ':TBLI_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE tblitype SET TBLI_TYPE_NAME='$typename', TBLI_TYPE_CATE='$typecate', TBLI_TYPE_NOTE='$typenote',
                    TBLI_UPDT_DATE='$dateinput',
                    TBLI_UPDT_TIME='$timeinput',
                    TBLI_UPDT_USER='$userid'    
            WHERE TBLI_TYPE_CODE='$typecode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
