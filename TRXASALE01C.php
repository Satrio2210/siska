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
        $rawdata = $_POST['q'];
        //$rawdata = '14102021-00002|1077-00001';
        list($regicode, $paticode) = explode("|",$rawdata);

        $view = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_PAYM, TRXA_REGI_DOCT, TRXA_REGI_POLI 
                FROM trxaregi
                WHERE TRXA_REGI_CODE = '$regicode' AND TRXA_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Admisi!!");
        $rview = $qview->fetch(PDO::FETCH_ASSOC);  
        
        $regicode = "$rview[TRXA_REGI_CODE]";
        $paticode = "$rview[TRXA_PATI_CODE]";
        $regidoct = "$rview[TRXA_REGI_DOCT]";
        $regipoli = "$rview[TRXA_REGI_POLI]";
        $regipaym = "$rview[TRXA_REGI_PAYM]";

        // Hitung nilai Tindakan
        $query_tret = "SELECT SUM(TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS TOTA_TRET 
                        FROM trxatret 
                        WHERE TRXA_TRET_CODE = '$regicode'
                        AND TRXA_TRET_STAT = 'I'
                        AND TRXA_VIEW_STAT = 'Y'";

        $qtret = $db->query($query_tret) or die("Gagal Ambil data Tindakan");
        $rtret = $qtret->fetch(PDO::FETCH_ASSOC);

        $total_tret = "$rtret[TOTA_TRET]";

        // Hitung nilai BHP
        $query_csbl = "SELECT SUM((TRXA_STOCK_PRIC * $profit) * TRXA_STOCK_QUTY) AS TOTA_CSBL 
                       FROM trxacsbl 
                       WHERE TRXA_CSBL_CODE = '$regicode'
                       AND TRXA_CSBL_STAT = 'I'
                       AND TRXA_VIEW_STAT = 'Y'";

        $qcsbl = $db->query($query_csbl) or die("Gagal Ambil data BHP");
        $rcsbl = $qcsbl->fetch(PDO::FETCH_ASSOC);

        $total_csbl = "$rcsbl[TOTA_CSBL]";
        //$total_csbl = $xtotal_csbl * $profit;
        
        //test_hitung nilai Obat
        $query_prsc = "SELECT SUM((TRXA_STOCK_PRIC * $profit) * TRXA_STOCK_QUTY) AS TOTA_PRSC,
                      (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE
                       FROM trxaprsc 
                       WHERE TRXA_PRSC_CODE = '$regicode'
                       AND TRXA_PRSC_STAT = 'I'
                       AND TRXA_VIEW_STAT = 'Y'";

        $qprsc = $db->query($query_prsc) or die("Gagal Ambil data Resep");
        $rprsc = $qprsc->fetch(PDO::FETCH_ASSOC);
        
        // Ambil nilai TOTA_PRSC dan PAYM_TYPE
        $total_prsc = $rprsc['TOTA_PRSC'];
        $paym_type = $rprsc['PAYM_TYPE'];
        
        // Pengkondisian jika PAYM_TYPE = 'B', set total_prsc menjadi 0
        if ($paym_type === 'B') {
            $total_prsc = 0;
        }
        
        // Format hasil jika perlu
        $view_total_prsc = number_format($total_prsc, 0, '', '.');
        
        echo "Total Harga Resep: " . $view_total_prsc;


        // // Hitung nilai Obat
        // $query_prsc = "SELECT SUM((TRXA_STOCK_PRIC * $profit) * TRXA_STOCK_QUTY) AS TOTA_PRSC
        //               (SELECT TRXA_REGI_PAYM FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_PRSC_CODE) AS PAYM_TYPE
        //               FROM trxaprsc WHERE TRXA_PRSC_CODE = '$regicode'
        //               AND TRXA_PRSC_STAT = 'I'
        //               AND TRXA_VIEW_STAT = 'Y'";

        // $qprsc = $db->query($query_prsc) or die("Gagal Ambil data Resep");
        // $rprsc = $qprsc->fetch(PDO::FETCH_ASSOC);
        
        // $total_prsc = "$rprsc[TOTA_PRSC]";
        //$total_prsc = $xtotal_prsc * $profit;xx

        // Ambil nilai yang sudah di bayarkan jika ada
        $query_outs = "SELECT SUM(TRXA_PAYM_AMNT) AS TOTA_PAYM 
                       FROM trxasale WHERE TRXA_REGI_CODE = '$regicode'
                       AND TRXA_VIEW_STAT = 'Y'";
                       
        $qouts = $db->query($query_outs) or die("Gagal Ambil data Pembayaran terakhir");
        $routs = $qouts->fetch(PDO::FETCH_ASSOC);

        $total_outs = "$routs[TOTA_PAYM]";

        // Ambil Biaya Admin dan Resep Obat
        // Periksa apakah ada obat racikan
        $periksaracikan = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode' 
                     AND TRXA_PRSC_CONC='Y'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";
        $periksaracikan_di_query=$db->query($periksaracikan) or die ("Cek Fail");
        $ketersediaan_racikan = $periksaracikan_di_query->fetchColumn();

        if ($ketersediaan_racikan == 0)
        {
            // Periksa apakah ada resep yang diberikan
            $periksaresep = "SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE='$regicode'
                     AND TRXA_PRSC_STAT='I'
                     AND TRXA_VIEW_STAT='Y'";
            $periksaresep_di_query=$db->query($periksaresep) or die ("Cek Fail");
            $ketersediaan_resep = $periksaresep_di_query->fetchColumn();

            if ($ketersediaan_resep == 0)
            {
                // periksa di data register apakah di kenakan biaya admin
                $periksabiayaadmin = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$regicode' AND TRXA_REGI_FEE='Y'";
                $periksabiayaadmin_di_query=$db->query($periksabiayaadmin) or die ("Cek Fail");
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


        $subtotal1 = ($total_tret + $total_csbl);
        $subtotal2 = ($total_prsc + $subtotal1);
        $subtotal3 = ($subtotal2 + $total_admin); 

        $xpaymtota = ($subtotal3 - $total_outs);

        $xharga = round($xpaymtota);
        $int = (int)$xharga;

        $paymtota = pembulatan($int);    

        $viewpaymtota = number_format($paymtota, 0, '', '.');

        echo "|$regicode|$paticode|$regidoct|$regipoli|$regipaym|$paymtota|$viewpaymtota|";    
        
   }
}
?>