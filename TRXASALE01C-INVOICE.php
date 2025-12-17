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
        $rawdata = $_POST['q'];
        list($regicode, $paticode) = explode("|",$rawdata);

        $view = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DOCT, TRXA_REGI_POLI 
                FROM trxaregi
                WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        $rview = $qview->fetch(PDO::FETCH_ASSOC);  
        
        $regicode = "$rview[TRXA_REGI_CODE]";
        $paticode = "$rview[TRXA_PATI_CODE]";
        $regidoct = "$rview[TRXA_REGI_DOCT]";
        $regipoli = "$rview[TRXA_REGI_POLI]";

        
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
            else if ($xregipaym == 'H') { $regipaym = 'Halodoc'; }
            else { $regipaym = 'Kosong';}

            $examhght = "$rview[EXAM_HGHT]";
            $examwght = "$rview[EXAM_WGHT]";
            $examblod = "$rview[EXAM_BLOD]";
            $examanam = "$rview[EXAM_ANAM]";
            $examdiag = "$rview[EXAM_DIAG]";

            echo "|$regicode|$paticode|$mainname|$fullage|$gender|$regipaym|$examhght|$examwght|$examblod|$examanam|$examdiag|";    
        
   }
}
?>