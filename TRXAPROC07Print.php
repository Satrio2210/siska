<?php

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
			$pdf->Cell(70,5,'Krishand Software ',0,0,'L');
			$pdf->SetFont('Arial','BU',14);
			$pdf->Cell(40,5,'PURCHASE REQUEST',0,1,'L');

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,4,'Jakarta',0,0,'L');
			$pdf->SetFont('Arial','',8);			
			$pdf->Cell(10,4,'No.',0,0,'L');
			$pdf->Cell(20,4,': PR/000020020218',0,1,'L');			

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(70,4,'Tel 021-7363764',0,1,'L');
			$pdf->Cell(40,4,'NPWP: 03.234.767.1-111.022',0,1,'L');
			$pdf->Ln(1);

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Date',0,0,'L');
			$pdf->Cell(35,4,': 02 Feb 2018',0,1,'L');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Site',0,0,'L');
			$pdf->Cell(35,4,': Site A',0,1,'L');

			$pdf->Cell(70,4,' ',0,0,'L');
			$pdf->Cell(20,4,'Page',0,0,'L');
			$pdf->Cell(35,4,': Page 1/1',0,1,'L');

	
			$pdf->Ln(4);

			$pdf->Cell(10,4,'NO','TB',0,'C');
			$pdf->Cell(50,4,'DESCRIPTION','TB',0,'C');
			$pdf->Cell(20,4,'QUANTITY','TB',0,'C');
			$pdf->Cell(30,4,'REQUIRED DATE','TB',0,'C');
			$pdf->Cell(20,4,'PRICE','TB',1,'C');

			$pdf->Cell(10,4,'1',0,0,'C');
			$pdf->Cell(50,4,'Meja Makan',0,0,'C');
			$pdf->Cell(20,4,'2 Pcs',0,0,'C');
			$pdf->Cell(30,4,'01/02/2021',0,0,'C');
			$pdf->Cell(20,4,'500.000.00',0,1,'R');

			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');

			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');

			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');

			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');

			$pdf->Cell(10,4,' ',0,0,'C');
			$pdf->Cell(50,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,0,'C');
			$pdf->Cell(30,4,' ',0,0,'C');
			$pdf->Cell(20,4,' ',0,1,'C');


			$pdf->Cell(130,4,'Prefered Vendor Ahmad Haryanto','T',1,'L');
			$pdf->Ln(2);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,4,'Remarks',0,0,'L');
			$pdf->Cell(20,4,'Request By','LTBR',0,'C');
			$pdf->Cell(20,4,'Prepared By','LTBR',0,'C');
			$pdf->Cell(20,4,'Approved By','LTBR',1,'C');

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(70,4,'Keperluan Pantry',0,0,'L');
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





			/*$no = 0;
			$query_item = "SELECT INVE_STOCK_CODE,
    		INVE_STOCK_NAME, INVE_WARE_CODE, 
    		INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
    		(SELECT ITEM_PART_UNIT FROM itemproc 
    		WHERE ITEM_PART_CODE = INVE_STOCK_CODE LIMIT 1) AS STOCK_UNIT,
    		(INVE_STOCK_QUTY * INVE_STOCK_PRIC) AS AMOUNT  
    		FROM investock 
    		WHERE INVE_PROC_CODE = '$order_number' AND INVE_VIEW_STAT = 'R'
    		AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE LIMIT 1) = 'N'
  			ORDER BY INVE_STOCK_CODE DESC";

			$q_item = $db->query($query_item) or die("Gagal ambil data item!!");
			while ($data_item = $q_item->fetch(PDO::FETCH_ASSOC))
			{
			$no++; 
			$description = $data_item['INVE_STOCK_NAME'];
			$partunit = $data_item['STOCK_UNIT'];
			$quantity = number_format($data_item['INVE_STOCK_QUTY'],0,',','.');
			$unitprice = number_format($data_item['INVE_STOCK_PRIC'],0,',','.');
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

			$query_amount = "SELECT INVE_WARE_CODE, 
        	SUM(INVE_STOCK_QUTY * INVE_STOCK_PRIC) AS AMOUNT  
        	FROM investock 
        	WHERE INVE_PROC_CODE = '$order_number' AND INVE_VIEW_STAT = 'R'
        	AND (SELECT WARE_HOUS_TYPE FROM waremast WHERE WARE_HOUS_CODE = INVE_WARE_CODE LIMIT 1) = 'N'
        	GROUP BY INVE_WARE_CODE";

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
			$view_vat = number_format($vat,0,',','.');*/


			
			$pdf->Output('I','INV-PURCHASE.pdf');
/*    	}
	}

}
else
{
	header("Location: "."index.php");
}*/
?>

