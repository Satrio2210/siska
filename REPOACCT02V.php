<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>
  <H2 style="color: #339cff"; class="content-subhead">Trial Balance</H2>
  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Code</th>
  <th style="width: 300px; text-align: center;">Account Name</th>
  <th style="width: 100px; text-align: center;">Debet</th>
  <th style="width: 100px; text-align: center;">Kredit</th>
  </tr>
  </thead>
  <tbody>

<?php
$no=0;
$fulldate = $_POST['q'];
//$fulltext = '2020-01-01|2020-07-31';
list($startdate, $enddate) = explode("|",$fulldate);
$saldodebet = 0;
$saldokredit = 0;
               
$xxxquery1 = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_VIEW_STAT='Y'
          ORDER BY COAC_MAST_CODE";

$query1 = "SELECT DISTINCT(TRXA_COAC_CODE) AS MAST_CODE, TRXA_COAC_NAME AS MAST_NAME, 
          (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = TRXA_COAC_CODE) AS NORM_BLNC 
          FROM trxajrnl
          WHERE TRXA_JRNL_STAT = 'Y'
          ORDER BY TRXA_COAC_CODE";
            
$q1 = $db->query($query1) or die("Gagal Ambil Kode Akun ");
while ($data1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
  $no++;
  if ($no % 2 == 0)
  { 
  echo '<tr class="pure-table-odd">'; 
  }
  else 
  {
  echo '<tr>'; 
  }
  $coaccode = $data1['MAST_CODE'];
  echo '<td style="width: 100px">'.$coaccode.'</td>';
  //$coacname = $data1['COAC_MAST_NAME'];
  $coacname = $data1['MAST_NAME'];
  echo '<td style="width: 300px">'.$coacname.'</td>';
  //$normblnc = $data1['COAC_NORM_BLNC'];
  $normblnc = $data1['NORM_BLNC'];

  // Ambil Nilai Saldo 
  $query2 = "SELECT CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS SALDO
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE = '$coaccode'";
  $q2 = $db->query($query2) or die("Gagal Ambil Saldo Debet, Kredit ");
  $data2 = $q2->fetch(PDO::FETCH_ASSOC);
  if ($normblnc == 'DB')
  {
    $saldodebet = $saldodebet+$data2['SALDO'];
    $balance = number_format($data2['SALDO'], 0, '', '.');
    echo '<td style="width: 100px;text-align: right;">'.$balance.'</td>';
    echo '<td style="width: 100px;text-align: right;"> </td>';  
  }
  else
  {
    $saldokredit = $saldokredit+$data2['SALDO'];
    $balance = number_format($data2['SALDO'], 0, '', '.');
    echo '<td style="width: 150px;text-align: right;"> </td>';
    echo '<td style="width: 150px;text-align: right;">'.$balance.'</td>';      
  }
  echo '</tr>';
}
// Ambil Total Saldo
echo '<tr class=pure-table-odd>';
echo '<td style="width: 100px"> </td>';
echo '<td style="width: 200px"> </td>';
$sumdebt = number_format($saldodebet, 0, '', '.');
echo '<td style="width: 150px; text-align: right;"><b>'.$sumdebt.'</b></td>';
$sumcrdt = number_format($saldokredit, 0, '', '.');
echo '<td style="width: 150px; text-align: right;"><b>'.$sumcrdt.'</b></td>';
echo '</tr>';
?>
  </tbody>
  </table>

<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>

