<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
  /* #screen {
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
  } */

  #screen {
    width: 100%;
    border-collapse: collapse;
    min-width: 1200px;
    table-layout: fixed;
  }

  #screen thead {
    background: #10b981;
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  /* HEADER */
  .table-pasien #screen th {
    padding: 14px 12px;
    font-size: 13px;
    border-bottom: 1px solid #edf2f7;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
  }

  /* CELL */
  .table-pasien #screen td {
    padding: 14px 12px;
    font-size: 13px;
    border-bottom: 1px solid #edf2f7;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
  }

  /* COLUMN WIDTH */

  /* TANGGAL DAFTAR */
  /* #screen th:nth-child(1),
  #screen td:nth-child(1) {
    width: 60px;
  } */

  /* TERDAFTAR */
  #screen th:nth-child(1),
  #screen td:nth-child(1) {
    width: 60px;
  }

  /* NOMOR ANTRIAN */
  #screen th:nth-child(2),
  #screen td:nth-child(2) {
    width: 50px;
  }

  /* NAMA PASIEN */
  #screen th:nth-child(3),
  #screen td:nth-child(3) {
    width: 180px;
    text-align: center;
  }

  /* PEMBAYARAN */
  #screen th:nth-child(4),
  #screen td:nth-child(4) {
    width: 50px;
  }

  /* DOKTER */
  #screen th:nth-child(5),
  #screen td:nth-child(5) {
    width: 150px;
    text-align: center;
  }

  /* POLI
  #screen th:nth-child(7),
  #screen td:nth-child(7) {
    width: 80px;
  } */

  /* STATUS */
  #screen th:nth-child(6),
  #screen td:nth-child(6) {
    width: 50px;
  }

  /* ACTION */
  #screen th:nth-child(7),
  #screen td:nth-child(7) {
    width: 150px;
  }

  #screen tr {
    transition: .2s;
  }

  #screen tbody tr:hover {
    background: #f8fafc;
  }

  .badge {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
  }

  .badge-antri {
    background: #fef3c7;
    color: #92400e;
  }

  .badge-periksa {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .badge-bayar {
    background: #dcfce7;
    color: #166534;
  }

  .badge-selesai {
    background: #bbf7d0;
    color: #166534;
  }

  .btn-action {
    border: none;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    margin-right: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .btn-action:hover {
    transform: translateY(-1px);
  }

  .btn-update {
    background: #10b981;
    color: white;
  }

  .btn-print {
    background: #0ea5e9;
    color: white;
  }

  .btn-delete {
    background: #ef4444;
    color: white;
  }

  .table-container {
    overflow: auto;
    border-radius: 16px;
    max-height: 420px;
    border: 1px solid #e2e8f0;
  }
</style>
<div class="table-container table-pasien">
  <table id="screen">
    <thead>
      <tr>
        <!-- <th>TANGGAL</th> -->
        <th>TERDAFTAR</th>
        <th>ANTRIAN</th>
        <th>PASIEN</th>
        <th>TIPE</th>
        <th>DOKTER</th>
        <th>STATUS</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody>
      <?php
      $kata = $_POST['q'];
      //$kode = 'ACC';
      $panjangkata = strlen($kata);
      if ($panjangkata == 0) {

        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_ENTR_TIME,
          TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME,
          TRXA_REGI_STAT, TRXA_ENTR_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER 
          FROM trxaregi
          WHERE TRXA_REGI_STAT IN ('W','C','P') 
          AND TRXA_VIEW_STAT = 'Y'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
      } else {
        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE,
          (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS PATI_NAME,
          TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_ENTR_TIME,
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
      while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        $regicode = $k['TRXA_REGI_CODE'];

        // hitung nomor antrian full (A001, B005, dst)
        $kodePoli = $k['TRXA_REGI_POLI'];        // misal: PU / PG / PK / LB
        $prefix = isset($prefixMap[$kodePoli]) ? $prefixMap[$kodePoli] : '';
        $noantri_full = $prefix . $k['TRXA_REGI_LIST'];

        //TANGGAL DAFTAR
        // echo '<td>' . $k['REGI_DATE'] . ' ' . $k['TRXA_ENTR_TIME'] . '</td>';

        //TERDAFTAR
        $tanggal_daftar = $k['TRXA_REGI_DATE'];

        if ($tanggal_daftar == $datenow) {
          echo '<td>Hari ini '. $k['REGI_DATE'] . ' ' . $k['TRXA_ENTR_TIME'] .'</td>';
        } else {
          $hasil_hitung_tanggal = hitungTanggal($tanggal_daftar, $datenow);

          echo '<td>' . $hasil_hitung_tanggal . ' hari lalu ' . $k['REGI_DATE'] . ' ' . $k['TRXA_ENTR_TIME'] .'</td>';
        }

        //NO.ANTRIAN
        echo '<td>' . $noantri_full . '</td>';

        //NAMA PASIEN
        echo '<td>' . $k['PATI_NAME'] . '</td>';

        //PEMBAYARAN
        $xregipaym = $k['TRXA_REGI_PAYM'];
        if ($xregipaym == 'U') {
          $regipaym = 'Umum';
        } else if ($xregipaym == 'B') {
          $regipaym = 'BPJS';
        } else if ($xregipaym == 'A') {
          $regipaym = 'Asuransi';
        } else if ($xregipaym == 'P') {
          $regipaym = 'Perusahaan';
        } else if ($xregipaym == 'H') {
          $regipaym = 'Halodoc';
        } else {
          $regipaym = 'Fail get Payment';
        }

        if ($xregipaym == 'B') {
          echo '<td style="width: 100px; background-color: #05c1ff;" ><b>' . $regipaym . '</b></td>';
        } else {
          echo '<td>' . $regipaym . '</td>';
        }

        //NAMA DOKTER
        echo '<td>' . $k['DOCT_NAME'] . '</td>';

        // //POLI
        // echo '<td>' . $k['POLI_NAME'] . '</td>';
      
        //STATUS
        $regipaym = $k['TRXA_REGI_PAYM'];
        $registat = $k['TRXA_REGI_STAT'];
        if ($registat == 'W') {
          echo '<td><span class="badge badge-antri">Antri</span></td>';
        } else if ($registat == 'C' && $regipaym == 'U') {
          echo '<td><span class="badge badge-periksa">Periksa</span></td>';
        } else if ($registat == 'P') {
          echo '<td><span class="badge badge-bayar">Bayar</span></td>';
        } else if ($registat == 'C' && $regipaym == 'B') {
          echo '<td><span class="badge badge-selesai">Selesai</span></td>';
        } else {
          echo '<td><span class="badge badge-selesai">No Status</span></td>';
        }

        //ACTION
        echo '<td>';

        echo '<button class="btn-action btn-update" onclick="
        
        viewcode(\'' . $regicode . '\');
        
        setTimeout(function(){
          document.getElementById(\'regidoct\').scrollIntoView({
          behavior:\'smooth\',
          block:\'start\'
        });

        document.getElementById(\'txtregidoct\').focus();

        },300);
        
        ">Update</button>';

        echo '<a class="btn-action btn-print" href="print.php?nomor=' . $noantri_full . '&pasien=' . urlencode($k['PATI_NAME']) . '&layanan=' . urlencode($k['POLI_NAME']) . '" target="_blank">Antrian</a>';

        if ($registat == 'C') {
          echo '<a class="btn-action btn-delete" 
              onclick="alert(\'Pemeriksaan Belum lengkap ?\');
              ">Closing</a>';

        } else {
          echo '<a class="btn-action btn-delete" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\'' . $regicode . '\');}
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
</div>