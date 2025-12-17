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
        $icdcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT DIAG_ICD_CATEGORY, DIAG_ICD_SUBCATE, DIAG_ICD_CODE,
                        DIAG_ICD_NOTE  
                FROM diagmast 
                WHERE DIAG_ICD_CODE = '$icdcode' 
                AND DIAG_VIEW_STAT = 'Y' 
          ORDER by DIAG_ICD_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data ICD!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $icdcategory = "$rview[DIAG_ICD_CATEGORY]";
            $icdsubcate = "$rview[DIAG_ICD_SUBCATE]";
            $icdcode = "$rview[DIAG_ICD_CODE]";
            $icdnote = "$rview[DIAG_ICD_NOTE]";

            echo "|$icdcategory|$icdsubcate|$icdcode|$icdnote";    
        }
   }
}
?>