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

        #unlock-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
        }

        #unlock-box {
            background: #fff;
            padding: 22px 24px;
            border-radius: 14px;
            width: min(420px, 92vw);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
            text-align: center;
        }

        #unlock-box h2 {
            margin: 0 0 8px;
            font-size: 20px
        }

        #unlock-box p {
            margin: 0 0 14px;
            color: #444;
            font-size: 14px;
            line-height: 1.4
        }

        #unlock-btn {
            font-size: 16px;
            font-weight: 700;
            padding: 12px 16px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
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

    <!-- <button onclick="testDing()" style="position:fixed;bottom:60px;right:10px;z-index:9999">
        TEST DING BOOST
    </button>

    <button onclick="testDing2()" style="position:fixed;bottom:120px;right:20px;z-index:9999">
        TEST DING BOOST2
    </button> -->

    <div id="unlock-overlay">
        <div id="unlock-box">
            <h2>Aktifkan Suara</h2>
            <p>Klik 1x untuk mengaktifkan bunyi panggilan antrian (ding dong + suara).</p>
            <button id="unlock-btn">AKTIFKAN SUARA</button>
        </div>
    </div>

    <!-- //<script src="https://code.responsivevoice.org/responsivevoice.js?key=m2sKd8bb"></script> -->
    <script>
        let lastCallId = 0;

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

        // ================= UNLOCK AUDIO (WAJIB 1x KLIK) =================
        let audioUnlocked = false;

        async function unlockAudioOnce() {
            if (audioUnlocked) return true;

            logCall('UNLOCK: START');

            try {
                await audioCtx.resume();
                logCall('AUDIOCTX RESUME', { state: audioCtx.state });
            } catch (e) {
                logCall('AUDIOCTX RESUME FAIL', { error: e?.message || e });
            }

            // 1) Unlock HTMLAudioElement (dingAudio)
            try {
                dingAudio.pause();
                dingAudio.currentTime = 0;
                dingAudio.volume = 0; // silent unlock
                await dingAudio.play();
                dingAudio.pause();
                dingAudio.currentTime = 0;
                dingAudio.volume = 1;
                logCall('UNLOCK: DING OK');
            } catch (e) {
                logCall('UNLOCK: DING FAIL', { error: e?.message || e });
                // tetap lanjut unlock TTS
            }

            // 2) Unlock SpeechSynthesis
            try {
                speechSynthesis.cancel();
                const u = new SpeechSynthesisUtterance(" ");
                u.lang = ttsVoice?.lang || 'id-ID';
                if (ttsVoice) u.voice = ttsVoice;
                u.volume = 0; // silent
                speechSynthesis.speak(u);

                // tunggu sebentar biar engine "kebuka"
                await new Promise(r => setTimeout(r, 250));
                speechSynthesis.cancel();

                logCall('UNLOCK: TTS OK');
            } catch (e) {
                logCall('UNLOCK: TTS FAIL', { error: e?.message || e });
            }

            audioUnlocked = true;
            logCall('UNLOCK: DONE');
            return true;
        }

        document.getElementById('unlock-btn')?.addEventListener('click', async () => {
            await unlockAudioOnce();
            const ov = document.getElementById('unlock-overlay');
            if (ov) ov.style.display = 'none';
            processQueue(); // kalau sebelumnya udah ada antrian numpuk, langsung proses
        });

        // ================= DING DONG (FADE OUT) =================
        const dingAudio = new Audio('audio/tingting.mp3');
        dingAudio.preload = 'auto';

        function playDingFade(duration = 3.0, fadeTime = 2.0) {
            return new Promise(async (resolve) => {
                try {
                    // pastiin context aktif
                    if (audioCtx.state !== 'running') await audioCtx.resume();
                } catch (_) { }

                dingAudio.pause();
                dingAudio.currentTime = 0;

                // jangan utak-atik dingAudio.volume lagi (biarin 1)
                dingAudio.volume = 1;

                // SET GAIN AWAL (BOOST)
                const baseGain = dingGain.gain.value; // misal 4.0 / 6.0
                dingGain.gain.setValueAtTime(baseGain, audioCtx.currentTime);

                logCall('DING PLAY', { baseGain });

                dingAudio.play().catch(() => {
                    logCall('DING AUTOPLAY BLOCKED');
                    resolve();
                });

                const fadeStart = Math.max(duration - fadeTime, 0);

                setTimeout(() => {
                    // fade pakai gain node (bukan volume audio element)
                    const t0 = audioCtx.currentTime;
                    dingGain.gain.cancelScheduledValues(t0);
                    dingGain.gain.setValueAtTime(baseGain, t0);
                    dingGain.gain.linearRampToValueAtTime(0.0001, t0 + fadeTime);

                    setTimeout(() => {
                        dingAudio.pause();
                        dingAudio.currentTime = 0;

                        // balikin gain ke base biar next play normal
                        const t1 = audioCtx.currentTime;
                        dingGain.gain.cancelScheduledValues(t1);
                        dingGain.gain.setValueAtTime(baseGain, t1);

                        logCall('DING END (FADE)', { baseGain });
                        resolve();
                    }, fadeTime * 1000 + 50);
                }, fadeStart * 1000);
            });
        }

        // ================= DING BOOSTER (FIX) =================
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        const audioCtx = new AudioCtx();

        let dingSourceNode = null;
        const dingGain = audioCtx.createGain();

        // set boost awal (coba gede dulu biar kelihatan bedanya)
        dingGain.gain.value = 8.0; // coba 4 dulu, nanti turunin kalau pecah

        function setupDingBoosterOnce() {
            if (dingSourceNode) return; // jangan bikin source 2x

            dingSourceNode = audioCtx.createMediaElementSource(dingAudio);
            dingSourceNode.connect(dingGain);
            dingGain.connect(audioCtx.destination);

            logCall('DING BOOST READY', { gain: dingGain.gain.value, ctx: audioCtx.state });
        }
        setupDingBoosterOnce();

        // ================= QUEUE SUARA =================
        const callQueue = [];
        let isProcessingQueue = false;

        function enqueueCall(text, meta) {
            callQueue.push({ text, meta });
            logCall('ENQUEUE', { ...meta, queue_len: callQueue.length });
            processQueue();
        }

        async function processQueue() {

            if (!audioUnlocked) {
                logCall('QUEUE PAUSE (NEED UNLOCK)', { queue_len: callQueue.length });
                return;
            }

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

        // async function testDing() {
        //     await unlockAudioOnce(); // biar pasti running
        //     dingGain.gain.value = 9.0; // test gede banget dulu
        //     playDingFade(3.0, 2.0);
        // }

        // async function testDing2() {
        //     await unlockAudioOnce(); // biar pasti running
        //     dingGain.gain.value = 2.0; // test gede banget dulu
        //     playDingFade(3.0, 2.0);
        // }

        setInterval(checkLastCall, 2000);
    </script>
</body>

</html>