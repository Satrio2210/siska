<?php
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
  <th style="width: 150px">CODE</th>
  <th style="width: 200px">NAME</th>
  <th style="width: 200px">KEMASAN</th>
  <th style="width: 200px">SPESIFIKASI</th>
  <th style="width: 200px">KATEGORI</th>
  <th style="width: 100px">ALOKASI</th>
  <th style="width: 150px">MANUFAKTUR</th>
  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT INVE_MAST_CODE, 
          INVE_MAIN_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_MAIN_TYPE) AS NAME_TYPE, 
          INVE_MAIN_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT) AS NAME_UNIT,
          (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT) AS AMNT_UNIT,  
          INVE_MAIN_SPEC, (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = INVE_MAIN_SPEC) AS NAME_SPEC, 
          INVE_MAIN_VARN, (SELECT TBLI_VARN_NAME FROM tblivarn WHERE TBLI_VARN_CODE = INVE_MAIN_VARN) AS NAME_VARN, 
          INVE_PART_TYPE, INVE_PART_NAME, INVE_PART_ALAS
          FROM invemast WHERE INVE_VIEW_STAT = 'Y' ORDER BY INVE_MAST_CODE";
}
else
{ 
$xquery = "SELECT INVE_MAST_CODE, 
          INVE_MAIN_TYPE, (SELECT TBLI_TYPE_NAME FROM tblitype WHERE TBLI_TYPE_CODE = INVE_MAIN_TYPE) AS NAME_TYPE, 
          INVE_MAIN_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT) AS NAME_UNIT,
          (SELECT TBLI_UNIT_DEVI FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_MAIN_UNIT) AS AMNT_UNIT,  
          INVE_MAIN_SPEC, (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = INVE_MAIN_SPEC) AS NAME_SPEC, 
          INVE_MAIN_VARN, (SELECT TBLI_VARN_NAME FROM tblivarn WHERE TBLI_VARN_CODE = INVE_MAIN_VARN) AS NAME_VARN, 
          INVE_PART_TYPE, INVE_PART_NAME, INVE_PART_ALAS
          FROM invemast 
          WHERE INVE_PART_NAME LIKE '$kata%' AND INVE_VIEW_STAT = 'Y'
          OR INVE_PART_ALAS LIKE '$kata%' AND INVE_VIEW_STAT = 'Y' 
          ORDER BY INVE_MAST_CODE";
}

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
// Struktur Kode = TYPE-SPEC CODE-VARN
$mastcode = $k['INVE_MAIN_TYPE'].'-'.$k['INVE_MAIN_SPEC'].$k['INVE_MAST_CODE'].'-'.$k['INVE_MAIN_VARN'];
echo '<td style="width: 150px">'.$mastcode.'</td>';
echo '<td style="width: 200px">'.$k['INVE_PART_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['NAME_UNIT'].'/'.$k['AMNT_UNIT'].'</td>';
echo '<td style="width: 200px">'.$k['NAME_VARN'].' - '.$k['NAME_SPEC'].'</td>';
echo '<td style="width: 200px">'.$k['NAME_TYPE'].'</td>';
if ($k['INVE_PART_TYPE'] == 'ST') { $parttype = 'Stock';}
else if ($k['INVE_PART_TYPE'] == 'NS') { $parttype = 'Non Stock';}
else if ($k['INVE_PART_TYPE'] == 'FA') { $parttype = 'Fixed Asset';}
else {$parttype = 'None';}
echo '<td style="width: 100px">'.$parttype.'</td>';
echo '<td style="width: 150px">'.$k['INVE_PART_ALAS'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


