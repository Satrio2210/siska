<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
//examcode,examdoct,examhght,examwght,examblod,examtemp,medialle,foodalle,chrodsse,othrdsse,paticare,patisurge,patismoke,examanam,exambody,examdiag,examprsc
list($examcode, $examdoct, $examhght, $examwght, $examwaist, $exambmi, $examblod, $examtemp, $examrr, $examhr, $examcomp, $medialle, $foodalle, $chrodsse, $othrdsse, $paticare, $patisurge, $patismoke, $examanam, $exambody, $examdiag, $examprsc) = explode("|", $rawdata);

$registat = 'C';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxaexam = "SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE='$examcode'";
$periksatrxaexam_di_query = $db->query($periksatrxaexam) or die("Cek Fail");
$ketersediaan = $periksatrxaexam_di_query->fetchColumn();

if ($ketersediaan == 0) {

        $input = "INSERT INTO trxaexam (
         TRXA_EXAM_CODE, 
         TRXA_EXAM_DOCT, 
         TRXA_EXAM_HGHT,
         TRXA_EXAM_WGHT,
         TRXA_EXAM_WAIST,
         TRXA_EXAM_BMI, 
         TRXA_EXAM_BLOD, 
         TRXA_EXAM_TEMP,
         TRXA_EXAM_RR,
         TRXA_EXAM_HR,
         TRXA_EXAM_COMP,
         TRXA_EXAM_ANAM, 
         TRXA_EXAM_BODY, 
         TRXA_EXAM_DIAG, 
         TRXA_EXAM_PRSC, TRXA_VIEW_STAT, 
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_EXAM_CODE, 
        :TRXA_EXAM_DOCT, 
        :TRXA_EXAM_HGHT,
        :TRXA_EXAM_WGHT,
        :TRXA_EXAM_WAIST,
        :TRXA_EXAM_BMI, 
        :TRXA_EXAM_BLOD, 
        :TRXA_EXAM_TEMP,
        :TRXA_EXAM_RR,
        :TRXA_EXAM_HR,
        :TRXA_EXAM_COMP,
        :TRXA_EXAM_ANAM, 
        :TRXA_EXAM_BODY, 
        :TRXA_EXAM_DIAG, 
        :TRXA_EXAM_PRSC, :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
                ':TRXA_EXAM_CODE' => $examcode,
                ':TRXA_EXAM_DOCT' => $examdoct,
                ':TRXA_EXAM_HGHT' => $examhght,
                ':TRXA_EXAM_WGHT' => $examwght,
                ':TRXA_EXAM_WAIST' => $examwaist,
                ':TRXA_EXAM_BMI' => $exambmi,
                ':TRXA_EXAM_BLOD' => $examblod,
                ':TRXA_EXAM_TEMP' => $examtemp,
                ':TRXA_EXAM_RR' => $examrr,
                ':TRXA_EXAM_HR' => $examhr,
                ':TRXA_EXAM_COMP' => $examcomp,
                ':TRXA_EXAM_ANAM' => $examanam,
                ':TRXA_EXAM_BODY' => $exambody,
                ':TRXA_EXAM_DIAG' => $examdiag,
                ':TRXA_EXAM_PRSC' => $examprsc,
                ':TRXA_VIEW_STAT' => $viewstat,
                ':TRXA_ENTR_DATE' => $dateinput,
                ':TRXA_ENTR_TIME' => $timeinput,
                ':TRXA_ENTR_USER' => $userid,
                ':TRXA_UPDT_DATE' => $dateinput,
                ':TRXA_UPDT_TIME' => $timeinput,
                ':TRXA_UPDT_USER' => $userid
        ));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        $update_status = "UPDATE trxaregi SET TRXA_REGI_STAT='C',
                                TRXA_UPDT_DATE='$dateinput',
                                TRXA_UPDT_TIME='$timeinput',
                                TRXA_UPDT_USER='$userid'    
                        WHERE TRXA_REGI_CODE='$examcode'";
        // Prepare Request  
        $query_update_status = $db->prepare($update_status);

        // Mulai Input
        $db->beginTransaction();
        $query_update_status->execute();
        $db->commit();

} else {
        $update = "UPDATE trxaexam SET TRXA_EXAM_HGHT='$examhght',
                    TRXA_EXAM_WGHT='$examwght',
                    TRXA_EXAM_WAIST='$examwaist',
                    TRXA_EXAM_BMI='$exambmi',
                    TRXA_EXAM_BLOD='$examblod',
                    TRXA_EXAM_TEMP='$examtemp',
                    TRXA_EXAM_RR='$examrr',
                    TRXA_EXAM_HR='$examhr',
                    TRXA_EXAM_COMP='$examcomp',
                    TRXA_EXAM_ANAM='$examanam',
                    TRXA_EXAM_BODY='$exambody',
                    TRXA_EXAM_DIAG='$examdiag',
                    TRXA_EXAM_PRSC='$examprsc',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_EXAM_CODE='$examcode'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

        $update_status = "UPDATE trxaregi SET TRXA_REGI_STAT='C',
                                TRXA_UPDT_DATE='$dateinput',
                                TRXA_UPDT_TIME='$timeinput',
                                TRXA_UPDT_USER='$userid'    
                        WHERE TRXA_REGI_CODE='$examcode'";
        // Prepare Request  
        $query_update_status = $db->prepare($update_status);

        // Mulai Input
        $db->beginTransaction();
        $query_update_status->execute();
        $db->commit();

}



