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

        header("Location: "."TRXADRUG02.php");


// Data Jurnal Resep

    }
    else
    {
    header("Location: "."index.php");
    }
    

}

?>