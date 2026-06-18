<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$fulldate = $_POST['q'];
$jenis = $_POST['jenis'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|", $fulldate);
?>
<table class="pure-table pure-table-horizontal">
    <thead>
        <tr>
            <th style="width: 150px">Tanggal</th>
            <th style="width: 200px">Nama</th>
            <th style="width: 150px">Obat</th>
            <th style="width: 100px">Jumlah</th>
            <th style="width: 100px">Harga Jual</th>
            <th style="width: 100px">Sub Total</th>
            <th style="width: 200px">Farmasi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $where_jenis = "";

        if ($jenis == "B") {
            $where_jenis = " AND trxaregi.TRXA_REGI_PAYM = 'B' ";
        } elseif ($jenis == "U") {
            $where_jenis = " AND trxaregi.TRXA_REGI_PAYM = 'U' ";
        }

        $no = 0;
        if ($startdate == $enddate) {
            $xquery = "SELECT 
            TRXA_PRSC_CODE,
            trxaregi.TRXA_PATI_CODE AS PATI_CODE,
            CASE 
                WHEN patimast.PATI_MAIN_TITL = 'Tn.' THEN 'Tuan'
                WHEN patimast.PATI_MAIN_TITL = 'Ny.' THEN 'Nyonya'
                WHEN patimast.PATI_MAIN_TITL = 'Nn.' THEN 'Nona'
                WHEN patimast.PATI_MAIN_TITL = 'An.' THEN 'Anak'
            END AS TITLE,
            patimast.PATI_MAIN_NAME AS PATI_NAME,
            trxaprsc.TRXA_PRSC_DOCT AS DOCT_CODE,
            passiden.PASS_USER_NAME AS DOCT_NAME,
            trxaprsc.TRXA_STOCK_CODE,
            invemast.INVE_PART_NAME AS STOCK_NAME,
            invemast.INVE_MAIN_SPEC AS SPEC_CODE,
            tblispec.TBLI_SPEC_NAME AS SPEC_NAME,
            trxaprsc.TRXA_STOCK_QUTY,
            invemast.INVE_SALE_UNIT AS CODE_UNIT,
            tbliunit.TBLI_UNIT_NAME AS NAME_UNIT,
            IFNULL(trxaprsc.TRXA_STOCK_BTCH, 'Belum diisi') AS BTCH_CODE,
            CASE 
                WHEN trxaprsc.TRXA_PRSC_CONC = 'Y' THEN 'Racikan'
                WHEN trxaprsc.TRXA_PRSC_CONC = 'N' THEN 'Bukan Racikan'
            END AS PRSC_CONC,
            trxaprsc.TRXA_PRSC_STAT,
            trxaprsc.TRXA_ENTR_DATE,
            trxaprsc.TRXA_ENTR_TIME,
            trxaprsc.TRXA_STOCK_PRIC
        FROM 
            trxaprsc
        JOIN 
            trxaregi ON trxaprsc.TRXA_PRSC_CODE = trxaregi.TRXA_REGI_CODE
        JOIN 
            patimast ON trxaregi.TRXA_PATI_CODE = patimast.PATI_MAST_CODE
        JOIN 
            passiden ON trxaprsc.TRXA_PRSC_DOCT = passiden.PASS_USER_IDEN
        JOIN 
            invemast ON trxaprsc.TRXA_STOCK_CODE = invemast.INVE_MAST_CODE
        JOIN 
            tblispec ON invemast.INVE_MAIN_SPEC = tblispec.TBLI_SPEC_CODE
        JOIN 
            tbliunit ON invemast.INVE_SALE_UNIT = tbliunit.TBLI_UNIT_CODE
        WHERE 
            trxaprsc.TRXA_PRSC_STAT IN ('A', 'I') 
            AND trxaprsc.TRXA_VIEW_STAT = 'Y'
            $where_jenis 
            AND trxaprsc.TRXA_ENTR_DATE = '$startdate'
    
        ORDER BY
            trxaprsc.TRXA_ENTR_DATE ASC,
            trxaprsc.TRXA_ENTR_TIME ASC,
            trxaprsc.TRXA_PRSC_CODE ASC";

        } else {
            $xquery = "SELECT 
            TRXA_PRSC_CODE,
            trxaregi.TRXA_PATI_CODE AS PATI_CODE,
            CASE 
                WHEN patimast.PATI_MAIN_TITL = 'Tn.' THEN 'Tuan'
                WHEN patimast.PATI_MAIN_TITL = 'Ny.' THEN 'Nyonya'
                WHEN patimast.PATI_MAIN_TITL = 'Nn.' THEN 'Nona'
                WHEN patimast.PATI_MAIN_TITL = 'An.' THEN 'Anak'
            END AS TITLE,
            patimast.PATI_MAIN_NAME AS PATI_NAME,
            trxaprsc.TRXA_PRSC_DOCT AS DOCT_CODE,
            passiden.PASS_USER_NAME AS DOCT_NAME,
            trxaprsc.TRXA_STOCK_CODE,
            invemast.INVE_PART_NAME AS STOCK_NAME,
            invemast.INVE_MAIN_SPEC AS SPEC_CODE,
            tblispec.TBLI_SPEC_NAME AS SPEC_NAME,
            trxaprsc.TRXA_STOCK_QUTY,
            invemast.INVE_SALE_UNIT AS CODE_UNIT,
            tbliunit.TBLI_UNIT_NAME AS NAME_UNIT,
            IFNULL(trxaprsc.TRXA_STOCK_BTCH, 'Belum diisi') AS BTCH_CODE,
            CASE 
                WHEN trxaprsc.TRXA_PRSC_CONC = 'Y' THEN 'Racikan'
                WHEN trxaprsc.TRXA_PRSC_CONC = 'N' THEN 'Bukan Racikan'
            END AS PRSC_CONC,
            trxaprsc.TRXA_PRSC_STAT,
            trxaprsc.TRXA_ENTR_DATE,
            trxaprsc.TRXA_ENTR_TIME,
            trxaprsc.TRXA_STOCK_PRIC
        FROM 
            trxaprsc
        JOIN 
            trxaregi ON trxaprsc.TRXA_PRSC_CODE = trxaregi.TRXA_REGI_CODE
        JOIN 
            patimast ON trxaregi.TRXA_PATI_CODE = patimast.PATI_MAST_CODE
        JOIN 
            passiden ON trxaprsc.TRXA_PRSC_DOCT = passiden.PASS_USER_IDEN
        JOIN 
            invemast ON trxaprsc.TRXA_STOCK_CODE = invemast.INVE_MAST_CODE
        JOIN 
            tblispec ON invemast.INVE_MAIN_SPEC = tblispec.TBLI_SPEC_CODE
        JOIN 
            tbliunit ON invemast.INVE_SALE_UNIT = tbliunit.TBLI_UNIT_CODE
        WHERE 
            trxaprsc.TRXA_PRSC_STAT IN ('A', 'I') 
            AND trxaprsc.TRXA_VIEW_STAT = 'Y'
            $where_jenis 
            AND trxaprsc.TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'
    
        ORDER BY
            trxaprsc.TRXA_ENTR_DATE ASC,
            trxaprsc.TRXA_ENTR_TIME ASC,
            trxaprsc.TRXA_PRSC_CODE ASC";

        }

        $q = $db->query($xquery) or die("Gagal Maning!!");

        $grandtotal = 0;

        while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
            echo '';

            $tanggall = $k['TRXA_ENTR_DATE'];
            $qtyy = $k['TRXA_STOCK_QUTY'];

            $bulat = round($k['TRXA_STOCK_PRIC']);
            $xint = (int) $bulat;

            $price_ritel = pembulatan($xint);

            $tott = $price_ritel * $qtyy;

            $grandtotal += $tott;

            $view_price_ritel = number_format($tott, 0, ',', '.');
            $view_price = number_format($price_ritel, 0, ',', '.');

            echo '<td style="width: 150px">' . $tanggall . '</td>';
            echo '<td style="width: 200px; text-align: left;">' . $k['TITLE'] . ' ' . $k['PATI_NAME'] . '</td>';
            echo '<td style="width: 150px; text-align: left;">' . $k['STOCK_NAME'] . ' ' . $k['SPEC_NAME'] . '</td>';
            echo '<td style="width: 100px; text-align: left;">' . $k['TRXA_STOCK_QUTY'] . ' ' . $k['NAME_UNIT'] . '</td>';
            echo '<td style="width: 100px; text-align: left;">' . $view_price . '</td>';
            echo '<td style="width: 100px; text-align: left;">' . $view_price_ritel . '</td>';
            echo '<td style="width: 200px; text-align: left;">' . $k['DOCT_NAME'] . '</td>';

            echo '</tr>';

        }
        ?>

        <td style="text-align:right;">
             <b>Total - Rp. <?php echo number_format($grandtotal, 0, ',', '.'); ?></b>
        </td>

        <td></td>

        <?php
        ?>
    </tbody>
</table>