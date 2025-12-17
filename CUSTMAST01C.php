<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $mastcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE, CUST_MAIN_ADDR, CUST_MAIN_CITY,
                        CUST_MAIN_CTRY, CUST_MAIN_PHNE, CUST_CRDT_LIMT, CUST_SHIP_NAME, CUST_SHIP_ADDR
                FROM custmast 
                WHERE CUST_MAST_CODE = '$mastcode' AND CUST_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Absen!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $mastcode = "$rview[CUST_MAST_CODE]";
            $mainname = "$rview[CUST_MAIN_NAME]";
            $maintype = "$rview[CUST_MAIN_TYPE]";
            $mainaddr = "$rview[CUST_MAIN_ADDR]";
            $maincity = "$rview[CUST_MAIN_CITY]";
            $mainctry = "$rview[CUST_MAIN_CTRY]";
            $mainphne = "$rview[CUST_MAIN_PHNE]";
            $crdtlimt = "$rview[CUST_CRDT_LIMT]";
            $shipname = "$rview[CUST_SHIP_NAME]";
            $shipaddr = "$rview[CUST_SHIP_ADDR]";       

            echo "|$mastcode|$mainname|$maintype|$mainaddr|$maincity|$mainctry|$mainphne|$crdtlimt|$shipname|$shipaddr";    
        }
   }
}
?>