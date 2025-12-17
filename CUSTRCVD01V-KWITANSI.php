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
  <th style="width: 150px">DESCRIPTION</th>
  <th style="width: 100px">QTY</th>
  <th style="width: 100px">UOM</th>
  <th style="width: 100px">AMOUNT</th>
  <th style="width: 100px">DISC</th>
  <th style="width: 100px">PATIENT</th>
  
  </tr>
  </thead>
  <tbody>
  <tr>
  <td style="width: 50px"></td>
  <td style="width: 150px">DRUGS</td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  </tr>      
<?php
$rawinput = xss_clean($_POST['q']);
list($salecode,$kodetransaksi) = explode("|",$rawinput);
//$kodetransaksi = '29122021-00447';
//$salecode = '29122021-00284';
$no = 0;
$sub_total = 0;

//$kodetransaksi = Nomor kwitansi

//  $datenow = date("Y-m-d");
//  $xdatenow = strtotime($datenow);
//  $yearnow = date('Y',$xdatenow);
//  $monthnow = date('m',$xdatenow);
//  $daynow = date('d',$xdatenow);

// $varquery = "SET @CSUM := 0"; 
// $qvar = $db->query($varquery) or die("Gagal Set Variable");
// $var = $qvar->fetch(PDO::FETCH_ASSOC);

$query_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS UNIT_CODE,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,
              (TRXA_STOCK_PRIC * '$profit') AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE
              FROM trxaprsc WHERE TRXA_PRSC_CODE = '$kodetransaksi' AND TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT='Y'";
 
$qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC))
{ 
$drug_name = $row_prsc['STOCK_NAME'];
$drug_qty = $row_prsc['TRXA_STOCK_QUTY'];
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
echo '<td style="width: 150px; text-align: left;">'.$drug_name.'</td>';
echo '<td style="width: 100px">'.$drug_qty.'</td>';
echo '<td style="width: 100px">'.$drug_unit.'</td>';
echo '<td style="width: 100px">'.$view_drug_amount.'</td>';
echo '<td style="width: 100px">0</td>';
echo '<td style="width: 100px">'.$view_drug_amount.'</td>';
echo '</tr>';
}
?>
  <tr>
  <td style="width: 50px"></td>
  <td style="width: 150px; text-align: left;">TREATMENT</td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  </tr>      
<?php
  $query_action = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE, 
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME, 
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) IN ('O','N')  
              AND TRXA_TRET_CODE = '$kodetransaksi' AND TRXA_VIEW_STAT='Y'";

  $qaction = $db->query($query_action) or die("Gagal Ambil data tindakan!!");
  while ($row_action = $qaction->fetch(PDO::FETCH_ASSOC))
  { 
  $action_name = $row_action['MEDI_NAME'];
  $action_qty = $row_action['TRXA_TRET_QUTY'];
  $action_amount = $row_action['SUB_TOTAL'];
  $view_action_amount = number_format($row_action['SUB_TOTAL'], 0, '', '.');  

  $no++;
  $sub_total = $sub_total + $action_amount;

  echo '<tr>';
  echo '<td style="width: 50px">'.$no.'</td>';
  echo '<td style="width: 150px; text-align: left;">'.$action_name.'</td>';
  echo '<td style="width: 100px">'.$action_qty.'</td>';
  echo '<td style="width: 100px"></td>';
  echo '<td style="width: 100px">'.$view_action_amount.'</td>';
  echo '<td style="width: 100px">0</td>';
  echo '<td style="width: 100px">'.$view_action_amount.'</td>';
  echo '</tr>';

  }
?>
  <tr>
  <td style="width: 50px"></td>
  <td style="width: 150px; text-align: left;">SERVICES</td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  </tr>      
<?php
  $query_tret = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE, 
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME, 
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) = 'J' 
              AND TRXA_TRET_CODE = '$kodetransaksi' AND TRXA_VIEW_STAT='Y'";

  $qtret = $db->query($query_tret) or die("Gagal Ambil data jasa pelayanan!!");
  while ($row_tret = $qtret->fetch(PDO::FETCH_ASSOC))
  {
  $tret_name = $row_tret['MEDI_NAME'];
  $tret_qty = $row_tret['TRXA_TRET_QUTY'];
  $tret_amount = $row_tret['SUB_TOTAL'];
  $view_tret_amount = number_format($row_tret['SUB_TOTAL'], 0, '', '.');  

  $no++;
  $sub_total = $sub_total + $tret_amount;

  echo '<tr>';
  echo '<td style="width: 50px">'.$no.'</td>';
  echo '<td style="width: 150px; text-align: left;">'.$tret_name.'</td>';
  echo '<td style="width: 100px">'.$tret_qty.'</td>';
  echo '<td style="width: 100px"> </td>';
  echo '<td style="width: 100px">'.$view_tret_amount.'</td>';
  echo '<td style="width: 100px">0</td>';
  echo '<td style="width: 100px">'.$view_tret_amount.'</td>';
  echo '</tr>';

  }

?>

  <tr>
  <td style="width: 50px"></td>
  <td style="width: 150px; text-align: left;">CONSUMABLE</td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  <td style="width: 100px"> </td>
  </tr>      

