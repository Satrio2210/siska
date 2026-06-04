<!doctype html>
<?php include "conf/config.php";
//memulai session
session_start();

//cek adanya session
if (isset($_SESSION['username'])) {
  $user = $_SESSION['username'];

  ?>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Klinik Pratama">
    <title>Pemeriksaan Pasien</title>
    <link rel="shortcut icon" href="img/icon.png">
    <link rel="stylesheet" href="css/pure/pure-min.css">
    <!--[if lte IE 8]>
  <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
<![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
    <style type="text/css">
      html {
        scroll-behavior: smooth;
      }

      img {
        width: 100px;
        height: 100px;
        position: relative;
        top: 0px;
        left: 0px;
      }

      .button-view {
        background: rgb(28, 184, 65);
        /* this is an green */
      }

      .button-delete {
        background: rgb(202, 60, 60);
        /* this is an maroon */
      }
    </style>

    <style type="text/css">
      div.footerdate {
        position: fixed;
        left: 50;
        bottom: 50px;
        width: 90%;
        color: black;
        text-align: right;
      }

      div.footertime {
        position: fixed;
        left: 50;
        bottom: 20px;
        width: 90%;
        color: black;
        text-align: right;
      }
    </style>

    <!-- new style -->
    <style>
      body {
        background: #f3f6fb;
      }

      .content {
        padding: 20px;
      }

      .medical-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
      }

      .medical-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #edf1f7;
        /* height: 100%; */
        display: flex;
        flex-direction: column;
      }

      .medical-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
      }

      .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
      }

      .form-group {
        display: flex;
        flex-direction: column;
      }

      .form-group label {
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
      }

      .form-group input,
      .form-group textarea,
      .form-group select {
        width: 100% !important;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 500;
        color: #000;
        background: white;
        box-sizing: border-box;
        transition: all .2s ease;
      }

      .form-group input:focus,
      .form-group textarea:focus,
      .form-group select:focus {
        border-color: #10b981;
        outline: none;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
      }

      .form-group input[readonly],
      .form-group textarea[readonly] {
        color: #000 !important;
        font-weight: 500 !important;
        -webkit-text-fill-color: #000 !important;
        opacity: 1 !important;
      }

      .form-group textarea {
        min-height: 120px;
        resize: vertical;
        color: #000;
        font-size: 14px;
        font-weight: 500;
      }

      .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
      }

      .info-item {
        background: #f9fafb;
        border-radius: 12px;
        padding: 14px;
        border: 1px solid #eef2f7;
      }

      .info-item label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 6px;
      }

      .info-item input {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        font-weight: 600;
        color: #111827;
        box-shadow: none !important;
      }

      .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: center;
      }

      .checkbox-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
      }

      .button-modern {
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s ease;
      }

      .button-submit {
        background: #10b981;
        color: white;
      }

      .button-submit:hover {
        background: #059669;
      }

      .button-print {
        background: #2563eb;
        color: white;
      }

      .button-print:hover {
        background: #1d4ed8;
      }

      .action-wrapper {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
      }

      #tbldiagnosa,
      #tblscreen {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        width: 100%;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 10px;
      }

      #screen,
      #screendiag {
        border-collapse: collapse;
        width: 100%;
        overflow: hidden;
        border-radius: 14px;
      }

      #screen thead,
      #screendiag thead {
        background: #10b981;
        color: white;
      }

      #screen th,
      #screen td,
      #screendiag th,
      #screendiag td {
        padding: 14px !important;
        border: none !important;
        font-size: 13px;
      }

      #screen tbody tr,
      #screendiag tbody tr {
        border-bottom: 1px solid #e5e7eb;
      }

      #screen tbody tr:hover,
      #screendiag tbody tr:hover {
        background: #f9fafb !important;
      }

      @media (max-width: 768px) {
        .medical-card {
          padding: 16px;
        }

        .action-wrapper {
          flex-direction: column;
          align-items: stretch;
        }

        .button-modern {
          width: 100%;
        }
      }

      /* ===============================
                                                         MODERN MEDICAL LAYOUT
                                                      ================================ */

      .split-layout {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
        align-items: stretch;
      }

      .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
      }

      .vital-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
      }

      @media(max-width: 992px) {

        .split-layout {
          grid-template-columns: 1fr;
        }

        .form-grid-2,
        .vital-grid {
          grid-template-columns: 1fr;
        }

      }

      /* =========================
                                                 RIWAYAT PASIEN
                                              ========================= */

      .history-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 24px;
        margin-top: 10px;
      }

      .history-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        min-height: 56px;
      }

      .history-label {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
      }

      .history-option {
        display: flex;
        align-items: center;
        gap: 18px;
      }

      .history-option label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        cursor: pointer;
        color: #374151;
        margin: 0;
      }

      .history-option input[type="checkbox"] {
        width: 16px;
        height: 16px;
      }

      @media(max-width:768px) {

        .history-grid {
          grid-template-columns: 1fr;
        }

        .history-row {
          flex-direction: column;
          align-items: flex-start;
          gap: 10px;
        }
      }

      /* =========================
                                         PEMERIKSAAN
                                      ========================= */

      .exam-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 14px;
        align-items: start;
      }

      .exam-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 16px;
      }

      .exam-label {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 14px;
      }

      .exam-card textarea,
      .exam-card select {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 500;
        color: #000;
        box-sizing: border-box;
      }

      .exam-card textarea {
        min-height: 90px;
        resize: vertical;
      }

      .diagnosa-section {
        margin-top: 20px;
      }

      .diagnosa-search {
        width: 100%;
      }

      .diagnosa-search input {
        width: 100%;
      }

      .note-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 14px;
        margin-bottom: 0;
      }

      @media(max-width:768px) {

        .exam-grid,
        .note-grid {
          grid-template-columns: 1fr;
        }

      }

      /* =========================
                                     DIAGNOSA
                                  ========================= */

      .diagnosa-wrapper {
        position: relative;
        width: 100%;
        margin-top: 14px;
      }

      .diagnosa-search {
        width: 100%;
      }

      .diagnosa-search input {
        width: 100%;
      }

      #tbllistdiag {
        width: 100%;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        margin-top: 8px;
        max-height: 300px;
        overflow-y: auto;
      }

      #tbldiagnosa {
        width: 100%;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        margin-top: 14px;
      }

      #tbllistdiag table,
      #tbldiagnosa table {
        margin: 0;
      }

      /* =========================
                                 SUBMIT SECTION
                              ========================= */

      .submit-card {
        margin-top: 5px !important;
      }

      .submit-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
      }

      .submit-left {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .submit-left label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
      }

      .submit-left select {
        min-width: 220px;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 13px;
        background: white;
      }

      .submit-right {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
      }

      .btn-modern {
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
      }

      .btn-primary {
        background: #10b981;
        color: white;
      }

      .btn-primary:hover {
        background: #059669;
      }

      .btn-secondary {
        background: #eef2ff;
        color: #3730a3;
      }

      .btn-secondary:hover {
        background: #e0e7ff;
      }

      @media(max-width:768px) {

        .submit-wrapper {
          flex-direction: column;
          align-items: stretch;
        }

        .submit-left,
        .submit-right {
          width: 100%;
        }

        .submit-right {
          justify-content: flex-start;
        }

      }
    </style>

  </head>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script src="js/sanie.js"></script>
  <script src="js/sweetalert.min.js"></script>

  <script>
    $(document).ready(function () {
      setInterval(timestamp, 1000);
    });
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function (data) { $('#timestamp').html(data); }, }); }
  </script>

  <body onLoad="periksaakses('PASS_TRXA_POLI'); 
