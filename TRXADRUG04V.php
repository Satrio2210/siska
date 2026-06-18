<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$fulldate = $_POST['q'];
list($startdate, $enddate) = explode("|", $fulldate);
?>

<table class="pure-table pure-table-horizontal" style="width:100%;">
<thead>
<tr>
    <th style="width:50px;text-align:center;">No</th>
    <th style="width:80px;text-align:center;">Kode</th>
    <th>Nama Obat</th>
    <th style="width:120px;text-align:right;">Qty Keluar</th>
</tr>
</thead>
<tbody>

<?php

$no = 0;
$totalqty = 0;

$query1 = "SELECT
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

$q1 = $db->query($query1) or die("Gagal Ambil Data Pemakaian Obat");

while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{
    $no++;

    $qty = (int)$k1['TOTAL_PAKAI'];
    $totalqty += $qty;

    if($no <= 10)
    {
        echo '<tr style="background:#fff8dc;">';
    }
    else
    {
        echo '<tr>';
    }

    echo '<td style="text-align:center;">'.$no.'</td>';

    echo '<td style="text-align:center;">'
         .$k1['TRXA_STOCK_CODE'].
         '</td>';

    echo '<td>'
         .$k1['INVE_PART_NAME'].
         '</td>';

    echo '<td style="text-align:right;">'
         .number_format($qty,0,'','.')
         .'</td>';

    echo '</tr>';
}
?>

<tr style="background:#e8e8e8;font-weight:bold;">
    <td colspan="3" style="text-align:right;">
        TOTAL PEMAKAIAN
    </td>

    <td style="text-align:right;">
        <?php echo number_format($totalqty,0,'','.'); ?>
    </td>
</tr>

</tbody>
</table>

<div style="padding:15px 0;">
    <b>Total Jenis Obat :</b>
    <?php echo $no; ?>
</div>

<div style="padding:20px 0;">
<center>
&copy; SISKA Development
</center>
</div>