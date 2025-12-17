<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';
//$rawinput='VP-0001|inv-07-001|2021-07-31|1.1.2|BNI 46 (IDR) ( NO REK 0156788887 )|1234567890|2021-07-29|009|4.510.500|4.000.000';
$rawinput = xss_clean($_POST['q']);

list($vendcode,$invccode,$dueddate,$coaccode,$coacname,$cheqcode,$cheqdate,$cheqbank,$xsummamnt,$xpaymamnt) = explode("|",$rawinput);
$viewstat = 'Y';

$summamnt = str_replace(".","",$xsummamnt);
$paymamnt = str_replace(".","",$xpaymamnt);

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksapayment = "SELECT COUNT(*) FROM itemvend WHERE ITEM_VEND_CODE='$vendcode'";
$periksapayment_di_query=$db->query($periksapayment) or die ("Cek Code Cheque Payment Fail");
$ketersediaan = $periksapayment_di_query->fetchColumn();
//Cek adanya Kode paymen yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode payment baru
if ($ketersediaan == 0)
    {
        $input_summamnt = ($summamnt - $paymamnt);
    }
else
    {
        // ambil sisa terakhir pembayaran   
        $sumlast = "SELECT ITEM_SUMM_AMNT FROM itemvend WHERE ITEM_VEND_CODE = '$vendcode'
        ORDER BY ITEM_ENTR_DATE DESC, ITEM_ENTR_TIME DESC LIMIT 1";

        $qsum = $db->query($sumlast) or die("Gagal Ambil  saldo terakhir!!");
        $r = $qsum->fetch(PDO::FETCH_ASSOC);

        $input_summamnt = ($r['ITEM_SUMM_AMNT'] - $paymamnt);

    }
$input_payment = "INSERT INTO itemvend (ITEM_VEND_CODE, ITEM_INVC_CODE, ITEM_DUED_DATE, 
        ITEM_COAC_CODE, ITEM_CHEQ_CODE, ITEM_CHEQ_DATE,
        ITEM_CHEQ_BANK, ITEM_SUMM_AMNT, ITEM_PAYM_AMNT,
        ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (:ITEM_VEND_CODE, :ITEM_INVC_CODE, :ITEM_DUED_DATE,
        :ITEM_COAC_CODE, :ITEM_CHEQ_CODE, :ITEM_CHEQ_DATE,
        :ITEM_CHEQ_BANK, :ITEM_SUMM_AMNT, :ITEM_PAYM_AMNT, 
        :ITEM_VIEW_STAT, 
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";
// Prepare Request  
$query_input_payment = $db->prepare($input_payment);

// Mulai Input
///var_dump(array(
$db->beginTransaction();
$query_input_payment->execute(array(
':ITEM_VEND_CODE' =>$vendcode, ':ITEM_INVC_CODE' =>$invccode, ':ITEM_DUED_DATE' =>$dueddate,  
':ITEM_COAC_CODE' =>$coaccode, ':ITEM_CHEQ_CODE' =>$cheqcode, ':ITEM_CHEQ_DATE' =>$cheqdate,
':ITEM_CHEQ_BANK' =>$cheqbank, ':ITEM_SUMM_AMNT' =>$input_summamnt, ':ITEM_PAYM_AMNT' =>$paymamnt,
':ITEM_VIEW_STAT' =>$viewstat,
':ITEM_ENTR_DATE' =>$dateinput,':ITEM_ENTR_TIME' =>$timeinput,':ITEM_ENTR_USER' =>$userid,  
':ITEM_UPDT_DATE' =>$dateinput,':ITEM_UPDT_TIME' =>$timeinput,':ITEM_UPDT_USER' =>$userid));
///print_r($db->error_Info());
///var_dump($query_input_payment);
///exit();
$db->commit();        

// Input Jurnal Payment
// jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote
// 1. jrnlcode
// Generate Kode Transaksi Jurnal dengan kode TA = Transaction Auto       
// Start Generate Kode Transaksi Jurnal  
$sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
            ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
            LIMIT 1";
$qcode = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
$rcode = $qcode->fetch(PDO::FETCH_ASSOC);

$jrnlcode = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
// ambil 4 huruf dari kanan
$xcode = substr($jrnlcode, -4);
$int = (int)$xcode;
$int++;

$xjrnlcode = "TA-" . sprintf("%'.04d\n", $int);

//if ($int >= 10)
//    { $xjrnlcode = "TA-00" . $int;}

//elseif ($int >= 100)
//    { $xjrnlcode = "TA-0" . $int; }

//elseif ($int >= 1000)
//    { $xjrnlcode = $int;  }

//else { $xjrnlcode = "TA-000" . $int;}
// End Generate Kode Transaksi Jurnal         
// 2. jrnldate
$jrnldate = date("Y-m-d");

$sqldivi = "SELECT TRXA_INVC_CODE, TRXA_PROC_CODE AS PROC_CODE, 
            (SELECT TRXA_PROC_DIVI FROM trxaproc WHERE TRXA_PROC_CODE = PROC_CODE) AS DIVI_CODE,
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = DIVI_CODE) AS DIVI_NAME
            FROM trxainvc WHERE TRXA_INVC_CODE='$invccode'";

$qdivi = $db->query($sqldivi) or die("Gagal Ambil nama divisi ");
$rdivi = $qdivi->fetch(PDO::FETCH_ASSOC);
$divicode = $rdivi['DIVI_CODE'];
$diviname = $rdivi['DIVI_NAME'];

$jrnlstat = 'Y';
$jrnlnote = $invccode . '- AutoJurnal Pembayaran invoice dengan '.$cheqcode.'';

        // Data input Jurnal Pengurangan Hutang usaha
        $debt_payable = $paymamnt;
        $crdt_payable = 0;

        $input_account_payable = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_account_payable = $db->prepare($input_account_payable);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_account_payable->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$code_account_payable, ':TRXA_COAC_NAME' =>$name_account_payable,                  
        ':TRXA_JRNL_DEBT' =>$debt_payable, ':TRXA_JRNL_CRDT' =>$crdt_payable,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Data input Jurnal Pengeluaran Kas
        $debt_paymamnt = 0;
        $crdt_paymamnt = $paymamnt;

        $input_paymamnt = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_paymamnt = $db->prepare($input_paymamnt);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_paymamnt->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$coaccode, ':TRXA_COAC_NAME' =>$coacname,                  
        ':TRXA_JRNL_DEBT' =>$debt_paymamnt, ':TRXA_JRNL_CRDT' =>$crdt_paymamnt,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

?>      
