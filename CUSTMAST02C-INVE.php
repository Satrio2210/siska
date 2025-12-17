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
  <th style="width: 400px;">NAMA ITEM</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];

  if (strlen($kata) == 1)
  {

  $xquery = "SELECT INVE_MAST_CODE, INVE_PART_NAME, INVE_MAIN_SPEC, 
            (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=INVE_MAIN_SPEC) AS SPEC_NAME
            FROM invemast WHERE INVE_PART_TYPE='ST' AND INVE_VIEW_STAT='Y'
            ORDER BY INVE_MAST_CODE LIMIT 10";            
  }
  else
  {
  $xquery = "SELECT INVE_MAST_CODE, INVE_PART_NAME, INVE_MAIN_SPEC, 
            (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=INVE_MAIN_SPEC) AS SPEC_NAME
            FROM invemast WHERE INVE_PART_TYPE='ST' AND INVE_VIEW_STAT='Y'
            AND INVE_PART_NAME LIKE '$kata%'
            OR INVE_PART_TYPE='ST' AND INVE_VIEW_STAT='Y'
            AND INVE_PART_NAME LIKE '%$kata%'
            ORDER BY INVE_MAST_CODE";            
  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  //$coaccode = $k['COAC_MAST_CODE'];
  $invecode = $k['INVE_MAST_CODE'];
  $invename = $k['INVE_PART_NAME'] .' '.$k['SPEC_NAME'];

echo '<tr>';
echo '<td style="width: 400px;" onClick="isiinvecode(\''.$invecode.'\',\''.$invename.'\');" 
      style="cursor:pointer">'.$invename.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


