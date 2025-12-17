<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>

  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 100px; text-align: center;">Opname</th>
  <th style="width: 100px; text-align: center;">Date</th>
  <th style="width: 200px; text-align: center;">Ware House</th>
  <th style="width: 200px; text-align: center;">Dead Line</th>
  <th style="width: 200px; text-align: center;">Opname By</th>
  <th style="width: 100px; text-align: center;">Action</th>
 

  </tr>
  </thead>
  <tbody>

<?php
$opnastat = $_POST['q'];
//$opnastat = 'Y';
$queryopna = "SELECT TRXA_OPNA_CODE, TRXA_OPNA_DATE, TRXA_WARE_CODE, 
              (SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE=TRXA_WARE_CODE) AS HOUS_NAME, 
              TRXA_FINS_DATE, TRXA_EMPL_CODE,
              (SELECT CONCAT(EMPL_FRST_NAME, ' ',EMPL_LAST_NAME) AS EMPL_NAME 
              FROM emplmast WHERE EMPL_MAST_CODE=TRXA_EMPL_CODE) AS EMPL_NAME,
              TRXA_OPNA_STAT
              FROM trxaopna WHERE TRXA_OPNA_STAT IN ('I','A')
              AND TRXA_VIEW_STAT='$opnastat'
              ORDER BY TRXA_OPNA_DATE";
           
$qopna = $db->query($queryopna) or die("Gagal Ambil Data Input Opname ");
while ($k = $qopna->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $nomoropna=$k['TRXA_OPNA_CODE'];
  echo '<td style="width: 100px">'.$k['TRXA_OPNA_CODE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_OPNA_DATE'].'</td>';
  echo '<td style="width: 200px">'.$k['HOUS_NAME'].'</td>';
  echo '<td style="width: 200px">'.$k['TRXA_FINS_DATE'].'</td>';

  if ($k['EMPL_NAME'] == '')
  {
      $emplname = 'Admin';
  }
  else
  {
      $emplname = $k['EMPL_NAME'];
  }
  echo '<td style="width: 200px">'.$emplname.' </td>';

  $status_opname = $k['TRXA_OPNA_STAT'];

  if ($status_opname == 'I')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_opname.'
        <a class="pure-button button-view" align="left" onClick="adjustment(\''.$nomoropna.'\');">Adjustment</a>';
  echo '</td>';  
  }
  else if ($status_opname == 'A')
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_opname.'
        <a class="pure-button button-view" align="left" onClick="unadjustment(\''.$nomoropna.'\');">UnAdjustment</a>';
  echo '</td>';  

  }

  else
  {
  echo '<td style="width: 100px; text-align: center;" style="cursor:pointer">status ='.$status_opname.'
        <a class="pure-button" align="left">UnAdjustment</a>';
  echo '</td>';  

  }

  echo '</tr>';
}
?>
  </tbody>
  </table>


