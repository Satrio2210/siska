<?php
include "conf/config.php";
include "inc/sanie.php";
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>
  <table class="pure-table">
  <thead>
  <tr>
  <th style="width: 200px; text-align: center;">Invoice</th>
  <th style="width: 100px; text-align: center;">Date</th>
  <th style="width: 100px; text-align: center;">Order</th>
  <th style="width: 100px; text-align: center;">Expire</th>
  <th style="width: 300px; text-align: center;">Suplier</th>
  <th style="width: 200px; text-align: center;">Status</th>
  <th style="width: 200px; text-align: center;">Task</th>
  

  </tr>
  </thead>
  <tbody>

<?php
  $code = xss_clean($_POST['q']);
  //$fieldid = 'Y';
  if ($code == 'Y') 
  {
  $userid = $_SESSION['username'];
  //$userid = 'ASRUL';    
  } 
  else
  {
    $userid = 'noid';
  }

$queryinvoice = "SELECT TRXA_INVC_CODE, TRXA_INVC_DATE, TRXA_PROC_CODE, TRXA_DUED_DATE, TRXA_SUPL_CODE,
            (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
            TRXA_INVC_STAT
            FROM trxainvc WHERE TRXA_INVC_STAT IN ('U','O') AND TRXA_ENTR_USER='$userid' AND TRXA_VIEW_STAT='Y'";
           
$qinvoice = $db->query($queryinvoice) or die("Gagal Ambil Data Invoice ");
while ($k = $qinvoice->fetch(PDO::FETCH_ASSOC))
{ 
  echo '<tr>';
  $nomorinvoice=$k['TRXA_INVC_CODE'];
  echo '<td style="width: 100px">'.$k['TRXA_INVC_CODE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_INVC_DATE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_PROC_CODE'].'</td>';
  echo '<td style="width: 100px">'.$k['TRXA_DUED_DATE'].'</td>';
  echo '<td style="width: 300px">'.$k['SUPL_NAME'].'</td>';
  if ($k['TRXA_INVC_STAT'] == 'U') { $invcstat = 'Di ajukan';}
  else if ($k['TRXA_INVC_STAT'] == 'O') { $invcstat = 'Proses Pembayaran';}
  else { $invcstat = 'Lunas';}
  echo '<td style="width: 200px">'.$invcstat.'</td>';
  echo '<td style="width: 100px;" style="cursor:pointer">';
        ?>
        <a class="pure-button button-print" onClick="javascript: location.href ='TRXAPROC06P.php?nomor=<?php echo $nomorinvoice;?>'">Print</a>
  <?php
  if ($k['TRXA_INVC_STAT'] == 'U')
  {
  echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$nomorinvoice.'\');}
              else
              { alert(\'Cancel Delete\');}
        ">Delete</a>';
  }
  else
  {
  echo '<a>Delete</a>';
  }

  echo '</td>';

  echo '</tr>';
}
?>
  </tbody>
  </table>
<?php
}
?>

