<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (ISSET($_POST['tglstartdate'],$_POST['tglenddate']))
{

$startdate = $_POST['tglstartdate'];
$enddate = $_POST['tglenddate'];
$TanggalMulai = formatTanggal($startdate);
$TanggalSelesai=formatTanggal($enddate);

$title = 'Report Farmasi  ' . $company;
$subtitle = 'Dari Tanggal ' . $TanggalMulai . ' Sampai ' . $TanggalSelesai . '';

// memanggil library FPDF
require('pdf/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('p','mm','A4');
$pdf->SetAutoPageBreak(true);
// membuat halaman baru
$pdf->AddPage();

$pdf->Ln(5);
// setting jenis font yang akan digunakan 
$pdf->SetFont('Arial','B',14);
//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
$pdf->Image('img/logo.png',10,5,20);
$pdf->Cell(190,4,$title,0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,4,$subtitle,0,1,'C');
// Mulai Looping data
$pdf->SetFont('Arial','B',10);

$pdf->Ln(5);
  // Line 1
  $pdf->Cell(10,8,'No.','LBTR',0,'C');
  $pdf->Cell(30,8,'Ref','BTR',0,'C');
  $pdf->Cell(30,8,'Date','BTR',0,'C');
  $pdf->Cell(30,8,'Paid','BTR',0,'C');
  $pdf->Cell(30,8,'Disc','BTR',0,'C');
  $pdf->Cell(20,8,'Payment','BTR',1,'C');

$pdf->SetFont('Arial','',10);

// ambil report
$no=0;          
$query1 = "SELECT TRXA_DRUG_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_DISC, 
           TRXA_PAYM_MODE, TRXA_DRUG_STAT, TRXA_UPDT_DATE 
           FROM trxadrug
           WHERE TRXA_VIEW_STAT = 'Y' 
           AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q1 = $db->query($query1) or die("Gagal Ambil Report!!");
while ($data1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 

  $no++;
  // Line 1
  $pdf->Cell(10,8,''.$no.'','LBTR',0,'C');
  $pdf->Cell(30,8,''.$data1['TRXA_DRUG_CODE'].'','LBTR',0,'C');
  $pdf->Cell(30,8,''.$data1['TRXA_UPDT_DATE'].'','BTR',0,'L');

  $paymamnt = number_format($data1['TRXA_PAYM_AMNT'], 0, '', '.');
  $pdf->Cell(10,8,'Rp.','BT',0,'R');
  $pdf->Cell(20,8,''.$paymamnt.'','BTR',0,'R');

  $paymdisc = number_format($data1['TRXA_PAYM_DISC'], 0, '', '.');
  $pdf->Cell(10,8,'Rp.','BT',0,'R');    
  $pdf->Cell(20,8,''.$paymdisc.'','BTR',0,'R');

  if ($data1['TRXA_PAYM_MODE'] == 'BCA') { $paymmode = 'Debit BCA';}
  else if ($data1['TRXA_PAYM_MODE'] == 'MAN') { $paymmode = 'Debit Mandiri';}
  else if ($data1['TRXA_PAYM_MODE'] == 'BNI') { $paymmode = 'Debit BNI';}
  else if ($data1['TRXA_PAYM_MODE'] == 'BCM') { $paymmode = 'Transfer BCA';}
  else if ($data1['TRXA_PAYM_MODE'] == 'LIN') { $paymmode = 'Transfer Link aja';}
  else { $paymmode = 'Tunai';}
  $pdf->Cell(20,8,''.$paymmode.'','BTR',1,'C');
}
// Total Tunai
$query_tun = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_TUN FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'TUN' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_tun = $db->query($query_tun) or die("Gagal ambil Tunai");
$r_tun = $q_tun->fetch(PDO::FETCH_ASSOC);
$total_tun = number_format($r_tun['TOTAL_TUN'], 0, '', '.');

// Total Debit BCA
$query_bca = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BCA FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BCA' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bca = $db->query($query_bca) or die("Gagal ambil bca");
$r_bca = $q_bca->fetch(PDO::FETCH_ASSOC);
$total_bca = number_format($r_bca['TOTAL_BCA'], 0, '', '.');

// Total Debit Mandiri
$query_man = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_MAN FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'MAN' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_man = $db->query($query_man) or die("Gagal ambil mandiri");
$r_man = $q_man->fetch(PDO::FETCH_ASSOC);
$total_man = number_format($r_man['TOTAL_MAN'], 0, '', '.');

// Total Debit BNI
$query_bni = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BNI FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BNI' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bni = $db->query($query_bni) or die("Gagal ambil BNI");
$r_bni = $q_bni->fetch(PDO::FETCH_ASSOC);
$total_bni = number_format($r_bni['TOTAL_BNI'], 0, '', '.');


// Total Transfer BCA
$query_bcm = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_BCM FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'BCM' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_bcm = $db->query($query_bcm) or die("Gagal ambil Transfer BCA");
$r_bcm = $q_bcm->fetch(PDO::FETCH_ASSOC);
$total_bcm = number_format($r_bcm['TOTAL_BCM'], 0, '', '.');


// Total Transfer Link Aja
$query_lin = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL_LIN FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' AND TRXA_PAYM_MODE = 'LIN' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_lin = $db->query($query_lin) or die("Gagal ambil Transfer Link Aja");
$r_lin = $q_lin->fetch(PDO::FETCH_ASSOC);
$total_lin = number_format($r_lin['TOTAL_LIN'], 0, '', '.');

// Total Semua
$query_total = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL FROM trxadrug 
        WHERE TRXA_VIEW_STAT='Y' 
        AND TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'";

$q_total = $db->query($query_total) or die("Gagal ambil Total");
$r_total = $q_total->fetch(PDO::FETCH_ASSOC);
$total = number_format($r_total['TOTAL'], 0, '', '.');

$pdf->Cell(40,8,'Total Tunai','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_tun.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total Debit BCA','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_bca.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total Debit Mandiri','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_man.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total Debit BNI','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_bni.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total Transfer BCA','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_bcm.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total Transfer Link Aja','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total_lin.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Cell(40,8,'Total ','LBT',0,'R');
$pdf->Cell(30,8,'Rp. '.$total.'','BT',0,'R');
$pdf->Cell(80,8,' ','BTR',1,'R');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(190,4,'&copy; 2021, SISKA Development Legal.',0,1,'C');

$pdf->Output('I','KASIR-' . $startdate . '-' . $enddate . '.pdf');

}
else
{
  header("location: "."TRXASALE03.php");
}

?>