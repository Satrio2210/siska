<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_POST['q'];
//$kode = 'PO-0001'; 

if($kode)
{
        $sql = "SELECT TRXA_PROC_DATE, TRXA_PROC_DUED, TRXA_PROC_DIVI,
                (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = TRXA_PROC_DIVI) AS DIVI_NAME,  
                        TRXA_SUPL_CODE,
                (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
                (SELECT SUPL_MAIN_ADDR FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_ADDR, 
                        TRXA_PROC_FROB, TRXA_PROC_VATX, TRXA_PROC_TYPE, TRXA_TERM_PAID, TRXA_DOWN_PAID, TRXA_PROC_TERM
                FROM trxaproc WHERE TRXA_PROC_CODE = '$kode'";

        $q = $db->query($sql) or die("Gagal ambil data isian form!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $procdate = "$r[TRXA_PROC_DATE]";
            $procdued = "$r[TRXA_PROC_DUED]";

            $procdivi = "$r[TRXA_PROC_DIVI]";
            $diviname = "$r[DIVI_NAME]";

            $suplcode = "$r[TRXA_SUPL_CODE]";
            $suplname = "$r[SUPL_NAME]";

            $supladdr = "$r[SUPL_ADDR]";

			$procfrob = "$r[TRXA_PROC_FROB]";

            $procvatx = "$r[TRXA_PROC_VATX]";
            $proctype = "$r[TRXA_PROC_TYPE]";
            $termpaid = "$r[TRXA_TERM_PAID]";
            $downpaid = "$r[TRXA_DOWN_PAID]";
            $procterm = "$r[TRXA_PROC_TERM]";

        echo "|$procdate|$procdued|$diviname|$procdivi|$suplname|$suplcode|$supladdr|$procfrob|$procvatx|$proctype|$termpaid|$downpaid|$procterm|"; 
        }
}
?>	



