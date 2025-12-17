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

$title = 'Report Neraca ' . $company;
$subtitle = 'Periode :' . $TanggalSelesai;
// memanggil library FPDF
require('pdf/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('p','mm','A4');
$pdf->SetAutoPageBreak(true);
// membuat halaman baru
$pdf->AddPage();

$pdf->SetLeftMargin(27);

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
$pdf->Cell(65,8,'Aktiva','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BTR',1,'C');

$pdf->SetFont('Arial','',11);

// Ambil Akun Group Aktiva              
$queryaktiva = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '1.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qaktiva = $db->query($queryaktiva) or die("Gagal Ambil Group Akun");
while ($rowaktiva = $qaktiva->fetch(PDO::FETCH_ASSOC))
{
$coaccode = $rowaktiva['TBLA_COAC_CODE'];
$coacname = $rowaktiva['TBLA_COAC_NAME'];
$pdf->Cell(65,8,$coacname,'LBT',0,'L');

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
  $pdf->Cell(30,8,$saldo_group,'BT',0,'R');
  $pdf->Cell(30,8,'','BT',0,'C');
  $pdf->Cell(30,8,'','BTR',1,'C');

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
$pdf->SetFont('Arial','B',11);
$pdf->Cell(65,8,'Total Aktiva','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,$saldo_aktiva,'BTR',1,'C');

$pdf->Cell(65,8,'PASIVA','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BTR',1,'C');
$pdf->SetFont('Arial','',11);
// Ambil Akun Group Pasiva              
$queryPasiva = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '2.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qPasiva = $db->query($queryPasiva) or die("Gagal Ambil Group Akun");
while ($rowPasiva = $qPasiva->fetch(PDO::FETCH_ASSOC))
{
$coaccode = $rowPasiva['TBLA_COAC_CODE'];
$coacname = $rowPasiva['TBLA_COAC_NAME'];
$pdf->Cell(65,8,$coacname,'LBT',0,'L');

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
  $pdf->Cell(30,8,$saldo_group,'BT',0,'R');
  $pdf->Cell(30,8,'','BT',0,'C');
  $pdf->Cell(30,8,'','BTR',1,'C');

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
$pdf->SetFont('Arial','B',11);
$pdf->Cell(65,8,'Sub Total Pasiva','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,$saldo_Pasiva,'BT',0,'R');
$pdf->Cell(30,8,'','BTR',1,'C');

$pdf->Cell(65,8,'CAPITAL','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BTR',1,'C');
$pdf->SetFont('Arial','',11);
// Ambil Akun Group Capital              
$queryCapital = "SELECT TBLA_COAC_CODE, TBLA_COAC_NAME 
          FROM tblacoac 
          WHERE TBLA_COAC_CODE LIKE '3.%'
          AND TBLA_COAC_STAT = 'Y'
          ORDER BY TBLA_COAC_CODE";
$qCapital = $db->query($queryCapital) or die("Gagal Ambil Group Akun");
while ($rowCapital = $qCapital->fetch(PDO::FETCH_ASSOC))
{
$coaccode = $rowCapital['TBLA_COAC_CODE'];
$coacname = $rowCapital['TBLA_COAC_NAME'];
$pdf->Cell(65,8,$coacname,'LBT',0,'L');

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
  $pdf->Cell(30,8,$saldo_group,'BT',0,'R');
  $pdf->Cell(30,8,'','BT',0,'C');
  $pdf->Cell(30,8,'','BTR',1,'C');

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
$pdf->SetFont('Arial','B',11);
$pdf->Cell(65,8,'Sub Total Capital','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,$saldo_Capital,'BT',0,'R');
$pdf->Cell(30,8,'','BTR',1,'C');

$pdf->Cell(65,8,'Total Pasiva + Capital','LBT',0,'L');
$pdf->Cell(30,8,'','BT',0,'C');
$pdf->Cell(30,8,'','BT',0,'C');
$xsaldo_pasiva_capital = $xsaldo_Pasiva+$xsaldo_Capital;
$saldo_pasiva_capital = number_format($xsaldo_pasiva_capital, 0, '', '.');
$pdf->Cell(30,8,$saldo_pasiva_capital,'BTR',1,'R');
$pdf->SetFont('Arial','',11);

$pdf->Ln(2);
$pdf->SetFont('Times','',8);
$pdf->Cell(155,4,'&copy; 2020, Made in Jakarta. asrulsani.mohamad@gmail.com Legal.',0,1,'C');

$pdf->Output('I','EQ-' . $startdate . '-' . $enddate . '.pdf');
}
else
{
  header("location: "."REPOACCT05.php");
}

?>