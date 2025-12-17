<?php
// ====== BAGIAN PHP (API AJAX) ======
include "conf/config.php"; // ganti sesuai file koneksi lu

// Kalau request AJAX untuk statistik
if (isset($_GET['ajax']) && $_GET['ajax'] === 'stats') {
    header('Content-Type: application/json');

    $today = date('Y-m-d');

    // Mapping poli
    $poliMap = [
        'PU' => 'Poli Umum',
        'PG' => 'Poli Gigi',
        'KB' => 'Poli KIA',
    ];

    $dataPoli = [];

    foreach ($poliMap as $kode => $nama) {
        // Total antrian hari ini di trxaregi
        $sqlTotal = "SELECT COUNT(*) AS jml
                     FROM trxaregi
                     WHERE TRXA_REGI_DATE = :tgl
                       AND TRXA_REGI_POLI = :poli";
        $stTotal = $db->prepare($sqlTotal);
        $stTotal->execute([
            ':tgl' => $today,
            ':poli' => $kode
        ]);
        $rowTotal = $stTotal->fetch(PDO::FETCH_ASSOC);
        $total = (int) ($rowTotal['jml'] ?? 0);

        // Sudah dipanggil (channel POLI)
        $sqlCall = "SELECT COUNT(*) AS jml
                    FROM queue_calls
                    WHERE channel = 'POLI'
                      AND poli_name = :poli_name
                      AND DATE(created_at) = :tgl";
        $stCall = $db->prepare($sqlCall);
        $stCall->execute([
            ':poli_name' => $nama,
            ':tgl' => $today
        ]);
        $rowCall = $stCall->fetch(PDO::FETCH_ASSOC);
        $dipanggil = (int) ($rowCall['jml'] ?? 0);

        $sisa = max($total - $dipanggil, 0);

        // Nomor terakhir yang dipanggil untuk poli ini
        $sqlLast = "SELECT queue_no, patient_name
                    FROM queue_calls
                    WHERE channel = 'POLI'
                      AND poli_name = :poli_name
                      AND DATE(created_at) = :tgl
                    ORDER BY id DESC
                    LIMIT 1";
        $stLast = $db->prepare($sqlLast);
        $stLast->execute([
            ':poli_name' => $nama,
            ':tgl' => $today
        ]);
        $rowLast = $stLast->fetch(PDO::FETCH_ASSOC);
        $lastNo = $rowLast['queue_no'] ?? '-';

        $dataPoli[$kode] = [
            'kode' => $kode,
            'nama' => $nama,
            'total' => $total,
            'dipanggil' => $dipanggil,
            'sisa' => $sisa,
            'last_no' => $lastNo,
            'last_name' => $rowLast['patient_name'] ?? '-',
        ];
    }

    echo json_encode([
        'ok' => true,
        'poli' => $dataPoli,
    ]);
    exit;
}

