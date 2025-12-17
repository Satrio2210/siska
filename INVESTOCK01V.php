<?php
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
  <th style="width: 100px">CODE ITEM</th>
  <th style="width: 200px">NAME ITEM</th>
  <th style="width: 150px">SERIAL</th>
  <th style="width: 150px">BATCH</th>
  <th style="width: 150px">QTY STOCK</th>
  <th style="width: 150px">QTY OPNAME</th>
  <th style="width: 150px">DIFFERENCE</th>
  <th style="width: 150px">STATUS</th>
  <th style="width: 100px">ACTION</th>

  </tr>
  </thead>
  <tbody>
<?php
$rawinput = $_POST['q'];
list($opnacode, $warecode, $typecode) = explode("|",$rawinput);

$xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_SRNM, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_QUTY, 
           (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = INVE_STOCK_CODE) AS PART_UNIT,
           (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = PART_UNIT) AS NAME_UNIT,
           
           (SELECT ITEM_STOCK_OPNA FROM itemopna WHERE
            ITEM_OPNA_CODE = '$opnacode'
            AND ITEM_WARE_CODE = '$warecode'
            AND ITEM_STOCK_CODE = INVE_STOCK_CODE 
             AND ITEM_STOCK_BTCH = INVE_STOCK_BTCH              
             ) 
           AS QTY_OPNAME, INVE_ENTR_TIME
           FROM investock 
           WHERE INVE_STOCK_TYPE = '$typecode' 
           AND INVE_WARE_CODE = '$warecode' 
          AND INVE_VIEW_STAT IN ('R','Y','X')
          ORDER by INVE_STOCK_CODE, INVE_ENTR_DATE";


$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$stockcode = $k['INVE_STOCK_CODE'];
$timecode = $k['INVE_ENTR_TIME'];
echo '<td style="width: 100px">'.$k['INVE_STOCK_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['INVE_STOCK_NAME'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_SRNM'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_BTCH'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_QUTY'].' '.$k['NAME_UNIT'].'</td>';
$qtystock = $k['INVE_STOCK_QUTY'];
$qtyopname = $k['QTY_OPNAME'];
if ($qtyopname == '')
{
echo '<td style="width: 150px">0 '.$k['NAME_UNIT'].'</td>';
}
else
{
echo '<td style="width: 150px">'.$k['QTY_OPNAME'].' '.$k['NAME_UNIT'].'</td>';  
}
$difference = $qtystock - $qtyopname;
echo '<td style="width: 150px">'.$difference.'  '.$k['NAME_UNIT'].'</td>';
echo '<td style="width: 100px">';
echo '<a class="button-view pure-button" 
              onclick="viewcode(\''.$warecode.'\',\''.$stockcode.'\',\''.$timecode.'\');">Opname</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


