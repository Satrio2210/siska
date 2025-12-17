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

	    $head_laboratory_name = "Rudiana A.Md.Ak";
	    $head_laboratory_address1 = "PHC Bintaro Ruko Kebayoran Arcade";
	    $head_laboratory_address2 = "Sektor 7 Blok B3 No 33-35 Bintaro";

		$sub_total = 0;

	    $xxxxquery_header = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE AS REGI_DATE,
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

	    $query_header = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_PATI_CODE AS PATI_CODE, TRXA_REGI_DATE AS REGI_DATE,
	                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
	                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
	                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
	                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_BIRT,
	                (SELECT DATE_FORMAT(PATI_MAIN_BIRT,'%d/%m/%Y') FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS BIRT_DATE,
	                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_ADDR,
	                (SELECT PATI_MAIN_DIST FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_DIST,
	                (SELECT PATI_MAIN_CITY FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_CITY,
	                (SELECT PATI_MAIN_PHNE FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_PHNE,

	                TRXA_REGI_PAYM,

	                (SELECT TRXA_REGI_DOCT FROM trxaregi WHERE TRXA_PATI_CODE = PATI_CODE AND TRXA_REGI_DATE = REGI_DATE
           			 ORDER BY TRXA_ENTR_DATE, TRXA_ENTR_TIME LIMIT 1) AS REGI_DOCT,

           			 (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = REGI_DOCT) AS DOCT_NAME,

	                (SELECT TRXA_REGI_POLI FROM trxaregi WHERE TRXA_PATI_CODE = PATI_CODE AND TRXA_REGI_DATE = REGI_DATE
           			 ORDER BY TRXA_ENTR_DATE, TRXA_ENTR_TIME LIMIT 1) AS REGI_POLI

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

	    $doct_assign = $row_header['REGI_DOCT'];
	    $doct_name = $row_header['DOCT_NAME'];
	    $poli_assign = $row_header['REGI_POLI'];

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

		$pdf->Cell(190,8,'HASIL PEMERIKSAAN LABORATORIUM',0,1,'C');
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',8);

		$pdf->Ln(5);

		// line 1
		$pdf->Cell(30,5,'Nomor.',0,0,'L');
		$pdf->Cell(90,5,': '.$admission_no.'/'.$id_patient.' ',0,0,'L');

		$pdf->Cell(30,5,'Dokter',0,0,'L');

		if ($poli_assign == $code_lab_room)
		{
			$pdf->Cell(35,5,': APS ',0,1,'L');
		}
		else
		{
			$pdf->Cell(35,5,': '.$doct_name.' ',0,1,'L');	
	    }		

		// line 2
		$pdf->Cell(30,5,'Nama / Jns kelamin',0,0,'L');
		$pdf->Cell(90,5,': '.$pati_name.' / '.$gender.'',0,0,'L');

		$pdf->Cell(30,5,'Tanggal',0,0,'L');
		$view_check_date = formatTanggal($check_date);
		$pdf->Cell(35,5,': '.$view_check_date.' ',0,1,'L');

		// line 3
		$pdf->Cell(30,5,'Tgl.Lahir/Umur',0,0,'L');
		$view_birt_date = formatTanggal($raw_birt_date);
		$pdf->Cell(90,5,': '.$view_birt_date.' / '.$shortage.' ',0,1,'L');

		// line 4
		$pdf->Cell(30,5,'Alamat',0,0,'L');
		$pdf->Cell(90,5,': '.$street_address.' '.$dist_address.' ',0,1,'L');

		$pdf->Cell(30,5,' ',0,0,'L');
		$pdf->Cell(35,5,': '.$city_address.' ',0,1,'L');
	           
		$pdf->Ln(5);

		$pdf->SetFont('Arial','B',10);
		
		if ($gender	== 'Laki-laki')
		{ $pdf->setFillColor(153,204,255);  }
		else if ($gender	== 'Perempuan')
		{ $pdf->setFillColor(255,204,229);  }
		else
		{ $pdf->setFillColor(230,230,230); }	

		$pdf->Cell(50,15,'JENIS PEMERIKSAAN','TLR',0,'C',1); 
		$pdf->Cell(50,15,'HASIL','TLR',0,'C',1); 
		$pdf->Cell(20,15,'SATUAN','TLR',0,'C',1); 
		$pdf->Cell(35,15,'NILAI NORMAL','TLR',0,'C',1); 
		$pdf->Cell(35,15,'KETERANGAN','TLR',1,'C',1); 
		

		$query_body = "SELECT DISTINCT(SUBS_CODE) AS GROUP_CODE, SUBS_NAME AS GROUP_NAME, MEDI_NAME FROM 
						(SELECT TRXA_LABO_REGI, TRXA_MAST_CODE AS MAST_CODE, 
						 (SELECT LABO_SUBS_CODE FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS SUBS_CODE,
							(SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE=SUBS_CODE) AS SUBS_NAME,
							(SELECT LABO_SIZE_CODE FROM labomast WHERE LABO_MAST_CODE=MAST_CODE) AS MEDI_CODE,
							(SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = MEDI_CODE) AS MEDI_NAME 
						FROM trxalabo 
						WHERE TRXA_LABO_REGI='$laboregi' AND TRXA_VIEW_STAT='Y') AS TABLE_GROUP GROUP BY SUBS_NAME";

  		$q_body = $db->query($query_body) or die("Gagal ambil Group data !!");
  		while ($row_body = $q_body->fetch(PDO::FETCH_ASSOC))
  		{
    		$outgoupname = strtoupper($row_body['GROUP_NAME']);
    		$outgroupcode = $row_body['GROUP_CODE'];
    		$outmediname = $row_body['MEDI_NAME'];

    		$no = 0;

    		$pdf->setFillColor(230,230,230);
    		$pdf->SetFont('Arial','B',8);
			$pdf->Cell(190,8,''.$outgoupname.'','TBLR',1,'C',1); 
			$pdf->SetFont('Arial','',8);

			$pdf->setFillColor(245,245,245);
			$pdf->Cell(50,5,''.$outmediname.'','LR',0,'L',1); 
			$pdf->Cell(50,5,' ','LR',0,'C',1); 
			$pdf->Cell(20,5,' ','LR',0,'C',1); 
			$pdf->Cell(35,5,' ','LR',0,'C',1); 
			$pdf->Cell(35,5,' ','LR',1,'C',1); 

			$query_detail = "SELECT TRXA_MAST_CODE AS MAST_CODE,
            (SELECT LABO_SUBS_CODE FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS SUBS_CODE,
            (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE = SUBS_CODE) AS SUBS_NAME,  
            (SELECT LABO_SIZE_NAME FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS SIZE_NAME,
            TRXA_LABO_RSLT, 
            (SELECT LABO_UNIT_NAME FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS UNIT_NAME,
            (SELECT LABO_VALU_MIN FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_MIN,
            (SELECT LABO_VALU_MAX FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_MAX,
            (SELECT LABO_VALU_STRG FROM labomast WHERE LABO_MAST_CODE = MAST_CODE) AS VALU_STRG,
            TRXA_LABO_NOTE
            FROM trxalabo WHERE TRXA_LABO_REGI = '$laboregi' 
            AND (SELECT LABO_SUBS_CODE FROM labomast WHERE LABO_MAST_CODE = TRXA_MAST_CODE) = '$outgroupcode' 
            AND TRXA_LABO_STAT = 'I' 
            AND TRXA_VIEW_STAT='Y'";

  			$q_detail = $db->query($query_detail) or die("Gagal ambil Detail data !!");
  			while ($row_detail = $q_detail->fetch(PDO::FETCH_ASSOC))
  			{

  				$outsizename = $row_detail['SIZE_NAME'];
  				$outresult = $row_detail['TRXA_LABO_RSLT'];
  				$outunitname = $row_detail['UNIT_NAME'];
  				$outvalumin = $row_detail['VALU_MIN'];
  				$outvalumax = $row_detail['VALU_MAX'];
  				$outvalustrg = $row_detail['VALU_STRG'];
  				
  				$outlabonote = $row_detail['TRXA_LABO_NOTE'];

  				$no++;

  				if ($no % 2 == 0) 
  				{

				$pdf->setFillColor(245,245,245);
				$pdf->Cell(50,5,'    '.$outsizename.' #','LR',0,'L',1); 
				$pdf->Cell(50,5,''.$outresult.'','LR',0,'C',1);
				$pdf->Cell(20,5,''.$outunitname.'','LR',0,'C',1); 
				if ($outvalumin == '<') 
					{
					$pdf->Cell(35,5,''.$outvalumin.' '.$outvalumax.'','LR',0,'C',1); 
					}
				else if ($outvalumin == '>')
					{
					$pdf->Cell(35,5,''.$outvalumin.' '.$outvalumax.'','LR',0,'C',1);
					} 
				else if (($outvalumin == '') && ($outvalumax == ''))
					{
					$pdf->Cell(35,5,''.$outvalustrg.'','LR',0,'C',1);
					}
				else
					{
					$pdf->Cell(35,5,''.$outvalumin.' - '.$outvalumax.'','LR',0,'C',1);
					}
				 
				 
				$pdf->Cell(35,5,''.$outlabonote.'','LR',1,'L',1);

  				}
  				else
  				{

				$pdf->Cell(50,5,'    '.$outsizename.' #','LR',0,'L'); 
				$pdf->Cell(50,5,''.$outresult.'','LR',0,'C');
				$pdf->Cell(20,5,''.$outunitname.'','LR',0,'C'); 
				if ($outvalumin == '<') 
					{
					$pdf->Cell(35,5,''.$outvalumin.' '.$outvalumax.'','LR',0,'C'); 
					}
				else if ($outvalumin == '>')
					{
					$pdf->Cell(35,5,''.$outvalumin.' '.$outvalumax.'','LR',0,'C');
					} 
				else if (($outvalumin == '') && ($outvalumax == ''))
					{
					$pdf->Cell(35,5,''.$outvalustrg.'','LR',0,'C',1);
					}
				else
					{
					$pdf->Cell(35,5,''.$outvalumin.' - '.$outvalumax.'','LR',0,'C');
					}
				 
				 
				$pdf->Cell(35,5,''.$outlabonote.'','LR',1,'L');

  				}
			} 
		}


		$pdf->Cell(50,5,'  ','T',0,'L'); 
		$pdf->Cell(50,5,'  ','T',0,'L'); 
		$pdf->Cell(20,5,'  ','T',0,'L'); 
		$pdf->Cell(35,5,'  ','T',0,'L'); 
		$pdf->Cell(35,5,'  ','T',1,'L'); 

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

	    $query_print = "SELECT DATE_FORMAT(TRXA_UPDT_DATE,'%d/%m/%Y') AS PRINT_DATE, 
	    				 TIME_FORMAT(TRXA_UPDT_TIME,'%h:%i') AS PRINT_TIME
	                	 FROM trxaregi
	                	 WHERE TRXA_REGI_CODE = '$laboregi' AND TRXA_REGI_STAT = 'P' AND TRXA_VIEW_STAT = 'Y' LIMIT 1";

		$qprint = $db->query($query_print) or die("Gagal Ambil Query print!!");
		$row_print = $qprint->fetch(PDO::FETCH_ASSOC);

		$print_date = $row_print['PRINT_DATE'];
		$print_time = $row_print['PRINT_TIME'];
		

		$pdf->Cell(80,5,'Waktu pengambilan Specimen : '.$entr_date.' '.$entr_time.'',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 


		$pdf->Cell(80,5,'Waktu penyerahan hasil : '.$print_date.' '.$print_time.'',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(30,5,'  ',0,0,'L'); 
		$pdf->Cell(20,5,' ',0,0,'L'); 
		$pdf->Cell(40,5,' ',0,1,'L'); 

		$pdf->Ln(5);

		$pdf->Cell(63,5,' Pelaksana ',0,0,'C');
		$pdf->Cell(64,5,' ',0,0,'L'); 
		$pdf->Cell(63,5,' Pj. Laboratorium ',0,1,'C'); 

		$pdf->Ln(10);

		$pdf->SetFont('Arial','B',8);


		$pdf->Cell(63,5,' '.$entr_user.' ',0,0,'C');
		$pdf->Cell(64,5,' ',0,0,'L'); 
		$pdf->Cell(63,5,' '.$head_laboratory_name.' ',0,1,'C'); 

		$pdf->SetFont('Arial','',8);

		$pdf->Cell(63,5,'  ',0,0,'C');
		$pdf->Cell(64,5,' ',0,0,'L'); 
		$pdf->Cell(63,5,'  ',0,1,'C'); 

		$pdf->Ln(10);

		$pdf->SetFont('Arial','',7);


		$pdf->Output('I','LABS-'.$laboregi.'.pdf');
	}

}
else
{
	header("location: "."TRXALABO05.php");	
}

?>