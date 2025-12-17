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

$beforedate = date('Y-m-d', strtotime('-1 days', strtotime($startdate)));
$xgetyear = strtotime($beforedate);
$getyear = date('Y',$xgetyear);
$firstdate=$getyear.'-01-01';  

$title = 'Report Equity ' . $company;
$subtitle = 'Periode :' . $TanggalSelesai;
// memanggil library FPDF
require('pdf/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('p','mm','A4');
$pdf->SetAutoPageBreak(true);
// membuat halaman baru
$pdf->AddPage();

$pdf->SetLeftMargin(40);

$pdf->Ln(5);
// setting jenis font yang akan digunakan 
$pdf->SetFont('Arial','B',14);
//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
$pdf->Cell(125,4,$title,0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(125,4,$subtitle,0,1,'C');
// Mulai Looping data
$pdf->Ln(5);

// Line 1
$pdf->Cell(65,8,'Description','LBT',0,'C');
$pdf->Cell(30,8,'Invest','BT',0,'C');
$pdf->Cell(30,8,'Prive','BTR',1,'C');

$pdf->SetFont('Arial','',11);

// Ambil Akun Modal               
$querymodal = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '3.1%'
          AND COAC_VIEW_STAT = 'Y'";
            
$qmod = $db->query($querymodal) or die("Gagal Ambil Akun Modal");
$datamod = $qmod->fetch(PDO::FETCH_ASSOC);
 
$coaccode = $datamod['MAST_CODE'];
$coacname = $datamod['COAC_MAST_NAME'];
$pdf->Cell(65,8,'Modal Awal','LBT',0,'L');

// Ambil Nilai Saldo Modal
$querymodal2 = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_MODAL FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '3.%'
              AND TRXA_JRNL_STAT='Y'";
$qmod2 = $db->query($querymodal2) or die("Gagal Ambil Saldo Modal ");
$datamod2 = $qmod2->fetch(PDO::FETCH_ASSOC);
$xsaldomod = $datamod2['SALDO_MODAL'];
$saldomod = number_format($xsaldomod, 0, '', '.');
$pdf->Cell(30,8,$saldomod,'BT',0,'R');
$pdf->Cell(30,8,'','BTR',1,'R');

// Ambil Saldo Revenue               
$queryrev = "SELECT SUM(TRXA_JRNL_CRDT-TRXA_JRNL_DEBT) AS SALDO_REVENUE FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '4.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qrev = $db->query($queryrev) or die("Gagal Ambil Saldo Revenue");
$datarev = $qrev->fetch(PDO::FETCH_ASSOC);
$saldorevenue = $datarev['SALDO_REVENUE'];

// Ambil Saldo Expense               
$queryexp = "SELECT SUM(TRXA_JRNL_DEBT-TRXA_JRNL_CRDT) AS SALDO_EXPENSE FROM trxajrnl
              WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate' 
              AND TRXA_COAC_CODE LIKE '5.%'
              AND TRXA_JRNL_STAT='Y'";
            
$qexp = $db->query($queryexp) or die("Gagal Ambil Saldo Expense");
$dataexp = $qexp->fetch(PDO::FETCH_ASSOC);
$saldoexpense = $dataexp['SALDO_EXPENSE'];

$xsaldonet = ($saldorevenue - $saldoexpense);
$saldonet = number_format($xsaldonet, 0, '', '.');
$pdf->Cell(65,8,'Laba Bersih','LBT',0,'L');
$pdf->Cell(30,8,$saldonet,'BT',0,'R');
$pdf->Cell(30,8,'','BTR',1,'R');

// Ambil Kenaikan Modal Pemilik

$pdf->Cell(65,8,'Kenaikan Modal Pemilik','LBT',0,'R');
$pdf->Cell(30,8,'','BT',0,'R');
$xmodalplusnet = ($xsaldomod + $xsaldonet);
$modalplusnet = number_format($xmodalplusnet, 0, '', '.');
$pdf->Cell(30,8,$modalplusnet,'BTR',1,'R');

// Ambil Modal Sesudah laba 
$pdf->Cell(65,8,'Modal Akhir','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'R');
$pdf->Cell(30,8,$modalplusnet,'BTR',1,'R');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(125,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','EQ-' . $startdate . '-' . $enddate . '.pdf');
}
else
{
  header("location: "."REPOACCT04.php");
}

?>