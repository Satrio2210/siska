<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
?>

  <table class="pure-table pure-table-horizontal">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Ref</th>
  <th style="width: 100px; text-align: center;">Tanggal</th>
  <th style="width: 200px; text-align: center;">Keterangan</th> 
  <th style="width: 150px; text-align: center;">Departemen</th>
  <th style="width: 100px; text-align: right;">Debet</th>
  <th style="width: 100px; text-align: right;">Kredit</th>
  <th style="width: 100px; text-align: right;">Saldo</th>
  </tr>
  </thead>
  <tbody>

<?php
if ($startdate == $enddate)
{
$query1 = "SELECT DISTINCT(TRXA_JRNL_CODE) AS JRNL_CODE, TRXA_JRNL_DATE 
from trxajrnl WHERE TRXA_JRNL_DATE IS NOT NULL
AND TRXA_JRNL_STAT = 'Y' AND TRXA_JRNL_DATE = '$startdate'
Order By TRXA_JRNL_DATE";

 
}
else
{
$query1 = "SELECT DISTINCT(TRXA_JRNL_CODE) AS JRNL_CODE, TRXA_JRNL_DATE 
from trxajrnl WHERE TRXA_JRNL_DATE IS NOT NULL
AND TRXA_JRNL_STAT = 'Y' AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
Order By TRXA_JRNL_DATE";


}


$q1 = $db->query($query1) or die("Gagal Ambil Kode Transaksi!!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr class=pure-table-odd>';
  $jrnlcode = $k1['JRNL_CODE'];
  echo '<td style="width: 100px">'.$jrnlcode.'</td>';

  $query2 = "SELECT DATE_FORMAT(TRXA_JRNL_DATE,'%d/%m/%Y') AS JRNL_DATE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE 
             FROM trxajrnl
             WHERE TRXA_JRNL_CODE='$jrnlcode' 
             AND TRXA_JRNL_STAT = 'Y' AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
             ORDER BY TRXA_ENTR_TIME
             LIMIT 1";
  $q2 = $db->query($query2) or die("Gagal Ambil Keterangan!!");
  while ($k2 = $q2->fetch(PDO::FETCH_ASSOC))
  {
    echo '<td style="width: 100px">'.$k2['JRNL_DATE'].'</td>';
    echo '<td style="width: 200px">'.$k2['TRXA_JRNL_NOTE'].'</td>';
    echo '<td style="width: 150px">'.$k2['TRXA_DIVI_NAME'].'</td>';
    echo '<td style="width: 100px"> </td>';
    echo '<td style="width: 100px"> </td>';
    echo '<td style="width: 100px"> </td>';
    echo '</tr>';

    $varquery = "SET @CSUM := 0"; 
    $qvar = $db->query($varquery) or die("Gagal Set Variable");
    $var = $qvar->fetch(PDO::FETCH_ASSOC);

    $query3 = "SELECT TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,
              (@CSUM := @CSUM + TRXA_JRNL_DEBT) AS RUNN_DEBT,
              (@CSUM := @CSUM - TRXA_JRNL_CRDT) AS RUNN_CSUM 
              from trxajrnl
              WHERE TRXA_JRNL_CODE='$jrnlcode' AND TRXA_JRNL_STAT = 'Y'
              ORDER BY TRXA_JRNL_DEBT DESC";
    $q3 = $db->query($query3) or die("Gagal Ambil Debet Kredit!!");
    while ($k3 = $q3->fetch(PDO::FETCH_ASSOC))
    {
      echo '<tr>';
      echo '<td style="width: 100px"> </td>';
      echo '<td style="width: 100px">'.$k3['TRXA_COAC_CODE'].'</td>';
      echo '<td colspan=2 style="width: 350px">'.$k3['TRXA_COAC_NAME'].'</td>';
      $jrnldebt = number_format($k3['TRXA_JRNL_DEBT'], 0, '', '.');
      echo '<td style="width: 100px; text-align: right;">'.$jrnldebt.'</td>';
      $jrnlcrdt = number_format($k3['TRXA_JRNL_CRDT'], 0, '', '.');
      echo '<td style="width: 100px; text-align: right;">'.$jrnlcrdt.'</td>';
      $runncsum = number_format($k3['RUNN_CSUM'], 0, '', '.');
      if ($k3['RUNN_CSUM'] < 0)
      {
      echo '<td style="background-color:#FF0000; width: 100px; text-align: right;">'.$runncsum.'</td>';  
      }
      else
      {
      echo '<td style="width: 100px; text-align: right;">'.$runncsum.'</td>';  
      }
      
      echo '</tr>';
    }
  }
 echo '</tr>'; 
}  

?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


