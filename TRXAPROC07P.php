<?php
	include 'conf/config.php';
	include 'inc/sanie.php';
	if (ISSET($_POST['txtretucode']))
{

	$nomorreturn = $_POST['txtretucode'];

    $periksanomorreturn = "SELECT COUNT(*) FROM trxaretu WHERE TRXA_RETU_CODE='$nomorreturn'";
    $periksanomorreturn_di_query=$db->query($periksanomorreturn) or die ("Gagal periksa nomor Return");
    $ketersediaan = $periksanomorreturn_di_query->fetchColumn();
    //Cek adanya nomor po  dalam tabel transaksi PO  jika tidak ada proses di batalkan
    if ($ketersediaan == 0)
    	{
		header("location: TRXAPROC05.php");
    	}
    	else
    	{
    		// Ambil Data header dari tabel trxaretu

    		$query_header = "SELECT t.TRXA_RETU_CODE, t.TRXA_RETU_DATE,
								t.TRXA_PROC_CODE, t.TRXA_RETU_DIVI, 
								(SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = t.TRXA_RETU_DIVI LIMIT 1) 
								AS DIVI_NAME, 
								t.TRXA_SUPL_CODE, s.SUPL_MAIN_NAME, 
								s.SUPL_MAIN_CITY, s.SUPL_MAIN_PHNE, s.SUPL_MAIN_PERS,
								s.SUPL_MAIN_TIDN, t.TRXA_RETU_NOTE
								FROM trxaretu AS t, suplmast AS s 
								WHERE t.TRXA_SUPL_CODE = s.SUPL_MAST_CODE 
								AND t.TRXA_RETU_CODE = '$nomorreturn' 
								AND t.TRXA_RETU_STAT='E' 
								AND t.TRXA_VIEW_STAT='Y'";

    		$q_header = $db->query($query_header) or die("Gagal ambil data header!!");
    		$data_header = $q_header->fetch(PDO::FETCH_ASSOC);

    		$return_number = $data_header['TRXA_RETU_CODE'];
    		$return_date = formatTanggal($data_header['TRXA_RETU_DATE']);
    		$proc_number = $data_header['TRXA_PROC_CODE'];
    		$divi_name = $data_header['DIVI_NAME'];

    		$return_suplier = $data_header['SUPL_MAIN_NAME'];
    		$return_city = $data_header['SUPL_MAIN_CITY'];
    		$return_phone = $data_header['SUPL_MAIN_PHNE'];
			$return_npwp = $data_header['SUPL_MAIN_TIDN'];
			$return_person = $data_header['SUPL_MAIN_PERS'];
			$return_note = $data_header['TRXA_RETU_NOTE'];    		

			// memanggil library FPDF
			require('pdf/fpdf.php');
			// intance object dan memberikan pengaturan halaman PDF
			//$pdf = new FPDF('l','mm','A6');
			$pdf = new FPDF('l','mm', [105,148]);
			$pdf->SetAutoPageBreak(true);
			// membuat halaman baru
			$pdf->AddPage();
			//$pdf->Ln(3);
			// setting jenis font yang akan digunakan 
			$pdf->SetFont('Arial','B',12);
			//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
			$pdf->Cell(70,5,''.$return_suplier.'',0,0,'L');
			$pdf->SetFont('Arial','BU',14);
			$pdf->Cell(40,5,'PURCHASE REQUEST',0,1,'L');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,4,'Jakarta',0,0,'L');
			$pdf->SetFont('Arial','',8);			
			$pdf->Cell(10,4,'No.',0,0,'L');
			$pdf->Cell(20,4,': '.$return_number.'',0,1,'L');			

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(70,4,'Tel '.$return_phone.'',0,1,'L');
			$pdf->Cell(40,4,'NPWP: '.$return_npwp.'',0,1,'L');
			$pdf->Ln(1);

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Date',0,0,'L');
			$pdf->Cell(35,4,': '.$return_date.'',0,1,'L');

	   		// Ambil Data sub header dari tabel investock dan waremast

    		$query_subheader = "SELECT s.INVE_WARE_CODE, w.WARE_HOUS_NAME
								FROM investock AS s, waremast AS w 
								WHERE s.INVE_PROC_CODE = '$proc_number'
								AND w.WARE_HOUS_TYPE = 'R'
								AND s.INVE_WARE_CODE = w.WARE_HOUS_CODE";

    		$q_subheader = $db->query($query_subheader) or die("Gagal ambil data subheader!!");
    		$data_subheader = $q_subheader->fetch(PDO::FETCH_ASSOC);

    		$ware_hous_name = $data_subheader['WARE_HOUS_NAME'];


			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Warehouse',0,0,'L');
			$pdf->Cell(35,4,': '.$ware_hous_name.'',0,1,'L');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Divisi',0,0,'L');
			$pdf->Cell(35,4,': '.$divi_name.'',0,1,'L');

	
			$pdf->Ln(4);

			$pdf->Cell(10,4,'NO','TB',0,'C');
			$pdf->Cell(50,4,'DESCRIPTION','TB',0,'C');
			$pdf->Cell(20,4,'QUANTITY','TB',0,'C');
			$pdf->Cell(30,4,'REQUIRED DATE','TB',0,'C');
			$pdf->Cell(20,4,'PRICE','TB',1,'C');

			$no = 0;
			$query_item = "SELECT INVE_STOCK_CODE,
    		INVE_STOCK_NAME, INVE_WARE_CODE, 
    		INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
    		(SELECT DATE_FORMAT(ITEM_ARRV_REQU,'%d/%m/%Y') FROM itemproc 
    		WHERE ITEM_PROC_CODE = '$proc_number' AND ITEM_PART_CODE = INVE_STOCK_CODE) AS REQUIRED_DATE,
    		(SELECT ITEM_PART_UNIT FROM itemproc 
    		WHERE ITEM_PART_CODE = INVE_STOCK_CODE LIMIT 1) AS STOCK_UNIT    		  
    		FROM investock 
    		WHERE INVE_PROC_CODE = '$proc_number' AND INVE_VIEW_STAT = 'R'
    		AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE LIMIT 1) = 'R'
  			ORDER BY INVE_STOCK_CODE DESC";

			$q_item = $db->query($query_item) or die("Gagal ambil data item!!");
			while ($data_item = $q_item->fetch(PDO::FETCH_ASSOC))
			{
			$no++; 
			$description = $data_item['INVE_STOCK_NAME'];
			$partunit = $data_item['STOCK_UNIT'];
			$quantity = number_format($data_item['INVE_STOCK_QUTY'],0,',','.');
			$unitprice = number_format($data_item['INVE_STOCK_PRIC'],0,',','.');
			$required_date = $data_item['REQUIRED_DATE'];

			$pdf->Cell(10,4,''.$no.'',0,0,'C');
			$pdf->Cell(50,4,''.$description.'',0,0,'L');
			$pdf->Cell(20,4,''.$quantity.' '.$partunit.'',0,0,'C');
			$pdf->Cell(30,4,''.$required_date.'',0,0,'C');
			$pdf->Cell(20,4,''.$unitprice.'',0,1,'R');
			}
			$lnumber = (6 - $no);
			while ($no<$lnumber)
			{
			$no++;
			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');
			}
			$pdf->Cell(130,4,'Prefered Vendor '.$return_person.'','T',1,'L');
			$pdf->Ln(2);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,4,'Remarks',0,0,'L');
			$pdf->Cell(20,4,'Request By','LTBR',0,'C');
			$pdf->Cell(20,4,'Prepared By','LTBR',0,'C');
			$pdf->Cell(20,4,'Approved By','LTBR',1,'C');

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(70,4,''.$return_note.'',0,0,'L');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',1,'C');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',1,'C');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',1,'C');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',0,'C');
			$pdf->Cell(20,4,' ','LR',1,'C');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Doni','LTBR',0,'C');
			$pdf->Cell(20,4,'Ani','LTBR',0,'C');
			$pdf->Cell(20,4,'Santi','LTBR',1,'C');
			
			$pdf->Output('I','RET-'.$nomorreturn.'.pdf');
		}
}
else
{
	header("Location: "."index.php");
}
?>

?>