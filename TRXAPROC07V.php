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
  <th style="width: 100px">Item Code</th>
  <th style="width: 200px">Item Name</th>
  <th style="width: 150px">Quantity</th>
  <th style="width: 150px">Price</th>
  <th style="width: 200px">Ware House</th>
  <th style="width: 100px">Receipt Date</th>
  <th style="width: 100px">Status</th>
  <th style="width: 120px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT INVE_STOCK_CODE, INVE_PROC_CODE, INVE_STOCK_NAME, INVE_WARE_CODE, 
          (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME, 
          (SELECT ITEM_ARRV_REQU FROM itemproc WHERE ITEM_PROC_CODE = INVE_PROC_CODE AND ITEM_PART_CODE = INVE_STOCK_CODE) AS RECEIPT_DATE, 
          INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
          (SELECT ITEM_PART_UNIT FROM itemproc WHERE ITEM_PROC_CODE = INVE_PROC_CODE AND ITEM_PART_CODE = INVE_STOCK_CODE) AS STOCK_UNIT,

          (SELECT TRXA_RETU_STAT FROM trxaretu WHERE TRXA_PROC_CODE = INVE_PROC_CODE 
           AND TRXA_RETU_DIVI = (SELECT TRXA_PROC_DIVI FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE)
           AND TRXA_SUPL_CODE = (SELECT TRXA_SUPL_CODE FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE)
          ) AS RETU_STAT

          FROM investock 
          WHERE INVE_VIEW_STAT = 'R' AND INVE_STOCK_QUTY > 0
          AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) = 'R'
          ORDER BY INVE_STOCK_CODE DESC
"; 
}
else
{
$xquery = "SELECT INVE_STOCK_CODE, INVE_PROC_CODE, INVE_STOCK_NAME, INVE_WARE_CODE, 
          (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME, 
          (SELECT ITEM_ARRV_REQU FROM itemproc WHERE ITEM_PROC_CODE = INVE_PROC_CODE AND ITEM_PART_CODE = INVE_STOCK_CODE) AS RECEIPT_DATE, 
          INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
          (SELECT ITEM_PART_UNIT FROM itemproc WHERE ITEM_PROC_CODE = INVE_PROC_CODE AND ITEM_PART_CODE = INVE_STOCK_CODE) AS STOCK_UNIT,

          (SELECT TRXA_RETU_STAT FROM trxaretu WHERE TRXA_PROC_CODE = INVE_PROC_CODE 
           AND TRXA_RETU_DIVI = (SELECT TRXA_PROC_DIVI FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE)
           AND TRXA_SUPL_CODE = (SELECT TRXA_SUPL_CODE FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE)
          ) AS RETU_STAT

          FROM investock 
          WHERE INVE_PROC_CODE = '$kata' AND INVE_VIEW_STAT = 'R' AND INVE_STOCK_QUTY > 0
          AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) = 'R'
          ORDER BY INVE_STOCK_CODE DESC
"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$stockcode = $k['INVE_STOCK_CODE'];
$proccode = $k['INVE_PROC_CODE'];
echo '<td style="width: 100px">'.$stockcode.'</td>';
echo '<td style="width: 200px">'.$k['INVE_STOCK_NAME'].'</td>';
$stockqty = number_format($k['INVE_STOCK_QUTY'], 0, '', '.');
echo '<td style="width: 150px">'.$stockqty.' '.$k['STOCK_UNIT'].'</td>';
$stockpric = number_format($k['INVE_STOCK_PRIC'], 0, '', '.');
echo '<td style="width: 150px">Rp. '.$stockpric.'</td>';
echo '<td style="width: 200px">'.$k['WARE_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['RECEIPT_DATE'].'</td>';
echo '<td style="width: 100px">'.$k['RETU_STAT'].'</td>';
echo '<td style="width: 120px">';

if ($k['RETU_STAT'] == 'E') 
  { 
    $retustat = 'G'; 
    echo '<a class="button-view pure-button" 
    onclick="viewcode(\''.$stockcode.'\',\''.$proccode.'\',\''.$retustat.'\');">Terima Retur</a>';

  }
else 
  { 
    $retustat = 'E'; 
    echo '<a class="button-delete pure-button" 
    onclick="viewcode(\''.$stockcode.'\',\''.$proccode.'\',\''.$retustat.'\');">Kirim Retur</a>';

  }


echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


