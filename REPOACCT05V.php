<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
?>
  <H2 style="color: #339cff"; class="content-subhead">Neraca</H2>
  <table class="pure-table pure-table-horizontal">
  <?php
  $fulldate = $_POST['q'];
  //$fulltext = '2020-01-01|2020-07-31';
  list($startdate, $enddate) = explode("|",$fulldate);
  $beforedate = date('Y-m-d', strtotime('-1 days', strtotime($startdate)));
  $xgetyear = strtotime($beforedate);
  $getyear = date('Y',$xgetyear);
  $firstdate=$getyear.'-01-01';  
  ?>
  <tbody>
  <tr class="pure-table-odd">
  <td style="width: 300px; text-align: left;"><b>AKTIVA</b></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  </tr>

<?php
// Ambil Akun Group Aktiva              
$queryaktiva = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '1.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qaktiva = $db->query($queryaktiva) or die("Gagal Ambil Group Akun");
while ($rowaktiva = $qaktiva->fetch(PDO::FETCH_ASSOC))
{
echo '<tr>';
$coaccode = $rowaktiva['TBLA_COAC_CODE'];
$coacname = $rowaktiva['TBLA_COAC_NAME'];
echo '<td style="width: 300px; text-align: left;">'.$coacname.'</td>';

// Ambil Nilai Saldo Group Aktiva
$queryaktiva2 = "SELECT SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT) AS SALDO_GROUP
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE LIKE '$coaccode%'";
  $qaktiva2 = $db->query($queryaktiva2) or die("Gagal Ambil Saldo Group ");
  $rowaktiva2 = $qaktiva2->fetch(PDO::FETCH_ASSOC);
  $xsaldo_group = $rowaktiva2['SALDO_GROUP'];
  $saldo_group = number_format($xsaldo_group, 0, '', '.');
  echo '<td style="width: 100px;text-align: right;">'.$saldo_group.'</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';  
  echo '<td style="width: 100px;text-align: right;"> </td>';  

  echo '</tr>';

}

// Ambil Saldo Akumulasi Group Aktiva               
$querysaldoaktiva = "SELECT SUM(TRXA_JRNL_DEBT-TRXA_JRNL_CRDT) AS SALDO_AKTIVA FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '1.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qsaldoaktiva = $db->query($querysaldoaktiva) or die("Gagal Ambil Saldo Aktiva");
$rowsaldoaktiva = $qsaldoaktiva->fetch(PDO::FETCH_ASSOC);
$xsaldo_aktiva = $rowsaldoaktiva['SALDO_AKTIVA'];
$saldo_aktiva = number_format($xsaldo_aktiva, 0, '', '.');

echo '<tr class="pure-table-odd">';
echo '<td style="width: 300px"><b>Total Aktiva</td>';
echo '<td style="width: 100px;text-align: right;"> </td>';
echo '<td style="width: 100px;text-align: right;"></td>';
echo '<td style="width: 100px;text-align: right;"><b>'.$saldo_aktiva.'</b></td>';  
echo '</tr>'; 

?>
  <tr class="pure-table-odd">
  <td style="width: 300px; text-align: left;"><b>PASIVA</b></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  </tr>

<?php
// Ambil Akun Group Pasiva              
$queryPasiva = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '2.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qPasiva = $db->query($queryPasiva) or die("Gagal Ambil Group Akun");
while ($rowPasiva = $qPasiva->fetch(PDO::FETCH_ASSOC))
{
echo '<tr>';
$coaccode = $rowPasiva['TBLA_COAC_CODE'];
$coacname = $rowPasiva['TBLA_COAC_NAME'];
echo '<td style="width: 300px; text-align: left;">'.$coacname.'</td>';

// Ambil Nilai Saldo Group Pasiva
$queryPasiva2 = "SELECT SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT) AS SALDO_GROUP
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE LIKE '$coaccode%'";
  $qPasiva2 = $db->query($queryPasiva2) or die("Gagal Ambil Saldo Group ");
  $rowPasiva2 = $qPasiva2->fetch(PDO::FETCH_ASSOC);
  $xsaldo_group = $rowPasiva2['SALDO_GROUP'];
  $saldo_group = number_format($xsaldo_group, 0, '', '.');
  echo '<td style="width: 100px;text-align: right;">'.$saldo_group.'</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';  
  echo '<td style="width: 100px;text-align: right;"> </td>';  

  echo '</tr>';

}

