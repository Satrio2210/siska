<?php
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
  <th style="width: 100px">ANTRIAN</th>
  <th style="width: 200px">PASIEN</th>
  <th style="width: 100px">R.M.</th>
  <th style="width: 100px">TIPE</th>
  <th style="width: 200px">MEDIS</th>
  <th style="width: 100px">POLI</th>
  <th style="width: 200px">PETUGAS</th>
  <th style="width: 100px">STATUS</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME,
          TRXA_REGI_STAT, TRXA_ENTR_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER 
          FROM trxaregi
          WHERE TRXA_REGI_STAT = 'W' 
          AND TRXA_VIEW_STAT = 'Y' 
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
}
else
{
$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME,
          TRXA_REGI_STAT, TRXA_ENTR_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER 
          FROM trxaregi
          WHERE TRXA_PATI_CODE LIKE '$kata%' OR (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '$kata%' 
          AND TRXA_REGI_STAT = 'W'
          AND TRXA_VIEW_STAT = 'Y' 
          ORDER BY TRXA_REGI_LIST"; 
}

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$regicode = $k['TRXA_REGI_CODE'];
echo '<td style="width: 100px">'.$k['TRXA_REGI_LIST'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['PATI_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['TRXA_PATI_CODE'].'</td>';

$xregipaym = $k['TRXA_REGI_PAYM'];
if ($xregipaym == 'U') { $regipaym = 'Umum'; }
else if ($xregipaym == 'B') { $regipaym = 'BPJS'; }
else if ($xregipaym == 'A') { $regipaym = 'Asuransi'; }
else if ($xregipaym == 'P') { $regipaym = 'Perusahaan'; }
else if ($xregipaym == 'H') { $regipaym = 'Halodoc'; }
else { $regipaym = 'Fail get Payment'; }

echo '<td style="width: 100px">'.$regipaym.'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['DOCT_NAME'].'</td>'; echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['ENTR_USER'].'</td>';
$registat = $k['TRXA_REGI_STAT'];
if ($registat == 'W') 
  { 
    echo '<td style="width: 100px; background-color: #fbf705;"><b>Antri</b></td>';
  }
else if ($registat == 'C') 
  { 
    echo '<td style="width: 100px; background-color: #64cdcd;"><b>Periksa</b></td>';
  }
else if ($registat == 'P') 
  { 
    echo '<td style="width: 100px; background-color: #87fd65;"><b>Bayar</b></td>';
  }
else 
  { 
    echo '<td style="width: 100px;">No Status</b></td>';
  }


echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$regicode.'\');">Periksa</a>';
echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


