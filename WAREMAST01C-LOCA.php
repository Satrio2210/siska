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
  <th style="width: 100px;">LOCATION CODE</th>
  <th style="width: 200px;">LOCATION NAME</th>
  <th style="width: 300px;">ADDRESS</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR 
              FROM fixeloca 
              WHERE FIXE_VIEW_STAT = 'Y'
              ORDER by FIXE_LOCA_CODE LIMIT 20";    
  }
  else
  {
  $xquery = "SELECT FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR 
              FROM fixeloca 
              WHERE FIXE_LOCA_NAME LIKE '$kata%'  
              AND FIXE_VIEW_STAT = 'Y'
              ORDER by FIXE_LOCA_CODE";        
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outlocacode = $k['FIXE_LOCA_CODE'];
  $outlocaname = $k['FIXE_LOCA_NAME'];  

echo '<tr>';
echo '<td style="width: 100px;" onClick="isilocacode(\''.$outlocacode.'\',\''.$outlocaname.'\');" 
      style="cursor:pointer">'.$k['FIXE_LOCA_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isilocacode(\''.$outlocacode.'\',\''.$outlocaname.'\');" 
      style="cursor:pointer">'.$k['FIXE_LOCA_NAME'].'</td>';
echo '<td style="width: 300px;" onClick="isilocacode(\''.$outlocacode.'\',\''.$outlocaname.'\');" 
      style="cursor:pointer">'.$k['FIXE_LOCA_ADDR'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


