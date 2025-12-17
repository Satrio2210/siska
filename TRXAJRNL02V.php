<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
#screen {
    font-family: Arial, Helvetica, sans-serif;
    font-size:11;
    border-collapse: collapse;
    width: 100%;
}


#screen th {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}

#screen td {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center;
}

#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

table tbody, table thead
{
    display: block;
}
table tbody 
{
  overflow: auto;
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px">TANGGAL</th>
  <th style="width: 100px">AKUN</th>
  <th style="width: 200px">KETERANGAN</th>
  <th style="width: 200px">DEBET</th>
  <th style="width: 200px">KREDIT</th>
  <th style="width: 200px">SALDO</th>
  
  </tr>
  </thead>
  <tbody>
<?php
$kodetransaksi = xss_clean($_POST['q']);
//$kodetransaksi = 'TA-0001';

//  $datenow = date("Y-m-d");
//  $xdatenow = strtotime($datenow);
//  $yearnow = date('Y',$xdatenow);
//  $monthnow = date('m',$xdatenow);
//  $daynow = date('d',$xdatenow);

 $varquery = "SET @CSUM := 0"; 
 $qvar = $db->query($varquery) or die("Gagal Set Variable");
 $var = $qvar->fetch(PDO::FETCH_ASSOC);
 
$xquery = 
"SELECT  TRXA_JRNL_DATE,
    TRXA_COAC_CODE, 
    TRXA_COAC_NAME,
    TRXA_JRNL_DEBT,
    TRXA_JRNL_CRDT,
    (@CSUM := @CSUM + TRXA_JRNL_DEBT) AS RUNN_DEBT,
    (@CSUM := @CSUM - TRXA_JRNL_CRDT) AS RUNN_CSUM, TRXA_ENTR_TIME
  FROM trxajrnl
  WHERE TRXA_JRNL_CODE = '$kodetransaksi' AND TRXA_JRNL_STAT='Y'
  ORDER BY TRXA_JRNL_DEBT DESC";
  $q = $db->query($xquery) or die("Gagal Get Tabel trxajrnl");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$coaccode = $k['TRXA_COAC_CODE'];
$entrtime = $k['TRXA_ENTR_TIME'];
echo '<td style="width: 100px;" onClick="viewcode(\''.$kodetransaksi.'\',\''.$coaccode.'\',\''.$entrtime.'\');" 
      style="cursor:pointer">'.$k['TRXA_JRNL_DATE'].'</td>';
echo '<td style="width: 100px">'.$k['TRXA_COAC_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['TRXA_COAC_NAME'].'</td>';
$xjrnldebt = $k['TRXA_JRNL_DEBT'];
$jrnldebt = number_format($xjrnldebt, 0, '', '.');
echo '<td style="width: 200px">Rp. '.$jrnldebt.'</td>';
$xjrnlcrdt = $k['TRXA_JRNL_CRDT'];
$jrnlcrdt = number_format($xjrnlcrdt, 0, '', '.');
echo '<td style="width: 200px">Rp. '.$jrnlcrdt.'</td>';
$xrunncsum = $k['RUNN_CSUM'];
$runncsum = number_format($xrunncsum, 0, '', '.');
echo '<td style="width: 200px">Rp. '.$runncsum.'</td>';
echo '</tr>';
}
?>
  <tr>
  <td colspan=3>Total Saldo</td>
  <td>Rp.
<?php
$yquery = 
"SELECT  SUM(TRXA_JRNL_DEBT) AS SALDO_DEBET
  FROM trxajrnl
  WHERE TRXA_JRNL_CODE = '$kodetransaksi' AND TRXA_JRNL_STAT='Y'";

$qy = $db->query($yquery) or die("Gagal Get SUM Debet");
$dr = $qy->fetch(PDO::FETCH_ASSOC);
$xdramnt = $dr['SALDO_DEBET'];
$dramnt = number_format($xdramnt, 0, '', '.'); 
echo $dramnt;
?>
</td>
  <td>Rp.
<?php
$zquery = 
"SELECT  SUM(TRXA_JRNL_CRDT) AS SALDO_KREDIT
  FROM trxajrnl
  WHERE TRXA_JRNL_CODE = '$kodetransaksi' AND TRXA_JRNL_STAT='Y'";

$qz = $db->query($zquery) or die("Gagal Get SUM Credit");
$cr = $qz->fetch(PDO::FETCH_ASSOC);
$xcramnt = $cr['SALDO_KREDIT'];
$cramnt = number_format($xcramnt, 0, '', '.');
echo $cramnt; 
?>
  </td>
  <td>Rp.
    <?php $xsamnt = $xdramnt - $xcramnt;
    $samnt = number_format($xsamnt, 0, '', '.'); 
    echo $samnt; ?></td>
  </tr>
  </tbody>
  </table>


