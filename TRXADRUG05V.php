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
  <th style="width: 50px; text-align: center;">No.</th>  
  <th style="width: 300px; text-align: center;">Nama Obat</th>
  <th style="width: 100px; text-align: center;">Jumlah</th>
  <th style="width: 200px; text-align: center;">Total HNA</th> 
  </tr>
  </thead>
  <tbody>

<?php
$no=0;
if ($startdate == $enddate)
{
$query1 = "SELECT DISTINCT(TRXA_STOCK_CODE) AS STOCK_CODE, 
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = UNIT_CODE) AS UNIT_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
          (SELECT SUM(TRXA_STOCK_QUTY) FROM trxaprsc 
                                       WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                       AND TRXA_PRSC_STAT = 'P' 
                                       AND TRXA_VIEW_STAT = 'Y' 
                                       AND TRXA_ENTR_DATE = '$startdate') AS STOCK_QUTY,
          (SELECT SUM(TRXA_STOCK_QUTY * TRXA_STOCK_PRIC) FROM trxaprsc 
                                                         WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                                         AND TRXA_PRSC_STAT = 'P' 
                                                         AND TRXA_VIEW_STAT = 'Y' 
                                                         AND TRXA_ENTR_DATE = '$startdate') AS TOTAL_SALE
          FROM trxaprsc WHERE TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT = 'Y' 
          AND TRXA_ENTR_DATE = '$startdate'
          ORDER BY STOCK_QUTY DESC";

}
else
{
$query1 = "SELECT DISTINCT(TRXA_STOCK_CODE) AS STOCK_CODE, 
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = UNIT_CODE) AS UNIT_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
          (SELECT SUM(TRXA_STOCK_QUTY) FROM trxaprsc 
                                       WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                       AND TRXA_PRSC_STAT = 'P' 
                                       AND TRXA_VIEW_STAT = 'Y' 
                                       AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate') AS STOCK_QUTY,
          (SELECT SUM(TRXA_STOCK_QUTY * TRXA_STOCK_PRIC) FROM trxaprsc 
                                                         WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                                         AND TRXA_PRSC_STAT = 'P' 
                                                         AND TRXA_VIEW_STAT = 'Y' 
                                                         AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate') AS TOTAL_SALE
          FROM trxaprsc WHERE TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT = 'Y' 
          AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'
          ORDER BY STOCK_QUTY DESC";

}

$q1 = $db->query($query1) or die("Gagal Ambil Pemakaian Obat!!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
    $no++;

    $stockcode = $k1['STOCK_CODE'];
    $stockname = $k1['STOCK_NAME'];
    $nameunit = $k1['UNIT_NAME'];
    $namespec = $k1['SPEC_NAME'];
    $quantity = $k1['STOCK_QUTY'];
    $price = $k1['TOTAL_SALE'];

    echo '<td style="width: 50px">'.$no.'</td>';
    echo '<td style="width: 300px">'.$stockname.' '.$namespec.'</td>';
    echo '<td style="width: 100px; text-align: right;">'.$quantity.' '.$nameunit.'</td>';

    $view_price = number_format($price, 0, '', '.');
    echo '<td style="width: 200px; text-align: right;">Rp. '.$view_price.'</td>';

    echo '</tr>';
}  

// Total Tunai
if ($startdate == $enddate)
{
$query_total = "SELECT SUM(TOTAL_SALE) AS TOTAL_PRICE FROM (SELECT DISTINCT(TRXA_STOCK_CODE) AS STOCK_CODE, 
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = UNIT_CODE) AS UNIT_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
          (SELECT SUM(TRXA_STOCK_QUTY) FROM trxaprsc 
                                       WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                       AND TRXA_PRSC_STAT = 'P' 
                                       AND TRXA_VIEW_STAT = 'Y' 
                                       AND TRXA_ENTR_DATE = '$startdate') AS STOCK_QUTY,
          (SELECT SUM(TRXA_STOCK_QUTY * TRXA_STOCK_PRIC) FROM trxaprsc 
                                                         WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                                         AND TRXA_PRSC_STAT = 'P' 
                                                         AND TRXA_VIEW_STAT = 'Y' 
                                                         AND TRXA_ENTR_DATE = '$startdate') AS TOTAL_SALE
          FROM trxaprsc WHERE TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT = 'Y' 
          AND TRXA_ENTR_DATE = '$startdate'
          ORDER BY STOCK_QUTY DESC) AS TABLE_SALE";  

}
else
{
$query_total = "SELECT SUM(TOTAL_SALE) AS TOTAL_PRICE FROM (SELECT DISTINCT(TRXA_STOCK_CODE) AS STOCK_CODE, 
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = UNIT_CODE) AS UNIT_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
          (SELECT SUM(TRXA_STOCK_QUTY) FROM trxaprsc 
                                       WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                       AND TRXA_PRSC_STAT = 'P' 
                                       AND TRXA_VIEW_STAT = 'Y' 
                                       AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate') AS STOCK_QUTY,
          (SELECT SUM(TRXA_STOCK_QUTY * TRXA_STOCK_PRIC) FROM trxaprsc 
                                                         WHERE TRXA_STOCK_CODE = STOCK_CODE 
                                                         AND TRXA_PRSC_STAT = 'P' 
                                                         AND TRXA_VIEW_STAT = 'Y' 
                                                         AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate') AS TOTAL_SALE
          FROM trxaprsc WHERE TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT = 'Y' 
          AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'
          ORDER BY STOCK_QUTY DESC) AS TABLE_SALE";  
}

$q_total = $db->query($query_total) or die("Gagal ambil Total Tunai");
$r_total = $q_total->fetch(PDO::FETCH_ASSOC);
$total = $r_total['TOTAL_PRICE'];

$view_total = number_format($total, 0, '', '.');
?>
  <tr class='pure-table-odd'>
  <td colspan= "2" style="width: 350px; text-align: right;">Total Pemakaian</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $view_total; ?></td>
  <td colspan= "5" style="width: 150px; text-align: right;"></td>
  </tr>


  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


