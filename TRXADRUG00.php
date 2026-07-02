<!-- TRXADRUG00.php -->

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
    <title>Resep</title>
    <link rel="shortcut icon" href="img/icon.png">
    <link rel="stylesheet" href="css/pure/pure-min.css">
    <!--[if lte IE 8]>
  <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
<![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
    <style type="text/css">
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

      .button-update {
        color: white;
        border-radius: 4px;
        background: rgb(66, 184, 221);
        /* this is a light blue */
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

    <!-- ========================= MODERN FORM LAYOUT START ========================= -->
    <style>
      :root {
        --primary: #16a34a;
        --primary-dark: #15803d;
        --primary-soft: #dcfce7;
        --bg: #f3f6fb;
        --card: #ffffff;
        --border: #dbe4ee;
        --text: #0f172a;
        --muted: #64748b;
        --danger: #dc2626;
        --shadow: 0 2px 6px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
        --radius: 16px;
      }

      .content {
        background: var(--bg);
        padding: 20px;
      }

      /* ========================= GLOBAL ========================= */
      .card-modern {
        background: var(--card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: visible;
      }

      .card-title {
        padding: 12px 16px;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        color: white;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .3px;
      }

      .card-body {
        padding: 12px;
      }

      .input-modern,
      .modern-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 10px;
        font-size: 13px;
        background: white;
        transition: .2s;
      }

      .input-modern:focus,
      .modern-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(22, 163, 74, .12);
      }

      .modern-textarea {
        resize: none;
        min-height: 70px;
      }

      /* ========================= TOP LIST PASIEN ========================= */
      .patient-list-wrapper {
        margin-top: 18px;
      }

      .patient-search {
        margin-bottom: 10px;
      }

      .patient-list-scroll {
        max-height: 250px;
        overflow: scroll;
      }

      /* ========================= BOTTOM GRID ========================= */
      .workspace-grid {
        display: grid;
        grid-template-columns: 40% 58%;
        gap: 16px;
        margin-top: 16px;
      }

      /* ========================= PATIENT INFO ========================= */
      .patient-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
      }

      .info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 10px;
      }

      .info-label {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .4px;
      }

      .info-value {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
      }

      .recipe-doctor {
        margin-top: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #000000;
        border-radius: 12px;
        padding: 10px;
        font-family: monospace;
        font-weight: bold;
        line-height: 1.7;
        min-height: auto;
        overflow: auto;
        /* white-space: pre-wrap; */
      }

      /* .recipe-dokisi {
              white-space: pre-wrap;
              word-wrap: break-word;
            } */

      /* ========================= PAYMENT BADGE ========================= */
      .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
      }

      .badge-umum {
        background: #e2e8f0;
        color: #334155;
      }

      .badge-bpjs {
        background: #dcfce7;
        color: #166534;
      }

      .badge-asuransi {
        background: #dbeafe;
        color: #1e40af;
      }

      .badge-perusahaan {
        background: #ffedd5;
        color: #c2410c;
      }

      /* ========================= INPUT RESEP ========================= */
      .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }

      .full-width {
        grid-column: 1/-1;
      }

      .form-label {
        display: block;
        margin-bottom: 4px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
      }

      .checkbox-row {
        display: flex;
        gap: 18px;
        align-items: center;
      }

      .checkbox-modern {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
      }

      /* ========================= BUTTON ========================= */
      .action-row {
        margin-top: 12px;
        display: flex;
        gap: 8px;
      }

      .btn-modern {
        border: none;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
      }

      .btn-save {
        background: var(--primary);
        color: white;
      }

      .btn-save:hover {
        background: var(--primary-dark);
      }

      .btn-close {
        background: #e2e8f0;
        color: #334155;
      }

      /* ========================= TABLE RESEP ========================= */
      .recipe-table-wrapper {
        margin-top: 20px;
      }

      .recipe-table-scroll {
        max-height: 260px;
        overflow: auto;
      }

      #screen th {
        padding: 8px !important;
        font-size: 12px !important;
      }

      #screen td {
        padding: 7px !important;
        font-size: 12px !important;
      }

      #screen {
        font-size: 12px !important;
      }

      .total-panel {
        margin-top: 15px;
        display: flex;
        justify-content: flex-end;
      }

      .total-box {
        background: #dcfce7;
        color: #166534;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 800;
      }

      /* ========================= POPUP AUTOCOMPLETE ========================= */
      /* #tblregi, */
      .input-resep-wrapper {
        position: relative;
      }

      #tblregi {
        position: relative !important;
        width: 100%;
        top: auto !important;
        left: auto !important;
        right: auto !important;
        background: transparent;
        border: none;
        border-radius: 0;
        box-shadow: none;
        overflow: visible;
        z-index: auto;
        top: 80px;
        left: 0;
      }

      #tblsigna,
      #tblsigna_racik {
        position: absolute;
        background: white;
        border-radius: 10px;
        overflow: auto;
        box-shadow: 0 8px 10px rgba(0, 0, 0, .10);
        border: 1px solid #e2e8f0;
        z-index: 9999;
      }

      /* #tblsigna {
                      position: absolute;
                      top: 100%;
                      left: 0;
                      width: 100%;
                      margin-top: 4px;
                      z-index: 999;
                    } */

      #tblsigna table tbody,
      #tblsigna_racik table tbody 
      {
        display: block;
        max-height: 140px;
        overflow-y: auto;
        overflow-x: hidden;
      }

      #tblsigna table thead,
      #tblsigna table tbody tr,
      #tblsigna_racik table thead,
      #tblsigna_racik table tbody tr
      {
        display: table;
        width: auto;
        table-layout: fixed;
      }

      #tblresep,
      #tblresep_racik {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 500px;
        max-height: 220px;
        margin-top: 4px;
        background: #fff;
        border: 1px solid #a5a4a4;
        border-radius: 10px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        z-index: 9999;
        display: none;
        overflow-y: auto;
        overflow-x: hidden;
      }

      /* #tblsigna {
                                            width: 420px;
                                            top: 215px;
                                            right: 0;
                                          } */


      /* #tblresep table, */
      /* #tblsigna table {
                                          font-size: 12px !important;
                                        } */


      /* #tblresep td, */
      /* #tblsigna td {
                                          padding: 6px 8px !important;
                                        } */

      /* ========================= RESPONSIVE ========================= */
      @media(max-width:1100px) {
        .workspace-grid {
          grid-template-columns: 1fr;
        }

        .form-grid {
          grid-template-columns: 1fr;
        }
      }

      #txtexamprsc {
        height: auto !important;
        padding: 10px !important;
        font-size: 13px;
        line-height: 1.6;
        background: white !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px;
        font-family: monospace;
      }

      .autocomplete-wrapper {
        position: relative;
        width: 100%;
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

  <!-- <script>
    setInterval(function () {
      var textarea = document.getElementById('txtexamprsc');
      if (textarea) {
        var val = textarea.value;
        // Ganti tanda pemisah (jika ada) atau pastikan formatnya dibaca sebagai baris
        if (val.includes('--NL--')) {
          textarea.value = val.split('--NL--').join('\n');
        }
      }
    }, 500);
  </script> -->

  <script>
    $(document).ready(function () {
      // Kita buat variabel penanda
      var sudahRapi = false;

      function rapikanResep() {
        var prscBox = document.getElementById('txtexamprsc');

        // Cek jika elemen ada, ada isinya, dan BELUM PERNAH dirapikan
        if (prscBox && prscBox.value.length > 0 && !sudahRapi) {
          var rawText = prscBox.value;

          // Cek apakah memang perlu dirapikan (ada tanda '-' tapi belum ada '\n')
          if (rawText.includes('-') && !rawText.includes('\n')) {
            var cleanText = rawText.replace(/-/g, '\n-');
            prscBox.value = cleanText.trim();

            // Tandai bahwa proses sudah selesai
            sudahRapi = true;
            console.log("Resep sudah dirapikan, fungsi berhenti.");
          }
        }
      }

      // Jalankan pertama kali
      rapikanResep();

      // Interval tetap ada untuk jaga-jaga kalau data lambat loading
      var interval = setInterval(function () {
        if (sudahRapi) {
          clearInterval(interval); // Hentikan interval kalau sudah rapi
        } else {
          rapikanResep();
        }
      }, 1000);
    });
  </script>

  <audio id="notifAudio" preload="auto">

    <source src="audio/notif.mp3" type="audio/mpeg">

  </audio>

  <body onLoad="periksaakses('PASS_DRUG_ENTR');">
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
              <a class="pure-menu-link">FARMASI</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
              <a class="pure-menu-link">Transaksi</a>
            </li>


            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADRUG04.php'">
              <a class="pure-menu-link">Report</a>
            </li>

            <li class="pure-menu-item" onclick="window.open('INVEUP00.php','_blank')" style="cursor:pointer;">
              <a class="pure-menu-link">Update Stock/Harga Obat</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = ''">
                <a class="pure-menu-link">
                  Dashboard
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Input Resep
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG01.php'">
                <a class="pure-menu-link">
                  Penyerahan Obat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG02.php'">
                <a class="pure-menu-link">
                  Penjualan Obat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG03.php'">
                <a class="pure-menu-link">
                  Faktur
                </a>
              </li>

            </ul>
          </div>

          <form name="frmtrxadrug" class="pure-form" method="post"> <!-- hidden --> <input type="hidden"
              name="hidprscdoct" id="hidprscdoct" value="<?php echo $user; ?>"> <input type="hidden" name="hidregipaym"
              id="hidregipaym"> <input type="hidden" name="hidmediroom" id="hidmediroom"> <input type="hidden"
              name="hidstockcode" id="hidstockcode"> <input type="hidden" name="hidstockbtch" id="hidstockbtch"> <input
              type="hidden" name="hidstockpric" id="hidstockpric"> <input type="hidden" name="hidstockamnt"
              id="hidstockamnt"> <input type="hidden" name="hidprscconc" id="hidprscconc"> <input type="hidden"
              name="hidsigna" id="hidsigna">
            <!-- ===================================================== TOP LIST PASIEN ====================================================== -->
            <div class="card-modern patient-list-wrapper">
              <div class="card-title"> List Pasien / Registrasi </div>
              <div class="card-body">
                <div class="patient-search">
                  <input type="text" name="txtsearch" id="txtsearch" class="input-modern"
                    placeholder="Cari pasien / nomor RM..." autocomplete="off"
                    onkeyup="if (value.length > 0) { ambilregicode(this.value); } else { ambilregicode('X')};">
                </div>
                <div class="patient-list-scroll">
                  <div id="tblregi"></div>
                </div>
              </div>
            </div>
            <!-- ===================================================== BOTTOM WORKSPACE ====================================================== -->
            <div class="workspace-grid">
              <!-- ================================================= LEFT : DATA PASIEN ================================================== -->
              <div>
                <div class="card-modern">
                  <div class="card-title"> Data Pasien </div>
                  <div class="card-body">
                    <div class="patient-info-grid">
                      <div class="info-box">
                        <div class="info-label"> No Registrasi </div>
                        <input type="text" id="txtprsccode" class="input-modern" readonly>
                      </div>
                      <div class="info-box">
                        <div class="info-label"> Rekam Medis </div> <input type="text" id="txtpaticode"
                          class="input-modern" readonly>
                      </div>
                      <div class="info-box">
                        <div class="info-label"> Nama Pasien </div> <input type="text" id="txtmainname"
                          class="input-modern" readonly>
                      </div>
                      <div class="info-box">
                        <div class="info-label"> Jenis Kelamin </div> <input type="text" id="txtmaingend"
                          class="input-modern" readonly>
                      </div>
                      <div class="info-box">
                        <div class="info-label"> Usia </div> <input type="text" id="txtmainage" class="input-modern"
                          readonly>
                      </div>
                      <div class="info-box">
                        <div class="info-label"> Pembayaran </div> <input type="text" id="txtregipaym"
                          class="input-modern" readonly>
                      </div>
                    </div>
                    <div class="info-box">
                      <div class="info-label"> Diagnosa </div> <textarea id="txtexamdiag" rows="2" class="input-modern"
                        readonly></textarea>
                    </div>

                    <!-- resep dokter -->
                    <div class="recipe-doctor">
                      <div> RESEP DOKTER </div>
                      <textarea id="txtexamprsc" readonly class="modern-textarea"
                        style=" min-height:150px; background:#0f172a; color:white; border:none; font-family:monospace; "></textarea>
                    </div>

                  </div>
                </div>
              </div>
              <!-- ================================================= RIGHT : INPUT RESEP ================================================== -->
              <div>
                <div class="card-modern">
                  <div class="card-title" id="inputresep"> Input Resep Non Racikan </div>
                  <div class="card-body">
                    <div class="form-grid"> <!-- obat -->
                      <div class="full-width"> <label class="form-label"> Cari Obat </label>
                        <div class="autocomplete-wrapper">
                          <input type="text" name="txtstockcode" id="txtstockcode" class="input-modern" autocomplete="off"
                            placeholder="Ketik nama obat..."
                            onkeyup="if (value.length > 0) { var regipoli = document.getElementById('hidmediroom').value; var regipaym = document.getElementById('hidregipaym').value; ambilresep(this.value,regipoli,regipaym); } else { document.getElementById('tblresep').innerHTML=''; document.getElementById('tblresep').style.display='none'; }">
                          <div id="tblresep"></div>
                        </div>
                      </div> <!-- qty -->

                      <div> <label class="form-label"> Qty </label> <input type="text" name="txtstockquty"
                          id="txtstockquty" value="1" class="input-modern"> </div> <!-- signa -->
                      <div> <label class="form-label"> Signa </label>
                        <div class="autocomplete-wrapper">
                          <input type="text" name="txtsigna" id="txtsigna" autocomplete="off" class="input-modern"
                            placeholder="Aturan makan..."
                            onkeyup="if (value.length > 0) { ambilsignacode(this.value); } else { document.getElementById('tblsigna').style.display='none'; }">
                          <div id="tblsigna" style="display: none;"></div>
                        </div>
                      </div> <!-- cara pemakaian -->
                      <div class="full-width"> <label class="form-label"> Cara Pemakaian </label> <input name="txtusage"
                          id="txtusage" class="input-modern" placeholder="Contoh: diminum sesudah makan..."
                          readonly></input> </div> <!-- checkbox -->
                      <div class="full-width">
                        <div class="checkbox-row" style="display:none;"> <label class="checkbox-modern"> <input type="checkbox"
                              name="optnonracikan" id="optnonracikan"
                              onclick="if (checked == true) { document.getElementById('optracikan').checked=false; document.getElementById('hidprscconc').value='N'; }">
                            Non Racikan </label> <label class="checkbox-modern"> <input type="checkbox" name="optracikan"
                              id="optracikan"
                              onclick="if (checked == true) { document.getElementById('optnonracikan').checked=false; document.getElementById('hidprscconc').value='Y'; }">
                            Racikan </label> </div>
                      </div>
                    </div> <!-- button -->
                    <div class="action-row"> <a class="btn-modern btn-save"
                        onclick="javascript: 
                        var ambil = parseInt(document.getElementById('txtstockquty').value); 
                        var tersedia = parseInt(document.getElementById('hidstockamnt').value); if (document.getElementById('txtstockcode').value == '') { swal({ title:'Item Obat Kosong', text:'Anda belum memilih item obat', icon:'warning' }); } else { var inprsccode = document.getElementById('txtprsccode').value; 
                        var inprscdoct = document.getElementById('hidprscdoct').value; var instockcode = document.getElementById('hidstockcode').value; var instockbtch = document.getElementById('hidstockbtch').value; 
                        var instockpric = document.getElementById('hidstockpric').value; 
                        // var instockpricbaru = parseFloat(instockpric) * 1.85;
                        var instockquty = document.getElementById('txtstockquty').value; 
                        var inprscconc = 'N'; 
                        var inprscsgna = document.getElementById('hidsigna').value; 
                        var inmediroom = document.getElementById('hidmediroom').value;
                        var insgnausag = document.getElementById('txtusage').value;
                        input( inprsccode, inprscdoct, instockcode, instockbtch, instockpric, instockquty, inprscconc, inprscsgna, inmediroom, insgnausag ); }">
                        Input Resep </a> <a class="btn-modern btn-close"
                        onclick="javascript:location.href='TRXADRUG00.php'"> Close </a> </div>
                  </div>
                </div>
                                  <div class="card-modern" style="margin-top: 16px;">
                    <div class="card-title"> Input Resep Racikan </div>
                    <div class="card-body">
                      <!-- Form input kepala racikan -->
                      <div class="form-grid" style="display: grid; grid-template-columns: 2fr 2fr 1fr; gap: 10px; align-items: end;">
                        <div>
                          <label class="form-label"> Nama Racikan </label>
                          <input type="text" id="txtracikname" class="input-modern" placeholder="Nama Racikan" autocomplete="off">
                        </div>
                        <div>
                          <label class="form-label"> Signa </label>
                          <div class="autocomplete-wrapper">
                            <input type="text" id="txtraciksigna" class="input-modern" placeholder="Aturan makan..." autocomplete="off"
                              onkeyup="if (value.length > 0) { ambilsignacode_racik(value); } else { document.getElementById('tblsigna_racik').style.display='none'; }">
                            <div id="tblsigna_racik" style="position: absolute; background: white; border-radius: 10px; overflow: auto; box-shadow: 0 8px 10px rgba(0,0,0,.15); border: 1px solid #cbd5e1; z-index: 9999; display:none; width: 100%;"></div>
                            <input type="hidden" id="hidraciksignacode">
                            <input type="hidden" id="hidracikusage">
                          </div>
                        </div>
                        <div>
                          <label class="form-label"> Qty </label>
                          <input type="number" id="txtracikqty" class="input-modern" value="1" min="1">
                        </div>
                      </div>
                      <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                        <button type="button" class="btn-modern btn-save" onclick="tambahRacikanHead()">Tambah Racikan</button>
                      </div>

                      <!-- List Kepala Racikan -->
                      <div style="margin-top: 15px;">
                        <div id="tblracikhead" style="max-height: 150px; overflow: auto;"></div>
                      </div>

                      <!-- Area Komposisi / Detail Obat untuk Racikan Terpilih -->
                      <div id="section_racik_detail" style="margin-top: 15px; border-top: 1px solid #cbd5e1; padding-top: 15px; display: none;">
                        <input type="hidden" id="hidselectedracikid">
                        <div style="font-weight: 700; font-size: 13px; margin-bottom: 10px; color: #166534;" id="lblSelectedRacik">
                          Racikan Terpilih: -
                        </div>
                        
                        <!-- Input Obat ke Racikan -->
                        <div class="form-grid" style="display: grid; grid-template-columns: 3fr 1.5fr; gap: 10px; align-items: end;">
                          <div>
                            <label class="form-label"> Cari Obat </label>
                            <div class="autocomplete-wrapper">
                              <input type="text" id="txtracikstockname" class="input-modern" placeholder="Ketik nama obat..." autocomplete="off"
                                onkeyup="if (value.length > 0) { var regipoli = document.getElementById('hidmediroom').value; var regipaym = document.getElementById('hidregipaym').value; ambilresep_racik(this.value,regipoli,regipaym); } else { document.getElementById('tblresep_racik').innerHTML=''; document.getElementById('tblresep_racik').style.display='none'; }">
                              <div id="tblresep_racik"></div>
                              <input type="hidden" id="hidracikstockcode">
                              <input type="hidden" id="hidracikstockbtch">
                              <input type="hidden" id="hidracikstockpric">
                              <input type="hidden" id="hidracikstockamnt">
                            </div>
                          </div>
                          <div>
                            <label class="form-label"> Qty </label>
                            <input type="text" id="txtracikstockqty" class="input-modern" value="1">
                          </div>
                        </div>
                        <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                          <button type="button" class="btn-modern btn-save" onclick="tambahObatKeRacikan()">Tambah Obat Ke Racikan</button>
                        </div>

                        <!-- List Detail Obat dalam Racikan Terpilih -->
                        <div style="margin-top: 15px;">
                          <div id="tblracikdetail" style="max-height: 150px; overflow: auto;"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                <!-- ============================================= DAFTAR ITEM RESEP ============================================== -->
                <div class="card-modern recipe-table-wrapper">
                  <div class="card-title"> Daftar Item Resep </div>
                  <div class="card-body">
                    <div class="recipe-table-scroll">
                      <div id="tblscreen"></div>
                    </div>
                    <!-- <div class="total-panel">
                      <div class="total-box"> Total Resep </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- ========================= MODERN FORM LAYOUT END ========================= -->

          <div class="footerdate">
            <span class="labelTime Time"><b>Date :</b> <?php $tgl = date('d-m-Y');
            echo $tgl; ?></span>
          </div>
          <div class="footertime">
            <span class="labelTime Time" id="timestamp"></span>
          </div>


        </div><!-- div main -->
      </div><!-- div layout -->
      <script src="js/TRXADRUG00.js?v=<?php echo time(); ?>"></script>
      <script src="js/ui.js"></script>
      <script>
        function playNotif() {
          var audio =
            document.getElementById(
              'notifAudio'
            );

          audio.currentTime = 0;

          audio.play();
        }

        // setInterval(
        //   cekResepBaru,
        //   3000
        // );
      </script>

  </body>

  </html>
  <?php
} else {
  header("Location: " . "signin.php");
}
?>


