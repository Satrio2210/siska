<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';
//inregicode,inpaticode,inregidoct,inregipoli,inregipaym,inpaymtota,inpaymamnt,inpaymdisc,inpaymmode

$rawinput = xss_clean($_POST['q']);
list($regicode, $paticode, $regidoct, $regipoli, $regipaym, $xpaymtota, $xpaymamnt, $xpaymdisc, $xpaymmode) = explode("|",$rawinput);
// kode invoice 26112020-00001
$paymtota = str_replace(".","",$xpaymtota);
$paymamnt = str_replace(".","",$xpaymamnt);
$paymdisc = str_replace(".","",$xpaymdisc);

if ($regipaym == 'U') { $paymmode = $xpaymmode; }
else { $paymmode = 'UNP'; }


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
                        TRXA_UPDT_USER='$userid' WHERE TRXA_REGI_STAT='C'
                        AND TRXA_REGI_CODE='$regicode'";

    $query_update_status_pasien = $db->prepare($update_status_pasien);

    $db->beginTransaction();
    $query_update_status_pasien->execute();
    $db->commit();

    //Memindahkan Biaya Admin ke Kwitansi Pembayaran
    $update_charge_admin = "UPDATE trxaregi SET TRXA_REGI_FEE = 'P',
                        TRXA_UPDT_DATE='$dateinput',
                        TRXA_UPDT_TIME='$timeinput',
                        TRXA_UPDT_USER='$userid' WHERE TRXA_REGI_FEE='Y' 
                        AND TRXA_REGI_CODE='$regicode'";

    $query_update_charge_admin = $db->prepare($update_charge_admin);

    $db->beginTransaction();
    $query_update_charge_admin->execute();
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

    //Merubah status item tindakan menjadi sudah di bayar di tabel trxatret
    // Closing item Tindakan menjadi terbayar 
    $query_update_status_tret = "UPDATE trxatret SET TRXA_TRET_STAT = 'P',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
                WHERE TRXA_TRET_CODE='$regicode'
                AND TRXA_VIEW_STAT='Y'";

    // Prepare Request  
    $q_update_status_tret = $db->prepare($query_update_status_tret);

    // Mulai Update
    $db->beginTransaction();
    $q_update_status_tret->execute();
    $db->commit();




?>      
