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

$saldodebet = 0;
$saldokredit = 0;

$title = 'Report Trial Balance ' . $company;
$subtitle = 'Periode :' . $TanggalSelesai;
// memanggil library FPDF
require('pdf/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('p','mm','A4');
$pdf->SetAutoPageBreak(true);
// membuat halaman baru
$pdf->AddPage();

$pdf->SetLeftMargin(25);

$pdf->Ln(5);
// setting jenis font yang akan digunakan 
$pdf->SetFont('Arial','B',14);
//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
$pdf->Cell(155,4,$title,0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(155,4,$subtitle,0,1,'C');
// Mulai Looping data
$pdf->Ln(5);

// Line 1
$pdf->Cell(30,8,'Code','LBT',0,'C');
$pdf->Cell(65,8,'Account Name','BT',0,'C');
$pdf->Cell(30,8,'Debet','BT',0,'C');
$pdf->Cell(30,8,'Kredit','BTR',1,'C');

$pdf->SetFont('Arial','',11);

// ambil nama akun
$xxxquery1 = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_NAME, COAC_NORM_BLNC 
          FROM coacmast 
          WHERE COAC_VIEW_STAT='Y'
          ORDER BY COAC_MAST_CODE";

$query1 = "SELECT DISTINCT(TRXA_COAC_CODE) AS MAST_CODE, TRXA_COAC_NAME AS MAST_NAME, 
          (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = TRXA_COAC_CODE) AS NORM_BLNC 
          FROM trxajrnl
          WHERE TRXA_JRNL_STAT = 'Y'
          ORDER BY TRXA_COAC_CODE";
            
$q1 = $db->query($query1) or die("Gagal Ambil Kode Akun ");
while ($data1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 

  $coaccode = $data1['MAST_CODE'];
  $pdf->Cell(30,8,$coaccode,'LBT',0,'C');

  $coacname = $data1['MAST_NAME'];
  $pdf->Cell(65,8,$coacname,'BT',0,'L');
  $normblnc = $data1['NORM_BLNC'];

  // Ambil Nilai Saldo 
  $query2 = "SELECT CASE 
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

  $q2 = $db->query($query2) or die("Gagal Ambil Saldo Debet, Kredit ");
  $data2 = $q2->fetch(PDO::FETCH_ASSOC);
  if ($normblnc == 'DB')
  {
    $saldodebet = $saldodebet+$data2['SALDO'];
    $balance = number_format($data2['SALDO'], 0, '', '.');

    $pdf->Cell(30,8,$balance,'BT',0,'R');
    $pdf->Cell(30,8,'0','BTR',1,'R');
  }
  else
  {
    $saldokredit = $saldokredit+$data2['SALDO'];
    $balance = number_format($data2['SALDO'], 0, '', '.');

    $pdf->Cell(30,8,'0','BT',0,'R');
    $pdf->Cell(30,8,$balance,'BTR',1,'R');

  }
}
// Ambil Total Saldo
$pdf->Cell(30,8,'','LBT',0,'C');
$pdf->Cell(65,8,'','BT',0,'C');
$sumdebt = number_format($saldodebet, 0, '', '.');
$pdf->Cell(30,8,$sumdebt,'BT',0,'R');
$sumcrdt = number_format($saldokredit, 0, '', '.');
$pdf->Cell(30,8,$sumcrdt,'BTR',1,'R');

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(155,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','TB-' . $startdate . '-' . $enddate . '.pdf');
}
else
{
  header("location: "."REPOACCT02.php");
}

?>