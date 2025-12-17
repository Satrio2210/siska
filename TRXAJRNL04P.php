<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (ISSET($_POST['tglstartdate'],$_POST['tglenddate']))
{

$startdate = $_POST['tglstartdate'];
$enddate = $_POST['tglenddate'];
$TanggaMulai = formatTanggal($startdate);
$TanggalSelesai=formatTanggal($enddate);

$title = 'Report Jurnal ' . $company;
$subtitle = 'Dari ' . $TanggaMulai . ' Sampai ' . $TanggalSelesai;
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
$pdf->Cell(190,4,$title,0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,4,$subtitle,0,1,'C');
// Kalimat Pembuka Kontrak
$pdf->SetFont('Arial','B',11);
// Line 1
$pdf->Ln(4);
$pdf->Cell(18,8,'Ref','LBT',0,'C');
$pdf->Cell(20,8,'Tanggal','BT',0,'C');
$pdf->Cell(54,8,'Keterangan','BT',0,'C');
$pdf->Cell(42,8,'Departemen','BT',0,'C');
$pdf->Cell(20,8,'Debet','BT',0,'C');
$pdf->Cell(20,8,'Kredit','BT',0,'C');
$pdf->Cell(20,8,'Saldo','BTR',1,'C');
$pdf->SetFont('Arial','',9);

$query1 = "SELECT DISTINCT(TRXA_JRNL_CODE) AS JRNL_CODE 
          FROM trxajrnl 
          WHERE TRXA_JRNL_STAT = 'Y' AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'";

$q1 = $db->query($query1) or die("Gagal Ambil Kode Transaksi!!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
$jrnlcode = $k1['JRNL_CODE'];
$pdf->Cell(18,6,$jrnlcode,'LT',0,'C');

$query2 = "SELECT TRXA_JRNL_DATE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE 
             FROM trxajrnl
             WHERE TRXA_JRNL_CODE='$jrnlcode' 
             AND TRXA_JRNL_STAT = 'Y' AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
             ORDER BY TRXA_ENTR_TIME
             LIMIT 1";
  $q2 = $db->query($query2) or die("Gagal Ambil Keterangan!!");
  while ($k2 = $q2->fetch(PDO::FETCH_ASSOC))
  {
  	$jrnldate = $k2['TRXA_JRNL_DATE'];
  	$pdf->Cell(20,6,$jrnldate,'T',0,'C');
  	$xjrnlnote = $k2['TRXA_JRNL_NOTE'];
  	$jrnlnote = substr($xjrnlnote, 0,35);
  	//$jrnlnote = ' ';
  	$pdf->Cell(54,6,$jrnlnote,'T',0);
  	$diviname = $k2['TRXA_DIVI_NAME'];
  	$pdf->Cell(42,6,$diviname,'T',0,'C');
	  $pdf->Cell(20,6,'','T',0,'C');
  	$pdf->Cell(20,6,'','T',0,'C');
	  $pdf->Cell(20,6,'','TR',1,'C');

    $varquery = "SET @CSUM := 0"; 
    $qvar = $db->query($varquery) or die("Gagal Set Variable");
    $var = $qvar->fetch(PDO::FETCH_ASSOC);

    $query3 = "SELECT TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,
              (@CSUM := @CSUM + TRXA_JRNL_DEBT) AS RUNN_DEBT,
              (@CSUM := @CSUM - TRXA_JRNL_CRDT) AS RUNN_CSUM 
              from trxajrnl
              WHERE TRXA_JRNL_CODE='$jrnlcode' AND TRXA_JRNL_STAT = 'Y'
              ORDER BY TRXA_JRNL_DEBT DESC";
    $q3 = $db->query($query3) or die("Gagal Ambil Debet Kredit!!");
    while ($k3 = $q3->fetch(PDO::FETCH_ASSOC))
    {
		$pdf->Cell(20,6,'','L',0,'C');
		$coaccode = $k3['TRXA_COAC_CODE'];
		$pdf->Cell(22,6,$coaccode,'',0,'L');
		$coacname = $k3['TRXA_COAC_NAME'];
		$pdf->Cell(50,6,$coacname,'',0,'L');
		$pdf->Cell(42,6,'','',0,'C');
		$jrnldebt = number_format($k3['TRXA_JRNL_DEBT'], 0, '', '.');
		$pdf->Cell(20,6,$jrnldebt,'',0,'R');
		$jrnlcrdt = number_format($k3['TRXA_JRNL_CRDT'], 0, '', '.');
		$pdf->Cell(20,6,$jrnlcrdt,'',0,'R');
		$runncsum = number_format($k3['RUNN_CSUM'], 0, '', '.');
		$pdf->Cell(20,6,$runncsum,'R',1,'R');
	}
	}
}

$pdf->Cell(18,1,'','LB',0,'C');
$pdf->Cell(20,1,'','B',0,'C');
$pdf->Cell(54,1,'','B',0,'C');
$pdf->Cell(42,1,'','B',0,'C');
$pdf->Cell(20,1,'','B',0,'C');
$pdf->Cell(20,1,'','B',0,'C');
$pdf->Cell(20,1,'','BR',1,'C');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(190,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','JRNL-' . $startdate . '-' . $enddate . '.pdf');

}
else
{
  header("location: "."TRXAJRNL04.php");
}


?>