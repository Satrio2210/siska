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
        $varncode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLI_VARN_CODE, TBLI_VARN_NAME, TBLI_VARN_NOTE 
          FROM tblivarn 
          WHERE TBLI_VARN_CODE = '$varncode' 
          AND TBLI_VARN_STAT = 'Y' 
          ORDER by TBLI_VARN_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Varian!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $varncode = "$rview[TBLI_VARN_CODE]";
            $varnname = "$rview[TBLI_VARN_NAME]";
            $varnnote = "$rview[TBLI_VARN_NOTE]";
            echo "|$varncode|$varnname|$varnnote";    
        }
   }
}
?>