<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>

  <table class="pure-table pure-table-border">
  <thead>
  <tr>
  <th style="width: 50px; text-align: center;">No.</th>  
  <th style="width: 400px; text-align: center;">ICD</th>
  <th style="width: 100px; text-align: center;">Jumlah</th> 
  </tr>
  </thead>
  <tbody>

<?php
$no=0;
if ($startdate == $enddate)
{
$query1 = "SELECT DIAG_CODE, DIAG_NAME, COUNT(*) AS DIAG_COUNT 
          FROM (SELECT TRXA_DIAG_CODE AS DIAG_CODE, TRXA_DIAG_NAME AS DIAG_NAME, TRXA_ENTR_DATE AS ENTR_DATE, TRXA_ENTR_USER, 
                  (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER
                FROM trxadiag WHERE TRXA_VIEW_STAT = 'Y') AS DIAG_TABLE 
          WHERE ENTR_DATE = '$startdate'
          GROUP BY DIAG_CODE, DIAG_NAME
          ORDER BY DIAG_COUNT DESC";

}
else
{
$query1 = "SELECT DIAG_CODE, DIAG_NAME, COUNT(*) AS DIAG_COUNT 
          FROM (SELECT TRXA_DIAG_CODE AS DIAG_CODE, TRXA_DIAG_NAME AS DIAG_NAME, TRXA_ENTR_DATE AS ENTR_DATE, TRXA_ENTR_USER, 
                  (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS ENTR_USER
                FROM trxadiag WHERE TRXA_VIEW_STAT = 'Y') AS DIAG_TABLE 
          WHERE ENTR_DATE BETWEEN '$startdate' AND '$enddate'
          GROUP BY DIAG_CODE, DIAG_NAME
          ORDER BY DIAG_COUNT DESC";

}

$q1 = $db->query($query1) or die("Gagal Ambil ICD !!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
    $no++;

    $diagcode = $k1['DIAG_CODE'];
    $diagname = $k1['DIAG_NAME'];
    $diagcount = $k1['DIAG_COUNT'];
 
    echo '<td style="width: 50px; text-align: center;">'.$no.'</td>';
    echo '<td style="width: 400px"><b>'.$diagcode.'</b> - '.$diagname.'</td>';
    echo '<td style="width: 100px; text-align: center;">'.$diagcount.'</td>';

    echo '</tr>';
}  


?>


  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


