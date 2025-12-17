<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');

//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include "inc/sanie.php";
$userid = $_SESSION['username'];
$status = $_POST['q'];
//$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
//$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);

// Periksa apakah ada input transaksi yang belum selesai di posting
      $periksatrxacode = "SELECT COUNT(*) FROM trxajrnl WHERE TRXA_JRNL_STAT = '$status' AND TRXA_ENTR_USER='$userid'";
      $periksatrxacode_di_query=$db->query($periksatrxacode) or die ("Cek Fail");
      $ketersediaan = $periksatrxacode_di_query->fetchColumn();
      if ($ketersediaan == 0)
      {
        // Start Generate Kode Transaksi Jurnal  
        $sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $jrnlcode = $r['TRXA_JRNL_CODE'] = isset($r['TRXA_JRNL_CODE']) ? $r['TRXA_JRNL_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($jrnlcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "TM-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xjrnlcode = "TM-00" . $int; echo "$xjrnlcode";}

        //elseif ($int <= 100)
        //{ $xjrnlcode = "TM-0" . $int; echo "$xjrnlcode";}

        //elseif ($int <= 1000)
        //{ $xjrnlcode = $int;  echo "$xjrnlcode"; }

        //else { $xjrnlcode = "TM-000" . $int; echo "$xjrnlcode";}
      // End Generate Kode Transaksi Jurnal         
      }
      else
      {
      // Tampilkan di Tabel View Jurnal Transaksi di bawah Form Input
      $sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl 
                  WHERE TRXA_JRNL_STAT = '$status' AND TRXA_ENTR_USER='$userid'               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
              LIMIT 1";
      $q = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
      $r = $q->fetch(PDO::FETCH_ASSOC);
      $xjrnlcode = $r['TRXA_JRNL_CODE'];
      echo "$xjrnlcode";
      }
  }
?>	
