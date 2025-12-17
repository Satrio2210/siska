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
        $policode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLA_POLI_CODE, TBLA_POLI_NAME 
          FROM tblapoli 
          WHERE TBLA_POLI_CODE = '$policode' 
          AND TBLA_POLI_STAT = 'Y' 
          ORDER by TBLA_POLI_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Poli!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $policode = "$rview[TBLA_POLI_CODE]";
            $poliname = "$rview[TBLA_POLI_NAME]";

            echo "|$policode|$poliname";    
        }
   }
}
?>