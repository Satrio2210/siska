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
  <th style="width: 100px">PO Code</th>  
  <th style="width: 200px">Suplier Name</th>
  <th style="width: 150px">Amount</th>
  <th style="width: 200px">Invoice</th>
  <th style="width: 100px">Due Date</th>
  <th style="width: 150px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];

$xquery = "SELECT t.TRXA_PROC_CODE, t.TRXA_SUPL_CODE, 
          (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = t.TRXA_SUPL_CODE) AS SUPL_NAME,
          t.TRXA_PROC_VATX, t.TRXA_DOWN_PAID, t.TRXA_REMA_PAID,
          i.TRXA_INVC_CODE, i.TRXA_DUED_DATE
          FROM trxaproc AS t, trxainvc AS i
          WHERE t.TRXA_PROC_CODE = i.TRXA_PROC_CODE
          AND t.TRXA_PROC_STAT = 'CL'
          AND i.TRXA_INVC_STAT = 'U'
          ORDER BY i.TRXA_DUED_DATE     
"; 

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$proccode = $k['TRXA_PROC_CODE'];
echo '<td style="width: 100px">'.$k['TRXA_PROC_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['SUPL_NAME'].'</td>';

if ($k['TRXA_PROC_VATX'] == 'E') 
{
  $dpp = ($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']);
  $ppn = (($dpp * 10) /100);
  $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
}
else if ($k['TRXA_PROC_VATX'] == 'I')
{
  $dpp = (($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']) * (100/110));
  $ppn = (($dpp * 10) /100);
  $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
}
else
{
  $amount = $k['TRXA_REMA_PAID'];
}

$view_amount = number_format($amount, 0, '', '.');
echo '<td style="width: 150px; text-align: right;">Rp.'.$view_amount.'</td>';
echo '<td style="width: 200px">'.$k['TRXA_INVC_CODE'].'</td>';
echo '<td style="width: 100px">'.$k['TRXA_DUED_DATE'].'</td>';
echo '<td style="width: 150px">';

echo '<a class="button-view pure-button" 
      onclick="viewcode(\''.$proccode.'\');">Request Payment</a>';
echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


