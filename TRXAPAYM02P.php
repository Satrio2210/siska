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

  $title = 'Laporan Pengeluaran Kas ' . $company;
  $subtitle = 'Per ' . $TanggalMulai . ' Sampai ' . $TanggalSelesai . '';

  // memanggil library FPDF
  require('pdf/fpdf.php');
  // intance object dan memberikan pengaturan halaman PDF
  $pdf = new FPDF('p','mm','A4');
  $pdf->SetAutoPageBreak(true,40);
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
$pdf->setFillColor(153,204,255);

$pdf->Cell(20,8,'',0,0,'C');

$pdf->Cell(20,8,'Tanggal.','LBTR',0,'C',1);
$pdf->Cell(20,8,'Ref','BTR',0,'C',1);
$pdf->Cell(60,8,'Keterangan','BTR',0,'C',1);
$pdf->Cell(20,8,'Debet','BTR',0,'C',1);
$pdf->Cell(20,8,'Kredit','BTR',1,'C',1);

$pdf->SetFont('Arial','',10);

// ambil report
$querytanggal = "SELECT DISTINCT(TRXA_PAYM_DATE) AS TANGGAL, TRXA_PAYM_CODE AS REF, TRXA_PAYM_NOTE AS NOTE FROM trxapaym WHERE TRXA_VIEW_STAT = 'Y'
                 AND TRXA_PAYM_DATE BETWEEN '$startdate' AND '$enddate'";

$qtanggal = $db->query($querytanggal) or die("Gagal Ambil List Tanggal!!");
while ($rowtanggal = $qtanggal->fetch(PDO::FETCH_ASSOC))
{ 
  
  // Line 1
  $pdf->Cell(20,6,'',0,0,'C');

  $tanggal = $rowtanggal['TANGGAL'];
  $view_tanggal = formatTanggalBulan($tanggal);
  $pdf->Cell(20,6,''.$view_tanggal.'','LTR',0,'C');
  $ref = $rowtanggal['REF'];
  $pdf->Cell(20,6,''.$ref.'','TR',0,'C');
  $pdf->Cell(60,6,''.$rowtanggal['NOTE'].'','TR',0,'L');
  $pdf->Cell(20,6,' ','TR',0,'C');
  $pdf->Cell(20,6,' ','TR',1,'C');


  // line 2 - line 3
  $querypayment = "SELECT TRXA_COAC_CODE, LEFT(TRXA_COAC_CODE,3) AS CASH_PRNT, RIGHT(TRXA_COAC_CODE,1) AS CASH_CODE,
                  (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = CASH_PRNT AND COAC_MAST_CODE = CASH_CODE) AS COAC_NAME,

                          TRXA_PAYE_CODE, LEFT(TRXA_PAYE_CODE,3) AS COST_PRNT, SUBSTR(TRXA_PAYE_CODE,5,2) AS COST_CODE,
                  (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = COST_PRNT AND COAC_MAST_CODE = COST_CODE) AS PAYE_NAME,
                          TRXA_PAYM_AMNT 
                   FROM trxapaym 
                   WHERE TRXA_VIEW_STAT = 'Y'
                   AND TRXA_PAYM_CODE = '$ref' AND TRXA_PAYM_DATE = '$tanggal'
                   ORDER BY TRXA_COAC_CODE, TRXA_PAYE_CODE";
                   //var_dump($querypayment);
                   //exit();

  $qpayment = $db->query($querypayment) or die("Gagal ambil transaksi");
  while ($rowpayment = $qpayment->fetch(PDO::FETCH_ASSOC))
  {

    $pdf->Cell(20,6,'',0,0,'C');

    $pdf->Cell(20,6,' ','LR',0,'C');
    $pdf->Cell(20,6,' ','R',0,'C');
    $pdf->Cell(60,6,''.$rowpayment['COAC_NAME'].'','R',0,'C');
    $view_payment = number_format($rowpayment['TRXA_PAYM_AMNT'], 0, '', '.');
    $pdf->Cell(20,6,' ','R',0,'C');
    $pdf->Cell(20,6,''.$view_payment.'','R',1,'R');

    $pdf->Cell(20,6,'',0,0,'C');

    $pdf->Cell(20,6,' ','LR',0,'C');
    $pdf->Cell(20,6,' ','R',0,'C');
    $pdf->Cell(60,6,''.$rowpayment['PAYE_NAME'].'','R',0,'C');
    $pdf->Cell(20,6,''.$view_payment.'','R',0,'R');
    $pdf->Cell(20,6,' ','R',1,'C');

  }                 

}
// Total 
  $querytotal = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTAL  
                 FROM trxapaym 
                 WHERE TRXA_VIEW_STAT = 'Y'
                 AND TRXA_PAYM_DATE BETWEEN '$startdate' AND '$enddate'";

  $qtotal = $db->query($querytotal) or die("Gagal Ambil Jumlah Total Aja!!");
  $rowtotal = $qtotal->fetch(PDO::FETCH_ASSOC);

  $raw_total = $rowtotal['TOTAL'];

  $view_total = number_format($raw_total, 0, '', '.');

    $pdf->Cell(20,6,'',0,0,'C');

    $pdf->Cell(100,8,' ','LBTR',0,'C');
    $pdf->Cell(20,8,''.$view_total.'','BTR',0,'R');
    $pdf->Cell(20,8,''.$view_total.'','BTR',1,'R');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(180,4,'&copy; 2021, SISKA Development Legal.',0,1,'C');

$pdf->Output('I','PAYMENT-' . $startdate . '-' . $enddate . '.pdf');

}
else
{
  header("location: "."TRXAPAYM02.php");
}

?>