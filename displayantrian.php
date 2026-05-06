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

    <link rel="stylesheet" type="text/css" href="assets/css/displayantriandef.css">
</head>

<body>
    <!-- ====== OVERLAY UNLOCK SUARA (WAJIB 1x KLIK) ====== -->
    <div id="unlock-overlay">
        <div id="unlock-box">
            <div class="unlock-title">Aktifkan Suara Panggilan</div>
            <div class="unlock-desc">
                Klik tombol di bawah untuk mengaktifkan suara panggilan (ding + TTS).<br>
                Browser biasanya memblokir audio sebelum ada interaksi.
            </div>

            <button id="btn-unlock-audio" class="unlock-btn" type="button">
                🔊 AKTIFKAN SUARA
            </button>

            <div class="unlock-note" id="unlock-note">Status: menunggu klik…</div>

            <div class="unlock-mini">
                <label class="unlock-toggle">
                    <input type="checkbox" id="unlock-test-tts" checked>
                    <span>Test suara TTS (“Suara panggilan aktif”)</span>
                </label>
                <label class="unlock-toggle">
                    <input type="checkbox" id="unlock-test-ding" checked>
                    <span>Test ding (tingting)</span>
                </label>
            </div>
        </div>
    </div>

    <!-- indikator kecil (opsional) -->
    <!-- <div class="audio-badge" id="audio-badge" title="Suara panggilan">
        <i class="fa-solid fa-volume-high"></i>
    </div> -->

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

            <div class="header-right">
                <!-- <div class="summary-chip fade-in" id="chip-total">
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
                </div> -->

                <div class="sound-indicator" id="sound-indicator" title="Suara Panggilan">
                    <i class="fa-solid fa-volume-high"></i>
                </div>
            </div>
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

                <div class="video-wrapper">
                    <video id="info-video" class="info-video" playsinline muted autoplay
                        controlslist="nodownload noplaybackrate">
                        Maaf, browser Anda tidak mendukung video.
                    </video>
                </div>

                <div class="footer-mini fade-in">
                    <span>
                        <div class="footer-pill">📅</div>
                        <span id="footer-date">-</span>
                    </span>
                    <span>•</span>
                    <span>
                        <div class="footer-pill">⏱</div>
                        <span id="footer-time">-</span>
                    </span>
                </div>

            </section>
        </main>

        <footer class="footer fade-in">
            <div class="marquee">
                <div class="marquee-track" id="marquee-track">
                    <div class="marquee-content" id="marquee-content">
                        <SPAN>*</SPAN>
                        <span>Selamat datang di KLINiK PRATAMA RAWAT JALAN YEMIMA MEDIKA</span>
                        <SPAN>*</SPAN>
                        <span>Melayani Pemeriksaan Dokter Umum - Dokter Gigi - Kebidanan - Laboratorium - Farmasi</span>
                        <SPAN>*</SPAN>
                        <span>Mohon menunggu hingga nomor antrean Anda dipanggil melalui layar dan suara
                            panggilan</span>
                        <SPAN>*</SPAN>
                        <span>Gunakan masker, jaga jarak, dan patuhi protokol kesehatan demi kenyamanan bersama</span>
                        <SPAN>*</SPAN>
                        <span>Untuk informasi layanan dan promo kesehatan, ikuti Instagram kami di
                            @klinikyemimamedika</span>
                        <SPAN>*</SPAN>
                        <span>Informasi & pendaftaran: Telp / WhatsApp 0811-8385-108 - Telepon 021-77814916</span>
                        <SPAN>*</SPAN>
                        <span>Terima kasih atas kepercayaan Anda kepada KPRJ Yemima Medika</span>
                    </div>
                    <!-- duplikat otomatis lewat JS (atau kamu bisa copy manual) -->
                </div>
            </div>
        </footer>

    </div>

    <!-- ResponsiveVoice (logic lama) -->
    <!-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=m2sKd8bb"></script> -->

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

        document.addEventListener('DOMContentLoaded', () => {
            const content = document.getElementById('marquee-content');
            const track = document.getElementById('marquee-track');
            if (content && track) {
                // duplikasi 1x untuk loop mulus
                track.appendChild(content.cloneNode(true));
            }
        });

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

                })
                .catch(err => console.error('Stat error:', err));
        }

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

        // ================= LOGGER =================
        function logCall(stage, payload = {}) {
            const t = new Date().toLocaleTimeString();
            console.log(`[SALE ${t}] ${stage}`, payload);
        }

        // ================= TTS INIT =================
        let ttsVoice = null;

        function initTTS() {
            if (!('speechSynthesis' in window)) {
                logCall('TTS NOT SUPPORTED');
                return;
            }

            const pickVoice = () => {
                const voices = speechSynthesis.getVoices() || [];
                ttsVoice =
                    voices.find(v => /id-ID/i.test(v.lang)) ||
                    voices.find(v => /indones/i.test(v.name)) ||
                    voices.find(v => /id/i.test(v.lang)) ||
                    null;

                logCall('VOICE READY', {
                    voice: ttsVoice ? `${ttsVoice.name} (${ttsVoice.lang})` : 'DEFAULT'
                });
            };

            pickVoice();
            speechSynthesis.onvoiceschanged = pickVoice;
        }
        initTTS();

        // ================= DING (SATU KALI SAJA) =================
        const dingAudio = new Audio('audio/tingting.mp3'); // path sesuai folder kamu
        dingAudio.preload = 'auto';

        // ===== fallback beep (kalau mp3 gagal / diblok) =====
        let audioCtx = null;
        function beepFallback(ms = 220, freq = 880, volume = 0.12) {
            try {
                const Ctx = window.AudioContext || window.webkitAudioContext;
                if (!Ctx) return Promise.resolve(false);

                if (!audioCtx) audioCtx = new Ctx();
                if (audioCtx.state === 'suspended') {
                    return audioCtx.resume().then(() => beepFallback(ms, freq, volume));
                }

                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'sine';
                osc.frequency.value = freq;
                gain.gain.value = volume;

                osc.connect(gain);
                gain.connect(audioCtx.destination);

                osc.start();
                setTimeout(() => {
                    osc.stop();
                    osc.disconnect();
                    gain.disconnect();
                }, ms);

                return Promise.resolve(true);
            } catch {
                return Promise.resolve(false);
            }
        }

        // ================= DING DONG (FADE OUT) =================
        function playDingFade(duration = 3.0, fadeTime = 1.0) {
            return new Promise((resolve) => {
                dingAudio.pause();
                dingAudio.currentTime = 0;
                dingAudio.volume = 1;

                dingAudio.play().then(() => {
                    const fadeStart = Math.max(duration - fadeTime, 0);

                    setTimeout(() => {
                        const steps = 10;
                        let step = 0;
                        const interval = (fadeTime * 1000) / steps;

                        const fade = setInterval(() => {
                            step++;
                            dingAudio.volume = Math.max(1 - step / steps, 0);

                            if (step >= steps) {
                                clearInterval(fade);
                                dingAudio.pause();
                                dingAudio.currentTime = 0;
                                dingAudio.volume = 1;
                                resolve();
                            }
                        }, interval);
                    }, fadeStart * 1000);
                }).catch(async () => {
                    // kalau autoplay blocked, fallback beep pendek
                    await beepFallback(220, 880, 0.12);
                    resolve();
                });
            });
        }

        // ================= UNLOCK AUDIO (ANTI AUTOPLAY BLOCK) =================
        let audioUnlocked = false;

        function setUnlockNote(msg) {
            const el = document.getElementById('unlock-note');
            if (el) el.textContent = msg;
        }

        function showUnlockOverlay() {
            const overlay = document.getElementById('unlock-overlay');
            if (overlay) overlay.style.display = 'flex';
        }

        function hideUnlockOverlay() {
            const overlay = document.getElementById('unlock-overlay');
            if (overlay) overlay.style.display = 'none';
        }

        function setBadge(on) {
            const badge = document.getElementById('audio-badge');
            if (!badge) return;
            badge.classList.toggle('on', !!on);
        }

        function pingBadge() {
            const badge = document.getElementById('audio-badge');
            if (!badge) return;
            badge.classList.add('ping');
            setTimeout(() => badge.classList.remove('ping'), 800);
        }

        function testSpeakOnce(text = "Suara panggilan aktif.") {
            return new Promise((resolve) => {
                if (!('speechSynthesis' in window)) return resolve(false);

                try { speechSynthesis.cancel(); } catch { }

                const u = new SpeechSynthesisUtterance(text);
                u.lang = ttsVoice?.lang || 'id-ID';
                if (ttsVoice) u.voice = ttsVoice;

                u.rate = 1.0;
                u.pitch = 1.0;
                u.volume = 1.0;

                let done = false;
                const finish = (ok) => {
                    if (done) return;
                    done = true;
                    resolve(ok);
                };

                u.onend = () => finish(true);
                u.onerror = () => finish(false);

                try {
                    speechSynthesis.speak(u);
                    setTimeout(() => finish(false), 2500);
                } catch {
                    finish(false);
                }
            });
        }

        async function tryPlayDingQuick() {
            try {
                dingAudio.pause();
                dingAudio.currentTime = 0;
                dingAudio.volume = 1;
                await dingAudio.play();
                setTimeout(() => {
                    dingAudio.pause();
                    dingAudio.currentTime = 0;
                }, 350);
                return true;
            } catch {
                return await beepFallback(220, 880, 0.12);
            }
        }

        async function unlockAudioOnce() {
            if (audioUnlocked) return true;

            const btn = document.getElementById('btn-unlock-audio');
            const optTTS = document.getElementById('unlock-test-tts');
            const optDing = document.getElementById('unlock-test-ding');

            if (btn) btn.disabled = true;

            // resume AudioContext biar beep bisa bunyi
            try {
                const Ctx = window.AudioContext || window.webkitAudioContext;
                if (Ctx) {
                    if (!audioCtx) audioCtx = new Ctx();
                    if (audioCtx.state === 'suspended') await audioCtx.resume();
                }
            } catch { }

            let dingOk = true;
            let ttsOk = true;

            if (!optDing || optDing.checked) {
                setUnlockNote("Status: test bunyi ding...");
                dingOk = await tryPlayDingQuick();
            }

            if (!optTTS || optTTS.checked) {
                setUnlockNote("Status: test TTS...");
                ttsOk = await testSpeakOnce("Suara panggilan aktif.");
            }

            if (dingOk || ttsOk) {
                audioUnlocked = true;
                setUnlockNote("Status: suara aktif ✅");
                setBadge(true);
                pingBadge();
                hideUnlockOverlay();

                // kalau ada panggilan numpuk, jalanin lagi
                setTimeout(() => {
                    try { processQueue(); } catch { }
                }, 150);

                return true;
            }

            audioUnlocked = false;
            setBadge(false);
            setUnlockNote("Status: gagal. Coba klik lagi atau cek output audio Windows.");
            if (btn) btn.disabled = false;
            return false;
        }

        document.addEventListener('DOMContentLoaded', () => {
            // tampilkan overlay dari awal
            showUnlockOverlay();
            setBadge(false);

            const btn = document.getElementById('btn-unlock-audio');
            if (btn) btn.addEventListener('click', unlockAudioOnce);

            const badge = document.getElementById('audio-badge');
            if (badge) badge.addEventListener('click', showUnlockOverlay);
        });

        // ================= QUEUE SUARA =================
        const callQueue = [];
        let isProcessingQueue = false;

        function enqueueCall(text, meta = {}) {
            callQueue.push({ text, meta });
            logCall('ENQUEUE', { ...meta, queue_len: callQueue.length });
            processQueue();
        }

        async function processQueue() {
            if (isProcessingQueue) return;
            if (callQueue.length === 0) return;

            if (!audioUnlocked) return;

            isProcessingQueue = true;

            const item = callQueue.shift();
            const text = item.text;
            const meta = item.meta || {};

            logCall('START ITEM', { ...meta, remaining_queue: callQueue.length });

            // 🔔 Ding dong dulu 
            await playDingFade(3.0, 2.0);

            // 🔊 TTS
            const u = new SpeechSynthesisUtterance(text);
            u.lang = ttsVoice?.lang || 'id-ID';
            if (ttsVoice) u.voice = ttsVoice;

            u.pitch = 1;
            u.rate = 0.95;
            u.volume = 1;

            u.onstart = () => logCall('TTS START', meta);
            u.onend = () => {
                logCall('TTS END', meta);
                isProcessingQueue = false;
                processQueue();
            };
            u.onerror = (e) => {
                logCall('TTS ERROR', { ...meta, error: e?.error || e });

                // kalau error, anggap audio perlu unlock ulang
                audioUnlocked = false;
                setBadge(false);
                showUnlockOverlay();
                setUnlockNote("Status: suara bermasalah. Klik AKTIFKAN SUARA lagi.");

                isProcessingQueue = false;
                processQueue();
            };

            speechSynthesis.speak(u);
        }

        // Optional: bersihin antrian suara (buat debug/emergency)
        function clearVoiceQueue() {
            logCall('CLEAR QUEUE', { queue_len_before: callQueue.length });
            callQueue.length = 0;
            speechSynthesis.cancel();
            dingAudio.pause();
            dingAudio.currentTime = 0;
            dingAudio.volume = 1;
            isProcessingQueue = false;
        }

        // ================== FETCH SALE (LOKET FARMASI) ==================
        function fetchSaleCall() {
            fetch('get_last_call.php?channel=SALE')
                .then(r => r.json())
                .then(data => {
                    if (!data || !data.id) return;
                    if (data.id == lastSaleId) return;

                    lastSaleId = data.id;

                    const nomor = data.queue_no;
                    const namaRaw = data.patient_name || 'Pasien';

                    // ini fungsi lu yang udah ada sebelumnya
                    const nama = normalizeNameForTTS ? normalizeNameForTTS(namaRaw) : namaRaw;

                    // UI
                    document.getElementById('loket-obat-name').innerText = namaRaw;

                    // highlight kartu loket
                    if (typeof highlightCard === 'function') highlightCard('card-obat');

                    // teks panggilan
                    const text = "Atas nama " + nama + ", silakan menuju loket Farmasi.";

                    // LOG
                    logCall('NEW CALL', { id: data.id, nomor, nama: namaRaw, channel: 'SALE', text_preview: text });

                    // QUEUE SUARA
                    enqueueCall(text, { id: data.id, nomor, nama: namaRaw, channel: 'SALE' });

                    // indikator (kalau ada)
                    if (typeof pingSoundIndicator === 'function') pingSoundIndicator();
                })
                .catch(err => logCall('FETCH ERROR', { error: err?.message || err }));
        }

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
            setInterval(fetchStats, 2000);

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