// Ambil Saldo Akumulasi Group Pasiva               
$querysaldoPasiva = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_PASIVA FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '2.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qsaldoPasiva = $db->query($querysaldoPasiva) or die("Gagal Ambil Saldo Pasiva");
$rowsaldoPasiva = $qsaldoPasiva->fetch(PDO::FETCH_ASSOC);
$xsaldo_Pasiva = $rowsaldoPasiva['SALDO_PASIVA'];
$saldo_Pasiva = number_format($xsaldo_Pasiva, 0, '', '.');

echo '<tr class="pure-table-odd">';
echo '<td style="width: 300px"><b>Sub Total Pasiva</b></td>';
echo '<td style="width: 100px;text-align: right;"> </td>';
echo '<td style="width: 100px;text-align: right;">'.$saldo_Pasiva.'</td>';
echo '<td style="width: 100px;text-align: right;"> </td>';  
echo '</tr>'; 

?>
  <tr class="pure-table-odd">
  <td style="width: 300px; text-align: left;"><b>CAPITAL</b></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  <td style="width: 100px; text-align: right;"></td>
  </tr>

<?php
// Ambil Akun Group Capital              
$queryCapital = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '3.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qCapital = $db->query($queryCapital) or die("Gagal Ambil Group Akun");
while ($rowCapital = $qCapital->fetch(PDO::FETCH_ASSOC))
{
echo '<tr>';
$coaccode = $rowCapital['TBLA_COAC_CODE'];
$coacname = $rowCapital['TBLA_COAC_NAME'];
echo '<td style="width: 300px; text-align: left;">'.$coacname.'</td>';

// Ambil Nilai Saldo Group Capital
$queryCapital2 = "SELECT SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT) AS SALDO_GROUP
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE LIKE '$coaccode%'";
  $qCapital2 = $db->query($queryCapital2) or die("Gagal Ambil Saldo Group ");
  $rowCapital2 = $qCapital2->fetch(PDO::FETCH_ASSOC);
  $xsaldo_group = $rowCapital2['SALDO_GROUP'];
  $saldo_group = number_format($xsaldo_group, 0, '', '.');
  echo '<td style="width: 100px;text-align: right;">'.$saldo_group.'</td>';
  echo '<td style="width: 100px;text-align: right;"> </td>';  
  echo '<td style="width: 100px;text-align: right;"> </td>';  

  echo '</tr>';

}

// Ambil Saldo Akumulasi Group Capital               
$querysaldoCapital = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_CAPITAL FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '3.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qsaldoCapital = $db->query($querysaldoCapital) or die("Gagal Ambil Saldo Capital");
$rowsaldoCapital = $qsaldoCapital->fetch(PDO::FETCH_ASSOC);
$xsaldo_Capital = $rowsaldoCapital['SALDO_CAPITAL'];
$saldo_Capital = number_format($xsaldo_Capital, 0, '', '.');

echo '<tr class="pure-table-odd">';
echo '<td style="width: 300px"><b>Sub Total Capital</b></td>';
echo '<td style="width: 100px;text-align: right;"> </td>';
echo '<td style="width: 100px;text-align: right;">'.$saldo_Capital.'</td>';
echo '<td style="width: 100px;text-align: right;"> </td>';  
echo '</tr>'; 

echo '<tr class="pure-table-odd">';
echo '<td style="width: 300px"><b>Total Pasiva + Capital</b></td>';
echo '<td style="width: 100px;text-align: right;"> </td>';
echo '<td style="width: 100px;text-align: right;"></td>';
$xsaldo_pasiva_capital = $xsaldo_Pasiva+$xsaldo_Capital;
$saldo_pasiva_capital = number_format($xsaldo_pasiva_capital, 0, '', '.');
echo '<td style="width: 100px;text-align: right;"><b>'.$saldo_pasiva_capital.'</b></td>';  
echo '</tr>'; 
?>
  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.  
  </center>
</div>


