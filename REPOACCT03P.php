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

$totalrev = 0;
$totalexp = 0;
$totalnet = 0;

$title = 'Report Profit Loss ' . $company;
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
$pdf->Cell(30,8,'Expense','BT',0,'C');
$pdf->Cell(30,8,'Revenue','BTR',1,'C');

$pdf->SetFont('Arial','',11);

// Ambil Akun Revenue               
$queryrev = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '4.%'
          AND COAC_FNRP_STAT = 'PL'
          AND COAC_VIEW_STAT='Y'
          ORDER BY COAC_MAST_CODE";
            
$qrev = $db->query($queryrev) or die("Gagal Ambil Akun Revenue");
while ($datarev = $qrev->fetch(PDO::FETCH_ASSOC))
{ 

  $coaccode = $datarev['MAST_CODE'];

  $coacname = $datarev['COAC_MAST_NAME'];
  $pdf->Cell(65,8,$coacname,'LBT',0,'L');

  // Ambil Nilai Saldo 
  $queryrev2 = "SELECT CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS SALDO
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE = '$coaccode'";
  $qrev2 = $db->query($queryrev2) or die("Gagal Ambil Saldo Revenue ");
  $datarev2 = $qrev2->fetch(PDO::FETCH_ASSOC);

  $totalrev = $totalrev+$datarev2['SALDO'];
  $saldorev = number_format($datarev2['SALDO'], 0, '', '.');
  $pdf->Cell(30,8,'','BT',0,'R');
  $pdf->Cell(30,8,$saldorev,'BTR',1,'R');

}

$pdf->Cell(65,8,'Beban beban','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BTR',1,'C');


// Ambil Akun Expense               
$queryexp = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_MAST_PRNT LIKE '5.%'
          AND COAC_FNRP_STAT = 'PL'
          AND COAC_VIEW_STAT = 'Y'
          ORDER BY COAC_MAST_CODE";
            
$qexp = $db->query($queryexp) or die("Gagal Ambil Akun Expense");
while ($dataexp = $qexp->fetch(PDO::FETCH_ASSOC))
{
  $coaccode = $dataexp['MAST_CODE'];
  $coacname = $dataexp['COAC_MAST_NAME'];
  $pdf->Cell(65,8,$coacname,'LBT',0,'L');


  // Ambil Nilai Saldo 
  $queryexp2 = "SELECT CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS SALDO
                  FROM trxajrnl 
                  WHERE TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
                  AND TRXA_JRNL_STAT = 'Y' 
                  AND TRXA_COAC_CODE = '$coaccode'";
  $qexp2 = $db->query($queryexp2) or die("Gagal Ambil Saldo Expense ");
  $dataexp2 = $qexp2->fetch(PDO::FETCH_ASSOC);

  $totalexp = $totalexp + $dataexp2['SALDO'];
  $saldoexp = number_format($dataexp2['SALDO'], 0, '', '.');

  $pdf->Cell(30,8,$saldoexp,'BT',0,'R');
  $pdf->Cell(30,8,'','BTR',1,'R');
}

// Ambil Total Saldo Beban
$pdf->Cell(65,8,'Total Beban','LBT',0,'R');
$pdf->Cell(30,8,'','BT',0,'R');
$summaryexp = number_format($totalexp, 0, '', '.');
$pdf->Cell(30,8,$summaryexp,'BTR',1,'R');

// Ambil Total Net
$pdf->Cell(65,8,'Laba Bersih','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'R');

$totalnet = ($totalrev - $totalexp);
$summarynet = number_format($totalnet, 0, '', '.');
$pdf->Cell(30,8,$summarynet,'BTR',1,'R');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(125,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','PL-' . $startdate . '-' . $enddate . '.pdf');

}
else
{
  header("location: "."REPOACCT03.php");
}

?>