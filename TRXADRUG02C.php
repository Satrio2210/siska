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
        list($drugcode, $stockcode) = explode("|",$rawinput);

        $view = "SELECT ITEM_STOCK_CODE AS STOCK_CODE, ITEM_STOCK_BTCH,
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE= UNIT_CODE) AS UNIT_NAME,
           ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, ITEM_DRUG_CONC, ITEM_DRUG_SGNA, ITEM_DRUG_USAG
          FROM itemdrug 
          WHERE ITEM_DRUG_STAT='I' AND ITEM_DRUG_CODE='$drugcode' AND ITEM_STOCK_CODE = '$stockcode' AND ITEM_VIEW_STAT='Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Obat!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {

            $stockbtch = "$rview[ITEM_STOCK_BTCH]";
            $stockname = "$rview[STOCK_NAME]";
            $stockpric = "$rview[ITEM_STOCK_PRIC]";
            $stockquty = "$rview[ITEM_STOCK_QUTY]";
            $drugconc = "$rview[ITEM_DRUG_CONC]";
            $drugsgna = "$rview[ITEM_DRUG_SGNA]";
            $drugusag = "$rview[ITEM_DRUG_USAG]";

            echo "|$drugcode|$stockcode|$stockbtch|$stockname|$stockpric|$stockquty|$drugconc|$drugusag|"; 
        }
   }
}
?>