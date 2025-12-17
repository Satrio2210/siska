<?php
include "conf/config.php";
include "inc/sanie.php";
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
  <th style="width: 510px;">LIST-OBAT</th>
  </tr>
    <thead>
        <tr>
          <th style="width: 250px">Nama Obat</th>
          <th style="width: 250px">Harga Jual</th>
    </thead>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //list($kata, $regipoli) = explode("|",$rawdata);

  if (strlen($kata) == 1)
  {


  $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_PRIC, 
              (INVE_STOCK_PRIC * '$profit') AS PRICE_RITEL, INVE_STOCK_QUTY,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC  
              FROM investock 
              WHERE INVE_WARE_CODE = '$gudang_farmasi'
              AND INVE_STOCK_QUTY > 0 
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST','NS')
              AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=INVE_STOCK_CODE)
                  ) = 'FG'
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_CODE, INVE_ENTR_DATE DESC";    

  }
  else
  {
  $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_PRIC, 
             (INVE_STOCK_PRIC * '$profit') AS PRICE_RITEL, INVE_STOCK_QUTY, 
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC  
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND INVE_STOCK_QUTY > 0
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST','NS')
              AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=INVE_STOCK_CODE)
                  ) = 'FG'
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_CODE, INVE_ENTR_DATE DESC";        
  }


$q = $db->query($xquery) or die("Gagal ambil item Obat !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outstockcode = $k['INVE_STOCK_CODE'];
  $outstockname = $k['INVE_STOCK_NAME'];

  $xharga = round($k['PRICE_RITEL']);
  $int = (int)$xharga;

  $price_ritel = pembulatan($int);

  $view_price_ritel = number_format($price_ritel,0,',','.');

  //$outstockpric = number_format($k['INVE_STOCK_PRIC'], 0, '', '.');
  $outstockquty = $k['INVE_STOCK_QUTY'];

echo '<tr>';
//echo '<td style="width: 500px;" onClick="isiobat(\''.$outstockcode.'\',\''.$outstockname.'\',\''.$view_price_ritel.'\',\''.$outstockquty.'\');" 
//      style="cursor:pointer">'.$k['INVE_STOCK_NAME'].' ' .$k['NAME_SPEC']. '</td>';

echo '<td style="width: 250px;" onClick="isiobat(\''.$outstockcode.'\',\''.$outstockname.'\');" 
      style="cursor:pointer">'.$k['INVE_STOCK_NAME'].' ' .$k['NAME_SPEC'].'</td>';
echo '<td style="width: 250px;" onClick="isiobat(\''.$outstockcode.'\',\''.$outstockname.'\');" 
      style="cursor:pointer">Rp. '.$view_price_ritel.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


