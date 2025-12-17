<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$regicode = $_POST['q'];
//$kode = 'ACC';
//list($startdate, $enddate) = explode("|",$fulldate);

$query_header = "SELECT TRXA_REGI_DATE, TRXA_PATI_CODE,
                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_ADDR, 
                TRXA_REGI_CODE, 
                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_NAME,
                (SELECT PATI_MAIN_PHNE FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_PHONE,
                TRXA_REGI_DOCT, 
                (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE = TRXA_PATI_CODE) AS PATI_BIRT,
                TRXA_REGI_PAYM, TRXA_ENTR_DATE, TRXA_ENTR_TIME
                FROM trxaregi WHERE TRXA_REGI_CODE='$regicode'";

$qheader = $db->query($query_header) or die("Gagal Ambil Data header!!");
$row_header = $qheader->fetch(PDO::FETCH_ASSOC);

$entrdate = date("d-m-Y", strtotime($row_header['TRXA_ENTR_DATE']));

$tgl_daftar = $entrdate . ' ' . $row_header['TRXA_ENTR_TIME'];
$no_rm = $row_header['TRXA_PATI_CODE'];
$alamat = $row_header['PATI_ADDR'];
$no_daftar = $row_header['TRXA_REGI_CODE'];
$nama = $row_header['PATI_NAME'];
$no_telp = $row_header['PATI_PHONE'];

$regidoct = $row_header['TRXA_REGI_DOCT'];
$dokter = $row_header['DOCT_NAME'];

$tgl_lahir = formatHariTanggal($row_header['PATI_BIRT']);

if ($row_header['TRXA_REGI_PAYM'] == 'U')
{ $pembayaran = 'Umum';}
else if ($row_header['TRXA_REGI_PAYM'] == 'B')
{ $pembayaran = 'BPJS';}
else if ($row_header['TRXA_REGI_PAYM'] == 'A')
{ $pembayaran = 'Asuransi';}
else if ($row_header['TRXA_REGI_PAYM'] == 'P')
{ $pembayaran = 'Perusahaan';}
else if ($row_header['TRXA_REGI_PAYM'] == 'H')
{ $pembayaran = 'Halodoc';}
else
{ $pembayaran = 'None';}

?>
  <table class="pure-table pure-table-horizontal">
  <thead>

  <tr>
  <th style="width: 110px; text-align: left;">Tgl. MRS</th>
  <th style="width: 300px; text-align: left;">: <?php echo $tgl_daftar; ?></th>

  <th style="width: 100px; text-align: left;">No. RM</th> 
  <th style="width: 300px; text-align: left;">: <?php echo $no_rm; ?></th>

  <th style="width: 100px; text-align: left;">Alamat</th>
  <th style="width: 300px; text-align: left;">: <?php echo $alamat; ?></th>
  </tr>

  <tr>
  <th style="width: 110px; text-align: left;">No. Daftar</th>
  <th style="width: 300px; text-align: left;">: <?php echo $no_daftar; ?></th>

  <th style="width: 100px; text-align: left;">Nama</th>
  <th style="width: 300px; text-align: left;">: <?php echo $nama; ?></th>

  <th style="width: 100px; text-align: left;">No Telpon</th>
  <th style="width: 300px; text-align: left;">: <?php echo $no_telp; ?></th>
  </tr>

  <tr class=pure-table-odd>
  <th style="width: 110px; text-align: left;">Dokter</th>
  <th style="width: 300px; text-align: left;">: <?php echo $dokter; ?></th>

  <th style="width: 100px; text-align: left;">Tgl Lahir</th>
  <th style="width: 300px; text-align: left;">: <?php echo $tgl_lahir; ?></th>

  <th style="width: 100px; text-align: left;">Pembayaran</th>
  <th style="width: 300px; text-align: left;">: <?php echo $pembayaran; ?></th>
  </tr>

  </thead>
  <tbody>
  <tr class=pure-table-odd>
    <td style="width: 300px; text-align: center;"><b>Keterangan</b></td>
    <td style="width: 100px; text-align: center;"><b>Jumlah</b></td>
    <td style="width: 200px; text-align: center;"><b>Biaya</b></td>
    <td style="width: 100px; text-align: center;"><b>Diskon</b></td>
    <td style="width: 200px; text-align: center;"><b>Subtotal</b></td>
    <td style="width: 200px; text-align: center;"><b>Jenis Bayar</b></td>
  </tr>

  <tr class=pure-table-odd>
    <td style="width: 300px; text-align: center;">Layanan</td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
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
while ($row_tret = $qtret->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  echo '<td style="width: 300px; text-align: right;">'.$row_tret['MEDI_NAME'].'</td>';
  echo '<td style="width: 100px; text-align: center;">'.$row_tret['TRXA_TRET_QUTY'].'</td>';

  $medirate = number_format($row_tret['TRXA_MEDI_RATE'], 0, '', '.');

  echo '<td style="width: 200px; text-align: right;">'.$medirate.'</td>';
  echo '<td style="width: 100px; text-align: right;">0</td>';

  $subtotal = number_format($row_tret['SUB_TOTAL'], 0, '', '.');  
  echo '<td style="width: 200px; text-align: right;">'.$subtotal.'</td>';

  if ($row_tret['PAYM_TYPE'] == 'U')
    { $paymtype = 'Umum';}
  else if ($row_tret['PAYM_TYPE'] == 'B')
    { $paymtype = 'BPJS';}
  else if ($row_tret['PAYM_TYPE'] == 'A')
    { $paymtype = 'Asuransi';}
  else if ($row_tret['PAYM_TYPE'] == 'P')
    { $paymtype = 'Perusahaan';}
  else if ($row_tret['PAYM_TYPE'] == 'H')
  { $paymtype = 'Halodoc';}
  else
  { $paymtype = 'None';}

  echo '<td style="width: 200px; text-align: center;">'.$paymtype.'</td>';
  echo "</tr>";
}
?>
<?php
  echo '<tr>';
  echo '<td style="width: 300px; text-align: right;">Biaya Admin</td>';
  echo '<td style="width: 100px; text-align: center;">  </td>';

  // Periksa apakah ada obat racikan
  $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";

  $periksaracikan_di_query=$db->query($periksaracikan) or die ("Cek Fail");
  $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

  if ($ketersediaan_racikan == 0)
  {

    // Periksa apakah ada resep yang diberikan
    $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";
                     
    $periksaresep_di_query=$db->query($periksaresep) or die ("Cek Fail");
    $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

    if ($ketersediaan_resep == 0)
    {
        // periksa di data register apakah di kenakan biaya admin
        $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' AND TRXA_REGI_FEE='Y'";
        $periksabiayaadmin_di_query=$db->query($periksabiayaadmin) or die ("Cek Fail");
        $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

        if ($ketersediaan_biayaadmin == 0)
        {
          $total_admin = 0;
        }
        else
        {
          $total_admin = $fee_admin;
        }                
    }
    else
    {
      $total_admin = ($fee_admin + $fee_resep);  
    }
    
  }
  else
  {
    $total_admin = ($fee_admin + ($fee_resep + $fee_racikan));  
  }

  $biaya_admin = number_format($total_admin, 0, '', '.');

  echo '<td style="width: 200px; text-align: right;">'.$biaya_admin.'</td>';
  echo '<td style="width: 100px; text-align: right;">0</td>';
  echo '<td style="width: 200px; text-align: right;">'.$biaya_admin.'</td>';
  //echo '<td style="width: 200px; text-align: center;">'.$paymtype.'</td>';
  echo '<td style="width: 200px; text-align: center;"> </td>';
  echo "</tr>";

?>
  <tr class=pure-table-odd>
    <td style="width: 300px; text-align: center;">Tindakan</td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
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
while ($row_action = $qaction->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  echo '<td style="width: 300px; text-align: right;">'.$row_action['MEDI_NAME'].'</td>';
  echo '<td style="width: 100px; text-align: center;">'.$row_action['TRXA_TRET_QUTY'].'</td>';

  $medirate2 = number_format($row_action['TRXA_MEDI_RATE'], 0, '', '.');

  echo '<td style="width: 200px; text-align: right;">'.$medirate2.'</td>';
  echo '<td style="width: 100px; text-align: right;">0</td>';

  $subtotal2 = number_format($row_action['SUB_TOTAL'], 0, '', '.');  
  echo '<td style="width: 200px; text-align: right;">'.$subtotal2.'</td>';

  if ($row_action['PAYM_TYPE'] == 'U')
    { $paymtype2 = 'Umum';}
  else if ($row_action['PAYM_TYPE'] == 'B')
    { $paymtype2 = 'BPJS';}
  else if ($row_action['PAYM_TYPE'] == 'A')
    { $paymtype2 = 'Asuransi';}
  else if ($row_action['PAYM_TYPE'] == 'P')
    { $paymtype2 = 'Perusahaan';} 
  else if ($row_action['PAYM_TYPE'] == 'H')
    { $paymtype2 = 'Halodoc';}
  else
  { $paymtype2 = 'None';}

  echo '<td style="width: 200px; text-align: center;">'.$paymtype2.'</td>';
  echo "</tr>";
}
?>

  <tr class=pure-table-odd>
    <td style="width: 300px; text-align: center;">BHP</td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
  </tr>
<?php
// BHP
$query_csbl = "SELECT TRXA_CSBL_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              TRXA_STOCK_PRIC, TRXA_STOCK_QUTY, (TRXA_STOCK_PRIC*TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_CSBL_CODE) AS PAYM_TYPE
              FROM trxacsbl WHERE TRXA_CSBL_CODE = '$regicode' AND TRXA_CSBL_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

$qcsbl = $db->query($query_csbl) or die("Gagal Ambil data obat!!");
while ($row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  echo '<td style="width: 300px; text-align: right;">'.$row_csbl['STOCK_NAME'].'</td>';
  echo '<td style="width: 100px; text-align: center;">'.$row_csbl['TRXA_STOCK_QUTY'].'</td>';

  $stockpric = number_format($row_csbl['TRXA_STOCK_PRIC'], 0, '', '.');

  echo '<td style="width: 200px; text-align: right;">'.$stockpric.'</td>';
  echo '<td style="width: 100px; text-align: right;">0</td>';

  $totapric = number_format($row_csbl['SUB_TOTAL_PRIC'], 0, '', '.');  
  echo '<td style="width: 200px; text-align: right;">'.$totapric.'</td>';

  if ($row_csbl['PAYM_TYPE'] == 'U')
    { $paymtype3 = 'Umum';}
  else if ($row_csbl['PAYM_TYPE'] == 'B')
    { $paymtype3 = 'BPJS';}
  else if ($row_csbl['PAYM_TYPE'] == 'A')
    { $paymtype3 = 'Asuransi';}
  else if ($row_csbl['PAYM_TYPE'] == 'P')
    { $paymtype3 = 'Perusahaan';}
  else if ($row_action['PAYM_TYPE'] == 'H')
  { $paymtype2 = 'Halodoc';}
  else
  { $paymtype3 = 'None';}

  echo '<td style="width: 200px; text-align: center;">'.$paymtype3.'</td>';
  echo "</tr>";
}

?>

  <tr class=pure-table-odd>
    <td style="width: 300px; text-align: center;">Obat</td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
    <td style="width: 100px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
    <td style="width: 200px; text-align: left;"></td>
  </tr>

<?php
// Obat
$query_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME, 
              TRXA_STOCK_PRIC, TRXA_STOCK_QUTY, (TRXA_STOCK_PRIC*TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE
              FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode' AND TRXA_PRSC_STAT = 'I' AND TRXA_VIEW_STAT='Y'";

$qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  echo '<td style="width: 300px; text-align: right;">'.$row_prsc['STOCK_NAME'].'</td>';
  echo '<td style="width: 100px; text-align: center;">'.$row_prsc['TRXA_STOCK_QUTY'].'</td>';

  $xstockpric = $row_prsc['TRXA_STOCK_PRIC'];
  $stockpric = $xstockpric * $profit;
  
  // Jika PAYM_TYPE adalah 'B', set total harga menjadi 0
  if ($row_prsc['PAYM_TYPE'] === 'B') {
      $stockpric = 0;
  }
  
  $view_stockpric = number_format($stockpric, 0, '', '.');

  echo '<td style="width: 200px; text-align: right;">'.$view_stockpric.'</td>';
  echo '<td style="width: 100px; text-align: right;">0</td>';

  $xtotapric = $row_prsc['SUB_TOTAL_PRIC'];
  $totapric = $xtotapric * $profit;
  
        // Jika PAYM_TYPE adalah 'B', set total harga menjadi 0
  if ($row_prsc['PAYM_TYPE'] === 'B') {
      $totapric = 0;
  }
   
  $view_totapric = number_format($totapric, 0, '', '.');
  echo '<td style="width: 200px; text-align: right;">'.$view_totapric.'</td>';

  if ($row_prsc['PAYM_TYPE'] == 'U')
    { $paymtype4 = 'Umum';}
  else if ($row_prsc['PAYM_TYPE'] == 'B')
    { $paymtype4 = 'BPJS';}
  else if ($row_prsc['PAYM_TYPE'] == 'A')
    { $paymtype4 = 'Asuransi';}
  else if ($row_prsc['PAYM_TYPE'] == 'P')
    { $paymtype4 = 'Perusahaan';}
  else if ($row_action['PAYM_TYPE'] == 'H')
    { $paymtype2 = 'Halodoc';}
  else
  { $paymtype4 = 'None';}

  echo '<td style="width: 200px; text-align: center;">'.$paymtype4.'</td>';
  echo "</tr>";
}

?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