// input data assesment pasien di tabel trxaassm

$periksaassm = "SELECT COUNT(*) FROM trxaassm WHERE TRXA_ASSM_CODE='$examcode'";
$periksaassm_di_query = $db->query($periksaassm) or die("Cek Fail");
$ketersediaanassm = $periksaassm_di_query->fetchColumn();

if ($ketersediaanassm == 0) {

        $input = "INSERT INTO trxaassm (
         TRXA_ASSM_CODE, TRXA_MEDI_ALLE, TRXA_FOOD_ALLE,
         TRXA_CHRO_DSSE, TRXA_OTHR_DSSE, TRXA_PATI_CARE,
         TRXA_PATI_SURGE, TRXA_PATI_SMOKE, TRXA_VIEW_STAT, 
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_ASSM_CODE, :TRXA_MEDI_ALLE, :TRXA_FOOD_ALLE,
        :TRXA_CHRO_DSSE, :TRXA_OTHR_DSSE, :TRXA_PATI_CARE,
        :TRXA_PATI_SURGE,:TRXA_PATI_SMOKE, :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE,:TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
        :TRXA_UPDT_DATE,:TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
                ':TRXA_ASSM_CODE' => $examcode,
                ':TRXA_MEDI_ALLE' => $medialle,
                ':TRXA_FOOD_ALLE' => $foodalle,
                ':TRXA_CHRO_DSSE' => $chrodsse,
                ':TRXA_OTHR_DSSE' => $othrdsse,
                ':TRXA_PATI_CARE' => $paticare,
                ':TRXA_PATI_SURGE' => $patisurge,
                ':TRXA_PATI_SMOKE' => $patismoke,
                ':TRXA_VIEW_STAT' => $viewstat,
                ':TRXA_ENTR_DATE' => $dateinput,
                ':TRXA_ENTR_TIME' => $timeinput,
                ':TRXA_ENTR_USER' => $userid,
                ':TRXA_UPDT_DATE' => $dateinput,
                ':TRXA_UPDT_TIME' => $timeinput,
                ':TRXA_UPDT_USER' => $userid
        ));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


} else {
        $update = "UPDATE trxaassm SET TRXA_MEDI_ALLE='$medialle',
                    TRXA_FOOD_ALLE='$foodalle',
                    TRXA_CHRO_DSSE='$chrodsse',
                    TRXA_OTHR_DSSE='$othrdsse',
                    TRXA_PATI_CARE='$paticare',
                    TRXA_PATI_SURGE='$patisurge',
                    TRXA_PATI_SMOKE='$patismoke',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_ASSM_CODE='$examcode'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();



}

?>