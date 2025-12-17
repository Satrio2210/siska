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
        $sgnacode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLP_SGNA_CODE, TBLP_SGNA_NAME 
          FROM tblpsgna 
          WHERE TBLP_SGNA_CODE = '$sgnacode' 
          AND TBLP_SGNA_STAT = 'Y' 
          ORDER by TBLP_SGNA_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Signa!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $sgnacode = "$rview[TBLP_SGNA_CODE]";
            $sgnaname = "$rview[TBLP_SGNA_NAME]";

            echo "|$sgnacode|$sgnaname";    
        }
   }
}
?>