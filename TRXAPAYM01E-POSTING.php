<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';


$paymcode = xss_clean($_POST['q']);

$jrnlstat = 'Y';

$amount_null = 0;

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaposting = "SELECT COUNT(*) FROM trxapaym WHERE TRXA_PAYM_CODE = '$paymcode' AND TRXA_PAYM_STAT = 'P'";
$periksaposting_di_query=$db->query($periksaposting) or die ("Cek Fail");
$ketersediaan = $periksaposting_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode fee tindakan baru

if ($ketersediaan == 0)
{

  // membuat kode transaksi jurnal
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

// Data yang akan di post
  $query_posting = "SELECT TRXA_PAYM_CODE, TRXA_PAYM_DATE, TRXA_COAC_CODE,
                 LEFT(TRXA_COAC_CODE,3) AS CASH_PRNT, RIGHT(TRXA_COAC_CODE,1) AS CASH_CODE, 
                (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = CASH_PRNT AND COAC_MAST_CODE = CASH_CODE) AS COAC_NAME,

                 TRXA_DIVI_CODE, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=TRXA_DIVI_CODE) AS DIVI_NAME,

                 TRXA_PAYE_CODE, LEFT(TRXA_PAYE_CODE,3) AS COST_PRNT, SUBSTR(TRXA_PAYE_CODE,5,2) AS COST_CODE, 
                (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = COST_PRNT AND COAC_MAST_CODE = COST_CODE) AS PAYE_NAME,

                 TRXA_PAYM_AMNT, TRXA_PAYM_NOTE  
                FROM trxapaym 
                WHERE TRXA_PAYM_CODE = '$paymcode' 
                AND TRXA_VIEW_STAT = 'Y'";

  $q_posting = $db->query($query_posting) or die("Gagal Ambil data posting!!");
  $r_posting = $q_posting->fetch(PDO::FETCH_ASSOC);

  $paymdate = $r_posting['TRXA_PAYM_DATE'];
  $coaccode = $r_posting['TRXA_COAC_CODE'];
  $coacname = $r_posting['COAC_NAME'];
  
  $divicode = $r_posting['TRXA_DIVI_CODE'];
  $diviname = $r_posting['DIVI_NAME'];

  $payecode = $r_posting['TRXA_PAYE_CODE'];
  $payename = $r_posting['PAYE_NAME'];

  $amount = $r_posting['TRXA_PAYM_AMNT'];

  $paymnote = $r_posting['TRXA_PAYM_NOTE'];

  $jrnlnote = $paymcode . '- AutoJurnal '.$paymnote.'';

        // input jurnal pengeluaran kas bank
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
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$paymdate,  
        ':TRXA_COAC_CODE' =>$coaccode, ':TRXA_COAC_NAME' =>$coacname,                  
        ':TRXA_JRNL_DEBT' =>$amount_null, ':TRXA_JRNL_CRDT' =>$amount,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // input Jurnal akun biaya 

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
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$paymdate,  
        ':TRXA_COAC_CODE' =>$payecode, ':TRXA_COAC_NAME' =>$payename,                  
        ':TRXA_JRNL_DEBT' =>$amount, ':TRXA_JRNL_CRDT' =>$amount_null,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // update status dari Input menjadi posting

        $update = "UPDATE trxapaym SET TRXA_PAYM_STAT = 'P', TRXA_UPDT_DATE='$dateinput',TRXA_UPDT_TIME='$timeinput',TRXA_UPDT_USER='$userid'    
                    WHERE TRXA_PAYM_CODE = '$paymcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

                echo "OK";

}
else
{
                echo "NO";
}

?>      
