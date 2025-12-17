<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include "inc/sanie.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $regicode = $_POST['q'];
        //$regicode = '11082021-00001';
        //list($outdoctuser, $outschddays, $outschdstart) = explode("|",$rawdata);

        $view = "SELECT TRXA_PATI_CODE, (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_BIRT,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_GEND,
                TRXA_REGI_DATE, TRXA_REGI_DOCT,
                (SELECT TRXA_EXAM_HGHT FROM trxaexam WHERE TRXA_EXAM_CODE='$regicode') AS EXAM_HGHT,
                (SELECT TRXA_EXAM_WGHT FROM trxaexam WHERE TRXA_EXAM_CODE='$regicode') AS EXAM_WGHT,
                (SELECT TRXA_EXAM_BLOD FROM trxaexam WHERE TRXA_EXAM_CODE='$regicode') AS EXAM_BLOD,
                (SELECT TRXA_EXAM_TEMP FROM trxaexam WHERE TRXA_EXAM_CODE='$regicode') AS EXAM_TEMP

                FROM trxaregi 
          WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {

            $paticode = "$rview[TRXA_PATI_CODE]";
            $patiname = "$rview[PATI_NAME]";
            $patibirt = formatTanggal($rview['PATI_BIRT']);
            $patigend = "$rview[PATI_GEND]";
            $regidate = "$rview[TRXA_REGI_DATE]";
            $regidoct = "$rview[TRXA_REGI_DOCT]";
            $examhght = "$rview[EXAM_HGHT]";
            $examwght = "$rview[EXAM_WGHT]";
            $examblod = "$rview[EXAM_BLOD]";
            $examtemp = "$rview[EXAM_TEMP]";

            echo "|$regicode|$paticode|$patiname|$patibirt|$patigend|$regidate|$regidoct|$examhght|$examwght|$examblod|$examtemp|";    
        }
   }
}
?>