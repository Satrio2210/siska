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
  <th style="width: 200px;">KODE</th>
  <th style="width: 300px;">NAMA</th>
  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];

if (strlen($kata) == 1)
{
  $xquery = "SELECT INVE_MAST_CODE, INVE_MAIN_TYPE, 
            (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_MAIN_TYPE ) AS TYPE_NAME,
            INVE_MAIN_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT ) AS UNIT_NAME,
            INVE_SALE_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_SALE_UNIT ) AS SALE_UNIT,
            INVE_MAIN_SPEC, (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = INVE_MAIN_SPEC ) AS SPEC_NAME,
            INVE_MAIN_VARN, (SELECT TBLI_VARN_NAME FROM tblivarn WHERE TBLI_VARN_CODE = INVE_MAIN_VARN ) AS VARN_NAME,
            INVE_WITH_SRNM, INVE_PART_TYPE, INVE_COST_FRGT, INVE_PART_NAME, INVE_PART_ALAS, 
            INVE_DEFA_WARE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_DEFA_WARE ) AS HOUS_NAME, 
            INVE_STOCK_MINI, INVE_MAIN_NOTE, INVE_MAIN_PRIC, INVE_GRTE_TYPE, INVE_GRTE_LIMT, INVE_EXCE_RCVE, INVE_LACK_RCVE
FROM invemast
WHERE INVE_VIEW_STAT = 'Y'";
}
else
{
  $xquery = "SELECT INVE_MAST_CODE, INVE_MAIN_TYPE, 
            (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_MAIN_TYPE ) AS TYPE_NAME,
            INVE_MAIN_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT ) AS UNIT_NAME,
            INVE_SALE_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_SALE_UNIT ) AS SALE_UNIT,
            INVE_MAIN_SPEC, (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = INVE_MAIN_SPEC ) AS SPEC_NAME,
            INVE_MAIN_VARN, (SELECT TBLI_VARN_NAME FROM tblivarn WHERE TBLI_VARN_CODE = INVE_MAIN_VARN ) AS VARN_NAME,
            INVE_WITH_SRNM, INVE_PART_TYPE, INVE_COST_FRGT, INVE_PART_NAME, INVE_PART_ALAS, 
            INVE_DEFA_WARE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = INVE_DEFA_WARE ) AS HOUS_NAME, 
            INVE_STOCK_MINI, INVE_MAIN_NOTE, INVE_MAIN_PRIC, INVE_GRTE_TYPE, INVE_GRTE_LIMT, INVE_EXCE_RCVE, INVE_LACK_RCVE
FROM invemast
WHERE INVE_VIEW_STAT = 'Y'
AND INVE_PART_NAME LIKE '$kata%'";
}

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $mastcode = $k['INVE_MAST_CODE'];
  $typename = $k['TYPE_NAME'];
  $typecode = $k['INVE_MAIN_TYPE'];

  $unitname = $k['UNIT_NAME'];
  $unitcode = $k['INVE_MAIN_UNIT'];

  $saleunitname = $k['SALE_UNIT'];
  $saleunitcode = $k['INVE_SALE_UNIT'];

  $specname = $k['SPEC_NAME'];
  $speccode = $k['INVE_MAIN_SPEC'];
  $varnname = $k['VARN_NAME'];
  $varncode = $k['INVE_MAIN_VARN'];
  $withsrnm = $k['INVE_WITH_SRNM'];
  $parttype = $k['INVE_PART_TYPE'];
  $costfrgt = $k['INVE_COST_FRGT'];
  $partname = $k['INVE_PART_NAME'];
  $partalas = $k['INVE_PART_ALAS'];
  $housname = $k['HOUS_NAME'];
  $houscode = $k['INVE_DEFA_WARE'];
  $stockmini = $k['INVE_STOCK_MINI'];
  $mainnote = $k['INVE_MAIN_NOTE'];
  $mainpric = $k['INVE_MAIN_PRIC'];
  $grtetype = $k['INVE_GRTE_TYPE'];
  $grtelimt = $k['INVE_GRTE_LIMT'];
  $excercve = $k['INVE_EXCE_RCVE'];
  $lackrcve = $k['INVE_LACK_RCVE'];
echo '<tr>';

echo '<td style="width: 200px;" onClick="isiinvemastcode(\''.$mastcode.'\',\''.$typename.'\',\''.$typecode.'\',\''.$unitname.'\',\''.$unitcode.'\',\''.$saleunitname.'\',\''.$saleunitcode.'\',\''.$specname.'\',\''.$speccode.'\',\''.$varnname.'\',\''.$varncode.'\',\''.$withsrnm.'\',\''.$parttype.'\',\''.$costfrgt.'\',\''.$partname.'\',\''.$partalas.'\',\''.$housname.'\',\''.$houscode.'\',\''.$stockmini.'\',\''.$mainnote.'\',\''.$mainpric.'\',\''.$grtetype.'\',\''.$grtelimt.'\',\''.$excercve.'\',\''.$lackrcve.'\');" 
      style="cursor:pointer">'.$k['INVE_MAIN_TYPE'].'-'.$k['INVE_MAIN_SPEC'].$k['INVE_MAST_CODE'].'-'.$k['INVE_MAIN_VARN'].'</td>';

echo '<td style="width: 300px;" onClick="isiinvemastcode(\''.$mastcode.'\',\''.$typename.'\',\''.$typecode.'\',\''.$unitname.'\',\''.$unitcode.'\',\''.$saleunitname.'\',\''.$saleunitcode.'\',\''.$specname.'\',\''.$speccode.'\',\''.$varnname.'\',\''.$varncode.'\',\''.$withsrnm.'\',\''.$parttype.'\',\''.$costfrgt.'\',\''.$partname.'\',\''.$partalas.'\',\''.$housname.'\',\''.$houscode.'\',\''.$stockmini.'\',\''.$mainnote.'\',\''.$mainpric.'\',\''.$grtetype.'\',\''.$grtelimt.'\',\''.$excercve.'\',\''.$lackrcve.'\');" 
      style="cursor:pointer">'.$k['INVE_PART_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


