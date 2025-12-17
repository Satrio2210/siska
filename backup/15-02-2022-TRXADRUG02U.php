<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include "inc/sanie.php";

if (isset($_POST['txtdrugcode']) && ($_POST['txtdrugcode'] != ''))
    {
        $drugcode = $_POST['txtdrugcode'];

        if(isset($_POST['optpaymmode']) && ($_POST['optpaymmode'] != ''))  {$paymmode = $_POST['optpaymmode'];}//ok
        if(isset($_POST['txtpaymamnt']) && ($_POST['txtpaymamnt'] != ''))  {$xpaymamnt = $_POST['txtpaymamnt'];}//ok

        if(isset($_POST['txtpaymdisc']) && ($_POST['txtpaymdisc'] != ''))  {$xpaymdisc = $_POST['txtpaymdisc'];}//ok

        $paymamnt = str_replace(".","",$xpaymamnt);
        $paymdisc = str_replace(".","",$xpaymdisc);
        $paymouts = ($paymamnt - $paymdisc);
        $drug_null = 0;

        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("H:i:s");

        //Melakukan Potong Stock Persediaan obat di tabel Investock dengan metode LIFO
        //sesuai dengan item obat yang di bayar menurut Registrasi Kode
        $query_get_drug = "SELECT ITEM_STOCK_CODE, ITEM_STOCK_BTCH, ITEM_STOCK_QUTY 
                       FROM itemdrug WHERE ITEM_DRUG_CODE='$drugcode' 
                       AND ITEM_DRUG_STAT = 'I' 
                       AND ITEM_VIEW_STAT='Y'";

        $q_get_drug = $db->query($query_get_drug) or die("Gagal Ambil Data Stock Obat yang mau dibayar");
        while ($r_get_drug = $q_get_drug->fetch(PDO::FETCH_ASSOC))
        { 
            $stockcode = $r_get_drug['ITEM_STOCK_CODE'];
            $stockquty = $r_get_drug['ITEM_STOCK_QUTY'];
            $stockbtch = $r_get_drug['ITEM_STOCK_BTCH'];

            $query_potong_stock_drug = "UPDATE investock SET INVE_STOCK_QUTY = (INVE_STOCK_QUTY - '$stockquty') 
                                    WHERE INVE_STOCK_CODE = '$stockcode'
                                    AND INVE_STOCK_BTCH = '$stockbtch' 
                                    AND INVE_WARE_CODE = '$gudang_farmasi'
                                    AND INVE_STOCK_QUTY > 0
                                    AND INVE_VIEW_STAT IN ('R','Y')
                                    ORDER BY INVE_ENTR_DATE, INVE_ENTR_TIME DESC
                                    LIMIT 1";

            $q_potong_stock_drug = $db->prepare($query_potong_stock_drug);

            $db->beginTransaction();
            $q_potong_stock_drug->execute();
            $db->commit();
        }

        //Merubah status item obat menjadi sudah di bayar di tabel itemdrug 
        //dari status input(I) ke status bayar(P)
        $query_update_status_drug = "UPDATE itemdrug SET ITEM_DRUG_STAT = 'P',
                        ITEM_UPDT_DATE='$dateinput',
                        ITEM_UPDT_TIME='$timeinput',
                        ITEM_UPDT_USER='$userid' WHERE ITEM_DRUG_CODE='$drugcode' AND ITEM_VIEW_STAT='Y'";

        $q_update_status_drug = $db->prepare($query_update_status_drug);

        $db->beginTransaction();
        $q_update_status_drug->execute();
        $db->commit();

        // Merubah status faktur menjadi sudah di bayar di tabel trxadrug
        // dari status input ke status prmbayaran , I ke P
        $update = "UPDATE trxadrug SET  TRXA_PAYM_AMNT='$paymamnt', 
                                        TRXA_PAYM_DISC='$paymdisc', 
                                        TRXA_PAYM_OUTS='$paymouts',
                                        TRXA_PAYM_MODE='$paymmode', 
                                        TRXA_DRUG_STAT='P',
                                        TRXA_UPDT_DATE='$dateinput', 
                                        TRXA_UPDT_TIME='$timeinput', 
                                        TRXA_UPDT_USER='$userid' 
                    WHERE TRXA_DRUG_CODE='$drugcode' AND TRXA_VIEW_STAT='Y'";

        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

        // mengambil kode dan nama divi dari user id yang aktif
        //

        $sql_divisi = "SELECT TRXA_UPDT_DATE, TRXA_UPDT_USER, 
                      (SELECT PASS_EMPL_CODE FROM passiden WHERE PASS_USER_IDEN = TRXA_UPDT_USER) AS EMPL_CODE,
                      (SELECT EMPL_MAIN_DIVI FROM emplmast WHERE EMPL_MAST_CODE = EMPL_CODE) AS DIVI_CODE,
                      (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = DIVI_CODE) AS DIVI_NAME,
                      (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS EMPL_NAME 
                    FROM trxadrug WHERE TRXA_DRUG_CODE='$drugcode' AND TRXA_VIEW_STAT = 'Y'";

        $qdivisi = $db->query($sql_divisi) or die("Gagal ambil kode divisi");
        $rdivisi = $qdivisi->fetch(PDO::FETCH_ASSOC);

        $code_divisi = $rdivisi['DIVI_CODE'];
        $name_divisi = $rdivisi['DIVI_NAME'];
        $jrnldate = $rdivisi['TRXA_UPDT_DATE'];


// Data Jurnal Resep
    // Start Generate Kode Transaksi Jurnal Penjualan Obat  
    $sqllast_obat = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                 ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";

    $qcode = $db->query($sqllast_obat) or die("Gagal Ambil Kode Transaksi terakhir!!");
    $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

    $jrnlcode = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
    // ambil 4 huruf dari kanan
    $xcode = substr($jrnlcode, -4);
    $int = (int)$xcode;
    $int++;

    $jrnlcode_obat = "TA-" . sprintf("%'.04d\n", $int);


    // menentukan jenis pembayaran

    if ($paymmode == 'TUN')
    {
        $code_payment = $code_cash;
        $name_payment = $name_cash;      
    }
    else if ($paymmode == 'BCA')
    {
        $code_payment = $code_bca;
        $name_payment = $name_bca;          
    }
    else if ($paymmode == 'MAN')
    {
        $code_payment = $code_mandiri;
        $name_payment = $name_mandiri;          
    }
    else if ($paymmode == 'BNI')
    {
        $code_payment = $code_bni;
        $name_payment = $name_bni;          
    }
    else if ($paymmode == 'BCM')
    {
        $code_payment = $code_bca;
        $name_payment = $name_bca;          
    }
    else if ($paymmode == 'LIN')
    {
        $code_payment = $code_bni;
        $name_payment = $name_bni;          
    }
    else
    {
        $code_payment = $code_cash;
        $name_payment = $name_cash;
    }

    // jenis pembayaran 

    $jrnlnote_obat = 'Penjualan Obat - Faktur Nomor '.$drugcode.'';
    $jrnlstat = 'Y';

    if ($paymdisc > 0)
    {

    // Input Kas Pembayaran Sebagian 
    $pay_part = $paymamnt - $paymdisc;

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
    ':TRXA_JRNL_CODE' =>$jrnlcode_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$pay_part, ':TRXA_JRNL_CRDT' =>$drug_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_obat,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Input Piutang Sisa Pembayaran  
    $input_outstanding_drug = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
     $query_input_outstanding_drug = $db->prepare($input_outstanding_drug);

    // Mulai Input
    ///var_dump(array(
    $db->beginTransaction();
    $query_input_outstanding_drug->execute(array(
    ':TRXA_JRNL_CODE' =>$jrnlcode_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_account_receivable, ':TRXA_COAC_NAME' =>$name_account_receivable,                  
    ':TRXA_JRNL_DEBT' =>$paymdisc, ':TRXA_JRNL_CRDT' =>$drug_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_obat,
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_payment, ':TRXA_COAC_NAME' =>$name_payment,                  
    ':TRXA_JRNL_DEBT' =>$paymamnt, ':TRXA_JRNL_CRDT' =>$drug_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_obat,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();
    }

    // Input PPN Keluaran
    $dpp_drug_amnt = ($paymamnt * (100/110)); 
    $vat_out = $dpp_drug_amnt * (10/100);
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_vat_out, ':TRXA_COAC_NAME' =>$name_vat_out,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$vat_out,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_obat,
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_sale_drugs, ':TRXA_COAC_NAME' =>$name_sale_drugs,                  
    ':TRXA_JRNL_DEBT' =>$vat_out_null, ':TRXA_JRNL_CRDT' =>$dpp_drug_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_obat,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit();

    // Start Generate Kode Transaksi Jurnal Pemakaian Obat  
    $sqllast_pemakaian_obat = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                 ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
    $qcode_obat = $db->query($sqllast_pemakaian_obat) or die("Gagal Ambil Kode Transaksi terakhir!!");
    $rcode_obat = $qcode_obat->fetch(PDO::FETCH_ASSOC);

    $jrnlcode_get_obat = $rcode_obat['TRXA_JRNL_CODE'] = isset($rcode_obat['TRXA_JRNL_CODE']) ? $rcode_obat['TRXA_JRNL_CODE'] : '';
    // ambil 4 huruf dari kanan
    $xcode = substr($jrnlcode_get_obat, -4);
    $int = (int)$xcode;
    $int++;

    $jrnlcode_get_obat = "TA-" . sprintf("%'.04d\n", $int);


    // Ambil Nilai HNA Obat
    $query_hna = "SELECT SUM(ITEM_STOCK_PRIC * ITEM_STOCK_QUTY) AS TOTA_DRUG 
                  FROM itemdrug WHERE ITEM_DRUG_CODE = '$drugcode' AND ITEM_VIEW_STAT='Y'";

    $qhna = $db->query($query_hna) or die("Gagal Ambil data Obat");
    $rhna = $qhna->fetch(PDO::FETCH_ASSOC);

    $hna_amnt = ($rhna['TOTA_DRUG']/$profit);

   // Note Transaksi
    $jrnlnote_hna = 'Pemakaian Penjualan Obat Faktur - '.$drugcode.''; 


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
    ':TRXA_JRNL_CODE' =>$jrnlcode_get_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_usage_cost, ':TRXA_COAC_NAME' =>$name_usage_cost,                  
    ':TRXA_JRNL_DEBT' =>$hna_amnt, ':TRXA_JRNL_CRDT' =>$drug_null,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_hna,
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
    ':TRXA_JRNL_CODE' =>$jrnlcode_get_obat,':TRXA_JRNL_DATE' =>$jrnldate,  
    ':TRXA_COAC_CODE' =>$code_inventory_drugs, ':TRXA_COAC_NAME' =>$name_inventory_drugs,                  
    ':TRXA_JRNL_DEBT' =>$drug_null, ':TRXA_JRNL_CRDT' =>$hna_amnt,  
    ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$jrnlnote_hna,
    ':TRXA_JRNL_STAT' =>$jrnlstat,
    ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
    ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
    ///print_r($db->error_Info());
    ///var_dump($query_input);
    ///exit();
    $db->commit(); 


        header("location: TRXADRUG02.php");
    
    }
}
else
{
 header("Location: "."index.php");
}
?>