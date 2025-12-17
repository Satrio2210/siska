<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
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
  <th style="width: 100px">Nomor PO</th>
  <th style="width: 250px">Nama Item</th>
  <th style="width: 150px">Qty Order</th>
  <th style="width: 150px">Qty Terima</th>
  <th style="width: 150px">Tgl Order</th>
  <th style="width: 200px">Kotak Penerima</th>
  <th style="width: 200px">Pemeriksa</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT ITEM_PROC_CODE, ITEM_PART_CODE, 
(SELECT TRXA_PROC_DUED FROM trxaproc WHERE TRXA_PROC_CODE = ITEM_PROC_CODE) AS EXPIRED_DATE, 
(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS PART_NAME,
(SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS SPEC_CODE,
(SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS PART_UNIT, 
ITEM_QUTY_ORDR, 
IF(ITEM_QUTY_RCVE IS NULL, '0', ITEM_QUTY_RCVE) AS QUTY_RCVE, 
ITEM_PART_PRIC, ITEM_ARRV_REQU, 
ITEM_WARE_CODE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = ITEM_WARE_CODE) AS WARE_NAME,
ITEM_EMPL_CODE, 
IF((SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = ITEM_EMPL_CODE) IS NULL,'Belum diperiksa',(SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = ITEM_EMPL_CODE))  AS EMPL_NAME
FROM itemproc WHERE ITEM_VIEW_STAT='Y'
ORDER BY ITEM_ENTR_DATE DESC, ITEM_ENTR_TIME, ITEM_PROC_CODE
"; 
}
else
{
$xquery = "SELECT ITEM_PROC_CODE, ITEM_PART_CODE, 
(SELECT TRXA_PROC_DUED FROM trxaproc WHERE TRXA_PROC_CODE = ITEM_PROC_CODE) AS EXPIRED_DATE, 
(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS PART_NAME,
(SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS SPEC_CODE,
(SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS PART_UNIT,
ITEM_QUTY_ORDR, 
IF(ITEM_QUTY_RCVE IS NULL, '0', ITEM_QUTY_RCVE) AS QUTY_RCVE, 
ITEM_PART_PRIC, ITEM_ARRV_REQU, 
ITEM_WARE_CODE, (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = ITEM_WARE_CODE) AS WARE_NAME,
ITEM_EMPL_CODE, 
IF((SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = ITEM_EMPL_CODE) IS NULL,'Belum diperiksa',(SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = ITEM_EMPL_CODE))  AS EMPL_NAME 
FROM itemproc WHERE ITEM_VIEW_STAT='Y' AND ITEM_PROC_CODE LIKE '$kata%'
ORDER BY ITEM_ENTR_DATE DESC, ITEM_ENTR_TIME, ITEM_PROC_CODE
"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$proccode = $k['ITEM_PROC_CODE'];
$partcode = $k['ITEM_PART_CODE'];
$expireddate = $k['EXPIRED_DATE'];
echo '<td style="width: 100px">'.$k['ITEM_PROC_CODE'].'</td>';
echo '<td style="width: 250px; text-align: left;">'.$k['PART_NAME'].' '.$k['SPEC_NAME'].'</td>';

$qutyordr = number_format($k['ITEM_QUTY_ORDR'], 0, '', '.');
$qutyrcve = number_format($k['QUTY_RCVE'], 0, '', '.');

$insent = $k['ITEM_QUTY_ORDR'];
$inreceive = $k['QUTY_RCVE'];
if ( $insent == $inreceive)
{
	echo '<td style="width: 150px; background-color: #98F7FD;">'.$qutyordr.' '.$k['PART_UNIT'].'</td>';
	echo '<td style="width: 150px; background-color: #98F7FD;">'.$qutyrcve.' '.$k['PART_UNIT'].'</td>';
}
else
{
	echo '<td style="width: 150px">'.$qutyordr.' '.$k['PART_UNIT'].'</td>';
	echo '<td style="width: 150px">'.$qutyrcve.' '.$k['PART_UNIT'].'</td>';	
}

$datearrvrequ = formatTanggal($k['ITEM_ARRV_REQU']);

echo '<td style="width: 150px">'.$datearrvrequ.'</td>';
echo '<td style="width: 200px">'.$k['WARE_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['EMPL_NAME'].'</td>';

echo '<td style="width: 200px">';

//$expiredorder = kadaluarsa($datenow, $expireddate);
//if ($expiredorder == 0) 
//{
echo '<a class="button-view pure-button" onclick="viewcode(\''.$proccode.'\',\''.$partcode.'\');">Checker</a>';
//}
//else if ($expiredorder == 1)
//{
//echo '<b>Purchasing Expired</b>';
//}
//else
//{
//echo '<a class="pure-button">Checker</a>';  
//}  

$outsent = $k['ITEM_QUTY_ORDR'];
$outreceive = $k['QUTY_RCVE'];
if ($outsent == $outreceive)
{
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Close ?\'))
              { hapuscode(\''.$proccode.'\',\''.$partcode.'\');}
              else
              { document.getElementById(\'txtproccode\').focus();}
              ">Close</a>';  
}
else
{
echo '<a class="pure-button">Close</a>';  
}

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


