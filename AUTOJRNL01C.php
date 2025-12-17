<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
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
  <th style="width: 150px;">KWITANSI</th>
  <th style="width: 150px;">REGISTRASI</th>
  <th style="width: 100px;">TANGGAL</th>
  <th style="width: 200px;">PASIEN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];

  $xxxquery = "SELECT a.TRXA_SALE_CODE, a.TRXA_REGI_CODE, a.TRXA_ENTR_DATE, b.PATI_MAIN_NAME FROM 
            (SELECT TRXA_SALE_CODE, TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_ENTR_DATE FROM trxasale) AS a, 
            (SELECT PATI_MAST_CODE, PATI_MAIN_NAME FROM patimast) AS b 
             WHERE a.TRXA_PATI_CODE = b.PATI_MAST_CODE AND a.TRXA_PATI_CODE LIKE '$kata%' 

             OR a.TRXA_PATI_CODE = b.PATI_MAST_CODE AND b.PATI_MAIN_NAME LIKE '$kata%'

             OR a.TRXA_PATI_CODE = b.PATI_MAST_CODE AND b.PATI_MAIN_NAME LIKE '%$kata%'";

$xquery = "SELECT TRXA_SALE_CODE, TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_ENTR_DATE, 
          (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME
          FROM trxasale 
          WHERE TRXA_PATI_CODE LIKE '$kata%' AND TRXA_PAYM_MODE <> 'UNP'
          OR (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '$kata%'
          AND TRXA_PAYM_MODE <> 'UNP'
          OR (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) LIKE '%$kata%'
          AND TRXA_PAYM_MODE <> 'UNP' 
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";



$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $salecode = $k['TRXA_SALE_CODE'];
  $regicode = $k['TRXA_REGI_CODE'];
  $paiddate = $k['TRXA_ENTR_DATE'];
  $patiname = $k['PATI_NAME'];


echo '<tr>';
echo '<td style="width: 150px;" onClick="isijrnlcode(\''.$salecode.'\',\''.$regicode.'\',\''.$paiddate.'\');" 
      style="cursor:pointer">'.$salecode.'</td>';
echo '<td style="width: 150px;" onClick="isijrnlcode(\''.$salecode.'\',\''.$regicode.'\',\''.$paiddate.'\');" 
      style="cursor:pointer">'.$regicode.'</td>';
echo '<td style="width: 100px;" onClick="isijrnlcode(\''.$salecode.'\',\''.$regicode.'\',\''.$paiddate.'\');" 
      style="cursor:pointer">'.$paiddate.'</td>';
echo '<td style="width: 200px;" onClick="isijrnlcode(\''.$salecode.'\',\''.$regicode.'\',\''.$paiddate.'\');" 
      style="cursor:pointer">'.$patiname.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


