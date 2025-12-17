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
  height: 300px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 50px">NO</th>
  <th style="width: 200px">DESCRIPTION</th>
  <th style="width: 125px">QTY</th>
  <th style="width: 125px">UOM</th>
  <th style="width: 125px">AMOUNT</th>
  <th style="width: 125px">DISC</th>
  <th style="width: 125px">PATIENT</th>
  
  </tr>
  </thead>
  <tbody>
<?php
//$rawinput = xss_clean($_POST['q']);
$salecode = xss_clean($_POST['q']);
//list($salecode,$kodetransaksi) = explode("|",$rawinput);
$no = 0;
$sub_total = 0;

$xxxxquery_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS UNIT_CODE,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,
              (TRXA_STOCK_PRIC * '$profit') AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE
              FROM trxaprsc WHERE TRXA_PRSC_CODE = '$salecode' AND TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT='Y'";

$query_prsc = "SELECT ITEM_DRUG_CODE, ITEM_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS STOCK_NAME, 
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = ITEM_STOCK_CODE) AS SPEC_CODE,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS UNIT_CODE,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,              
              ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, (ITEM_STOCK_PRIC *ITEM_STOCK_QUTY) AS SUB_TOTAL_PRIC
              FROM itemdrug WHERE ITEM_DRUG_CODE = '$salecode' AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'";
 
$qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC))
{ 
$drug_name = $row_prsc['STOCK_NAME'];
$drug_qty = $row_prsc['ITEM_STOCK_QUTY'];
$drug_unit = $row_prsc['UNIT_NAME'];

$xharga = round($row_prsc['SUB_TOTAL_PRIC']);
$int = (int)$xharga;

$drug_amount = pembulatan($int);

//$drug_amount = $row_prsc['SUB_TOTAL_PRIC'];
$view_drug_amount = number_format($drug_amount, 0, '', '.');

$no++;
$sub_total = $sub_total + $drug_amount;


echo '<tr>';
echo '<td style="width: 50px">'.$no.'</td>';
echo '<td style="width: 200px">'.$drug_name.'</td>';
echo '<td style="width: 100px">'.$drug_qty.'</td>';
echo '<td style="width: 100px">'.$drug_unit.'</td>';
echo '<td style="width: 100px">'.$view_drug_amount.'</td>';
echo '<td style="width: 100px">0</td>';
echo '<td style="width: 100px">'.$view_drug_amount.'</td>';
echo '</tr>';
}
?>
	<?php
	/// final summary
    echo '<tr>';
  	echo '<td style="width: 50px"> </td>';
	  echo '<td style="width: 125px; text-align: left;"><b>SUB TOTAL</b></td>';
    echo '<td style="width: 125px; text-align: left;"><b>DISCOUNT</b></td>';
    echo '<td style="width: 125px; text-align: right;"><b>PPN</b></td>';
    echo '<td style="width: 125px; text-align: right;"><b>TOTAL</b></td>';
    echo '<td style="width: 125px; text-align: right;"><b>PAYMENT</b></td>';
    echo '<td style="width: 125px; text-align: right;"><b>BALANCE</b></td>';
    
    echo '</tr>';

    echo '<tr>';
  	echo '<td style="width: 50px"> </td>';

    // SUB TOTAL
    $view_sub_total = number_format($sub_total, 0, '', '.');
	   echo '<td style="width: 125px; text-align: right;">'.$view_sub_total.'</td>';

    $xxxquery_payment = "SELECT TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, TRXA_PAYM_OUTS AS BALANCE FROM trxasale 
                    WHERE TRXA_REGI_CODE='$salecode' AND TRXA_SALE_CODE='$salecode' AND TRXA_VIEW_STAT='Y'";

    $query_payment = "SELECT TRXA_PAYM_DISC AS DISCOUNT, TRXA_PAYM_OUTS AS PAYMENT_AMOUNT FROM trxadrug 
                    WHERE TRXA_DRUG_CODE='$salecode'  AND TRXA_DRUG_STAT = 'P' AND TRXA_VIEW_STAT='Y'";

    $qpayment = $db->query($query_payment) or die("Gagal Ambil data Pembayaran!!");
    $row_payment = $qpayment->fetch(PDO::FETCH_ASSOC);
    $payment = $row_payment['PAYMENT_AMOUNT'];
    $kena_diskon = $row_payment['DISCOUNT'];
    //$balance  = $row_payment['BALANCE'];

    // DISCOUNT
    $view_kena_diskon = number_format($kena_diskon, 0, '', '.');
    echo '<td style="width: 125px; text-align: right;">'.$view_kena_diskon.'</td>';

    // PPN
    $dasar_kena_pajak = ($payment * (100/110));
    $ppn = ($dasar_kena_pajak * (10/100));
    $view_ppn = number_format($ppn, 0, '', '.'); 
    echo '<td style="width: 125px; text-align: right;">'.$view_ppn.'</td>';
    // Total
    echo '<td style="width: 125px; text-align: right;">'.$view_sub_total.'</td>';

    // payment
  	$view_payment = number_format($payment, 0, '', '.'); 
    echo '<td style="width: 125px; text-align: right;">'.$view_payment.'</td>';
    // balance
    
    $balance = ($sub_total - $payment);
    $view_balance = number_format($balance, 0, '', '.');
    echo '<td style="width: 125px; text-align: right;">'.$view_balance.'</td>';

    echo '</tr>';
	?>

  </tbody>
  </table>


