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
        $vstcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT VST_MAST_CODE, VST_MAST_ROOM, 
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=VST_MAST_ROOM) AS POLI_NAME,
                VST_MAST_PAYM, VST_MAST_USER, 
                (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=VST_MAST_USER) AS USER_NAME,
                VST_MAXI_AMNT, VST_NOMI_AMNT 
                FROM vstmast 
                WHERE VST_MAST_CODE = '$vstcode' 
                AND VST_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Absen!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $vstcode = "$rview[VST_MAST_CODE]";
            $poliname = "$rview[POLI_NAME]";

            $mastroom = "$rview[VST_MAST_ROOM]";

            $mastpaym = "$rview[VST_MAST_PAYM]";

            $username = "$rview[USER_NAME]";
            $mastuser = "$rview[VST_MAST_USER]";
           
            $maxiamnt = "$rview[VST_MAXI_AMNT]";

            $nomiamnt = "$rview[VST_NOMI_AMNT]";

            echo "|$vstcode|$poliname|$mastroom|$mastpaym|$username|$mastuser|$maxiamnt|$nomiamnt";    
        }
   }
}
?>