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
        $rawinput = xss_clean($_POST['q']);
        list($inwarecode, $instockcode, $intimecode) = explode("|",$rawinput);

        $view = "SELECT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_QUTY
                FROM investock 
                WHERE INVE_STOCK_CODE = '$instockcode'
                AND INVE_WARE_CODE = '$inwarecode' 
                AND INVE_VIEW_STAT IN ('R','Y','X')
                AND INVE_ENTR_TIME = '$intimecode'";

        $qview = $db->query($view) or die("Gagal Ambil Data Distance!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $stockcode = "$rview[INVE_STOCK_CODE]";
            $stockname = "$rview[INVE_STOCK_NAME]";
            $stockopna = "$rview[INVE_STOCK_QUTY]";
            $timecode = $intimecode;

            echo "|$stockcode|$stockname|$stockopna|$timecode";    
        }
   }
}
?>