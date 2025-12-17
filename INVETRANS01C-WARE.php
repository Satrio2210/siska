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
  <th style="width: 100px;">CODE</th>
  <th style="width: 200px;">BOX</th>
  <th style="width: 200px;">LOCATION</th>
  <th style="width: 200px;">ROOM</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT WARE_HOUS_CODE, WARE_HOUS_NAME, WARE_HOUS_LOCA, WARE_MEDI_ROOM,
            (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = WARE_HOUS_LOCA) AS LOCA_NAME,
            (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = WARE_MEDI_ROOM) AS ROOM_NAME
            FROM waremast 
            WHERE WARE_HOUS_STAT = 'Y'
            ORDER by WARE_HOUS_CODE";    
  }
  else
  {
  $xquery = "SELECT WARE_HOUS_CODE, WARE_HOUS_NAME, WARE_HOUS_LOCA, WARE_MEDI_ROOM,
             (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = WARE_HOUS_LOCA) AS LOCA_NAME,
             (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = WARE_MEDI_ROOM) AS ROOM_NAME
              FROM waremast 
              WHERE WARE_HOUS_NAME LIKE '$kata%'  
              AND WARE_HOUS_STAT = 'Y'
              ORDER by WARE_HOUS_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outwarecode = $k['WARE_HOUS_CODE'];
  $outwarename = $k['WARE_HOUS_NAME'];
  $outlocaname = $k['LOCA_NAME'];
  $outroomname = $k['ROOM_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isiwarecode(\''.$outwarecode.'\',\''.$outwarename.'\',\''.$outlocaname.'\');" 
      style="cursor:pointer">'.$outwarecode.'</td>';
echo '<td style="width: 200px;" onClick="isiwarecode(\''.$outwarecode.'\',\''.$outwarename.'\',\''.$outlocaname.'\');"  
      style="cursor:pointer">'.$outwarename.'</td>';
echo '<td style="width: 200px;" onClick="isiwarecode(\''.$outwarecode.'\',\''.$outwarename.'\',\''.$outlocaname.'\');"  
      style="cursor:pointer">'.$outlocaname.'</td>';
echo '<td style="width: 200px;" onClick="isiwarecode(\''.$outwarecode.'\',\''.$outwarename.'\',\''.$outlocaname.'\');"  
      style="cursor:pointer">'.$outroomname.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


