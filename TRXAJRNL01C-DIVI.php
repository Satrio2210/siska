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
  <th style="width: 200px;">KODE DIVISI</th>
  <th style="width: 500px;">NAMA DIVISI</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if ($kata == '')
  {
  $xquery = "SELECT TBLE_DIVI_CODE, TBLE_DIVI_NAME 
              FROM tbledivi 
              WHERE TBLE_DIVI_STAT = 'Y'
              ORDER by TBLE_DIVI_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLE_DIVI_CODE, TBLE_DIVI_NAME 
              FROM tbledivi 
              WHERE TBLE_DIVI_NAME LIKE '$kata%'  
              AND TBLE_DIVI_STAT = 'Y'
              ORDER by TBLE_DIVI_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $divicode = $k['TBLE_DIVI_CODE'];
  $diviname = $k['TBLE_DIVI_NAME'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isidivicode(\''.$divicode.'\',\''.$diviname.'\');" 
      style="cursor:pointer">'.$k['TBLE_DIVI_CODE'].'</td>';
echo '<td style="width: 500px;" onClick="isidivicode(\''.$divicode.'\',\''.$diviname.'\');" 
      style="cursor:pointer">'.$k['TBLE_DIVI_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


