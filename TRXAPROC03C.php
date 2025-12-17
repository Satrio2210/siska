<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include 'inc/sanie.php';
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $rawinput = xss_clean($_POST['q']);
        list($proccode, $partcode) = explode("|",$rawinput);

       // Start Generate Batch Code   
            $xbatchcode = substr(str_shuffle('0123456789'),1,5);
            $batchcode = 'BTCH-'.$xbatchcode;
      // End Generate Kode          

        $view = "SELECT ITEM_PROC_CODE, ITEM_PART_CODE, ITEM_PART_UNIT, ITEM_QUTY_ORDR,
        (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_PART_CODE LIMIT 1) AS PART_NAME,
        (SELECT INVE_WITH_SRNM FROM invemast WHERE INVE_MAST_CODE=ITEM_PART_CODE LIMIT 1) AS WITH_SRNM,
        IF(ITEM_QUTY_RCVE IS NULL, '0', ITEM_QUTY_RCVE) AS QUTY_RCVE, 
        IF(ITEM_PROC_BTCH IS NULL, '', ITEM_PROC_BTCH) AS PROC_BTCH,  
        IF(ITEM_PROC_SRNM IS NULL, '', ITEM_PROC_SRNM) AS PROC_SRNM,  
        ITEM_ARRV_REQU,
        ITEM_WARE_CODE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = ITEM_WARE_CODE LIMIT 1) AS WARE_NAME,
        IF(ITEM_EMPL_CODE IS NULL, '', ITEM_EMPL_CODE) AS EMPL_CODE,  
        IF((SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = EMPL_CODE LIMIT 1) IS NULL,'',(SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = ITEM_EMPL_CODE LIMIT 1))  AS EMPL_NAME 
        FROM itemproc 
        WHERE ITEM_PROC_CODE='$proccode' AND ITEM_PART_CODE='$partcode'";

        $qview = $db->query($view) or die("Gagal Ambil Data Order!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $partunit = "$rview[ITEM_PART_UNIT]";
            $qutyordr = "$rview[ITEM_QUTY_ORDR]";
            $partname = "$rview[PART_NAME]";
            $withsrnm = "$rview[WITH_SRNM]";
            $qutyrcve = "$rview[QUTY_RCVE]";
            $qutyrest = ($qutyordr - $qutyrcve);
            $procbtch = "$rview[PROC_BTCH]";
            $procsrnm = "$rview[PROC_SRNM]";
            $arrvrequ = "$rview[ITEM_ARRV_REQU]";
            $warecode = "$rview[ITEM_WARE_CODE]";
            $warename = "$rview[WARE_NAME]";
            $emplcode = "$rview[EMPL_CODE]";
            $emplname = "$rview[EMPL_NAME]";
            echo "|$proccode|$partcode|$partunit|$partname|$withsrnm|$qutyrest|$batchcode|$procsrnm|$arrvrequ|$warecode|$warename|$emplcode|$emplname"; 
        }
   }
}
?>