<?php
// Set timezone to match your location
date_default_timezone_set('Asia/Jakarta');

// Get queue number from URL
$nomor = $_GET['nomor'] ?? 'A-000';
$pasien = $_GET['pasien'] ?? '';
$layanan = $_GET['layanan'] ?? '';
$prefix = substr($nomor, 0, 1);

// Current date and time
$tanggal = date('d-m-Y');
$waktu = date('H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Antrian <?= htmlspecialchars($nomor) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 58mm;
        }
        .ticket {
            width: 100%;
            padding: 2mm;
            text-align: center;
        }
        .header {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 2mm;
        }
        .service {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 3mm;
        }
        .number {
            font-size: 24pt;
            font-weight: bold;
            margin: 3mm 0;
            line-height: 1;
        }
        .pasien {
            font-size: 10pt;
            margin: 3mm 0;
            line-height: 1.2;
            font-weight: bold;
        }
        .info {
            font-size: 10pt;
            margin: 3mm 0;
            line-height: 1.2;
        }
        .footer {
            font-size: 8pt;
            margin-top: 3mm;
            line-height: 1.2;
        }
        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }
            body {
                width: 58mm;
                margin: 0;
                padding: 1mm;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">KLINIK YEMIMA MEDIKA</div>
        <div class="service"><?= htmlspecialchars($layanan) ?></div>
        <div class="number"><?= htmlspecialchars($nomor) ?></div>
        <div class="pasien"><?= htmlspecialchars($pasien) ?></div>
        <div class="info">
            <div>Tanggal: <?= htmlspecialchars($tanggal) ?></div>
            <div>Waktu: <?= htmlspecialchars($waktu) ?></div>
        </div>
        <div class="footer">
            Terima kasih atas kunjungan Anda<br>
            Silahkan menunggu antrian dipanggil
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(window.close, 100);
            }, 100);
        };
    </script>
</body>
</html>