<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//regicode,paticode,regidoct,regipoli,paymtota,paymamnt,paymdisc,paymmode

$rawinput = xss_clean($_POST['q']);
list($regicode, $paticode, $regidoct, $regipoli, $xpaymtota, $xpaymamnt, $xpaymdisc, $paymmode) = explode("|",$rawinput);
// kode invoice 26112020-00001
$paymtota = str_replace(".","",$xpaymtota);
$paymamnt = str_replace(".","",$xpaymamnt);
$paymdisc = str_replace(".","",$xpaymdisc);

$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaregicode = "SELECT COUNT(*) FROM trxasale WHERE TRXA_REGI_CODE='$regicode' AND TRXA_VIEW_STAT='Y'";
$periksaregicode_di_query=$db->query($periksaregicode) or die ("Cek Fail");
$ketersediaan = $periksaregicode_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode suplier baru
if ($ketersediaan == 0)
   {

    // Start Generate Kode urut Kwitansi  
    $sqllast = "SELECT TRXA_SALE_CODE FROM trxasale               
                ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
                LIMIT 1";

    $q = $db->query($sqllast) or die("Gagal Ambil Kode Kwitansi terakhir!!");
    $r = $q->fetch(PDO::FETCH_ASSOC);

    $sequcode = $r['TRXA_SALE_CODE'];
    // ambil 4 huruf dari kanan
    $xcode = substr($sequcode, -5);
    $int = (int)$xcode;
    $int++;

    if ($int >= 10)
        { $xsequcode = "-000" . $int;}

    else if ($int >= 100)

        { $xsequcode = "-00" . $int;}

    else if ($int >= 1000)
        { $xsequcode = "-0" . $int;}

    else if ($int >= 10000)
        { $xsequcode = "-" . $int;}

    else { $xsequcode = "-0000" . $int;}

//regicode,paticode,regidoct,regipoli,totapaym,paymamnt,paymdisc,paymmode
    $salecode = $daynow . '' . $monthnow . '' . $yearnow . '' . $xsequcode;
    // End Generate Kode Pendaftaran         
    $paymouts = $paymtota - $paymamnt;

    $input_bayar = "INSERT INTO trxasale (
    TRXA_SALE_CODE, TRXA_REGI_CODE, TRXA_PATI_CODE, 
    TRXA_REGI_DOCT, TRXA_REGI_POLI, TRXA_PAYM_TOTA,
    TRXA_PAYM_AMNT, TRXA_PAYM_DISC, TRXA_PAYM_OUTS, 
    TRXA_PAYM_MODE, TRXA_VIEW_STAT,          
    TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
    TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
    VALUES (
    :TRXA_SALE_CODE, :TRXA_REGI_CODE, :TRXA_PATI_CODE, 
    :TRXA_REGI_DOCT, :TRXA_REGI_POLI, :TRXA_PAYM_TOTA, 
    :TRXA_PAYM_AMNT, :TRXA_PAYM_DISC, :TRXA_PAYM_OUTS, 
    :TRXA_PAYM_MODE, :TRXA_VIEW_STAT,          
    :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
    :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
    // Prepare Request  
    $query_input_bayar = $db->prepare($input_bayar);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_bayar->execute(array(
    ':TRXA_SALE_CODE' =>$salecode, ':TRXA_REGI_CODE' =>$regicode, ':TRXA_PATI_CODE' =>$paticode,   
    ':TRXA_REGI_DOCT' =>$regidoct, ':TRXA_REGI_POLI' =>$regipoli, ':TRXA_PAYM_TOTA' =>$paymtota, 
    ':TRXA_PAYM_AMNT' =>$paymamnt, ':TRXA_PAYM_DISC' =>$paymdisc, ':TRXA_PAYM_OUTS' =>$paymouts, 
    ':TRXA_PAYM_MODE' =>$paymmode, ':TRXA_VIEW_STAT' =>$viewstat, 
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input_header);
    ///exit();
    $db->commit();

   }
   else
   {
    $update_bayar = "UPDATE trxasale SET TRXA_PAYM_AMNT=(TRXA_PAYM_AMNT +'$paymamnt'),
                    TRXA_PAYM_OUTS=(TRXA_PAYM_OUTS - '$paymamnt'), 
                    TRXA_PAYM_MODE='$paymmode', 
                    TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',TRXA_UPDT_USER='$userid'    
                    WHERE TRXA_REGI_CODE='$regicode'";
    // Prepare Request  
    $query_update_bayar = $db->prepare($update_bayar);

    $db->beginTransaction();
    $query_update_bayar->execute();
    $db->commit();

   }
?>      
