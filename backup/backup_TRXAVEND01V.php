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
  <th style="width: 100px">Suplier ID</th>
  <th style="width: 200px">Suplier Name</th>
  <th style="width: 150px">Amount</th>
  <th style="width: 100px">Due Date</th>
  <th style="width: 150px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];

$xquery = "SELECT SUPL_MAST_CODE AS ID_SUPLIER, SUPL_MAIN_NAME, 

(SELECT SUM(i.ITEM_PART_PRIC * i.ITEM_QUTY_RCVE) 
FROM itemproc AS i, trxaproc AS t 
WHERE t.TRXA_PROC_CODE = i.ITEM_PROC_CODE 
AND TRXA_PROC_STAT = 'CL'
AND t.TRXA_SUPL_CODE = ID_SUPLIER) AS INVC_AMOUNT,

(SELECT MIN(t.TRXA_PROC_DUED) 
FROM itemproc AS i, trxaproc AS t
WHERE t.TRXA_PROC_CODE = i.ITEM_PROC_CODE
AND TRXA_PROC_STAT = 'CL' 
AND t.TRXA_SUPL_CODE = ID_SUPLIER) AS DUED_DATE

FROM suplmast WHERE 

(SELECT SUM(i.ITEM_PART_PRIC * i.ITEM_QUTY_RCVE) 
FROM itemproc AS i, trxaproc AS t 
WHERE t.TRXA_PROC_CODE = i.ITEM_PROC_CODE 
AND TRXA_PROC_STAT = 'CL'
AND t.TRXA_SUPL_CODE = SUPL_MAST_CODE) > 0 

AND (SELECT COUNT(*) FROM trxavend WHERE TRXA_SUPL_CODE = SUPL_MAST_CODE 
     AND TRXA_VEND_STAT IN ('R','A','P')) = 0

AND SUPL_VIEW_STAT = 'Y'

"; 

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$id_suplier = $k['ID_SUPLIER'];
$name_suplier = $k['SUPL_MAIN_NAME'];

echo '<td style="width: 100px">'.$k['ID_SUPLIER'].'</td>';
echo '<td style="width: 200px">'.$k['SUPL_MAIN_NAME'].'</td>';

$invcamount = number_format($k['INVC_AMOUNT'], 0, '', '.');
echo '<td style="width: 150px">Rp.'.$invcamount.'</td>';

echo '<td style="width: 100px">'.$k['DUED_DATE'].'</td>';
echo '<td style="width: 150px">';

echo '<a class="button-view pure-button" 
      onclick="viewcode(\''.$id_suplier.'\',\''.$name_suplier.'\');">Request Payment</a>';
echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


