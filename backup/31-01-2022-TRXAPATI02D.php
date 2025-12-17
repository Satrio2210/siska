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
        //$regicode = '09102021-00001';
        //list($outdoctuser, $outschddays, $outschdstart) = explode("|",$rawdata);
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $query_tret = "SELECT SUM(TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS TRET_AMNT FROM trxatret WHERE TRXA_TRET_CODE = '$regicode'
                        AND TRXA_VIEW_STAT='Y'";

        $qtret = $db->query($query_tret) or die("Gagal Ambil data tindakan!!");
        $row_tret = $qtret->fetch(PDO::FETCH_ASSOC);
        $tret_total = $row_tret['TRET_AMNT'];
        $tret_null = 0;


        $update = "UPDATE trxaregi SET TRXA_REGI_STAT='X',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_REGI_CODE='$regicode'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Update
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

        // Closing item Tindakan menjadi terbayar 
        $update_tret = "UPDATE trxatret SET TRXA_TRET_STAT = 'P',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
                WHERE TRXA_TRET_CODE='$regicode'
                AND TRXA_VIEW_STAT='Y'";

        // Prepare Request  
        $query_update_tret = $db->prepare($update_tret);

        // Mulai Update
        $db->beginTransaction();
        $query_update_tret->execute();
        $db->commit();


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
            { 
                $fee_klinik = $fee_admin; 
            }
        else
            {  
                $fee_klinik = 0; 
            }

        // ambil metode bayar
        if ($r_regi['PAYM_MODE'] == 'TUN')
            {
            $code_payment = $code_cash;
            $name_payment = $name_cash;      
            }
        else if ($r_regi['PAYM_MODE'] == 'BCA')
            {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
            }
        else if ($r_regi['PAYM_MODE'] == 'MAN')
            {
            $code_payment = $code_mandiri;
            $name_payment = $name_mandiri;          
            }
        else if ($r_regi['PAYM_MODE'] == 'BNI')
            {
            $code_payment = $code_bni;
            $name_payment = $name_bni;          
            }
        else if ($r_regi['PAYM_MODE'] == 'BCM')
            {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
            }
        else if ($r_regi['PAYM_MODE'] == 'LIN')
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

        $jrnlcode_tindakan = "TA-" . sprintf("%'.04d\n", $int);

        // End Generate Kode Transaksi Jurnal         

        // Input ke Kas Jasa Tindakan
        $jrnlnote_tindakan = 'Pendapatan Jasa Tindakan - '.$regicode.''; 
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
        ':TRXA_JRNL_CODE' =>$jrnlcode_tindakan,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
        ':TRXA_JRNL_DEBT' =>$tret_total, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_tindakan,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Input ke Pendapatan Jasa Tindakan

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
        ':TRXA_JRNL_CODE' =>$jrnlcode_tindakan,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_tret_doct, ':TRXA_COAC_NAME' =>$name_tret_doct,                  
        ':TRXA_JRNL_DEBT' =>$tret_null, ':TRXA_JRNL_CRDT' =>$tret_total,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_tindakan,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

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

        $jrnlcode_admin = "TA-" . sprintf("%'.04d\n", $int);

        // End Generate Kode Transaksi Jurnal         


      // Input ke Kas Fee Admin

  // Periksa apakah ada obat racikan
  $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";

  $periksaracikan_di_query=$db->query($periksaracikan) or die ("Cek Fail");
  $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

  if ($ketersediaan_racikan == 0)
  {

    // Periksa apakah ada resep yang diberikan
    $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";
                     
    $periksaresep_di_query=$db->query($periksaresep) or die ("Cek Fail");
    $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

    if ($ketersediaan_resep == 0)
    {
        // periksa di data register apakah di kenakan biaya admin
        $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' AND TRXA_REGI_FEE='Y'";
        $periksabiayaadmin_di_query=$db->query($periksabiayaadmin) or die ("Cek Fail");
        $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

        if ($ketersediaan_biayaadmin == 0)
        {
          $total_admin = 0;
        }
        else
        {
          $total_admin = $fee_admin;
        }                
    }
    else
    {
      $total_admin = ($fee_admin + $fee_resep);  
    }
    
  }
  else
  {
    $total_admin = ($fee_admin + ($fee_resep + $fee_racikan));  
  }



        $jrnlnote_admin = 'Pendapatan Jasa Admin nomor '.$regicode.''; 

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
        ':TRXA_JRNL_CODE' =>$jrnlcode_admin,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
        ':TRXA_JRNL_DEBT' =>$total_admin, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_admin,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Pendapatan Jasa  Admin
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
        ':TRXA_JRNL_CODE' =>$jrnlcode_admin,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_fee_admin, ':TRXA_COAC_NAME' =>$name_fee_admin,                  
        ':TRXA_JRNL_DEBT' =>$tret_null, ':TRXA_JRNL_CRDT' =>$total_admin,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_admin,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


////////////////////
        // Start Generate Kode Transaksi Jurnal Resep  
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

        $jrnlcode_resep = "TA-" . sprintf("%'.04d\n", $int);
        // End Generate Kode Transaksi Jurnal         

// Periksa apakah ada obat racikan
    $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' AND TRXA_PRSC_CONC='Y'";
    $periksaracikan_di_query=$db->query($periksaracikan) or die ("Cek Fail");
    $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

    if ($ketersediaan_racikan == 0)
    {

      // Input ke Kas Uang Jasa Resep
        $jrnlnote_resep = 'Pendapatan Jasa Resep Nomor '.$regicode.'';

        $fee_resep_farmasi = $fee_resep;
    }
    else
    {
      // Input ke Kas Uang Jasa Resep
        $jrnlnote_resep = 'Pendapatan Jasa Resep dan Racikan Nomor '.$regicode.'';

        $fee_resep_farmasi = $fee_resep + $fee_racikan;        
    } 
        
        $input_resep_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_resep_in = $db->prepare($input_resep_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_resep_in->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
        ':TRXA_JRNL_DEBT' =>$fee_resep_farmasi, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

      // Input ke Pendapatan Jasa Resep
        $input_fee_resep_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_fee_resep_in = $db->prepare($input_fee_resep_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_fee_resep_in->execute(array(
        ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_fee_resep, ':TRXA_COAC_NAME' =>$name_fee_resep,                  
        ':TRXA_JRNL_DEBT' =>$tret_null, ':TRXA_JRNL_CRDT' =>$fee_resep_farmasi,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

    }
?>