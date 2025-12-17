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
        $postcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLE_POST_CODE, TBLE_POST_NAME 
          FROM tblepost 
          WHERE TBLE_POST_CODE = '$postcode' 
          AND TBLE_POST_STAT = 'Y' 
          ORDER by TBLE_POST_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Posisi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $postcode = "$rview[TBLE_POST_CODE]";
            $postname = "$rview[TBLE_POST_NAME]";

            echo "|$postcode|$postname";    
        }
   }
}
?>