">
    <div id="layout">
      <!-- Menu toggle -->
      <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
      </a>
      <!-- Menu Kiri -->
      <div id="menu">
        <div class="pure-menu">

          <a class="pure-menu-heading" href="#"><?php echo $_SESSION['username']; ?></a>
          <ul class="pure-menu-list">

            <li class="pure-menu-item" onclick="javascript: location.href = 'index.php'">
              <a class="pure-menu-link">RAWAT JALAN</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
              <a class="pure-menu-link">Pasien</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI05.php'">
              <a class="pure-menu-link">Signa</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAMEDI01.php'">
              <a class="pure-menu-link">Tindakan Medis</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'DIAGMAST01.php'">
              <a class="pure-menu-link">Kode Diagnosa</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'signout.php'">
              <a class="pure-menu-link">EXIT</a>
            </li>

          </ul>
        </div>
      </div><!-- div menu -->

      <!-- tampilan menu -->
      <div id="main">
        <div class="header">
          <img align="right" height="<?php echo $width_logo; ?>" width="<?php echo $height_logo; ?>" src="img/logo.png"
            alt="">

          <h1 id="login">Sistem Informasi Klinik Pratama</h1>
          <h2>SISKA</h2>
        </div><!-- div header -->
        <div class="headerlogo">
        </div>

        <div class="content">

          <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Pemeriksaan Pasien
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPOLI02.php'">
                <a class="pure-menu-link">
                  Perawatan Pasien
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected">
                <a id="bhpLink" class="pure-menu-link">
                  BHP
                </a>
              </li>

            </ul>
          </div>
          <!-- Tab Menu -->
          <div class="medical-container"></div>

          <div class="medical-card" id="daftarPasien">
            <div class="medical-title">
              Daftar Pasien
            </div>
            <!-- <div id="tblscreen" style="position: absolute; 
                    top: 200px;
                    left: calc(80% - 300px);
                    background-color: white; 
                    visibility: hidden; 
                    z-index: 100">
              </div> -->
            <div id="tblscreen">
            </div>
          </div>


          <!-- Form Input -->

          <form name="frmtrxapoli" class="pure-form pure-form-aligned" method="post" action="">
            <fieldset>

              <div class="medical-card" id="infoPasien">
                <div class="medical-title">
                  Informasi Pasien
                </div>

                <div class="form-grid">
                  <div class="form-group">
                    <label for="txtregidate">Tgl. Berkunjung :</label>
                    <input type="text" name="txtregidate" id="txtregidate" maxlength="14" style="width: 150px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <label for="txtexamcode">No. Daftar :</label>
                    <input type="text" name="txtexamcode" id="txtexamcode" maxlength="14" style="width: 250px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <input type="hidden" name="hidexamdoct" id="hidexamdoct" value="<?php echo $user; ?>">

                    <label for="txtpaticode">Rekam Medis :</label>
                    <input type="text" name="txtpaticode" id="txtpaticode" maxlength="10" style="width: 150px;"
                      readonly="true">
                  </div>
                </div>

                <div class="form-grid">
                  <div class="form-group">
                    <label for="txtmainname">Nama Lengkap :</label>
                    <input type="text" name="txtmainname" id="txtmainname" maxlength="50" style="width: 250px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <label for="txtmaingend">Jenis Kelamin :</label>
                    <input type="text" name="txtmaingend" id="txtmaingend" maxlength="10" style="width: 150px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <label for="txtmainage">Usia :</label>
                    <input type="text" name="txtmainage" id="txtmainage" maxlength="50" style="width: 250px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <label for="txtbirtdate">Tgl Lahir :</label>
                    <input type="text" name="txtbirtdate" id="txtbirtdate" maxlength="14" style="width: 150px;"
                      readonly="true">
                  </div>
                </div>

                <div class="form-grid">
                  <div class="form-group">
                    <label for="txtmainaddr">Alamat :</label>
                    <input type="text" name="txtmainaddr" id="txtmainaddr" maxlength="50" style="width: 500px;"
                      readonly="true">
                  </div>

                  <div class="form-group">
                    <label for="txtregipaym">Pembayaran :</label>
                    <input type="text" name="txtregipaym" id="txtregipaym" maxlength="50" style="width: 150px;"
                      readonly="true">
                  </div>
                </div>
              </div>

              <div class="split-layout">

                <!-- KIRI -->
                <div class="medical-card">

                  <div class="medical-title">
                    Keluhan
                  </div>

                  <div class="form-group">
                    <label for="txtexamcomp">
                      Keluhan Utama
                    </label>

                    <textarea id="txtexamcomp" name="txtexamcomp" rows="3" readonly="true">
                                                                </textarea>
                  </div>

                  <br>

                  <!-- <div class="form-group">

                      <label for="txtexamanam">
                        Anamnesa
                      </label>

                      <textarea id="txtexamanam" name="txtexamanam" rows="3"></textarea>

                    </div> -->

                </div>

                <!-- KANAN -->
                <div class="medical-card">

                  <div class="medical-title">
                    Vital Sign
                  </div>

                  <div class="vital-grid">

                    <div class="form-group">
                      <label for="txtexamhght">
                        Tinggi (cm)
                      </label>

                      <input type="text" name="txtexamhght" id="txtexamhght" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamwght">
                        Berat (kg)
                      </label>

                      <input type="text" name="txtexamwght" id="txtexamwght" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamwaist">
                        Lingkar Perut (cm)
                      </label>

                      <input type="text" name="txtexamwaist" id="txtexamwaist" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexambmi">
                        IMT (kg/m2)
                      </label>

                      <input type="text" name="txtexambmi" id="txtexambmi" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamblod">
                        Tekanan Darah (mmHg)
                      </label>

                      <input type="text" name="txtexamblod" id="txtexamblod" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamtemp">
                        Suhu (celcius)
                      </label>

                      <input type="text" name="txtexamtemp" id="txtexamtemp" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamrr">
                        Respiratory Rate (/minute)
                      </label>

                      <input type="text" name="txtexamrr" id="txtexamrr" maxlength="10">
                    </div>

                    <div class="form-group">
                      <label for="txtexamhr">
                        Heart Rate (bpm)
                      </label>

                      <input type="text" name="txtexamhr" id="txtexamhr" maxlength="10">
                    </div>
                  </div>
                </div>
              </div>

              <div class="medical-card">

                <div class="medical-title">
                  Riwayat Pasien
                </div>

                <div class="history-grid">

                  <!-- ALERGI OBAT -->
                  <div class="history-row">

                    <div class="history-label">
                      Alergi Obat
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optmedialle-no" id="optmedialle-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optmedialle-yes').checked = false;
                            document.getElementById('hidmedialle').value = 'N';
                        }">
                        Tidak Ada
                      </label>

                      <label>
                        <input type="checkbox" name="optmedialle-yes" id="optmedialle-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optmedialle-no').checked = false;
                            document.getElementById('hidmedialle').value = 'Y';
                        }">
                        Ada
                      </label>

                      <input name="hidmedialle" id="hidmedialle" type="hidden">

                    </div>

                  </div>

                  <!-- ALERGI MAKANAN -->
                  <div class="history-row">

                    <div class="history-label">
                      Alergi Makanan
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optfoodalle-no" id="optfoodalle-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optfoodalle-yes').checked = false;
                            document.getElementById('hidfoodalle').value = 'N';
                        }">
                        Tidak Ada
                      </label>

                      <label>
                        <input type="checkbox" name="optfoodalle-yes" id="optfoodalle-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optfoodalle-no').checked = false;
                            document.getElementById('hidfoodalle').value = 'Y';
                        }">
                        Ada
                      </label>

                      <input name="hidfoodalle" id="hidfoodalle" type="hidden">

                    </div>

                  </div>

                  <!-- PENYAKIT KRONIS -->
                  <div class="history-row">

                    <div class="history-label">
                      Penyakit Kronis
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optchrodsse-no" id="optchrodsse-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optchrodsse-yes').checked = false;
                            document.getElementById('hidchrodsse').value = 'N';
                        }">
                        Tidak Ada
                      </label>

                      <label>
                        <input type="checkbox" name="optchrodsse-yes" id="optchrodsse-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optchrodsse-no').checked = false;
                            document.getElementById('hidchrodsse').value = 'Y';
                        }">
                        Ada
                      </label>

                      <input name="hidchrodsse" id="hidchrodsse" type="hidden">

                    </div>

                  </div>

                  <!-- PENYAKIT LAIN -->
                  <div class="history-row">

                    <div class="history-label">
                      Penyakit Lainnya
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optothrdsse-no" id="optothrdsse-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optothrdsse-yes').checked = false;
                            document.getElementById('hidothrdsse').value = 'N';
                        }">
                        Tidak Ada
                      </label>

                      <label>
                        <input type="checkbox" name="optothrdsse-yes" id="optothrdsse-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optothrdsse-no').checked = false;
                            document.getElementById('hidothrdsse').value = 'Y';
                        }">
                        Ada
                      </label>

                      <input name="hidothrdsse" id="hidothrdsse" type="hidden">

                    </div>

                  </div>

                  <!-- RAWAT INAP -->
                  <div class="history-row">

                    <div class="history-label">
                      Rawat Inap
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optpaticare-no" id="optpaticare-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optpaticare-yes').checked = false;
                            document.getElementById('hidpaticare').value = 'N';
                        }">
                        Tidak
                      </label>

                      <label>
                        <input type="checkbox" name="optpaticare-yes" id="optpaticare-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optpaticare-no').checked = false;
                            document.getElementById('hidpaticare').value = 'Y';
                        }">
                        Ya
                      </label>

                      <input name="hidpaticare" id="hidpaticare" type="hidden">

                    </div>

                  </div>

                  <!-- OPERASI -->
                  <div class="history-row">

                    <div class="history-label">
                      Operasi
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optpatisurge-no" id="optpatisurge-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optpatisurge-yes').checked = false;
                            document.getElementById('hidpatisurge').value = 'N';
                        }">
                        Tidak
                      </label>

                      <label>
                        <input type="checkbox" name="optpatisurge-yes" id="optpatisurge-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optpatisurge-no').checked = false;
                            document.getElementById('hidpatisurge').value = 'Y';
                        }">
                        Ya
                      </label>

                      <input name="hidpatisurge" id="hidpatisurge" type="hidden">

                    </div>

                  </div>

                  <!-- MEROKOK -->
                  <div class="history-row">

                    <div class="history-label">
                      Merokok
                    </div>

                    <div class="history-option">

                      <label>
                        <input type="checkbox" checked="checked" name="optpatismoke-no" id="optpatismoke-no" value="true"
                          onclick="
                        if (checked == true){
                            document.getElementById('optpatismoke-yes').checked = false;
                            document.getElementById('hidpatismoke').value = 'N';
                        }">
                        Tidak
                      </label>

                      <label>
                        <input type="checkbox" name="optpatismoke-yes" id="optpatismoke-yes" value="true" onclick="
                        if (checked == true){
                            document.getElementById('optpatismoke-no').checked = false;
                            document.getElementById('hidpatismoke').value = 'Y';
                        }">
                        Ya
                      </label>

                      <input name="hidpatismoke" id="hidpatismoke" type="hidden">
                    </div>
                  </div>
                </div>
              </div>

              <div class="medical-card">

                <div class="medical-title">
                  Pemeriksaan
                </div>

                <!-- TOP -->
                <div class="exam-grid">
                  <!-- ANAMNESA -->
                  <div class="exam-card">
                    <div class="exam-label">
                      Anamnesa
                    </div>

                    <textarea id="txtexamanam" name="txtexamanam" rows="3"></textarea>
                  </div>

                  <!-- PEMERIKSAAN FISIK -->
                  <div class="exam-card">

                    <div class="exam-label">
                      Pemeriksaan Fisik
                    </div>

                    <textarea id="txtexambody" name="txtexambody" rows="3"></textarea>

                  </div>

                  <!-- TERAPI -->
                  <div class="exam-card">

                    <div class="exam-label">
                      Terapi Non Obat
                    </div>

                    <select name="" id="" style="height: 35px; padding: 5px; font-size: 14px;">
                      <option value="">- PILIH -</option>
                      <optgroup label="Edukasi dan Modifikasi Gaya Hidup">
                        <option value="">Konseling Diet / Gizi</option>
                        <option value="">Edukasi Berhenti Merokok</option>
                        <option value="">Aktifitas Fisik</option>
                      </optgroup>
                      <optgroup label="Terapi Fisik">
                        <option value="">Terapi Panas / dingin</option>
                        <option value="">Latihan Rentang Gerak</option>
                        <option value="">Pemijatan</option>
                      </optgroup>
                      <optgroup label="Perawatan Luka dan Tindakan">
                        <option value="">Perawatan Luka</option>
                        <option value="">Imobilisasi</option>
                        <option value="">Ekstraksi Corpus Alienum</option>
                      </optgroup>
                      <optgroup label="Terapi Psikologis">
                        <option value="">Managemen Stres</option>
                        <option value="">Konseling Psikologis</option>
                      </optgroup>
                      <optgroup label="Terapi Pendukung Lainnya">
                        <option value="">Akupuntur / Akupresur</option>
                        <option value="">Edukasi Postur</option>
                      </optgroup>
                    </select>

                  </div>

                </div>

                <!-- DIAGNOSA -->
                <div class="diagnosa-section">

                  <div class="exam-label">
                    Diagnosa
                  </div>

                  <div class="diagnosa-wrapper">

                    <!-- SEARCH -->
                    <div class="diagnosa-search">

                      <input type="text" name="txtlistdiag" id="txtlistdiag" maxlength="200" autocomplete="off"
                        placeholder="Cari diagnosa ICD..." onkeyup="
                if (value.length > 0) {
                    let regicode = document.getElementById('txtexamcode').value;
                    ambildiagnosa(regicode,this.value);
                } else {
                    document.getElementById('tbllistdiag').style.display = 'none';
                }">

                    </div>

                    <div id="tbllistdiag" style="
                          width: 100%;
                          background-color: white;
                          display: none;
                          margin-top: 10px;
                          border-radius: 12px;
                          overflow-y: auto;
                          max-height: 250px;
                      ">
                    </div>

                    <div id="tbldiagnosa" style="
                          width: 100%;
                          background-color: white;
                          display: none;
                          margin-top: 14px;
                          border-radius: 12px;
                      ">
                    </div>

                    <!-- HASIL SEARCH -->
                    <!-- <div id="tbllistdiag" style="display:none;">
                    </div> -->

                    <!-- HASIL TERPILIH -->
                    <!-- <div id="tbldiagnosa" style="display:none;">
                    </div> -->

                  </div>

                </div>

                <!-- NOTE + RESEP -->
                <div class="note-grid">

                  <!-- NOTE -->
                  <div class="exam-card">

                    <div class="exam-label">
                      Note
                    </div>

                    <textarea id="txtexamdiag" name="txtexamdiag" rows="3"></textarea>

                  </div>

                  <!-- RESEP -->
                  <div class="exam-card">

                    <div class="exam-label">
                      Terapi Obat / Resep
                    </div>

                    <textarea id="txtexamprsc" name="txtexamprsc" rows="3"></textarea>

                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>

              <div class="medical-card submit-card">

                <div class="medical-title">
                  Submit Pemeriksaan
                </div>

                <div class="submit-wrapper">

                  <!-- LEFT -->
                  <div class="submit-left">

                    <label for="jenis_surat">
                      Cetak Surat
                    </label>

                    <select id="jenis_surat" disabled>

                      <option value="">
                        -- CETAK SURAT --
                      </option>

                      <option value="SKBW">
                        SKBW
                      </option>

                      <option value="SURAT_SEHAT">
                        Surat Sehat
                      </option>

                      <option value="SURAT_KETERANGAN">
                        Surat Keterangan
                      </option>

                    </select>
                    <!-- CETAK -->
                    <button type="button" class="btn-modern btn-secondary" onclick="cetakSurat()" disabled>
                      Cetak Surat
                    </button>

                  </div>

                  <!-- RIGHT -->
                  <div class="submit-right">

                    <!-- SUBMIT -->
                    <button type="button" class="btn-modern btn-primary" onclick="

                if (document.getElementById('txtexamhght').value == '')
                {
                    swal({
                        title: 'Tinggi Badan Kosong' ,
                        text: 'Anda belum mengisi Tinggi Badan, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else if (document.getElementById('txtexamwght').value == '')
                {
                    swal({
                        title: 'Berat Badan Kosong' ,
                        text: 'Anda belum mengisi Berat Badan, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else if (document.getElementById('txtexamblod').value == '')
                {
                    swal({
                        title: 'Tekanan Darah Kosong' ,
                        text: 'Anda belum mengisi Tekanan Darah, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else if (document.getElementById('txtexamtemp').value == '')
                {
                    swal({
                        title: 'Temperatur Kosong' ,
                        text: 'Anda belum mengisi Temperatur Suhu, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else if (document.getElementById('txtexamanam').value == '')
                {
                    swal({
                        title: 'Anamnesa Kosong' ,
                        text: 'Anda belum mengisi Anamnesa, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else if (document.getElementById('txtexamprsc').value == '')
                {
                    swal({
                        title: 'Resep Kosong' ,
                        text: 'Anda belum mengisi E-Resep, silah periksa lagi',
                        icon: 'warning',
                    });
                }

                else
                {
                    var inexamcode = document.getElementById('txtexamcode').value;
                    var inexamdoct = document.getElementById('hidexamdoct').value;

                    var inexamhght = document.getElementById('txtexamhght').value;
                    var inexamwght = document.getElementById('txtexamwght').value;

                    var inexamwaist = document.getElementById('txtexamwaist').value;
                    var inexambmi = document.getElementById('txtexambmi').value;

                    var inexamblod = document.getElementById('txtexamblod').value;
                    var inexamtemp = document.getElementById('txtexamtemp').value;

                    var inexamrr = document.getElementById('txtexamrr').value;
                    var inexamhr = document.getElementById('txtexamhr').value;
                    var inexamcomp = document.getElementById('txtexamcomp').value;
                    
                    var inmedialle = document.getElementById('hidmedialle').value;
                    var infoodalle = document.getElementById('hidfoodalle').value;
                    var inchrodsse = document.getElementById('hidchrodsse').value;
                    var inothrdsse = document.getElementById('hidothrdsse').value;
                    var inpaticare = document.getElementById('hidpaticare').value;
                    var inpatisurge = document.getElementById('hidpatisurge').value;
                    var inpatismoke = document.getElementById('hidpatismoke').value;

                    var inexamanam = document.getElementById('txtexamanam').value;
                    var inexambody = document.getElementById('txtexambody').value;

                    var inexamdiag = document.getElementById('txtexamdiag').value;

                    var inexamprsc = document.getElementById('txtexamprsc').value;

                    input(
                        inexamcode,
                        inexamdoct,
                        inexamhght,
                        inexamwght,
                        inexamwaist,
                        inexambmi,
                        inexamblod,
                        inexamtemp,
                        inexamrr,
                        inexamhr,
                        inexamcomp,
                        inmedialle,
                        infoodalle,
                        inchrodsse,
                        inothrdsse,
                        inpaticare,
                        inpatisurge,
                        inpatismoke,
                        inexamanam,
                        inexambody,
                        inexamdiag,
                        inexamprsc
                    );

                    document.getElementById('tblrekammedis').style.visibility = 'hidden';
                    document.getElementById('tblrekammedis').innerHTML = '';
                }

                ">

                      Simpan Pemeriksaan

                    </button>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <div class="medical-card">
                <div class="medical-title">
                  Rekam Medis
                </div>
                <div id="tblrekammedis"></div>
              </div>
            </fieldset>
          </form>
        </div>

      </div><!-- div content -->
      <div class="footerdate">
        <span class="labelTime Time"><b>Date :</b> <?php $tgl = date('d-m-Y');
        echo $tgl; ?></span>
      </div>
      <div class="footertime">
        <span class="labelTime Time" id="timestamp"></span>
      </div>


    </div><!-- div main -->
    </div><!-- div layout -->
    <script src="js/TRXAPOLI01.js"></script>
    <script src="js/ui.js"></script>
    <script>
      document.addEventListener('click', function (e) {
        const btn = e.target.closest('.button-panggil');
        if (!btn) return;

        const nomor = btn.getAttribute('data-noantri') || '';
        const nama = btn.getAttribute('data-nama') || '';
        const poli = btn.getAttribute('data-poli') || '';
        const channel = btn.getAttribute('data-channel') || 'POLI';

        const params = "channel=" + encodeURIComponent(channel)
          + "&nomor=" + encodeURIComponent(nomor)
          + "&nama=" + encodeURIComponent(nama)
          + "&poli=" + encodeURIComponent(poli);

        fetch('panggil_queue.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: params
        })
          .then(r => r.json())
          .then(res => {
            console.log('RESP panggil_queue POLI:', res);
            // kalau mau: if (!res.ok) alert(res.error);
          })
          .catch(err => {
            console.error('Error fetch panggil_queue POLI:', err);
          });
      });
    </script>

  </body>

  </html>
  <?php
} else {
  header("Location: " . "signin.php");
}
?>