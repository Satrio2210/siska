<?php
include 'conf/config.php';
include 'inc/sanie.php';
//cek adanya session
if (isset($_GET['regicode'])) {

	$regicode = $_GET['regicode'];
	$salecode = $_GET['salecode'];

	$periksaregicode = "SELECT COUNT(*) FROM trxasale 
						WHERE TRXA_REGI_CODE='$regicode' 
						AND TRXA_SALE_CODE='$salecode' 
						AND TRXA_VIEW_STAT='Y'";

	$periksaregicode_di_query = $db->query($periksaregicode) or die("Cek Fail");
	$ketersediaan = $periksaregicode_di_query->fetchColumn();

	if ($ketersediaan == 0) {
		header("location: " . "TRXASALE02.php");
	} else {
		$no = 0;
		$sub_total = 0;

		$sql_header = "SELECT 
			s.TRXA_SALE_CODE AS INVOICE_NO, 
			s.TRXA_REGI_CODE AS REGI_CODE, 
			s.TRXA_PATI_CODE AS PATI_CODE, 
			p.PATI_MAIN_NAME AS NAMA,
			CONCAT(s.TRXA_ENTR_DATE, ' ', s.TRXA_ENTR_TIME) AS INVOICE_DATE,
			p.PATI_MAIN_ADDR AS ADDRESS,
			CONCAT(r.TRXA_ENTR_DATE, ' ', r.TRXA_ENTR_TIME) AS ADMISSION_DATE, 
			r.TRXA_REGI_PAYM AS PATIENT_TYPE, 
			CONCAT(r.TRXA_UPDT_DATE, ' ', r.TRXA_UPDT_TIME) AS DISCHARGE_DATE, 
			s.TRXA_REGI_DOCT, 
			u.PASS_USER_NAME AS PRIMARY_DOCTOR 
		FROM trxasale s
		LEFT JOIN patimast p ON p.PATI_MAST_CODE = s.TRXA_PATI_CODE
		LEFT JOIN trxaregi r ON r.TRXA_REGI_CODE = s.TRXA_REGI_CODE
		LEFT JOIN passiden u ON u.PASS_USER_IDEN = s.TRXA_REGI_DOCT
		WHERE 
        s.TRXA_SALE_CODE = :salecode 
        AND s.TRXA_REGI_CODE = :regicode 
        AND s.TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt = $db->prepare($sql_header);
			$stmt->execute([
				':salecode' => $salecode,
				':regicode' => $regicode
			]);

			$row_header = $stmt->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			error_log("Database Error (Ambil Header Nota): " . $e->getMessage());
			$row_header = false;
			$error_message = "Maaf, data nota gagal dimuat. Silakan coba lagi atau hubungi admin.";
		}

		$admission_no = $row_header['REGI_CODE'];
		$mr_no = $row_header['PATI_CODE'];
		$invoice_no = $row_header['INVOICE_NO'];
		$name = $row_header['NAMA'];
		$invoice_date = $row_header['INVOICE_DATE'];
		$address = $row_header['ADDRESS'];
		$admission_date = $row_header['ADMISSION_DATE'];
		$discharge_date = $row_header['DISCHARGE_DATE'];

		if ($row_header['PATIENT_TYPE'] == 'U') {
			$patient_type = 'Umum';
		} else if ($row_header['PATIENT_TYPE'] == 'B') {
			$patient_type = 'BPJS';
		} else if ($row_header['PATIENT_TYPE'] == 'A') {
			$patient_type = 'Asuransi';
		} else if ($row_header['PATIENT_TYPE'] == 'P') {
			$patient_type = 'Perusahaan';
		} else if ($row_header['PATIENT_TYPE'] == 'H') {
			$patient_type = 'Halodoc';
		} else {
			$patient_type = 'No Type';
		}

		$primary_doctor = $row_header['PRIMARY_DOCTOR'];

		// memanggil library FPDF
		require('pdf/fpdf.php');
		// intance object dan memberikan pengaturan halaman PDF
		$pdf = new FPDF('p', 'mm', 'A4');
		//$pdf = new FPDF('l','mm',array(210.82,148.59));

		$pdf->SetAutoPageBreak(true);
		// membuat halaman baru
		$pdf->AddPage();
		$pdf->Ln(5);
		// setting jenis font yang akan digunakan 
		$pdf->SetFont('Arial', 'B', 18);
		//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
		$pdf->Image('img/logo.png', 10, 5, 20);
		$pdf->Image('img/qr-code.png', 175, 5, 20);
		$pdf->Ln(5);

		$pdf->Cell(190, 8, 'INVOICE', 0, 1, 'C');
		$pdf->Ln(2);
		$pdf->SetFont('Arial', '', 10);

		// line 1
		$pdf->Cell(30, 5, 'Admission No/MR', 0, 0, 'L');
		$pdf->Cell(90, 5, ': ' . $admission_no . '/' . $mr_no . '', 0, 0, 'L');

		$pdf->Cell(30, 5, 'Invoice No', 0, 0, 'L');
		$pdf->Cell(35, 5, ': ' . $invoice_no . '', 0, 1, 'L');

		// line 2
		$pdf->Cell(30, 5, 'Name', 0, 0, 'L');
		$pdf->Cell(90, 5, ': ' . $name . '', 0, 0, 'L');

		$pdf->Cell(30, 5, 'Invoice Date', 0, 0, 'L');
		$pdf->Cell(35, 5, ': ' . $invoice_date . '', 0, 1, 'L');

		// line 3
		$pdf->Cell(30, 5, 'Address', 0, 0, 'L');
		$pdf->Cell(90, 5, ': ' . $address . '', 0, 0, 'L');

		$pdf->Cell(30, 5, 'Admission Date', 0, 0, 'L');
		$pdf->Cell(35, 5, ': ' . $admission_date . '', 0, 1, 'L');

		// line 4
		$pdf->Cell(30, 5, 'Patient Type', 0, 0, 'L');
		$pdf->Cell(90, 5, ': ' . $patient_type . '', 0, 0, 'L');

		$pdf->Cell(30, 5, 'Discharge Date', 0, 0, 'L');
		$pdf->Cell(35, 5, ': ' . $discharge_date . '', 0, 1, 'L');

		// line 5
		$pdf->Cell(30, 5, 'Primary Doctor', 0, 0, 'L');
		$pdf->Cell(90, 5, ': ' . $primary_doctor . '', 0, 1, 'L');

		$pdf->SetFont('Arial', '', 8);
		$pdf->Ln(2);

		$pdf->Cell(8, 6, 'No', 'LTBR', 0, 'C');
		$pdf->Cell(50, 6, 'Name', 'LTB', 0, 'L');
		$pdf->Cell(30, 6, ' Description ', 'TBR', 0, 'L');
		$pdf->Cell(10, 6, ' Qty', 'LTBR', 0, 'R');
		$pdf->Cell(15, 6, 'UOM', 'LTBR', 0, 'L');
		$pdf->Cell(25, 6, 'Amount', 'LTBR', 0, 'R');
		$pdf->Cell(25, 6, 'Disc.', 'LTBR', 0, 'R');
		$pdf->Cell(25, 6, 'Patient', 'LTBR', 1, 'R');

		// Periksa Drugs
		$sql_cekprsc = "SELECT COUNT(*) FROM trxaprsc 
             WHERE TRXA_PRSC_CODE = :regicode 
             AND TRXA_PRSC_STAT = 'P'";

		try {
			$stmt_prsc = $db->prepare($sql_cekprsc);

			$stmt_prsc->execute([
				':regicode' => $regicode
			]);

			$ketersediaanprsc = $stmt_prsc->fetchColumn();

		} catch (PDOException $e) {
			error_log("Database Error (Periksa Obat): " . $e->getMessage());
			$ketersediaanprsc = 0;
		}

		if ($ketersediaanprsc > 0) {

			$pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
			$pdf->Cell(50, 5, 'DRUGS', 'L', 0, 'L');
			$pdf->Cell(30, 5, '  ', 'R', 0, 'L');
			$pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

			// if (!function_exists('get_mapped_signa')) {
			// 	function get_mapped_signa($signa) {
			// 		if ($signa == '01') return '1x1 Sebelum Makan';
			// 		if ($signa == '02') return '2x1 Sebelum Makan';
			// 		if ($signa == '03') return '3x1 Sebelum Makan';
			// 		if ($signa == '04') return '1x1 Sesudah Makan';
			// 		if ($signa == '05') return '2x1 Sesudah Makan';
			// 		if ($signa == '06') return '3x1 Sesudah Makan';
			// 		if ($signa == '07') return '4x1 Sesudah Makan';
			// 		if ($signa == '08') return '5x1 Sesudah Makan';
			// 		if ($signa == '09') return '3x1 Oles Tipis';
			// 		if ($signa == '10') return '3x1 Tetes Pada Mata Yang Sakit';
			// 		return $signa;
			// 	}
			// }

			$query_prsc = "SELECT 
				p.TRXA_PRSC_CODE, 
				p.TRXA_STOCK_CODE, 
				im.INVE_PART_NAME AS STOCK_NAME, 
				im.INVE_MAIN_SPEC AS SPEC_CODE,
				ts.TBLI_SPEC_NAME AS SPEC_NAME,
				im.INVE_SALE_UNIT AS UNIT_CODE,
				tu.TBLI_UNIT_NAME AS UNIT_NAME,
				p.TRXA_STOCK_PRIC AS STOCK_PRIC, 
				p.TRXA_STOCK_QUTY, 
				(p.TRXA_STOCK_PRIC * p.TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
				r.TRXA_REGI_PAYM AS PAYM_TYPE,
				sg.TBLP_SGNA_NAME AS SGNA_NAME,
				p.TRXA_PRSC_CONC, 
				p.TRXA_RACIK_ID
			FROM trxaprsc p
			LEFT JOIN invemast im ON im.INVE_MAST_CODE = p.TRXA_STOCK_CODE
			LEFT JOIN tblispec ts ON ts.TBLI_SPEC_CODE = im.INVE_MAIN_SPEC
			LEFT JOIN tbliunit tu ON tu.TBLI_UNIT_CODE = im.INVE_SALE_UNIT
			LEFT JOIN trxaregi r ON r.TRXA_REGI_CODE = p.TRXA_PRSC_CODE
			LEFT JOIN tblpsgna sg ON sg.TBLP_SGNA_CODE = p.TRXA_PRSC_SGNA
			WHERE 
				p.TRXA_PRSC_CODE = :regicode 
				AND p.TRXA_PRSC_STAT = 'P' 
				AND p.TRXA_VIEW_STAT = 'Y'
		";

			try {
				$stmt_prsc = $db->prepare($query_prsc);
				$stmt_prsc->execute([
					':regicode' => $regicode
				]);

				$all_prsc_rows = $stmt_prsc->fetchAll(PDO::FETCH_ASSOC);

			} catch (PDOException $e) {
				error_log("Database Error (Ambil data obat): " . $e->getMessage());

				$all_prsc_rows = [];
			}

			$final_items = [];
			$racik_indices = [];

			foreach ($all_prsc_rows as $row) {
				$qty_prsc = $row['TRXA_STOCK_QUTY'];
				$raw_pric_prsc = $row['STOCK_PRIC'];

				// PERBAIKAN: Bulatkan Harga Satuan dulu seperti di TRXADRUG08V
				$stockpric_bulat = pembulatan((int) round($raw_pric_prsc));

				// Jika PAYM_TYPE adalah 'B', set harga satuan menjadi 0
				// if ($row['PAYM_TYPE'] === 'B') {
				// 	$stockpric_bulat = 0;
				// }

				// PERBAIKAN: Kalikan Harga Satuan yang sudah DIBULATKAN dengan Qty
				$tott = $stockpric_bulat * $qty_prsc;

				// Bulatkan hasil akhirnya lagi untuk memastikan
				$totapric = pembulatan($tott);

				// Jika PAYM_TYPE adalah 'B', set total harga menjadi 0
				// if ($row['PAYM_TYPE'] === 'B') {
				// 	$totapric = 0;
				// }

				$is_racikan = ($row['TRXA_PRSC_CONC'] === 'Y' && !empty($row['TRXA_RACIK_ID']) && $row['TRXA_RACIK_ID'] > 0);

				if ($is_racikan) {
					$racik_id = $row['TRXA_RACIK_ID'];
					if (!isset($racik_indices[$racik_id])) {
						$qhead = $db->query("SELECT TRXAR_NAMA, TRXAR_QTY, TRXAR_SGNA FROM trxaracik_head WHERE TRXAR_ID = " . (int) $racik_id . " LIMIT 1");
						$head_row = $qhead ? $qhead->fetch(PDO::FETCH_ASSOC) : null;

						$racik_nama = ($head_row && !empty($head_row['TRXAR_NAMA'])) ? $head_row['TRXAR_NAMA'] : 'Obat';
						$racik_qty = ($head_row && isset($head_row['TRXAR_QTY'])) ? $head_row['TRXAR_QTY'] : 1;
						$racik_sgna = ($head_row && !empty($head_row['TRXAR_SGNA'])) ? $head_row['TRXAR_SGNA'] : '';

						$final_items[] = [
							'is_racikan' => true,
							'racik_id' => $racik_id,
							'name' => $racik_nama . ' (Racikan)',
							'qty' => $racik_qty,
							'unit' => 'Pcs',
							'signa' => $racik_sgna,
							'total_price' => 0,
							'paym_type' => $row['PAYM_TYPE']
						];
						$racik_indices[$racik_id] = count($final_items) - 1;
					}
					$final_items[$racik_indices[$racik_id]]['total_price'] += $totapric;
				} else {
					$final_items[] = [
						'is_racikan' => false,
						'name' => $row['STOCK_NAME'] . ($row['SPEC_NAME'] ? ' ' . $row['SPEC_NAME'] : ''),
						'qty' => $qty_prsc,
						'unit' => $row['UNIT_NAME'] ?? '',
						'signa' => $row['SGNA_NAME'] ?? '',
						'total_price' => $totapric,
						'paym_type' => $row['PAYM_TYPE']
					];
				}
			}

			foreach ($final_items as &$f_item) {
				if ($f_item['is_racikan']) {
					$f_item['total_price'] += 30000;
					$f_item['total_price'] = pembulatan($f_item['total_price']);
				}
			}
			unset($f_item);

			foreach ($final_items as $item) {
				$no++;
				$totapric = $item['total_price'];
				$view_totapric = number_format($totapric, 0, '', '.');

				$display_name = $item['name'];
				// $signa_desc = get_mapped_signa($item['signa']);
				$signa_desc = $row['SGNA_NAME'] ?? '';

				$sub_total = $sub_total + $totapric;

				$pdf->Cell(8, 5, '' . $no . '', 'LR', 0, 'C');
				$pdf->Cell(50, 5, '' . $display_name . ($signa_desc ? ', (' . $signa_desc . ')' : '') . '', 'L', 0, 'L');
				$pdf->Cell(30, 5, '  ', 'R', 0, 'L');
				$pdf->Cell(10, 5, '' . $item['qty'] . '', 'LR', 0, 'R');
				$pdf->Cell(15, 5, '' . $item['unit'] . '', 'LR', 0, 'L');
				$pdf->Cell(25, 5, '' . $view_totapric . '', 'LR', 0, 'R');
				$pdf->Cell(25, 5, '0', 'LR', 0, 'R');
				$pdf->Cell(25, 5, '' . $view_totapric . '', 'LR', 1, 'R');
			}
		}

		// Periksa Treatment
		$sql_tret_count = "SELECT COUNT(*) 
			FROM trxatret t
			INNER JOIN tblfmedi m ON m.TBLF_MEDI_CODE = t.TRXA_MEDI_CODE
			WHERE m.TBLF_MEDI_TYPE IN ('O', 'N')
			AND t.TRXA_TRET_CODE = :regicode 
			AND t.TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt_tret_count = $db->prepare($sql_tret_count);
			$stmt_tret_count->execute([
				':regicode' => $regicode
			]);

			$ketersediaantret = $stmt_tret_count->fetchColumn();

		} catch (PDOException $e) {
			error_log("Database Error (Periksa Treatment): " . $e->getMessage());
			$ketersediaantret = 0;
		}

		if ($ketersediaantret > 0) {

			$pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
			$pdf->Cell(50, 5, 'TREATMENT', 'L', 0, 'L');
			$pdf->Cell(30, 5, '  ', 'R', 0, 'L');
			$pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

			$query_action = "SELECT 
					t.TRXA_TRET_CODE, 
					t.TRXA_MEDI_CODE, 
					m.TBLF_MEDI_NAME AS MEDI_NAME, 
					t.TRXA_MEDI_RATE, 
					t.TRXA_TRET_QUTY, 
					(t.TRXA_MEDI_RATE * t.TRXA_TRET_QUTY) AS SUB_TOTAL, 
					r.TRXA_REGI_PAYM AS PAYM_TYPE
				FROM trxatret t
				INNER JOIN tblfmedi m ON m.TBLF_MEDI_CODE = t.TRXA_MEDI_CODE
				LEFT JOIN trxaregi r ON r.TRXA_REGI_CODE = t.TRXA_TRET_CODE
				WHERE m.TBLF_MEDI_TYPE IN ('O', 'N') 
				AND t.TRXA_TRET_CODE = :regicode 
				AND t.TRXA_VIEW_STAT = 'Y'
			";

			try {
				$stmt_action = $db->prepare($query_action);
				$stmt_action->execute([
					':regicode' => $regicode
				]);

				$actions = $stmt_action->fetchAll(PDO::FETCH_ASSOC);

				foreach ($actions as $row_action) {
					$action_name = $row_action['MEDI_NAME'];
					$action_qty = $row_action['TRXA_TRET_QUTY'];
					$action_amount = $row_action['SUB_TOTAL'];
					$view_action_amount = number_format($action_amount, 0, '', '.');

					$no++;
					$sub_total += $action_amount; // Lebih singkat dari $sub_total = $sub_total + $action_amount;

					$pdf->Cell(8, 5, $no, 'LR', 0, 'C');
					$pdf->Cell(50, 5, $action_name, 'L', 0, 'L');
					$pdf->Cell(30, 5, ' ', 'R', 0, 'L');
					$pdf->Cell(10, 5, $action_qty, 'LR', 0, 'R');
					$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
					$pdf->Cell(25, 5, $view_action_amount, 'LR', 0, 'R');
					$pdf->Cell(25, 5, '0', 'LR', 0, 'R');
					$pdf->Cell(25, 5, $view_action_amount, 'LR', 1, 'R');
				}

			} catch (PDOException $e) {
				error_log("Database Error (Cetak PDF Tindakan): " . $e->getMessage());
				$pdf->Cell(188, 5, 'Gagal memuat rincian tindakan. Silakan hubungi admin.', 1, 1, 'C');
			}
		}

		// Periksa Services
		$sql_services_count = "SELECT COUNT(*) 
			FROM trxatret t
			INNER JOIN tblfmedi m ON m.TBLF_MEDI_CODE = t.TRXA_MEDI_CODE
			WHERE m.TBLF_MEDI_TYPE = 'J'
			AND t.TRXA_TRET_CODE = :regicode 
			AND t.TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt_services = $db->prepare($sql_services_count);

			$stmt_services->execute([
				':regicode' => $regicode
			]);

			$ketersediaanservices = $stmt_services->fetchColumn();

		} catch (PDOException $e) {
			error_log("Database Error (Periksa Services): " . $e->getMessage());
			$ketersediaanservices = 0;
		}

		if ($ketersediaanservices > 0) {

			$pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
			$pdf->Cell(50, 5, 'SERVICES', 'L', 0, 'L');
			$pdf->Cell(30, 5, '  ', 'R', 0, 'L');
			$pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

			$sql_tret = "SELECT 
					t.TRXA_TRET_CODE, 
					t.TRXA_MEDI_CODE, 
					m.TBLF_MEDI_NAME AS MEDI_NAME, 
					t.TRXA_MEDI_RATE, 
					t.TRXA_TRET_QUTY, 
					(t.TRXA_MEDI_RATE * t.TRXA_TRET_QUTY) AS SUB_TOTAL, 
					r.TRXA_REGI_PAYM AS PAYM_TYPE
				FROM trxatret t
				INNER JOIN tblfmedi m ON m.TBLF_MEDI_CODE = t.TRXA_MEDI_CODE
				LEFT JOIN trxaregi r ON r.TRXA_REGI_CODE = t.TRXA_TRET_CODE
				WHERE m.TBLF_MEDI_TYPE = 'J' 
				AND t.TRXA_TRET_CODE = :regicode 
				AND t.TRXA_VIEW_STAT = 'Y'
			";

			try {
				$stmt_tret = $db->prepare($sql_tret);
				$stmt_tret->execute([
					':regicode' => $regicode
				]);

				$services = $stmt_tret->fetchAll(PDO::FETCH_ASSOC);

				foreach ($services as $row_tret) {
					$tret_name = $row_tret['MEDI_NAME'];
					$tret_qty = $row_tret['TRXA_TRET_QUTY'];
					$tret_amount = $row_tret['SUB_TOTAL'];
					$view_tret_amount = number_format($tret_amount, 0, '', '.');

					$no++;
					$sub_total += $tret_amount;

					$pdf->Cell(8, 5, $no, 'LR', 0, 'C');
					$pdf->Cell(50, 5, $tret_name, 'L', 0, 'L');
					$pdf->Cell(30, 5, ' ', 'R', 0, 'L');
					$pdf->Cell(10, 5, $tret_qty, 'LR', 0, 'R');
					$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
					$pdf->Cell(25, 5, $view_tret_amount, 'LR', 0, 'R');
					$pdf->Cell(25, 5, '0', 'LR', 0, 'R');
					$pdf->Cell(25, 5, $view_tret_amount, 'LR', 1, 'R');
				}

			} catch (PDOException $e) {
				error_log("Database Error (Cetak PDF Jasa Pelayanan): " . $e->getMessage());
				$pdf->Cell(188, 5, 'Gagal memuat rincian jasa. Silakan hubungi admin.', 1, 1, 'C');
			}
		}

		// periksa BHP
		$sql_csbl_count = "SELECT COUNT(*) FROM trxacsbl 
                   WHERE TRXA_CSBL_CODE = :regicode 
                   AND TRXA_CSBL_STAT = 'P'";

		try {
			$stmt_csbl_count = $db->prepare($sql_csbl_count);
			$stmt_csbl_count->execute([
				':regicode' => $regicode
			]);

			$ketersediaancsbl = $stmt_csbl_count->fetchColumn();

		} catch (PDOException $e) {
			error_log("Database Error (Periksa BHP): " . $e->getMessage());
			$ketersediaancsbl = 0;
		}

		if ($ketersediaancsbl > 0) {

			$pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
			$pdf->Cell(50, 5, 'CONSUMABLE', 'L', 0, 'L');
			$pdf->Cell(30, 5, '  ', 'R', 0, 'L');
			$pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
			$pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

			$sql_csbl = "SELECT 
					c.TRXA_CSBL_CODE, 
					c.TRXA_STOCK_CODE, 
					i.INVE_PART_NAME AS STOCK_NAME, 
					c.TRXA_STOCK_PRIC AS STOCK_PRIC, 
					c.TRXA_STOCK_QUTY, 
					(c.TRXA_STOCK_PRIC * c.TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC, 
					r.TRXA_REGI_PAYM AS PAYM_TYPE
				FROM trxacsbl c
				INNER JOIN invemast i ON i.INVE_MAST_CODE = c.TRXA_STOCK_CODE
				INNER JOIN tblitype ty ON ty.TBLI_TYPE_CODE = i.INVE_MAIN_TYPE
				LEFT JOIN trxaregi r ON r.TRXA_REGI_CODE = c.TRXA_CSBL_CODE
				WHERE c.TRXA_CSBL_CODE = :regicode
				AND ty.TBLI_TYPE_CATE = 'FG' 
				AND c.TRXA_CSBL_STAT = 'P' 
				AND c.TRXA_VIEW_STAT = 'Y'
			";

			try {
				$stmt_csbl = $db->prepare($sql_csbl);
				$stmt_csbl->execute([
					':regicode' => $regicode
				]);

				$consumables = $stmt_csbl->fetchAll(PDO::FETCH_ASSOC);

				foreach ($consumables as $row_csbl) {
					$csbl_name = $row_csbl['STOCK_NAME'];
					$csbl_qty = $row_csbl['TRXA_STOCK_QUTY'];

					$xharga = round($row_csbl['SUB_TOTAL_PRIC']);
					$int = (int) $xharga;
					$csbl_amount = pembulatan($int);
					$view_csbl_amount = number_format($csbl_amount, 0, '', '.');

					$no++;
					$sub_total += $csbl_amount;

					$pdf->Cell(8, 5, $no, 'LR', 0, 'C');
					$pdf->Cell(50, 5, $csbl_name, 'L', 0, 'L');
					$pdf->Cell(30, 5, ' ', 'R', 0, 'L');
					$pdf->Cell(10, 5, $csbl_qty, 'LR', 0, 'R');
					$pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
					$pdf->Cell(25, 5, $view_csbl_amount, 'LR', 0, 'R');
					$pdf->Cell(25, 5, '0', 'LR', 0, 'R');
					$pdf->Cell(25, 5, $view_csbl_amount, 'LR', 1, 'R');
				}

			} catch (PDOException $e) {
				error_log("Database Error (Cetak PDF BHP): " . $e->getMessage());
				$pdf->Cell(188, 5, 'Gagal memuat rincian Consumable. Silakan hubungi admin.', 1, 1, 'C');
			}
		}

		$pdf->Cell(113, 6, 'SUB TOTAL :', 'T', 0, 'R');
		$view_sub_total = number_format($sub_total, 0, '', '.');
		$pdf->Cell(25, 6, '' . $view_sub_total . '', 'T', 0, 'R');
		$pdf->Cell(25, 6, '0', 'T', 0, 'R');
		$pdf->Cell(25, 6, '' . $view_sub_total . '', 'T', 1, 'R');

		$pdf->Cell(113, 6, 'DISCOUNT :', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '0', 0, 1, 'R');

		$pdf->Cell(113, 6, 'ADMIN CHARGE :', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');

		// Periksa apakah ada obat racikan
		$sql_racikan_count = "SELECT COUNT(*) 
			FROM trxaprsc 
			WHERE TRXA_PRSC_CODE = :regicode 
			AND TRXA_PRSC_CONC = 'Y'
			AND TRXA_PRSC_STAT = 'P'
			AND TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt_racikan_count = $db->prepare($sql_racikan_count);

			$stmt_racikan_count->execute([
				':regicode' => $regicode
			]);

			$ketersediaan_racikan = $stmt_racikan_count->fetchColumn();

		} catch (PDOException $e) {
			error_log("Database Error (Periksa Obat Racikan): " . $e->getMessage());
			$ketersediaan_racikan = 0;
		}

		if ($ketersediaan_racikan == 0) {
			$sql_resep = "SELECT COUNT(*) FROM trxaprsc 
                  WHERE TRXA_PRSC_CODE = :regicode
                    AND TRXA_PRSC_STAT = 'P'
                    AND TRXA_VIEW_STAT = 'Y'";

			try {
				$stmt_resep = $db->prepare($sql_resep);
				$stmt_resep->execute([':regicode' => $regicode]);
				$ketersediaan_resep = $stmt_resep->fetchColumn();
			} catch (PDOException $e) {
				error_log("Database Error (Periksa Resep): " . $e->getMessage());
				$ketersediaan_resep = 0;
			}

			if ($ketersediaan_resep == 0) {
				$sql_admin = "SELECT COUNT(*) FROM trxaregi 
                      WHERE TRXA_REGI_CODE = :regicode 
                        AND TRXA_REGI_FEE = 'P'";

				try {
					$stmt_admin = $db->prepare($sql_admin);
					$stmt_admin->execute([':regicode' => $regicode]);
					$ketersediaan_biayaadmin = $stmt_admin->fetchColumn();
				} catch (PDOException $e) {
					error_log("Database Error (Periksa Biaya Admin): " . $e->getMessage());
					$ketersediaan_biayaadmin = 0;
				}

				if ($ketersediaan_biayaadmin == 0) {
					$total_admin = 0;
				} else {
					$total_admin = $fee_admin;
				}

			} else {
				$total_admin = $fee_admin + $fee_resep;
			}

		} else {
			$total_admin = $fee_admin + $fee_resep + $fee_racikan;
		}

		$view_fee_admin = number_format($total_admin, 0, '', '.');

		$pdf->Cell(25, 6, '' . $view_fee_admin . '', 0, 1, 'R');

		$pdf->Cell(113, 6, 'TOTAL :', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$sub_total = $sub_total + $total_admin;
		$subbulat = pembulatan($sub_total);
		$view_sub_total = number_format($subbulat, 0, '', '.');
		$pdf->Cell(25, 6, '' . $view_sub_total . '', 0, 1, 'R');

		$sql_payment = "SELECT 
				TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, 
				TRXA_PAYM_OUTS AS BALANCE 
			FROM trxasale 
			WHERE TRXA_REGI_CODE = :regicode 
			AND TRXA_SALE_CODE = :salecode 
			AND TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt_payment = $db->prepare($sql_payment);
			$stmt_payment->execute([
				':regicode' => $regicode,
				':salecode' => $salecode
			]);

			$row_payment = $stmt_payment->fetch(PDO::FETCH_ASSOC);

			if (!$row_payment) {
				$row_payment = [
					'PAYMENT_AMOUNT' => 0,
					'BALANCE' => 0
				];
			}

		} catch (PDOException $e) {
			error_log("Database Error (Ambil Data Pembayaran): " . $e->getMessage());
			$row_payment = [
				'PAYMENT_AMOUNT' => 0,
				'BALANCE' => 0
			];
		}

		$payment = $row_payment['PAYMENT_AMOUNT'];
		$balance = $row_payment['BALANCE'];

		$pdf->Cell(113, 6, 'PAYMENT :', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');

		$view_payment = number_format($payment, 0, '', '.');
		$pdf->Cell(25, 6, '' . $view_payment . '', 0, 1, 'R');

		$pdf->Cell(113, 6, 'BALANCE :', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');
		$pdf->Cell(25, 6, '', 0, 0, 'R');

		$view_balance = number_format($balance, 0, '', '.');
		$pdf->Cell(25, 6, '' . $view_balance . '', 0, 1, 'R');

		$pdf->Cell(60, 5, 'IN WORDS TOTAL :', 0, 0, 'L');
		$pdf->SetFont('Arial', '', 8);

		$words_patient = terbilang($view_sub_total);
		$pdf->Cell(70, 5, '' . $words_patient . ' Rupiah', 0, 1, 'R');

		$pdf->Ln(4);

		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(60, 5, 'PATIENT RECEIPT / KUITANSI :', 0, 1, 'L');

		$pdf->SetFont('Arial', '', 8);

		$pdf->Cell(18, 5, 'Type', 'LTBR', 0, 'L');
		$pdf->Cell(18, 5, 'Date', 'LTBR', 0, 'L');
		$pdf->Cell(22, 5, 'Payment Mode', 'LTBR', 0, 'L');
		$pdf->Cell(20, 5, 'Account No.', 'LTBR', 0, 'L');
		$pdf->Cell(20, 5, 'Account Name', 'LTBR', 0, 'L');
		$pdf->Cell(25, 5, 'Description', 'LTBR', 0, 'L');
		$pdf->Cell(40, 5, 'Cashier', 'LTBR', 0, 'R');
		$pdf->Cell(25, 5, 'Patient', 'LTBR', 1, 'R');

		$sql_footer = "SELECT 
				s.TRXA_PAYM_MODE, 
				s.TRXA_ENTR_DATE, 
				s.TRXA_ENTR_USER, 
				u.PASS_USER_NAME AS CASHIER 
			FROM trxasale s
			LEFT JOIN passiden u ON u.PASS_USER_IDEN = s.TRXA_ENTR_USER
			WHERE s.TRXA_SALE_CODE = :invoice_no 
			AND s.TRXA_VIEW_STAT = 'Y'
		";

		try {
			$stmt_footer = $db->prepare($sql_footer);
			$stmt_footer->execute([
				':invoice_no' => $invoice_no
			]);

			$row_footer = $stmt_footer->fetch(PDO::FETCH_ASSOC);

			if (!$row_footer) {
				$row_footer = [
					'TRXA_PAYM_MODE' => '-',
					'TRXA_ENTR_DATE' => date('Y-m-d'),
					'TRXA_ENTR_USER' => '-',
					'CASHIER' => 'Admin'
				];
			}

		} catch (PDOException $e) {
			error_log("Database Error (Ambil Data Footer): " . $e->getMessage());
			$row_footer = [
				'TRXA_PAYM_MODE' => '-',
				'TRXA_ENTR_DATE' => date('Y-m-d'),
				'TRXA_ENTR_USER' => '-',
				'CASHIER' => 'Admin'
			];
		}

		if ($row_footer['TRXA_PAYM_MODE'] == 'TUN') {
			$paymmode = 'Cash';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BCA') {
			$paymmode = 'Debit BCA';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'MAN') {
			$paymmode = 'Debit Mandiri';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BNI') {
			$paymmode = 'Debit BNI';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BRI') {
			$paymmode = 'Debit BRI';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BCM') {
			$paymmode = 'Transfer BCA';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'MAM') {
			$paymmode = 'Transfer Mandiri';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BIM') {
			$paymmode = 'Transfer BNI';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'BRM') {
			$paymmode = 'Transfer BRI';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'qrBCA') {
			$paymmode = 'Qris BCA';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'qrMAN') {
			$paymmode = 'Qris Mandiri';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'qrBNI') {
			$paymmode = 'Qris BNI';
		} else if ($row_footer['TRXA_PAYM_MODE'] == 'qrBRI') {
			$paymmode = 'Qris BRI';
		} else {
			$paymode = 'unpaid';
		}

		$paymdate = date("d/m/Y", strtotime($row_footer['TRXA_ENTR_DATE']));
		$cashier = $row_footer['CASHIER'];

		$pdf->Cell(18, 5, 'Payment', 'LTBR', 0, 'L');
		$pdf->Cell(18, 5, '' . $paymdate . '', 'LTBR', 0, 'L');
		$pdf->Cell(22, 5, '' . $paymmode . '', 'LTBR', 0, 'L');
		//$pdf->Cell(22,8,' ','LTBR',0,'L'); 
		$pdf->Cell(20, 5, ' ', 'LTBR', 0, 'R');
		$pdf->Cell(20, 5, ' ', 'LTBR', 0, 'L');
		$pdf->Cell(25, 5, ' ', 'LTBR', 0, 'R');
		$pdf->Cell(40, 5, '' . $cashier . '', 'LTBR', 0, 'R');
		$pdf->Cell(25, 5, '' . $view_payment . '', 'LTBR', 1, 'R');

		//$pdf->Cell(163,6,'TOTAL :',0,0,'R'); 
		//$pdf->Cell(25,6,''.$view_payment.'',0,1,'R');

		//$pdf->Ln(2);
		//$pdf->Cell(150,6,' ',0,0,'R'); 

		//$pdf->Cell(30,6,'CASHIER',0,0,'C'); 
		//$pdf->Ln(15);
		//$pdf->Cell(150,6,' ',0,0,'R'); 
		//$pdf->Cell(30,6,''.$cashier.'',0,0,'C'); 

		$pdf->Output('I', 'KWITANSI-' . $invoice_no . '.pdf');

	}

} else {
	header("location: " . "TRXASALE02.php");
}

?>