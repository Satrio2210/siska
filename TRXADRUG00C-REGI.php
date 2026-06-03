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
    table-layout:fixed;
    border-spacing: 0;
    font-size: 12px;
    font-family: inherit;
  }

  #screen th,
  #screen td{
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
  }

  #screen tbody tr:hover {
    background: #f8fafc;
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
      
      if (strlen($kata) == 1) {
        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE,
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE = TRXA_REGI_CODE AND TRXA_VIEW_STAT='Y' ) AS CNT_RESEP,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_POLI,
                (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_PRSC,
                (SELECT GROUP_CONCAT(TRXA_DIAG_NAME SEPARATOR ', ') FROM trxadiag WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS DIAGNOSA
                FROM trxaregi
                WHERE TRXA_REGI_POLI <> '$code_lab_room' 
                -- AND TRXA_REGI_STAT IN ('C','W')
                AND TRXA_REGI_STAT IN ('C')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
      } else {
        $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE,
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE = TRXA_REGI_CODE AND TRXA_VIEW_STAT='Y' ) AS CNT_RESEP,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_POLI,
                (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_PRSC,
                (SELECT GROUP_CONCAT(TRXA_DIAG_NAME SEPARATOR ', ') FROM trxadiag WHERE TRXA_EXAM_CODE = TRXA_REGI_CODE) AS DIAGNOSA
                FROM trxaregi
                WHERE (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '$kata%' 
                AND TRXA_REGI_POLI <> '$code_lab_room' 
                -- AND TRXA_REGI_STAT IN ('C','W')
                AND TRXA_REGI_STAT IN ('C')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
      }

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