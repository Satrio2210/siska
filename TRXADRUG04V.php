<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
?>
  <table class="pure-table pure-table-horizontal">
  <thead>
  <tr>
  <th style="width: 50px; text-align: center;">No.</th>  
  <th style="width: 100px; text-align: center;">Ref</th>
  <th style="width: 100px; text-align: center;">Date</th>
  <th style="width: 200px; text-align: center;">Paid</th> 
  <th style="width: 100px; text-align: right;">Disc</th>
  <th style="width: 100px; text-align: right;">Payment</th>
  </tr>
  </thead>
  <tbody>

<?php
$no=0;
if ($startdate == $enddate)
{
$query1 = "SELECT TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, TRXA_PAYM_MODE, TRXA_DRUG_STAT, TRXA_UPDT_DATE 
           FROM trxadrug
           WHERE TRXA_VIEW_STAT = 'Y' 
           AND TRXA_ENTR_DATE = '$startdate'";  

}
else
{
$query1 = "SELECT TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, TRXA_PAYM_MODE, TRXA_DRUG_STAT, TRXA_UPDT_DATE 
           FROM trxadrug
           WHERE TRXA_VIEW_STAT = 'Y' 
           AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";  
}

$q1 = $db->query($query1) or die("Gagal Ambil Kode Transaksi!!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
    $no++;

    if ($k1['TRXA_PAYM_MODE'] == 'BCA') 
    	{ 
    		$paymmode = 'Debit BCA';
    		echo '<tr style="background: rgb(139, 138, 205);">';
    	}
    else if ($k1['TRXA_PAYM_MODE'] == 'MAN') 
    	{ 
    		$paymmode = 'Debit Mandiri';
    		echo '<tr style="background: rgb(252, 248, 148);">';
    	}
    else if ($k1['TRXA_PAYM_MODE'] == 'BNI') 
    	{ 
    		$paymmode = 'Debit BNI';
    		echo '<tr style="background: rgb(253, 177, 135);">';
    	}
    else if ($k1['TRXA_PAYM_MODE'] == 'BCM') 
      { 
        $paymmode = 'Transfer BCA';
        echo '<tr style="background: rgb(67, 65, 251);">';
      }
    else if ($k1['TRXA_PAYM_MODE'] == 'LIN') 
      { 
        $paymmode = 'Transfer Link Aja';
        echo '<tr style="background: rgb(118, 250, 132);">';
      }

    else 
    	{ 
    		$paymmode = 'Tunai';
    		echo '<tr>';
    	}

    echo '<td style="width: 50px">'.$no.'</td>';
    echo '<td style="width: 100px">'.$k1['TRXA_DRUG_CODE'].'</td>';
    echo '<td style="width: 100px">'.$k1['TRXA_UPDT_DATE'].'</td>';

    $paymamnt = number_format($k1['TRXA_PAYM_AMNT'], 0, '', '.');
    echo '<td style="width: 150px">Rp. '.$paymamnt.'</td>';

    $paymdisc = number_format($k1['TRXA_PAYM_DISC'], 0, '', '.');    
    echo '<td style="width: 100px">Rp. '.$paymdisc.'</td>';

    echo '<td style="width: 100px">'.$paymmode.'</td>';
    echo '</tr>';
}  

// Total Tunai
$query_tun = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_TUN FROM trxadrug 
				WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'TUN' 
				AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_tun = $db->query($query_tun) or die("Gagal ambil Tunai");
$r_tun = $q_tun->fetch(PDO::FETCH_ASSOC);
$total_tun = number_format($r_tun['TOTAL_TUN'], 0, '', '.');
?>
  <tr>
  <td colspan= "2" style="width: 200px; text-align: right;">Tunai</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_tun; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

<?php
// Total Debit BCA
$query_bca = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BCA FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BCA' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bca = $db->query($query_bca) or die("Gagal ambil bca");
$r_bca = $q_bca->fetch(PDO::FETCH_ASSOC);
$total_bca = number_format($r_bca['TOTAL_BCA'], 0, '', '.');
?>
  <tr>
  <td colspan= "2" style="width: 200px; text-align: right;">Debit BCA</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_bca; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

<?php
// Total Debit Mandiri
$query_man = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_MAN FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'MAN' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_man = $db->query($query_man) or die("Gagal ambil mandiri");
$r_man = $q_man->fetch(PDO::FETCH_ASSOC);
$total_man = number_format($r_man['TOTAL_MAN'], 0, '', '.');
?>
  <tr>
  <td colspan= "2" style="width: 300px; text-align: right;">Debit Mandiri</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_man; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>
<?php
// Total Debit BNI
$query_bni = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BNI FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BNI' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bni = $db->query($query_bni) or die("Gagal ambil BNI");
$r_bni = $q_bni->fetch(PDO::FETCH_ASSOC);
$total_bni = number_format($r_bni['TOTAL_BNI'], 0, '', '.');
?>

  <tr>
  <td colspan= "2" style="width: 200px; text-align: right;">Debit BNI</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_bni; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

<?php
// Total Transfer BCA
$query_bcm = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BCM FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BCM' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bcm = $db->query($query_bcm) or die("Gagal ambil Transfer BCA");
$r_bcm = $q_bcm->fetch(PDO::FETCH_ASSOC);
$total_bcm = number_format($r_bcm['TOTAL_BCM'], 0, '', '.');
?>

  <tr>
  <td colspan= "2" style="width: 200px; text-align: right;">Transfer BCA</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_bcm; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

<?php
// Total Transfer Link Aja
$query_lin = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_LIN FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'LIN' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_lin = $db->query($query_lin) or die("Gagal ambil Transfer Link Aja");
$r_lin = $q_lin->fetch(PDO::FETCH_ASSOC);
$total_lin = number_format($r_lin['TOTAL_LIN'], 0, '', '.');
?>

  <tr>
  <td colspan= "2" style="width: 200px; text-align: right;">Transfer Link aja</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total_lin; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

<?php
// Total Semua
$query_total = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_total = $db->query($query_total) or die("Gagal ambil Total");
$r_total = $q_total->fetch(PDO::FETCH_ASSOC);
$total = number_format($r_total['TOTAL'], 0, '', '.');
?>

  <tr style="background: rgb(221, 221, 221);">
  <td colspan= "2" style="width: 200px; text-align: right;">Total</td>  
  <td style="width: 150px; text-align: right;">Rp. <?php echo $total; ?></td>
  <td colspan= "5" style="width: 480px; text-align: right;"></td>
  </tr>

  </tbody>
  </table>
<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


