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
  <th style="width: 150px">Kotak</th>
  <th style="width: 150px">Ruangan</th>
  <th style="width: 200px">Item</th>
  <th style="width: 100px">Jenis</th>
  <th style="width: 100px">Batch</th>
  <th style="width: 100px">Serial</th>
  <th style="width: 200px">QTY</th>
  <th style="width: 100px">HNA</th>
  <th style="width: 100px">PPN</th>
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
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, INVE_PROC_CODE,
                (SELECT TRXA_PROC_VATX FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE) AS VAT_CODE,
                (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS PART_TYPE,
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS MAIN_CODE_UNIT,

                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS MAIN_NAME_UNIT,
                (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS DEVI_UNIT, 

                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, 
                (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME, 
                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
                INVE_WARE_CODE, 
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
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, INVE_PROC_CODE,
                (SELECT TRXA_PROC_VATX FROM trxaproc WHERE TRXA_PROC_CODE = INVE_PROC_CODE) AS VAT_CODE,
                (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS PART_TYPE,
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS MAIN_CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS MAIN_NAME_UNIT, 
                (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS DEVI_UNIT,
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, 
                (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME, 
                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS SPEC_CODE,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
                INVE_WARE_CODE, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE, 
                ( INVE_STOCK_PRIC * '$profit' ) AS PRICE_SALE
                FROM investock WHERE 
                INVE_STOCK_NAME LIKE '$kata%' 
                AND INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0

                OR INVE_STOCK_NAME LIKE '%$kata%'
                AND INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0

                OR (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) LIKE '%$kata%'
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
    echo '<td style="width: 200px">'.$row['STOCK_NAME'].' '.$row['SPEC_NAME'].'</td>';

    if ($row['PART_TYPE'] == 'NS') { $parttype = 'BHP';}
    else if ($row['PART_TYPE'] == 'ST') { $parttype = 'Obat';}
    else { $parttype = 'Umum'; } 

    echo '<td style="width: 100px">'.$parttype.'</td>';

    echo '<td style="width: 100px">'.$row['INVE_STOCK_BTCH'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_SRNM'].'</td>'; 

    $posisi=strpos($row['MAIN_NAME_UNIT'],'@');

    if ($posisi)
    {
      list($main_name_unit,$subpartunit) = explode('@',$row['MAIN_NAME_UNIT']);
    }
    else 
    {
        $main_name_unit = $row['MAIN_NAME_UNIT']; 
    }

    $name_unit = $row['NAME_UNIT'];
    $devi_unit = $row['DEVI_UNIT'];
    $stock_quty = $row['INVE_STOCK_QUTY'];
    $sisa = ($stock_quty % $devi_unit);
    $xgenap = ($stock_quty - $sisa);
    $genap = ($xgenap / $devi_unit);

    if ($genap == 0)
    {

    $view_genap = number_format($genap,0,',','.');
    echo '<td style="width: 200px">'.$sisa.' '. $name_unit .'</td>';

    }
    else if ($sisa == 0)
    {
    $view_genap = number_format($genap,0,',','.');
    echo '<td style="width: 200px">'.$genap.' '.$main_name_unit.'</td>';

    }
    else
    {

    $view_genap = number_format($genap,0,',','.');
    echo '<td style="width: 200px">'.$genap.' '.$main_name_unit.' '.$sisa.' '. $name_unit .'</td>';

    }


    $view_stock_pric = number_format($row['INVE_STOCK_PRIC'],0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_stock_pric.'</td>';

         if ($row['VAT_CODE'] == 'I') { $pajak_ppn = 'Termasuk PPN';}
    else if ($row['VAT_CODE'] == 'E') { $pajak_ppn = 'Diluar PPN';}
    else { $pajak_ppn = 'No PPN';} 
    
    echo '<td style="width: 100px">'.$pajak_ppn.'</td>';
    $xharga = round($row['PRICE_SALE']);
    $int = (int)$xharga;

    $price_sale = pembulatan($int);    

    $view_price_sale = number_format($price_sale,0,',','.');
    echo '<td style="width: 100px">Rp. '.$view_price_sale.'</td>'; 
    echo '</tr>';

}
?>

  </tbody>
  </table>


