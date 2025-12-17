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
        $manucode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLL_MANU_CODE, TBLL_MANU_NAME 
          FROM tbllmanu 
          WHERE TBLL_MANU_CODE = '$manucode' 
          AND TBLL_VIEW_STAT = 'Y' 
          ORDER by TBLL_MANU_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Manual!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $manucode = "$rview[TBLL_MANU_CODE]";
            $manuname = "$rview[TBLL_MANU_NAME]";
            echo "|$manucode|$manuname";    
        }
   }
}
?>