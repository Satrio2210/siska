<?php
include "conf/config.php";
include 'inc/sanie.php';
?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>
  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Order</th>
  <th style="width: 150px; text-align: center;">Tanggal</th>
  <th style="width: 100px; text-align: center;">Divisi</th>
  <th style="width: 200px; text-align: center;">Pemasok</th>
  <th style="width: 150px; text-align: center;">Tenggat</th>
  <th style="width: 100px; text-align: center;">DP</th>
  <th style="width: 100px; text-align: center;">Jumlah</th>
  <th style="width: 100px; text-align: center;">PPN</th>
  <th style="width: 200px; text-align: center;">Status</th>
  <th style="width: 150px; text-align: center;">Task</th>
  

  </tr>
  </thead>
  <tbody>

<?php
$userid = $_POST['q'];
//$fulltext = '2020-01-01|2020-07-31';

$querypo = "SELECT TRXA_PROC_CODE, TRXA_PROC_DATE, TRXA_PROC_DUED, TRXA_PROC_DIVI, TRXA_PROC_STAT, TRXA_PROC_VATX,
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = TRXA_PROC_DIVI) AS DIVI_NAME, 
            TRXA_SUPL_CODE,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
            TRXA_DOWN_PAID,
            (SELECT SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) FROM itemproc WHERE ITEM_PROC_CODE = TRXA_PROC_CODE) AS AMOUNT_ORDER
            FROM trxaproc WHERE TRXA_PROC_STAT IN ('AP','OP','CL') 
            AND TRXA_ENTR_USER='$userid' ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
           
$qpo = $db->query($querypo) or die("Gagal Ambil Data PO ");
while ($k = $qpo->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $nomorpo=$k['TRXA_PROC_CODE'];
  $procdate = formatTanggal($k['TRXA_PROC_DATE']);
  $procdued = formatTanggal($k['TRXA_PROC_DUED']);

  echo '<td style="width: 100px">'.$k['TRXA_PROC_CODE'].'</td>';
  echo '<td style="width: 150px">'.$procdate.'</td>';
  echo '<td style="width: 100px">'.$k['DIVI_NAME'].'</td>';
  echo '<td style="width: 200px">'.$k['SUPL_NAME'].'</td>';
  echo '<td style="width: 150px">'.$procdued.'</td>';

  $down_payment = $k['TRXA_DOWN_PAID'];
  $view_down_payment = number_format($k['TRXA_DOWN_PAID'],0,',','.');
  echo '<td style="width: 100px; text-align: right;">'.$view_down_payment.'</td>';

  $status_vat = $k['TRXA_PROC_VATX'];

  $amount_order = $k['AMOUNT_ORDER'];
  $view_amount_order = number_format($amount_order,0,',','.');
  echo '<td style="width: 100px; text-align: right;">'.$view_amount_order.'</td>';  

  if ($status_vat == 'E') 
  {
    $dpp = $amount_order;
  }
  else if ($status_vat == 'I')
  {
    $dpp = ($amount_order * (100/110));
  }
  else
  {
    $dpp = 0;
  }

  
  $vat = (($dpp * 10)/100);
  $view_vat = number_format($vat,0,',','.'); 
  echo '<td style="width: 100px; text-align: right;">'.$view_vat.'</td>';

  $xprocstat = $k['TRXA_PROC_STAT'];

  if ($xprocstat == 'AP') { $procstat = 'Di ajukan'; }
  else if ($xprocstat == 'OP') { $procstat = 'Sedang Di antar'; }
  else if ($xprocstat == 'CL') { $procstat = 'Proses Bayar'; }
  else { $procstat = 'None';}

  echo '<td style="width: 200px; text-align: right;">'.$procstat.'</td>';

  echo '<td style="width: 200px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-delete" align="left" onClick="cancelpo(\''.$nomorpo.'\');">Cancel</a>';
        ?>
        <a class="pure-button button-print" onClick="javascript: location.href ='TRXAPROC02P.php?nomor=<?php echo $nomorpo;?>'">Print</a>
  <?php
  echo '</td>';
  echo '</tr>';
}
?>
  </tbody>
  </table>


