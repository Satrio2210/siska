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

    <script src="https://code.responsivevoice.org/responsivevoice.js?key=m2sKd8bb"></script>
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
                    document.getElementById('call-name').innerText = nama;
                    document.getElementById('call-poli').innerText = poli;

                    const text = "Nomor antrian " + nomor +
                        ", atas nama " + nama +
                        ", silakan menuju " + poli + ".";

                    if (window.responsiveVoice && responsiveVoice.voiceSupport()) {
                        responsiveVoice.cancel();
                        responsiveVoice.speak(text, "Indonesian Female", {
                            pitch: 1,
                            rate: 0.95,
                            volume: 1
                        });
                    }
                })
                .catch(err => console.error(err));
        }

        setInterval(checkLastCall, 2000);
    </script>
</body>

</html>