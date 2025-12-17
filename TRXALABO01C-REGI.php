<?php
include "conf/config.php";
?>
<style>
  #screen {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #screen td,
  #screen th {
    border: 1px solid #ddd;
    padding: 4px;
  }


  #screen tr:nth-child(even) {
    background-color: #f3f2f2;
  }

  #screen tr:hover {
    background-color: #ddd;
  }

  #screen th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
  }

  #screen tbody,
  #screen thead {
    display: block;
  }

  #screen tbody {
    overflow: auto;
    height: 200px;
  }
</style>
<table id="screen">
  <thead>
    <tr>
      <th style="width: 750px;">PASIEN</th>
    </tr>
    <thead>
      <tr>
        <th style="width: 100px">Antri</th>
        <th style="width: 160px">Nama</th>
        <th style="width: 140px">Poli</th>
        <th style="width: 100px">Payment</th>
        <th style="width: 95px">R.M</th>
        <th style="width: 120px">TANGGAL DAFTAR</th>

      </tr>
    </thead>
  </thead>
  <tbody>
    <?php
    $rawdata = $_POST['q'];
    list($kata, $dokter) = explode("|", $rawdata);

    if (strlen($kata) == 1) {
      $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, 
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT DATE_FORMAT(PATI_MAIN_BIRT,'%d/%m/%Y') FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS BIRT_DATE,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                (SELECT COUNT(*) FROM trxatret WHERE TRXA_TRET_CODE=TRXA_REGI_CODE AND TRXA_VIEW_STAT='Y') AS TOTA_TRET,
                TRXA_REGI_PAYM, TRXA_REGI_POLI, TRXA_REGI_LIST, TRXA_ENTR_DATE
                FROM trxaregi
                WHERE TRXA_REGI_DOCT = '$dokter' AND TRXA_REGI_STAT IN('W','C')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 5 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
    } else {
      $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE,
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT DATE_FORMAT(PATI_MAIN_BIRT,'%d/%m/%Y') FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS BIRT_DATE,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                (SELECT COUNT(*) FROM trxatret WHERE TRXA_TRET_CODE=TRXA_REGI_CODE AND TRXA_VIEW_STAT='Y') AS TOTA_TRET,
                TRXA_REGI_PAYM, TRXA_REGI_POLI, TRXA_REGI_LIST, TRXA_ENTR_DATE
                FROM trxaregi
                WHERE (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '$kata%' 
                AND TRXA_REGI_DOCT = '$dokter' AND TRXA_REGI_STAT IN('W','C')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 5 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
    }

    $prefixMap = [
      'PU' => 'A', // Poli Umum
      'PG' => 'B', // Poli Gigi
      'KB' => 'C', // Poli KIA
      'LB' => 'D', // Laboratorium
    ];

    $q = $db->query($xquery) or die("Gagal ambil regis !!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
      $outtretcode = $k['TRXA_REGI_CODE'];
      $outpaticode = $k['TRXA_PATI_CODE'];
      $outmainname = $k['MAIN_NAME'];
      $outbirtdate = $k['BIRT_DATE'];
      $mainage = $k['MAIN_AGE'];
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
      } else if ($gender = 'F') {
        $outmaingend = 'Perempuan';
      } else {
        $outmaingend = 'No Gender';
      }

      $outtotaltret = $k['TOTA_TRET'];

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

      $outpaymcode = $k['TRXA_REGI_PAYM'];

      if ($outpaymcode == 'U') {
        $outregipaym = 'Umum';
      } else if ($outpaymcode == 'B') {
        $outregipaym = 'BPJS';
      } else if ($outpaymcode == 'A') {
        $outregipaym = 'Asuransi';
      } else if ($outpaymcode == 'P') {
        $outregipaym = 'Perusahaan';
      } else if ($outpaymcode == 'H') {
        $outregipaym = 'Halodoc';
      } else {
        $outregipaym = 'Kosong';
      }

      $outregipoli = $k['TRXA_REGI_POLI'];

      // hitung nomor antrian full (A001, B005, dst)
      $kodePoli = $k['TRXA_REGI_POLI'];        // misal: PU / PG / PK / LB
      $prefix = isset($prefixMap[$kodePoli]) ? $prefixMap[$kodePoli] : '';
      $noantri_full = $prefix . $k['TRXA_REGI_LIST'];

      //isiregi(outtretcode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode)
      if ($outtotaltret == 0) {
        echo '<tr>';
      } else {
        echo '<tr style="background-color: #98F7FD;">';
      }
      echo '<td style="width: 100px;" onClick="isiregi(\'' . $outtretcode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outbirtdate . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\');" 
      style="cursor:pointer">' . $noantri_full . '</td>';

      echo '<td style="width: 165px;" onClick="isiregi(\'' . $outtretcode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outbirtdate . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\');" 
      style="cursor:pointer">' . $k['MAIN_NAME'] . '</td>';

      echo '<td style="width: 140px;">' . $regipoli . '</td>';

      echo '<td style="width: 100px;">' . $outregipaym . '</td>';

      // echo '<td style="width: 100px;" onClick="isiregi(\''.$outtretcode.'\',\''.$outpaticode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outbirtdate.'\',\''.$outmainage.'\',\''.$outregipaym.'\',\''.$outpaymcode.'\',\''.$outregipoli.'\');" 
//       style="cursor:pointer">'.$k['TRXA_REGI_CODE'].'</td>';
    
      echo '<td style="width: 95px;" onClick="isiregi(\'' . $outtretcode . '\',\'' . $outpaticode . '\',\'' . $outmainname . '\',\'' . $outmaingend . '\',\'' . $outbirtdate . '\',\'' . $outmainage . '\',\'' . $outregipaym . '\',\'' . $outpaymcode . '\',\'' . $outregipoli . '\');" 
      style="cursor:pointer">' . $k['TRXA_PATI_CODE'] . '</td>';

      echo '<td style="width: 100px;">' . $k['TRXA_ENTR_DATE'] . '</td>';


      echo '</tr>';
    }
    ?>
  </tbody>
</table>