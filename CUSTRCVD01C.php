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
        list($salecode, $regicode, $paticode) = explode("|",$rawdata);

        $view = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, 
                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_BIRT,
                TRXA_REGI_PAYM
                FROM trxaregi
                WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_PATI_CODE = '$paticode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $regidate = date("d-m-Y", strtotime($rview['TRXA_REGI_DATE']));
            $mainname = "$rview[MAIN_NAME]";
            $mainage = "$rview[MAIN_AGE]";
            $mainbirt = date("d-m-Y", strtotime($rview['MAIN_BIRT']));
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

            echo "|$regicode|$paticode|$mainname|$gender|$fullage|$regipaym|$salecode";    
        }
   }
}
?>