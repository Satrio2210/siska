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
        $mastcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT LABO_MAST_CODE, LABO_SUBS_CODE, 
                (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE=LABO_SUBS_CODE) AS SUBS_NAME,
                LABO_SIZE_CODE, (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=LABO_SIZE_CODE) AS MEDI_NAME, 
                LABO_SIZE_NAME, LABO_UNIT_NAME, 
                (SELECT TBLL_UNIT_NAME FROM tbllunit WHERE TBLL_UNIT_CODE=LABO_UNIT_NAME) AS UNIT_NAME,
                LABO_VALU_MIN, LABO_VALU_MAX, LABO_VALU_STRG, LABO_PATI_GEND 
                FROM labomast 
                WHERE LABO_MAST_CODE = '$mastcode' 
                AND LABO_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Absen!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $mastcode = "$rview[LABO_MAST_CODE]";
            $subscode = "$rview[LABO_SUBS_CODE]";
            $subsname = "$rview[SUBS_NAME]";
            $sizecode = "$rview[LABO_SIZE_CODE]";
            $mediname = "$rview[MEDI_NAME]";
            $sizename = "$rview[LABO_SIZE_NAME]";
            $unitcode = "$rview[LABO_UNIT_NAME]";
            $unitname = "$rview[UNIT_NAME]";
            $valumin = "$rview[LABO_VALU_MIN]";
            $valumax = "$rview[LABO_VALU_MAX]";       
            $valustrg = "$rview[LABO_VALU_STRG]";    
            $patigend = "$rview[LABO_PATI_GEND]";

            echo "|$mastcode|$subscode|$subsname|$sizecode|$mediname|$sizename|$unitcode|$unitname|$valumin|$valumax|$valustrg|$patigend";    
        }
   }
}
?>