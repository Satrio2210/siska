<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>
  <H2 style="color: #339cff"; class="content-subhead">Equity</H2>
  <table class="pure-table pure-table-horizontal">
  <thead>
  <tr>
  <th style="width: 300px; text-align: center;">Description</th>
  <th style="width: 100px; text-align: center;">Invest</th>
  <th style="width: 100px; text-align: center;">Prive</th>
  </tr>
  </thead>
  <tbody>

<?php
$fulldate = $_POST['q'];
//$fulltext = '2020-01-01|2020-07-31';
list($startdate, $enddate) = explode("|",$fulldate);
$beforedate = date('Y-m-d', strtotime('-1 days', strtotime($startdate)));
$xgetyear = strtotime($beforedate);
$getyear = date('Y',$xgetyear);
$firstdate=$getyear.'-01-01';  

// Ambil Akun Modal               
$querymodal = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '3.1%'
          AND COAC_VIEW_STAT = 'Y'";
            
$qmod = $db->query($querymodal) or die("Gagal Ambil Akun Modal");
$datamod = $qmod->fetch(PDO::FETCH_ASSOC);
 
echo '<tr>';
$coaccode = $datamod['MAST_CODE'];
$coacname = $datamod['COAC_MAST_NAME'];
echo '<td style="width: 300px">Modal Awal</td>';

// Ambil Nilai Saldo Modal
$querymodal2 = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_MODAL FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '3.%'
              AND TRXA_JRNL_STAT='Y'";
  $qmod2 = $db->query($querymodal2) or die("Gagal Ambil Saldo Modal ");
  $datamod2 = $qmod2->fetch(PDO::FETCH_ASSOC);
  $xsaldomod = $datamod2['SALDO_MODAL'];
  $saldomod = number_format($xsaldomod, 0, '', '.');
  echo '<td style="width: 100px;text-align: right;">'.$saldomod.'</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';  
  echo '</tr>';


// Ambil Saldo Revenue               
$queryrev = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_REVENUE FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '4.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qrev = $db->query($queryrev) or die("Gagal Ambil Saldo Revenue");
$datarev = $qrev->fetch(PDO::FETCH_ASSOC);
$saldorevenue = $datarev['SALDO_REVENUE'];

// Ambil Saldo Expense               
$queryexp = "SELECT SUM(TRXA_JRNL_DEBT-TRXA_JRNL_CRDT) AS SALDO_EXPENSE FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '5.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qexp = $db->query($queryexp) or die("Gagal Ambil Saldo Expense");
$dataexp = $qexp->fetch(PDO::FETCH_ASSOC);
$saldoexpense = $dataexp['SALDO_EXPENSE'];

$xsaldonet = ($saldorevenue - $saldoexpense);
$saldonet = number_format($xsaldonet, 0, '', '.');
echo '<tr>';
echo '<td style="width: 300px">Laba Bersih</td>';
echo '<td style="width: 100px;text-align: right;">'.$saldonet.'</td>';
echo '<td style="width: 100px;text-align: right;"> </td>';  
echo '</tr>';
 
// Ambil Kenaikan Modal Pemilik

echo '<tr>';
echo '<td style="width: 300px;text-align: right">Kenaikan Modal Pemilik</td>';
echo '<td style="width: 100px"> </td>';
$xmodalplusnet = ($xsaldomod + $xsaldonet);
$modalplusnet = number_format($xmodalplusnet, 0, '', '.');
echo '<td style="width: 100px; text-align: right;"><b>'.$modalplusnet.'</b></td>';
echo '</tr>';


// Ambil Modal Sesuadah laba 
echo '<tr>';
echo '<td style="width: 300px">Modal Akhir</td>';
echo '<td style="width: 100px"> </td>';
echo '<td style="width: 100px; text-align: right;"><b>'.$modalplusnet.'</b></td>';
echo '</tr>';

?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


