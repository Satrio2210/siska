<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include "inc/sanie.php";

$inputjurnal = xss_clean($_POST['q']);


list($salecode,$regicode,$jrnldate,$xsaledrugs,$codesaledrugs,$namesaledrugs,$xvatout,$codevatout,$namevatout,$xsalebhp,$codesalebhp,$namesalebhp,$xcashdrugs,$codecashdrugs,$namecashdrugs) = explode("|",$inputjurnal);

$saledrugs = str_replace(".","",$xsaledrugs);
$vatout = str_replace(".","",$xvatout);
$salebhp = str_replace(".","",$xsalebhp);
$cashdrugs = str_replace(".","",$xcashdrugs);

$nilainul = 0;
$jrnlstat = 'Y';
$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksasalecode = "SELECT COUNT(*) FROM autojrnl WHERE TRXA_SALE_CODE='$salecode' 
                    AND TRXA_REGI_CODE='$regicode' 
                    AND TRXA_COAC_CODE='$codesaledrugs'";
                    
$periksasalecode_di_query=$db->query($periksasalecode) or die ("Cek Fail");
$ketersediaan = $periksasalecode_di_query->fetchColumn();
 //Cek adanya jurnal dengan nomor kwitansi yang sama 
if ($ketersediaan == 0)
{

    // ambil kode jurnal terakhir //
    $sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC, TRXA_JRNL_CODE DESC
                LIMIT 1";

    $qcode = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
    $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

    $jrnlcodelast = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
    // ambil 4 huruf dari kanan
    $xcode = substr($jrnlcodelast, -4);
    $int = (int)$xcode;
    $int++;

    $jrnlcode = "TA-" . sprintf("%'.04d\n", $int); 

    $jrnlnote = $salecode.'-Auto Jurnal Penjualan Obat dan BHP'; 

    $sql_user_primary = "SELECT TRXA_REGI_DOCT FROM trxasale WHERE TRXA_SALE_CODE = '$salecode'";
    $q_user_primary = $db->query($sql_user_primary) or die("Gagal ambil user primer");
    $r_user_primary = $q_user_primary->fetch(PDO::FETCH_ASSOC); 

    $user_primary = $r_user_primary['TRXA_REGI_DOCT'];

    $sqldivisi = "SELECT EMPL_MAIN_DIVI AS DIVI_CODE, 
                      (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=DIVI_CODE) AS DIVI_NAME 
                      FROM emplmast
                      WHERE EMPL_MAST_CODE = (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = '$user_primary')";

    $qdivisi = $db->query($sqldivisi) or die("Gagal ambil kode divisi");
    $rdivisi = $qdivisi->fetch(PDO::FETCH_ASSOC);

    $divicode = $rdivisi['DIVI_CODE'];
    $diviname = $rdivisi['DIVI_NAME'];

    $input_saledrugs = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
            TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,        
            TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
            TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
            TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
            VALUES (
            :TRXA_JRNL_CODE, :TRXA_JRNL_DATE,  
            :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
            :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
            :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
            :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
    // Prepare Request  
    $query_input_saledrugs = $db->prepare($input_saledrugs);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
           $query_input_saledrugs->execute(array(
            ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
            ':TRXA_COAC_CODE' =>$codesaledrugs, ':TRXA_COAC_NAME' =>$namesaledrugs,                  
            ':TRXA_JRNL_DEBT' =>$nilainul, ':TRXA_JRNL_CRDT' =>$saledrugs, 
            ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
            ':TRXA_JRNL_STAT' =>$jrnlstat,
            ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
            ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
            //print_r($db->error_Info());
            ///var_dump($query_input);
            ///exit();
            $db->commit();


    $input_vatout = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,        
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_JRNL_CODE, :TRXA_JRNL_DATE,  
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
    $query_input_vatout = $db->prepare($input_vatout);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_vatout->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$codevatout, ':TRXA_COAC_NAME' =>$namevatout,                  
        ':TRXA_JRNL_DEBT' =>$nilainul, ':TRXA_JRNL_CRDT' =>$vatout, 
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


    $input_salebhp = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,        
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_JRNL_CODE, :TRXA_JRNL_DATE,  
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
    $query_input_salebhp = $db->prepare($input_salebhp);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_salebhp->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$codesalebhp, ':TRXA_COAC_NAME' =>$namesalebhp,                  
        ':TRXA_JRNL_DEBT' =>$nilainul, ':TRXA_JRNL_CRDT' =>$salebhp, 
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

    $input_cashdrugs = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,        
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_JRNL_CODE, :TRXA_JRNL_DATE,  
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
    $query_input_cashdrugs = $db->prepare($input_cashdrugs);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_cashdrugs->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$codecashdrugs, ':TRXA_COAC_NAME' =>$namecashdrugs,                  
        ':TRXA_JRNL_DEBT' =>$cashdrugs, ':TRXA_JRNL_CRDT' =>$nilainul, 
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

    // Input Auto Jurnal
    $input_auto_jrnl = "INSERT INTO autojrnl (TRXA_SALE_CODE, TRXA_REGI_CODE,  
        TRXA_COAC_CODE, TRXA_JRNL_DATE, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_SALE_CODE, :TRXA_REGI_CODE,  
        :TRXA_COAC_CODE, :TRXA_JRNL_DATE, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
    $query_input_auto_jrnl = $db->prepare($input_auto_jrnl);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_auto_jrnl->execute(array(
        ':TRXA_SALE_CODE' =>$salecode,':TRXA_REGI_CODE' =>$regicode,  
        ':TRXA_COAC_CODE' =>$codesaledrugs, ':TRXA_JRNL_DATE' =>$jrnldate, ':TRXA_VIEW_STAT' =>$jrnlstat,                  
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
}
else
{

$update_auto_jrnl = "UPDATE autojrnl SET TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
                    WHERE TRXA_SALE_CODE='$salecode' 
                    AND TRXA_REGI_CODE='$regicode' 
                    AND TRXA_COAC_CODE='$codesaledrugs'";

// Prepare Request  
$query_update_auto_jrnl = $db->prepare($update_auto_jrnl);

// Mulai Input
$db->beginTransaction();
$query_update_auto_jrnl->execute();
$db->commit();

}
?>      
