<?php

error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$prsccode = $_GET['prsccode'];
// $prsccode = '08062026-00013';

if ($prsccode == '') {
    die("Kode resep kosong");
}

/*
HEADER PASIEN
*/
$sqlhead = "SELECT
r.TRXA_REGI_CODE,
r.TRXA_REGI_LIST,
r.TRXA_REGI_DATE,
pm.PATI_MAIN_TITL,
pm.PATI_MAIN_NAME,
pm.PATI_MAST_CODE
FROM trxaregi r
LEFT JOIN patimast pm
ON pm.PATI_MAST_CODE=r.TRXA_PATI_CODE
WHERE r.TRXA_REGI_CODE='$prsccode'
LIMIT 1
";

$qhead = $db->query($sqlhead);
$head = $qhead->fetch(PDO::FETCH_ASSOC);

/*
DETAIL OBAT NON RACIKAN
*/
$sqldetail = "SELECT
p.TRXA_STOCK_CODE,
p.TRXA_STOCK_QUTY,
p.TRXA_PRSC_SGNA,

i.INVE_PART_NAME,
s.TBLI_SPEC_NAME,
u.TBLI_UNIT_NAME,

sg.TBLP_SGNA_NAME,
sg.TBLP_SGNA_USAG

FROM trxaprsc p

LEFT JOIN invemast i
ON i.INVE_MAST_CODE=p.TRXA_STOCK_CODE

LEFT JOIN tblispec s
ON s.TBLI_SPEC_CODE=i.INVE_MAIN_SPEC

LEFT JOIN tbliunit u
ON u.TBLI_UNIT_CODE=i.INVE_SALE_UNIT

LEFT JOIN tblpsgna sg
ON sg.TBLP_SGNA_CODE=p.TRXA_PRSC_SGNA

WHERE
p.TRXA_PRSC_CODE='$prsccode'
AND p.TRXA_PRSC_CONC='N'
AND p.TRXA_VIEW_STAT='Y'

ORDER BY i.INVE_PART_NAME
";

$qdetail = $db->query($sqldetail);

/*
DETAIL RACIKAN HEADERS
*/
$sqlracik = "SELECT * FROM trxaracik_head WHERE TRXAR_CODE='$prsccode' AND TRXAR_VIEW_STAT='Y' ORDER BY TRXAR_ID";
$qracik = $db->query($sqlracik);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>E-Tiket Obat</title>

    <style>
        /* Reset dasar */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
        }

        /* Set ukuran container pas 50x40mm */
        .etiket {
            width: 48mm;
            margin: 0;
            height: 40mm;
            box-sizing: border-box;
            padding: 2mm;
            /* Padding dikecilin biar lega */
            overflow: hidden;
            page-break-after: always;
            border-bottom: 1px dashed #000;
            position: relative;
        }

        .header {
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            margin-bottom: 3px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }

        .judul {
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            margin-bottom: 3px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }

        .info {
            font-size: 7px;
            line-height: 1.2;
            margin-top: 1px;
        }

        .namapasien {
            font-weight: bold;
            font-size: 9px;
            line-height: 1.2;
            text-transform: uppercase;
            text-align: center;
            margin-top: 5px;
        }

        /* Buat bikin sebaris */
        .flex-row {
            display: flex;
            justify-content: space-between;
        }

        .garis {
            margin: 3px 0;
            border: 0;
            border-top: 1px dashed #000;
        }


        .namaobat {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            line-height: 1.1;
            white-space: normal;
            word-wrap: break-word;
        }


        .jumlah {
            font-size: 10px;
            line-height: 1.2;
            margin-top: 1px;
            text-align: center;
        }

        .signa {
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            border-radius: 3px;
            padding: 2px;
            line-height: 1.1;
        }

        .signa small {
            font: 9px;
            font-size: 8px;
            font-weight: normal;
            display: block;
            margin-top: 2px;
            color: #272727;
        }

        .footer {
            font-size: 8px;
            line-height: 1.2;
            margin-top: 1px;
            text-align: center;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Setingan kertas biar printer ngebaca 50x40mm pas print */
        @media print {
            body {
                margin: 0;
            }

            .etiket {
                border: none;
                /* Hilangkan garis bantu kalau di-print */
            }

            /* @page {
                size: 50mm 40mm;
                margin: 0;
            } */
        }
    </style>

</head>

<body onload="window.print();">

    <?php
    // 1. Loop etiket Obat Non-Racikan
    while ($row = $qdetail->fetch(PDO::FETCH_ASSOC)) {
        ?>

        <div class="etiket">

            <div class="header">INSTALASI FARMASI KPRJ YEMIMA MEDIKA</div>

            <div class="flex-row info">
                <!-- <span>No: <?php echo $head['TRXA_REGI_LIST']; ?></span> -->
                <span>RM: <?php echo $head['PATI_MAST_CODE']; ?></span>
                <span>Tgl: <?php echo $head['TRXA_REGI_DATE']; ?></span>
            </div>

            <div class="namapasien">
                <?php echo $head['PATI_MAIN_TITL'] . ' ' . $head['PATI_MAIN_NAME']; ?>
            </div>

            <hr class="garis">

            <div class="namaobat">
                <!-- <?php echo $row['INVE_PART_NAME'] . ' ' . $row['TBLI_SPEC_NAME']; ?> -->
                <?php echo $row['INVE_PART_NAME']; ?>
            </div>

            <!-- <div class="jumlah">
                Jumlah: <?php echo $row['TRXA_STOCK_QUTY'] . ' ' . $row['TBLI_UNIT_NAME']; ?>
            </div> -->

            <div class="signa">
                ATURAN PAKAI:<br>
                <?php echo $row['TBLP_SGNA_NAME']; ?><br>
                <small><?php echo $row['TBLP_SGNA_USAG']; ?></small>
            </div>

            <!-- <div class="footer">
                SEMOGA LEKAS SEMBUH
            </div> -->

        </div>

        <?php
    }

    // 2. Loop etiket Resep Racikan
    while ($racik = $qracik->fetch(PDO::FETCH_ASSOC)) {
        ?>

        <div class="etiket">

            <div class="header">INSTALASI FARMASI KPRJ YEMIMA MEDIKA</div>

            <div class="flex-row info">
                <span>RM: <?php echo $head['PATI_MAST_CODE']; ?></span>
                <span>Tgl: <?php echo $head['TRXA_REGI_DATE']; ?></span>
            </div>

            <div class="namapasien">
                <?php echo $head['PATI_MAIN_TITL'] . ' ' . $head['PATI_MAIN_NAME']; ?>
            </div>

            <hr class="garis">

            <div class="namaobat">
                <?php echo $racik['TRXAR_NAMA']; ?> (<?php echo $racik['TRXAR_QTY']; ?> Pcs)
            </div>

            <div class="signa">
                ATURAN PAKAI:<br>
                <?php echo $racik['TRXAR_SGNA']; ?><br>
                <small><?php echo $racik['TRXAR_USAG']; ?></small>
            </div>

        </div>

        <?php
    }
    ?>

</body>

</html>
