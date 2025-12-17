<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>

  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 200px; text-align: center;">Nama Kotak</th>
  <th style="width: 200px; text-align: center;">Ruangan</th>
  <th style="width: 200px; text-align: center;">Nama Barang</th>
  <th style="width: 100px; text-align: center;">Batch</th>
  <th style="width: 100px; text-align: center;">Serial</th>
  <th style="width: 100px; text-align: center;">Expired</th>
  <th style="width: 50px; text-align: center;">Qty</th>
  <th style="width: 100px; text-align: center;">Price</th>
  <th style="width: 100px; text-align: center;">Sale</th>
  

  </tr>
  </thead>
  <tbody>

<?php
$stockid = $_POST['q'];

if ($stockid == 'Y')
{

  $querystock = "SELECT INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_STOCK_NAME, INVE_WARE_CODE, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE, 
                ( INVE_STOCK_PRIC * '$profit' ) AS PRICE_SALE
                FROM investock WHERE INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0
                ORDER BY INVE_WARE_CODE";


  $qstock = $db->query($querystock) or die('Gagal Ambil Data Stock');
  while ($row = $qstock->fetch(PDO::FETCH_ASSOC))
  {
    echo '<tr>';
    echo '<td style="width: 200px">'.$row['WARE_NAME'].'</td>';
    echo '<td style="width: 200px">'.$row['MEDI_NAME'].'</td>';
    echo '<td style="width: 200px">'.$row['INVE_STOCK_NAME'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_BTCH'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_SRNM'].'</td>'; 
    echo '<td style="width: 100px">'.$row['INVE_EXPR_DATE'].'</td>';

    $view_stock_quty = number_format($row['INVE_STOCK_QUTY'],0,',','.');
    echo '<td style="width: 50px">'.$view_stock_quty.'</td>';

    $view_stock_pric = number_format($row['INVE_STOCK_PRIC'],0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_stock_pric.'</td>';

    $view_price_sale = number_format($row['PRICE_SALE'],0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_price_sale.'</td>'; 

    echo '</tr>';
  }  

}
else
{
    echo '<tr>';
    echo '<td style="width: 200px">none</td>';
    echo '<td style="width: 200px">none</td>';
    echo '<td style="width: 100px">none</td>';
    echo '<td style="width: 100px">none</td>';
    echo '<td style="width: 100px">none</td>'; 
    echo '<td style="width: 100px">none</td>';

    echo '<td style="width: 50px">none</td>';

    echo '<td style="width: 100px">none</td>';

    echo '<td style="width: 100px">none</td>'; 

    echo '</tr>';

}
           
?>
  </tbody>
  </table>


