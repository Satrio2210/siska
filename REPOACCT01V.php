<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
$beforedate = date('Y-m-d', strtotime('-1 days', strtotime($startdate)));
$xgetyear = strtotime($beforedate);
$getyear = date('Y',$xgetyear);
$firstdate=$getyear.'-01-01';  

$query1 = "SELECT DISTINCT(TRXA_COAC_CODE) AS COAC_CODE, TRXA_COAC_NAME, 
          (SELECT COAC_MAST_STAT FROM coacmast WHERE COAC_MAST_NAME =TRXA_COAC_NAME) AS MAST_STAT
          FROM trxajrnl
          WHERE TRXA_JRNL_STAT = 'Y'
          ORDER BY TRXA_COAC_CODE";


$q1 = $db->query($query1) or die("Gagal Ambil Kode Akun!!");
while ($data1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
  $coaccode = $data1['COAC_CODE'];
  $coacname = $data1['TRXA_COAC_NAME'];
  $maststat = $data1['MAST_STAT'];
?>
  <H2 style="color: #339cff"; class="content-subhead"><?php echo $coaccode . ' ' . $coacname;?></H2>
  <table class="pure-table pure-table-horizontal">
  <thead>
  <tr>
    <th style="width: 100px; text-align: center;">Tanggal</th>
    <th style="width: 100px; text-align: center;">No. Ref</th>
    <th style="width: 200px; text-align: center;">Keterangan</th> 
    <th style="width: 150px; text-align: center;">Departemen</th>
    <th style="width: 100px; text-align: right;">Debet</th>
    <th style="width: 100px; text-align: right;">Kredit</th>  
  </tr>
  </thead>
<?php  
if ($maststat == 'C')
{
$querysaldoawal = "SELECT SUM(TRXA_JRNL_DEBT) AS JRNL_DEBT, SUM(TRXA_JRNL_CRDT) AS JRNL_CRDT,
              CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS SALDO
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$beforedate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE = '$coaccode'";
}
else
{
$querysaldoawal = "SELECT SUM(TRXA_JRNL_DEBT) AS JRNL_DEBT, SUM(TRXA_JRNL_CRDT) AS JRNL_CRDT,
              CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS SALDO
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$beforedate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE LIKE '$coaccode%'";  
}


$qsaldoawal = $db->query($querysaldoawal) or die("Gagal Ambil Saldo Awal");
$datasaldo = $qsaldoawal->fetch(PDO::FETCH_ASSOC);
$xsaldodebet = $datasaldo['JRNL_DEBT'];
$saldodebet = number_format($xsaldodebet, 0, '', '.');
$xsaldokredit = $datasaldo['JRNL_CRDT'];
$saldokredit = number_format($xsaldokredit, 0, '', '.');
$xsaldoawal = $datasaldo['SALDO'];
$saldoawal = number_format($xsaldoawal, 0, '', '.');
?>
<tr class="pure-table-odd">
  <td colspan="4">Saldo Awal :</td>
  <td style="width: 100px; text-align: right;"><?php echo $saldodebet;?></td>
  <td style="width: 100px; text-align: right;"><?php echo $saldokredit;?></td>
</tr>
<?php

 if ($maststat == 'C')
 {
  $query2 = "SELECT DATE_FORMAT(TRXA_JRNL_DATE,'%d/%m/%Y') AS JRNL_DATE, TRXA_JRNL_CODE, TRXA_JRNL_NOTE, TRXA_DIVI_NAME, 
              TRXA_JRNL_DEBT, TRXA_JRNL_CRDT 
            FROM trxajrnl 
            WHERE TRXA_COAC_CODE='$coaccode'
            AND TRXA_JRNL_STAT = 'Y'
            AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
            ORDER BY TRXA_JRNL_DATE";

 }
else
{
  $query2 = "SELECT DATE_FORMAT(TRXA_JRNL_DATE,'%d/%m/%Y') AS JRNL_DATE, TRXA_JRNL_CODE, TRXA_JRNL_NOTE, TRXA_DIVI_NAME, 
              TRXA_JRNL_DEBT, TRXA_JRNL_CRDT 
            FROM trxajrnl 
            WHERE TRXA_COAC_CODE LIKE '$coaccode%'
            AND TRXA_JRNL_STAT = 'Y'
            AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
            ORDER BY TRXA_JRNL_DATE";

}

  $q2 = $db->query($query2) or die("Gagal Ambil Keterangan!!");
  while ($data2 = $q2->fetch(PDO::FETCH_ASSOC))
  {
    echo '<tr>';
    echo '<td style="width: 100px">'.$data2['JRNL_DATE'].'</td>';
    echo '<td style="width: 100px">'.$data2['TRXA_JRNL_CODE'].'</td>';
    echo '<td style="width: 200px">'.$data2['TRXA_JRNL_NOTE'].'</td>';
    echo '<td style="width: 150px">'.$data2['TRXA_DIVI_NAME'].'</td>';
    $jrnldebt = number_format($data2['TRXA_JRNL_DEBT'], 0, '', '.');
    echo '<td style="width: 100px; text-align: right;">'.$jrnldebt.'</td>';
    $jrnlcrdt = number_format($data2['TRXA_JRNL_CRDT'], 0, '', '.');
    echo '<td style="width: 100px; text-align: right;">'.$jrnlcrdt.'</td>';
    echo '</tr>';
  }

if ( $maststat == 'C')
{
  $query3 = "SELECT SUM(TRXA_JRNL_DEBT) AS TOTA_DEBT, SUM(TRXA_JRNL_CRDT) AS TOTA_CRDT,
              CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS MUTASI
              FROM trxajrnl
              WHERE TRXA_COAC_CODE='$coaccode'
              AND TRXA_JRNL_STAT='Y'
              AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'";

}
else
{
  $query3 = "SELECT SUM(TRXA_JRNL_DEBT) AS TOTA_DEBT, SUM(TRXA_JRNL_CRDT) AS TOTA_CRDT,
              CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS MUTASI
              FROM trxajrnl
              WHERE TRXA_COAC_CODE LIKE '$coaccode%'
              AND TRXA_JRNL_STAT='Y'
              AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'";

}
  $q3 = $db->query($query3) or die("Gagal Ambil Total");

  $data3 = $q3->fetch(PDO::FETCH_ASSOC);
  echo '<tr class=pure-table-odd>';
  echo '<td style="width: 100px; text-align: left">Saldo Awal :</td>';
  echo '<td style="width: 100px; text-align: right">'.$saldoawal.'</td>';
  echo '<td style="width: 200px; text-align: left"> </td>';
  echo '<td style="width: 150px; text-align: left">Total :</td>';
  $xtotadebt = $data3['TOTA_DEBT'];
  $totadebt = number_format($xtotadebt, 0, '', '.');  
  echo '<td style="width: 100px; text-align: right">'.$totadebt.'</td>';
  $xtotacrdt = $data3['TOTA_CRDT'];
  $totacrdt = number_format($xtotacrdt, 0, '', '.');  
  echo '<td style="width: 100px; text-align: right">'.$totacrdt.'</td>';
  echo '</tr>';

  echo '<tr class=pure-table-odd>';
  echo '<td style="width: 100px; text-align: left">Saldo Akhir :</td>';
  if ($xsaldoawal <= 0)
  {
    $xsaldoakhir = ($data3['MUTASI'] - 0);
  }
  else
  {
    $xsaldoakhir = $xsaldoawal + $data3['MUTASI'];  
  }
  $saldoakhir = number_format($xsaldoakhir, 0, '', '.');
  echo '<td style="width: 100px; text-align: right">'.$saldoakhir.'</td>';  
  echo '<td style="width: 200px; text-align: left"> </td>';
  echo '<td style="width: 150px; text-align: left">Mutasi :</td>';
  $xmutasi = $data3['MUTASI'];
  $mutasi = number_format($xmutasi, 0, '', '.');
  echo '<td style="width: 100px; text-align: right">'.$mutasi.'</td>';
  echo '<td style="width: 100px; text-align: left"> </td>'; 
  echo '</tr>'; 
  echo '</table>';
   
}  

?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


