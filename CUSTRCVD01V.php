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

  <th style="width: 150px">KODE</th>
  <th style="width: 200px">NAMA</th>
  <th style="width: 100px">UNIT</th>
  <th style="width: 100px">TANGGAL</th>
  <th style="width: 100px">MEDIS</th>
  <th style="width: 100px">DAFTAR</th>
  <th style="width: 100px">BAYAR</th>
  <th style="width: 200px">TERTANGGUNG</th>
  <th style="width: 100px">ACTION</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_SALE_CODE, TRXA_REGI_CODE, TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE, 
           TRXA_PATI_CODE AS PATI_CODE, (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,  
           TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS NAME_DOCT,  
           TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TRXA_REGI_POLI) AS POLI_NAME,
           (SELECT COUNT(*) FROM trxaregi WHERE TRXA_PATI_CODE = PATI_CODE) AS COUNT_REGI,
           IF(TRXA_PAYM_MODE IS NULL OR TRXA_PAYM_MODE = '', 'empty', TRXA_PAYM_MODE) as PAYM_MODE,
           (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS PATIENT,
           DATE_FORMAT(TRXA_ENTR_DATE,'%d/%m/%Y') AS REGI_DATE 
           FROM trxasale WHERE TRXA_PAYM_MODE NOT IN ('TUN','BCA','MAN','BNI','BCM','LIN')
           AND TRXA_VIEW_STAT = 'Y'
           ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
}
else
{
$xquery = "SELECT TRXA_SALE_CODE, TRXA_REGI_CODE, TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE,
           TRXA_PATI_CODE AS PATI_CODE, (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,  
           TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS NAME_DOCT,  
           TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TRXA_REGI_POLI) AS POLI_NAME,
           (SELECT COUNT(*) FROM trxaregi WHERE TRXA_PATI_CODE = PATI_CODE) AS COUNT_REGI,
           IF(TRXA_PAYM_MODE IS NULL OR TRXA_PAYM_MODE = '', 'empty', TRXA_PAYM_MODE) as PAYM_MODE,
           (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS PATIENT,
           DATE_FORMAT(TRXA_ENTR_DATE,'%d/%m/%Y') AS REGI_DATE
           FROM trxasale WHERE TRXA_PAYM_MODE NOT IN ('TUN','BCA','MAN','BNI','BCM','LIN')
           AND TRXA_VIEW_STAT = 'Y' 
           AND (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '$kata%'

           OR TRXA_PAYM_MODE NOT IN ('TUN','BCA','MAN','BNI','BCM','LIN')
           AND TRXA_VIEW_STAT = 'Y' 
           AND (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '%$kata%'

           ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
}

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$salecode = $k['TRXA_SALE_CODE'];
$regicode = $k['REGI_CODE'];
$paticode = $k['PATI_CODE'];
echo '<td style="width: 150px">'.$salecode.'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['PATI_NAME'].'</td>';
echo '<td style="width: 100px; text-align: left;">'.$k['POLI_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['REGI_DATE'].'</td>';
echo '<td style="width: 100px; text-align: left;">'.$k['NAME_DOCT'].'</td>';
$countregi = $k['COUNT_REGI'];
if ($countregi > 1)
{
echo '<td style="width: 100px">Pasien Lama</td>';
}
else
{
echo '<td style="width: 100px">Pasien Baru</td>';  
}
$paymmode = $k['PAYM_MODE'];
if ($paymmode == 'UNP')
{
echo '<td style="width: 100px">Menunggu</td>';  
}
else
{
echo '<td style="width: 100px">Lunas</td>';    
}


$patient = $k['PATIENT'];
if ($patient == 'U')
{
echo '<td style="width: 200px">Pembayaran Mandiri</td>';  
}
else if ($patient == 'B')
{
echo '<td style="width: 200px">BPJS</td>';  
}
else if ($patient == 'A')
{
echo '<td style="width: 200px">Asuransi</td>';  
} 
else if ($patient == 'P')
{
echo '<td style="width: 200px">Perusahaan</td>';  
} 
else
{
echo '<td style="width: 200px">None</td>';  
}

echo '<td style="width: 100px">';
echo '<a class="button-view pure-button" 
              onclick="viewcode(\''.$salecode.'\',\''.$regicode.'\',\''.$paticode.'\');
              ">Periksa</a>';
echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


