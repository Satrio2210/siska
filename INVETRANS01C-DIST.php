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
        list($warestart, $wareend) = explode("|",$rawinput);

        $queryview = "SELECT WARE_HOUS_DIST, WARE_HOUS_DAYS
        FROM waredist WHERE WARE_HOUS_START='$warestart' 
                      AND WARE_HOUS_END='$wareend'
                      AND WARE_VIEW_STAT = 'Y'
        ";


        $qview = $db->query($queryview) or die("Gagal Ambil Data Distance!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $housdays = "$rview[WARE_HOUS_DAYS]";
            $housdist = "$rview[WARE_HOUS_DIST]";

            echo "|$housdays|$housdist"; 
        }
   }
}
?>