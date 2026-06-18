<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$fulldate = $_GET['q'];
list($startdate, $enddate) = explode("|", $fulldate);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=REPORT_PEMAKAIAN_OBAT_" . $startdate . "_SD_" . $enddate . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Pemakaian Obat</title>
</head>

<body>

    <h2>REPORT PEMAKAIAN OBAT</h2>

    <table>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td><?php echo $startdate; ?> s/d <?php echo $enddate; ?></td>
        </tr>
    </table>

    <br>

    <table border="1">
        <thead>
            <tr style="font-weight:bold;">
                <th>No</th>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Qty Keluar</th>
            </tr>
        </thead>

        <tbody>

            <?php

            $no = 0;
            $totalqty = 0;

            $query = "
SELECT
    p.TRXA_STOCK_CODE,
    m.INVE_PART_NAME,
    SUM(p.TRXA_STOCK_QUTY) AS TOTAL_PAKAI
FROM trxaprsc p
LEFT JOIN invemast m
    ON p.TRXA_STOCK_CODE = m.INVE_MAST_CODE
WHERE p.TRXA_VIEW_STAT = 'Y'
AND p.TRXA_ENTR_DATE BETWEEN '$startdate' AND '$enddate'
GROUP BY
    p.TRXA_STOCK_CODE,
    m.INVE_PART_NAME
ORDER BY TOTAL_PAKAI DESC
";

            $q = $db->query($query) or die("Gagal Ambil Data Pemakaian Obat");

            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $no++;

                $qty = (int) $r['TOTAL_PAKAI'];

                $totalqty += $qty;

                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $r['TRXA_STOCK_CODE'] . "</td>";
                echo "<td>" . $r['INVE_PART_NAME'] . "</td>";
                echo "<td>" . $qty . "</td>";
                echo "</tr>";
            }

            ?>

            <tr style="font-weight:bold;">
                <td colspan="3" align="right">
                    TOTAL PEMAKAIAN
                </td>
                <td>
                    <?php echo $totalqty; ?>
                </td>
            </tr>

            <tr style="font-weight:bold;">
                <td colspan="3" align="right">
                    TOTAL JENIS OBAT
                </td>
                <td>
                    <?php echo $no; ?>
                </td>
            </tr>

        </tbody>
    </table>

    <br><br>

    Dicetak oleh SISKA pada :
    <?php echo date('d-m-Y H:i:s'); ?>

</body>

</html>