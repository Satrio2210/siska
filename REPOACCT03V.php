<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>
  <H2 style="color: #339cff"; class="content-subhead">Profit Loss</H2>
  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 300px; text-align: center;">Description</th>
  <th style="width: 100px; text-align: center;">Expense</th>
  <th style="width: 100px; text-align: center;">Revenue</th>
  </tr>
  </thead>
  <tbody>

<?php
$fulldate = $_POST['q'];
//$fulltext = '2020-01-01|2020-07-31';
list($startdate, $enddate) = explode("|",$fulldate);
$totalrev = 0;
$totalexp = 0;
$totalnet = 0;

// Ambil Akun Revenue               
$queryrev = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '4.%'
          AND COAC_FNRP_STAT = 'PL'
          AND COAC_VIEW_STAT='Y'
          ORDER BY COAC_MAST_CODE";
            
$qrev = $db->query($queryrev) or die("Gagal Ambil Akun Revenue");
while ($datarev = $qrev->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $coaccode = $datarev['MAST_CODE'];
  $coacname = $datarev['COAC_MAST_NAME'];
  echo '<td style="width: 300px">'.$coacname.'</td>';

  // Ambil Nilai Saldo 
  $queryrev2 = "SELECT CASE 
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
  $qrev2 = $db->query($queryrev2) or die("Gagal Ambil Saldo Revenue ");
  $datarev2 = $qrev2->fetch(PDO::FETCH_ASSOC);

  $totalrev = $totalrev+$datarev2['SALDO'];
  $saldorev = number_format($datarev2['SALDO'], 0, '', '.');
  echo '<td style="width: 100px;text-align: right;"> </td>';
  echo '<td style="width: 100px;text-align: right;">'.$saldorev.'</td>';  
  echo '</tr>';
}
  echo "<tr class=pure-table-odd>";
  echo '<td style="width: 300px">Beban beban :</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';
  echo "</tr>";

// Ambil Akun Expense               
$queryexp = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '5.%'
          AND COAC_FNRP_STAT = 'PL'
          AND COAC_VIEW_STAT = 'Y'
          ORDER BY COAC_MAST_CODE";
            
$qexp = $db->query($queryexp) or die("Gagal Ambil Akun Expense");
while ($dataexp = $qexp->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $coaccode = $dataexp['MAST_CODE'];
  $coacname = $dataexp['COAC_MAST_NAME'];
  echo '<td style="width: 300px">'.$coacname.'</td>';

  // Ambil Nilai Saldo 
  $queryexp2 = "SELECT CASE 
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
  $qexp2 = $db->query($queryexp2) or die("Gagal Ambil Saldo Expense ");
  $dataexp2 = $qexp2->fetch(PDO::FETCH_ASSOC);

  $totalexp = $totalexp + $dataexp2['SALDO'];
  $saldoexp = number_format($dataexp2['SALDO'], 0, '', '.');
  echo '<td style="width: 100px;text-align: right;">'.$saldoexp.'</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';  
  echo '</tr>';
}

// Ambil Total Saldo Beban
echo '<tr class=pure-table-odd>';
echo '<td style="width: 300px; text-align: right;">Total Beban</td>';
echo '<td style="width: 100px"> </td>';
$summaryexp = number_format($totalexp, 0, '', '.');
echo '<td style="width: 100px; text-align: right;"><u>('.$summaryexp.')</u></td>';
echo '</tr>';

// Ambil Total Net
echo '<tr>';
echo '<td style="width: 300px">Laba Bersih</td>';
echo '<td style="width: 100px"> </td>';
$totalnet = ($totalrev - $totalexp);
$summarynet = number_format($totalnet, 0, '', '.');
echo '<td style="width: 100px; text-align: right;"><b>'.$summarynet.'</b></td>';
echo '</tr>';

?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


