<?php
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
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px">ID</th>
  <th style="width: 200px">NAME</th>
  <th style="width: 150px">SERIAL</th>
  <th style="width: 150px">BATCH</th>
  <th style="width: 150px">QTY</th>
  <th style="width: 150px">PRICE</th>
  <th style="width: 150px">TOTAL</th>
  
  </tr>
  </thead>
  <tbody>
<?php
$kodepo = xss_clean($_POST['q']);
//$kodepo = 'PO-0002';


$xquery = "SELECT ITEM_PART_CODE, 
(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_PART_CODE) AS PART_NAME, ITEM_WARE_CODE, 
ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS PART_UNIT,
 ITEM_QUTY_RCVE, 
 ITEM_PART_PRIC, 
 ITEM_PROC_BTCH, 
 ITEM_PROC_SRNM, 
 (ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS TOTAL_PRIC 
 FROM itemproc 
 WHERE ITEM_PROC_CODE = '$kodepo' AND ITEM_VIEW_STAT='N' 
 AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = ITEM_WARE_CODE) = 'N' 
 ORDER BY ITEM_PART_CODE DESC ";


  $q = $db->query($xquery) or die("Gagal Get Tabel itemproc");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 100px;">'.$k['ITEM_PART_CODE'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['PART_NAME'].'</td>';
echo '<td style="width: 150px">'.$k['ITEM_PROC_SRNM'].'</td>';
echo '<td style="width: 150px">'.$k['ITEM_PROC_BTCH'].'</td>';

$qutyrcve = $k['ITEM_QUTY_RCVE'];
$view_qutyrcve = number_format($k['ITEM_QUTY_RCVE'], 0, '', '.');
$xpartunit = $k['PART_UNIT'];

// periksa apakah xpartunit mengandung @

$posisi=strpos($xpartunit,"@");

if ($posisi)
{
  list($partunit,$subpartunit) = explode("@",$xpartunit);
}
else 
{
  $partunit = $xpartunit; 
}

echo '<td style="width: 150px">'.$view_qutyrcve.' '.$partunit.'</td>';

$partpric = $k['ITEM_PART_PRIC'];
$view_partpric = number_format($k['ITEM_PART_PRIC'], 0, '', '.');
echo '<td style="width: 150px; text-align: right;">Rp. '.$view_partpric.'</td>';

$totapric = $k['TOTAL_PRIC'];
$view_totapric = number_format($k['TOTAL_PRIC'], 0, '', '.');
echo '<td style="width: 150px; text-align: right;">Rp. '.$view_totapric.'</td>';

echo '</tr>';
}
?>
<?php

$queryGrandTotal = "SELECT (SUM(ITEM_QUTY_RCVE * ITEM_PART_PRIC)) AS SUB_TOTAL 
                    FROM itemproc 
                    WHERE ITEM_PROC_CODE = '$kodepo' 
                    AND ITEM_VIEW_STAT='N'
                    AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = ITEM_WARE_CODE) = 'N'";

$qy = $db->query($queryGrandTotal) or die("Gagal Get SUM Grand Total");
$gt = $qy->fetch(PDO::FETCH_ASSOC);
$subtotal = $gt['SUB_TOTAL'];

$view_grandtotal = number_format($subtotal, 0, '', '.'); 
?>

  <tr>
  <td colspan=5></td>
  <td style="text-align: left;"><b>Grand Total</b></td>
  <td style="text-align: right;"><b>Rp. <?php echo $view_grandtotal; ?></b></td>
  </tr>

  </tbody>
  </table>


