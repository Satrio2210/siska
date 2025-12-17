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
        $feecode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT FEE_MAST_CODE, FEE_MAST_ROOM, 
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=FEE_MAST_ROOM) AS POLI_NAME,
                FEE_MAST_TYPE, FEE_MAST_PAYM, FEE_MAST_USER, 
                (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=FEE_MAST_USER) AS USER_NAME,
                FEE_MEDI_CODE, 
                (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=FEE_MEDI_CODE) AS MEDI_NAME,
                FEE_MAST_RATE, FEE_PART_USER, FEE_PART_HOME, 
                FEE_MAXI_AMNT, FEE_MINI_AMNT 
                FROM feemast 
                WHERE FEE_MAST_CODE = '$feecode' 
                AND FEE_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Tindakan!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $feecode = "$rview[FEE_MAST_CODE]";
            $poliname = "$rview[POLI_NAME]";

            $mastroom = "$rview[FEE_MAST_ROOM]";

            $masttype = "$rview[FEE_MAST_TYPE]";
            $mastpaym = "$rview[FEE_MAST_PAYM]";

            $username = "$rview[USER_NAME]";
            $mastuser = "$rview[FEE_MAST_USER]";

            $mediname = "$rview[MEDI_NAME]";
            $medicode = "$rview[FEE_MEDI_CODE]";
            
            $mastrate = "$rview[FEE_MAST_RATE]";

            $partuser = "$rview[FEE_PART_USER]";
            $parthome = "$rview[FEE_PART_HOME]";

            $maxiamnt = "$rview[FEE_MAXI_AMNT]";
            $miniamnt = "$rview[FEE_MINI_AMNT]";
            // 1        2         3        4         5          6        7          8         9        10         11       12        13          14                
    echo "|$feecode|$poliname|$mastroom|$masttype|$mastpaym|$username|$mastuser|$mediname|$medicode|$mastrate|$partuser|$parthome|$maxiamnt|$miniamnt";    
        }
   }
}
?>