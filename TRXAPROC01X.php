<?php
include "conf/config.php";
include "inc/sanie.php";

//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

  $status = $_POST['q'];
  $userid = $_SESSION['username'];

    // Periksa apakah ada input transaksi yang belum selesai di posting
      $periksatrxacode = "SELECT COUNT(*) FROM trxaproc WHERE TRXA_PROC_STAT = '$status' AND TRXA_ENTR_USER='$userid'";
      $periksatrxacode_di_query=$db->query($periksatrxacode) or die ("Cek Fail");
      $ketersediaan = $periksatrxacode_di_query->fetchColumn();
      if ($ketersediaan == 0)
      {
        // Start Generate Kode Transaksi Purchasing  
        $sqllast = "SELECT TRXA_PROC_CODE FROM trxaproc                
                  ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $proccode = $r['TRXA_PROC_CODE'] = isset($r['TRXA_PROC_CODE']) ? $r['TRXA_PROC_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($proccode, -4);
        $int = (int)$xcode;
        $int++;

        echo "PO-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xproccode = "PO-00" . $int; echo "$xproccode";}

        //elseif ($int <= 100)

        //{ $xproccode = "PO-0" . $int; echo "$xproccode";}

        //elseif ($int <= 1000)
        //{ $xproccode = $int;  echo "$xproccode";}
        //else { $xproccode = "PO-000" . $int; echo "$xproccode";}
      // End Generate Kode Transaksi Purchasing         
      }
      else
      {
      // Tampilkan di Tabel View Purchasing Transaksi di bawah Form Input
      $sqllast = "SELECT TRXA_PROC_CODE FROM trxaproc 
                  WHERE TRXA_PROC_STAT = '$status' AND TRXA_ENTR_USER='$userid'               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
      $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
      $r = $q->fetch(PDO::FETCH_ASSOC);
      $xproccode = $r['TRXA_PROC_CODE'];
      echo "$xproccode";
      }
}
?>	
