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
  <th style="width: 400px;">NAMA</th>
  <th style="width: 100px;">SATUAN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT INVE_MAST_CODE, INVE_MAIN_UNIT AS CODE_UNIT, INVE_MAIN_SPEC AS CODE_SPEC,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,  
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
              INVE_PART_NAME, INVE_DEFA_WARE AS HOUS_CODE,
              (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = HOUS_CODE) AS HOUS_NAME
              FROM invemast 
              WHERE INVE_VIEW_STAT = 'Y'
              ORDER by INVE_MAST_CODE";

  }
  else
  {
  $xquery = "SELECT INVE_MAST_CODE, INVE_MAIN_UNIT AS CODE_UNIT, INVE_MAIN_SPEC AS CODE_SPEC,
            (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = CODE_SPEC) AS NAME_SPEC,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT, 
              INVE_PART_NAME, INVE_DEFA_WARE AS HOUS_CODE,
              (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = HOUS_CODE) AS HOUS_NAME
              FROM invemast 
              WHERE INVE_PART_NAME LIKE '$kata%'  
              AND INVE_VIEW_STAT = 'Y'
              ORDER by INVE_MAST_CODE";

  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $invecode = $k['INVE_MAST_CODE'];
  $unitcode = $k['CODE_UNIT'];
  $specname = $k['NAME_SPEC'];

  $xnameunit = $k['NAME_UNIT'];

  $posisi=strpos($xnameunit,"@");

  if ($posisi)
  {
    list($nameunit,$subnameunit) = explode("@",$xnameunit);
  }
  else 
  {
    $nameunit = $xnameunit; 
  }

  $invename = $k['INVE_PART_NAME'];
  $warecode = $k['HOUS_CODE'];
  $warename = $k['HOUS_NAME'];  

echo '<tr>';
echo '<td style="width: 400px;" onClick="isiinvecode(\''.$invecode.'\',\''.$unitcode.'\',\''.$invename.'\',\''.$warecode.'\',\''.$warename.'\');" 
      style="cursor:pointer">'.$k['INVE_PART_NAME'].' '.$specname.'</td>';
echo '<td style="width: 100px;" onClick="isiinvecode(\''.$invecode.'\',\''.$unitcode.'\',\''.$invename.'\',\''.$warecode.'\',\''.$warename.'\');" 
      style="cursor:pointer">'.$nameunit.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


