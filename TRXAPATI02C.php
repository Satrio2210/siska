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
                (SELECT PATI_MAIN_BLOD FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_BLOD,
                (SELECT PATI_MAIN_PHNE FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_PHNE,
                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_ADDR,
                TRXA_REGI_DATE, TRXA_REGI_FROM, TRXA_REGI_PAYM, 
                TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
                TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME, 
                TRXA_REGI_FEE 
                FROM trxaregi 
          WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $paticode = "$rview[TRXA_PATI_CODE]";
            $patiname = "$rview[PATI_NAME]";
            $patibirt = formatTanggal($rview['PATI_BIRT']);
            $patigend = "$rview[PATI_GEND]";
            $patiblod = "$rview[PATI_BLOD]";
            $patiphne = "$rview[PATI_PHNE]";
            $patiaddr = "$rview[PATI_ADDR]";
            $regidate = "$rview[TRXA_REGI_DATE]";
            $regifrom = "$rview[TRXA_REGI_FROM]";
            $regipaym = "$rview[TRXA_REGI_PAYM]";
            $regidoct = "$rview[TRXA_REGI_DOCT]";
            $doctname = "$rview[DOCT_NAME]";
            $regipoli = "$rview[TRXA_REGI_POLI]";
            $poliname = "$rview[POLI_NAME]";
            $regifee = "$rview[TRXA_REGI_FEE]";

            echo "|$paticode|$patiname|$patibirt|$patigend|$patiblod|$patiphne|$patiaddr|$regidate|$regifrom|$regipaym|$regidoct|$doctname|$regipoli|$poliname|$regifee|";    
        }
   }
}
?>