<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
$rawdata = xss_clean($_POST['q']);
list($feecode,$mastroom,$masttype,$mastpaym,$mastuser,$medicode,$mastrate,$xpartuser,$xparthome,$xmaxiamnt,$xminiamnt) = explode("|", $rawdata);

$partuser = str_replace(".","",$xpartuser);
$parthome = str_replace(".","",$xparthome);
$maxiamnt = str_replace(".","",$xmaxiamnt);
$miniamnt = str_replace(".","",$xminiamnt);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksafeemast = "SELECT COUNT(*) FROM feemast WHERE FEE_MAST_CODE='$feecode'";
$periksafeemast_di_query=$db->query($periksafeemast) or die ("Cek Fail");
$ketersediaan = $periksafeemast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO feemast (
          FEE_MAST_CODE, FEE_MAST_ROOM, FEE_MAST_TYPE,
          FEE_MAST_PAYM, FEE_MAST_USER, FEE_MEDI_CODE,
          FEE_MAST_RATE, FEE_PART_USER, FEE_PART_HOME,
          FEE_MAXI_AMNT, FEE_MINI_AMNT, FEE_VIEW_STAT,
          FEE_ENTR_DATE, FEE_ENTR_TIME, FEE_ENTR_USER,
          FEE_UPDT_DATE, FEE_UPDT_TIME, FEE_UPDT_USER) 
        VALUES (
          :FEE_MAST_CODE, :FEE_MAST_ROOM, :FEE_MAST_TYPE,
          :FEE_MAST_PAYM, :FEE_MAST_USER, :FEE_MEDI_CODE,
          :FEE_MAST_RATE, :FEE_PART_USER, :FEE_PART_HOME,
          :FEE_MAXI_AMNT, :FEE_MINI_AMNT, :FEE_VIEW_STAT,
          :FEE_ENTR_DATE, :FEE_ENTR_TIME, :FEE_ENTR_USER,
          :FEE_UPDT_DATE, :FEE_UPDT_TIME, :FEE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':FEE_MAST_CODE' =>$feecode,':FEE_MAST_ROOM' =>$mastroom,':FEE_MAST_TYPE' =>$masttype, 
        ':FEE_MAST_PAYM' =>$mastpaym,':FEE_MAST_USER' =>$mastuser,':FEE_MEDI_CODE' =>$medicode,           
        ':FEE_MAST_RATE' =>$mastrate,':FEE_PART_USER' =>$partuser,':FEE_PART_HOME' =>$parthome,
        ':FEE_MAXI_AMNT' =>$maxiamnt,':FEE_MINI_AMNT' =>$miniamnt,':FEE_VIEW_STAT' =>$viewstat,        
        ':FEE_ENTR_DATE' =>$dateinput, ':FEE_ENTR_TIME' =>$timeinput, ':FEE_ENTR_USER' =>$userid,
        ':FEE_UPDT_DATE' =>$dateinput, ':FEE_UPDT_TIME' =>$timeinput, ':FEE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE feemast SET FEE_MAST_ROOM='$mastroom', FEE_MAST_TYPE='$masttype', 
            FEE_MAST_PAYM='$mastpaym', FEE_MAST_USER='$mastuser', FEE_MEDI_CODE='$medicode',
            FEE_MAST_RATE='$mastrate', FEE_PART_USER='$partuser', FEE_PART_HOME='$parthome',
            FEE_MAXI_AMNT='$maxiamnt', FEE_MINI_AMNT='$miniamnt', FEE_VIEW_STAT='$viewstat',            
            FEE_UPDT_DATE='$dateinput',FEE_UPDT_TIME='$timeinput',FEE_UPDT_USER='$userid'    
            WHERE FEE_MAST_CODE='$feecode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
