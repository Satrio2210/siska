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
	$nomorpo = $_GET['nomor'];

    $periksanomorpo = "SELECT COUNT(*) FROM trxaproc WHERE TRXA_PROC_CODE='$nomorpo'";
    $periksanomorpo_di_query=$db->query($periksanomorpo) or die ("Gagal periksa nomor po");
    $ketersediaan = $periksanomorpo_di_query->fetchColumn();
    //Cek adanya nomor po  dalam tabel transaksi PO  jika tidak ada proses di batalkan
    	if ($ketersediaan == 0)
    	{
		header("location: TRXAPROC02.php");
    	}
    	else
    	{

    		// Ambil Data header dari tabel trxaproc

    		$query_header = "SELECT TRXA_PROC_CODE, TRXA_PROC_DATE, TRXA_PROC_DUED, TRXA_SUPL_CODE,
    						(SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_NAME,
    						(SELECT SUPL_MAIN_PERS FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_PERS,
    						(SELECT CONCAT(SUPL_MAIN_ADDR, ' - ',SUPL_MAIN_CITY) FROM suplmast WHERE SUPL_MAST_CODE = TRXA_SUPL_CODE) AS SUPL_ADDR
    						FROM trxaproc WHERE TRXA_PROC_CODE = '$nomorpo'";

    		$q_header = $db->query($query_header) or die("Gagal ambil data header!!");
    		$data_header = $q_header->fetch(PDO::FETCH_ASSOC);
    		$tanggalpo = formatTanggal($data_header['TRXA_PROC_DATE']);
    		$pengiriman = formatTanggal($data_header['TRXA_PROC_DUED']);
    		$kepada = $data_header['SUPL_NAME'];
    		$up = $data_header['SUPL_PERS'];
    		//$matauang = $data_header['CRNC_NAME'];
    		$matauang = 'IDR';
    		$alamat = $data_header['SUPL_ADDR'];


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
			$pdf->Image('img/logo.png',10,5,20);
			$pdf->Ln(5);
			//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
			$pdf->Cell(190,8,'PURCHASE ORDER','TB',1,'L');
			$pdf->Ln(2);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,4,'Nomor PO',0,0,'L');
			$pdf->Cell(80,4,': '.$nomorpo.'',0,0,'L');
			$pdf->Cell(30,4,'Pengiriman',0,0,'L');
			$pdf->Cell(20,4,': '.$pengiriman.'',0,1,'L');
			$pdf->Ln(2);

			$pdf->Cell(30,4,'Tanggal PO',0,0,'L');
			$pdf->Cell(80,4,': '.$tanggalpo.'',0,0,'L');
			$pdf->Cell(30,4,'Dikirim Ke',0,0,'L');
			$pdf->Cell(20,4,': Kantor Pusat',0,1,'L');
			$pdf->Ln(2);

			$pdf->Cell(30,4,'Kepada',0,0,'L');
			$pdf->Cell(80,4,': '.$kepada.'',0,0,'L');
			$pdf->Cell(30,4,'Mata Uang',0,0,'L');
			$pdf->Cell(20,4,': '.$matauang.'',0,1,'L');
			$pdf->Ln(2);

			$pdf->Cell(30,4,'Up.',0,0,'L');
			$pdf->Cell(80,4,': '.$up.'',0,0,'L');
			$pdf->Cell(30,4,'Term',0,0,'L');
			$pdf->Cell(20,4,': Cash/Tunai',0,1,'L');
			$pdf->Ln(2);

			$pdf->Cell(30,4,'Alamat',0,0,'L');
			$pdf->Cell(2,4,': ',0,0,'L');
			$pdf->MultiCell(80,4,''.$alamat.'',0,'false');
			$pdf->Ln(4);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(8,5,'No.','LTBR',0,'C');
			$pdf->Cell(80,5,'Description of Goods ','LTBR',0,'C');
			$pdf->Cell(20,5,'Unit','LTBR',0,'C');
			$pdf->Cell(20,5,'Quantity','LTBR',0,'C');
			$pdf->Cell(25,5,'Unit Price','LTBR',0,'C');
			$pdf->Cell(25,5,'Amount','LTBR',1,'C');

			// ambil data Item dari tabel ItemProc dengan Nomor PO sama dengan Nomor PO di data header
			$pdf->SetFont('Arial','',8);
			$no = 0;
			$query_item = "SELECT ITEM_PART_CODE, 
			(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE LIMIT 1) AS PART_NAME,
			ITEM_QUTY_ORDR, 
			ITEM_PART_UNIT, (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT) AS PART_UNIT, 
			ITEM_PART_PRIC, 
			(ITEM_QUTY_ORDR * ITEM_PART_PRIC) AS ITEM_AMOUNT
			FROM itemproc WHERE ITEM_PROC_CODE = '$nomorpo'";

			$q_item = $db->query($query_item) or die("Gagal ambil data item!!");
			while ($data_item = $q_item->fetch(PDO::FETCH_ASSOC))
			{
			$no++; 
			$partname = $data_item['PART_NAME'];
			$xpartunit = $data_item['PART_UNIT'];

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
			

			$qutyordr = number_format($data_item['ITEM_QUTY_ORDR'],0,',','.');
			$partprice = number_format($data_item['ITEM_PART_PRIC'],0,',','.');
			$itemamount = number_format($data_item['ITEM_AMOUNT'],0,',','.');

			$pdf->Cell(8,5,''.$no.'','LR',0,'C');
			$pdf->Cell(80,5,''.$partname.'','LR',0,'L');
			$pdf->Cell(20,5,''.$partunit.'','LR',0,'C');
			$pdf->Cell(20,5,''.$qutyordr.'','LR',0,'R');
			$pdf->Cell(25,5,''.$partprice.'.00','LR',0,'R');
			$pdf->Cell(25,5,''.$itemamount.'.00','LR',1,'R');
			}
			$lnumber = (21 - $no);
			while ($no<$lnumber)
			{
			$no++;
			$pdf->Cell(8,5,' ','LR',0,'C');
			$pdf->Cell(80,5,' ','LR',0,'L');
			$pdf->Cell(20,5,' ','LR',0,'C');
			$pdf->Cell(20,5,' ','LR',0,'R');
			$pdf->Cell(25,5,' ','LR',0,'R');
			$pdf->Cell(25,5,' ','LR',1,'R');
			}

			$pdf->Cell(8,5,' ','LBR',0,'C');
			$pdf->Cell(80,5,' ','LBR',0,'L');
			$pdf->Cell(20,5,' ','LBR',0,'C');
			$pdf->Cell(20,5,' ','LBR',0,'R');
			$pdf->Cell(25,5,' ','LBR',0,'R');
			$pdf->Cell(25,5,' ','LBR',1,'R');

			$query_term = "SELECT TRXA_PROC_VATX, TRXA_TERM_PAID, TRXA_ENTR_USER,
						  (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS ENTR_USER 
			 				FROM trxaproc WHERE TRXA_PROC_CODE='$nomorpo'";
			$q_term = $db->query($query_term) or die("Gagal ambil data term dan status vat");
			$data_term = $q_term->fetch(PDO::FETCH_ASSOC);
			$proc_vatx = $data_term['TRXA_PROC_VATX'];
			$term_payment = $data_term['TRXA_TERM_PAID'];
			$entr_user = $data_term['ENTR_USER'];

			$query_footer = "SELECT SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) AS TOTAL_AMOUNT 
							FROM itemproc
							WHERE ITEM_PROC_CODE = '$nomorpo' AND ITEM_VIEW_STAT='Y'";

			$q_footer = $db->query($query_footer) or die("Gagal ambil data summary");
			$data_footer = $q_footer->fetch(PDO::FETCH_ASSOC);

			$total_amount = $data_footer['TOTAL_AMOUNT'];
			$view_total_amount = number_format($data_footer['TOTAL_AMOUNT'],0,',','.');

			if ($proc_vatx == 'E') 
			{
				$tax_base = $total_amount;	
				$vat = ((($tax_base) * 10) /100);
			}
			else if ($proc_vatx == 'I')
			{
				$tax_base = ($total_amount * (100/110)); 
				$vat = ((($tax_base) * 10) /100);
			}
			else
			{
				$tax_base = $total_amount;
				$vat = 0;
			}

			$view_vat = number_format($vat,0,',','.');

			$total = $tax_base + $vat;
			$view_total = number_format($total,0,',','.');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(26,5,'Term of Payment  :',0,0,'L');
			$pdf->SetFont('Arial','',8);

            if ($term_payment == 'CBD')
            {
            $pdf->Cell(102,5,'Cash Before Delivery',0,0,'L'); 
            }
            else if ($term_payment == 'COD')
            {
            $pdf->Cell(102,5,'Cash After Delivery',0,0,'L');	
            }
            else if ($term_payment == 'T30')
            {
            $pdf->Cell(102,5,'30 Days after Invoice Received',0,0,'L');	
            }
            else if ($term_payment == 'CIA')
            {
            $pdf->Cell(102,5,'Cash in Advance',0,0,'L');	
            }
            else if ($term_payment == 'NTD')
            {
            $pdf->Cell(102,5,'Payment Within 30 Days of Invoice Date',0,0,'L');	
            }
            else if ($term_payment == 'EOM')
            {
            $pdf->Cell(102,5,'Payment is Due 30 Days After End Of Month in Invoice Date',0,0,'L');	
            }
            else
            {
            $pdf->Cell(102,5,'No Term Payment',0,0,'L');	
            }

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,5,'Sub Total','LBTR',0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,5,''.$view_total_amount.'.00','LBTR',1,'R');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(128,5,' ',0,0,'L');
			$pdf->Cell(25,5,'Discount','LBTR',0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,5,'0.00','LBTR',1,'R');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(128,5,'Remarks',0,0,'L');
			$pdf->Cell(25,5,'VAT','LBTR',0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,5,''.$view_vat.'.00','LBTR',1,'R');

			$pdf->Cell(128,4,'Harga sudah termasuk ongkos',0,0,'L');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,5,'Freight Cost','LBTR',0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,5,'0.00','LBTR',1,'R');

			$pdf->Cell(128,5,' ',0,0,'L');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(25,5,'Total','LBTR',0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,5,''.$view_total.'.00	','LBTR',1,'R');

			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,'Ordered By','LBTR',0,'C');
			$pdf->Cell(25,5,'Prepared By','LBTR',0,'C');
			$pdf->Cell(25,5,'Approved By','LBTR',0,'C');
			$pdf->Cell(25,5,'Confirmed By','LBTR',1,'C');

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',1,'C');

			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',1,'C');

			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,' ','LR',0);
			$pdf->Cell(25,5,' ','LR',0);
			$pdf->Cell(25,5,' ','LR',0);
			$pdf->Cell(25,5,' ','LR',1);

			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',1,'C');

			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',0,'C');
			$pdf->Cell(25,5,' ','LR',1,'C');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(78,5,' ',0,0,'L');
			$pdf->Cell(25,5,''.$entr_user.'','LBTR',0,'C');
			$pdf->Cell(25,5,'Purchasing Staff','LBTR',0,'C');
			$pdf->Cell(25,5,'G M F & A','LBTR',0,'C');
			$pdf->Cell(25,5,'Vendor','LBTR',1,'C');

			$pdf->Ln(4);

			$pdf->Output('I','Order-'.$nomorpo.'.pdf');
		

    	}}
	

}
else
{
	header("Location: "."index.php");
}
?>
