<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "config.php";
include "inc/tanggal.php";
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
  <th style="width: 200px;">KODE AKUN</th>
  <th style="width: 500px;">NAMA AKUN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  $xquery = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
              FROM tblacoac 
              WHERE TBLA_COAC_CODE LIKE '$kata%'  
              AND TBLA_COAC_STAT = 'Y'
              OR TBLA_COAC_NAME LIKE '$kata%'
              AND TBLA_COAC_STAT = 'Y'
              ORDER by TBLA_COAC_CODE";

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $coaccode = $k['TBLA_COAC_CODE'];
  $coacname = $k['TBLA_COAC_NAME'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isicoaccode(\''.$coaccode.'\',\''.$coacname.'\');" 
      style="cursor:pointer">'.$k['TBLA_COAC_CODE'].'</td>';
echo '<td style="width: 500px;" onClick="isicoaccode(\''.$coaccode.'\',\''.$coacname.'\');" 
      style="cursor:pointer">'.$k['TBLA_COAC_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


