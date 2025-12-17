<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (ISSET($_GET['drugcode']))
{
	//24102021-00001
	$drugcode = $_GET['drugcode'];

	$no = 0;
	$sub_total = 0;

	$query_header = "SELECT TRXA_DRUG_CODE AS INVOICE_NO,
					CONCAT(TRXA_ENTR_DATE,' ',TRXA_ENTR_TIME) AS INVOICE_DATE,  
					(SELECT CONCAT(TRXA_ENTR_DATE,' ',TRXA_ENTR_TIME) FROM itemdrug WHERE TRXA_DRUG_CODE=INVOICE_NO LIMIT 1) AS ADMISSION_DATE,
					CONCAT(TRXA_UPDT_DATE,' ',TRXA_UPDT_TIME) AS DISCHARGE_DATE 
          			FROM trxadrug 
          			WHERE TRXA_DRUG_CODE = '$drugcode'";

	$qheader = $db->query($query_header) or die("Gagal Ambil Tanggal Faktur!!");
	$row_header = $qheader->fetch(PDO::FETCH_ASSOC);

	$invoice_no = $row_header['INVOICE_NO'];
	$invoice_date = $row_header['INVOICE_DATE'];
	$admission_date = $row_header['ADMISSION_DATE'];
	$discharge_date = $row_header['DISCHARGE_DATE'];
	

	// memanggil library FPDF
	require('pdf/fpdf.php');
	// intance object dan memberikan pengaturan halaman PDF
	$pdf = new FPDF('p','mm','A4');
	//$pdf = new FPDF('l','mm',array(210.82,148.59));

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

	$pdf->Cell(190,8,'INVOICE',0,1,'C');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',10);

	// line 1
	$pdf->Cell(120,5,''.$company.'',0,0,'L');

	$pdf->Cell(30,5,'Invoice No',0,0,'L');
	$pdf->Cell(35,5,': ' . $invoice_no .'',0,1,'L');

	// line 2
	$pdf->Cell(120,5,''.$building.'',0,0,'L');

	$pdf->Cell(30,5,'Invoice Date',0,0,'L');
	$pdf->Cell(35,5,': '.$invoice_date.'',0,1,'L');

	// line 3
	$pdf->Cell(120,5,''.$street.'',0,0,'L');

	$pdf->Cell(30,5,'Admission Date',0,0,'L');
	$pdf->Cell(35,5,': '.$admission_date.'',0,1,'L');

	// line 4
	$pdf->Cell(120,5,''.$city.'',0,0,'L');

	$pdf->Cell(30,5,'Discharge Date',0,0,'L');
	$pdf->Cell(35,5,': '.$discharge_date.'',0,1,'L');

	// line 5
	//$pdf->Cell(120,5,''.$phone.'',0,0,'L');
           
	$pdf->SetFont('Arial','',9);
	$pdf->Ln(2);

	$pdf->Cell(8,5,'No','LTBR',0,'C'); 
	$pdf->Cell(50,5,'Name','LTB',0,'L'); 
	$pdf->Cell(30,5,' Description ','TBR',0,'L'); 
	$pdf->Cell(10,5,' Qty','LTBR',0,'R'); 
	$pdf->Cell(15,5,'UOM','LTBR',0,'L'); 
	$pdf->Cell(25,5,'Amount','LTBR',0,'R');
	$pdf->Cell(25,5,'Disc.','LTBR',0,'R'); 
	$pdf->Cell(25,5,'Patient','LTBR',1,'R');


	$xxxxxquery_drug = "SELECT ITEM_DRUG_CODE, ITEM_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS STOCK_NAME, 
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = ITEM_STOCK_CODE) AS SPEC_CODE,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,

              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS UNIT_CODE,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,              
              ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, ((ITEM_STOCK_PRIC * '$profit') *ITEM_STOCK_QUTY) AS SUB_TOTAL_PRIC
              FROM itemdrug WHERE ITEM_DRUG_CODE = '$drugcode' AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'";


	$query_drug = "SELECT ITEM_DRUG_CODE, ITEM_STOCK_CODE, 
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS STOCK_NAME, 
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = ITEM_STOCK_CODE) AS SPEC_CODE,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,

              (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) AS UNIT_CODE,
              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,              
              ITEM_STOCK_PRIC, ITEM_STOCK_QUTY, (ITEM_STOCK_PRIC *ITEM_STOCK_QUTY) AS SUB_TOTAL_PRIC
              FROM itemdrug WHERE ITEM_DRUG_CODE = '$drugcode' AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'";
    
	$qdrug = $db->query($query_drug) or die("Gagal Ambil data obat!!");
	while ($row_drug = $qdrug->fetch(PDO::FETCH_ASSOC))
	{ 

	$drug_name = $row_drug['STOCK_NAME'];
	$spec_name = $row_drug['SPEC_NAME'];
	$drug_qty = $row_drug['ITEM_STOCK_QUTY'];
	$drug_unit = $row_drug['UNIT_NAME'];

	$xharga = round($row_drug['SUB_TOTAL_PRIC']);
    $int = (int)$xharga;
    
    $drug_amount = pembulatan($int);    
    
	//$drug_amount = $row_drug['SUB_TOTAL_PRIC'];
	$view_drug_amount = number_format($drug_amount, 0, '', '.');
    
    $no++;
    $sub_total = $sub_total + $drug_amount;
    
	$pdf->Cell(8,5,''.$no.'','LR',0,'C'); 
	$pdf->Cell(50,5,''.$drug_name.' '.$spec_name.'','L',0,'L'); 
	$pdf->Cell(30,5,'  ','R',0,'L'); 
	$pdf->Cell(10,5,''.$drug_qty.'','LR',0,'R'); 
	$pdf->Cell(15,5,''.$drug_unit.'','LR',0,'L'); 
	$pdf->Cell(25,5,''.$view_drug_amount.'','LR',0,'R');
	$pdf->Cell(25,5,'0','LR',0,'R'); 
	$pdf->Cell(25,5,''.$view_drug_amount.'','LR',1,'R');

	}

	$pdf->Cell(113,6,'SUB TOTAL :','T',0,'R'); 
	$view_sub_total = number_format($sub_total, 0, '', '.');
	$pdf->Cell(25,6,''.$view_sub_total.'','T',0,'R');
	$pdf->Cell(25,6,'0','T',0,'R'); 
	$pdf->Cell(25,6,''.$view_sub_total.'','T',1,'R');

  	$query_payment = "SELECT TRXA_PAYM_DISC AS DISCOUNT, TRXA_PAYM_OUTS AS PAYMENT_AMOUNT FROM trxadrug 
                    WHERE TRXA_DRUG_CODE='$drugcode'  AND TRXA_VIEW_STAT='Y'";

  	$qpayment = $db->query($query_payment) or die("Gagal Ambil data Pembayaran!!");
  	$row_payment = $qpayment->fetch(PDO::FETCH_ASSOC);
  	$payment = $row_payment['PAYMENT_AMOUNT'];
  	$kena_diskon = $row_payment['DISCOUNT'];

	$pdf->Cell(113,6,'DISCOUNT :',0,0,'R'); 
  	$view_kena_diskon = number_format($kena_diskon, 0, '', '.');

	$pdf->Cell(25,6,''.$view_kena_diskon.'',0,0,'R');
	$pdf->Cell(25,6,'',0,0,'R'); 
	$pdf->Cell(25,6,''.$view_kena_diskon.'',0,1,'R');
    //$pdf->Cell(113,6,'PPN :',0,0,'R')
	$pdf->Cell(113,6,'PPN :',0,0,'R'); 
	$pdf->Cell(25,6,'',0,0,'R');
	$pdf->Cell(25,6,'',0,0,'R');
	$dasar_kena_pajak = ($payment * (100/100));
	$ppn = ($dasar_kena_pajak * (11/100));
	$view_ppn = number_format($ppn, 0, '', '.'); 
	$pdf->Cell(25,6,''.$view_ppn.'',0,1,'R');

	$pdf->Cell(113,6,'TOTAL :',0,0,'R'); 
	$pdf->Cell(25,6,'',0,0,'R');
	$pdf->Cell(25,6,'',0,0,'R'); 
	//$sub_total = $sub_total + $fee_admin;
	$view_sub_total = number_format($sub_total + $ppn, 0, '', '.'); 
	//$view_sub_total = number_format($sub_total , 0, '', '.'); 
	$pdf->Cell(25,6,''.$view_sub_total.'',0,1,'R');

  	$bulatkan_sub_total = (int)$sub_total;
  	$bulatkan_payment = (int)$payment;

  	$balance  = ($bulatkan_sub_total - $bulatkan_payment);

	$pdf->Cell(113,6,'PAYMENT :',0,0,'R'); 
	$pdf->Cell(25,6,'',0,0,'R');
	$pdf->Cell(25,6,'',0,0,'R'); 

	$view_payment = number_format($payment, 0, '', '.'); 
	$pdf->Cell(25,6,''.$view_payment.'',0,1,'R');

	$pdf->Cell(113,6,'BALANCE :',0,0,'R'); 
	$pdf->Cell(25,6,'',0,0,'R');
	$pdf->Cell(25,6,'',0,0,'R'); 

	$view_balance = number_format($balance, 0, '', '.');
	$pdf->Cell(25,6,''.$view_balance.'',0,1,'R');

	$pdf->Cell(60,5,'IN WORDS PATIENT :',0,0,'L');
	$pdf->SetFont('Arial','',8);

	$words_patient = terbilang($payment);
	$pdf->Cell(70,5,''.$words_patient.' Rupiah',0,1,'R');
	
	$pdf->Ln(4);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(60,5,'PATIENT RECEIPT / KUITANSI :',0,1,'L');

	$pdf->SetFont('Arial','',8);

	$pdf->Cell(18,5,'Type','LTBR',0,'L'); 
	$pdf->Cell(18,5,'Date','LTBR',0,'L'); 
	$pdf->Cell(22,5,'Payment Mode','LTBR',0,'L'); 
	$pdf->Cell(25,5,'Account No.','LTBR',0,'L'); 
	$pdf->Cell(25,5,'Account Name','LTBR',0,'L'); 
	$pdf->Cell(30,5,'Description','LTBR',0,'L');
	$pdf->Cell(25,5,'Cashier','LTBR',0,'R'); 
	$pdf->Cell(25,5,'Patient','LTBR',1,'R');

  	$query_footer = "SELECT TRXA_PAYM_MODE, TRXA_ENTR_DATE, TRXA_ENTR_USER, 
                  (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS CASHIER 
                  FROM trxadrug 
                  WHERE TRXA_DRUG_CODE='$invoice_no' AND TRXA_VIEW_STAT='Y'";

  	$qfooter = $db->query($query_footer) or die("Gagal Ambil data Footer!!");
  	$row_footer = $qfooter->fetch(PDO::FETCH_ASSOC);

  	if ($row_footer['TRXA_PAYM_MODE'] == 'TUN')
  		{ $paymmode = 'Cash'; }
  	else if ($row_footer['TRXA_PAYM_MODE'] == 'BCA')
  		{ $paymmode = 'Debit BCA'; }
  	else if ($row_footer['TRXA_PAYM_MODE'] == 'MAN')
  		{ $paymmode = 'Debit Mandiri'; }
  	else if ($row_footer['TRXA_PAYM_MODE'] == 'BNI')
  		{ $paymmode = 'Debit BNI'; }
  	else if ($row_footer['TRXA_PAYM_MODE'] == 'BCM')
  		{ $paymmode = 'Transfer BCA'; }
  	else if ($row_footer['TRXA_PAYM_MODE'] == 'LIN')
  		{ $paymmode = 'Transfer LinkAja'; }

  	$paymdate = date("d/m/Y", strtotime($row_footer['TRXA_ENTR_DATE']));
  	$cashier = $row_footer['CASHIER'];

	$pdf->Cell(18,5,'Payment','LTBR',0,'L'); 
	$pdf->Cell(18,5,''.$paymdate.'','LTBR',0,'L'); 
	$pdf->Cell(22,5,''.$paymmode.'','LTBR',0,'L'); 
	$pdf->Cell(25,5,' ','LTBR',0,'R'); 
	$pdf->Cell(25,5,' ','LTBR',0,'L'); 
	$pdf->Cell(30,5,' ','LTBR',0,'R');
	$pdf->Cell(25,5,''.$cashier.'','LTBR',0,'R'); 
	$pdf->Cell(25,5,''.$view_payment.'','LTBR',1,'R');

	$pdf->Cell(163,5,'TOTAL :',0,0,'R'); 
	$pdf->Cell(25,5,''.$view_payment.'',0,1,'R');

	$pdf->Ln(2);
	$pdf->Cell(150,5,' ',0,0,'R'); 

	$pdf->Cell(30,5,'CASHIER',0,0,'C'); 
	$pdf->Ln(5);
	$pdf->Cell(150,5,' ',0,0,'R'); 
	$pdf->Cell(30,5,''.$cashier.'',0,0,'C'); 

	$pdf->Output('I','KWITANSI-'.$invoice_no.'.pdf');
}
else
{
	header("location: "."TRXADRUG02.php");
}

?>