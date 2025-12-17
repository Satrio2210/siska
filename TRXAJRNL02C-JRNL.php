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
        $viewitemjurnal = $_POST['q'];
        //$hapusjurnal = 'TA-0001|2020-01-01|11.1.20000.00|BNI 46 (IDR) ( NO REK 0156788887 )|IDR|95.000.000|0|test aja';
        list($outjrnlcode, $outcoaccode, $outentrtime) = explode("|",$viewitemjurnal);

        $view = "SELECT TRXA_JRNL_CODE, TRXA_JRNL_DATE, TRXA_COAC_CODE, TRXA_COAC_NAME, 
                        TRXA_JRNL_DEBT, TRXA_JRNL_CRDT, TRXA_DIVI_CODE, 
                        TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_ENTR_TIME FROM trxajrnl 
				WHERE TRXA_JRNL_CODE='$outjrnlcode' AND TRXA_COAC_CODE='$outcoaccode' AND TRXA_ENTR_TIME='$outentrtime'
                AND TRXA_JRNL_STAT='Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Item Transaksi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $jrnlcode = "$rview[TRXA_JRNL_CODE]";
            $jrnldate = "$rview[TRXA_JRNL_DATE]";
            $coaccode = "$rview[TRXA_COAC_CODE]";
            $coacname = "$rview[TRXA_COAC_NAME]";
            $jrnldebt = "$rview[TRXA_JRNL_DEBT]";
            $jrnlcrdt = "$rview[TRXA_JRNL_CRDT]";
            $divicode = "$rview[TRXA_DIVI_CODE]";
            $diviname = "$rview[TRXA_DIVI_NAME]";
            $jrnlnote = "$rview[TRXA_JRNL_NOTE]"; 
            $entrtime = "$rview[TRXA_ENTR_TIME]";

            echo "|$jrnlcode|$jrnldate|$coaccode|$coacname|$jrnldebt|$jrnlcrdt|$divicode|$diviname|$jrnlnote|$entrtime|";    
        }
   }
}
?>