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
  height: 300px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 200px; text-align: center;">Account</th>
  <th style="width: 150px; text-align: center;">Cheque Number</th>
  <th style="width: 200px; text-align: center;">Cheque Date</th>
  <th style="width: 200px; text-align: center;">Bank</th>
  <th style="width: 150px; text-align: center;">Outstanding</th>
  <th style="width: 150px; text-align: center;">Be Paid</th>

  </tr>
  </thead>
  <tbody>
<?php
$vendcode = $_POST['q'];
//$vendcode = 'VP-0002';
//$fulltext = '2020-01-01|2020-07-31';

$queryrequ = "SELECT LEFT(ITEM_COAC_CODE,3) AS MAST_PRNT, RIGHT(ITEM_COAC_CODE,1) AS MAST_CODE, 
(SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = MAST_PRNT AND COAC_MAST_CODE = MAST_CODE) AS COAC_NAME, 
ITEM_CHEQ_CODE, ITEM_CHEQ_DATE, ITEM_CHEQ_BANK, 
(SELECT TBLE_BANK_NAME FROM tblebank WHERE TBLE_BANK_CODE = ITEM_CHEQ_BANK) AS BANK_NAME,
ITEM_SUMM_AMNT, ITEM_PAYM_AMNT
FROM itemvend WHERE ITEM_VEND_CODE = '$vendcode'";
           
$qrequ = $db->query($queryrequ) or die("Gagal Ambil Data Request ");
while ($k = $qrequ->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  //$nomorrequest=$k['TRXA_VEND_CODE'];
  echo '<td style="width: 200px">'.$k['COAC_NAME'].'</td>';
  echo '<td style="width: 150px">'.$k['ITEM_CHEQ_CODE'].'</td>';
  $cheqdate = formatTanggal($k['ITEM_CHEQ_DATE']);
  echo '<td style="width: 200px">'.$cheqdate.'</td>';
  echo '<td style="width: 200px">'.$k['BANK_NAME'].'</td>';

  $view_summamnt = number_format($k['ITEM_SUMM_AMNT'], 0, '', '.');
  $view_paymamnt = number_format($k['ITEM_PAYM_AMNT'], 0, '', '.');

  if ($k['ITEM_SUMM_AMNT'] == 0)
  {
  echo '<td style="width: 150px; text-align: left; background-color: #98F7FD;">Rp. '.$view_summamnt.'</td>';
  echo '<td style="width: 150px; text-align: left;background-color: #98F7FD;">Rp. '.$view_paymamnt.'</td>';
  }
  else
  {
  echo '<td style="width: 150px; text-align: left;">Rp. '.$view_summamnt.'</td>';
  echo '<td style="width: 150px; text-align: left;">Rp. '.$view_paymamnt.'</td>';    
  }

  //echo '<td style="width: 100px">';

  //echo '<a class="button-view pure-button" 
  //    onclick="viewcode(\''.$nomorrequest.'\');">Pay</a>';
  //echo '</td>';
  echo '</tr>';
}
?>
  </tbody>
  </table>


