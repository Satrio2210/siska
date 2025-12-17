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
  <th style="width: 150px">Kotak</th>
  <th style="width: 150px">Ruangan</th>
  <th style="width: 200px">Item</th>
  <th style="width: 100px">Batch</th>
  <th style="width: 100px">Serial</th>
  <th style="width: 100px">Kadaluarsa</th>
  <th style="width: 100px">QTY</th>
  <th style="width: 100px">HNA</th>
  <th style="width: 100px">Harga</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, 
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_STOCK_NAME, INVE_WARE_CODE, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE, 
                ( INVE_STOCK_PRIC * '$profit' ) AS PRICE_SALE
                FROM investock WHERE INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0
                ORDER BY INVE_WARE_CODE"; 
}
else
{ 
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE,
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_STOCK_NAME, INVE_WARE_CODE, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE, 
                ( INVE_STOCK_PRIC * '$profit' ) AS PRICE_SALE
                FROM investock WHERE 
                INVE_STOCK_NAME LIKE '$kata%' 
                AND INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0

                OR INVE_STOCK_BTCH LIKE '$kata%'
                AND INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0

                ORDER BY INVE_WARE_CODE"; 
               
 }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($row = $q->fetch(PDO::FETCH_ASSOC))
{ 

    echo '<tr>';
    echo '<td style="width: 150px">'.$row['WARE_NAME'].'</td>';
    echo '<td style="width: 150px">'.$row['MEDI_NAME'].'</td>';
    echo '<td style="width: 200px">'.$row['INVE_STOCK_NAME'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_BTCH'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_SRNM'].'</td>'; 
    echo '<td style="width: 100px">'.$row['INVE_EXPR_DATE'].'</td>';

    $name_unit = $row['NAME_UNIT'];

    $view_stock_quty = number_format($row['INVE_STOCK_QUTY'],0,',','.');
    echo '<td style="width: 100px">'.$view_stock_quty.' '. $name_unit .'</td>';

    $view_stock_pric = number_format($row['INVE_STOCK_PRIC'],0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_stock_pric.'</td>';

    $view_price_sale = number_format($row['PRICE_SALE'],0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_price_sale.'</td>'; 

    echo '</tr>';

}
?>

  </tbody>
  </table>


