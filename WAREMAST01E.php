<?php
session_start();
include "conf/config.php";
include "inc/sanie.php";

$rawdata = xss_clean($_POST['q']);
//$rawdata = 'BOX9|Kotak Alkes Poli gigi|FAR|PG|N|ID-0009|test';


list($houscode,$housname,$housloca,$mediroom,$houstype,$emplcode,$housnote) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksawaremast = "SELECT COUNT(*) FROM waremast WHERE WARE_HOUS_CODE='$houscode'";
$periksawaremast_di_query=$db->query($periksawaremast) or die ("Cek Fail");
$ketersediaan = $periksawaremast_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO waremast (
        WARE_HOUS_CODE, WARE_HOUS_NAME, WARE_HOUS_LOCA, WARE_MEDI_ROOM,
        WARE_HOUS_TYPE, WARE_EMPL_CODE, WARE_HOUS_NOTE, WARE_HOUS_STAT,
        WARE_ENTR_DATE, WARE_ENTR_TIME, WARE_ENTR_USER,  
        WARE_UPDT_DATE, WARE_UPDT_TIME, WARE_UPDT_USER) 
        VALUES (
        :WARE_HOUS_CODE, :WARE_HOUS_NAME, :WARE_HOUS_LOCA, :WARE_MEDI_ROOM, 
        :WARE_HOUS_TYPE, :WARE_EMPL_CODE, :WARE_HOUS_NOTE, :WARE_HOUS_STAT,
        :WARE_ENTR_DATE, :WARE_ENTR_TIME, :WARE_ENTR_USER,  
        :WARE_UPDT_DATE, :WARE_UPDT_TIME, :WARE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':WARE_HOUS_CODE' =>$houscode,':WARE_HOUS_NAME' =>$housname,':WARE_HOUS_LOCA' =>$housloca,
        ':WARE_MEDI_ROOM' =>$mediroom, 
        ':WARE_HOUS_TYPE' =>$houstype,':WARE_EMPL_CODE' =>$emplcode,':WARE_HOUS_NOTE' =>$housnote,
        ':WARE_HOUS_STAT' =>$viewstat,                   
        ':WARE_ENTR_DATE' =>$dateinput,':WARE_ENTR_TIME' =>$timeinput,':WARE_ENTR_USER' =>$userid,
        ':WARE_UPDT_DATE' =>$dateinput,':WARE_UPDT_TIME' =>$timeinput,':WARE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{
$update = "UPDATE waremast SET  WARE_HOUS_NAME='$housname', 
                                WARE_HOUS_LOCA='$housloca', 
                                WARE_MEDI_ROOM='$mediroom', 
                                WARE_HOUS_TYPE='$houstype', 
                                WARE_EMPL_CODE='$emplcode', 
                                WARE_HOUS_NOTE='$housnote', 
                    WARE_UPDT_DATE='$dateinput',
                    WARE_UPDT_TIME='$timeinput',
                    WARE_UPDT_USER='$userid'    
            WHERE WARE_HOUS_CODE='$houscode'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

}

?>      
