<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
$rawdata = xss_clean($_POST['q']);
list($vstcode,$mastroom,$mastpaym,$mastuser,$maxiamnt,$xnomiamnt) = explode("|", $rawdata);

$nomiamnt = str_replace(".","",$xnomiamnt);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksavstmast = "SELECT COUNT(*) FROM vstmast WHERE VST_MAST_CODE='$vstcode'";
$periksavstmast_di_query=$db->query($periksavstmast) or die ("Cek Fail");
$ketersediaan = $periksavstmast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO vstmast (
          VST_MAST_CODE, VST_MAST_ROOM, VST_MAST_PAYM, 
          VST_MAST_USER, VST_MAXI_AMNT, VST_NOMI_AMNT, 
          VST_VIEW_STAT, 
          VST_ENTR_DATE, VST_ENTR_TIME, VST_ENTR_USER, 
          VST_UPDT_DATE, VST_UPDT_TIME, VST_UPDT_USER) 
        VALUES (
          :VST_MAST_CODE, :VST_MAST_ROOM, :VST_MAST_PAYM, 
          :VST_MAST_USER, :VST_MAXI_AMNT, :VST_NOMI_AMNT, 
          :VST_VIEW_STAT, 
          :VST_ENTR_DATE, :VST_ENTR_TIME, :VST_ENTR_USER, 
          :VST_UPDT_DATE, :VST_UPDT_TIME, :VST_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

//input(invstcode,inmastroom,inmastpaym,inmastuser,inmaxiamnt,innomiamnt);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':VST_MAST_CODE' =>$vstcode,':VST_MAST_ROOM' =>$mastroom,':VST_MAST_PAYM' =>$mastpaym, 
        ':VST_MAST_USER' =>$mastuser,':VST_MAXI_AMNT' =>$maxiamnt,':VST_NOMI_AMNT' =>$nomiamnt,           
        ':VST_VIEW_STAT' =>$viewstat,
        ':VST_ENTR_DATE' =>$dateinput, ':VST_ENTR_TIME' =>$timeinput, ':VST_ENTR_USER' =>$userid,
        ':VST_UPDT_DATE' =>$dateinput, ':VST_UPDT_TIME' =>$timeinput, ':VST_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE vstmast SET VST_MAST_ROOM='$mastroom', VST_MAST_PAYM='$mastpaym', 
            VST_MAST_USER='$mastuser', VST_MAXI_AMNT='$maxiamnt', VST_NOMI_AMNT='$nomiamnt',
            VST_VIEW_STAT='$viewstat',            
            VST_UPDT_DATE='$dateinput',VST_UPDT_TIME='$timeinput',VST_UPDT_USER='$userid'    
            WHERE VST_MAST_CODE='$vstcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