<?php
  $query_csbl = "SELECT TRXA_CSBL_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              (TRXA_STOCK_PRIC * '$profit') AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_CSBL_CODE) AS PAYM_TYPE
              FROM trxacsbl WHERE TRXA_CSBL_CODE = '$kodetransaksi' AND TRXA_CSBL_STAT = 'P' AND TRXA_VIEW_STAT='Y'";

  $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP!!");
  while ($row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC))
  {

  $csbl_name = $row_csbl['STOCK_NAME'];
  $csbl_qty = $row_csbl['TRXA_STOCK_QUTY'];

  $xharga = round($row_csbl['SUB_TOTAL_PRIC']);
  $int = (int)$xharga;

  $csbl_amount = pembulatan($int);

  //$csbl_amount = $row_csbl['SUB_TOTAL_PRIC'];
  $view_csbl_amount = number_format($csbl_amount, 0, '', '.');  

  $no++;
  $sub_total = $sub_total + $csbl_amount;

  echo '<tr>';
  echo '<td style="width: 50px">'.$no.'</td>';
  echo '<td style="width: 150px; text-align: left;">'.$csbl_name.'</td>';
  echo '<td style="width: 100px">'.$csbl_qty.'</td>';
  echo '<td style="width: 100px"></td>';
  echo '<td style="width: 100px">'.$view_csbl_amount.'</td>';
  echo '<td style="width: 100px">0</td>';
  echo '<td style="width: 100px">'.$view_csbl_amount.'</td>';
  echo '</tr>';

  }

?>
	<?php
	/// final summary
    echo '<tr>';
  	echo '<td style="width: 50px"> </td>';

	echo '<td style="width: 150px; text-align: left;"><b>SUB TOTAL</b></td>';
    echo '<td style="width: 100px; text-align: left;"><b>DISCOUNT</b></td>';
    echo '<td style="width: 100px; text-align: right;"><b>ADMIN</b></td>';
    echo '<td style="width: 100px; text-align: right;"><b>TOTAL</b></td>';
    echo '<td style="width: 100px; text-align: right;"><b>PAYMENT</b></td>';
    echo '<td style="width: 100px; text-align: right;"><b>BALANCE</b></td>';
    
    echo '</tr>';

    echo '<tr>';
  	echo '<td style="width: 50px"> </td>';

    $view_sub_total = number_format($sub_total, 0, '', '.');
    // sub total
	echo '<td style="width: 150px; text-align: right;">'.$view_sub_total.'</td>';
    // discont
    echo '<td style="width: 100px; text-align: right;">0</td>';
    // admin charge

	// Periksa apakah ada obat racikan
    $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$kodetransaksi' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";
    $periksaracikan_di_query=$db->query($periksaracikan) or die ("Cek Fail");
    $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

    if ($ketersediaan_racikan == 0)
  	{
            // Periksa apakah ada resep yang diberikan
            $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$kodetransaksi'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";
            $periksaresep_di_query=$db->query($periksaresep) or die ("Cek Fail");
            $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

            if ($ketersediaan_resep == 0)
            {
              // periksa di data register apakah di kenakan biaya admin
              $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$kodetransaksi' AND TRXA_REGI_FEE='P'";
                $periksabiayaadmin_di_query=$db->query($periksabiayaadmin) or die ("Cek Fail");
                $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

                if ($ketersediaan_biayaadmin == 0)
                {
                  $total_admin = 0;
                }
                else
                {
                  $total_admin = $fee_admin;
                }                
            }
            else
            {
                $total_admin = ($fee_admin + $fee_resep);  
            }
  	}
  	else
  	{
    	$total_admin = ($fee_admin + ($fee_resep + $fee_racikan));  
  	}

  	$view_fee_admin = number_format($total_admin, 0, '', '.'); 

    echo '<td style="width: 100px; text-align: right;">'.$view_fee_admin.'</td>';
    // total
  	$sub_total = $sub_total + $total_admin;
  	$view_sub_total = number_format($sub_total, 0, '', '.'); 

    echo '<td style="width: 100px; text-align: right;">'.$view_sub_total.'</td>';

  	$query_payment = "SELECT TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, TRXA_PAYM_OUTS AS BALANCE FROM trxasale 
                    WHERE TRXA_REGI_CODE='$kodetransaksi' AND TRXA_SALE_CODE='$salecode' AND TRXA_VIEW_STAT='Y'";

  	$qpayment = $db->query($query_payment) or die("Gagal Ambil data Pembayaran!!");
  	$row_payment = $qpayment->fetch(PDO::FETCH_ASSOC);
  	$payment = $row_payment['PAYMENT_AMOUNT'];
  	$balance  = $row_payment['BALANCE'];

    // payment
  	$view_payment = number_format($payment, 0, '', '.'); 
    echo '<td style="width: 100px; text-align: right;">'.$view_payment.'</td>';
    // balance
    $view_balance = number_format($balance, 0, '', '.');
    echo '<td style="width: 100px; text-align: right;">'.$view_balance.'</td>';

    echo '</tr>';
	?>

  </tbody>
  </table>


