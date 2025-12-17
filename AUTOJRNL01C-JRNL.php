<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
include "inc/sanie.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $viewitemjurnal = $_POST['q'];
        //$viewitemjurnal = '05112021-00014|05112021-00017';
        list($outsalecode, $outregicode) = explode("|",$viewitemjurnal);

        // resep obat
        $query_prsc = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_DRUGS 
                        FROM 
                        (
                        SELECT (TRXA_STOCK_PRIC * '$profit') AS SALE_PRIC, TRXA_STOCK_QUTY, 
                        ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS TOTAL_PRIC 
                        FROM trxaprsc 
                        WHERE TRXA_PRSC_CODE = '$outregicode' 
                        AND TRXA_PRSC_STAT = 'P' AND TRXA_VIEW_STAT='Y'
                        ) 
                        AS DRUGS_TABLE";    

        $qprsc = $db->query($query_prsc) or die("Gagal Ambil data penjualan obat!!");
        $row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC);

        $xharga_prsc = round($row_prsc['SALE_DRUGS']);
        $int_prsc = (int)$xharga_prsc;

        $sale_drugs = pembulatan($int_prsc);

        $tax_base = ($sale_drugs * (100/110));
        $vat_out = $tax_base * (10/100);

        $data_jurnal = "|$sale_drugs|$tax_base|$code_sale_drugs|$name_sale_drugs"; 
        $data_jurnal .= "|$vat_out|$code_vat_out|$name_vat_out";

        // BHP / Consumable
        $query_csbl = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_BHP
                        FROM 
                        (
                        SELECT (TRXA_STOCK_PRIC * '$profit') AS STOCK_PRIC, TRXA_STOCK_QUTY, 
                        ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS TOTAL_PRIC
                        FROM trxacsbl 
                        WHERE TRXA_CSBL_CODE = '$outregicode' 
                        AND TRXA_CSBL_STAT = 'P' AND TRXA_VIEW_STAT='Y'
                        )
                        AS BHP_TABLE";

        $xxxxxxquery_csbl = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_BHP
                        FROM 
                        (
                        SELECT TRXA_STOCK_CODE,  
                        (TRXA_STOCK_PRIC * '$profit') AS STOCK_PRIC, TRXA_STOCK_QUTY, 
                        ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS TOTAL_PRIC
                        FROM trxacsbl 
                        WHERE TRXA_CSBL_CODE = '$outregicode' 
                        AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                            (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=TRXA_STOCK_CODE)
                            ) = 'FG'
                        AND TRXA_CSBL_STAT = 'P' AND TRXA_VIEW_STAT='Y'
                        )
                        AS BHP_TABLE";


        $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP!!");
        $row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC);

        $xharga_csbl = round($row_csbl['SALE_BHP']);
        $int_csbl = (int)$xharga_csbl;

        $sale_bhp = pembulatan($int_csbl);

        $data_jurnal .= "|$sale_bhp|$code_sale_bhp|$name_sale_bhp";

        // 
        $query_payment = "SELECT TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, 
                          TRXA_PAYM_OUTS AS BALANCE,
                          TRXA_PAYM_MODE
                        FROM trxasale 
                        WHERE TRXA_REGI_CODE='$outregicode' AND TRXA_SALE_CODE='$outsalecode' AND TRXA_VIEW_STAT='Y'";

        $qpayment = $db->query($query_payment) or die("Gagal Ambil data Pembayaran");
        $row_payment = $qpayment->fetch(PDO::FETCH_ASSOC);

        $xpayment_amount = round($row_payment['PAYMENT_AMOUNT']);
        $int_payment_amount = (int)$xpayment_amount;
        $payment_amount = pembulatan($int_payment_amount);

        $xpayment_balance = round($row_payment['BALANCE']);
        $int_payment_balance = (int)$xpayment_balance;
        $payment_balance = pembulatan($int_payment_balance);

        if ($row_payment['TRXA_PAYM_MODE'] == 'BCA')
        {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
        }
    else if ($row_payment['TRXA_PAYM_MODE'] == 'MAN')
        {
            $code_payment = $code_mandiri;
            $name_payment = $name_mandiri;          
        }
    else if ($row_payment['TRXA_PAYM_MODE'] == 'BNI')
        {
            $code_payment = $code_bni;
            $name_payment = $name_bni;          
        }
    else if ($row_payment['TRXA_PAYM_MODE'] == 'BCM')
        {
            $code_payment = $code_bca;
            $name_payment = $name_bca;          
        }
    else if ($row_payment['TRXA_PAYM_MODE'] == 'LIN')
        {
            $code_payment = $code_bni;
            $name_payment = $name_bni;          
        }
    else
        {
            $code_payment = $code_cash;
            $name_payment = $name_cash;
        }

        $cash_drugs = ($sale_drugs + $sale_bhp);
        $code_cash_drugs = $code_payment;
        $name_cash_drugs = $name_payment;

        $data_jurnal .= "|$cash_drugs|$code_cash_drugs|$name_cash_drugs";

        $inventory_drugs = ($sale_drugs / $profit);
        $data_jurnal .= "|$inventory_drugs|$code_inventory_drugs|$name_inventory_drugs";

        $inventory_bhp = ($sale_bhp / $profit);
        $data_jurnal .= "|$inventory_bhp|$code_inventory_bhp|$name_inventory_bhp";

        $usage_cost = ($inventory_drugs + $inventory_bhp);
        $data_jurnal .= "|$usage_cost|$code_usage_cost|$name_usage_cost";

        // Tindakan Pemeriksaan Dokter 

        $query_tret_doct = "SELECT IF(SUM(TRET_AMOUNT) IS NULL OR SUM(TRET_AMOUNT) = '', 0,SUM(TRET_AMOUNT)) AS TRET_DOCT 
                        FROM 
                        (SELECT TRXA_TRET_CODE AS TRET_CODE, TRXA_MEDI_ROOM AS MEDI_ROOM,
                         SUM(TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS TRET_AMOUNT FROM trxatret
                         GROUP BY MEDI_ROOM, TRET_CODE) AS TRET_TABLE
                         WHERE TRET_CODE = '$outregicode' AND MEDI_ROOM NOT IN ('$code_lab_room','$code_keb_room')";    

        $qtret_doct = $db->query($query_tret_doct) or die("Gagal Ambil data tindakan dokter!!");
        $row_tret_doct = $qtret_doct->fetch(PDO::FETCH_ASSOC);

        $xharga_tret_doct = round($row_tret_doct['TRET_DOCT']);
        $int_tret_doct = (int)$xharga_tret_doct;

        $tret_doct = pembulatan($int_tret_doct);

        $data_jurnal .= "|$tret_doct|$code_tret_doct|$name_tret_doct";

        // Tindakan Pemeriksaan Bidan

        $query_tret_nurs = "SELECT IF(SUM(TRET_AMOUNT) IS NULL OR SUM(TRET_AMOUNT) = '', 0,SUM(TRET_AMOUNT)) AS TRET_NURS 
                        FROM 
                        (SELECT TRXA_TRET_CODE AS TRET_CODE, TRXA_MEDI_ROOM AS MEDI_ROOM,
                         SUM(TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS TRET_AMOUNT FROM trxatret
                         GROUP BY MEDI_ROOM, TRET_CODE) AS TRET_TABLE
                         WHERE TRET_CODE = '$outregicode' AND MEDI_ROOM = '$code_keb_room'";    

        $qtret_nurs = $db->query($query_tret_nurs) or die("Gagal Ambil data tindakan bidan!!");
        $row_tret_nurs = $qtret_nurs->fetch(PDO::FETCH_ASSOC);

        $xharga_tret_nurs = round($row_tret_nurs['TRET_NURS']);
        $int_tret_nurs = (int)$xharga_tret_nurs;

        $tret_nurs = pembulatan($int_tret_nurs);

        $data_jurnal .= "|$tret_nurs|$code_tret_nurs|$name_tret_nurs";

        // Tindakan Pemeriksaan Laborat

        $query_tret_labs = "SELECT IF(SUM(TRET_AMOUNT) IS NULL OR SUM(TRET_AMOUNT) = '', 0,SUM(TRET_AMOUNT)) AS TRET_LABS 
                        FROM 
                        (SELECT TRXA_TRET_CODE AS TRET_CODE, TRXA_MEDI_ROOM AS MEDI_ROOM,
                         SUM(TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS TRET_AMOUNT FROM trxatret
                         GROUP BY MEDI_ROOM, TRET_CODE) AS TRET_TABLE
                         WHERE TRET_CODE = '$outregicode' AND MEDI_ROOM = '$code_lab_room'";    

        $qtret_labs = $db->query($query_tret_labs) or die("Gagal Ambil data tindakan laborat!!");
        $row_tret_labs = $qtret_labs->fetch(PDO::FETCH_ASSOC);

        $xharga_tret_labs = round($row_tret_labs['TRET_LABS']);
        $int_tret_labs = (int)$xharga_tret_labs;

        $tret_labs = pembulatan($int_tret_labs);

        $data_jurnal .= "|$tret_labs|$code_tret_labs|$name_tret_labs";

        $cash_tret = ((($tret_doct + $tret_nurs) + $tret_labs) - $payment_balance);
        $code_cash_tret = $code_payment;
        $name_cash_tret = $name_payment;

        $data_jurnal .= "|$cash_tret|$code_cash_tret|$name_cash_tret";

        $account_receivable = $payment_balance;

        $data_jurnal .= "|$account_receivable|$code_account_receivable|$name_account_receivable";

        // Biaya Admin
        // Periksa apakah ada obat racikan
        $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$outregicode' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";

        $periksaracikan_di_query=$db->query($periksaracikan) or die ("Gagal Periksa racikan");
        $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

        if ($ketersediaan_racikan == 0)
        {
            // Periksa apakah ada resep yang diberikan
            $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$outregicode'
                     AND TRXA_PRSC_STAT='P'
                     AND TRXA_VIEW_STAT='Y'";
            $periksaresep_di_query=$db->query($periksaresep) or die ("Gagal Periksa Resep");
            $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

            if ($ketersediaan_resep == 0)
            {
                // periksa di data register apakah di kenakan biaya admin
                $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$outregicode' AND TRXA_REGI_FEE='P'";
                $periksabiayaadmin_di_query=$db->query($periksabiayaadmin) or die ("Gagal Cek Fail");
                $ketersediaan_biayaadmin = $periksabiayaadmin_di_query->fetchColumn();

                if ($ketersediaan_biayaadmin == 0)
                {
                  $total_admin = 0;
                }
                else
                {
                  $total_admin = $fee_admin;
                }                
            }
            else
            {
                $total_admin = ($fee_admin + $fee_resep);  
            }
        }
        else
        {
            $total_admin = ($fee_admin + ($fee_resep + $fee_racikan));  
        }

        if ($total_admin == 20000) { $input_fee_admin = 5000; $input_fee_resep = 15000;}
        else if ($total_admin == 15000) { $input_fee_admin = 5000; $input_fee_resep = 10000;}
        else if ($total_admin == 5000) { $input_fee_admin = 5000; $input_fee_resep = 0;}
        else { $input_fee_admin = 0; $input_fee_resep = 0;}

        $data_jurnal .= "|$input_fee_admin|$code_fee_admin|$name_fee_admin";

        $data_jurnal .= "|$input_fee_resep|$code_fee_resep|$name_fee_resep";

        $cash_admin = $total_admin;
        $code_cash_admin = $code_payment;
        $name_cash_admin = $name_payment;

        $data_jurnal .= "|$cash_admin|$code_cash_admin|$name_cash_admin";

        //$view_fee_admin = number_format($total_admin, 0, '', '.'); 

        echo $data_jurnal;    
   }
}
?>