<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
  #screen {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    background: #fff;
  }

  /* WRAPPER */
  .table-wrapper {
    width: 100%;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    background: white;
  }

  /* HEADER */
  #screen thead {
    position: sticky;
    top: 0;
    z-index: 2;
  }

  #screen thead tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }

  #screen th {
    padding: 16px;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    border: none;
    background: #10b981;
    color: white;
  }

  /* BODY */
  #screen tbody {
    display: block;
    max-height: 380px;
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
    scrollbar-gutter: stable;
  }

  #screen tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
    transition: .2s ease;
    background: white;
  }

  #screen tbody tr:nth-child(even) {
    background: #f9fafb;
  }

  #screen tbody tr:hover {
    background: #f3f4f6;
  }

  /* CELL */
  #screen td {
    padding: 14px 12px;
    font-size: 13px;
    border-bottom: 1px solid #edf2f7;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
  }

  /* COLUMN WIDTH */
  #screen th:nth-child(1),
  #screen td:nth-child(1) {
    width: 90px;
  }

  #screen th:nth-child(2),
  #screen td:nth-child(2) {
    width: 100px;
    /* text-align: left; */
  }

  #screen th:nth-child(3),
  #screen td:nth-child(3) {
    width: auto;
    text-align: left;
  }

  #screen th:nth-child(4),
  #screen td:nth-child(4) {
    width: 150px;
  }

  #screen th:nth-child(5),
  #screen td:nth-child(5) {
    width: 180px;
  }

  /* STATUS BADGE */
  .status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
  }

  .status-wait {
    background: #fef3c7;
    color: #b45309;
  }

  .status-process {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .status-done {
    background: #dcfce7;
    color: #15803d;
  }

  /* ACTION */
  .action-group {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .button-view,
  .button-panggil {
    border: none;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s ease;
    text-decoration: none;
  }

  .button-view {
    background: #10b981;
    color: white;
  }

  .button-view:hover {
    background: #059669;
  }

  .button-panggil {
    background: #3b82f6;
    color: white;
  }

  .button-panggil:hover {
    background: #2563eb;
  }

  /* SCROLLBAR */
  #screen tbody::-webkit-scrollbar {
    width: 8px;
  }

  #screen tbody::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 999px;
  }

  /* RESPONSIVE */
  @media(max-width:768px) {

    .table-wrapper {
      overflow-x: auto;
    }

    #screen {
      min-width: 900px;
    }

  }
</style>
<div class="table-wrapper">
  <table id="screen" class="modern-table">
    <thead>
      <tr>
        <th>Tgl Daftar</th>
        <th>No. Antrian</th>
        <th>Nama Pasien</th>
        <th>Pembayaran</th>
        <th>Status</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody>
      <?php
      $dokter = $_POST['q'];
      //$kata = '';
      $panjangkata = strlen($dokter);
      if ($panjangkata == 0) {

        // TAMBAHAN: (SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, TRXA_ENTR_TIME,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_POLI,
(SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C') 
AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC
";
      } else {
        // TAMBAHAN: (SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, TRXA_ENTR_TIME,
(SELECT PATI_MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_TITL,
(SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_STAT, TRXA_REGI_POLI,
(SELECT COUNT(*) FROM trxaexam WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS SUDAH_PERIKSA
FROM trxaregi WHERE TRXA_VIEW_STAT='Y'
AND TRXA_REGI_STAT IN ('W','C') 
AND TRXA_REGI_DOCT = '$dokter'
AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
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

        echo '<td>' . $k['TRXA_REGI_DATE'] . ' ' . $k['TRXA_ENTR_TIME'] . '</td>';

        echo '<td>' . $noantri_full . '</td>';
        //echo '<td style="width: 150px; text-align: left;">'.$k['TRXA_REGI_CODE'].'</td>';
        echo '<td>' . $nama_lengkap . '</td>';
        //echo '<td style="width: 100px">'.$k['TRXA_PATI_CODE'].'</td>';
      
        $regipaym = $k['TRXA_REGI_PAYM'];
        if ($regipaym == 'U') {
          echo '<td> Umum </td>';
        } else if ($regipaym == 'B') {
          echo '<td> BPJS </td>';
        } else if ($regipaym == 'A') {
          echo '<td> Asuransi </td>';
        } else if ($regipaym == 'P') {
          echo '<td> Perusahaan </td>';
        }
        // echo '<td>' . $regipaym . '</td>';
      
        $periksa = $k['TRXA_REGI_STAT'];
        $sudah_periksa = $k['SUDAH_PERIKSA'];

        if ($periksa == 'W') {
          if ($sudah_periksa > 0) {
            // Sudah skrining TTV, tapi belum diperiksa dokter
            echo '<td><span class="status-badge status-process">Belum di periksa</span></td>';
          } else {
            // Belum diapa-apain (Belum skrining TTV)
            echo '<td><span class="status-badge status-wait">Menunggu Skrining</span></td>';
          }
        } else {
          // Statusnya udah bukan 'W' (Kemungkinan 'C' = Selesai)
          echo '<td><span class="status-badge status-done">Sudah di periksa</span></td>';
        }

        //$regidate = $k['TRXA_REGI_DATE'];
      
        echo '<td><div class="action-group">';

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
        echo '</div></td>';

        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>