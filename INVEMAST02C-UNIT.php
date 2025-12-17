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
  <th style="width: 100px;">KODE UNIT</th>
  <th style="width: 200px;">NAMA UNIT</th>
  <th style="width: 100px;">JUMLAH UNIT</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //$kata = 'B';
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLI_UNIT_CODE, TBLI_UNIT_NAME, TBLI_UNIT_DEVI 
              FROM tbliunit 
              WHERE TBLI_UNIT_STAT = 'Y'
              ORDER by TBLI_UNIT_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLI_UNIT_CODE, TBLI_UNIT_NAME, TBLI_UNIT_DEVI 
              FROM tbliunit 
              WHERE TBLI_UNIT_NAME LIKE '$kata%'  
              AND TBLI_UNIT_STAT = 'Y'
              ORDER by TBLI_UNIT_CODE";    
  }

 //var_dump($xquery);
 //exit();         

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outunitcode = $k['TBLI_UNIT_CODE'];
  $outunitname = $k['TBLI_UNIT_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isiunitcode(\''.$outunitcode.'\',\''.$outunitname.'\');" 
      style="cursor:pointer">'.$k['TBLI_UNIT_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isiunitcode(\''.$outunitcode.'\',\''.$outunitname.'\');" 
      style="cursor:pointer">'.$k['TBLI_UNIT_NAME'].'</td>';
echo '<td style="width: 100px;" onClick="isiunitcode(\''.$outunitcode.'\',\''.$outunitname.'\');" 
      style="cursor:pointer">'.$k['TBLI_UNIT_DEVI'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


