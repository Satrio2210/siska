<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (ISSET($_GET['laboregi']))
{

	$laboregi = $_GET['laboregi'];

	$periksaregicode = "SELECT COUNT(*) FROM trxalabo 
						WHERE TRXA_LABO_REGI='$laboregi' 
						AND TRXA_VIEW_STAT='Y'";

    $periksaregicode_di_query=$db->query($periksaregicode) or die ("Cek Fail");
    $ketersediaan = $periksaregicode_di_query->fetchColumn();

    if ($ketersediaan == 0)
    {
     header("location: "."TRXALABO05.php");
    }
    else
    {

	    $head_laboratory_name = "Dr. Rudiana";
	    $head_laboratory_address1 = "PHC Bintaro Ruko Kebayoran Arcade";
	    $head_laboratory_address2 = "Sektor 7 Blok B3 No 33-35 Bintaro";

		$no = 0;
		$sub_total = 0;

	    $query_header = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE,
	                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
	                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
	                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
	                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_BIRT,
	                (SELECT DATE_FORMAT(PATI_MAIN_BIRT,'%d/%m/%Y') FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS BIRT_DATE,
	                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_ADDR,
	                (SELECT PATI_MAIN_DIST FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_DIST,
	                (SELECT PATI_MAIN_CITY FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_CITY,
	                (SELECT PATI_MAIN_PHNE FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_PHNE,

	                TRXA_REGI_PAYM

	                FROM trxaregi
	                WHERE TRXA_REGI_CODE = '$laboregi' AND TRXA_VIEW_STAT = 'Y'";


		$qheader = $db->query($query_header) or die("Gagal Ambil Query header!!");
		$row_header = $qheader->fetch(PDO::FETCH_ASSOC);

		$admission_no = $row_header['TRXA_REGI_CODE'];
		$check_date = $row_header['REGI_DATE'];
		if ($row_header['MAIN_GEND'] == 'M')
		{
			$gender = "Laki-laki";
		}
		else if ($row_header['MAIN_GEND'] == 'F')
		{
			$gender = "Perempuan";
		}

		$id_patient = $row_header['TRXA_PATI_CODE'];
		$raw_birt_date = $row_header['MAIN_BIRT']; 
		$birt_date = $row_header['BIRT_DATE'];

	    // tanggal lahir
	    $tanggal = new DateTime($raw_birt_date);

	    // tanggal hari ini
	    $today = new DateTime('today');

	    $y = $today->diff($tanggal)->y;
	    $m = $today->diff($tanggal)->m;
	    $d = $today->diff($tanggal)->d;
	    $fullage = '' . $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';
	    $shortage = '' . $y . ' tahun ' . $m . ' bulan';

	    $pati_name = $row_header['MAIN_NAME'];
	    $pati_phone = $row_header['MAIN_PHNE'];

	    $street_address =  $row_header['MAIN_ADDR'];
	    $dist_address = $row_header['MAIN_DIST'];
	    $city_address = $row_header['MAIN_CITY'];


		// memanggil library FPDF
		require('pdf/fpdf.php');
		// intance object dan memberikan pengaturan halaman PDF
		$pdf = new FPDF('p','mm','A4');
		$pdf->SetAutoPageBreak(true);
		// membuat halaman baru
		$pdf->AddPage();
		$pdf->Ln(5);
		// setting jenis font yang akan digunakan 
		$pdf->SetFont('Arial','B',18);
		//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
		$pdf->Image('img/logo.png',10,5,20);
		$pdf->Image('img/qr-code.png',175,5,20);
		$pdf->Ln(5);

		$pdf->Cell(190,8,'HASIL LABORATORIUM',0,1,'C');
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);

		// line 1
		$pdf->Cell(30,5,'Dokter',0,0,'L');
		$pdf->Cell(90,5,': '.$head_laboratory_name.'',0,1,'L');

		// line 2
		$pdf->Cell(30,5,'Alamat',0,0,'L');
		$pdf->Cell(90,5,': '.$head_laboratory_address1.' ',0,1,'L');

		$pdf->Cell(30,5,' ',0,0,'L');
		$pdf->Cell(35,5,': '.$head_laboratory_address2.' ',0,1,'L');

		$pdf->Ln(5);

		// line 3
		$pdf->Cell(30,5,'No.Lab/Tgl.',0,0,'L');
		$pdf->Cell(70,5,': '.$admission_no.'/'.$check_date.' ',0,0,'L');

		$pdf->Cell(30,5,'Jenis Kelamin',0,0,'L');
		$pdf->Cell(35,5,': '.$gender.' ',0,1,'L');

		// line 4
		$pdf->Cell(30,5,'ID Pasien',0,0,'L');
		$pdf->Cell(70,5,': '.$id_patient.' ',0,0,'L');

		$pdf->Cell(30,5,'Tgl.Lahir/Umur',0,0,'L');
		$pdf->Cell(35,5,': '.$birt_date.' / '.$shortage.' ',0,1,'L');

		// line 5
		$pdf->Cell(30,5,'Nama Pasien',0,0,'L');
		$pdf->Cell(70,5,': '.$pati_name.' ',0,0,'L');

		$pdf->Cell(30,5,'Telepon',0,0,'L');
		$pdf->Cell(35,5,': '.$pati_phone.' ',0,1,'L');

		// 
		$pdf->Cell(30,5,'Alamat',0,0,'L');
		$pdf->Cell(90,5,': '.$street_address.' '.$dist_address.' ',0,1,'L');

		$pdf->Cell(30,5,' ',0,0,'L');
		$pdf->Cell(35,5,': '.$city_address.' ',0,1,'L');
	           
		$pdf->Ln(5);

		$pdf->Cell(80,6,'Nama Pemeriksaan','TB',0,'L'); 
		$pdf->Cell(20,6,'Hasil','TB',0,'C'); 
		$pdf->Cell(30,6,'Nilai Rujukan','TB',0,'C'); 
		$pdf->Cell(20,6,'Satuan','TB',0,'C'); 
		$pdf->Cell(40,6,'Keterangan','TB',1,'L'); 


		$pdf->Cell(80,8,'HEMATOLOGI',0,0,'L'); 
		$pdf->Cell(20,8,' ',0,0,'L'); 
		$pdf->Cell(30,8,'  ',0,0,'L'); 
		$pdf->Cell(20,8,' ',0,0,'R'); 
		$pdf->Cell(40,8,' ',0,1,'L'); 


		$pdf->Cell(80,5,'D-dimer #',0,0,'L'); 
		$pdf->Cell(20,5,'3.472',0,0,'R'); 
		$pdf->Cell(30,5,'  ',0,0,'R'); 
		$pdf->Cell(20,5,'ng/mL FEU',0,0,'L'); 
		$pdf->Cell(40,5,'Laki-laki',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'Hasil di bawah 500 ng/mL',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'FEU menyingkirkan ',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'Dugaan emboli paru dan DVT',0,1,'L'); 

		$pdf->Cell(80,8,'KIMIA',0,0,'L'); 
		$pdf->Cell(20,8,' ',0,0,'L'); 
		$pdf->Cell(30,8,'  ',0,0,'L'); 
		$pdf->Cell(20,8,' ',0,0,'L'); 
		$pdf->Cell(40,8,' ',0,1,'L'); 


		$pdf->Cell(80,5,'Albumin #',0,0,'L'); 
		$pdf->Cell(20,5,'3.2   *',0,0,'R'); 
		$pdf->Cell(30,5,'3.4 - 4.8',0,0,'R'); 
		$pdf->Cell(20,5,'g/dL',0,0,'L'); 
		$pdf->Cell(40,5,'Dewasa',0,1,'L'); 

		$pdf->Cell(80,5,'hs-CRP #',0,0,'L'); 
		$pdf->Cell(20,5,'146.8   *',0,0,'R'); 
		$pdf->Cell(30,5,'<= 10.0',0,0,'R'); 
		$pdf->Cell(20,5,'mg/L',0,0,'L'); 
		$pdf->Cell(40,5,'> 18 Tahun ',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'hs CRP > 10.0 mg/L :',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'kemungkinan',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'infeksi/inflamasi aktif',0,1,'L'); 

		$pdf->Cell(80,5,' ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,'Untuk prediksi risiko',0,1,'L'); 

		$pdf->Cell(80,5,'  ','B',0,'L'); 
		$pdf->Cell(20,5,'  ','B',0,'L'); 
		$pdf->Cell(30,5,'  ','B',0,'L'); 
		$pdf->Cell(20,5,'  ','B',0,'L'); 
		$pdf->Cell(40,5,'  ','B',1,'L'); 

		$pdf->Ln(5);

	    $query_footer = "SELECT DATE_FORMAT(TRXA_ENTR_DATE,'%d/%m/%Y') AS ENTR_DATE, 
	    				 TIME_FORMAT(TRXA_ENTR_TIME,'%h:%i') AS ENTR_TIME, 
	    				 TRXA_ENTR_USER, 
	    				 (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS ENTR_USER
	                	 FROM trxalabo
	                	 WHERE TRXA_LABO_REGI = '$laboregi' AND TRXA_VIEW_STAT = 'Y' LIMIT 1";

		$qfooter = $db->query($query_footer) or die("Gagal Ambil Query footer!!");
		$row_footer = $qfooter->fetch(PDO::FETCH_ASSOC);

		$entr_date = $row_footer['ENTR_DATE'];
		$entr_time = $row_footer['ENTR_TIME'];
		$entr_user = $row_footer['ENTR_USER'];

		$pdf->Cell(80,5,'Waktu pengambilan Specimen :',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 

		$pdf->Cell(80,5,'Darah SST - '.$entr_date.' '.$entr_time.'',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 

		$pdf->Cell(80,5,'Darah EDTA - '.$entr_date.' '.$entr_time.'',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 

		$pdf->Cell(80,5,'Darah Sitrait - '.$entr_date.' '.$entr_time.'',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 

		$pdf->Ln(5);

		$pdf->Cell(100,5,' ',0,0,'L'); 
		$pdf->Cell(90,5,' Di otorisasi Oleh ',0,1,'C'); 

		$pdf->Ln(10);

		$pdf->SetFont('Arial','B',8);


		$pdf->Cell(100,5,' ',0,0,'L'); 
		$pdf->Cell(90,5,' '.$entr_user.' ',0,1,'C'); 

		$pdf->SetFont('Arial','',8);

		$pdf->Cell(100,5,' ',0,0,'L'); 
		$pdf->Cell(90,5,' Analis ',0,1,'C'); 

		$pdf->Ln(10);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(40,4,' ',0,0,'L'); 
		$pdf->Cell(150,4,'Hasil berupa angka menggunakan sistem desimal dengan separator titik.','T',1,'L'); 

		$pdf->Cell(40,4,' ',0,0,'L'); 
		$pdf->Cell(150,4,'Tanda * menunjukkan nilai di atas atau di bawah nilai rujukan..',0,1,'L'); 

		$pdf->Cell(40,4,' ',0,0,'L'); 
		$pdf->Cell(150,4,'Tanda # menunjukkan pemeriksaan dikerjakan di Laboratorium Klinik Yemima Medika Jl. Cagar Alam 10 Depok',0,1,'L'); 

		$pdf->Cell(40,4,' ',0,0,'L'); 
		$pdf->Cell(150,4,'Interpretasi terhadap hasil hanya dilakukan oleh dokter/klinis',0,1,'L'); 

		$pdf->Cell(40,4,' ','B',0,'L'); 
		$pdf->Cell(150,4,'Demi menjaga kerahasiaan hasil Anda, disarankan tidak mengunggah ke media sosial dan media publik lainnya','B',1,'L'); 

		$pdf->Cell(190,6,'Dokumen Hasil Pemeriksaan ini tidak memerlukan tanda tangan basah karena telah divalidasi dan dicetak dari sistem informasi klinik',0,1,'C'); 


		$pdf->Output('I','LABS-'.$laboregi.'.pdf');
	}

}
else
{
	header("location: "."TRXALABO05.php");	
}

?>