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
        //$viewitemjurnal = $_POST['q'];
        $outsalecode = $_POST['q'];
        //list($outsalecode, $outregicode) = explode("|",$viewitemjurnal);

        // Penjualan Obat
        $xxxxxquery_prsc = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_DRUGS 
                        FROM 
                        (
                        SELECT ITEM_STOCK_CODE, (ITEM_STOCK_PRIC * '$profit') AS SALE_PRIC, ITEM_STOCK_QUTY, 
                        ((ITEM_STOCK_PRIC * '$profit') * ITEM_STOCK_QUTY) AS TOTAL_PRIC 
                        FROM itemdrug 
                        WHERE ITEM_DRUG_CODE = '$outsalecode'
                        AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) = 'ST'
                        AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'
                        ) 
                        AS DRUGS_TABLE";    

        $query_prsc = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_DRUGS 
                        FROM 
                        (
                        SELECT ITEM_STOCK_CODE, ITEM_STOCK_PRIC AS SALE_PRIC, ITEM_STOCK_QUTY, 
                        (ITEM_STOCK_PRIC * ITEM_STOCK_QUTY) AS TOTAL_PRIC 
                        FROM itemdrug 
                        WHERE ITEM_DRUG_CODE = '$outsalecode'
                        AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) = 'ST'
                        AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'
                        ) 
                        AS DRUGS_TABLE";    


        $qprsc = $db->query($query_prsc) or die("Gagal Ambil data penjualan obat!!");
        $row_prsc = $qprsc->fetch(PDO::FETCH_ASSOC);

        $xharga_prsc = round($row_prsc['SALE_DRUGS']);
        $int_prsc = (int)$xharga_prsc;

        $xsale_drugs = pembulatan($int_prsc);

        $query_taxbase = "SELECT TRXA_PAYM_DISC AS DISKON, TRXA_PAYM_OUTS AS KENA_PAJAK FROM trxadrug 
                    WHERE TRXA_DRUG_CODE='$outsalecode'  AND TRXA_VIEW_STAT='Y'";

        $qtaxbase = $db->query($query_taxbase) or die("Gagal ambil data dasar kena pajak");
        $row_taxbase = $qtaxbase->fetch(PDO::FETCH_ASSOC);

        $xharga_taxbase = round($row_taxbase['KENA_PAJAK']);
        $int_taxbase = (int)$xharga_taxbase;

        $xtax_base = pembulatan($int_taxbase);
        $tax_base = ($xtax_base * (100/110));
        $vat_out = $tax_base * (10/100);            

        $xharga_diskon = round($row_taxbase['DISKON']);
        $int_diskon = (int)$xharga_diskon;

        $xdiskon = pembulatan($int_diskon);
        $sale_drugs = $xsale_drugs - $xdiskon;

        //$tax_base = ($sale_drugs * (100/110));
        //$vat_out = $tax_base * (10/100);

        $data_jurnal = "|$sale_drugs|$tax_base|$code_sale_drugs|$name_sale_drugs"; 
        $data_jurnal .= "|$vat_out|$code_vat_out|$name_vat_out";

        // BHP / Consumable
        $query_csbl = "SELECT IF(SUM(TOTAL_PRIC) IS NULL OR SUM(TOTAL_PRIC) = '', 0,SUM(TOTAL_PRIC)) AS SALE_BHP
                        FROM 
                        (
                        SELECT ITEM_STOCK_PRIC AS STOCK_PRIC, ITEM_STOCK_QUTY, 
                        ITEM_STOCK_CODE, (ITEM_STOCK_PRIC * ITEM_STOCK_QUTY) AS TOTAL_PRIC
                        FROM itemdrug 
                        WHERE ITEM_DRUG_CODE = '$outsalecode' 
                        AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=ITEM_STOCK_CODE) = 'NS'
                        AND (SELECT TBLI_TYPE_CATE FROM tblitype WHERE TBLI_TYPE_CODE = 
                      (SELECT INVE_MAIN_TYPE FROM invemast WHERE  INVE_MAST_CODE=ITEM_STOCK_CODE)
                  ) = 'FG'
                        AND ITEM_DRUG_STAT = 'P' AND ITEM_VIEW_STAT='Y'
                        )
                        AS BHP_TABLE";


        $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP!!");
        $row_csbl = $qcsbl->fetch(PDO::FETCH_ASSOC);

        $xharga_csbl = round($row_csbl['SALE_BHP']);
        $int_csbl = (int)$xharga_csbl;

        $sale_bhp = pembulatan($int_csbl);

        $data_jurnal .= "|$sale_bhp|$code_sale_bhp|$name_sale_bhp";

        // pembayaran
        $query_payment = "SELECT TRXA_PAYM_AMNT AS PAYMENT_AMOUNT, 
                          TRXA_PAYM_OUTS AS BALANCE,
                          TRXA_PAYM_MODE
                        FROM trxadrug 
                        WHERE TRXA_DRUG_CODE='$outsalecode' AND TRXA_VIEW_STAT='Y'";

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


        echo $data_jurnal;    
   }
}
?>