<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
	if (isset($_GET['nomor']))
	{
	include 'conf/config.php';
	include 'inc/sanie.php';
	$nomorinvoice = $_GET['nomor'];

    $periksanomorinvoice = "SELECT COUNT(*) FROM trxainvc WHERE TRXA_INVC_CODE='$nomorinvoice'";
    $periksanomorinvoice_di_query=$db->query($periksanomorinvoice) or die ("Gagal periksa nomor Invoice");
    $ketersediaan = $periksanomorinvoice_di_query->fetchColumn();
    //Cek adanya nomor po  dalam tabel transaksi PO  jika tidak ada proses di batalkan
    if ($ketersediaan == 0)
    	{
		header("location: TRXAPROC06.php");
    	}
    	else
    	{
    		// Ambil Data header dari tabel trxaproc

    		$query_header = "SELECT t.TRXA_INVC_CODE, t.TRXA_INVC_DATE, t.TRXA_PROC_CODE, t.TRXA_DUED_DATE, 
							s.SUPL_MAIN_NAME, s.SUPL_MAIN_ADDR, s.SUPL_MAIN_CITY, 
							s.SUPL_MAIN_CTRY, s.SUPL_MAIN_TIDN 
							FROM trxainvc AS t, suplmast AS s 
							WHERE t.TRXA_SUPL_CODE = s.SUPL_MAST_CODE 
							AND t.TRXA_INVC_CODE = '$nomorinvoice' 
							AND t.TRXA_INVC_STAT='U' 
							AND t.TRXA_VIEW_STAT='Y'";

    		$q_header = $db->query($query_header) or die("Gagal ambil data header!!");
    		$data_header = $q_header->fetch(PDO::FETCH_ASSOC);

    		$invoice_number = $data_header['TRXA_INVC_CODE'];
    		$order_number = $data_header['TRXA_PROC_CODE'];
    		$invoice_date = formatTanggal($data_header['TRXA_INVC_DATE']);
    		$invoice_npwp = $data_header['SUPL_MAIN_TIDN'];
    		$invoice_billto = $data_header['SUPL_MAIN_NAME'];
    		$invoice_address = $data_header['SUPL_MAIN_ADDR'];
    		$invoice_city = $data_header['SUPL_MAIN_CITY'];
    		$invoice_country = $data_header['SUPL_MAIN_CTRY'];

			// memanggil library FPDF
			require('pdf/fpdf.php');
			// intance object dan memberikan pengaturan halaman PDF
			$pdf = new FPDF('p','mm','A4');
			$pdf->SetAutoPageBreak(true);
			// membuat halaman baru
			$pdf->AddPage();
			$pdf->Ln(5);
			// setting jenis font yang akan digunakan 
			$pdf->SetFont('Arial','B',16);
			//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
			$pdf->Cell(100,8,''.$company.'',0,0,'L');
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(100,8,'INVOICE / FAKTUR',0,1,'L');
			$pdf->SetFont('Arial','B',9);

			// line 1
			$pdf->Cell(20,5,''.$building.'',0,1,'L');
			$pdf->Cell(20,5,''.$street.'',0,1,'L');
			$pdf->Cell(20,5,''.$city.'',0,1,'L');
			$pdf->Cell(100,5,'Phone : '.$phone.'',0,0,'L');

			$pdf->SetFont('Arial','',9);			

			$pdf->Cell(50,5,'Invoice Number',0,0,'L');
			$pdf->Cell(20,5,': '.$invoice_number.'',0,1,'L');			

			$pdf->Cell(20,5,'NPWP',0,0,'L');
			$pdf->Cell(80,5,': '.$npwp.'',0,1,'L');
			$pdf->Ln(1);

			$pdf->Cell(20,5,'BILL TO',0,0,'L');
			$pdf->Cell(80,5,': '.$invoice_billto.'',0,0,'L');
			$pdf->Cell(50,5,'Date',0,0,'L');
			$pdf->Cell(35,5,': '.$invoice_date.'',0,1,'L');

			$pdf->Ln(1);

			$pdf->Cell(20,5,'NPWP',0,0,'L');
			$pdf->Cell(80,5,': '.$invoice_npwp.'',0,0,'L');
			$pdf->Cell(50,5,'Page',0,0,'L');
			$pdf->Cell(35,5,': 1',0,1,'L');

			$pdf->Ln(1);

			$pdf->Cell(20,5,'Address',0,0,'L');
			$pdf->Cell(80,5,': '.$invoice_address.' '.$invoice_city.'',0,1,'L');

			$pdf->Cell(20,5,' ',0,0,'L');
			$pdf->Cell(80,5,'  '.$invoice_country.'',0,1,'L');
	
			$pdf->Ln(4);

			$pdf->Cell(10,5,'NO','LTBR',0,'C');
			$pdf->Cell(90,5,'DESCRIPTION','LTBR',0,'C');
			$pdf->Cell(30,5,'QUANTITY','LTBR',0,'C');
			$pdf->Cell(30,5,'UNIT PRICE','LTBR',0,'C');
			$pdf->Cell(30,5,'AMOUNT','LTBR',1,'C');

			$no = 0;
			$query_item = "SELECT ITEM_PART_CODE,
    		(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS PART_NAME, 
    		ITEM_WARE_CODE, 
    		ITEM_PART_PRIC, ITEM_QUTY_RCVE, 
    		ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS STOCK_UNIT,
    		(ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS AMOUNT  
    		FROM itemproc 
    		WHERE ITEM_PROC_CODE = '$order_number' AND ITEM_VIEW_STAT = 'N'
  			ORDER BY ITEM_PART_CODE DESC";

			$q_item = $db->query($query_item) or die("Gagal ambil data item!!");
			while ($data_item = $q_item->fetch(PDO::FETCH_ASSOC))
			{
			$no++; 
			$description = $data_item['PART_NAME'];
			$xpartunit = $data_item['STOCK_UNIT'];

			// periksa apakah xpartunit mengandung @

			$posisi=strpos($xpartunit,"@");

			if ($posisi)
			{
				list($partunit,$subpartunit) = explode("@",$xpartunit);
			}
			else 
			{
  				$partunit = $xpartunit; 
			}

		
			$quantity = number_format($data_item['ITEM_QUTY_RCVE'],0,',','.');
			$unitprice = number_format($data_item['ITEM_PART_PRIC'],0,',','.');
			$amount = number_format($data_item['AMOUNT'],0,',','.');

			$pdf->Cell(10,5,''.$no.'','LR',0,'C');
			$pdf->Cell(90,5,''.$description.'','LR',0,'L');
			$pdf->Cell(30,5,''.$quantity.' '.$partunit.'','LR',0,'C');
			$pdf->Cell(30,5,''.$unitprice.'','LR',0,'R');
			$pdf->Cell(30,5,''.$amount.'.00','LR',1,'R');
			}
			$lnumber = (21 - $no);
			while ($no<$lnumber)
			{
			$no++;
			$pdf->Cell(10,5,' ','LR',0,'C');
			$pdf->Cell(90,5,' ','LR',0,'L');
			$pdf->Cell(30,5,' ','LR',0,'C');
			$pdf->Cell(30,5,' ','LR',0,'R');
			$pdf->Cell(30,5,' ','LR',1,'R');
			}


			$pdf->Cell(10,5,'','LBR',0,'C');
			$pdf->Cell(90,5,' ','LBR',0,'L');
			$pdf->Cell(30,5,' ','LBR',0,'C');
			$pdf->Cell(30,5,' ','LBR',0,'R');
			$pdf->Cell(30,5,' ','LBR',1,'R');

			$xxxquery_amount = "SELECT ITEM_WARE_CODE, 
        	SUM(ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS AMOUNT  
        	FROM itemproc 
        	WHERE ITEM_PROC_CODE = '$order_number' AND ITEM_VIEW_STAT = 'N'
        	GROUP BY ITEM_WARE_CODE";

			$query_amount = "SELECT SUM(GET_AMOUNT) AS AMOUNT FROM (SELECT ITEM_PART_CODE,
    		(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE) AS PART_NAME, 
    		ITEM_WARE_CODE, 
    		ITEM_PART_PRIC, ITEM_QUTY_RCVE, 
    		ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS STOCK_UNIT,
    		(ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS GET_AMOUNT  
    		FROM itemproc 
    		WHERE ITEM_PROC_CODE = '$order_number' AND ITEM_VIEW_STAT = 'N') AS TABLE_AMOUNT";

			$q_amount = $db->query($query_amount) or die("Gagal ambil data Amount");
			$data_amount = $q_amount->fetch(PDO::FETCH_ASSOC);
			$total_amount = $data_amount['AMOUNT'];
			$view_total_amount = number_format($data_amount['AMOUNT'],0,',','.');

			$pdf->Cell(100,5,'Luxury Sales Tax(PPn BM',0,0,'L');
			$pdf->Cell(60,5,'Sales Amount(Harga Jual)',0,0,'L');
			$pdf->Cell(30,5,''.$view_total_amount.'.00','LTR',1,'R');

			$pdf->Cell(100,5,'',0,0,'L');
			$pdf->Cell(60,5,'Discount',0,0,'L');
			$pdf->Cell(30,5,'0.00','LR',1,'R');

			$pdf->Cell(20,5,'TARIF','LTBR',0,'C');
			$pdf->Cell(30,5,'DPP','LTBR',0,'C');
			$pdf->Cell(30,5,'PPn BM','LTBR',0,'C');
			$pdf->Cell(20,5,' ',0,0,'C');

			$query_downpaid = "SELECT TRXA_DOWN_PAID FROM trxaproc 
			WHERE TRXA_PROC_CODE = '$order_number' 
			AND TRXA_PROC_STAT = 'CL'";

			$q_downpaid = $db->query($query_downpaid) or die("Gagal ambil data Down Payment");
			$data_downpaid = $q_downpaid->fetch(PDO::FETCH_ASSOC);
			$downpaid = $data_downpaid['TRXA_DOWN_PAID'];
			$view_downpaid = number_format($data_downpaid['TRXA_DOWN_PAID'],0,',','.');

			$pdf->Cell(60,5,'Down Payment(Uang Muka)',0,0,'L');
			$pdf->Cell(30,5,''.$view_downpaid.'.00','LR',1,'R');

			$pdf->Cell(20,5,'..........%','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(20,5,' ',0,0,'C');

			$query_procvatx = "SELECT TRXA_PROC_VATX FROM trxaproc WHERE TRXA_PROC_CODE = '$order_number'"; 

			$q_procvatx = $db->query($query_procvatx) or die("Gagal ambil data Status VAT");
			$data_procvatx = $q_procvatx->fetch(PDO::FETCH_ASSOC);
			$procvatx = $data_procvatx['TRXA_PROC_VATX'];
			
			if ($procvatx == 'E') 
				{ 
					$taxbase = $total_amount;
					$vat = (($taxbase * 10)/100); 
					

				}
			else if ($procvatx == 'I') 
				{ 
					$taxbase = ($total_amount * (100/110));
					$vat = (($taxbase * 10)/100); 

				}
			else 
				{ 
					$taxbase = $total_amount;
					$vat = 0; 
				}

			$view_taxbase = number_format($taxbase,0,',','.');
			$view_vat = number_format($vat,0,',','.');

			$pdf->Cell(60,5,'DPP',0,0,'L');
			$pdf->Cell(30,5,''.$view_taxbase.'.00','LR',1,'R');

			$pdf->Cell(20,5,'..........%','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(20,5,' ',0,0,'C');


			$pdf->Cell(60,5,'Vat(PPN)',0,0,'L');
			$pdf->Cell(30,5,''.$view_vat.'.00','LR',1,'R');

			$pdf->Cell(20,5,'..........%','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(20,5,' ',0,0,'C');

			//$taxservice = (($taxbase * $pph22)/100);
			//$view_taxservice = number_format($taxservice,0,',','.');

			$pdf->Cell(60,5,'Tax Service',0,0,'L');
			$pdf->Cell(30,5,' ','LBR',1,'R');


			$pdf->Cell(20,5,'..........%','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTR',0,'C');
			$pdf->Cell(20,5,' ',0,0,'C');

			$total = (($taxbase + $vat) - $downpaid);

			$view_total = number_format($total,0,',','.');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(60,5,'Total',0,0,'L');
			$pdf->Cell(30,5,''.$view_total.'.00','LTBR',1,'R');
			$pdf->SetFont('Arial','',9);

			$pdf->Cell(20,5,'..........%','LTBR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTBR',0,'C');
			$pdf->Cell(30,5,'Rp.........','LTBR',1,'C');

			$pdf->Cell(50,5,'Jumlah','LTBR',0,'L');
			$pdf->Cell(30,5,'Rp.........','LTBR',0,'C');
			$pdf->Cell(50,5,' ',0,0,'C');

			$pdf->Cell(50,5,''.$city.', '.$invoice_date.'',0,1,'L');

			$pdf->Ln(16);
			$pdf->Cell(130,5,' ',0,0,'C');
			$pdf->Cell(40,5,'TIARA','B',1,'C');

			$pdf->Cell(130,5,' ',0,0,'C');
			$pdf->Cell(40,5,'FINANCE',0,1,'C');

			
			$pdf->Output('I','INV-'.$nomorinvoice.'.pdf');
    	}
	}

}
else
{
	header("Location: "."index.php");
}
?>

?>