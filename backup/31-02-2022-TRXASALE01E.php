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

// Start Generate Kode urut Kwitansi  
$sqllast = "SELECT TRXA_SALE_CODE FROM trxasale               
            ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
            LIMIT 1";

$q = $db->query($sqllast) or die("Gagal Ambil Kode Kwitansi terakhir!!");
$r = $q->fetch(PDO::FETCH_ASSOC);

$sequcode = $r['TRXA_SALE_CODE'] = isset($r['TRXA_SALE_CODE']) ? $r['TRXA_SALE_CODE'] : '';

// ambil 4 huruf dari kanan
$xcode = substr($sequcode, -5);
$int = (int)$xcode;
$int++;

$xsequcode = "-" . sprintf("%'.05d\n", $int);
//if ($int >= 10)
//   { $xsequcode = "-000" . $int;}

//else if ($int >= 100)

//   { $xsequcode = "-00" . $int;}

//else if ($int >= 1000)
//   { $xsequcode = "-0" . $int;}

//else if ($int >= 10000)
//   { $xsequcode = "-" . $int;}

//else { $xsequcode = "-0000" . $int;}

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

    //Merubah Status Pasien dari diperiksa menjadi sudah bayar
    $update_status_pasien = "UPDATE trxaregi SET TRXA_REGI_STAT = 'P',
                        TRXA_UPDT_DATE='$dateinput',
                        TRXA_UPDT_TIME='$timeinput',
                        TRXA_UPDT_USER='$userid' WHERE TRXA_REGI_CODE='$regicode'";

    $query_update_status_pasien = $db->prepare($update_status_pasien);

    $db->beginTransaction();
    $query_update_status_pasien->execute();
    $db->commit();

    //Potong Stock Persediaan bhp di tabel Investock dengan metode LIFO
    //sesuai dengan item BHP yang di bayar menurut Registrasi Kode
    $query_get_csbl = "SELECT TRXA_STOCK_CODE, TRXA_STOCK_QUTY, TRXA_MEDI_ROOM 
                       FROM trxacsbl WHERE TRXA_CSBL_CODE='$regicode' AND TRXA_VIEW_STAT='Y'";

    $q_get_csbl = $db->query($query_get_csbl) or die("Gagal Ambil Data Stock BHP yang mau dibayar");
    while ($r_get_csbl = $q_get_csbl->fetch(PDO::FETCH_ASSOC))
    { 
        $stockcode = $r_get_csbl['TRXA_STOCK_CODE'];
        $stockquty = $r_get_csbl['TRXA_STOCK_QUTY'];
        $mediroom = $r_get_csbl['TRXA_MEDI_ROOM'];

        $query_potong_stock_bhp = "UPDATE investock SET INVE_STOCK_QUTY = (INVE_STOCK_QUTY - '$stockquty') 
                                WHERE INVE_STOCK_CODE = '$stockcode' 
                                AND (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) = '$mediroom'
                                AND INVE_STOCK_QUTY > 0
                                AND INVE_VIEW_STAT IN ('R','Y')
                                ORDER BY INVE_ENTR_DATE, INVE_ENTR_TIME DESC
                                LIMIT 1";

        $q_potong_stock_bhp = $db->prepare($query_potong_stock_bhp);

        $db->beginTransaction();
        $q_potong_stock_bhp->execute();
        $db->commit();
    }

   // Merubah status item BHP menjadi sudah di bayar di tabel trxacsbl dari status input(I) ke status bayar(P)
    $query_update_status_bhp = "UPDATE trxacsbl SET TRXA_CSBL_STAT = 'P',
                        TRXA_UPDT_DATE='$dateinput',
                        TRXA_UPDT_TIME='$timeinput',
                        TRXA_UPDT_USER='$userid' WHERE TRXA_CSBL_CODE='$regicode'";

    $q_update_status_bhp = $db->prepare($query_update_status_bhp);

    $db->beginTransaction();
    $q_update_status_bhp->execute();
    $db->commit();

