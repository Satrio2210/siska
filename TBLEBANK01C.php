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
        $bankcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLE_BANK_CODE, TBLE_BANK_NAME 
          FROM tblebank 
          WHERE TBLE_BANK_CODE = '$bankcode' 
          AND TBLE_BANK_STAT = 'Y' 
          ORDER by TBLE_BANK_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Bank!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $bankcode = "$rview[TBLE_BANK_CODE]";
            $bankname = "$rview[TBLE_BANK_NAME]";

            echo "|$bankcode|$bankname";    
        }
   }
}
?>