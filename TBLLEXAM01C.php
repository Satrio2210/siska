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
        $examcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLL_EXAM_CODE, TBLL_EXAM_NAME 
          FROM tbllexam 
          WHERE TBLL_EXAM_CODE = '$examcode' 
          AND TBLL_VIEW_STAT = 'Y' 
          ORDER by TBLL_EXAM_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Unit!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $examcode = "$rview[TBLL_EXAM_CODE]";
            $examname = "$rview[TBLL_EXAM_NAME]";
            echo "|$examcode|$examname";    
        }
   }
}
?>