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
        $paymcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TRXA_PAYM_CODE, TRXA_PAYM_DATE, TRXA_COAC_CODE,
                 LEFT(TRXA_COAC_CODE,3) AS CASH_PRNT, RIGHT(TRXA_COAC_CODE,1) AS CASH_CODE, 
                (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = CASH_PRNT AND COAC_MAST_CODE = CASH_CODE) AS COAC_NAME,

                 TRXA_CHEQ_CODE, TRXA_DIVI_CODE, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=TRXA_DIVI_CODE) AS DIVI_NAME,

                 TRXA_PAYE_CODE, LEFT(TRXA_PAYE_CODE,3) AS COST_PRNT, SUBSTR(TRXA_PAYE_CODE,5,2) AS COST_CODE, 
                (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = COST_PRNT AND COAC_MAST_CODE = COST_CODE) AS PAYE_NAME,

                 TRXA_PAYM_AMNT, TRXA_PAYM_NOTE, TRXA_PAYM_STAT  
                FROM trxapaym 
                WHERE TRXA_PAYM_CODE = '$paymcode' AND TRXA_PAYM_STAT = 'I' 
                AND TRXA_VIEW_STAT = 'Y'";

                
        $qview = $db->query($view) or die("Gagal Ambil Data Absen!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $paymcode = "$rview[TRXA_PAYM_CODE]";
            $paymdate = "$rview[TRXA_PAYM_DATE]";
            $coaccode = "$rview[TRXA_COAC_CODE]";
            $coacname = "$rview[COAC_NAME]";
            $cheqcode = "$rview[TRXA_CHEQ_CODE]";
            $divicode = "$rview[TRXA_DIVI_CODE]";
            $diviname = "$rview[DIVI_NAME]";
            $payecode = "$rview[TRXA_PAYE_CODE]";
            $payename = "$rview[PAYE_NAME]";
            $paymamnt = "$rview[TRXA_PAYM_AMNT]";       
            $paymnote = "$rview[TRXA_PAYM_NOTE]";    
            $paymstat = "$rview[TRXA_PAYM_STAT]";

            echo "|$paymcode|$paymdate|$coaccode|$coacname|$cheqcode|$divicode|$diviname|$payecode|$payename|$paymamnt|$paymnote|$paymstat";    
        }
   }
}
?>