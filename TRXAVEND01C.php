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
        //$rawinput = '0009|PO-0002';
        //list($suplcode, $suplname) = explode("|",$rawinput);

        $queryview = "SELECT t.TRXA_PROC_CODE, t.TRXA_PROC_DIVI, t.TRXA_SUPL_CODE,
                    (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = t.TRXA_SUPL_CODE) AS SUPL_NAME, 
                    t.TRXA_PROC_VATX, t.TRXA_DOWN_PAID, t.TRXA_REMA_PAID,
                    i.TRXA_INVC_CODE, i.TRXA_DUED_DATE
                    FROM trxaproc AS t, trxainvc AS i
                    WHERE t.TRXA_PROC_CODE = i.TRXA_PROC_CODE
                    AND t.TRXA_PROC_CODE = '$rawinput'
                    AND t.TRXA_PROC_STAT = 'CL'
                    AND i.TRXA_INVC_STAT = 'U'";

        $xxqueryview = "SELECT SUPL_MAST_CODE, SUPL_MAIN_NAME
        FROM suplmast WHERE SUPL_MAST_CODE='$suplcode'
        ";

        $qview = $db->query($queryview) or die("Gagal Ambil Data Payment !!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $outproccode = "$rview[TRXA_PROC_CODE]";
            $outprocdivi = "$rview[TRXA_PROC_DIVI]";
            $outsuplcode = "$rview[TRXA_SUPL_CODE]";
            $outsuplname = "$rview[SUPL_NAME]";
            $outprocvatx = "$rview[TRXA_PROC_VATX]";
            $outdownpaid = "$rview[TRXA_DOWN_PAID]";
            $outremapaid = "$rview[TRXA_REMA_PAID]";
            $outinvccode = "$rview[TRXA_INVC_CODE]";
            $outdueddate = "$rview[TRXA_DUED_DATE]";
            ///        1           2             3           4           5              6          7             8           9
            echo "|$outproccode|$outprocdivi|$outsuplcode|$outsuplname|$outprocvatx|$outdownpaid|$outremapaid|$outinvccode|$outdueddate"; 
        }
   }
}
?>