<?php
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
  <th style="width: 500px;">E-RESEP</th>
  </tr>
  </thead>
  <tbody>
<?php
  $rawdata = $_POST['q'];
  list($kata, $regipoli) = explode("|",$rawdata);

  if (strlen($kata) == 1)
  {

  $xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC 
              FROM investock 
              WHERE INVE_WARE_CODE = '$gudang_farmasi' 
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_NAME";    

  }
  else
  {
  $xquery = "SELECT INVE_STOCK_CODE, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC   
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) = 'ST'  
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_NAME";        
  }


$q = $db->query($xquery) or die("Gagal ambil item Tindakan !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outstockcode = $k['INVE_STOCK_CODE'];
  $outstockname = $k['INVE_STOCK_NAME'];
  $outstockpric = $k['INVE_STOCK_PRIC'];
  $outstockquty = $k['INVE_STOCK_QUTY'];


echo '<tr>';
echo '<td style="width: 500px;" onClick="isiresep(\''.$outstockcode.'\',\''.$outstockname.'\',\''.$outstockpric.'\',\''.$outstockquty.'\');" 
      style="cursor:pointer">'.$k['INVE_STOCK_NAME'].' '.$k['NAME_SPEC'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


