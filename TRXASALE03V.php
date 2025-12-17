<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>
  <table class="pure-table pure-table-bordered">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Tanggal</th>  
  <th style="width: 50px; text-align: center;">Ref</th>
  <th style="width: 200px; text-align: center;">Keterangan</th>
  <th style="width: 100px; text-align: center;">Qty</th> 
  <th style="width: 100px; text-align: center;">Cash</th>
  <th style="width: 100px; text-align: right;">Non Cash</th>
  <th style="width: 100px; text-align: right;">Saldo</th>
  </tr>
  </thead>
  <tbody>

<?php

$querytanggal = "SELECT DISTINCT(ENTR_DATE) AS TANGGAL FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate' 
         ";

$qtanggal = $db->query($querytanggal) or die("Gagal Ambil List Tanggal!!");
while ($rowtanggal = $qtanggal->fetch(PDO::FETCH_ASSOC))
{ 
  
  // Line 1
  echo '<tr>';
  $tanggal = $rowtanggal['TANGGAL'];
  $view_tanggal = formatTanggalBulan($tanggal);
  echo '<td style="width: 100px">'.$view_tanggal.'</td>';
  echo '<td style="width: 50px"> </td>';
  echo '<td style="width: 200px">PEMASUKAN KLINIK</td>';
  echo '<td style="width: 100px"> </td>';
  // Cash
  $queryklinikcash = "SELECT SUM(REVENUE) AS CASH_KLINIK FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'TUN'";

  $qklinikcash = $db->query($queryklinikcash) or die("Gagal Ambil Jumlah Kas Klinik!!");
  $rowklinikcash = $qklinikcash->fetch(PDO::FETCH_ASSOC);

  $view_cash_klinik = number_format($rowklinikcash['CASH_KLINIK'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_cash_klinik.'</td>';
  // Non Tunai
  $querykliniknoncash = "SELECT SUM(REVENUE) AS NON_CASH_KLINIK FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD IN ('BCA','MAN','BNI','BCM','LIN')";

  $qkliniknoncash = $db->query($querykliniknoncash) or die("Gagal Ambil Jumlah Non Kas Klinik!!");
  $rowkliniknoncash = $qkliniknoncash->fetch(PDO::FETCH_ASSOC);

  $view_noncash_klinik = number_format($rowkliniknoncash['NON_CASH_KLINIK'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_noncash_klinik.'</td>';
  // Saldo
  $querykliniktotal = "SELECT SUM(REVENUE) AS TOTAL_KLINIK FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD IN ('TUN','BCA','MAN','BNI','BCM','LIN')";

  $qkliniktotal = $db->query($querykliniktotal) or die("Gagal Ambil Jumlah Total Klinik!!");
  $rowkliniktotal = $qkliniktotal->fetch(PDO::FETCH_ASSOC);

  $view_total_klinik = number_format($rowkliniktotal['TOTAL_KLINIK'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_total_klinik.'</td>';

  echo '</tr>';

 // Line 2
  echo '<tr>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px">PEMASUKAN LAB</td>';
  echo '<td style="width: 100px"> </td>';
  // Cash
  $querylabocash = "SELECT SUM(REVENUE) AS CASH_LABO FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM = '$code_lab_room'
         AND PAYMENT_METHOD = 'TUN'";

  $qlabocash = $db->query($querylabocash) or die("Gagal Ambil Jumlah Kas Laborat!!");
  $rowlabocash = $qlabocash->fetch(PDO::FETCH_ASSOC);

  $view_cash_labo = number_format($rowlabocash['CASH_LABO'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_cash_labo.'</td>';
  // Non Tunai
  $querylabononcash = "SELECT SUM(REVENUE) AS NON_CASH_LABO FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM = '$code_lab_room'
         AND PAYMENT_METHOD IN ('BCA','MAN','BNI','BCM','LIN')";

  $qlabononcash = $db->query($querylabononcash) or die("Gagal Ambil Jumlah Non Kas Laborat!!");
  $rowlabononcash = $qlabononcash->fetch(PDO::FETCH_ASSOC);

  $view_non_cash_labo = number_format($rowlabononcash['NON_CASH_LABO'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_non_cash_labo.'</td>';
  // Saldo
  $querylabototal = "SELECT SUM(REVENUE) AS TOTAL_LABO FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM = '$code_lab_room'
         AND PAYMENT_METHOD IN ('TUN','BCA','MAN','BNI','BCM','LIN')";

  $qlabototal = $db->query($querylabototal) or die("Gagal Ambil Jumlah Total Laborat!!");
  $rowlabototal = $qlabototal->fetch(PDO::FETCH_ASSOC);

  $view_total_labo = number_format($rowlabototal['TOTAL_LABO'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_total_labo.'</td>';

  echo '</tr>';

 // Line 3
  echo '<tr>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px">PEMASUKAN ADMIN</td>';
  echo '<td style="width: 100px"> </td>';
  // Cash
  $queryadmincash = "SELECT ((COUNT(*)) * '$fee_admin') AS CASH_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'TUN'";

  $qadmincash = $db->query($queryadmincash) or die("Gagal Ambil Jumlah Kas Admin!!");
  $rowadmincash = $qadmincash->fetch(PDO::FETCH_ASSOC);

  $view_cash_admin = number_format($rowadmincash['CASH_ADMIN'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_cash_admin.'</td>';
  // Non Tunai
  $queryadminnoncash = "SELECT ((COUNT(*)) * '$fee_admin') AS NON_CASH_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD IN ('BCA','MAN','BNI','BCM','LIN')";

  $qadminnoncash = $db->query($queryadminnoncash) or die("Gagal Ambil Jumlah Non Kas Admin!!");
  $rowadminnoncash = $qadminnoncash->fetch(PDO::FETCH_ASSOC);

  $view_non_cash_admin = number_format($rowadminnoncash['NON_CASH_ADMIN'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right;">Rp.'.$view_non_cash_admin.'</td>';

  // Saldo
  $queryadmintotal = "SELECT ((COUNT(*)) * '$fee_admin') AS TOTAL_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE = '$tanggal'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD IN ('TUN','BCA','MAN','BNI','BCM','LIN')";

  $qadmintotal = $db->query($queryadmintotal) or die("Gagal Ambil Jumlah Total Admin!!");
  $rowadmintotal = $qadmintotal->fetch(PDO::FETCH_ASSOC);

  $view_total_admin = number_format($rowadmintotal['TOTAL_ADMIN'], 0, '', '.');
  echo '<td style="width: 100px; text-align: right">Rp.'.$view_total_admin.'</td>';

  echo '</tr>';

}
// Total Tunai
  $queryklinik1 = "SELECT SUM(REVENUE) AS TUNAI FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'TUN'";

  $qklinik1 = $db->query($queryklinik1) or die("Gagal Ambil Jumlah Tunai!!");
  $rowklinik1 = $qklinik1->fetch(PDO::FETCH_ASSOC);

  $raw_klinik1 = $rowklinik1['TUNAI'];

// ambil Admin Tunai
  $queryadmin1 = "SELECT ((COUNT(*)) * '$fee_admin') AS TUNAI_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'TUN'";

  $qadmin1 = $db->query($queryadmin1) or die("Gagal Ambil Jumlah Admin Tunai!!");
  $rowadmin1 = $qadmin1->fetch(PDO::FETCH_ASSOC);

  $raw_admin1 = $rowadmin1['TUNAI_ADMIN'];

  $total_tunai = ($raw_admin1 + $raw_klinik1);

  $view_total_tunai = number_format($total_tunai, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Tunai</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_tunai.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';

// Total Debit BCA
  $queryklinik2 = "SELECT SUM(REVENUE) AS DEBIT_BCA FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'BCA'";

  $qklinik2 = $db->query($queryklinik2) or die("Gagal Ambil Jumlah Debit BCA!!");
  $rowklinik2 = $qklinik2->fetch(PDO::FETCH_ASSOC);

  $raw_klinik2 = $rowklinik2['DEBIT_BCA'];

// ambil Admin Debit BCA
  $queryadmin2 = "SELECT ((COUNT(*)) * '$fee_admin') AS DEBIT_BCA_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'BCA'";

  $qadmin2 = $db->query($queryadmin2) or die("Gagal Ambil Jumlah Admin Debit BCA!!");
  $rowadmin2 = $qadmin2->fetch(PDO::FETCH_ASSOC);

  $raw_admin2 = $rowadmin2['DEBIT_BCA_ADMIN'];

  $total_debit_bca = ($raw_admin2 + $raw_klinik2);

  $view_total_debit_bca = number_format($total_debit_bca, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Debit BCA</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_debit_bca.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';

// Total Debit Mandiri
  $queryklinik3 = "SELECT SUM(REVENUE) AS DEBIT_MANDIRI FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'MAN'";

  $qklinik3 = $db->query($queryklinik3) or die("Gagal Ambil Jumlah Debit Mandiri!!");
  $rowklinik3 = $qklinik3->fetch(PDO::FETCH_ASSOC);

  $raw_klinik3 = $rowklinik3['DEBIT_MANDIRI'];

// ambil Admin Debit Mandiri
  $queryadmin3 = "SELECT ((COUNT(*)) * '$fee_admin') AS DEBIT_MANDIRI_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'MAN'";

  $qadmin3 = $db->query($queryadmin3) or die("Gagal Ambil Jumlah Admin Debit Mandiri!!");
  $rowadmin3 = $qadmin3->fetch(PDO::FETCH_ASSOC);

  $raw_admin3 = $rowadmin3['DEBIT_MANDIRI_ADMIN'];

  $total_debit_mandiri = ($raw_admin3 + $raw_klinik3);

  $view_total_debit_mandiri = number_format($total_debit_mandiri, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Debit Mandiri</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_debit_mandiri.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';

// Total Debit BNI
  $queryklinik4 = "SELECT SUM(REVENUE) AS DEBIT_BNI FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'BNI'";

  $qklinik4 = $db->query($queryklinik4) or die("Gagal Ambil Jumlah Debit BNI!!");
  $rowklinik4 = $qklinik4->fetch(PDO::FETCH_ASSOC);

  $raw_klinik4 = $rowklinik4['DEBIT_BNI'];

// ambil Admin Debit BNI
  $queryadmin4 = "SELECT ((COUNT(*)) * '$fee_admin') AS DEBIT_BNI_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'BNI'";

  $qadmin4 = $db->query($queryadmin4) or die("Gagal Ambil Jumlah Admin Debit BNI!!");
  $rowadmin4 = $qadmin4->fetch(PDO::FETCH_ASSOC);

  $raw_admin4 = $rowadmin4['DEBIT_BNI_ADMIN'];

  $total_debit_bni = ($raw_admin4 + $raw_klinik4);

  $view_total_debit_bni = number_format($total_debit_bni, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Debit BNI</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_debit_bni.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';

// Total Transfer BCA
  $queryklinik5 = "SELECT SUM(REVENUE) AS TRANS_BCA FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'BCM'";

  $qklinik5 = $db->query($queryklinik5) or die("Gagal Ambil Jumlah Transfer BCA!!");
  $rowklinik5 = $qklinik5->fetch(PDO::FETCH_ASSOC);

  $raw_klinik5 = $rowklinik5['TRANS_BCA'];

// ambil Admin Transfer BCA
  $queryadmin5 = "SELECT ((COUNT(*)) * '$fee_admin') AS TRANS_BCA_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'BCM'";

  $qadmin5 = $db->query($queryadmin5) or die("Gagal Ambil Jumlah Admin Transfer BCA!!");
  $rowadmin5 = $qadmin5->fetch(PDO::FETCH_ASSOC);

  $raw_admin5 = $rowadmin5['TRANS_BCA_ADMIN'];

  $total_trans_bca = ($raw_admin5 + $raw_klinik5);

  $view_total_trans_bca = number_format($total_trans_bca, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Transfer BCA</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_trans_bca.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';


// Total Transfer Link Aja
  $queryklinik6 = "SELECT SUM(REVENUE) AS LINK_AJA FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD = 'LIN'";

  $qklinik6 = $db->query($queryklinik6) or die("Gagal Ambil Jumlah Link Aja!!");
  $rowklinik6 = $qklinik6->fetch(PDO::FETCH_ASSOC);

  $raw_klinik6 = $rowklinik6['LINK_AJA'];

// ambil Admin Transfer Link Aja
  $queryadmin6 = "SELECT ((COUNT(*)) * '$fee_admin') AS LINK_AJA_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD = 'LIN'";

  $qadmin6 = $db->query($queryadmin6) or die("Gagal Ambil Jumlah Admin Transfer Link Aja!!");
  $rowadmin6 = $qadmin6->fetch(PDO::FETCH_ASSOC);

  $raw_admin6 = $rowadmin6['LINK_AJA_ADMIN'];

  $total_trans_link_aja = ($raw_admin6 + $raw_klinik6);

  $view_total_trans_link_aja = number_format($total_trans_link_aja, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">LINK_AJA</td>';
  echo '<td style="text-align: right;">Rp. '.$view_total_trans_link_aja.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';


// Total 
  $queryklinik7 = "SELECT SUM(REVENUE) AS TOTAL FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND PAYMENT_METHOD IS NOT NULL";

  $qklinik7 = $db->query($queryklinik7) or die("Gagal Ambil Jumlah Link Aja!!");
  $rowklinik7 = $qklinik7->fetch(PDO::FETCH_ASSOC);

  $raw_klinik7 = $rowklinik7['TOTAL'];

// ambil Admin Total
  $queryadmin7 = "SELECT ((COUNT(*)) * '$fee_admin') AS TOTAL_ADMIN FROM (SELECT TRXA_TRET_CODE AS TRET_CODE, 
          TRXA_MEDI_CODE AS MEDI_CODE, 
         (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME,
         TRXA_MEDI_RATE AS MEDI_RATE, 
         TRXA_TRET_QUTY AS TRET_QUTY, 
         TRXA_MEDI_ROOM AS MEDI_ROOM, 
         (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS REVENUE,
         (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = TRET_CODE LIMIT 1) AS PAYMENT_METHOD,
         TRXA_ENTR_DATE AS ENTR_DATE 
         FROM trxatret 
         WHERE TRXA_TRET_STAT = 'P' AND TRXA_VIEW_STAT = 'Y') AS REVENUE_CASHIER
         WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
         AND MEDI_ROOM <> '$code_lab_room'
         AND PAYMENT_METHOD IS NOT NULL";

  $qadmin7 = $db->query($queryadmin7) or die("Gagal Ambil Jumlah Admin Total!!");
  $rowadmin7 = $qadmin7->fetch(PDO::FETCH_ASSOC);

  $raw_admin7 = $rowadmin7['TOTAL_ADMIN'];

  $total = ($raw_admin7 + $raw_klinik7);

  $view_total = number_format($total, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "2" style="text-align: right;">Total</td>';
  echo '<td  style="text-align: right;">Rp. '.$view_total.'</td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '<td></td>';
  echo '</tr>';

?>


  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


