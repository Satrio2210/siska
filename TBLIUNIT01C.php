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

        $view = "SELECT TBLI_UNIT_CODE, TBLI_UNIT_NAME, TBLI_UNIT_DEVI 
          FROM tbliunit 
          WHERE TBLI_UNIT_CODE = '$unitcode' 
          AND TBLI_UNIT_STAT = 'Y' 
          ORDER by TBLI_UNIT_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Unit!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $unitcode = "$rview[TBLI_UNIT_CODE]";
            $unitname = "$rview[TBLI_UNIT_NAME]";
            $unitdevi = "$rview[TBLI_UNIT_DEVI]";
            echo "|$unitcode|$unitname|$unitdevi";    
        }
   }
}
?>