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
        $rawdata = xss_clean($_POST['q']);
        list($regicode, $paticode) = explode("|",$rawdata);

        $view = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, 
                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_BIRT,
                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_ADDR,

                TRXA_REGI_PAYM,
                (SELECT TRXA_EXAM_HGHT FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_HGHT,
                (SELECT TRXA_EXAM_WGHT FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_WGHT,
                (SELECT TRXA_EXAM_BLOD FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_BLOD,
                (SELECT TRXA_EXAM_TEMP FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_TEMP,

                (SELECT TRXA_MEDI_ALLE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS MEDI_ALLE,
                (SELECT TRXA_FOOD_ALLE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS FOOD_ALLE,
                (SELECT TRXA_CHRO_DSSE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS CHRO_DSSE,
                (SELECT TRXA_OTHR_DSSE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS OTHR_DSSE,
                (SELECT TRXA_PATI_CARE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS PATI_CARE,
                (SELECT TRXA_PATI_SURGE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS PATI_SURGE,
                (SELECT TRXA_PATI_SMOKE FROM trxaassm WHERE TRXA_ASSM_CODE=TRXA_REGI_CODE) AS PATI_SMOKE,

                (SELECT TRXA_EXAM_ANAM FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_ANAM,
                (SELECT TRXA_EXAM_BODY FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_BODY,
                (SELECT TRXA_EXAM_DIAG FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_DIAG,
                (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_PRSC
                FROM trxaregi
                WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_PATI_CODE = '$paticode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $regidate = date("d-m-Y", strtotime($rview['TRXA_REGI_DATE']));
            $mainname = "$rview[MAIN_NAME]";
            $mainage = "$rview[MAIN_AGE]";
            $mainbirt = date("d-m-Y", strtotime($rview['MAIN_BIRT']));
            $mainaddr = "$rview[MAIN_ADDR]";
            // tanggal lahir
            $tanggal = new DateTime($mainage);

            // tanggal hari ini
            $today = new DateTime('today');

            $y = $today->diff($tanggal)->y;
            $m = $today->diff($tanggal)->m;
            $d = $today->diff($tanggal)->d;
            $fullage = '' . $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';

            $maingend = "$rview[MAIN_GEND]";
            if ($maingend == 'M') { $gender = 'Laki Laki';}
            else if ($maingend = 'F') { $gender = 'Perempuan';}
            else { $gender = 'No Gender'; }

            $xregipaym = "$rview[TRXA_REGI_PAYM]";
            if ($xregipaym == 'U') { $regipaym = 'Umum'; }
            else if ($xregipaym == 'B') { $regipaym = 'BPJS'; }
            else if ($xregipaym == 'A') { $regipaym = 'Asuransi'; }
            else if ($xregipaym == 'P') { $regipaym = 'Perusahaan'; }
            else { $regipaym = 'Kosong';}

            $examhght = "$rview[EXAM_HGHT]";
            $examwght = "$rview[EXAM_WGHT]";
            $examblod = "$rview[EXAM_BLOD]";
            $examtemp = "$rview[EXAM_TEMP]";

            $medialle = "$rview[MEDI_ALLE]";
            $foodalle = "$rview[FOOD_ALLE]";
            $chrodsse = "$rview[CHRO_DSSE]";
            $othrdsse = "$rview[OTHR_DSSE]";
            $paticare = "$rview[PATI_CARE]";
            $patisurge = "$rview[PATI_SURGE]";
            $patismoke = "$rview[PATI_SMOKE]";

            $examanam = "$rview[EXAM_ANAM]";
            $exambody = "$rview[EXAM_BODY]";
            $examdiag = "$rview[EXAM_DIAG]";
            $examprsc = "$rview[EXAM_PRSC]";

            echo "|$regidate|$regicode|$paticode|$mainname|$fullage|$mainbirt|$mainaddr|$gender|$regipaym|$examhght|$examwght|$examblod|$examtemp|$medialle|$foodalle|$chrodsse|$othrdsse|$paticare|$patisurge|$patismoke|$examanam|$exambody|$examdiag|$examprsc|";    
        }
   }
}
?>