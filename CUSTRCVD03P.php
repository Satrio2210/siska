<?php
// =============================================================================
// CUSTRCVD03P.php
// Cetak massal Kwitansi/Invoice pasien berobat dalam satu file PDF.
// Tiap kwitansi tampil pada halaman terpisah.
// Logika perhitungan mengikuti TRXASALE02P.php (invoice resmi) agar konsisten.
//
// Parameter (GET):
//   start = tanggal awal berobat (YYYY-MM-DD), default 2026-01-01
//   end   = tanggal akhir berobat (YYYY-MM-DD), default 2026-06-30
// =============================================================================

include 'conf/config.php';
include 'inc/sanie.php';

// Endpoint biner (PDF): pastikan tidak ada teks (warning/notice/deprecated)
// yang ikut tercetak sebelum output PDF, karena akan merusak file.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');

// ---- Ambil & validasi rentang tanggal --------------------------------------
$start = isset($_GET['start']) ? trim($_GET['start']) : '2026-01-01';
$end   = isset($_GET['end'])   ? trim($_GET['end'])   : '2026-06-30';

$re_date = '/^\d{4}-\d{2}-\d{2}$/';
if (!preg_match($re_date, $start)) { $start = '2026-01-01'; }
if (!preg_match($re_date, $end))   { $end   = '2026-06-30'; }

// ---- Ambil daftar transaksi (kwitansi) dalam rentang tanggal berobat -------
$query_list = "SELECT s.TRXA_SALE_CODE AS SALE_CODE, s.TRXA_REGI_CODE AS REGI_CODE
               FROM trxasale s
               INNER JOIN trxaregi r ON r.TRXA_REGI_CODE = s.TRXA_REGI_CODE
               WHERE r.TRXA_REGI_DATE BETWEEN '$start' AND '$end'
                 AND s.TRXA_VIEW_STAT = 'Y'
                 AND r.TRXA_VIEW_STAT = 'Y'
               ORDER BY r.TRXA_REGI_DATE ASC, s.TRXA_SALE_CODE ASC";

$qlist = $db->query($query_list) or die("Gagal ambil daftar kwitansi!!");
$daftar = $qlist->fetchAll(PDO::FETCH_ASSOC);

// ---- Siapkan PDF ------------------------------------------------------------
require('pdf/fpdf.php');
$pdf = new FPDF('p', 'mm', 'A4');
$pdf->SetAutoPageBreak(true);

if (count($daftar) == 0) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'TIDAK ADA KWITANSI', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(190, 6, 'Tidak ada pasien berobat pada rentang ' . $start . ' s/d ' . $end, 0, 1, 'C');
    $pdf->Output('I', 'KWITANSI-' . $start . '_' . $end . '.pdf');
    exit;
}

if (!function_exists('get_mapped_signa')) {
    function get_mapped_signa($signa) {
        if ($signa == '01') return '1x1 Sebelum Makan';
        if ($signa == '02') return '2x1 Sebelum Makan';
        if ($signa == '03') return '3x1 Sebelum Makan';
        if ($signa == '04') return '1x1 Sesudah Makan';
        if ($signa == '05') return '2x1 Sesudah Makan';
        if ($signa == '06') return '3x1 Sesudah Makan';
        if ($signa == '07') return '4x1 Sesudah Makan';
        if ($signa == '08') return '5x1 Sesudah Makan';
        if ($signa == '09') return '3x1 Oles Tipis';
        if ($signa == '10') return '3x1 Tetes Pada Mata Yang Sakit';
        return $signa;
    }
}

foreach ($daftar as $item) {
    render_kwitansi($pdf, $db, $item['REGI_CODE'], $item['SALE_CODE']);
}

$pdf->Output('I', 'KWITANSI-' . $start . '_' . $end . '.pdf');

