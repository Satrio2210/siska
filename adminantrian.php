<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Antrian Poli</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #f5f5f5;
        }

        #call-number {
            font-size: 90px;
            font-weight: bold;
            margin-top: 30px;
        }

        #call-name {
            font-size: 32px;
            margin-top: 10px;
        }

        #call-poli {
            font-size: 28px;
            margin-top: 5px;
            color: #555;
        }
    </style>
</head>

<body>
    <h1>ANTRIAN POLI</h1>

    <div id="call-number">-</div>
    <div id="call-name">-</div>
    <div id="call-poli">-</div>
    <br><br><br><br>
    <button onclick="clearVoiceQueue()" style="position:fixed;bottom:10px;right:10px;z-index:9999">
        CLEAR SUARA
    </button>

    <!-- //<script src="https://code.responsivevoice.org/responsivevoice.js?key=m2sKd8bb"></script> -->
    <script>
        let lastCallId = 0;

        // // === FUNGSI BARU UNTUK MENGUBAH PREFIX ===
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
        // // === END FUNGSI BARU ===

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

        // function checkLastCall() {
        //     fetch('get_last_call.php?channel=POLI')
        //         .then(r => r.json())
        //         .then(data => {
        //             if (!data || !data.id) return;
        //             if (data.id == lastCallId) return;

        //             lastCallId = data.id;

        //             const nomor = data.queue_no;
        //             const namaRaw = data.patient_name;
        //             const poli = data.poli_name;

        //             const nama = normalizeNameForTTS(namaRaw);

        //             document.getElementById('call-number').innerText = nomor;
        //             document.getElementById('call-name').innerText = namaRaw;
        //             document.getElementById('call-poli').innerText = poli;

        //             const text = "Nomor antrian " + nomor +
        //                 ", atas nama " + nama +
        //                 ", silakan menuju " + poli + ".";

        //             if (window.responsiveVoice && responsiveVoice.voiceSupport()) {
        //                 responsiveVoice.cancel();
        //                 responsiveVoice.speak(text, "Indonesian Female", {
        //                     pitch: 1,
        //                     rate: 0.95,
        //                     volume: 1
        //                 });
        //             }
        //         })
        //         .catch(err => console.error(err));
        // }

        // setInterval(checkLastCall, 2000);

        // ================= LOGGER =================
        function logCall(stage, payload = {}) {
            const t = new Date().toLocaleTimeString();
            console.log(`[CALL ${t}] ${stage}`, payload);
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

        // ================= DING DONG (FADE OUT) =================
        const dingAudio = new Audio('audio/tingting.mp3');
        dingAudio.preload = 'auto';

        function playDingFade(duration = 0.8, fadeTime = 0.25) {
            return new Promise((resolve) => {
                dingAudio.pause();
                dingAudio.currentTime = 0;
                dingAudio.volume = 1;

                logCall('DING PLAY');

                dingAudio.play().catch(() => {
                    logCall('DING AUTOPLAY BLOCKED');
                    resolve();
                });

                const fadeStart = Math.max(duration - fadeTime, 0);

                setTimeout(() => {
                    const steps = 10;
                    let step = 0;
                    const interval = fadeTime * 1000 / steps;

                    const fade = setInterval(() => {
                        step++;
                        dingAudio.volume = Math.max(1 - step / steps, 0);

                        if (step >= steps) {
                            clearInterval(fade);
                            dingAudio.pause();
                            dingAudio.currentTime = 0;
                            dingAudio.volume = 1;

                            logCall('DING END (FADE)');
                            resolve();
                        }
                    }, interval);
                }, fadeStart * 1000);
            });
        }

        // ================= QUEUE SUARA =================
        const callQueue = [];
        let isProcessingQueue = false;

        function enqueueCall(text, meta) {
            callQueue.push({ text, meta });
            logCall('ENQUEUE', { ...meta, queue_len: callQueue.length });
            processQueue();
        }

        async function processQueue() {
            if (isProcessingQueue) return;
            if (callQueue.length === 0) return;

            isProcessingQueue = true;

            const item = callQueue.shift();
            const text = item.text;
            const meta = item.meta || {};

            logCall('START ITEM', meta);

            // 🔔 Ding dong fade
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
                isProcessingQueue = false;
                processQueue();
            };

            speechSynthesis.speak(u);
        }

        // ================= EMERGENCY CLEAR =================
        function clearVoiceQueue() {
            logCall('CLEAR QUEUE', { queue_len_before: callQueue.length });
            callQueue.length = 0;
            speechSynthesis.cancel();
            dingAudio.pause();
            dingAudio.currentTime = 0;
            dingAudio.volume = 1;
            isProcessingQueue = false;
        }

        // ================= FETCH LAST CALL =================
        function checkLastCall() {
            fetch('get_last_call.php?channel=POLI')
                .then(r => r.json())
                .then(data => {
                    if (!data || !data.id) return;
                    if (data.id == lastCallId) return;

                    lastCallId = data.id;

                    const nomor = data.queue_no;
                    const namaRaw = data.patient_name;
                    const poli = data.poli_name;
                    const nama = normalizeNameForTTS(namaRaw);

                    document.getElementById('call-number').innerText = nomor;
                    document.getElementById('call-name').innerText = namaRaw;
                    document.getElementById('call-poli').innerText = poli;

                    const text =
                        "Nomor antrian " + nomor +
                        ", atas nama " + nama +
                        ", silakan menuju " + poli + ".";

                    logCall('NEW CALL', { id: data.id, nomor, nama: namaRaw, poli });

                    enqueueCall(text, { id: data.id, nomor, nama: namaRaw, poli });
                })
                .catch(err => logCall('FETCH ERROR', { error: err?.message || err }));
        }

        setInterval(checkLastCall, 2000);
    </script>
</body>

</html>