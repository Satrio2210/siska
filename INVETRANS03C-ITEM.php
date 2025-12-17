<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>
<style>
#screen {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#screen td, #screen th {
    border: 1px solid #ddd;
    padding: 4px;
}


#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

#screen th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}
#screen tbody, #screen thead
{
    display:block;
}
#screen tbody 
{
  overflow: auto;
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 200px;">NAMA ITEM</th>
  <th style="width: 100px;">QUANTITY</th>
  <th style="width: 150px;">BATCH</th>
  </tr>
  </thead>
  <tbody>
<?php
  $rawinput = $_POST['q'];
  list($item,$ware) = explode("|", $rawinput);
// untuk sementara menampilkan item yang belum dan sudah di bayar...
  // untuk running tampil item hanya yang sudah di bayar

  if (strlen($item) == 1)
  {

  $xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_QUTY,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC, 

              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = INVE_STOCK_CODE) AS PART_UNIT,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=PART_UNIT) AS PART_NAME, 
              IF(INVE_STOCK_SRNM='', 'noserial',INVE_STOCK_SRNM) AS STOCK_SRNM, 
              IF(INVE_STOCK_BTCH='','nobatch',INVE_STOCK_BTCH) AS STOCK_BTCH              
              FROM investock 
              WHERE INVE_WARE_CODE = '$ware' AND INVE_VIEW_STAT IN('Y','R')
              AND INVE_STOCK_QUTY > 0               
              ORDER by INVE_STOCK_CODE";     
  }
  else
  {
  $xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_QUTY,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC, 

              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = INVE_STOCK_CODE) AS PART_UNIT,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=PART_UNIT) AS PART_NAME, 
              IF(INVE_STOCK_SRNM='', 'noserial',INVE_STOCK_SRNM) AS STOCK_SRNM, 
              IF(INVE_STOCK_BTCH='','nobatch',INVE_STOCK_BTCH) AS STOCK_BTCH              
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$item%' AND INVE_WARE_CODE = '$ware' AND INVE_VIEW_STAT IN('Y','R')
              AND INVE_STOCK_QUTY > 0               
              ORDER by INVE_STOCK_CODE";     

  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  // outstockname, outstockcode, outstockquty, outpartunit, outstocksrnm, outstockbtch
  $stockcode = $k['INVE_STOCK_CODE'];
  $stockname = $k['INVE_STOCK_NAME'];
  $specname = $k['NAME_SPEC']; 
  $stockquty = $k['INVE_STOCK_QUTY'];
  $partunit = $k['PART_UNIT'];
  $partname = $k['PART_NAME']; 
  $stocksrnm = $k['STOCK_SRNM'];
  $stockbtch = $k['STOCK_BTCH'];


echo '<tr>';

echo '<td style="width: 200px;" onClick="isiitemcode(\''.$stockcode.'\',\''.$stockname.'\',\''.$stockquty.'\',
                                                      \''.$partunit.'\',\''.$stocksrnm.'\',\''.$stockbtch.'\');" 
      style="cursor:pointer">'.$stockname.' '.$specname.'</td>';

echo '<td style="width: 100px;" onClick="isiinvecode(\''.$stockcode.'\',\''.$stockname.'\',\''.$stockquty.'\',
                                                      \''.$partunit.'\',\''.$stocksrnm.'\',\''.$stockbtch.'\');" 
      style="cursor:pointer">'.$stockquty.' '.$partname.'</td>';

echo '<td style="width: 150px;" onClick="isiinvecode(\''.$stockcode.'\',\''.$stockname.'\',\''.$stockquty.'\',
                                                      \''.$partunit.'\',\''.$stocksrnm.'\',\''.$stockbtch.'\');" 
      style="cursor:pointer">'.$stockbtch.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


