<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
  #screen {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11;
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

  #screen tr:nth-child(even) {
    background-color: #f3f2f2;
  }

  #screen tr:hover {
    background-color: #ddd;
  }

  table tbody,
  table thead {
    display: block;
  }

  table tbody {
    overflow: auto;
    height: 300px;
  }
</style>
<table id="screen">
  <thead>
    <tr>
      <th style="width: 48px">Antri</th>
      <th style="width: 195px">Nama</th>
      <th style="width: 100px">Status</th>
      <th style="width: 100px">Action</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $dokter = $_POST['q'];
    //$kata = '';
    $panjangkata = strlen($dokter);
    if ($panjangkata == 0) {

      // TAMBAHAN: (SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
      $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_POLI,
(SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C') 
AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 20 DAY)
ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC
";
    } else {
      // TAMBAHAN: (SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
      $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_POLI,
(SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C') 
AND TRXA_REGI_DOCT = '$dokter'
AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 20 DAY)
ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC
";
    }

    $prefixMap = [
      'PU' => 'A', // Poli Umum
      'PG' => 'B', // Poli Gigi
      'KB' => 'C', // Poli KIA
      'LB' => 'D', // Laboratorium
    ];

    $namaPoliMap = [
      'PU' => 'Poli Umum',
      'PG' => 'Poli Gigi',
      'KB' => 'Poli KIA',
      'LB' => 'Laboratorium',
    ];

    $q = $db->query($xquery) or die("Gagal Maning!!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {

      echo '<tr>';
      $regicode = $k['TRXA_REGI_CODE'];
      $paticode = $k['TRXA_PATI_CODE'];

      // hitung nomor antrian full (A001, B005, dst)
      $kodePoli = $k['TRXA_REGI_POLI'];        // misal: PU / PG / PK / LB
      $prefix = isset($prefixMap[$kodePoli]) ? $prefixMap[$kodePoli] : '';
      $noantri_full = $prefix . $k['TRXA_REGI_LIST'];

      // nama poli buat suara
      $namapoli = isset($namaPoliMap[$kodePoli]) ? $namaPoliMap[$kodePoli] : 'Poli';

      // nama lengkap pasien
      $nama_lengkap = $k['PATI_TITL'] . ' ' . $k['PATI_NAME'];

      echo '<td style="width: 50px">' . $noantri_full . '</td>';
      //echo '<td style="width: 150px; text-align: left;">'.$k['TRXA_REGI_CODE'].'</td>';
      echo '<td style="width: 200px">' . $nama_lengkap . '</td>';
      //echo '<td style="width: 100px">'.$k['TRXA_PATI_CODE'].'</td>';
    
      /*$regipaym = $k['TRXA_REGI_PAYM'];
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
      }*/


      $periksa = $k['TRXA_REGI_STAT'];
      $sudah_periksa = $k['SUDAH_PERIKSA'];

      if ($periksa == 'W') {
        if ($sudah_periksa > 0) {
            // Sudah skrining TTV, tapi belum diperiksa dokter
            echo '<td style="width: 100px; background-color: #98F7FD;">Belum di periksa</td>';
        } else {
            // Belum diapa-apain (Belum skrining TTV)
            echo '<td style="width: 100px; background-color: #ffc107;">Menunggu Skrining</td>';
        }
      } else {
        // Statusnya udah bukan 'W' (Kemungkinan 'C' = Selesai)
        echo '<td style="width: 100px; background-color: #1eff00;">Sudah di periksa</td>';
      }

      //$regidate = $k['TRXA_REGI_DATE'];
    
      echo '<td style="width: 100px">';

      //if ($regidate == $datenow)
//{
      echo '<a class="button-view pure-button" onclick="viewcode(\'' . $regicode . '\',\'' . $paticode . '\');">Periksa</a>';
      echo '<a class="button-panggil pure-button"
          data-noantri="' . $noantri_full . '"
          data-nama="' . htmlspecialchars($nama_lengkap, ENT_QUOTES, 'UTF-8') . '"
          data-poli="' . $namapoli . '"
          data-channel="POLI">Panggil</a>';
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