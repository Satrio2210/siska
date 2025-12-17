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
        //$rawdata = $_POST['q'];
        $paticode = $_POST['q'];
        //$rawdata = '14102021-00002|1077-00001';
        //list($regicode, $paticode) = explode("|",$rawdata);

        $view = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                 PATI_MAIN_ADDR, PATI_MAIN_PROF, PATI_MAIN_PHNE,
                 (SELECT TRXA_ALLE_NOTE FROM trxaalle WHERE TRXA_PATI_CODE=PATI_MAST_CODE) AS ALLE_NOTE 
                FROM patimast
                WHERE PATI_MAST_CODE = '$paticode' AND PATI_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Pasien!!");
        $rview = $qview->fetch(PDO::FETCH_ASSOC);  
        
        $paticode = "$rview[PATI_MAST_CODE]";
        $mainpidn = "$rview[PATI_MAIN_PIDN]";
        $mainname = "$rview[PATI_MAIN_NAME]";


        $maingend = "$rview[PATI_MAIN_GEND]";

        if ($maingend == 'F') { $gender = 'Perempuan'; }
        else if ($maingend == 'M') { $gender = 'Laki Laki'; }
        else { $gender = 'Waria'; }

        $mainbirt = "$rview[PATI_MAIN_BIRT]";

        $datebirt = formatTanggal($mainbirt);

        // tanggal lahir
        $tanggal = new DateTime($mainbirt);

        // tanggal hari ini
        $today = new DateTime('today');

        $y = $today->diff($tanggal)->y;
        $m = $today->diff($tanggal)->m;
        $d = $today->diff($tanggal)->d;
        $mainage = '' . $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';

        $mainaddr = "$rview[PATI_MAIN_ADDR]";
        $mainprof = "$rview[PATI_MAIN_PROF]";
        $mainphne = "$rview[PATI_MAIN_PHNE]";
        $allenote = "$rview[ALLE_NOTE]";


        echo "|$paticode|$mainpidn|$mainname|$gender|$datebirt|$mainage|$mainaddr|$mainprof|$mainphne|$allenote|";    
        
   }
}
?>