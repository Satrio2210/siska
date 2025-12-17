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
  <th style="width: 200px">Lokasi</th>
  <th style="width: 200px">Kadaluarsa</th>
  <th style="width: 200px">Sisa Obat</th>

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
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS MAIN_CODE_UNIT,

                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS MAIN_NAME_UNIT,
                (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS DEVI_UNIT, 

                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 

                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_SPEC,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,

                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_WARE_CODE, 
                (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE
                FROM investock WHERE INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0
                ORDER BY INVE_STOCK_BTCH"; 
}
else
{ 
$xquery = "SELECT INVE_STOCK_CODE AS STOCK_CODE, 
                (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS MAIN_CODE_UNIT,

                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS MAIN_NAME_UNIT,
                (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = MAIN_CODE_UNIT) AS DEVI_UNIT, 

                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_UNIT,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 

                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS CODE_SPEC,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,

                INVE_STOCK_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) AS CATE_NAME, 
                INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_WARE_CODE,
                (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = STOCK_CODE) AS STOCK_NAME, 
                (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS WARE_NAME,
                (SELECT WARE_MEDI_ROOM FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) AS MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = MEDI_ROOM) AS MEDI_NAME, 
                INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_EXPR_DATE
                FROM investock 
                WHERE INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0 
                AND INVE_STOCK_NAME LIKE '$kata%'
                OR INVE_VIEW_STAT IN ('R','Y')
                AND INVE_STOCK_QUTY > 0 
                AND (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_STOCK_TYPE) LIKE '$kata%'                
                ORDER BY INVE_STOCK_BTCH"; 
               
 }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($row = $q->fetch(PDO::FETCH_ASSOC))
{ 
    echo '<tr>';
    echo '<td style="width: 200px;">'.$row['CATE_NAME'].'</td>';
    echo '<td style="width: 200px;">'.$row['STOCK_NAME'].' '.$row['NAME_SPEC'].'</td>';
    echo '<td style="width: 100px;">'.$row['INVE_STOCK_BTCH'].'</td>';
    echo '<td style="width: 200px;">'.$row['MEDI_NAME'].'</td>';

    //data awal
    //$tgl_mulai='2021-12-30';
    $tgl_kadaluarsa=$row['INVE_EXPR_DATE'];
 
    //convert
    $timeStart = strtotime($datenow);
    $timeEnd = strtotime($tgl_kadaluarsa);
 
    // Menambah bulan ini + semua bulan pada tahun sebelumnya
    $numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
 
    // hitung selisih bulan
    $numBulan += date("m",$timeEnd)-date("m",$timeStart);

    if ($numBulan == 1)
    {
    $exprdate = formatTanggal($row['INVE_EXPR_DATE']);
    echo '<td style="width: 200px; background-color: #7f2c39;">'.$exprdate.'</td>';
    }
    else if ($numBulan > 1)
    {
      if ($numBulan <= 6)
      {
        $exprdate = formatTanggal($row['INVE_EXPR_DATE']);
        echo '<td style="width: 200px; background-color: #fffb29;">'.$exprdate.'</td>';
      }
      else
      {
        $exprdate = formatTanggal($row['INVE_EXPR_DATE']);
        echo '<td style="width: 200px; background-color: #7afb07;">'.$exprdate.'</td>'; 
      }   
    }
    else
    {
      $exprdate = formatTanggal($row['INVE_EXPR_DATE']);
      echo '<td style="width: 200px;">'.$exprdate.'</td>'; 
    }


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

    echo '</tr>';

}
?>

  </tbody>
  </table>


