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
        $speccode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLI_SPEC_CODE, TBLI_SPEC_NAME, TBLI_SPEC_NOTE 
          FROM tblispec 
          WHERE TBLI_SPEC_CODE = '$speccode' 
          AND TBLI_SPEC_STAT = 'Y' 
          ORDER by TBLI_SPEC_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Spec!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $speccode = "$rview[TBLI_SPEC_CODE]";
            $specname = "$rview[TBLI_SPEC_NAME]";
            $specnote = "$rview[TBLI_SPEC_NOTE]";
            echo "|$speccode|$specname|$specnote";    
        }
   }
}
?>