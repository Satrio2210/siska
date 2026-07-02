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

    //1. Periksa Fee Register
    $q_regi = "SELECT TRXA_REGI_FEE, TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' LIMIT 1";
    $data_regi = $db->query($q_regi)->fetch(PDO::FETCH_ASSOC);

    $fee_admin_aktif = ($data_regi && $data_regi['TRXA_REGI_FEE'] == 'Y') ? true : false;
    $tipe_pembayaran = $data_regi ? $data_regi['TRXA_REGI_PAYM'] : '';


    // 2. Periksa ketersediaan racikan
    $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                       AND TRXA_PRSC_CONC='Y'
                       AND TRXA_PRSC_STAT='I'
                       AND TRXA_VIEW_STAT='Y'";
    $ketersediaan_racikan = $db->query($periksaracikan)->fetchColumn();

    if ($ketersediaan_racikan == 0) {

      $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                       AND TRXA_PRSC_STAT='I'
                       AND TRXA_VIEW_STAT='Y'";
      $ketersediaan_resep = $db->query($periksaresep)->fetchColumn();

      if ($ketersediaan_resep == 0) {

        if (!$fee_admin_aktif) {
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

    if ($tipe_pembayaran == 'B') {
      $total_admin = 0;
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
    if (!function_exists('get_mapped_signa')) {
      function get_mapped_signa($signa)
      {
        if ($signa == '01')
          return '1x1 Sebelum Makan';
        if ($signa == '02')
          return '2x1 Sebelum Makan';
        if ($signa == '03')
          return '3x1 Sebelum Makan';
        if ($signa == '04')
          return '1x1 Sesudah Makan';
        if ($signa == '05')
          return '2x1 Sesudah Makan';
        if ($signa == '06')
          return '3x1 Sesudah Makan';
        if ($signa == '07')
          return '4x1 Sesudah Makan';
        if ($signa == '08')
          return '5x1 Sesudah Makan';
        if ($signa == '09')
          return '3x1 Oles Tipis';
        if ($signa == '10')
          return '3x1 Tetes Pada Mata Yang Sakit';
        return $signa;
      }
    }

    $query_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              TRXA_STOCK_PRIC AS STOCK_PRIC, TRXA_STOCK_QUTY, 
              (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE,
              TRXA_PRSC_CONC, TRXA_RACIK_ID
              FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode' AND TRXA_PRSC_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

    $qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
    $all_prsc_rows = [];
    while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC)) {
      $all_prsc_rows[] = $row_prsc;
    }

    $final_items = [];
    $racik_indices = [];

    foreach ($all_prsc_rows as $row) {
      $qty_prsc = $row['TRXA_STOCK_QUTY'];
      $raw_pric_prsc = $row['STOCK_PRIC'];

      // PERBAIKAN: Bulatkan Harga Satuan dulu seperti di TRXADRUG08V
      $stockpric_bulat = pembulatan((int) round($raw_pric_prsc));

      // Jika PAYM_TYPE adalah 'B', set harga satuan menjadi 0
      if ($row['PAYM_TYPE'] === 'B') {
        $stockpric_bulat = 0;
      }

      // PERBAIKAN: Kalikan Harga Satuan yang sudah DIBULATKAN dengan Qty
      $tott = $stockpric_bulat * $qty_prsc;

      // Bulatkan hasil akhirnya lagi untuk memastikan
      $totapric = pembulatan($tott);

      // Jika PAYM_TYPE adalah 'B', set total harga menjadi 0
      if ($row['PAYM_TYPE'] === 'B') {
        $totapric = 0;
      }

      $is_racikan = ($row['TRXA_PRSC_CONC'] === 'Y' && !empty($row['TRXA_RACIK_ID']) && $row['TRXA_RACIK_ID'] > 0);

      if ($is_racikan) {
        $racik_id = $row['TRXA_RACIK_ID'];
        if (!isset($racik_indices[$racik_id])) {
          $qhead = $db->query("SELECT TRXAR_NAMA, TRXAR_QTY FROM trxaracik_head WHERE TRXAR_ID = " . (int) $racik_id . " LIMIT 1");
          $head_row = $qhead ? $qhead->fetch(PDO::FETCH_ASSOC) : null;

          $racik_nama = ($head_row && !empty($head_row['TRXAR_NAMA'])) ? $head_row['TRXAR_NAMA'] : 'Obat';
          $racik_qty = ($head_row && isset($head_row['TRXAR_QTY'])) ? $head_row['TRXAR_QTY'] : 1;

          $final_items[] = [
            'is_racikan' => true,
            'racik_id' => $racik_id,
            'name' => $racik_nama . ' (Racikan)',
            'qty' => $racik_qty,
            'total_price' => 0,
            'paym_type' => $row['PAYM_TYPE']
          ];
          $racik_indices[$racik_id] = count($final_items) - 1;
        }
        $final_items[$racik_indices[$racik_id]]['total_price'] += $totapric;
      } else {
        $final_items[] = [
          'is_racikan' => false,
          'name' => $row['STOCK_NAME'],
          'qty' => $qty_prsc,
          'stock_pric' => $stockpric_bulat,
          'total_price' => $totapric,
          'paym_type' => $row['PAYM_TYPE']
        ];
      }
    }

    foreach ($final_items as &$f_item) {
      if ($f_item['is_racikan']) {
        if ($f_item['paym_type'] === 'B') {
          $f_item['total_price'] = 0;
        } else {
          $f_item['total_price'] += 30000;
        }
        $f_item['total_price'] = pembulatan($f_item['total_price']);
        $f_item['stock_pric'] = pembulatan((int) round($f_item['total_price'] / $f_item['qty']));
      }
    }
    unset($f_item);

    foreach ($final_items as $item) {
      echo '<tr>';
      echo '<td style="width: 200px; text-align: right;">' . htmlspecialchars($item['name']) . '</td>';
      echo '<td style="width: 100px; text-align: center;">' . htmlspecialchars($item['qty']) . '</td>';

      $view_stockpric = number_format($item['stock_pric'], 0, '', '.');
      echo '<td style="width: 200px; text-align: right;">' . $view_stockpric . '</td>';

      $view_totapric = number_format($item['total_price'], 0, '', '.');
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