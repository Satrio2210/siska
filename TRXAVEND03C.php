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
        //list($stockcode, $proccode, $retustat) = explode("|",$rawinput);

        $queryview = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_SUPL_CODE,
        (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME 
        FROM trxavend WHERE TRXA_VEND_CODE='$rawinput' AND 
        TRXA_VEND_STAT = 'A'
        ";

        $qview = $db->query($queryview) or die("Gagal Ambil Data Payment!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $vendcode = "$rview[TRXA_VEND_CODE]";
            $venddate = "$rview[TRXA_VEND_DATE]";
            $suplcode = "$rview[TRXA_SUPL_CODE]";
            $suplname = "$rview[SUPL_NAME]";

            echo "|$vendcode|$venddate|$suplcode|$suplname"; 
        }
   }
}
?>