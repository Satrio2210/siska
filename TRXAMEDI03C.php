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
        $attcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT ATT_MAST_CODE, ATT_MAST_ROOM, 
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=ATT_MAST_ROOM) AS POLI_NAME,
                ATT_MAST_PAYM, ATT_MAST_USER, 
                (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=ATT_MAST_USER) AS USER_NAME,
                ATT_MAST_RATE, ATT_NOMI_AMNT 
                FROM attmast 
                WHERE ATT_MAST_CODE = '$attcode' 
                AND ATT_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Absen!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $attcode = "$rview[ATT_MAST_CODE]";
            $poliname = "$rview[POLI_NAME]";

            $mastroom = "$rview[ATT_MAST_ROOM]";

            $mastpaym = "$rview[ATT_MAST_PAYM]";

            $username = "$rview[USER_NAME]";
            $mastuser = "$rview[ATT_MAST_USER]";
           
            $mastrate = "$rview[ATT_MAST_RATE]";

            $nomiamnt = "$rview[ATT_NOMI_AMNT]";

            echo "|$attcode|$poliname|$mastroom|$mastpaym|$username|$mastuser|$mastrate|$nomiamnt|";    
        }
   }
}
?>