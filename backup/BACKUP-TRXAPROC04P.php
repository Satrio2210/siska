<?php
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
	if (isset($_POST['txtproccode']))
	{
	include 'conf/config.php';
	include 'inc/sanie.php';
	$nomorpo = xss_clean($_POST['txtproccode']);

    $periksanomorpo = "SELECT COUNT(*) FROM trxaproc WHERE TRXA_PROC_CODE='$nomorpo'";
    $periksanomorpo_di_query=$db->query($periksanomorpo) or die ("Gagal periksa nomor po");
    $ketersediaan = $periksanomorpo_di_query->fetchColumn();
    //Cek adanya nomor po  dalam tabel transaksi PO  jika tidak ada proses di batalkan
    if ($ketersediaan == 0)
    	{
		header("location: TRXAPROC04.php");
    	}
    	else
    	{

    		// Ambil Data header dari tabel trxaproc

    		$query_header = "SELECT t.TRXA_PROC_CODE, 
    						t.TRXA_PROC_DUED, 
    						t.TRXA_SUPL_CODE, 
            				(SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE=t.TRXA_SUPL_CODE LIMIT 1) AS SUPL_NAME, 
            				t.TRXA_DOWN_PAID, 
            				t.TRXA_REMA_PAID, 
            				t.TRXA_PROC_TERM, 
            				i.ITEM_ARRV_REQU, 
            				i.ITEM_WARE_CODE, 
            				(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = i.ITEM_WARE_CODE LIMIT 1) AS WARE_NAME,
            				(SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = i.ITEM_WARE_CODE LIMIT 1) AS LOCA_CODE,
            				(SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE LIMIT 1) AS LOCA_NAME,
            				i.ITEM_EMPL_CODE,
            				(SELECT CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE=i.ITEM_EMPL_CODE LIMIT 1) AS EMPL_NAME
            				FROM trxaproc AS t, itemproc AS i 
            				WHERE t.TRXA_PROC_CODE = '$nomorpo'              
            				AND t.TRXA_PROC_CODE = i.ITEM_PROC_CODE";

    		$q_header = $db->query($query_header) or die("Gagal ambil data header!!");
    		$data_header = $q_header->fetch(PDO::FETCH_ASSOC);
    		//$tanggalpo = formatTanggal($data_header['TRXA_PROC_DATE']);
    		$suplname = $data_header['SUPL_NAME'];
    		$arrvrequ = formatTanggal($data_header['ITEM_ARRV_REQU']);
    		$locaname = $data_header['LOCA_NAME'];
    		$warename = $data_header['WARE_NAME'];
    		$emplname = $data_header['EMPL_NAME'];



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
			$pdf->Cell(190,8,'Goods Received Note','LTBR',1,'C');
			$pdf->Ln(2);
			$pdf->SetFont('Arial','',8);

			// line 1
			$pdf->Cell(20,5,'Suplier',0,0,'L');
			$pdf->Cell(40,5,': '.$suplname.'',0,0,'L');

			$pdf->Cell(25,5,'Date',0,0,'L');
			$pdf->Cell(35,5,': '.$arrvrequ.'',0,0,'L');

			$pdf->Cell(30,5,'Advice Note Number',0,1,'L');

			// line 2
			$pdf->Cell(20,5,'Order Number',0,0,'L');
			$pdf->Cell(40,5,': '.$nomorpo.'',0,0,'L');

			$pdf->Cell(25,5,'Delivery Location',0,0,'L');
			$pdf->Cell(35,5,': '.$locaname.'',0,0,'L');

			$pdf->Cell(30,5,'Ware House : '.$warename.'',0,1,'L');

			$pdf->Cell(58,3,' ',0,0,'L');
			$pdf->Cell(60,3,' ',0,0,'L');

			$pdf->Cell(30,3,' ',0,1,'L');

             

			$pdf->Ln(2);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(8,4,' ','LTR',0,'C'); 
			$pdf->Cell(50,4,' ','LTR',0,'C'); 
			$pdf->Cell(10,4,' Pack ','LTR',0,'C'); 
			$pdf->Cell(25,4,' ','LTR',0,'C'); 
			$pdf->Cell(15,4,'Order','LTR',0,'C'); 
			$pdf->Cell(15,4,'Delivered','LTR',0,'C'); 
			$pdf->Cell(67,4,'','LTR',1,'C');

			$pdf->Cell(8,4,' ','LR',0,'C');
			$pdf->Cell(50,4,'Goods ','LR',0,'C');
			$pdf->Cell(10,4,'Size','LR',0,'C');
			$pdf->Cell(25,4,'Price','LR',0,'C');
			$pdf->Cell(15,4,'Quantity','LR',0,'C');
			$pdf->Cell(15,4,'Quantity','LR',0,'C');
			$pdf->Cell(67,4,'Comments','LR',1,'C');

			$pdf->Cell(8,2,' ','LBR',0,'C');
			$pdf->Cell(50,2,' ','LBR',0,'C');
			$pdf->Cell(10,2,'','LBR',0,'C');
			$pdf->Cell(25,2,' ','LBR',0,'C');
			$pdf->Cell(15,2,' ','LBR',0,'C');
			$pdf->Cell(15,2,' ','LBR',0,'C');
			$pdf->Cell(67,2,' ','LBR',1,'C');

			// ambil data Item dari tabel ItemProc dengan Nomor PO sama dengan Nomor PO di data header
			$pdf->SetFont('Arial','',8);
			$no = 0;
			$xxxxquery_item = "SELECT ITEM_PART_CODE,
    					(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_PART_CODE LIMIT 1) AS PART_NAME, 
    					ITEM_PART_UNIT, ITEM_QUTY_ORDR, ITEM_QUTY_RCVE, ITEM_PART_PRIC, ITEM_PROC_BTCH, ITEM_PROC_SRNM,  
    					(ITEM_PART_PRIC * 0.01) AS SERVICE_PRIC,
    					(ITEM_QUTY_RCVE * ITEM_PART_PRIC) + ((ITEM_QUTY_RCVE * ITEM_PART_PRIC) * 0.01) AS TOTAL_PRIC 
  						FROM itemproc
  						WHERE ITEM_PROC_CODE = '$nomorpo' AND ITEM_VIEW_STAT='N'
  						ORDER BY ITEM_PART_CODE DESC";

  			$query_item = "SELECT INVE_STOCK_CODE,
    						INVE_STOCK_NAME, INVE_WARE_CODE, 
    						(SELECT ITEM_PART_UNIT FROM itemproc WHERE ITEM_PROC_CODE='$nomorpo' AND ITEM_PART_CODE = INVE_STOCK_CODE LIMIT 1) AS PART_UNIT, 
    						(SELECT ITEM_QUTY_ORDR FROM itemproc WHERE ITEM_PROC_CODE='$nomorpo' AND ITEM_PART_CODE = INVE_STOCK_CODE LIMIT 1) AS STOCK_ORDR,
    						INVE_STOCK_QUTY, 
    						INVE_STOCK_PRIC,  
    						INVE_STOCK_BTCH, 
    						INVE_STOCK_SRNM,  
    						((INVE_STOCK_PRIC * '$pph22')/100) AS SERVICE_PRIC,
    						(INVE_STOCK_QUTY * INVE_STOCK_PRIC) + 
                (((INVE_STOCK_QUTY * INVE_STOCK_PRIC) * '$pph22')/100) AS TOTAL_PRIC 
  							FROM investock
  							WHERE INVE_PROC_CODE = '$nomorpo' AND INVE_VIEW_STAT='R'
  							AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE) = 'N'
  							ORDER BY INVE_STOCK_CODE DESC";

			$q_item = $db->query($query_item) or die("Gagal ambil data item!!");
			while ($data_item = $q_item->fetch(PDO::FETCH_ASSOC))
			{
			$no++; 
			$goods = $data_item['INVE_STOCK_NAME'];
			$size_pack = $data_item['PART_UNIT'];
			$price = number_format($data_item['INVE_STOCK_PRIC'],0,',','.');
			$order_qty = number_format($data_item['STOCK_ORDR']);
			$deliver_qty = number_format($data_item['INVE_STOCK_QUTY']);

			$pdf->Cell(8,5,''.$no.'','LTBR',0,'C');
			$pdf->Cell(50,5,''.$goods.'','LTBR',0,'L');
			$pdf->Cell(10,5,''.$size_pack.'','LTBR',0,'C');
			$pdf->Cell(25,5,'Rp. '.$price.'.00','LTBR',0,'R');
			$pdf->Cell(15,5,''.$order_qty.'','LTBR',0,'R');
			$pdf->Cell(15,5,''.$deliver_qty.'','LTBR',0,'R');
			$pdf->Cell(67,5,' ','LTBR',1,'R');
			}
			$lnumber = (11 - $no);
			while ($no<$lnumber)
			{
			$no++;
			$pdf->Cell(8,4,''.$no.'','LTBR',0,'C');
			$pdf->Cell(50,4,' ','LTBR',0,'C');
			$pdf->Cell(10,4,'','LTBR',0,'C');
			$pdf->Cell(25,4,' ','LTBR',0,'C');
			$pdf->Cell(15,4,' ','LTBR',0,'C');
			$pdf->Cell(15,4,' ','LTBR',0,'C');
			$pdf->Cell(67,4,' ','LTBR',1,'C');
			}

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(80,5,'Received by : '.$emplname.'',0,0,'L');
			$pdf->Cell(25,5,'Checked by : '.$emplname.'',0,1,'L');
	
			$pdf->Ln(4);

			$pdf->Cell(25,3,'1. Accounts/Finance dept. copy',0,1,'L');
			$pdf->Cell(25,3,'2. Suplier copy',0,1,'L');
			$pdf->Cell(25,3,'3. Stores/Goods Inwards copy',0,1,'L');


			$pdf->Output('I','GR-'.$nomorpo.'.pdf');

    	}
	}

}
else
{
	header("Location: "."index.php");
}
?>