// ====== BAGIAN HTML (LAYAR DISPLAY) DIBAWAH INI ======
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Display Antrian - KPRJ Yemima Medika</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font & Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #edf2f7;
            --bg-card: #ffffff;
            --border-soft: #e2e8f0;
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --accent: #22c55e;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --shadow-soft: 0 10px 24px rgba(15, 23, 42, 0.08);
            --radius-lg: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", system-ui, sans-serif;
        }

        body {
            background: radial-gradient(circle at top, #e0f2fe 0, #f9fafb 40%, #e2e8f0 100%);
            color: var(--text-main);
            height: 100vh;
            overflow: hidden;
        }

        .screen {
            width: 100%;
            height: 100vh;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ========== HEADER ========== */
        .header {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 18px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 2px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-img {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            object-fit: cover;
            border: 3px solid rgba(14, 165, 233, 0.4);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
            background: #e5f2ff;
        }

        .logo-fallback {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 32px;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
        }

        .clinic-meta h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .clinic-meta .subtitle {
            font-size: 16px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .header-right {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .summary-chip {
            min-width: 170px;
            padding: 10px 14px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f9fafb, #e0f2fe);
            border: 1px solid rgba(148, 163, 184, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .summary-chip.updated {
            transform: translateY(-4px);
            box-shadow: 0 14px 32px rgba(14, 165, 233, 0.4);
        }

        .summary-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .summary-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .sound-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 2px solid #22c55e;
            color: #16a34a;
            margin-left: 10px;
            background: #ecfdf3;
            position: relative;
            overflow: visible;
        }

        .sound-indicator.ping::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            border: 2px solid rgba(34, 197, 94, 0.7);
            animation: ping 0.7s ease-out;
        }

        @keyframes ping {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.9);
                opacity: 0;
            }
        }

        /* ========== MAIN AREA ========== */
        .main {
            flex: 1;
            display: grid;
            grid-template-columns: 42% 58%;
            gap: 16px;
        }

        .left-column {
            display: grid;
            grid-template-rows: 70% 30%;
            gap: 16px;
        }

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 18px 18px 16px;
            border: 2px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
        }

        .poli-utama-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .poli-utama-title {
            font-size: 26px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.13em;
        }

        .tag-poli {
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 12px;
            background: #ecfdf3;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .current-number {
            margin-top: 6px;
            flex: 1;
            border-radius: 18px;
            background: radial-gradient(circle at top left, #e0f2fe 0, #bfdbfe 45%, #93c5fd 75%);
            border: 2px solid #bfdbfe;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(59, 130, 246, 0.35);
        }

        .current-number::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 0 0, rgba(255, 255, 255, 0.7), transparent 60%);
            opacity: 1;
        }

        .current-label {
            position: absolute;
            top: 16px;
            left: 22px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #1d4ed8;
        }

        .current-code {
            position: relative;
            font-size: 96px;
            font-weight: 900;
            letter-spacing: 0.14em;
            color: #1e3a8a;
            text-shadow: 0 6px 14px rgba(15, 23, 42, 0.3);
            transition: transform 0.3s ease, opacity 0.3s ease;
            margin-bottom: 40px;
        }

        .current-code.pop {
            animation: popNumber 0.55s ease-out;
        }

        @keyframes popNumber {
            0% {
                transform: scale(0.6);
                opacity: 0;
            }

            55% {
                transform: scale(1.15);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .current-extra {
            position: absolute;
            bottom: 14px;
            right: 18px;
            font-size: 14px;
            display: flex;
            gap: 14px;
            color: #1e3a8a;
            font-weight: 600;
        }

        .current-extra span {
            background: rgba(255, 255, 255, 0.7);
            padding: 4px 8px;
            border-radius: 999px;
        }

        .current-next {
            position: absolute;
            left: 22px;
            bottom: 14px;
            font-size: 14px;
            color: #0f172a;
            background: rgba(255, 255, 255, 0.8);
            padding: 4px 10px;
            border-radius: 999px;
            max-width: 60%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .current-patient {
            position: absolute;
            top: 58%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            background: rgba(255, 255, 255, 0.85);
            padding: 6px 18px;
            border-radius: 12px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* SUB POLI */
        .sub-poli {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .sub-poli-card {
            background: var(--bg-card);
            border-radius: 18px;
            padding: 12px 12px 10px;
            border: 2px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
        }

        .sub-poli-card.highlight {
            transform: translateY(-4px);
            border-color: rgba(14, 165, 233, 0.9);
            box-shadow: 0 16px 36px rgba(14, 165, 233, 0.45);
        }

        .sub-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.13em;
            color: black;
        }

        .sub-code {
            font-size: 15px;
            font-weight: 800;
            margin-top: 6px;
            color: var(--text-main);
        }

        .sub-queue-info {
            margin-top: 4px;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* VIDEO + RUNNING TEXT */
        .video-panel {
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 8px;
        }

        .video-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-inline: 4px;
        }

        .video-header-title {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--text-main);
        }

        .video-tag {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .video-wrapper {
            border-radius: var(--radius-lg);
            background: radial-gradient(circle at top, #e0f2fe 0, #eff6ff 45%, #dbeafe 100%);
            border: 2px solid #bfdbfe;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .video-placeholder {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .video-placeholder h2 {
            font-size: 30px;
            color: #1d4ed8;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .video-placeholder span {
            font-size: 14px;
            color: var(--text-muted);
        }

        .running-text-container {
            margin-top: 4px;
            border-radius: 999px;
            background: #0f172a;
            border: 1px solid #0ea5e9;
            overflow: hidden;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.4);
        }

        .running-text-inner {
            white-space: nowrap;
            display: inline-block;
            padding: 6px 0;
            animation: ticker 35s linear infinite;
            font-size: 15px;
            color: #e5f9ff;
        }

        .running-text-inner span {
            margin: 0 40px;
        }

        @keyframes ticker {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* FOOTER */
        .footer {
            background: var(--bg-card);
            border-radius: 18px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            border: 2px solid var(--border-soft);
            box-shadow: var(--shadow-soft);
            font-size: 20px;
            color: var(--text-main);
        }

        .footer span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .footer-pill {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            border: 2px solid var(--primary-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--primary-dark);
            background: #e0f2fe;
        }

        /* Fade-in awal */
        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 1050px) {
            .clinic-meta h1 {
                font-size: 24px;
            }

            .clinic-meta .subtitle {
                font-size: 13px;
            }

            .current-code {
                font-size: 64px;
            }

            .sub-code {
                font-size: 30px;
            }

            .video-placeholder h2 {
                font-size: 22px;
            }
        }

        .info-video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* atau "contain" kalau mau full terlihat */
            border-radius: 18px;
        }
    </style>
</head>

<body>
    <div class="screen">

        <!-- HEADER -->
        <header class="header fade-in">
            <div class="header-left">
                <div class="logo-wrapper">
                    <!-- Kalau nanti ada logo, aktifkan img ini dan hapus div fallback -->
                    <img src="img/logo.png" alt="Logo KPRJ Yemima Medika" class="logo-img">
                    <!-- <div class="logo-fallback">Y</div> -->
                </div>
                <div class="clinic-meta">
                    <h1>KPRJ YEMIMA MEDIKA</h1>
                    <div class="subtitle">Antrean Poli Umum • Poli KIA • Poli Gigi</div>
                </div>
            </div>

            <!-- <div class="header-right">
                <div class="summary-chip fade-in" id="chip-total">
                    <div class="summary-label">Total Antrian</div>
                    <div class="summary-value" id="summary-total">0</div>
                </div>
                <div class="summary-chip fade-in" id="chip-now">
                    <div class="summary-label">Sedang Dipanggil</div>
                    <div class="summary-value" id="summary-now">0</div>
                </div>
                <div class="summary-chip fade-in" id="chip-left">
                    <div class="summary-label">Sisa</div>
                    <div class="summary-value" id="summary-left">0</div>
                </div>

                <div class="sound-indicator" id="sound-indicator" title="Suara Panggilan">
                    <i class="fa-solid fa-volume-high"></i>
                </div>
            </div> -->
        </header>

        <!-- MAIN -->
        <main class="main">
            <!-- KIRI -->
            <section class="left-column">
                <!-- POLI UMUM -->
                <section class="card fade-in">
                    <div class="poli-utama-header">
                        <div class="poli-utama-title">POLI UMUM</div>
                        <div class="tag-poli">Nomor Urut</div>
                    </div>

                    <div class="current-number">
                        <div class="current-label">Sedang Dipanggil</div>

                        <div class="current-code" id="poli-umum-code">A000</div>
                        <!-- <div class="current-code" id="call-number">A000</div> -->
                        <!-- <div id="call-name">-</div> -->
                        <div class="current-patient" id="patient-name-PU"></div>

                        <div class="current-next">
                            <span>SELANJUTNYA: <strong id="poli-umum-next">A000</strong></span>
                        </div>

                        <div class="current-extra">
                            <span>MENUNGGU: <strong id="poli-umum-remaining">00</strong></span>
                        </div>


                    </div>
                </section>

                <!-- POLI KIA / GIGI / LOKET -->
                <section class="sub-poli">
                    <div class="sub-poli-card fade-in" id="card-kia">
                        <div class="sub-title">Poli KIA</div>
                        <div class="sub-code" id="poli-kia-code">-</div>
                        <div class="sub-queue-info">
                            Sisa: <span id="poli-kia-remaining">0</span>
                        </div>
                    </div>

                    <div class="sub-poli-card fade-in" id="card-gigi">
                        <div class="sub-title">Poli Gigi</div>
                        <div class="sub-code" id="poli-gigi-code">-</div>
                        <div class="sub-queue-info">
                            Sisa: <span id="poli-gigi-remaining">0</span>
                        </div>
                    </div>

                    <div class="sub-poli-card fade-in" id="card-obat">
                        <div class="sub-title">Loket Obat</div>
                        <div class="sub-code" id="loket-obat-name">-</div>
                        <div class="sub-queue-info">
                            Menunggu: <span id="loket-obat-wait">0</span>
                        </div>
                    </div>
                </section>
            </section>

            <!-- KANAN -->
            <section class="video-panel fade-in">
                <div class="video-header">
                    <div class="video-header-title">Informasi & Edukasi Pasien</div>
                    <div class="video-tag">-</div>
                </div>

                <!-- <div class="video-wrapper">
                                    <div class="video-placeholder">
                        <h2>AREA VIDEO</h2>
                        <span>Pasang video edukasi / promosi layanan klinik di sini.</span>
                    </div>
                </div> -->

                <div class="video-wrapper">
                    <video id="info-video" class="info-video" playsinline muted autoplay
                        controlslist="nodownload noplaybackrate">
                        Maaf, browser Anda tidak mendukung video.
                    </video>
                </div>

                <div class="running-text-container">
                    <div class="running-text-inner" id="running-text">
                        <span>Selamat datang di KPRJ Yemima Medika.</span>
                        <span>Silakan tunggu nomor antrean Anda dipanggil.</span>
                        <span>Gunakan masker dan tetap jaga jarak.</span>
                        <span>Terima kasih atas kepercayaan Anda kepada kami.</span>
                    </div>
                </div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer class="footer fade-in">
            <span>
                <div class="footer-pill">📅</div>
                <span id="footer-date">-</span>
            </span>
            <span>•</span>
            <span>
                <div class="footer-pill">⏱</div>
                <span id="footer-time">-</span>
            </span>
        </footer>
    </div>

    <!-- ResponsiveVoice (logic lama) -->
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=m2sKd8bb"></script>

    <script>
        let lastPoliCalls = { PU: null, PG: null, KB: null };
        let lastSaleId = 0;

        const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        function updateClock() {
            const now = new Date();
            const h = now.getHours().toString().padStart(2, "0");
            const m = now.getMinutes().toString().padStart(2, "0");
            const s = now.getSeconds().toString().padStart(2, "0");
            document.getElementById("footer-time").textContent = `${h}:${m}:${s}`;

            const d = hari[now.getDay()];
            const tgl = now.getDate();
            const bln = bulan[now.getMonth()];
            const yr = now.getFullYear();
            document.getElementById("footer-date").textContent =
                `${d}, ${tgl} ${bln} ${yr}`;
        }

        function animateNumber(element, newValue) {
            if (!element) return;
            if (element.textContent === newValue) return;
            element.classList.remove("pop");
            void element.offsetWidth;
            element.textContent = newValue;
            element.classList.add("pop");
        }

        function pulseChip(chipId) {
            const chip = document.getElementById(chipId);
            if (!chip) return;
            chip.classList.add("updated");
            setTimeout(() => chip.classList.remove("updated"), 800);
        }

        function pingSoundIndicator() {
            const indicator = document.getElementById("sound-indicator");
            if (!indicator) return;
            indicator.classList.add("ping");
            setTimeout(() => indicator.classList.remove("ping"), 800);
        }

        function highlightCard(cardId) {
            document.querySelectorAll(".sub-poli-card").forEach(c => c.classList.remove("highlight"));
            const el = document.getElementById(cardId);
            if (el) {
                el.classList.add("highlight");
                setTimeout(() => el.classList.remove("highlight"), 1200);
            }
        }

        function computeNextNumber(no) {
            if (!no || no === "-") return "-";
            const match = String(no).match(/^([A-Za-z]?)(\d+)$/);
            if (!match) return "-";
            const prefix = match[1] || "";
            const digits = match[2];
            const next = (parseInt(digits, 10) + 1).toString().padStart(digits.length, "0");
            return prefix + next;
        }

        // ====== LOGIC: STATS POLI (PAKAI endpoint lama ?ajax=stats) ======
        function fetchStats() {
            fetch('displayantrian.php?ajax=stats')
                .then(r => r.json())
                .then(data => {
                    if (!data || !data.ok) return;
                    const poli = data.poli || {};

                    let totalAll = 0;
                    let dipAll = 0;
                    let sisaAll = 0;

                    ['PU', 'PG', 'KB'].forEach(k => {
                        const d = poli[k];
                        if (!d) return;

                        const total = parseInt(d.total || 0, 10);
                        const dip = parseInt(d.dipanggil || 0, 10);
                        const sisa = parseInt(d.sisa || 0, 10);

                        totalAll += total;
                        dipAll += dip;
                        sisaAll += sisa;

                        if (k === 'PU') {
                            const lastNo = d.last_no || '-';
                            const lastName = d.last_name || '-';

                            const nameEl = document.getElementById('patient-name-PU');
                            if (nameEl) {
                                nameEl.textContent = lastName;
                            }

                            if (lastNo && lastNo !== '-' && lastPoliCalls.PU !== lastNo) {
                                lastPoliCalls.PU = lastNo;

                                animateNumber(
                                    document.getElementById('poli-umum-code'),
                                    lastNo
                                );

                                const next = computeNextNumber(lastNo);
                                document.getElementById('poli-umum-next').textContent = next;
                                document.getElementById('poli-umum-remaining').textContent = sisa;

                                // Suara panggilan Poli Umum (logic lama)
                                // const text = `Poli Umum nomor ${lastNo}, silakan masuk ke ruang pemeriksaan.`;
                                // if (window.responsiveVoice && responsiveVoice.voiceSupport()) {
                                //     responsiveVoice.cancel();
                                //     responsiveVoice.speak(text, "Indonesian Female", {
                                //         pitch: 1,
                                //         rate: 0.9,
                                //         volume: 1
                                //     });
                                // }

                                pingSoundIndicator();
                            } else {
                                // tetap update sisa kalau angka sama
                                document.getElementById('poli-umum-remaining').textContent = sisa;
                                const next = computeNextNumber(lastNo);
                                document.getElementById('poli-umum-next').textContent = next;

                                const nameEl2 = document.getElementById('patient-name-PU');
                                if (nameEl2) {
                                    nameEl2.textContent = lastName;
                                }

                            }
                        }

                        if (k === 'KB') {
                            document.getElementById('poli-kia-code').textContent = d.last_no || '-';
                            document.getElementById('poli-kia-remaining').textContent = sisa;
                        }

                        if (k === 'PG') {
                            document.getElementById('poli-gigi-code').textContent = d.last_no || '-';
                            document.getElementById('poli-gigi-remaining').textContent = sisa;
                        }
                    });

                    // Update summary header
                    const oldTotal = parseInt(document.getElementById('summary-total').textContent || 0, 10);
                    const oldDip = parseInt(document.getElementById('summary-now').textContent || 0, 10);
                    const oldSisa = parseInt(document.getElementById('summary-left').textContent || 0, 10);

                    if (oldTotal !== totalAll) {
                        document.getElementById('summary-total').textContent = totalAll;
                        pulseChip('chip-total');
                    }
                    if (oldDip !== dipAll) {
                        document.getElementById('summary-now').textContent = dipAll;
                        pulseChip('chip-now');
                    }
                    if (oldSisa !== sisaAll) {
                        document.getElementById('summary-left').textContent = sisaAll;
                        pulseChip('chip-left');
                    }
                })
                .catch(err => console.error('Stat error:', err));
        }

        // function convertTitle(nama) {
        //     let map = {
        //         "Tn.": "Tuan",
        //         "Ny.": "Nyonya",
        //         "Nn.": "Nona",
        //         "An.": "Anak"
        //     };

        //     let prefix = nama.substring(0, 3); // contoh: "Tn."

        //     if (map[prefix]) {
        //         return map[prefix] + " " + nama.substring(3);
        //     }

        //     return nama;
        // }
        
        // === FUNGSI NORMALISASI NAMA (ANTI DIEJA) ===
        function normalizeNameForTTS(fullname) {
            if (!fullname) return "";
    
            let name = fullname.trim();
    
            // 1. Ubah titel
            name = name
                .replace(/^An\.\s*/i, "Anak ")
                .replace(/^Tn\.\s*/i, "Tuan ")
                .replace(/^Ny\.\s*/i, "Nyonya ")
                .replace(/^Nn\.\s*/i, "Nona ");
    
            // 2. Hilangkan tanda baca biang spelling
            name = name.replace(/[.,;:]/g, " ");
    
            // 3. Huruf kapital semua → Title Case
            name = name.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    
            // 4. Rapihin spasi
            name = name.replace(/\s+/g, " ").trim();
    
            return name;
        }
        // === END NORMALISASI ===
        
        // ====== LOGIC: LOKET OBAT (ENDPOINT lama get_last_call.php?channel=SALE) ======
        function fetchSaleCall() {
            fetch('get_last_call.php?channel=SALE')
                .then(r => r.json())
                .then(data => {
                    if (!data || !data.id) return;
                    if (data.id == lastSaleId) return;

                    lastSaleId = data.id;

                    const nomor = data.queue_no;
                    const namaRaw = data.patient_name || 'Pasien';

                    // const convertedName = convertTitle(nama);
                    // const numberEl = document.getElementById('loket-obat-code');
                    // animateNumber(numberEl, nomor);
                    const nama = normalizeNameForTTS(namaRaw);

                    document.getElementById('loket-obat-name').innerText = nama;

                    // highlight kartu loket
                    highlightCard('card-obat');

                    // suara seperti logic lama
                    const text = "Atas nama " + nama + ", silakan menuju loket Farmasi.";
                    if (window.responsiveVoice && responsiveVoice.voiceSupport()) {
                        responsiveVoice.cancel();
                        responsiveVoice.speak(text, "Indonesian Female", {
                            pitch: 1,
                            rate: 0.95,
                            volume: 1
                        });
                    }

                    pingSoundIndicator();
                })
                .catch(err => console.error('Sale error:', err));
        }

        // function fetchFarmCall() {
        //     fetch('get_last_call.php?channel=FARM')
        //         .then(r => r.json())
        //         .then(data => {
        //             if (!data || !data.id) return;
        //             if (data.id == lastSaleId) return;

        //             lastSaleId = data.id;

        //             const nomor = data.queue_no;
        //             const nama = data.patient_name || 'Pasien';

        //             const convertedName = convertTitle(nama);
        //             // const numberEl = document.getElementById('loket-obat-code');
        //             // animateNumber(numberEl, nomor);

        //             document.getElementById('loket-obat-name').innerText = nama;

        //             // highlight kartu loket
        //             highlightCard('card-obat');

        //             // suara seperti logic lama
        //             const text = "Atas nama " + convertedName + ", silakan menuju loket Farmasi.";
        //             if (window.responsiveVoice && responsiveVoice.voiceSupport()) {
        //                 responsiveVoice.cancel();
        //                 responsiveVoice.speak(text, "Indonesian Female", {
        //                     pitch: 1,
        //                     rate: 0.95,
        //                     volume: 1
        //                 });
        //             }

        //             pingSoundIndicator();
        //         })
        //         .catch(err => console.error('Sale error:', err));
        // }


        // ====== LOGIC: NAMA PASIEN SEDANG DILAYANI (ENDPOINT lama get_current_patient.php) ======
        // function fetchCurrentPatient() {
        //     fetch('get_last_call.php?.php?channel=POLI')
        //         .then(r => r.json())
        //         .then(data => {
        //             if (data && data.name) {
        //                 document.getElementById('patient-name-PU').textContent = data.name;
        //             }
        //         })
        //         .catch(err => console.error('Patient error:', err));
        // }


        document.addEventListener('DOMContentLoaded', () => {
            updateClock();
            setInterval(updateClock, 1000);

            // animasi fade in awal
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('show');
                }, index * 120);
            });

            fetchStats();
            setInterval(fetchStats, 3000);

            fetchSaleCall();
            setInterval(fetchSaleCall, 2000);

            const videoEl = document.getElementById("info-video");
            if (videoEl && videoPlaylist.length > 0) {
                loadAndPlayVideo(0);

                videoEl.addEventListener("ended", () => {
                    // kalau habis 1 video, lanjut ke berikutnya
                    let nextIndex = currentVideoIndex + 1;
                    if (nextIndex >= videoPlaylist.length) {
                        nextIndex = 0;
                    }
                    loadAndPlayVideo(nextIndex);
                });
            }

            // fetchCurrentPatient();
            // setInterval(fetchCurrentPatient, 5000);

            // Auto refresh tiap 60 menit (biar aman)
            setInterval(() => {
                location.reload();
            }, 3600000);
        });

        // ====== PLAYLIST VIDEO ======
        const videoPlaylist = [
            "video1.mp4",
            "video3.mp4",
            "video4.mp4",
            "video5.mp4",
            "video6.mp4",
            "bpjs1.mp4",
            "bpjs2.mp4",
            "bpjs3.mp4",
            // tambah lagi kalau ada, mis: "video4.mp4"
        ];

        let currentVideoIndex = 0;

        function loadAndPlayVideo(index) {
            const videoEl = document.getElementById("info-video");
            if (!videoEl || videoPlaylist.length === 0) return;

            // pastikan index valid
            if (index < 0 || index >= videoPlaylist.length) {
                index = 0;
            }
            currentVideoIndex = index;

            videoEl.src = "assets/videos/" + videoPlaylist[currentVideoIndex];
            videoEl.load();
            videoEl.play().catch(() => {
                // kalau autoplay di-block browser, ya udah diem aja
            });
        }

    </script>
</body>

</html>