// =============================================================================
// Fungsi render satu kwitansi (satu halaman PDF).
// Disalin dari TRXASALE02P.php agar tampilan & perhitungan identik.
// =============================================================================
function render_kwitansi($pdf, $db, $regicode, $salecode)
{
    global $fee_admin, $fee_resep, $fee_racikan;

    $no = 0;
    $sub_total = 0;

    // ---- Header ----
    $query_header = "SELECT TRXA_SALE_CODE AS INVOICE_NO,
                TRXA_REGI_CODE AS REGI_CODE, TRXA_PATI_CODE AS PATI_CODE,
                (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=PATI_CODE) AS NAME,
                CONCAT(TRXA_ENTR_DATE,' ',TRXA_ENTR_TIME) AS INVOICE_DATE,
                (SELECT PATI_MAIN_ADDR FROM patimast WHERE PATI_MAST_CODE=PATI_CODE) AS ADDRESS,
                (SELECT CONCAT(TRXA_ENTR_DATE,' ',TRXA_ENTR_TIME) FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS ADMISSION_DATE,
                (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS PATIENT_TYPE,
                (SELECT CONCAT(TRXA_UPDT_DATE,' ',TRXA_UPDT_TIME) FROM trxaregi WHERE TRXA_REGI_CODE = REGI_CODE) AS DISCHARGE_DATE,
                TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS PRIMARY_DOCTOR
                FROM trxasale
                WHERE TRXA_SALE_CODE = '$salecode' AND TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";

    $qheader = $db->query($query_header) or die("Gagal Ambil Query header!!");
    $row_header = $qheader->fetch(PDO::FETCH_ASSOC);
    if (!$row_header) { return; }

    $admission_no = $row_header['REGI_CODE'];
    $mr_no = $row_header['PATI_CODE'];
    $invoice_no = $row_header['INVOICE_NO'];
    $name = $row_header['NAME'];
    $invoice_date = $row_header['INVOICE_DATE'];
    $address = $row_header['ADDRESS'];
    $admission_date = $row_header['ADMISSION_DATE'];
    $discharge_date = $row_header['DISCHARGE_DATE'];

    if ($row_header['PATIENT_TYPE'] == 'U') { $patient_type = 'Umum'; }
    else if ($row_header['PATIENT_TYPE'] == 'B') { $patient_type = 'BPJS'; }
    else if ($row_header['PATIENT_TYPE'] == 'A') { $patient_type = 'Asuransi'; }
    else if ($row_header['PATIENT_TYPE'] == 'P') { $patient_type = 'Perusahaan'; }
    else if ($row_header['PATIENT_TYPE'] == 'H') { $patient_type = 'Halodoc'; }
    else { $patient_type = 'No Type'; }

    $primary_doctor = $row_header['PRIMARY_DOCTOR'];

    // ---- Layout header PDF ----
    $pdf->AddPage();
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Image('img/logo.png', 10, 5, 20);
    if (file_exists('img/qr-code.png')) { $pdf->Image('img/qr-code.png', 175, 5, 20); }
    $pdf->Ln(5);

    $pdf->Cell(190, 8, 'INVOICE', 0, 1, 'C');
    $pdf->Ln(2);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(30, 5, 'Admission No/MR', 0, 0, 'L');
    $pdf->Cell(90, 5, ': ' . $admission_no . '/' . $mr_no . '', 0, 0, 'L');
    $pdf->Cell(30, 5, 'Invoice No', 0, 0, 'L');
    $pdf->Cell(35, 5, ': ' . $invoice_no . '', 0, 1, 'L');

    $pdf->Cell(30, 5, 'Name', 0, 0, 'L');
    $pdf->Cell(90, 5, ': ' . $name . '', 0, 0, 'L');
    $pdf->Cell(30, 5, 'Invoice Date', 0, 0, 'L');
    $pdf->Cell(35, 5, ': ' . $invoice_date . '', 0, 1, 'L');

    $pdf->Cell(30, 5, 'Address', 0, 0, 'L');
    $pdf->Cell(90, 5, ': ' . $address . '', 0, 0, 'L');
    $pdf->Cell(30, 5, 'Admission Date', 0, 0, 'L');
    $pdf->Cell(35, 5, ': ' . $admission_date . '', 0, 1, 'L');

    $pdf->Cell(30, 5, 'Patient Type', 0, 0, 'L');
    $pdf->Cell(90, 5, ': ' . $patient_type . '', 0, 0, 'L');
    $pdf->Cell(30, 5, 'Discharge Date', 0, 0, 'L');
    $pdf->Cell(35, 5, ': ' . $discharge_date . '', 0, 1, 'L');

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
    // ---- DRUGS ----
    $periksatrxaprsc = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                    AND TRXA_PRSC_STAT = 'P'";
    $periksatrxaprsc_di_query = $db->query($periksatrxaprsc) or die("Gagal periksa Obat");
    $ketersediaanprsc = $periksatrxaprsc_di_query->fetchColumn();

    if ($ketersediaanprsc > 0) {
        $pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
        $pdf->Cell(50, 5, 'DRUGS', 'L', 0, 'L');
        $pdf->Cell(30, 5, '  ', 'R', 0, 'L');
        $pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

        $query_prsc = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE,
                (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME,
                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS SPEC_CODE,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
                (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS UNIT_CODE,
                (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,
                TRXA_STOCK_PRIC AS STOCK_PRIC, TRXA_STOCK_QUTY,
                (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC,
                (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE,
                TRXA_PRSC_SGNA, TRXA_PRSC_CONC, TRXA_RACIK_ID
                FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode' AND TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT='Y'";

        $qprsc = $db->query($query_prsc) or die("Gagal Ambil data obat!!");
        $all_prsc_rows = array();
        while ($row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC)) { $all_prsc_rows[] = $row_prsc; }

        $final_items = array();
        $racik_indices = array();

        foreach ($all_prsc_rows as $row) {
            $qty_prsc = $row['TRXA_STOCK_QUTY'];
            $raw_pric_prsc = $row['STOCK_PRIC'];

            $stockpric_bulat = pembulatan((int) round($raw_pric_prsc));
            $tott = $stockpric_bulat * $qty_prsc;
            $totapric = pembulatan($tott);

            $is_racikan = ($row['TRXA_PRSC_CONC'] === 'Y' && !empty($row['TRXA_RACIK_ID']) && $row['TRXA_RACIK_ID'] > 0);

            if ($is_racikan) {
                $racik_id = $row['TRXA_RACIK_ID'];
                if (!isset($racik_indices[$racik_id])) {
                    $qhead = $db->query("SELECT TRXAR_NAMA, TRXAR_QTY, TRXAR_SGNA FROM trxaracik_head WHERE TRXAR_ID = " . (int)$racik_id . " LIMIT 1");
                    $head_row = $qhead ? $qhead->fetch(PDO::FETCH_ASSOC) : null;

                    $racik_nama = ($head_row && !empty($head_row['TRXAR_NAMA'])) ? $head_row['TRXAR_NAMA'] : 'Obat';
                    $racik_qty = ($head_row && isset($head_row['TRXAR_QTY'])) ? $head_row['TRXAR_QTY'] : 1;
                    $racik_sgna = ($head_row && !empty($head_row['TRXAR_SGNA'])) ? $head_row['TRXAR_SGNA'] : '';

                    $final_items[] = array(
                        'is_racikan' => true,
                        'racik_id' => $racik_id,
                        'name' => $racik_nama . ' (Racikan)',
                        'qty' => $racik_qty,
                        'unit' => 'Pcs',
                        'signa' => $racik_sgna,
                        'total_price' => 0,
                        'paym_type' => $row['PAYM_TYPE']
                    );
                    $racik_indices[$racik_id] = count($final_items) - 1;
                }
                $final_items[$racik_indices[$racik_id]]['total_price'] += $totapric;
            } else {
                $final_items[] = array(
                    'is_racikan' => false,
                    'name' => $row['STOCK_NAME'] . ($row['SPEC_NAME'] ? ' ' . $row['SPEC_NAME'] : ''),
                    'qty' => $qty_prsc,
                    'unit' => isset($row['UNIT_NAME']) ? $row['UNIT_NAME'] : '',
                    'signa' => isset($row['TRXA_PRSC_SGNA']) ? $row['TRXA_PRSC_SGNA'] : '',
                    'total_price' => $totapric,
                    'paym_type' => $row['PAYM_TYPE']
                );
            }
        }

        foreach ($final_items as &$f_item) {
            if ($f_item['is_racikan']) {
                $f_item['total_price'] += 50000;
                $f_item['total_price'] = pembulatan($f_item['total_price']);
            }
        }
        unset($f_item);

        foreach ($final_items as $it) {
            $no++;
            $totapric = $it['total_price'];
            $view_totapric = number_format($totapric, 0, '', '.');

            $display_name = $it['name'];
            $signa_desc = get_mapped_signa($it['signa']);

            $sub_total = $sub_total + $totapric;

            $pdf->Cell(8, 5, '' . $no . '', 'LR', 0, 'C');
            $pdf->Cell(50, 5, '' . $display_name . ($signa_desc ? ', (' . $signa_desc . ')' : '') . '', 'L', 0, 'L');
            $pdf->Cell(30, 5, '  ', 'R', 0, 'L');
            $pdf->Cell(10, 5, '' . $it['qty'] . '', 'LR', 0, 'R');
            $pdf->Cell(15, 5, '' . $it['unit'] . '', 'LR', 0, 'L');
            $pdf->Cell(25, 5, '' . $view_totapric . '', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '0', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '' . $view_totapric . '', 'LR', 1, 'R');
        }
    }
    // ---- TREATMENT ----
    $periksatrxatret = "SELECT COUNT(*) FROM (SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE,
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME,
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL,
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) IN ('O','N')
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_VIEW_STAT='Y') AS tabel_treat";
    $periksatrxatret_di_query = $db->query($periksatrxatret) or die("Gagal periksa Treatment");
    $ketersediaantret = $periksatrxatret_di_query->fetchColumn();

    if ($ketersediaantret > 0) {
        $pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
        $pdf->Cell(50, 5, 'TREATMENT', 'L', 0, 'L');
        $pdf->Cell(30, 5, '  ', 'R', 0, 'L');
        $pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

        $query_action = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE,
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME,
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL,
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) IN ('O','N')
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";

        $qaction = $db->query($query_action) or die("Gagal Ambil data tindakan!!");
        while ($row_action = $qaction->fetch(PDO::FETCH_ASSOC)) {
            $action_name = $row_action['MEDI_NAME'];
            $action_qty = $row_action['TRXA_TRET_QUTY'];
            $action_amount = $row_action['SUB_TOTAL'];
            $view_action_amount = number_format($row_action['SUB_TOTAL'], 0, '', '.');

            $no++;
            $sub_total = $sub_total + $action_amount;

            $pdf->Cell(8, 5, '' . $no . '', 'LR', 0, 'C');
            $pdf->Cell(50, 5, '' . $action_name . '', 'L', 0, 'L');
            $pdf->Cell(30, 5, ' ', 'R', 0, 'L');
            $pdf->Cell(10, 5, '' . $action_qty . '', 'LR', 0, 'R');
            $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
            $pdf->Cell(25, 5, '' . $view_action_amount . '', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '0', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '' . $view_action_amount . '', 'LR', 1, 'R');
        }
    }

    // ---- SERVICES ----
    $periksaservices = "SELECT COUNT(*) FROM (SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE,
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME,
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL,
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) = 'J'
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_VIEW_STAT='Y') AS tabel_services";
    $periksaservices_di_query = $db->query($periksaservices) or die("Gagal periksa Services Treatment");
    $ketersediaanservices = $periksaservices_di_query->fetchColumn();

    if ($ketersediaanservices > 0) {
        $pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
        $pdf->Cell(50, 5, 'SERVICES', 'L', 0, 'L');
        $pdf->Cell(30, 5, '  ', 'R', 0, 'L');
        $pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

        $query_tret = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE,
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME,
              TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE*TRXA_TRET_QUTY) AS SUB_TOTAL,
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PAYM_TYPE
              FROM trxatret WHERE (SELECT TBLF_MEDI_TYPE FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) = 'J'
              AND TRXA_TRET_CODE = '$regicode' AND TRXA_VIEW_STAT='Y'";

        $qtret = $db->query($query_tret) or die("Gagal Ambil data jasa pelayanan!!");
        while ($row_tret = $qtret->fetch(PDO::FETCH_ASSOC)) {
            $tret_name = $row_tret['MEDI_NAME'];
            $tret_qty = $row_tret['TRXA_TRET_QUTY'];
            $tret_amount = $row_tret['SUB_TOTAL'];
            $view_tret_amount = number_format($row_tret['SUB_TOTAL'], 0, '', '.');

            $no++;
            $sub_total = $sub_total + $tret_amount;

            $pdf->Cell(8, 5, '' . $no . '', 'LR', 0, 'C');
            $pdf->Cell(50, 5, '' . $tret_name . '', 'L', 0, 'L');
            $pdf->Cell(30, 5, ' ', 'R', 0, 'L');
            $pdf->Cell(10, 5, '' . $tret_qty . '', 'LR', 0, 'R');
            $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
            $pdf->Cell(25, 5, '' . $view_tret_amount . '', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '0', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '' . $view_tret_amount . '', 'LR', 1, 'R');
        }
    }
    // ---- CONSUMABLE (BHP) ----
    $periksatrxacsbl = "SELECT COUNT(*) FROM trxacsbl WHERE TRXA_CSBL_CODE='$regicode'
                    AND TRXA_CSBL_STAT = 'P'";
    $periksatrxacsbl_di_query = $db->query($periksatrxacsbl) or die("Gagal periksa BHP");
    $ketersediaancsbl = $periksatrxacsbl_di_query->fetchColumn();

    if ($ketersediaancsbl > 0) {
        $pdf->Cell(8, 5, ' ', 'LR', 0, 'C');
        $pdf->Cell(50, 5, 'CONSUMABLE', 'L', 0, 'L');
        $pdf->Cell(30, 5, '  ', 'R', 0, 'L');
        $pdf->Cell(10, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 0, 'R');
        $pdf->Cell(25, 5, ' ', 'LR', 1, 'R');

        $query_csbl = "SELECT TRXA_CSBL_CODE, TRXA_STOCK_CODE,
              (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_STOCK_CODE) AS STOCK_NAME,
              TRXA_STOCK_PRIC AS STOCK_PRIC, TRXA_STOCK_QUTY,
              (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS SUB_TOTAL_PRIC,
              (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_CSBL_CODE) AS PAYM_TYPE
              FROM trxacsbl WHERE TRXA_CSBL_CODE = '$regicode'
              AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE =
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=TRXA_STOCK_CODE)
                  ) = 'FG'
              AND TRXA_CSBL_STAT = 'P' AND TRXA_VIEW_STAT='Y'";

        $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP!!");
        while ($row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC)) {
            $csbl_name = $row_csbl['STOCK_NAME'];
            $csbl_qty = $row_csbl['TRXA_STOCK_QUTY'];

            $xharga = round($row_csbl['SUB_TOTAL_PRIC']);
            $int = (int) $xharga;
            $csbl_amount = pembulatan($int);
            $view_csbl_amount = number_format($csbl_amount, 0, '', '.');

            $no++;
            $sub_total = $sub_total + $csbl_amount;

            $pdf->Cell(8, 5, '' . $no . '', 'LR', 0, 'C');
            $pdf->Cell(50, 5, '' . $csbl_name . '', 'L', 0, 'L');
            $pdf->Cell(30, 5, ' ', 'R', 0, 'L');
            $pdf->Cell(10, 5, '' . $csbl_qty . '', 'LR', 0, 'R');
            $pdf->Cell(15, 5, ' ', 'LR', 0, 'L');
            $pdf->Cell(25, 5, '' . $view_csbl_amount . '', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '0', 'LR', 0, 'R');
            $pdf->Cell(25, 5, '' . $view_csbl_amount . '', 'LR', 1, 'R');
        }
    }
    // ---- SUMMARY ----
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

    $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";
    $periksaracikan_di_query = $db->query($periksaracikan) or die("Cek Fail");
    $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

    if ($ketersediaan_racikan == 0) {
        $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";
        $periksaresep_di_query = $db->query($periksaresep) or die("Cek Fail");
        $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

        if ($ketersediaan_resep == 0) {
            $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' AND TRXA_REGI_FEE='P'";
            $periksabiayaadmin_di_query = $db->query($periksabiayaadmin) or die("Cek Fail");
            $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

            if ($ketersediaan_biayaadmin == 0) { $total_admin = 0; }
            else { $total_admin = $fee_admin; }
        } else {
            $total_admin = ($fee_admin + $fee_resep);
        }
    } else {
        $total_admin = ($fee_admin + ($fee_resep + $fee_racikan));
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

    $query_payment = "SELECT TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, TRXA_PAYM_OUTS AS BALANCE FROM trxasale
                    WHERE TRXA_REGI_CODE='$regicode' AND TRXA_SALE_CODE='$salecode' AND TRXA_VIEW_STAT='Y'";
    $qpayment = $db->query($query_payment) or die("Gagal Ambil data Pembayaran!!");
    $row_payment = $qpayment->fetch(PDO::FETCH_ASSOC);
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

    // ---- Footer pembayaran ----
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

    $query_footer = "SELECT TRXA_PAYM_MODE, TRXA_ENTR_DATE, TRXA_ENTR_USER,
                  (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_ENTR_USER) AS CASHIER
                  FROM trxasale
                  WHERE TRXA_SALE_CODE='$invoice_no' AND TRXA_VIEW_STAT='Y'";
    $qfooter = $db->query($query_footer) or die("Gagal Ambil data Footer!!");
    $row_footer = $qfooter->fetch(PDO::FETCH_ASSOC);

    if ($row_footer['TRXA_PAYM_MODE'] == 'TUN') { $paymmode = 'Cash'; }
    else if ($row_footer['TRXA_PAYM_MODE'] == 'BCA') { $paymmode = 'Debit BCA'; }
    else if ($row_footer['TRXA_PAYM_MODE'] == 'MAN') { $paymmode = 'Debit Mandiri'; }
    else if ($row_footer['TRXA_PAYM_MODE'] == 'BNI') { $paymmode = 'Debit BNI'; }
    else if ($row_footer['TRXA_PAYM_MODE'] == 'BCM') { $paymmode = 'Transfer BCA'; }
    else if ($row_footer['TRXA_PAYM_MODE'] == 'LIN') { $paymmode = 'Transfer LinkAja'; }
    else { $paymmode = 'Unpaid'; }

    $paymdate = date("d/m/Y", strtotime($row_footer['TRXA_ENTR_DATE']));
    $cashier = $row_footer['CASHIER'];

    $pdf->Cell(18, 5, 'Payment', 'LTBR', 0, 'L');
    $pdf->Cell(18, 5, '' . $paymdate . '', 'LTBR', 0, 'L');
    $pdf->Cell(22, 5, '' . $paymmode . '', 'LTBR', 0, 'L');
    $pdf->Cell(20, 5, ' ', 'LTBR', 0, 'R');
    $pdf->Cell(20, 5, ' ', 'LTBR', 0, 'L');
    $pdf->Cell(25, 5, ' ', 'LTBR', 0, 'R');
    $pdf->Cell(40, 5, '' . $cashier . '', 'LTBR', 0, 'R');
    $pdf->Cell(25, 5, '' . $view_payment . '', 'LTBR', 1, 'R');
}
?>