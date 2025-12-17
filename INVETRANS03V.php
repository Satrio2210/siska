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
  <th style="width: 100px">QUANTITY</th>
  <th style="width: 100px">SERIAL</th>
  <th style="width: 100px">BATCH</th>
  <th style="width: 100px">CARTOON</th>
  <th style="width: 100px">DIMENSION</th>
  <th style="width: 100px">ACTION</th>

  </tr>
  </thead>
  <tbody>
<?php
$kode = $_POST['q'];
//$kode = 'ACC';

$xquery = "SELECT ITEM_STOCK_CODE, ITEM_STOCK_NAME, ITEM_STOCK_QUTY, ITEM_PART_UNIT,
           (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=ITEM_PART_UNIT) AS ITEM_PART_NAME, 
                  ITEM_STOCK_SRNM, ITEM_STOCK_BTCH, ITEM_CART_CODE, ITEM_DIMM_CODE,
                  ITEM_ENTR_TIME
          FROM itemexec 
          WHERE ITEM_EXEC_CODE = '$kode' 
          AND ITEM_VIEW_STAT = 'Y' 
          ORDER by ITEM_STOCK_CODE"; 

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$stockcode = $k['ITEM_STOCK_CODE'];
$timecode = $k['ITEM_ENTR_TIME'];
echo '<td style="width: 100px">'.$k['ITEM_STOCK_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['ITEM_STOCK_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_STOCK_QUTY'].' '.$k['ITEM_PART_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_STOCK_SRNM'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_STOCK_BTCH'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_CART_CODE'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_DIMM_CODE'].'</td>';
echo '<td style="width: 100px">';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$kode.'\',\''.$stockcode.'\',\''.$timecode.'\');}
              else
              { document.getElementById(\'txtstockname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