// Proses Resep Obat
    //Melakukan Potong Stock Persediaan obat di tabel Investock dengan metode LIFO
    //sesuai dengan item resep yang di bayar menurut Registrasi Kode
    $query_get_prsc = "SELECT TRXA_STOCK_CODE, TRXA_STOCK_QUTY, TRXA_STOCK_BTCH 
                       FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                       AND TRXA_PRSC_STAT = 'I' 
                       AND TRXA_VIEW_STAT='Y'";

    $q_get_prsc = $db->query($query_get_prsc) or die("Gagal Ambil Data Stock Obat yang mau dibayar");
    while ($r_get_prsc = $q_get_prsc->fetch(PDO::FETCH_ASSOC))
    { 
        $stockcode = $r_get_prsc['TRXA_STOCK_CODE'];
        $stockquty = $r_get_prsc['TRXA_STOCK_QUTY'];
        $stockbtch = $r_get_prsc['TRXA_STOCK_BTCH'];

        $query_potong_stock_prsc = "UPDATE investock SET INVE_STOCK_QUTY = (INVE_STOCK_QUTY - '$stockquty') 
                                    WHERE INVE_STOCK_CODE = '$stockcode'
                                    AND INVE_STOCK_BTCH = '$stockbtch' 
                                    AND INVE_WARE_CODE = '$gudang_farmasi'
                                    AND INVE_STOCK_QUTY > 0
                                    AND INVE_VIEW_STAT IN ('R','Y')
                                    ORDER BY INVE_ENTR_DATE, INVE_ENTR_TIME DESC
                                    LIMIT 1";

        $q_potong_stock_prsc = $db->prepare($query_potong_stock_prsc);

        $db->beginTransaction();
        $q_potong_stock_prsc->execute();
        $db->commit();
    }

    //Merubah status item Resep menjadi sudah di bayar di tabel trxaprsc 
    //dari status input(I) ke status bayar(P)
    $query_update_status_prsc = "UPDATE trxaprsc SET TRXA_PRSC_STAT = 'P',
                        TRXA_UPDT_DATE='$dateinput',
                        TRXA_UPDT_TIME='$timeinput',
                        TRXA_UPDT_USER='$userid' WHERE TRXA_PRSC_CODE='$regicode' AND TRXA_VIEW_STAT='Y'";

    $q_update_status_prsc = $db->prepare($query_update_status_prsc);

    $db->beginTransaction();
    $q_update_status_prsc->execute();
    $db->commit();


    // Data primer input jurnal
    // jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote
    // Ambil Nilai BHP
    $query_csbl = "SELECT SUM(TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS TOTA_CSBL 
					FROM trxacsbl WHERE TRXA_CSBL_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";
    $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP");
    $rcsbl = $qcsbl->fetch(PDO::FETCH_ASSOC);

    $csbl_amnt = $rcsbl['TOTA_CSBL'];
	$csbl_tota = $csbl_amnt * $profit;
	$csbl_null = 0;

    // Ambil Nilai Resep
    $query_prsc = "SELECT SUM(TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS TOTA_PRSC 
					FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";
    $qprsc = $db->query($query_prsc) or die("Gagal Ambil data Resep");
    $rprsc = $qprsc->fetch(PDO::FETCH_ASSOC);

    $prsc_amnt = $rprsc['TOTA_PRSC'];
	$prsc_tota = $prsc_amnt * $profit;
	$prsc_null = 0;

	// Ambil Nilai Transaksi kasir
	$query_sale = "SELECT TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TRXA_REGI_POLI) AS POLI_NAME, 
    				TRXA_PAYM_OUTS, TRXA_PAYM_MODE, TRXA_ENTR_DATE, TRXA_ENTR_USER, 
                    (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS EMPL_CODE,
                    (SELECT EMPL_MAIN_DIVI FROM emplmast WHERE EMPL_MAST_CODE = EMPL_CODE) AS DIVI_CODE,
                    (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = DIVI_CODE) AS DIVI_NAME,
    				(SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS EMPL_NAME 
    				FROM trxasale WHERE TRXA_SALE_CODE='$salecode'";
    $q_sale = $db->query($query_sale) or die("Gagal Ambil Data Kasir");
    $r_sale = $q_sale->fetch(PDO::FETCH_ASSOC);
    $poliname = $r_sale['POLI_NAME'];

    $outstanding_csbl = $r_sale['TRXA_PAYM_OUTS'];
    $outstanding_prsc = $r_sale['TRXA_PAYM_OUTS'];
    $id_cashier = $r_sale['EMPL_CODE']; 
    $cashier = $r_sale['EMPL_NAME'];
    $code_divisi = $r_sale['DIVI_CODE'];
    $name_divisi = $r_sale['DIVI_NAME'];

    $jrnldate = $r_sale['TRXA_ENTR_DATE'];
    $jrnlstat = 'Y';
    $jrnlnote = ''.$id_cashier.' - ' .$cashier. ' Bayar Kwitansi nomor '.$salecode.'';
    
    if ($r_sale['TRXA_PAYM_MODE'] == 'TUN')
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
// Data Jurnal BHP
    // Start Generate Kode Transaksi Jurnal BHP  
    $sqllast_bhp = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                 ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
                 LIMIT 1";
    $qcode = $db->query($sqllast_bhp) or die("Gagal Ambil Kode Transaksi terakhir!!");
    $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

    $jrnlcode = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
    // ambil 4 huruf dari kanan
    $xcode = substr($jrnlcode, -4);
    $int = (int)$xcode;
    $int++;

    $jrnlcode_bhp = "TA-" . sprintf("%'.04d\n", $int); 

    $jrnlnote_bhp = 'Pembayaran Pemakaian BHP  - '.$salecode.''; 
    $jrnldate_bhp = $dateinput;

    $sqldivisi_bhp = "SELECT EMPL_MAIN_DIVI AS DIVI_CODE, 
                     (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=DIVI_CODE) AS DIVI_NAME 
                      FROM emplmast
                      WHERE EMPL_MAST_CODE = (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = '$userid')";

    $qdivisi_bhp = $db->query($sqldivisi_bhp) or die("Gagal ambil kode divisi");
    $rdivisi_bhp = $qdivisi_bhp->fetch(PDO::FETCH_ASSOC);

    $code_divisi_bhp = $rdivisi_bhp['DIVI_CODE'];
    $name_divisi_bhp = $rdivisi_bhp['DIVI_NAME'];

    if ($outstanding_csbl > 0)
    {

    // Input Kas Pembayaran Sebagian 
    $bayar_sebagian = $csbl_tota - $outstanding_csbl;
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$bayar_sebagian, ':TRXA_JRNL_CRDT' =>$csbl_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Piutang Sisa Pembayaran  

    $input_outstanding_csbl = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_outstanding_csbl = $db->prepare($input_outstanding_csbl);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_outstanding_csbl->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_account_receivable, ':TRXA_COAC_NAME' =>$name_account_receivable,                  
    ':TRXA_JRNL_DEBT' =>$outstanding_csbl, ':TRXA_JRNL_CRDT' =>$csbl_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    }
    else
    {
    // Input Kas Pembayaran Lunas 
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$csbl_tota, ':TRXA_JRNL_CRDT' =>$csbl_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();
	}

    // Input PPN Keluaran
    $dpp_csbl_amnt = ($csbl_tota * (100/110)); 
    $vat_out = $dpp_csbl_amnt * (10/100);
    $vat_out_null = 0;
    $input_vat_out = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_vat_out = $db->prepare($input_vat_out);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_vat_out->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_vat_out, ':TRXA_COAC_NAME' =>$name_vat_out,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$vat_out,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Penjualan BHP

    $input_sale_bhp = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_sale_bhp = $db->prepare($input_sale_bhp);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_sale_bhp->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_sale_bhp, ':TRXA_COAC_NAME' =>$name_sale_bhp,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$dpp_csbl_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Pemakaian Bahan BHP
    $input_usage_cost = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_usage_cost = $db->prepare($input_usage_cost);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_usage_cost->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_usage_cost, ':TRXA_COAC_NAME' =>$name_usage_cost,                  
    ':TRXA_JRNL_DEBT' =>$csbl_amnt, ':TRXA_JRNL_CRDT' =>$csbl_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Pengurangan Persediaan BHP
    $input_inventory_bhp = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_inventory_bhp = $db->prepare($input_inventory_bhp);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_inventory_bhp->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_bhp,':TRXA_JRNL_DATE' =>$jrnldate_bhp,  
    ':TRXA_COAC_CODE' =>$code_inventory_bhp, ':TRXA_COAC_NAME' =>$name_inventory_bhp,                  
    ':TRXA_JRNL_DEBT' =>$csbl_null, ':TRXA_JRNL_CRDT' =>$csbl_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi_bhp, ':TRXA_DIVI_NAME' =>$name_divisi_bhp, ':TRXA_JRNL_NOTE' =>$jrnlnote_bhp,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();


// Data Jurnal Resep
    // Start Generate Kode Transaksi Jurnal Resep  
    $sqllast_resep = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                 ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
                 LIMIT 1";
    $qcode = $db->query($sqllast_resep) or die("Gagal Ambil Kode Transaksi terakhir!!");
    $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

    $jrnlcode = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
    // ambil 4 huruf dari kanan
    $xcode = substr($jrnlcode, -4);
    $int = (int)$xcode;
    $int++;

    $jrnlcode_resep = "TA-" . sprintf("%'.04d\n", $int);

    $jrnlnote_resep = 'Pembayaran Resep - Kwitansi nomor '.$salecode.'';

    $jrnldate_resep = $dateinput;

    $sqldivisi_resep = "SELECT EMPL_MAIN_DIVI AS DIVI_CODE, 
                     (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=DIVI_CODE) AS DIVI_NAME 
                      FROM emplmast
                      WHERE EMPL_MAST_CODE = (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = '$userid')";

    $qdivisi_resep = $db->query($sqldivisi_resep) or die("Gagal ambil kode divisi");
    $rdivisi_resep = $qdivisi_bhp->fetch(PDO::FETCH_ASSOC);

    $code_divisi_resep = $rdivisi_bhp['DIVI_CODE'];
    $name_divisi_resep = $rdivisi_bhp['DIVI_NAME'];

    if ($outstanding_prsc > 0)
    {

    // Input Kas Pembayaran Sebagian 
    $pay_part = $prsc_tota - $outstanding_prsc;
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$pay_part, ':TRXA_JRNL_CRDT' =>$prsc_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Piutang Sisa Pembayaran  
    $input_outstanding_prsc = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_outstanding_prsc = $db->prepare($input_outstanding_prsc);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_outstanding_prsc->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_account_receivable, ':TRXA_COAC_NAME' =>$name_account_receivable,                  
    ':TRXA_JRNL_DEBT' =>$outstanding_prsc, ':TRXA_JRNL_CRDT' =>$prsc_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    }
    else
    {
    // Input Kas Pembayaran Lunas 
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$prsc_tota, ':TRXA_JRNL_CRDT' =>$prsc_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();
	}

    // Input PPN Keluaran
    $dpp_prsc_amnt = ($prsc_tota * (100/110)); 
    $vat_out = $dpp_prsc_amnt * (10/100);
    $vat_out_null = 0;
    $input_vat_out = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_vat_out = $db->prepare($input_vat_out);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_vat_out->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_vat_out, ':TRXA_COAC_NAME' =>$name_vat_out,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$vat_out,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Penjualan Obat
    $input_sale_drugs = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_sale_drugs = $db->prepare($input_sale_drugs);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_sale_drugs->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_sale_drugs, ':TRXA_COAC_NAME' =>$name_sale_drugs,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$dpp_prsc_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Pemakaian Bahan Obat
    $input_usage_cost = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_usage_cost = $db->prepare($input_usage_cost);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_usage_cost->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_usage_cost, ':TRXA_COAC_NAME' =>$name_usage_cost,                  
    ':TRXA_JRNL_DEBT' =>$prsc_amnt, ':TRXA_JRNL_CRDT' =>$prsc_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Pengurangan Persediaan Obat
    $input_inventory_drugs = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_inventory_drugs = $db->prepare($input_inventory_drugs);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_inventory_drugs->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_resep,':TRXA_JRNL_DATE' =>$jrnldate_resep,  
    ':TRXA_COAC_CODE' =>$code_inventory_drugs, ':TRXA_COAC_NAME' =>$name_inventory_drugs,                  
    ':TRXA_JRNL_DEBT' =>$prsc_null, ':TRXA_JRNL_CRDT' =>$prsc_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi_resep, ':TRXA_DIVI_NAME' =>$name_divisi_resep, ':TRXA_JRNL_NOTE' =>$jrnlnote_resep,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit(); 


?>      
