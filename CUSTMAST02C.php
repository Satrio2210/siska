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
        $listcode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TRXA_LIST_CODE, TRXA_INVE_CODE,
                 (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS INVE_NAME,
                 (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS SPEC_CODE,
                 (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=SPEC_CODE) AS SPEC_NAME, 
                 TRXA_CUST_CODE, (SELECT CUST_MAIN_NAME FROM custmast WHERE CUST_MAST_CODE=TRXA_CUST_CODE) AS CUST_NAME, 
                 TRXA_CUST_TYPE
                 FROM trxacust 
                WHERE TRXA_LIST_CODE = '$listcode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data List!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $listcode = "$rview[TRXA_LIST_CODE]";
            $invecode = "$rview[TRXA_INVE_CODE]";
            $invename = "$rview[INVE_NAME]" . ' ' . "$rview[SPEC_NAME]";
            $custcode = "$rview[TRXA_CUST_CODE]";
            $custname = "$rview[CUST_NAME]";
            $custtype = "$rview[TRXA_CUST_TYPE]";

            echo "|$listcode|$invecode|$invename|$custcode|$custname|$custtype";    
        }
   }
}
?>