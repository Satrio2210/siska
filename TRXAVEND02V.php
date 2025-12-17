<?php
include "conf/config.php";
include 'inc/sanie.php';
?>

  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Request</th>
  <th style="width: 100px; text-align: center;">PO</th>
  <th style="width: 100px; text-align: center;">Invoice</th>
  <th style="width: 150px; text-align: center;">Date</th>
  <th style="width: 200px; text-align: center;">Suplier</th>
  <th style="width: 150px; text-align: center;">Outstanding</th>
  <th style="width: 100px; text-align: center;">Approve</th>
  <th style="width: 100px; text-align: center;">Pending</th>
  

  </tr>
  </thead>
  <tbody>

<?php
$requstat = $_POST['q'];
//$requstat = 'Y';
//$fulltext = '2020-01-01|2020-07-31';

$XXXXXqueryrequ = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_SUPL_CODE AS ID_SUPLIER,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,

            (SELECT SUM(i.ITEM_PART_PRIC * i.ITEM_QUTY_RCVE) 
              FROM itemproc AS i, trxaproc AS t 
              WHERE t.TRXA_PROC_CODE = i.ITEM_PROC_CODE 
              AND t.TRXA_PROC_STAT = 'CL'
              AND t.TRXA_SUPL_CODE = ID_SUPLIER) AS AMOUNT,

            TRXA_VEND_STAT
            FROM trxavend WHERE TRXA_VEND_STAT IN ('R','A','P') AND TRXA_VIEW_STAT='$requstat'
            AND NOT ((SELECT COUNT(*) FROM itemvend WHERE ITEM_VEND_CODE = TRXA_VEND_CODE) > 0)"; 

$queryrequ = "SELECT TRXA_VEND_CODE, TRXA_VEND_DATE, TRXA_PROC_CODE, TRXA_SUPL_CODE,
              (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME, 
              TRXA_PROC_VATX, TRXA_DOWN_PAID, TRXA_REMA_PAID, TRXA_INVC_CODE, TRXA_VEND_STAT 
              FROM trxavend 
              WHERE TRXA_VEND_STAT IN ('R','A','P') AND TRXA_VIEW_STAT='$requstat'
              AND NOT ((SELECT COUNT(*) FROM itemvend WHERE ITEM_VEND_CODE = TRXA_VEND_CODE) > 0)
              ORDER BY TRXA_VEND_DATE DESC, TRXA_ENTR_TIME DESC";
           
$qrequ = $db->query($queryrequ) or die("Gagal Ambil Data Request ");
while ($k = $qrequ->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $nomorrequest=$k['TRXA_VEND_CODE'];
  echo '<td style="width: 100px">'.$k['TRXA_VEND_CODE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_PROC_CODE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_INVC_CODE'].'</td>';
  $requdate = formatTanggal($k['TRXA_VEND_DATE']);
  echo '<td style="width: 150px">'.$requdate.'</td>';
  echo '<td style="width: 200px">'.$k['SUPL_NAME'].'</td>';
 
  if ($k['TRXA_PROC_VATX'] == 'E') 
  {
    $dpp = ($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']);
    $ppn = (($dpp * 10) /100);
    $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
  }
  else if ($k['TRXA_PROC_VATX'] == 'I')
  {
    $dpp = (($k['TRXA_DOWN_PAID'] + $k['TRXA_REMA_PAID']) * (100/110));
    $ppn = (($dpp * 10) /100);
    $amount = (($dpp + $ppn) - $k['TRXA_DOWN_PAID']);  
  }
  else
  {
    $amount = $k['TRXA_REMA_PAID'];
  }

  $view_amount = number_format($amount, 0, '', '.');
  echo '<td style="width: 150px; text-align: left;">Rp. '.$view_amount.'</td>';

  $status_request = $k['TRXA_VEND_STAT'];

  if ($status_request == 'R')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-view" align="left" onClick="approverequest(\''.$nomorrequest.'\');">Approved</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-delete" align="left" onClick="rejectrequest(\''.$nomorrequest.'\');">Pending</a>';
  echo '</td>';    
  }
  else if ($status_request == 'A')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-view" align="left" onClick="unapproverequest(\''.$nomorrequest.'\');">UnApproved</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button" align="left">Pending</a>';
  echo '</td>';    

  }

  else if ($status_request == 'P')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button" align="left">Approve</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-delete" align="left" onClick="unrejectrequest(\''.$nomorrequest.'\');">UnPending</a>';
  echo '</td>';    
  }
  else
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_request.'
        <a class="pure-button" align="left">UnApprove</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_request.'
        <a class="pure-button" align="left">Pending</a>';
  echo '</td>';    

  }

  echo '</tr>';
}
?>
  </tbody>
  </table>


