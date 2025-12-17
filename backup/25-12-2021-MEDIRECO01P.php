<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (ISSET($_POST['txtmastcode']))
{

	$mastcode = $_POST['txtmastcode'];
	$maingend = $_POST['txtmaingend'];

	$mainname = $_POST['txtmainname'];
	$mainpidn = $_POST['txtmainpidn'];

	$mainbirt = $_POST['txtmainbirt'];
	$mainphne = $_POST['txtmainphne'];

	$mainage = $_POST['txtmainage'];
	$mainprof = $_POST['txtmainprof'];

	$mainaddr = $_POST['txtmainaddr'];
	$mainalergi = $_POST['txtmainalergi'];

	$periksamastcode = "SELECT COUNT(*) FROM patimast 
						WHERE PATI_MAST_CODE='$mastcode' 
						AND PATI_VIEW_STAT='Y'";

    $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
    $ketersediaan = $periksamastcode_di_query->fetchColumn();

    if ($ketersediaan == 0)
    {
     header("location: "."MEDIRECO01.php");
    }
    else
    {


	// memanggil library FPDF
	require('pdf/fpdf.php');
	// intance object dan memberikan pengaturan halaman PDF
	$pdf = new FPDF('p','mm','A4');
	$pdf->SetAutoPageBreak(true);
	// membuat halaman baru
	$pdf->AddPage();
	//$pdf->Ln(1);
	// setting jenis font yang akan digunakan 
	$pdf->SetFont('Arial','B',18);
	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
	$pdf->Image('img/logo.png',10,5,20);
	$pdf->Ln(5);

	$pdf->Cell(190,4,'KLINIK PRATAMA RAWAT JALAN',0,1,'C');
	$pdf->Cell(190,8,'YEMIMA MEDIKA',0,1,'C');

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(190,8,'Jl. Raya Cagar Alam No. 10 Cagar Alam Pancoranmas Depok',0,1,'C');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);

	// line 1
	$pdf->Cell(30,5,'No. RM',0,0,'L');
	$pdf->Cell(90,5,': '.$mastcode.'',0,0,'L');

	$pdf->Cell(30,5,'Pasien',0,0,'L');
	$pdf->Cell(35,5,': ' . $maingend .'',0,1,'L');

	// line 2
	$pdf->Cell(30,5,'Nama',0,0,'L');
	$pdf->Cell(90,5,': '.$mainname.'',0,0,'L');

	$pdf->Cell(30,5,'No. Identitas',0,0,'L');
	$pdf->Cell(35,5,': '.$mainpidn.'',0,1,'L');

	// line 3
	$pdf->Cell(30,5,'Tgl. Lahir',0,0,'L');
	$pdf->Cell(90,5,': '.$mainbirt.'',0,0,'L');

	$pdf->Cell(30,5,'No. Telp',0,0,'L');
	$pdf->Cell(35,5,': '.$mainphne.'',0,1,'L');

	// line 4
	$pdf->Cell(30,5,'Umur',0,0,'L');
	$pdf->Cell(90,5,': '.$mainage.'',0,0,'L');

	$pdf->Cell(30,5,'Pekerjaan',0,0,'L');
	$pdf->Cell(35,5,': '.$mainprof.'',0,1,'L');

	// line 5
	$pdf->Cell(30,5,'Alamat',0,0,'L');
	$pdf->Cell(90,5,': '.$mainaddr.'',0,0,'L');

	$pdf->Cell(65,5,'Riwayat Alergi','LTBR',1,'C');

	// LINE 6
	$pdf->Cell(120,5,' ',0,0,'L');
	$pdf->MultiCell(65,5,' '.$mainalergi.'',1,'L');

	// LINE 7
	//$pdf->Cell(120,5,' ',0,0,'L');
	//$pdf->Cell(65,5,' ','LBR',1,'L');
           
	$pdf->SetFont('Arial','',9);
	$pdf->Ln(8);


	$pdf->Cell(95,6,'TANGGAL: 05/05/1975','LTBR',0,'L');
    $pdf->Cell(95,6,'PEMERIKSA: dr. Tiar','LTBR',1,'L');

    $pdf->Cell(95,6,'OBJEKTIF: ','LR',0,'L');
    $pdf->Cell(95,6,'ANAMNESA: ','LR',1,'L');

    $pdf->Cell(95,6,'Tinggi Badan: ','L',0,'L');
    $pdf->Cell(95,6,' hasil anamnesa','LR',1,'L');

    $pdf->Cell(95,6,'Berat Badan: ','L',1,'L');
    $pdf->Cell(95,6,'Tekanan Darah','L',1,'L');
    $pdf->Cell(96,6,'Suhu Tubuh: ','L',1,'L');

    $pdf->Cell(95,6,'DIAGNOSA: ','LTR',0,'L');
    $pdf->Cell(95,6,'THERAPI: ','LTR',1,'L');




	$pdf->Cell(30,6,'Tgl/Bln/Thn','LTBR',0,'C'); 
	$pdf->Cell(40,6,'Anamnesa','LTBR',0,'C'); 
	$pdf->Cell(40,6,' Diagnosis ','LTBR',0,'C'); 
	$pdf->Cell(40,6,' Therapi','LTBR',0,'C'); 
	$pdf->Cell(40,6,'TTD dr.','LTBR',1,'C'); 

	$query_regi = "SELECT TRXA_REGI_CODE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE, TRXA_REGI_DOCT, 
               (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME  
              FROM trxaregi WHERE TRXA_PATI_CODE = '$mastcode' 
              AND TRXA_REGI_STAT = 'X' AND TRXA_VIEW_STAT='Y'
              ORDER BY TRXA_REGI_DATE DESC";
    
	$qregi = $db->query($query_regi) or die("Gagal Ambil data Pasien!!");
	while ($row_regi = $qregi->fetch(PDO::FETCH_ASSOC))
	{ 

	$regicode = $row_regi['TRXA_REGI_CODE'];
	$regidate = $row_regi['REGI_DATE'];
		
	$pdf->Cell(30,6,''.$regidate.'','LR',0,'C');

  	// Ambil data pemeriksaan dan diagnosa
  	$query_exam = "SELECT TRXA_EXAM_ANAM, TRXA_EXAM_BODY, TRXA_EXAM_DIAG, TRXA_EXAM_PRSC 
    	            FROM trxaexam WHERE TRXA_EXAM_CODE = '$regicode'";

  	$qexam = $db->query($query_exam) or die ("Gagal ambil anamnesa");
  	$row_exam = $qexam->fetch(PDO::FETCH_ASSOC);

  	$anamnesa = $row_exam['TRXA_EXAM_ANAM'];
  	$exambody = $row_exam['TRXA_EXAM_BODY'];
  	$examdiag = $row_exam['TRXA_EXAM_DIAG'];
  	$examprsc = $row_exam['TRXA_EXAM_PRSC'];


	$pdf->MultiCell(40,6,''.$anamnesa.'','L',0); 
	$pdf->MultiCell(40,6,''.$examdiag.'','L',0); 

	// Ambil data tindakan dan resep yang diberikan
  	$query_tret = "SELECT TRXA_MEDI_CODE, 
                (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = TRXA_MEDI_CODE AND TBLF_MEDI_TYPE IN('O','N')) AS MEDI_NAME
                 FROM trxatret WHERE TRXA_TRET_CODE = '$regicode'";

  	$qtret = $db->query($query_tret) or die ("Gagal ambil Treatment");
  	$row_tret = $qtret->fetch(PDO::FETCH_ASSOC);

  	$tindakan = $row_tret['MEDI_NAME'];

	$pdf->MultiCell(40,6,''.$tindakan.'',0,'R'); 
	$pdf->MultiCell(45,6,''.$row_regi['DOCT_NAME'].'',1,'L'); 

	}

	$pdf->Output('I','RekamMedis-'.$mastcode.'.pdf');

    }

}
else
{
	header("location: "."MEDIRECO01.php");
}

?>