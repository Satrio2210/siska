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

$title = 'Report General Ledger ' . $company;
$subtitle = 'Periode :' . $TanggalSelesai;
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
// Mulai Looping data
$pdf->Ln(2);
// ambil nama akun
$xxxquery1 = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS COAC_CODE, COAC_MAST_NAME AS TRXA_COAC_NAME 
          FROM coacmast 
          WHERE COAC_VIEW_STAT = 'Y'
          ORDER BY COAC_MAST_CODE";
          
$query1 = "SELECT DISTINCT(TRXA_COAC_CODE) AS COAC_CODE, TRXA_COAC_NAME
          FROM trxajrnl
          WHERE TRXA_JRNL_STAT = 'Y'
          ORDER BY TRXA_COAC_CODE";

$q1 = $db->query($query1) or die("Gagal Ambil Kode Akun!!");
while ($data1 = $q1->fetch(PDO::FETCH_ASSOC))
{ 
  $coaccode = $data1['COAC_CODE'];
  $coacname = $data1['TRXA_COAC_NAME'];

  $pdf->SetFont('Arial','B',12);
  $pdf->Ln(4);
  $pdf->Cell(190,4,$coaccode . ' ' . $coacname,0,1,'L');
  $pdf->Ln(2);
  // Line 1
  $pdf->Cell(20,8,'Tanggal','LBT',0,'C');
  $pdf->Cell(22,8,'No Ref','BT',0,'C');
  $pdf->Cell(54,8,'Keterangan','BT',0,'C');
  $pdf->Cell(42,8,'Departemen','BT',0,'C');
  $pdf->Cell(20,8,'Debet','BT',0,'C');
  $pdf->Cell(20,8,'Kredit','BTR',1,'C');

  $pdf->SetFont('Arial','',10);

  $querysaldoawal = "SELECT SUM(TRXA_JRNL_DEBT) AS JRNL_DEBT, SUM(TRXA_JRNL_CRDT) AS JRNL_CRDT,
                    CASE 
                    WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
                    THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
                    WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
                    THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
                    ELSE 0
                    END AS SALDO
                    FROM trxajrnl 
                    WHERE TRXA_JRNL_DATE BETWEEN '$firstdate' AND '$beforedate'
                    AND TRXA_JRNL_STAT = 'Y' 
                    AND TRXA_COAC_CODE = '$coaccode'";

  $qsaldoawal = $db->query($querysaldoawal) or die("Gagal Ambil Saldo Awal");
  $datasaldo = $qsaldoawal->fetch(PDO::FETCH_ASSOC);
  $xsaldodebet = $datasaldo['JRNL_DEBT'];
  $saldodebet = number_format($xsaldodebet, 0, '', '.');
  $xsaldokredit = $datasaldo['JRNL_CRDT'];
  $saldokredit = number_format($xsaldokredit, 0, '', '.');
  $xsaldoawal = $datasaldo['SALDO'];
  $saldoawal = number_format($xsaldoawal, 0, '', '.');

  $pdf->Cell(138,8,'Saldo Awal:','LBT',0,'L');
  $pdf->Cell(20,8,$saldodebet,'BT',0,'R');
  $pdf->Cell(20,8,$saldokredit,'BTR',1,'R');

  $query2 = "SELECT DATE_FORMAT(TRXA_JRNL_DATE,'%d/%m/%Y') AS JRNL_DATE, TRXA_JRNL_CODE, TRXA_JRNL_NOTE, TRXA_DIVI_NAME, 
              TRXA_JRNL_DEBT, TRXA_JRNL_CRDT 
            FROM trxajrnl 
            WHERE TRXA_COAC_CODE='$coaccode'
            AND TRXA_JRNL_STAT = 'Y'
            AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'
            ORDER BY TRXA_JRNL_DATE";
  $q2 = $db->query($query2) or die("Gagal Ambil Keterangan!!");
  while ($data2 = $q2->fetch(PDO::FETCH_ASSOC))
  {
    $pdf->Cell(20,8,''.$data2['JRNL_DATE'].'','LBT',0,'C');
    $pdf->Cell(22,8,''.$data2['TRXA_JRNL_CODE'].'','BT',0,'C');
    $xjrnlnote = $data2['TRXA_JRNL_NOTE'];
    $jrnlnote = substr($xjrnlnote, 0,45);
    $pdf->Cell(54,8,''.$jrnlnote.'','BT',0,'C');
    $pdf->Cell(42,8,''.$data2['TRXA_DIVI_NAME'].'','BT',0,'C');
    $jrnldebt = number_format($data2['TRXA_JRNL_DEBT'], 0, '', '.');
    $pdf->Cell(20,8,$jrnldebt,'BT',0,'R');
    $jrnlcrdt = number_format($data2['TRXA_JRNL_CRDT'], 0, '', '.');
    $pdf->Cell(20,8,$jrnlcrdt,'BTR',1,'R');
  }

  $query3 = "SELECT SUM(TRXA_JRNL_DEBT) AS TOTA_DEBT, SUM(TRXA_JRNL_CRDT) AS TOTA_CRDT,
              CASE 
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'DB'
              THEN (SUM(TRXA_JRNL_DEBT - TRXA_JRNL_CRDT))
              WHEN (SELECT COAC_NORM_BLNC FROM coacmast WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) = '$coaccode') = 'CR'
              THEN (SUM(TRXA_JRNL_CRDT - TRXA_JRNL_DEBT))
              ELSE 0
              END AS MUTASI
              FROM trxajrnl
              WHERE TRXA_COAC_CODE='$coaccode'
              AND TRXA_JRNL_STAT='Y'
              AND TRXA_JRNL_DATE BETWEEN '$startdate' AND '$enddate'";
  $q3 = $db->query($query3) or die("Gagal Ambil Total");

  $data3 = $q3->fetch(PDO::FETCH_ASSOC);

  $pdf->Cell(20,8,'Saldo Awal :','LBT',0,'L');
  $pdf->Cell(22,8,$saldoawal,'BT',0,'R');
  $pdf->Cell(54,8,'','BT',0,'C');
  $pdf->Cell(42,8,'Total :','BT',0,'L');
  $xtotadebt = $data3['TOTA_DEBT'];
  $totadebt = number_format($xtotadebt, 0, '', '.');
  $pdf->Cell(20,8,$totadebt,'BT',0,'R');  
  $xtotacrdt = $data3['TOTA_CRDT'];
  $totacrdt = number_format($xtotacrdt, 0, '', '.');
  $pdf->Cell(20,8,$totacrdt,'BTR',1,'R');  

  $pdf->Cell(20,8,'Saldo Akhir :','LBT',0,'L');

    if ($xsaldoawal <= 0)
  {
    $xsaldoakhir = ($data3['MUTASI'] - 0);
  }
  else
  {
    $xsaldoakhir = $xsaldoawal + $data3['MUTASI'];  
  }
  $saldoakhir = number_format($xsaldoakhir, 0, '', '.');
  $pdf->Cell(22,8,$saldoakhir,'BT',0,'R');
  $pdf->Cell(54,8,'','BT',0,'C');

  $pdf->Cell(42,8,'Mutasi :','BT',0,'L');

  $xmutasi = $data3['MUTASI'];
  $mutasi = number_format($xmutasi, 0, '', '.');
  $pdf->Cell(20,8,$mutasi,'BT',0,'R');  

  $pdf->Cell(20,8,'','BTR',1,'R');  

}

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(190,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','GL-' . $startdate . '-' . $enddate . '.pdf');

}
else
{
  header("location: "."REPOACCT01.php");
}

?>