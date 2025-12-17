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
  <th style="width: 100px; text-align: center;">Debet</th> 
  <th style="width: 100px; text-align: center;">Credit</th>
  </tr>
  </thead>
  <tbody>

<?php

$querytanggal = "SELECT DISTINCT(TRXA_PAYM_DATE) AS TANGGAL, TRXA_PAYM_CODE AS REF, TRXA_PAYM_NOTE AS NOTE FROM trxapaym WHERE TRXA_VIEW_STAT = 'Y'
                 AND TRXA_PAYM_DATE BETWEEN '$startdate' AND '$enddate'";

$qtanggal = $db->query($querytanggal) or die("Gagal Ambil List Tanggal!!");
while ($rowtanggal = $qtanggal->fetch(PDO::FETCH_ASSOC))
{ 
  
  // Line 1
  echo '<tr>';
  $tanggal = $rowtanggal['TANGGAL'];
  $view_tanggal = formatTanggalBulan($tanggal);
  echo '<td style="width: 100px">'.$view_tanggal.'</td>';
  $ref = $rowtanggal['REF'];
  echo '<td style="width: 50px">'.$ref.'</td>';
  echo '<td style="width: 200px">'.$rowtanggal['NOTE'].'</td>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px"> </td>';
  echo '</tr>';


  // line 2 - line 3
  $querypayment = "SELECT TRXA_COAC_CODE, LEFT(TRXA_COAC_CODE,3) AS CASH_PRNT, RIGHT(TRXA_COAC_CODE,1) AS CASH_CODE,
                  (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = CASH_PRNT AND COAC_MAST_CODE = CASH_CODE) AS COAC_NAME,

                          TRXA_PAYE_CODE, LEFT(TRXA_PAYE_CODE,3) AS COST_PRNT, SUBSTR(TRXA_PAYE_CODE,5,2) AS COST_CODE,
                  (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = COST_PRNT AND COAC_MAST_CODE = COST_CODE) AS PAYE_NAME,
                          TRXA_PAYM_AMNT 
                   FROM trxapaym 
                   WHERE TRXA_VIEW_STAT = 'Y'
                   AND TRXA_PAYM_CODE = '$ref' AND TRXA_PAYM_DATE = '$tanggal'
                   ORDER BY TRXA_COAC_CODE, TRXA_PAYE_CODE";
                   //var_dump($querypayment);
                   //exit();

  $qpayment = $db->query($querypayment) or die("Gagal ambil transaksi");
  while ($rowpayment = $qpayment->fetch(PDO::FETCH_ASSOC))
  {
    echo '<tr>';
    echo '<td style="width: 100px"> </td>';
    echo '<td style="width: 50px"> </td>';
    echo '<td style="width: 200px">'.$rowpayment['COAC_NAME'].'</td>';

    $view_payment = number_format($rowpayment['TRXA_PAYM_AMNT'], 0, '', '.');

    echo '<td style="width: 100px"> </td>';
    echo '<td style="width: 100px; text-align:right;">'.$view_payment.'</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td style="width: 100px"> </td>';
    echo '<td style="width: 50px"> </td>';
    echo '<td style="width: 200px">'.$rowpayment['PAYE_NAME'].'</td>';
    echo '<td style="width: 100px; text-align:right;">'.$view_payment.'</td>';
    echo '<td style="width: 100px"></td>';
    echo '</tr>';

  }                 

}
// Total 
  $querytotal = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL  
                 FROM trxapaym 
                 WHERE TRXA_VIEW_STAT = 'Y'
                 AND TRXA_PAYM_DATE BETWEEN '$startdate' AND '$enddate'";

  $qtotal = $db->query($querytotal) or die("Gagal Ambil Jumlah Total Aja!!");
  $rowtotal = $qtotal->fetch(PDO::FETCH_ASSOC);

  $raw_total = $rowtotal['TOTAL'];

  $view_total = number_format($raw_total, 0, '', '.');

  echo '<tr>';
  echo '<td colspan= "3" style="width: 350px; text-align: right;">Total</td>';
  echo '<td style="width: 100px; text-align: right;">'.$view_total.'</td>';
  echo '<td style="width: 100px; text-align: right;">'.$view_total.'</td>';
  echo '</tr>';
?>


  </tbody>
  </table>

<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


