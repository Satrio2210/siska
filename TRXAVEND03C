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
        //$rawinput = '0009|PO-0002';
        list($stockcode, $proccode, $retustat) = explode("|",$rawinput);

        $queryview = "SELECT TRXA_PROC_DIVI, TRXA_SUPL_CODE, 
        (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
        (SELECT SUPL_MAIN_ADDR FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_ADDR,
        (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = TRXA_PROC_DIVI) AS DIVI_NAME
        FROM trxaproc WHERE TRXA_PROC_CODE='$proccode' AND 
        (SELECT ITEM_PART_CODE FROM itemproc WHERE ITEM_PROC_CODE = '$proccode' 
        AND ITEM_PART_CODE = '$stockcode') = '$stockcode'
        ";

        $qview = $db->query($queryview) or die("Gagal Ambil Data Return!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $retucode = "RET-".$proccode;
            $procdivi = "$rview[TRXA_PROC_DIVI]";
            $suplcode = "$rview[TRXA_SUPL_CODE]";
            $suplname = "$rview[SUPL_NAME]";
            $supladdr = "$rview[SUPL_ADDR]";
            $diviname = "$rview[DIVI_NAME]";

            echo "|$retucode|$stockcode|$proccode|$procdivi|$suplcode|$suplname|$supladdr|$diviname|$retustat"; 
        }
   }
}
?>