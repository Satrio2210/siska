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
  <th style="width: 100px">ANTRIAN</th>
  <th style="width: 100px">TANGGAL</th>
  <th style="width: 200px">PASIEN</th>
  <th style="width: 100px">R.M.</th>
  <th style="width: 100px">TIPE</th>
  <th style="width: 200px">MEDIS</th>
  <th style="width: 100px">POLI</th>
  <th style="width: 100px">PETUGAS</th>
  <th style="width: 100px">TERDAFTAR</th>
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

$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME,
          TRXA_REGI_STAT, TRXA_ENTR_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER 
          FROM trxaregi
          WHERE TRXA_REGI_STAT IN ('W','C','P') 
          AND TRXA_VIEW_STAT = 'Y'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
}
else
{
$xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, 
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME,
          TRXA_REGI_STAT, TRXA_ENTR_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER 
          FROM trxaregi
          WHERE (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '$kata%' 
          AND TRXA_REGI_STAT IN ('W','C','P')
          AND TRXA_VIEW_STAT = 'Y'
          OR (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '%$kata%' 
          AND TRXA_REGI_STAT IN ('W','C','P')
          AND TRXA_VIEW_STAT = 'Y'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
          ORDER BY TRXA_REGI_LIST"; 
}

    // Mapping kode poli ke prefix antrian
    $prefixMap = [
      'PU' => 'A', // Poli Umum
      'PG' => 'B', // Poli Gigi
      'KB' => 'C', // Poli KIA
      'LB' => 'D', // Laboratorium
    ];
    // End Mapping kode poli ke prefix antrian

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$regicode = $k['TRXA_REGI_CODE'];

// hitung nomor antrian full (A001, B005, dst)
      $kodePoli = $k['TRXA_REGI_POLI'];        // misal: PU / PG / PK / LB
      $prefix = isset($prefixMap[$kodePoli]) ? $prefixMap[$kodePoli] : '';
      $noantri_full = $prefix . $k['TRXA_REGI_LIST'];

echo '<td style="width: 100px">' . $noantri_full . '</td>';
echo '<td style="width: 100px">'.$k['REGI_DATE'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['PATI_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['TRXA_PATI_CODE'].'</td>';

$xregipaym = $k['TRXA_REGI_PAYM'];
if ($xregipaym == 'U') { $regipaym = 'Umum'; }
else if ($xregipaym == 'B') { $regipaym = 'BPJS'; }
else if ($xregipaym == 'A') { $regipaym = 'Asuransi'; }
else if ($xregipaym == 'P') { $regipaym = 'Perusahaan'; }
else if ($xregipaym == 'H') { $regipaym = 'Halodoc'; }
else { $regipaym = 'Fail get Payment'; }

if ($xregipaym == 'B')
{
    echo '<td style="width: 100px; background-color: #05c1ff;" ><b>'.$regipaym.'</b></td>';
}
else 
{
    echo '<td style="width: 100px">'.$regipaym.'</td>';
}
echo '<td style="width: 200px; text-align: left;">'.$k['DOCT_NAME'].'</td>'; echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['ENTR_USER'].'</td>';
$tanggal_daftar = $k['TRXA_REGI_DATE'];

if ($tanggal_daftar == $datenow) 
{
echo '<td style="width: 100px">Hari ini</td>';	
}
else
{
$hasil_hitung_tanggal = hitungTanggal($tanggal_daftar, $datenow);


echo '<td style="width: 100px">'.$hasil_hitung_tanggal.' hari lalu</td>';	

}

$regipaym = $k['TRXA_REGI_PAYM'];
$registat = $k['TRXA_REGI_STAT'];
if ($registat == 'W') 
  { 
    echo '<td style="width: 100px; background-color: #fbf705;"><b>Antri</b></td>';
  }
else if ($registat == 'C' && $regipaym == 'U') 
  { 
    echo '<td style="width: 100px; background-color: #64cdcd;"><b>Periksa</b></td>';
  }
else if ($registat == 'P') 
  { 
    echo '<td style="width: 100px; background-color: #00ff08;"><b>Bayar</b></td>';
  }
else if ($registat == 'C' && $regipaym == 'B') 
  { 
    echo '<td style="width: 100px; background-color: #a7fc00;"><b>Selesai</b></td>';
  }
else 
  { 
    echo '<td style="width: 100px;">No Status</b></td>';
  }
  
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$regicode.'\');">Update</a>';

echo '<a class="button-print pure-button" href="print.php?nomor='.$noantri_full.'&pasien='.urlencode($k['PATI_NAME']).'&layanan='.urlencode($k['POLI_NAME']).'" target="_blank"> Antrian </a>';

if ($registat == 'C')
{
echo '<a class="button-delete pure-button" 
              onclick="alert(\'Pemeriksaan Belum lengkap ?\');
              ">Closing</a>';  

}
else
{
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$regicode.'\');}
              else
              { document.getElementById(\'txtsearch\').focus();}
              ">Closing</a>';  
}

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


