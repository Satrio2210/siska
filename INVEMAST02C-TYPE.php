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
  <th style="width: 100px;">KODE</th>
  <th style="width: 200px;">NAMA TIPE</th>
  <th style="width: 300px;">KETERANGAN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_NOTE 
              FROM tblitype 
              WHERE TBLI_TYPE_STAT = 'Y'
              ORDER by TBLI_TYPE_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_NOTE 
              FROM tblitype 
              WHERE TBLI_TYPE_NAME LIKE '$kata%'  
              AND TBLI_TYPE_STAT = 'Y'
              ORDER by TBLI_TYPE_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outtypecode = $k['TBLI_TYPE_CODE'];
  $outtypename = $k['TBLI_TYPE_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isitypecode(\''.$outtypecode.'\',\''.$outtypename.'\');" 
      style="cursor:pointer">'.$k['TBLI_TYPE_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isitypecode(\''.$outtypecode.'\',\''.$outtypename.'\');" 
      style="cursor:pointer">'.$k['TBLI_TYPE_NAME'].'</td>';
echo '<td style="width: 300px;" onClick="isitypecode(\''.$outtypecode.'\',\''.$outtypename.'\');" 
      style="cursor:pointer">'.$k['TBLI_TYPE_NOTE'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


