<?php

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
			$pdf->Cell(190,8,'FAKTUR PENJUALAN','TB',1,'C');
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


?>