<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
#screen {
    font-family: Arial, Helvetica, sans-serif;
    font-size:11;
    border-collapse: collapse;
    width: 100%;
}


#screen th {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}

#screen td {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center;
}

#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

table tbody, table thead
{
    display: block;
}
table tbody 
{
  overflow: auto;
  height: 400px;
}
</style>
  <table id="screen">
  <thead>
  <tr>

  <th style="width: 100px">Tanggal</th>
  <th style="width: 300px">Nama Item</th>
  <th style="width: 200px">Jumlah</th>
  <th style="width: 150px">Harga Satuan</th>
  <th style="width: 150px">Harga Total</th>
  
  </tr>
  </thead>
  <tbody>
<?php
$kodepo = xss_clean($_POST['q']);

$xquery = "SELECT ITEM_PART_CODE, (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS PART_NAME,
          ITEM_WARE_CODE, ITEM_ARRV_REQU AS RECEIPT_DATE, ITEM_PART_PRIC, ITEM_QUTY_RCVE, ITEM_PART_UNIT, 
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS PART_UNIT,
          (ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS SUB_TOTAL
          FROM itemproc
          WHERE ITEM_PROC_CODE = '$kodepo' AND ITEM_VIEW_STAT='N'
          ORDER BY ITEM_PART_CODE DESC"; 

  $q = $db->query($xquery) or die("Gagal Get Tabel itemproc");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 100px;">'.$k['RECEIPT_DATE'].'</td>';
echo '<td style="width: 300px">'.$k['PART_NAME'].'</td>';
echo '<td style="width: 200px">'.number_format($k['ITEM_QUTY_RCVE'],0,'','.').' '.$k['PART_UNIT'].'</td>';
echo '<td style="width: 150px; text-align: right;">Rp.'.number_format($k['ITEM_PART_PRIC'],0,'','.').'</td>';
echo '<td style="width: 150px; text-align: right;">Rp.'.number_format($k['SUB_TOTAL'],0,'','.').'</td>';

echo '</tr>';
}
?>
  <tr>
    <td colspan=3></td>
    <td style="text-align: left;"><b>Sub Total</b></td>
    <td style="text-align: right;">Rp.
<?php
$querysubtotal = 
"SELECT SUM(ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS SUM_SUB_TOTAL 
FROM itemproc WHERE ITEM_PROC_CODE = '$kodepo' AND ITEM_VIEW_STAT = 'N'";

$qsubtotal = $db->query($querysubtotal) or die("Gagal Get SUM Sub Total");
$st = $qsubtotal->fetch(PDO::FETCH_ASSOC);
$subtotal = $st['SUM_SUB_TOTAL'];
$view_subtotal = number_format($subtotal, 0,'','.');
echo $view_subtotal;

?>
  </tr>

  <tr>
  <td colspan=3></td> 
  <td style="text-align: left;"><b>DPP</b></td>
  <td style="text-align: right;">Rp.
<?php
$querystatusvat = 
"SELECT TRXA_PROC_VATX FROM trxaproc WHERE TRXA_PROC_CODE = '$kodepo'";

$qstatusvat = $db->query($querystatusvat) or die("Gagal Get Status VAT");
$rowstat = $qstatusvat->fetch(PDO::FETCH_ASSOC);
$statusvat = $rowstat['TRXA_PROC_VATX'];

if ($statusvat == 'E') 
  { 
    $taxbase = $subtotal;
    $vat = ((($taxbase)*10)/100); 
  }
else if ($statusvat == 'I') 
  { 
    $taxbase = ($subtotal * (100/110));
    $vat = ((($taxbase)*10)/100); 
  }
else 
  { 
    $taxbase = $subtotal;
    $vat = 0; 
  }

$view_taxbase = number_format($taxbase, 0,'','.');
echo $view_taxbase;


?>
  </td>
  </tr>

  <tr>
  <td colspan=3></td>
  <td style="text-align: left;"><b>PPN</b></td>
  <td style="text-align: right;">Rp.
<?php
$view_vat = number_format($vat, 0,'','.');
echo $view_vat;
?>

    </td>
  </tr>

  <tr>
  <td colspan=3></td>
  <td style="text-align: left;"><b>Uang Muka</b></td>
  <td style="text-align: right;">Rp.
<?php
$querydownpaid = 
"SELECT TRXA_DOWN_PAID FROM trxaproc WHERE TRXA_PROC_CODE = '$kodepo' AND TRXA_PROC_STAT = 'CL'";

$qdownpaid = $db->query($querydownpaid) or die("Gagal Get Down Payment");
$dp = $qdownpaid->fetch(PDO::FETCH_ASSOC);
$downpaid = $dp['TRXA_DOWN_PAID'];
$view_downpaid = number_format($dp['TRXA_DOWN_PAID'],0,'','.');
echo $view_downpaid;
?>
</td>
  </tr>

  <tr>
  <td colspan=3></td> 
  <td style="text-align: left;"><b>Grand Total</b></td>
  <td style="text-align: right;">Rp.
<?php

$grand_total = (($taxbase + $vat)   - $downpaid); 

$view_grand_total = number_format($grand_total, 0,'','.');
echo $view_grand_total;
?>

    </td>
  </tr>


  </tbody>
  </table>


