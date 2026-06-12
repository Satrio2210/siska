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

  <th style="width: 300px">Nama Obat</th>
  <th style="width: 100px">Batch</th>
  <th style="width: 100px">Satuan</th>
  <th style="width: 100px">Harga</th>
  <th style="width: 100px">Qty</th>
  <th style="width: 100px">Sub Total.</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$drugcode = $_POST['q'];

$xquery = "SELECT ITEM_STOCK_CODE AS STOCK_CODE, ITEM_STOCK_BTCH,
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE= UNIT_CODE) AS UNIT_NAME,

                          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,

           ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, 
           (ITEM_STOCK_PRIC * ITEM_STOCK_QUTY * 0.4) AS SUB_TOTAL
          FROM itemdrug 
          WHERE ITEM_DRUG_STAT='I' AND ITEM_DRUG_CODE='$drugcode' AND ITEM_VIEW_STAT='Y'
          ORDER BY ITEM_UPDT_TIME";


$q = $db->query($xquery) or die("Gagal Maning!!");

while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
//  nama obat | satuan | harga | qty | sub
echo '<tr>';
$stockcode = $k['STOCK_CODE'];
echo '<td style="width: 300px">'.$k['STOCK_NAME']. ' ' .$k['SPEC_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['ITEM_STOCK_BTCH'].'</td>';
echo '<td style="width: 100px">'.$k['UNIT_NAME'].'</td>';

$xprice = round($k['ITEM_STOCK_PRIC']);
$xint = (int)$xprice;

$price = pembulatan($xint);

$viewprice = number_format($price, 0, '', '.');
echo '<td style="width: 100px; text-align: right;">'.$viewprice.'</td>';

echo '<td style="width: 100px">'.$k['ITEM_STOCK_QUTY'].'</td>';

//$xharga = round($k['SUB_TOTAL']);
//$int = (int)$xharga;

//$sub_total = pembulatan($int); 

//naik 40%
// $upharga = 0.4;

$stockquty = $k['ITEM_STOCK_QUTY'];
$sub_total = ($price * $stockquty);

// $sub_tota1 = ($sub_tota * $upharga);
// $sub_total = ($sub_tota + $sub_tota1);

$viewtotal = number_format($sub_total, 0, '', '.');
//$viewtotal = number_format($k['SUB_TOTAL'], 0, '', '.');

echo '<td style="width: 100px; text-align: right;">'.$viewtotal.'</td>';

echo '<td style="width: 200px">';

echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$drugcode.'\',\''.$stockcode.'\');}
              else
              { document.getElementById(\'txtstockcode\').focus();}
              ">Delete</a>';

echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


