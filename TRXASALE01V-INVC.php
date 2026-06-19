<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$regicode = $_POST['q'];
//$kode = 'ACC';
//list($startdate, $enddate) = explode("|",$fulldate);

// Data Pasien
$query_regi = "SELECT TRXA_PATI_CODE, TRXA_REGI_STAT, 
          	  (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME
              FROM trxaregi WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";

$qregi = $db->query($query_regi) or die("Gagal Ambil data Pasien!!");
$row_regi = $qregi->fetch(PDO::FETCH_ASSOC);

$patiname = $row_regi['PATI_NAME'];

if ($row_regi['TRXA_REGI_STAT'] == 'C') {
  $registat = 'Periksa';
} else if ($row_regi['TRXA_REGI_STAT'] == 'P') {
  $registat = 'Bayar';
} else {
  $registat = 'Antri';
}

?>
<table class="pure-table pure-table-horizontal">
  <thead>

    <tr>
      <td style="width: 200px; text-align: center;"><?php echo $patiname; ?></td>
      <td style="width: 100px; text-align: center;"><?php echo $registat; ?></td>
      <td style="width: 200px; text-align: center;"></td>
      <td style="width: 200px; text-align: center;"></td>
    </tr>

    <tr>
      <td style="width: 200px; text-align: center;"><b>Keterangan</b></td>
      <td style="width: 100px; text-align: center;"><b>Jumlah</b></td>
      <td style="width: 200px; text-align: center;"><b>Biaya</b></td>
      <td style="width: 200px; text-align: center;"><b>Subtotal</b></td>
    </tr>

  </thead>
  <tbody>

    <tr class=pure-table-odd>
      <td style="width: 200px; text-align: center;">Layanan</td>
      <td style="width: 100px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
    </tr>

    <?php
    // Layanan
    $query_tret = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE, 
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME, 
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) = 'J' 
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_TRET_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

    $qtret = $db->query($query_tret) or die("Gagal Ambil data tindakan!!");
    while ($row_tret = $qtret->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td style="width: 200px; text-align: right;">' . $row_tret['MEDI_NAME'] . '</td>';
      echo '<td style="width: 100px; text-align: center;">' . $row_tret['TRXA_TRET_QUTY'] . '</td>';

      $medirate = number_format($row_tret['TRXA_MEDI_RATE'], 0, '', '.');

      echo '<td style="width: 200px; text-align: right;">' . $medirate . '</td>';

      $subtotal = number_format($row_tret['SUB_TOTAL'], 0, '', '.');
      echo '<td style="width: 200px; text-align: right;">' . $subtotal . '</td>';
      echo "</tr>";
    }
    ?>
    <?php
    echo '<tr>';
    echo '<td style="width: 200px; text-align: right;">Biaya Admin</td>';
    echo '<td style="width: 100px; text-align: center;">  </td>';

    // Periksa apakah ada obat racikan
    $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";

    $periksaracikan_di_query = $db->query($periksaracikan) or die("Cek Fail");
    $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

    if ($ketersediaan_racikan == 0) {

      // Periksa apakah ada resep yang diberikan
      $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";

      $periksaresep_di_query = $db->query($periksaresep) or die("Cek Fail");
      $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

      if ($ketersediaan_resep == 0) {
        // periksa di data register apakah di kenakan biaya admin
        $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' AND TRXA_REGI_FEE='Y'";
        $periksabiayaadmin_di_query = $db->query($periksabiayaadmin) or die("Cek Fail");
        $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

        if ($ketersediaan_biayaadmin == 0) {
          $total_admin = 0;
        } else {
          $total_admin = $fee_admin;
        }
      } else {
        $total_admin = ($fee_admin + $fee_resep);
      }

    } else {
      $total_admin = ($fee_admin + ($fee_resep + $fee_racikan));
    }

    $biaya_admin = number_format($total_admin, 0, '', '.');

    echo '<td style="width: 200px; text-align: right;">' . $biaya_admin . '</td>';
    echo '<td style="width: 200px; text-align: right;">' . $biaya_admin . '</td>';
    //echo '<td style="width: 200px; text-align: center;">'.$paymtype.'</td>';
    echo "</tr>";

    ?>
    <tr class=pure-table-odd>
      <td style="width: 200px; text-align: center;">Tindakan</td>
      <td style="width: 100px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
    </tr>
    <?php
    // Tindakan
    $query_action = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE, 
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME, 
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) IN ('O','N')  
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_TRET_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

    $qaction = $db->query($query_action) or die("Gagal Ambil data tindakan!!");
    while ($row_action = $qaction->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td style="width: 200px; text-align: right;">' . $row_action['MEDI_NAME'] . '</td>';
      echo '<td style="width: 100px; text-align: center;">' . $row_action['TRXA_TRET_QUTY'] . '</td>';

      $medirate2 = number_format($row_action['TRXA_MEDI_RATE'], 0, '', '.');

      echo '<td style="width: 200px; text-align: right;">' . $medirate2 . '</td>';

      $subtotal2 = number_format($row_action['SUB_TOTAL'], 0, '', '.');
      echo '<td style="width: 200px; text-align: right;">' . $subtotal2 . '</td>';

      echo "</tr>";
    }
    ?>

    <tr class=pure-table-odd>
      <td style="width: 200px; text-align: center;">BHP</td>
      <td style="width: 100px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
    </tr>
    <?php
    // BHP
    $query_csbl = "SELECT TRXA_CSBL_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              TRXA_STOCK_PRIC AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_CSBL_CODE) AS PAYM_TYPE
              FROM trxacsbl WHERE TRXA_CSBL_CODE = '$regicode'
              AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                  (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=TRXA_STOCK_CODE)
                  ) = 'FG' 
              AND TRXA_CSBL_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

    $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data obat!!");
    while ($row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td style="width: 200px; text-align: right;">' . $row_csbl['STOCK_NAME'] . '</td>';
      echo '<td style="width: 100px; text-align: center;">' . $row_csbl['TRXA_STOCK_QUTY'] . '</td>';

      $qty_csbl = $row_csbl['TRXA_STOCK_QUTY'];
      $raw_pric_csbl = $row_csbl['STOCK_PRIC'];

      // PERBAIKAN: Bulatkan Harga Satuan dulu seperti di TRXADRUG08V
      $stockpric_bulat = pembulatan((int) round($raw_pric_csbl));
      $view_stockpric = number_format($stockpric_bulat, 0, '', '.');
      echo '<td style="width: 200px; text-align: right;">' . $view_stockpric . '</td>';

      // PERBAIKAN: Kalikan Harga Satuan yang sudah DIBULATKAN dengan Qty
      $tott = $stockpric_bulat * $qty_csbl;

      // Bulatkan hasil akhirnya lagi untuk memastikan
      $totapric = pembulatan($tott);
      $view_totapric = number_format($totapric, 0, '', '.');

      echo '<td style="width: 200px; text-align: right;">' . $view_totapric . '</td>';

      echo "</tr>";
    }

    ?>

    <tr class=pure-table-odd>
      <td style="width: 200px; text-align: center;">Obat</td>
      <td style="width: 100px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
      <td style="width: 200px; text-align: left;"></td>
    </tr>

    <?php
    // Obat
    $query_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              TRXA_STOCK_PRIC AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE

              FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode' AND TRXA_PRSC_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

    $qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
    while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr>';
      echo '<td style="width: 200px; text-align: right;">' . $row_prsc['STOCK_NAME'] . '</td>';
      echo '<td style="width: 100px; text-align: center;">' . $row_prsc['TRXA_STOCK_QUTY'] . '</td>';

      $qty_prsc = $row_prsc['TRXA_STOCK_QUTY'];
      $raw_pric_prsc = $row_prsc['STOCK_PRIC'];

      // PERBAIKAN: Bulatkan Harga Satuan dulu seperti di TRXADRUG08V
      $stockpric_bulat = pembulatan((int) round($raw_pric_prsc));

      // Jika PAYM_TYPE adalah 'B', set harga satuan menjadi 0
      if ($row_prsc['PAYM_TYPE'] === 'B') {
        $stockpric_bulat = 0;
      }

      $view_stockpric = number_format($stockpric_bulat, 0, '', '.');
      echo '<td style="width: 200px; text-align: right;">' . $view_stockpric . '</td>';

      // PERBAIKAN: Kalikan Harga Satuan yang sudah DIBULATKAN dengan Qty
      $tott = $stockpric_bulat * $qty_prsc;

      // Bulatkan hasil akhirnya lagi untuk memastikan
      $totapric = pembulatan($tott);

      // Jika PAYM_TYPE adalah 'B', set total harga menjadi 0
      if ($row_prsc['PAYM_TYPE'] === 'B') {
        $totapric = 0;
      }

      $view_totapric = number_format($totapric, 0, '', '.');

      echo '<td style="width: 200px; text-align: right;">' . $view_totapric . '</td>';

      echo '</tr>';
    }
    echo '<tr>';
    echo '<td style="width: 200px; text-align: right;"> </td>';
    echo '<td style="width: 100px; text-align: center;"> </td>';
    echo '<td style="width: 200px; text-align: right;"> </td>';
    echo '<td style="width: 200px; text-align: right;">
  <a class="button-print pure-button" onclick="periksaakses(\'PASS_SALE_ENTR\');
                                                document.getElementById(\'tblviewinvc\').innerHTML = \'\'; 
                                               document.getElementById(\'tblviewinvc\').style.visibility = \'hidden\';">Close</a></td>';
    echo '</tr>';

    ?>
  </tbody>
</table>
<div style="padding: 30px 0 30px 0;">
  <center>
    &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.
  </center>
</div>