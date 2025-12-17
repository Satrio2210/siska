<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
include "inc/sanie.php";

if (isset($_POST['q']))
    {
        $regicode = $_POST['q'];
        //list($outdoctuser, $outschddays, $outschdstart) = explode("|",$rawdata);
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE trxaregi SET TRXA_REGI_STAT='X',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_REGI_CODE='$regicode'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

        // Closing item Tindakan menjadi terbayar 
        $update_tret = "UPDATE trxatret SET TRXA_TRET_STAT = 'P',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
                WHERE TRXA_TRET_CODE='$regicode'";
        // Prepare Request  
        $query_update_tret = $db->prepare($update_tret);

        // Mulai Input
        $db->beginTransaction();
        $query_update_tret->execute();
        $db->commit();

        // Ambil Nilai Jasa Tindakan
        //Ambil Total Fee Klinik dan Fee Dokter
        $query_tret = "SELECT TRXA_TRET_DOCT, TRXA_MEDI_CODE, TRXA_MEDI_RATE, TRXA_TRET_QUTY, 
                      (SELECT FEE_PART_USER FROM feemast WHERE FEE_MAST_USER = TRXA_TRET_DOCT AND FEE_MEDI_CODE=TRXA_MEDI_CODE) 
                      AS PART_USER 
                      WHERE TRXA_TRET_CODE = '$regicode'";

        $q_tret = $db->query($query_tret) or die("Gagal Ambil Data Tindakan");
        while ($r_tret = $q_gtret->fetch(PDO::FETCH_ASSOC))
        { 
        $medirate = $r_tret['TRXA_MEDI_RATE'];
        $tretquty = $r_tret['TRXA_TRET_QUTY'];
        $fee_user = $r_tret['PART_USER'];
        $fee_clinic = ($medirate - $partuser);

        $amount_fee_clinic = ($fee_clinic * $tretquty);
        $amount_fee_user = ($fee_user * $tretquty);

        $total_fee_clinic =  $total_fee_clinic + $amount_fee_clinic;
        $total_fee_user = $total_fee_user + $amount_fee_user;

        }

        $tret_null = 0;

        // Prepare Input Auto Jurnal
        // Generate Kode Transaksi Jurnal dengan kode TA = Transaction Auto       
        // Start Generate Kode Transaksi Jurnal  
        $sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                     ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
                     LIMIT 1";
        $qcode = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
        $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

        $jrnlcode = $rcode['TRXA_JRNL_CODE'];
        // ambil 4 huruf dari kanan
        $xcode = substr($jrnlcode, -4);
        $int = (int)$xcode;
        $int++;

        if ($int >= 10)
        { $xjrnlcode = "TA-00" . $int;}

        elseif ($int >= 100)
        { $xjrnlcode = "TA-0" . $int; }

        elseif ($int >= 1000)
        { $xjrnlcode = "TA-" . $int;  }

        else { $xjrnlcode = "TA-000" . $int;}
        // End Generate Kode Transaksi Jurnal         


        // Ambil Nilai Transaksi pendaftaran
        $query_regi = "SELECT TRXA_REGI_CODE AS REGI_CODE, 
                        (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = REGI_CODE limit 1) 
                        AS PAYM_MODE, TRXA_REGI_DOCT,
                        (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS DOCT_NAME, 
                    TRXA_REGI_FEE, TRXA_ENTR_USER, 
                    (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS EMPL_CODE,
                    (SELECT EMPL_MAIN_DIVI FROM emplmast WHERE EMPL_MAST_CODE = EMPL_CODE) AS DIVI_CODE,
                    (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = DIVI_CODE) AS DIVI_NAME,
                    (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS EMPL_NAME 
                    FROM trxaregi WHERE TRXA_REGI_CODE='$regicode'";

        $q_regi = $db->query($query_regi) or die("Gagal Ambil Data pendaftaran");
        $r_regi = $q_regi->fetch(PDO::FETCH_ASSOC);

        $id_admisi = $r_regi['EMPL_CODE']; 
        $name_admisi = $r_regi['EMPL_NAME'];
        
        $code_divisi = $r_regi['DIVI_CODE'];
        $name_divisi = $r_regi['DIVI_NAME'];

        $regi_doct = $r_regi['TRXA_REGI_DOCT'];
        $doct_name = $r_regi['DOCT_NAME'];

        $jrnlstat = 'Y';

        // ambil nilai fee admin
        $regifee = $r_regi['TRXA_REGI_FEE'];
        if ($regifee == 'Y')
            { $fee_klinik = $fee_admin - ($fee_kasir + $fee_daftar); }
        else
            {  $fee_klinik = 0; }

        // ambil metode bayar
        if ($r_regi['PAYM_MODE'] == 'TUN')
            {
            $code_payment = $code_cash;
            $name_payment = $name_cash;      
            }
        else if ($r_sale['TRXA_PAYM_MODE'] == 'BCA')
            {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
            }
        else if ($r_sale['TRXA_PAYM_MODE'] == 'MAN')
            {
            $code_payment = $code_mandiri;
            $name_payment = $name_mandiri;          
            }
        else if ($r_sale['TRXA_PAYM_MODE'] == 'BNI')
            {
            $code_payment = $code_bni;
            $name_payment = $name_bni;          
            }
        else if ($r_sale['TRXA_PAYM_MODE'] == 'BCM')
            {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
            }
        else if ($r_sale['TRXA_PAYM_MODE'] == 'LIN')
            {
            $code_payment = $code_bni;
            $name_payment = $name_bni;          
            }
        else
            {
            $code_payment = $code_cash;
            $name_payment = $name_cash;
            }



    // jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote

        // Input ke Kas Jasa Tindakan
        $cash_in_note = 'Fee Klinik tindakan nomor '.$regicode.''; 
        $input_cash_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_cash_in = $db->prepare($input_cash_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cash_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
        ':TRXA_JRNL_DEBT' =>$total_fee_clinic, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$cash_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Input ke Pendapatan Jasa Tindakan
        $jasa_in_note = ''.$regi_doct.' - ' .$doct_name. 'Jasa Tindakan nomor '.$regicode.'';
        $total_fee = $total_fee_clinic + $total_fee_user;

        $input_jasa_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_jasa_in = $db->prepare($input_jasa_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_jasa_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_tret_doct, ':TRXA_COAC_NAME' =>$name_tret_doct,                  
        ':TRXA_JRNL_DEBT' =>$tret_null, ':TRXA_JRNL_CRDT' =>$total_fee,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jasa_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Input ke Biaya Jasa Tindakan
        $cost_fee_note = ''.$regi_doct.' - ' .$doct_name. 'Biaya Jasa Tindakan nomor '.$regicode.'';

        $input_cost_fee = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_cost_fee = $db->prepare($input_cost_fee);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cost_fee->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_cost_doct, ':TRXA_COAC_NAME' =>$name_cost_doct,                  
        ':TRXA_JRNL_DEBT' =>$total_fee_user, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$cost_fee_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Kas Fee Admin
        $admin_in_note = 'Fee Admin  nomor '.$regicode.''; 
        $input_admin_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_admin_in = $db->prepare($input_admin_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_admin_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
        ':TRXA_JRNL_DEBT' =>$fee_klinik, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$admin_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Pendapatan Jasa  Admin
        $fee_admin_in_note = 'Fee Admin  nomor '.$regicode.''; 
        $input_fee_admin_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_fee_admin_in = $db->prepare($input_fee_admin_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_fee_admin_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_fee_admin, ':TRXA_COAC_NAME' =>$name_fee_admin,                  
        ':TRXA_JRNL_DEBT' =>$tret_null, ':TRXA_JRNL_CRDT' =>$fee_admin,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$fee_admin_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Biaya Jasa Admin 
        $cost_admin_in_note = ''.$id_admisi.' - ' .$name_admisi. 'Bayar Kwitansi nomor '.$regicode.''; 
        $input_cost_admin_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_cost_admin_in = $db->prepare($input_cost_admin_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cost_admin_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_cost_admin, ':TRXA_COAC_NAME' =>$name_cost_admin,                  
        ':TRXA_JRNL_DEBT' =>$fee_daftar, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$cost_admin_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Biaya Jasa Admin Lain lain
        $cost_other_in_note = ''.$id_admisi.' - ' .$name_admisi. 'Bayar Kwitansi nomor '.$regicode.''; 
        $input_cost_other_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_cost_other_in = $db->prepare($input_cost_other_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cost_other_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_cost_other, ':TRXA_COAC_NAME' =>$name_cost_other,                  
        ':TRXA_JRNL_DEBT' =>$fee_kasir, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$cost_other_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>