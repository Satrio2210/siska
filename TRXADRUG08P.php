<?php
session_start();

include "conf/config.php";
include "inc/sanie.php";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Report_Resep_Harian.xls");
header("Pragma: no-cache");
header("Expires: 0");

$startdate = $_POST['tglstartdate'];
$enddate = $_POST['tglenddate'];
$jenis = $_POST['jenispasien'];

$where_jenis = "";

if ($jenis == "B") {
    $where_jenis = " AND trxaregi.TRXA_REGI_PAYM = 'B' ";
} elseif ($jenis == "U") {
    $where_jenis = " AND trxaregi.TRXA_REGI_PAYM = 'U' ";
}

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

            trxaprsc.TRXA_ENTR_DATE,
            trxaprsc.TRXA_ENTR_TIME,

            trxaprsc.TRXA_STOCK_PRIC

        FROM trxaprsc

        JOIN trxaregi
            ON trxaprsc.TRXA_PRSC_CODE = trxaregi.TRXA_REGI_CODE

        JOIN patimast
            ON trxaregi.TRXA_PATI_CODE = patimast.PATI_MAST_CODE

        JOIN passiden
            ON trxaprsc.TRXA_PRSC_DOCT = passiden.PASS_USER_IDEN

        JOIN invemast
            ON trxaprsc.TRXA_STOCK_CODE = invemast.INVE_MAST_CODE

        JOIN tblispec
            ON invemast.INVE_MAIN_SPEC = tblispec.TBLI_SPEC_CODE

        JOIN tbliunit
            ON invemast.INVE_SALE_UNIT = tbliunit.TBLI_UNIT_CODE

        WHERE
            trxaprsc.TRXA_PRSC_STAT IN ('A','I')
            AND trxaprsc.TRXA_VIEW_STAT = 'Y'
            $where_jenis
            AND trxaprsc.TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'

        ORDER BY
            trxaprsc.TRXA_ENTR_DATE ASC,
            trxaprsc.TRXA_ENTR_TIME ASC,
            trxaprsc.TRXA_PRSC_CODE ASC";

$q = $db->query($xquery) or die("Gagal Export Excel");

echo "
<table border='1'>
<tr>
    <th colspan='7'>
        REPORT RESEP HARIAN<br>
        $startdate s/d $enddate
    </th>
</tr>

<tr>
    <th>Tanggal</th>
    <th>Nama Pasien</th>
    <th>Obat</th>
    <th>Jumlah</th>
    <th>Harga Jual</th>
    <th>Sub Total</th>
    <th>Farmasi</th>
</tr>
";

$grandtotal = 0;

while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
    $qtyy = $k['TRXA_STOCK_QUTY'];

    $bulat = round($k['TRXA_STOCK_PRIC']);
    $xint = (int) $bulat;

    $price_ritel = pembulatan($xint);

    $subtotal = $price_ritel * $qtyy;

    $grandtotal += $subtotal;

    echo "<tr>";

    echo "<td>" . $k['TRXA_ENTR_DATE'] . "</td>";

    echo "<td>" . $k['TITLE'] . " " . $k['PATI_NAME'] . "</td>";

    echo "<td>" . $k['STOCK_NAME'] . " " . $k['SPEC_NAME'] . "</td>";

    echo "<td>" . $qtyy . " " . $k['NAME_UNIT'] . "</td>";

    echo "<td>" . number_format($price_ritel, 0, ',', '.') . "</td>";

    echo "<td>" . number_format($subtotal, 0, ',', '.') . "</td>";

    echo "<td>" . $k['DOCT_NAME'] . "</td>";

    echo "</tr>";
}

echo "
<tr>
    <td colspan='5' align='right'><b>TOTAL</b></td>
    <td><b>" . number_format($grandtotal, 0, ',', '.') . "</b></td>
    <td></td>
</tr>
";

echo "</table>";
?>