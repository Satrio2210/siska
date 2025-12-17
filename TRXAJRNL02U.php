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
        $updatejurnal = $_POST['q'];

        //$updatejurnal='TA-0001|2020-11-01|1.01.1|1.01.1|Kas |30.000.000|0|FIN|Finance dan Keuangan|Setor Modal ke Kas Perusahaan|07:06:24';

        list($jrnlcode, $jrnldate, $oldcoaccode, $coaccode, $coacname, $xjrnldebt, $xjrnlcrdt, $divicode, $diviname, $jrnlnote, $entrtime) = explode("|",$updatejurnal);

$jrnldebt = str_replace(".","",$xjrnldebt);
$jrnlcrdt = str_replace(".","",$xjrnlcrdt);
$jrnlstat = 'Y';
$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

        $update = "UPDATE trxajrnl SET TRXA_JRNL_DATE = '$jrnldate', TRXA_COAC_CODE='$coaccode', TRXA_COAC_NAME='$coacname',
                    TRXA_JRNL_DEBT='$jrnldebt', TRXA_JRNL_CRDT='$jrnlcrdt', 
                    TRXA_DIVI_CODE='$divicode', TRXA_DIVI_NAME='$diviname', TRXA_JRNL_NOTE='$jrnlnote',
                    TRXA_UPDT_DATE='$dateinput', TRXA_UPDT_TIME='$timeinput', TRXA_UPDT_USER='$userid'
				WHERE TRXA_JRNL_CODE='$jrnlcode' AND TRXA_COAC_CODE='$oldcoaccode' AND TRXA_ENTR_TIME='$entrtime'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
    
    }
}
?>