<?php
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
  height: 400px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px;">Tanggal</th>
  <th style="width: 200px;">Dokter Pemeriksa</th>
  <th style="width: 100px;">Tinggi/Berat</th>
  <th style="width: 100px;">Darah/Suhu</th>
  <th style="width: 200px;">Anamnesa</th>
  <th style="width: 200px;">Pemeriksaan</th>
  <th style="width: 200px;">Diagnosa</th>
  <th style="width: 200px;">Resep</th>
  </tr>
  </thead>
  <tbody>
<?php
  $koderm = $_POST['q'];
  $xquery = "SELECT TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE AS PATI_CODE, 
            (SELECT TRXA_EXAM_HGHT FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS TINGGI,
            (SELECT TRXA_EXAM_WGHT FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS BERAT,
            (SELECT TRXA_EXAM_BLOD FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS DARAH,
            (SELECT TRXA_EXAM_TEMP FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS SUHU,
            (SELECT TRXA_EXAM_ANAM FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS ANAMNESA,
            (SELECT TRXA_EXAM_BODY FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS BODY,
            -- (SELECT TRXA_EXAM_DIAG FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS DIAGNOSA,
            (SELECT GROUP_CONCAT(CONCAT(TRXA_DIAG_CODE ,' - ', TRXA_DIAG_NAME) SEPARATOR ';<br>') FROM trxadiag WHERE TRXA_EXAM_CODE = REGI_CODE) AS DIAGNOSA,
            (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS RESEP,
            TRXA_REGI_DATE, 
            TRXA_REGI_DOCT, 
            (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME
            FROM trxaregi WHERE TRXA_PATI_CODE = '$koderm' AND TRXA_REGI_STAT = 'X' AND TRXA_REGI_POLI <> '$code_lab_room'
            ORDER BY TRXA_REGI_DATE DESC";

  $q = $db->query($xquery) or die("Gagal Ambil Data / Data Tidak di Temukan!!");
  while ($k = $q->fetch(PDO::FETCH_ASSOC))
  {
    $outregicode = $k['REGI_CODE'];
    $outregidate = date("d-m-Y", strtotime($k['TRXA_REGI_DATE']));
    $outdoctname = $k['DOCT_NAME'];
    $outtinggi = $k['TINGGI'];
    $outberat = $k['BERAT'];
    $outdarah = $k['DARAH'];
    $outsuhu = $k['SUHU'];
    $outanamnesa = $k['ANAMNESA'];
    $outbody = $k['BODY'];
    $outdiagnosa = $k['DIAGNOSA'];
    $outresep = $k['RESEP'];

    echo '<tr>';

    echo '<td style="width: 100px;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outregidate.'</td>';
    echo '<td style="width: 200px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outdoctname.'</td>';

    echo '<td style="width: 100px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outtinggi.' Cm | '.$outberat.' Kg</td>';

    echo '<td style="width: 100px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outdarah.' mmHg | '.$outsuhu.' Celcius </td>';

    echo '<td style="width: 200px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outanamnesa.'</td>';

    echo '<td style="width: 200px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outbody.'</td>';

    echo '<td style="width: 200px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outdiagnosa.'</td>';

    echo '<td style="width: 200px; text-align: left;" onClick="isikoderm(\''.$outregicode.'\',\''.$outdoctname.'\');" 
      style="cursor:pointer">'.$outresep.'</td>';

    echo '</tr>';
  }
?>
  </tbody>
  </table>


