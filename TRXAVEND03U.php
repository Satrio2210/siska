<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtvendcode']) && ($_POST['txtvendcode'] != ''))
    {
        $vendcode = $_POST['txtvendcode'];

        // ambil kode PO
        $query_proccode = "SELECT TRXA_PROC_CODE FROM trxavend WHERE TRXA_VEND_CODE='$vendcode'";
        $q_proccode = $db->query($query_proccode) or die("Gagal Ambil Data Procurement ");
        $k = $q_proccode->fetch(PDO::FETCH_ASSOC);

        $get_proccode = $k['TRXA_PROC_CODE'];

        // periksa pembayaran
        $periksa_outstanding = "SELECT COUNT(*) FROM itemvend 
        WHERE ITEM_VEND_CODE = '$vendcode'";

        $periksa_outstanding_diquery = $db->query($periksa_outstanding) or die("Gagal periksa_outstanding");
        $ketersediaan = $periksa_outstanding_diquery->fetchColumn();


        if ($ketersediaan == 0)
        {
            header("location: TRXAVEND03.php");
        }
        else
        {

            $periksa_payment = "SELECT TRXA_VEND_CODE, TRXA_REMA_PAID, 
            (SELECT SUM(ITEM_PAYM_AMNT) FROM itemvend WHERE ITEM_VEND_CODE = TRXA_VEND_CODE) AS PAYMENT  
            FROM trxavend WHERE TRXA_PROC_CODE = '$get_proccode'";

            $periksa_payment_diquery = $db->query($periksa_payment) or die("Gagal Ambil Data Pembayaran ");
            $ketersediaan_payment = $periksa_payment_diquery->fetch(PDO::FETCH_ASSOC);

            $jumlah_outstanding = $ketersediaan_payment['TRXA_REMA_PAID'];
            $jumlah_payment = $ketersediaan_payment['PAYMENT'];

            if ($jumlah_outstanding > $jumlah_payment)
            {
                header("location: TRXAVEND03.php");
            }
            else
            {
                // tabel invoice
                $update_invoice = "UPDATE trxainvc SET TRXA_INVC_STAT='P' 
                                   WHERE TRXA_PROC_CODE='$get_proccode'";

                $query_update_invoice = $db->prepare($update_invoice);

                $db->beginTransaction();
                $query_update_invoice->execute();
                $db->commit();

                //  tabel payment
                $update_payment = "UPDATE trxavend SET TRXA_VEND_STAT='X' 
                                    WHERE TRXA_PROC_CODE='$get_proccode'";

                $query_update_payment = $db->prepare($update_payment);

                $db->beginTransaction();
                $query_update_payment->execute();
                $db->commit();

                // tabel stock
                $update_stock = "UPDATE investock SET INVE_VIEW_STAT='Y' 
                                 WHERE INVE_PROC_CODE='$get_proccode'";

                $query_update_stock = $db->prepare($update_stock);

                $db->beginTransaction();
                $query_update_stock->execute();
                $db->commit();

                // tabel order
                $update_order = "UPDATE trxaproc SET TRXA_PROC_STAT='OK' 
                                  WHERE TRXA_PROC_CODE='$get_proccode'";

                $query_update_order = $db->prepare($update_order);

                $db->beginTransaction();
                $query_update_order->execute();
                $db->commit();

                header("location: TRXAVEND03.php");

            }



        }

    
    }
}
//else
//{
//  header("Location: "."index.php");
//}
?>