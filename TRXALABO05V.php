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
  <th style="width: 150px">No. Pemeriksaan</th>
  <th style="width: 100px">Tgl Daftar</th>
  <th style="width: 100px">Unit Asal</th>
  <th style="width: 100px">RM</th>
  <th style="width: 300px">Nama Pasien</th>
  <th style="width: 100px">Penjamin</th>
  <th style="width: 100px">Status Bayar</th>
  <th style="width: 100px">Antrian</th>
  <th style="width: 100px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$rawdata = $_POST['q'];

list($kata, $nakes) = explode("|",$rawdata);

//$nakes = $_POST['q'];

$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE AS PATI_CODE, TRXA_REGI_DATE AS REGI_DATE,
          (SELECT TRXA_REGI_POLI FROM trxaregi 
           WHERE TRXA_PATI_CODE = PATI_CODE AND TRXA_REGI_DATE = REGI_DATE
           ORDER BY TRXA_ENTR_DATE, TRXA_ENTR_TIME LIMIT 1) AS POLI_CODE,
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=POLI_CODE) AS POLI_NAME,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,
            TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_LIST
           FROM trxaregi 
          WHERE TRXA_REGI_STAT <> 'X'
          AND TRXA_REGI_DOCT = '$nakes'
          AND TRXA_REGI_POLI = '$code_lab_room' 
          AND TRXA_VIEW_STAT='Y'
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";

}
else
{
$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE AS PATI_CODE, TRXA_REGI_DATE AS REGI_DATE,
          (SELECT TRXA_REGI_POLI FROM trxaregi 
            WHERE TRXA_PATI_CODE = PATI_CODE AND TRXA_REGI_DATE = REGI_DATE
            ORDER BY TRXA_ENTR_DATE, TRXA_ENTR_TIME LIMIT 1) AS POLI_CODE,
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=POLI_CODE) AS POLI_NAME,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,
          TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_LIST
          FROM trxaregi 
          WHERE  (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '%$kata%'
          AND TRXA_REGI_STAT <> 'X'
          AND TRXA_REGI_DOCT = '$nakes' 
          AND TRXA_REGI_POLI = '$code_lab_room'
          AND TRXA_VIEW_STAT='Y' 
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";

}

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$regicode = $k['TRXA_REGI_CODE'];
$paticode = $k['PATI_CODE'];
echo '<td style="width: 150px">'.$regicode.'</td>';
echo '<td style="width: 100px; text-align: left;">'.$k['REGI_DATE'].'</td>';
echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';
echo '<td style="width: 100px">'.$paticode.'</td>';
echo '<td style="width: 300px; text-align: left;">'.$k['PATI_NAME'].'</td>';

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
if ( $periksa == 'P')
{
	echo '<td style="width: 100px; background-color: #98F7FD;">Lunas</td>';
}
else
{
	echo '<td style="width: 100px">Belum Lunas</td>';
}

echo '<td style="width: 100px">'.$k['TRXA_REGI_LIST'].'</td>';
//$regidate = $k['TRXA_REGI_DATE'];

echo '<td style="width: 100px">';

//if ($regidate == $datenow)
//{
  echo '<a class="button-view pure-button" onclick="viewcode(\''.$regicode.'\',\''.$paticode.'\');">Periksa</a>';  
//}
//else
//{
//   echo '<b>Register Expired</b>';  

//}
echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


