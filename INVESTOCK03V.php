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
  <th style="width: 100px">TYPE ITEM</th>
  <th style="width: 150px">SERIAL</th>
  <th style="width: 150px">BATCH</th>
  <th style="width: 150px">QTY STOCK</th>
  <th style="width: 150px">QTY OPNAME</th>
  <th style="width: 150px">DIFFERENCE</th>
  <th style="width: 100px">ACTION</th>

  </tr>
  </thead>
  <tbody>
<?php
$rawinput = $_POST['q'];
list($opnacode, $warecode) = explode("|",$rawinput);

$xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_TYPE,
            (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS NAME_TYPE, 
            INVE_STOCK_SRNM, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_QUTY, 
           (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = INVE_STOCK_CODE) AS PART_UNIT,
           (SELECT ITEM_STOCK_OPNA FROM itemopna WHERE
            ITEM_OPNA_CODE = '$opnacode'
            AND ITEM_WARE_CODE = '$warecode'
            AND ITEM_STOCK_CODE = INVE_STOCK_CODE 
             AND ITEM_STOCK_BTCH = INVE_STOCK_BTCH              
             ) 
           AS QTY_OPNAME, INVE_ENTR_TIME
           FROM investock 
           WHERE INVE_WARE_CODE = '$warecode' 
          AND INVE_VIEW_STAT = 'X' 
          ORDER by INVE_STOCK_CODE"; 


$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$stockcode = $k['INVE_STOCK_CODE'];
$timecode = $k['INVE_ENTR_TIME'];
echo '<td style="width: 100px">'.$k['INVE_STOCK_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['INVE_STOCK_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['NAME_TYPE'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_SRNM'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_BTCH'].'</td>';
echo '<td style="width: 150px">'.$k['INVE_STOCK_QUTY'].' '.$k['PART_UNIT'].'</td>';
$qtystock = $k['INVE_STOCK_QUTY'];
$qtyopname = $k['QTY_OPNAME'];
if ($qtyopname == '')
{
echo '<td style="width: 150px">0 '.$k['PART_UNIT'].'</td>';
}
else
{
echo '<td style="width: 150px">'.$k['QTY_OPNAME'].' '.$k['PART_UNIT'].'</td>';  
}
$difference = $qtystock - $qtyopname;
echo '<td style="width: 150px">'.$difference.'  '.$k['PART_UNIT'].'</td>';
echo '<td style="width: 100px">';
echo '<a class="button-update pure-button" 
              onclick="ubahstock(\''.$opnacode.'\',\''.$warecode.'\',\''.$stockcode.'\',\''.$timecode.'\',\''.$qtyopname.'\');">Execute</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


