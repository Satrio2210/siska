<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include 'inc/sanie.php';
?>

  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 200px; text-align: center;">Request</th>
  <th style="width: 200px; text-align: center;">Date</th>
  <th style="width: 200px; text-align: center;">From</th>
  <th style="width: 200px; text-align: center;">To</th>
  <th style="width: 100px; text-align: center;">Approve</th>
  <th style="width: 100px; text-align: center;">Reject</th>
  

  </tr>
  </thead>
  <tbody>

<?php
$requstat = $_POST['q'];
//$requstat = 'Y';
//$fulltext = '2020-01-01|2020-07-31';

$queryrequ = "SELECT TRXA_REQU_CODE, TRXA_REQU_DATE, TRXA_WARE_FROM,
            (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS WARE_FROM, 
             TRXA_WARE_DEST,
            (SELECT WARE_HOUS_NAME FROM waremast 
            WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS WARE_DEST,
            TRXA_REQU_STAT, TRXA_ENTR_USER,
            (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REQU_NAME
            FROM trxarequ WHERE TRXA_REQU_STAT IN ('R','A','C') AND TRXA_VIEW_STAT='$requstat'
            ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";
           
$qrequ = $db->query($queryrequ) or die("Gagal Ambil Data Request ");
while ($k = $qrequ->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $nomorrequest=$k['TRXA_REQU_CODE'];
  echo '<td style="width: 200px">'.$k['TRXA_REQU_CODE'].'|'.$k['REQU_NAME'].'</td>';
  $requdate = formatTanggal($k['TRXA_REQU_DATE']);
  echo '<td style="width: 200px">'.$requdate.'</td>';
  echo '<td style="width: 200px">'.$k['WARE_FROM'].'</td>';
  echo '<td style="width: 200px">'.$k['WARE_DEST'].'</td>';

  $status_request = $k['TRXA_REQU_STAT'];

  if ($status_request == 'R')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-view" align="left" onClick="approverequest(\''.$nomorrequest.'\');">Approve</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-delete" align="left" onClick="rejectrequest(\''.$nomorrequest.'\');">Reject</a>';
  echo '</td>';    
  }
  else if ($status_request == 'A')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-view" align="left" onClick="unapproverequest(\''.$nomorrequest.'\');">UnApprove</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button" align="left">Reject</a>';
  echo '</td>';    

  }

  else if ($status_request == 'C')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button" align="left">Approve</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">
        <a class="pure-button button-delete" align="left" onClick="unrejectrequest(\''.$nomorrequest.'\');">UnReject</a>';
  echo '</td>';    
  }
  else
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_request.'
        <a class="pure-button" align="left">UnApprove</a>';
  echo '</td>';  
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_request.'
        <a class="pure-button" align="left">Reject</a>';
  echo '</td>';    

  }

  echo '</tr>';
}
?>
  </tbody>
  </table>


