<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
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
  <th style="width: 100px">Klinik</th>
  <th style="width: 200px">Medis</th>
  <th style="width: 100px">Tgl Bayar</th>
  <th style="width: 150px">No. Pendaftaran</th>
  <th style="width: 150px">No. Kwitansi</th>
  <th style="width: 100px">No. RM</th>
  <th style="width: 200px">Nama</th>
  <th style="width: 100px">L/P</th>
  <th style="width: 100px">Pembayaran</th>
  <th style="width: 100px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';

$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT TRXA_SALE_CODE, TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS REGI_DOCT,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
          (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS MAIN_GEND,
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TRXA_REGI_POLI) AS REGI_POLI,
          TRXA_PAYM_MODE, TRXA_ENTR_DATE,
          (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS REGI_PAYM
          FROM trxasale WHERE TRXA_VIEW_STAT = 'Y' 
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 4 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, 
          TRXA_ENTR_TIME DESC LIMIT 10"; 
}
else
{ 
$xquery = "SELECT TRXA_SALE_CODE, TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS REGI_DOCT,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
          (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS MAIN_GEND,
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TRXA_REGI_POLI) AS REGI_POLI,
          TRXA_PAYM_MODE, TRXA_ENTR_DATE,
          (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS REGI_PAYM
          FROM trxasale WHERE TRXA_VIEW_STAT = 'Y' 
          AND (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '$kata%'
          OR TRXA_VIEW_STAT = 'Y' AND (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '%$kata%' 
          OR TRXA_VIEW_STAT = 'Y' AND TRXA_SALE_CODE LIKE '$kata%'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 4 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
               
 }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$salecode = $k['TRXA_SALE_CODE'];
$regicode = $k['REGI_CODE'];
$paticode = $k['TRXA_PATI_CODE'];
echo '<td style="width: 100px">'.$k['REGI_POLI'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['REGI_DOCT'].'</td>';
$paiddate = date("d-m-Y", strtotime($k['TRXA_ENTR_DATE']));
echo '<td style="width: 100px">'.$paiddate.'</td>';
echo '<td style="width: 150px">'.$regicode.'</td>';
echo '<td style="width: 150px">'.$salecode.'</td>';
echo '<td style="width: 100px">'.$paticode.'</td>';
echo '<td style="width: 200px">'.$k['PATI_NAME'].'</td>';

$maingend = $k['MAIN_GEND'];
if ($maingend == 'M')
{
  echo '<td style="width: 100px"> Laki-laki </td>'; 
}
else if ($maingend == 'F')
{
 echo '<td style="width: 100px"> Perempuan </td>'; 
}
else
{
 echo '<td style="width: 100px"> No gender </td>'; 
}

$regipaym = $k['REGI_PAYM'];
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
else if ($regipaym == 'H')
{
  echo '<td style="width: 100px"> Halodoc </td>';  
}

  echo '<td style="width: 100px">';
?>
<a class="pure-button button-print" onClick="javascript: location.href ='TRXASALE02P.php?regicode=<?php echo $regicode;?>&salecode=<?php echo $salecode;?>'">Print</a> 

<?php
echo '</td>';

echo '</tr>';
}
?>

  </tbody>
  </table>


