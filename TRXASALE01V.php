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

      <th style="width: 100px">Klinik</th>
      <th style="width: 200px">Dokter</th>
      <th style="width: 100px">Tgl Daftar</th>
      <th style="width: 150px">No. Pendaftaran</th>
      <th style="width: 100px">No. RM</th>
      <th style="width: 200px">Nama</th>
      <th style="width: 100px">L/P</th>
      <th style="width: 100px">Pembayaran</th>
      <th style="width: 200px">Action</th>

    </tr>
  </thead>
  <tbody>
    <?php
    $kata = $_POST['q'];
    //$kata = '';
    $panjangkata = strlen($kata);

    $xquery = "SELECT 
          t.TRXA_REGI_CODE, 
          t.TRXA_PATI_CODE, 
          CONCAT(p.PATI_MAIN_TITL, ' ', p.PATI_MAIN_NAME) AS PATI_NAME,
          p.PATI_MAIN_GEND AS MAIN_GEND, 
          t.TRXA_REGI_LIST, 
          t.TRXA_REGI_DATE, 
          t.TRXA_REGI_PAYM, 
          t.TRXA_REGI_DOCT, 
          u.PASS_USER_NAME AS REGI_DOCT,
          t.TRXA_REGI_POLI, 
          pl.TBLA_POLI_NAME AS REGI_POLI,
          t.TRXA_ENTR_DATE   
      FROM trxaregi t
      LEFT JOIN patimast p ON p.PATI_MAST_CODE = t.TRXA_PATI_CODE
      LEFT JOIN passiden u ON u.PASS_USER_IDEN = t.TRXA_REGI_DOCT
      LEFT JOIN tblapoli pl ON pl.TBLA_POLI_CODE = t.TRXA_REGI_POLI
      WHERE t.TRXA_REGI_STAT IN ('C', 'P')
        AND t.TRXA_REGI_PAYM IN ('U', 'B') 
        AND DATE(t.TRXA_ENTR_DATE) >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)
  ";

    if ($panjangkata > 0) {
      $xquery .= " AND p.PATI_MAIN_NAME LIKE '%$kata%' ";
    }

    $xquery .= " ORDER BY t.TRXA_ENTR_DATE DESC, t.TRXA_ENTR_TIME DESC";

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
      echo '<td style="width: 100px">' . $k['REGI_POLI'] . '</td>';
      echo '<td style="width: 200px; text-align: left;">' . $k['REGI_DOCT'] . '</td>';
      $regidate = date("d-m-Y", strtotime($k['TRXA_ENTR_DATE']));
      echo '<td style="width: 100px">' . $regidate . '</td>';
      echo '<td style="width: 150px">' . $k['TRXA_REGI_CODE'] . '</td>';
      echo '<td style="width: 100px">' . $k['TRXA_PATI_CODE'] . '</td>';
      echo '<td style="width: 200px">' . $k['PATI_NAME'] . '</td>';

      $maingend = $k['MAIN_GEND'];
      if ($maingend == 'M') {
        echo '<td style="width: 100px"> Laki-laki </td>';
      } else if ($maingend == 'F') {
        echo '<td style="width: 100px"> Perempuan </td>';
      } else {
        echo '<td style="width: 100px"> No gender </td>';
      }

      $regipaym = $k['TRXA_REGI_PAYM'];
      if ($regipaym == 'U') {
        echo '<td style="width: 100px"> Umum </td>';
      } else if ($regipaym == 'B') {
        echo '<td style="width: 100px"> BPJS </td>';
      } else if ($regipaym == 'A') {
        echo '<td style="width: 100px"> Asuransi </td>';
      } else if ($regipaym == 'P') {
        echo '<td style="width: 100px"> Perusahaan </td>';
      } else if ($regipaym == 'H') {
        echo '<td style="width: 100px"> Halodoc </td>';
      }

      $regicode = $k['TRXA_REGI_CODE'];
      $paticode = $k['TRXA_PATI_CODE'];
      $pati_name = htmlspecialchars($k['PATI_NAME'], ENT_QUOTES);

      // hitung nomor antrian full (A001, B005, dst)
      $kodePoli = $k['TRXA_REGI_POLI'];       // misal: PU / PG / PK / LB
      $prefix = isset($prefixMap[$kodePoli]) ? $prefixMap[$kodePoli] : '';
      $noantri_full = $prefix . $k['TRXA_REGI_LIST'];

      // nama poli buat suara
      $namapoli = isset($namaPoliMap[$kodePoli]) ? $namaPoliMap[$kodePoli] : 'Poli';

      echo '<td style="width: 200px">
        <a class="button-panggil pure-button"
          data-noantri="' . $noantri_full . '"
          data-nama="' . htmlspecialchars($pati_name, ENT_QUOTES, 'UTF-8') . '"
          data-poli="' . $namapoli . '"
          data-channel="SALE">Panggil</a>
        
        <a class="button-view pure-button" onclick="viewcode(\'' . $regicode . '\',\'' . $paticode . '\');">Periksa
        </a>';
      //<a class="button-print pure-button" onclick="if (document.getElementById(\'hidregicode\').value == \'\')
      //   { alert(\'Pilih dahulu pasien!\'); }
      //   else
      //{ document.frmtrxasale.submit(); }">Print</a>';  
      echo '</td>';

      echo '</tr>';
    }



    ?>
  </tbody>
</table>