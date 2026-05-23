<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "conf/config.php";


$rawdata = $_POST['q'];

var_dump($rawdata);
// exit();
//$rawdata ='1187-00001|2021-08-11|A|U|DTIAR|PU|Y';
//examcode,examhght,examwght,examblod,examtemp

list($examcode, $examhght, $examwght, $examwaist, $exambmi, $examblod, $examtemp, $examrr, $examhr, $examcomp) = explode("|", $rawdata);

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
         TRXA_EXAM_HGHT,
         TRXA_EXAM_WGHT, 
         TRXA_EXAM_WAIST, 
         TRXA_EXAM_BMI, 
         TRXA_EXAM_BLOD, 
         TRXA_EXAM_TEMP, 
         TRXA_EXAM_RR, 
         TRXA_EXAM_HR, 
         TRXA_EXAM_COMP, TRXA_VIEW_STAT, 
         TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER, 
         TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_EXAM_CODE, 
        :TRXA_EXAM_HGHT,
        :TRXA_EXAM_WGHT,
        :TRXA_EXAM_WAIST,
        :TRXA_EXAM_BMI, 
        :TRXA_EXAM_BLOD, 
        :TRXA_EXAM_TEMP,
        :TRXA_EXAM_RR,
        :TRXA_EXAM_HR,
        :TRXA_EXAM_COMP, 
        :TRXA_VIEW_STAT, 
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER, 
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
                ':TRXA_EXAM_CODE' => $examcode,
                ':TRXA_EXAM_HGHT' => $examhght,
                ':TRXA_EXAM_WGHT' => $examwght,
                ':TRXA_EXAM_WAIST' => $examwaist,
                ':TRXA_EXAM_BMI' => $exambmi,
                ':TRXA_EXAM_BLOD' => $examblod,
                ':TRXA_EXAM_TEMP' => $examtemp,
                ':TRXA_EXAM_RR' => $examrr,
                ':TRXA_EXAM_HR' => $examhr,
                ':TRXA_EXAM_COMP' => $examcomp,
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
        $update = "UPDATE trxaexam SET TRXA_EXAM_HGHT='$examhght',
                    TRXA_EXAM_WGHT='$examwght',
                    TRXA_EXAM_WAIST='$examwaist',
                    TRXA_EXAM_BMI='$exambmi',
                    TRXA_EXAM_BLOD='$examblod',
                    TRXA_EXAM_TEMP='$examtemp',
                    TRXA_EXAM_RR='$examrr',
                    TRXA_EXAM_HR='$examhr',
                    TRXA_EXAM_COMP='$examcomp',
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


}

?>