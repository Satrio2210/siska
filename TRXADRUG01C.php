<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include 'inc/sanie.php';
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $rawinput = xss_clean($_POST['q']);
        list($prsccode, $stockcode) = explode("|",$rawinput);

        $view = "SELECT TRXA_PRSC_CODE, (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_PRSC_CODE) AS PATI_CODE,
        (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS MAIN_NAME,
        (SELECT CASE WHEN PATI_MAIN_GEND = 'M' THEN 'Laki Laki'
                     WHEN PATI_MAIN_GEND = 'F' THEN 'Perempuan'
         END AS MAIN_GEND FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS GENDER,

        TRXA_STOCK_CODE, (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS STOCK_NAME,
        TRXA_STOCK_BTCH, TRXA_PRSC_CONC, TRXA_STOCK_QUTY 
        FROM trxaprsc 
        WHERE TRXA_PRSC_CODE='$prsccode' AND TRXA_STOCK_CODE = '$stockcode' AND TRXA_VIEW_STAT='Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Obat!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $prsccode = "$rview[TRXA_PRSC_CODE]";
            $paticode = "$rview[PATI_CODE]";
            $mainname = "$rview[MAIN_NAME]";
            $maingend = "$rview[GENDER]";
            $stockcode = "$rview[TRXA_STOCK_CODE]";
            $stockname = "$rview[STOCK_NAME]";
            $stockbtch = "$rview[TRXA_STOCK_BTCH]";
            $prscconc = "$rview[TRXA_PRSC_CONC]";
            $stockquty = "$rview[TRXA_STOCK_QUTY]";
            echo "|$prsccode|$paticode|$mainname|$maingend|$stockcode|$stockname|$stockbtch|$prscconc|$stockquty|"; 
        }
   }
}
?>