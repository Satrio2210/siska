<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
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
  <th style="width: 130px">No Faktur</th>
  <th style="width: 100px">Tanggal</th>
  <th style="width: 150px">Nominal</th>
  <th style="width: 100px">Diskon</th>
  <th style="width: 150px">Pembayaran</th>
  <th style="width: 100px">Status</th>
  <th style="width: 100px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, TRXA_PAYM_MODE, TRXA_DRUG_STAT, TRXA_UPDT_DATE 
           FROM trxadrug WHERE TRXA_DRUG_STAT = 'P' 
           AND TRXA_VIEW_STAT = 'Y' 
           ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
}
else
{ 
$xquery = "SELECT TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, TRXA_PAYM_MODE, TRXA_DRUG_STAT, TRXA_UPDT_DATE 
           FROM trxadrug WHERE TRXA_DRUG_CODE LIKE '$kata%' 
           AND TRXA_DRUG_STAT = 'P' 
           AND TRXA_VIEW_STAT = 'Y' 
           ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
               
 }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$drugcode = $k['TRXA_DRUG_CODE'];
echo '<td style="width: 130px">'.$k['TRXA_DRUG_CODE'].'</td>';
$drugdate = date("d-m-Y", strtotime($k['TRXA_UPDT_DATE']));
echo '<td style="width: 100px">'.$drugdate.'</td>';

$view_paymamnt = number_format($k['TRXA_PAYM_AMNT'], 0, '', '.');

echo '<td style="width: 150px; text-align: right;">'.$view_paymamnt.'</td>';

$view_paymdisc = number_format($k['TRXA_PAYM_DISC'], 0, '', '.');

echo '<td style="width: 100px; text-align: right;">'.$view_paymdisc.'</td>';

    if ($k['TRXA_PAYM_MODE'] == 'TUN')
      { $paymmode = 'Cash'; }
    else if ($k['TRXA_PAYM_MODE'] == 'BCA')
      { $paymmode = 'Debit BCA'; }
    else if ($k['TRXA_PAYM_MODE'] == 'MAN')
      { $paymmode = 'Debit Mandiri'; }
    else if ($k['TRXA_PAYM_MODE'] == 'BNI')
      { $paymmode = 'Debit BNI'; }
    else if ($k['TRXA_PAYM_MODE'] == 'BCM')
      { $paymmode = 'Transfer BCA'; }
    else if ($k['TRXA_PAYM_MODE'] == 'LIN')
      { $paymmode = 'Transfer LinkAja'; }

echo '<td style="width: 150px">'.$paymmode.'</td>';

if ($k['TRXA_DRUG_STAT'] == 'I')
{ $drugstat = 'Out Standing'; }
else if ($k['TRXA_DRUG_STAT'] == 'P')
{
  $drugstat = 'Paid Off';
}
else
{
  $drugstat = 'None';
}
echo '<td style="width: 100px">'.$drugstat.'</td>';

echo '<td style="width: 100px">';
?>
<a class="pure-button button-print" onClick="javascript: location.href ='TRXADRUG03P.php?drugcode=<?php echo $drugcode;?>'">Print</a> 

<?php
echo '</td>';

echo '</tr>';
}
?>

  </tbody>
  </table>


