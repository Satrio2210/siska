<?php
include "conf/config.php";
?>
<style>
  .table-wrapper {
    min-height: 250px;
    overflow: auto;
  }

  #screen {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    border-spacing: 0;
    font-size: 13px;
    font-family: inherit;
  }

  #screen th,
  #screen td {
    white-space: nowrap;
  }

  #screen thead th {
    position: sticky;
    top: 0;
    background: #f8fafc;
    color: #334155;
    padding: 9px 10px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    z-index: 5;
  }

  #screen tbody td {
    padding: 8px 10px;
    border-bottom: 1px solid #f1f5f9;
    color: #0f172a;
    font-size: 14px;
    font-weight: 700;
  }

  #screen tbody tr:hover {
    background: #91a1b186;
    cursor: pointer;
  }

  #screen th:nth-child(1),
  #screen td:nth-child(1) {
    width: 60px;
  }

  #screen th:nth-child(2),
  #screen td:nth-child(2) {
    width: 40%;
  }

  #screen th:nth-child(3),
  #screen td:nth-child(3) {
    width: 140px;
  }

  #screen th:nth-child(4),
  #screen td:nth-child(4) {
    width: 170px;
  }

  #screen th:nth-child(5),
  #screen td:nth-child(5) {
    width: 110px;
  }

  .status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
  }

  .status-done {
    background: #dcfce7;
    color: #166534;
  }

  .status-pending {
    background: #fee2e2;
    color: #991b1b;
  }

  .badge-status,
  .badge-pay {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
  }

  .badge-success {
    background: #dcfce7;
    color: #166534;
  }

  .badge-warning {
    background: #fef3c7;
    color: #92400e;
  }

  .badge-bpjs {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .badge-umum {
    background: #e2e8f0;
    color: #334155;
  }

  .badge-asuransi {
    background: #ffedd5;
    color: #c2410c;
  }

  .badge-perusahaan {
    background: #ede9fe;
    color: #6d28d9;
  }
</style>
<div class="table-wrapper">
  <table id="screen">
    <thead>
      <tr>
        <th>Antri</th>
        <th>Nama Pasien</th>
        <th>Poli</th>
        <th>Status</th>
        <th>Payment</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $kata = $_POST['q'];
      //$kata = 'X';
      //list($kata, $dokter) = explode("|",$rawdata);
      
      $xquery = " SELECT
        r.TRXA_REGI_CODE, 
        r.TRXA_PATI_CODE,
        CONCAT(p.PATI_MAIN_TITL, ' ', p.PATI_MAIN_NAME) AS MAIN_NAME,
        IFNULL(pr.CNT_RESEP, 0) AS CNT_RESEP,
        p.PATI_MAIN_BIRT AS MAIN_AGE,
        p.PATI_MAIN_GEND AS MAIN_GEND,
        r.TRXA_REGI_LIST, 
        r.TRXA_REGI_PAYM, 
        r.TRXA_REGI_POLI,
        e.TRXA_EXAM_PRSC AS EXAM_PRSC,
        d.DIAGNOSA
        FROM trxaregi r
        -- Join ke tabel master pasien
        JOIN patimast p ON p.PATI_MAST_CODE = r.TRXA_PATI_CODE
    
        -- Join ke tabel exam
        LEFT JOIN trxaexam e ON e.TRXA_EXAM_CODE = r.TRXA_REGI_CODE
    
        -- Subquery JOIN untuk ngitung resep (biar data ga duplicate/cartesian)
        LEFT JOIN (
        SELECT TRXA_PRSC_CODE, COUNT(*) AS CNT_RESEP 
        FROM trxaprsc 
        WHERE TRXA_VIEW_STAT = 'Y' 
        GROUP BY TRXA_PRSC_CODE
        ) pr ON pr.TRXA_PRSC_CODE = r.TRXA_REGI_CODE
    
        -- Subquery JOIN untuk gabungin teks diagnosa
        LEFT JOIN (
        SELECT TRXA_EXAM_CODE, GROUP_CONCAT(TRXA_DIAG_NAME SEPARATOR ', ') AS DIAGNOSA 
        FROM trxadiag 
        GROUP BY TRXA_EXAM_CODE
        ) d ON d.TRXA_EXAM_CODE = r.TRXA_REGI_CODE
    
        WHERE r.TRXA_REGI_POLI <> '$code_lab_room' 
        AND r.TRXA_REGI_STAT = 'C'
        AND r.TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
        ";
      // 2. Tambahin filter pencarian (menggantikan logika IF-ELSE lu yang kepanjangan)
      if (strlen($kata) != 1) {
        // Lu ga perlu lagi subquery buat nyari nama, karena tabel patimast (p) udah di-JOIN
        $xquery .= " AND p.PATI_MAIN_NAME LIKE '$kata%' ";
      }
      // 3. Tambahin pengurutan data di akhir
      $xquery .= " ORDER BY r.TRXA_ENTR_DATE DESC, r.TRXA_ENTR_TIME DESC";

      $q = $db->query($xquery) or die("Gagal ambil regis !!");
      while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
        $outprsccode = $k['TRXA_REGI_CODE'];
        $outpaticode = $k['TRXA_PATI_CODE'];
        $outmainname = $k['MAIN_NAME'];
        $mainage = $k['MAIN_AGE'];
        $outexamdiag = $k['DIAGNOSA'];

        // tanggal lahir
        $tanggal = new DateTime($mainage);

        // tanggal hari ini
        $today = new DateTime('today');

        $y = $today->diff($tanggal)->y;
        $m = $today->diff($tanggal)->m;
        $d = $today->diff($tanggal)->d;
        $outmainage = '' . $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';

        $gender = $k['MAIN_GEND'];

        if ($gender == 'M') {
          $outmaingend = 'Laki Laki';
        } else if ($gender == 'F') {
          $outmaingend = 'Perempuan';
        } else {
          $outmaingend = 'No Gender';
        }

        $outpaymcode = $k['TRXA_REGI_PAYM'];

        if ($outpaymcode == 'U') {
          $outregipaym = 'Umum';
        } else if ($outpaymcode == 'B') {
          $outregipaym = 'BPJS';
        } else if ($outpaymcode == 'A') {
          $outregipaym = 'Asuransi';
        } else if ($outpaymcode == 'P') {
          $outregipaym = 'Perusahaan';
        } else {
          $outregipaym = 'Kosong';
        }

        $outregipoli = $k['TRXA_REGI_POLI'];
        $inexamprsc = $k['EXAM_PRSC'];
        $outexamprsc = preg_replace("/[\r\n]*/", "", $inexamprsc);

        $regipoli = $k['TRXA_REGI_POLI'];
        if ($regipoli == 'PU') {
          $regipoli = 'Poli Umum';
        } else if ($regipoli == 'KB') {
          $regipoli = 'Poli KIA';
        } else if ($regipoli == 'PG') {
          $regipoli = 'Poli Gigi';
        } else if ($regipoli == 'LB') {
          $regipoli = 'Laboratorium';
        } else {
          $regipoli = 'Kosong';
        }


        $regipaym = $k['TRXA_REGI_PAYM'];
        if ($regipaym == 'U') {
          $regipaym = 'Umum';
        } else if ($regipaym == 'B') {
          $regipaym = 'BPJS';
        } else if ($regipaym == 'A') {
          $regipaym = 'Asuransi';
        } else if ($regipaym == 'P') {
          $regipaym = 'Perusahaan';
        } else {
          $regipaym = 'Kosong';
        }

        if ($regipaym == 'BPJS') {
          $badgepay = '<span class="badge-pay badge-bpjs">BPJS</span>';
        } else if ($regipaym == 'Umum') {
          $badgepay = '<span class="badge-pay badge-umum">Umum</span>';
        } else if ($regipaym == 'Asuransi') {
          $badgepay = '<span class="badge-pay badge-asuransi">Asuransi</span>';
        } else {
          $badgepay = '<span class="badge-pay badge-perusahaan">Perusahaan</span>';
        }
        //isiregi(outcsblcode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode)
        echo '<tr>';

        echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\',\'' . $outexamdiag . '\');" 
      style="cursor:pointer">' . $k['TRXA_REGI_LIST'] . '</td>';

        echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\',\'' . $outexamdiag . '\');" 
      style="cursor:pointer">' . $k['MAIN_NAME'] . '</td>';

        echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\',\'' . $outexamdiag . '\');" 
      style="cursor:pointer">' . $regipoli . '</td>';

        // echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\');" 
        // style="cursor:pointer">' . $regipaym . '</td>';
      
        // echo '<td style="width: 100px;" onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\');" 
        // style="cursor:pointer">' . $k['TRXA_PATI_CODE'] . '</td>';
      
        $cntresep = $k['CNT_RESEP'];

        if ($cntresep > 0) {
          $statusfarmasi = '<span class="badge-status badge-success">Sudah Dilayani</span>';
        } else {
          $statusfarmasi = '<span class="badge-status badge-warning">Belum Dilayani</span>';
        }

        echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\',\'' . $outexamdiag . '\');" 
      style="cursor:pointer">' . $statusfarmasi . '</td>';

        echo '<td onClick="isiregi(\'' . $outprsccode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\',\'' . $outexamprsc . '\',\'' . $outexamdiag . '\');" 
      style="cursor:pointer">' . $badgepay . '</td>';

        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>