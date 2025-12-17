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
        <th style="width: 200px;">OPNAME CODE</th>
  <th style="width: 200px;">OPNAME CODE</th>
  <th style="width: 500px;">WAREHOUSE</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TRXA_OPNA_CODE, TRXA_OPNA_DATE, 
            TRXA_WARE_CODE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_CODE) AS WARE_NAME, 
            TRXA_OPNA_DLAY, TRXA_FINS_DATE, TRXA_OPNA_NOTE, 
            TRXA_EMPL_CODE, 
            (SELECT CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = TRXA_EMPL_CODE) AS EMPL_NAME
            FROM trxaopna 
            WHERE TRXA_OPNA_STAT = 'A' AND TRXA_VIEW_STAT='Y'
            ORDER by TRXA_OPNA_CODE";    
  }
  else
  {
  $xquery = "SELECT TRXA_OPNA_CODE, TRXA_OPNA_DATE, 
            TRXA_WARE_CODE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_CODE) AS WARE_NAME, 
            TRXA_OPNA_DLAY, TRXA_FINS_DATE, TRXA_OPNA_NOTE, 
            TRXA_EMPL_CODE, 
            (SELECT CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = TRXA_EMPL_CODE) AS EMPL_NAME
            FROM trxaopna 
            WHERE TRXA_OPNA_CODE LIKE '$kata%' AND TRXA_OPNA_STAT = 'A' AND TRXA_VIEW_STAT='Y'
            ORDER by TRXA_OPNA_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outopnacode = $k['TRXA_OPNA_CODE'];
  $outopnadate = $k['TRXA_OPNA_DATE'];
  $outwarename = $k['WARE_NAME'];
  $outwarecode = $k['TRXA_WARE_CODE'];
  $outopnadlay = $k['TRXA_OPNA_DLAY'];
  $outfinsdate = $k['TRXA_FINS_DATE'];
  $outopnanote = $k['TRXA_OPNA_NOTE'];
  $outemplname = $k['EMPL_NAME'];
  $outemplcode = $k['TRXA_EMPL_CODE'];

echo '<tr>';

echo '<td style="width: 200px;" onClick="isiopnacode(\''.$outopnacode.'\',\''.$outopnadate.'\',\''.$outwarename.'\',\''.$outwarecode.'\',\''.$outopnadlay.'\',\''.$outfinsdate.'\',\''.$outopnanote.'\',\''.$outemplname.'\',\''.$outemplcode.'\');" 
      style="cursor:pointer">'.$outwarecode.'</td>';
echo '<td style="width: 500px;" onClick="isiopnacode(\''.$outopnacode.'\',\''.$outopnadate.'\',\''.$outwarename.'\',\''.$outwarecode.'\',\''.$outopnadlay.'\',\''.$outfinsdate.'\',\''.$outopnanote.'\',\''.$outemplname.'\',\''.$outemplcode.'\');" 
      style="cursor:pointer">'.$outwarename.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


