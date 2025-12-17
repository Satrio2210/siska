<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
$rawdata = xss_clean($_POST['q']);
list($attcode,$mastroom,$mastpaym,$mastuser,$mastrate,$xnomiamnt) = explode("|", $rawdata);

$nomiamnt = str_replace(".","",$xnomiamnt);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaattmast = "SELECT COUNT(*) FROM attmast WHERE ATT_MAST_CODE='$attcode'";
$periksaattmast_di_query=$db->query($periksaattmast) or die ("Cek Fail");
$ketersediaan = $periksaattmast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

$input = "INSERT INTO attmast (
          ATT_MAST_CODE, ATT_MAST_ROOM, ATT_MAST_PAYM, 
          ATT_MAST_USER, ATT_MAST_RATE, ATT_NOMI_AMNT, 
          ATT_VIEW_STAT, 
          ATT_ENTR_DATE, ATT_ENTR_TIME, ATT_ENTR_USER, 
          ATT_UPDT_DATE, ATT_UPDT_TIME, ATT_UPDT_USER) 
        VALUES (
          :ATT_MAST_CODE, :ATT_MAST_ROOM, :ATT_MAST_PAYM, 
          :ATT_MAST_USER, :ATT_MAST_RATE, :ATT_NOMI_AMNT, 
          :ATT_VIEW_STAT, 
          :ATT_ENTR_DATE, :ATT_ENTR_TIME, :ATT_ENTR_USER, 
          :ATT_UPDT_DATE, :ATT_UPDT_TIME, :ATT_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);
//input(inattcode,inmastroom,inmastpaym,inmastuser,inmastrate,innomiamnt);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':ATT_MAST_CODE' =>$attcode,':ATT_MAST_ROOM' =>$mastroom,':ATT_MAST_PAYM' =>$mastpaym, 
        ':ATT_MAST_USER' =>$mastuser,':ATT_MAST_RATE' =>$mastrate,':ATT_NOMI_AMNT' =>$nomiamnt,           
        ':ATT_VIEW_STAT' =>$viewstat,
        ':ATT_ENTR_DATE' =>$dateinput, ':ATT_ENTR_TIME' =>$timeinput, ':ATT_ENTR_USER' =>$userid,
        ':ATT_UPDT_DATE' =>$dateinput, ':ATT_UPDT_TIME' =>$timeinput, ':ATT_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE attmast SET ATT_MAST_ROOM='$mastroom', ATT_MAST_PAYM='$mastpaym', 
            ATT_MAST_USER='$mastuser', ATT_MAST_RATE='$mastrate', ATT_NOMI_AMNT='$nomiamnt',
            ATT_VIEW_STAT='$viewstat',            
            ATT_UPDT_DATE='$dateinput',ATT_UPDT_TIME='$timeinput',ATT_UPDT_USER='$userid'    
            WHERE ATT_MAST_CODE='$attcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
