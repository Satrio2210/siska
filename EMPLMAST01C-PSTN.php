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
  <th style="width: 100px;">KODE POSISI</th>
  <th style="width: 200px;">NAMA POSISI</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //$kata = 'bag';
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLE_POST_CODE, TBLE_POST_NAME 
              FROM tblepost 
              WHERE TBLE_POST_STAT = 'Y'
              ORDER by TBLE_POST_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLE_POST_CODE, TBLE_POST_NAME 
              FROM tblepost 
              WHERE TBLE_POST_NAME LIKE '$kata%'  
              AND TBLE_POST_STAT = 'Y'
              ORDER by TBLE_POST_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $pstncode = $k['TBLE_POST_CODE'];
  $pstnname = $k['TBLE_POST_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isipstncode(\''.$pstncode.'\',\''.$pstnname.'\');" 
      style="cursor:pointer">'.$k['TBLE_POST_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isipstncode(\''.$pstncode.'\',\''.$pstnname.'\');" 
      style="cursor:pointer">'.$k['TBLE_POST_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


