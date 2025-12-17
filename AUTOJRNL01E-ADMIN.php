<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include "inc/sanie.php";

$inputjurnal = xss_clean($_POST['q']);

list($salecode,$regicode,$jrnldate,$xfee_admin,$codefee_admin,$namefee_admin,$xfee_resep,$codefee_resep,$namefee_resep,$xcash_admin,$codecash_admin,$namecash_admin) = explode("|",$inputjurnal);

$fee_admin = str_replace(".","",$xfee_admin);
$fee_resep = str_replace(".","",$xfee_resep);
$cash_admin = str_replace(".","",$xcash_admin);

$nilainul = 0;
$jrnlstat = 'Y';
$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksasalecode = "SELECT COUNT(*) FROM autojrnl WHERE TRXA_SALE_CODE='$salecode' 
                    AND TRXA_REGI_CODE='$regicode' 
                    AND TRXA_COAC_CODE='$codefee_admin'";

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

    $jrnlnote = $salecode.'-Auto Jurnal Jasa Admin'; 

    $sql_user_primary = "SELECT TRXA_ENTR_USER FROM trxaregi WHERE TRXA_REGI_CODE = '$regicode'";
    $q_user_primary = $db->query($sql_user_primary) or die("Gagal ambil user primer");
    $r_user_primary = $q_user_primary->fetch(PDO::FETCH_ASSOC); 

    $user_primary = $r_user_primary['TRXA_ENTR_USER'];

    $sqldivisi = "SELECT EMPL_MAIN_DIVI AS DIVI_CODE, 
                      (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=DIVI_CODE) AS DIVI_NAME 
                      FROM emplmast
                      WHERE EMPL_MAST_CODE = (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = '$user_primary')";

    $qdivisi = $db->query($sqldivisi) or die("Gagal ambil kode divisi");
    $rdivisi = $qdivisi->fetch(PDO::FETCH_ASSOC);

    $divicode = $rdivisi['DIVI_CODE'];
    $diviname = $rdivisi['DIVI_NAME'];


    $sql_user_primary2 = "SELECT TRXA_ENTR_USER FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode'";
    $q_user_primary2 = $db->query($sql_user_primary2) or die("Gagal ambil user primer 2");
    $r_user_primary2 = $q_user_primary2->fetch(PDO::FETCH_ASSOC); 

    $user_primary2 = $r_user_primary2['TRXA_ENTR_USER'];

    $sqldivisi2 = "SELECT EMPL_MAIN_DIVI AS DIVI_CODE, 
                      (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=DIVI_CODE) AS DIVI_NAME 
                      FROM emplmast
                      WHERE EMPL_MAST_CODE = (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = '$user_primary2')";

    $qdivisi2 = $db->query($sqldivisi2) or die("Gagal ambil kode divisi");
    $rdivisi2 = $qdivisi->fetch(PDO::FETCH_ASSOC);

    $divicode2 = $rdivisi2['DIVI_CODE'];
    $diviname2 = $rdivisi2['DIVI_NAME'];

    $input_fee_admin = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
    $query_input_fee_admin = $db->prepare($input_fee_admin);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
           $query_input_fee_admin->execute(array(
            ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
            ':TRXA_COAC_CODE' =>$codefee_admin, ':TRXA_COAC_NAME' =>$namefee_admin,                  
            ':TRXA_JRNL_DEBT' =>$nilainul, ':TRXA_JRNL_CRDT' =>$fee_admin, 
            ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
            ':TRXA_JRNL_STAT' =>$jrnlstat,
            ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
            ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
            //print_r($db->error_Info());
            ///var_dump($query_input);
            ///exit();
            $db->commit();

    $input_fee_resep = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
    $query_input_fee_resep = $db->prepare($input_fee_resep);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_fee_resep->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$codefee_resep, ':TRXA_COAC_NAME' =>$namefee_resep,                  
        ':TRXA_JRNL_DEBT' =>$nilainul, ':TRXA_JRNL_CRDT' =>$fee_resep, 
        ':TRXA_DIVI_CODE' =>$divicode2, ':TRXA_DIVI_NAME' =>$diviname2, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

//$cash_admin = str_replace(".","",$xcash_admin);

    $input_cash_admin = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
    $query_input_cash_admin = $db->prepare($input_cash_admin);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
       $query_input_cash_admin->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode,':TRXA_JRNL_DATE' =>$jrnldate,  
        ':TRXA_COAC_CODE' =>$codecash_admin, ':TRXA_COAC_NAME' =>$namecash_admin,                  
        ':TRXA_JRNL_DEBT' =>$cash_admin, ':TRXA_JRNL_CRDT' =>$nilainul, 
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
        ':TRXA_COAC_CODE' =>$codefee_admin, ':TRXA_JRNL_DATE' =>$jrnldate, ':TRXA_VIEW_STAT' =>$jrnlstat,                  
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
                    AND TRXA_COAC_CODE='$codefee_admin'";

// Prepare Request  
$query_update_auto_jrnl = $db->prepare($update_auto_jrnl);

// Mulai Input
$db->beginTransaction();
$query_update_auto_jrnl->execute();
$db->commit();

}
?>      
