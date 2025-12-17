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
  <th style="width: 200px">Kategori</th>
  <th style="width: 200px">Nama Obat</th>
  <th style="width: 100px">Batch Code</th>
  <th style="width: 150px">Harga Jual</th>
  <th style="width: 150px">Harga Jual</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 

$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, INVE_PROC_CODE AS PROC_CODE,
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_PACK_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_PACK_UNIT) AS NAME_PACK_UNIT, 
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_RITEL_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_RITEL_UNIT) AS NAME_RITEL_UNIT, 
                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_SPEC,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,
                
                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_NAME,
                ((SELECT ITEM_PART_PRIC FROM itemproc 
                WHERE ITEM_PROC_CODE = PROC_CODE AND ITEM_PART_CODE = STOCK_CODE) * '$profit') AS  PRICE_PACK,   
                INVE_STOCK_PRIC, ( INVE_STOCK_PRIC * '$profit' ) AS PRICE_RITEL
                FROM investock WHERE INVE_VIEW_STAT IN ('R','Y')

                AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'NS'
                AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=INVE_STOCK_CODE)
                  ) = 'RM'

                ORDER BY INVE_STOCK_NAME"; 

}
else
{ 
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, INVE_PROC_CODE AS PROC_CODE,
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_PACK_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_PACK_UNIT) AS NAME_PACK_UNIT, 
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_RITEL_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_RITEL_UNIT) AS NAME_RITEL_UNIT, 
                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_SPEC,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,

                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_NAME,
                ((SELECT ITEM_PART_PRIC FROM itemproc 
                WHERE ITEM_PROC_CODE = PROC_CODE AND ITEM_PART_CODE = STOCK_CODE) * '$profit') AS  PRICE_PACK,

                INVE_STOCK_PRIC, 
                (INVE_STOCK_PRIC * '$profit') AS PRICE_RITEL
                FROM investock 
                WHERE INVE_VIEW_STAT IN ('R','Y') 

                AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'NS'
                AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=INVE_STOCK_CODE)
                  ) = 'RM'

                AND INVE_STOCK_NAME LIKE '$kata%'

                OR INVE_VIEW_STAT IN ('R','Y')
                
                AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'NS'
                AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=INVE_STOCK_CODE)
                  ) = 'RM'

                AND (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) LIKE '$kata%'                
                ORDER BY INVE_STOCK_NAME"; 
               
 }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($row = $q->fetch(PDO::FETCH_ASSOC))
{ 

    echo '<tr>';
    echo '<td style="width: 200px">'.$row['CATE_NAME'].'</td>';
    echo '<td style="width: 200px">'.$row['INVE_STOCK_NAME'].' '.$row['NAME_SPEC'].'</td>';
    echo '<td style="width: 100px">'.$row['INVE_STOCK_BTCH'].'</td>';


    $posisi=strpos($row['NAME_PACK_UNIT'],'@');

    if ($posisi)
    {
      list($packunit,$subpackunit) = explode('@',$row['NAME_PACK_UNIT']);
    }
    else 
    {
        $packunit = $row['NAME_PACK_UNIT']; 
    }

    //$xharga = round($row['PRICE_SALE']);
    //$int = (int)$xharga;

    //$price_sale = pembulatan($int);    

    //$view_price_sale = number_format($price_sale,0,',','.');
    //echo '<td style="width: 100px">Rp. '.$view_price_sale.'</td>'; 

    $xharga1 = round($row['PRICE_PACK']);
    $int1 = (int)$xharga1;

    $price_pack = pembulatan($int1);
    $view_price_pack = number_format($price_pack,0,',','.');
    //$view_price_pack = number_format($row['PRICE_PACK'],0,',','.');    
    echo '<td style="width: 150px">'.$view_price_pack.' per '.$packunit.'</td>';

    $xharga2 = round($row['PRICE_RITEL']);
    $int2 = (int)$xharga2;

    $price_ritel = pembulatan($int2);

    $view_price_ritel = number_format($price_ritel,0,',','.');
    //$view_price_ritel = number_format($row['PRICE_RITEL'],0,',','.');
    echo '<td style="width: 150px">'.$view_price_ritel.' per '.$row['NAME_RITEL_UNIT'].'</td>';

    echo '</tr>';

}
?>

  </tbody>
  </table>


