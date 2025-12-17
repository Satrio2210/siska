<?php
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
  <th style="width: 100px">Antrian</th>
  <th style="width: 150px">Daftar</th>
  <th style="width: 200px">Nama</th>
  <th style="width: 100px">R.M.</th>
  <th style="width: 100px">Pembayaran</th>
  <th style="width: 200px">Status</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$dokter = $_POST['q'];
//$kata = '';
$panjangkata = strlen($dokter);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C')
ORDER BY TRXA_REGI_LIST
"; 
}
else
{
$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C') 
AND TRXA_REGI_DOCT = '$dokter'
ORDER BY TRXA_REGI_LIST
"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$regicode = $k['TRXA_REGI_CODE'];
$paticode = $k['TRXA_PATI_CODE'];
echo '<td style="width: 100px">'.$k['TRXA_REGI_LIST'].'</td>';
echo '<td style="width: 150px; text-align: left;">'.$k['TRXA_REGI_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['PATI_TITL'].' '.$k['PATI_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['TRXA_PATI_CODE'].'</td>';

$regipaym = $k['TRXA_REGI_PAYM'];
if ($regipaym == 'U')
{
  echo '<td style="width: 100px"> Umum </td>';  
}
else if ($regipaym == 'B')
{
  echo '<td style="width: 100px"> BPJS </td>';
}
else if ($regipaym == 'A')
{
  echo '<td style="width: 100px"> Asuransi </td>';  
}
else if ($regipaym == 'P')
{
  echo '<td style="width: 100px"> Perusahaan </td>';  
}


$periksa = $k['TRXA_REGI_STAT'];
if ( $periksa == 'W')
{
	echo '<td style="width: 200px; background-color: #98F7FD;">Belum di periksa</td>';
}
else
{
	echo '<td style="width: 200px">Sudah di periksa</td>';
}

$regidate = $k['TRXA_REGI_DATE'];

echo '<td style="width: 200px">';

if ($regidate == $datenow)
{
  echo '<a class="button-view pure-button" onclick="viewcode(\''.$regicode.'\',\''.$paticode.'\');">Periksa</a>';  
}
else
{
   echo '<b>Register Expired</b>';  

}
echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


