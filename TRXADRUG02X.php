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
      $periksatrxacode = "SELECT COUNT(*) FROM trxadrug WHERE TRXA_DRUG_STAT = '$status' AND TRXA_ENTR_USER='$userid'";
      $periksatrxacode_di_query=$db->query($periksatrxacode) or die ("Cek Fail");
      $ketersediaan = $periksatrxacode_di_query->fetchColumn();
      if ($ketersediaan == 0)
      {
        // Start Generate Kode Transaksi Penjualan  
        $sqllast = "SELECT TRXA_DRUG_CODE FROM trxadrug                
                  ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $drugcode = $r['TRXA_DRUG_CODE'] = isset($r['TRXA_DRUG_CODE']) ? $r['TRXA_DRUG_CODE'] : '';
        // 12112021-00001
        // ambil 5 huruf dari kanan
        $xcode = substr($drugcode, -5);
        $int = (int)$xcode;
        $int++;

        $xdrugcode = "-" . sprintf("%'.05d\n", $int);

        //if ($int <= 10)
        //{ $xdrugcode = "-000" . $int; }

        //elseif ($int <= 100)

        //{ $xdrugcode = "-00" . $int; }

        //elseif ($int <= 1000)

        //{ $xdrugcode = "-0" . $int;}

        //elseif ($int <= 10000)

        //{ $xdrugcode = "-" . $int;}


        //else { $xdrugcode = "-0000" . $int;}

        $fullcode = $daynow . '' . $monthnow . '' . $yearnow . '' . $xdrugcode;
        echo "$fullcode";

      // End Generate Kode Transaksi Penjualan         
      }
      else
      {
      // Tampilkan di Tabel View Penjualan Transaksi di bawah Form Input
      $sqllast = "SELECT TRXA_DRUG_CODE FROM trxadrug 
                  WHERE TRXA_DRUG_STAT = '$status' AND TRXA_ENTR_USER='$userid'               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
      $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
      $r = $q->fetch(PDO::FETCH_ASSOC);
      $fullcode = $r['TRXA_DRUG_CODE'];
      echo "$fullcode";
      }
}
?>	
