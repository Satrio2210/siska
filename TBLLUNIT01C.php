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
        $unitcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLL_UNIT_CODE, TBLL_UNIT_NAME 
          FROM tbllunit 
          WHERE TBLL_UNIT_CODE = '$unitcode' 
          AND TBLL_VIEW_STAT = 'Y' 
          ORDER by TBLL_UNIT_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Unit!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $unitcode = "$rview[TBLL_UNIT_CODE]";
            $unitname = "$rview[TBLL_UNIT_NAME]";
            echo "|$unitcode|$unitname";    
        }
   }
}
?>