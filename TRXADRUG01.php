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
    <title>Farmasi</title>
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

      .button-print {
        background: rgb(223, 117, 20);
        /* this is an orange */
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
        --shadow: 0 2px 6px rgba(15, 23, 42, .04),
          0 8px 24px rgba(15, 23, 42, .06);
        --radius: 16px;
      }

      .content {
        background: var(--bg);
        padding: 20px;
      }

      .card-modern {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 16px;
      }

      .card-title {
        padding: 12px 16px;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
      }

      .card-body {
        padding: 14px;
      }

      .input-modern {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 13px;
      }

      .input-modern:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, .12);
      }

      #resepdetail {
        margin-top: 16px;
      }

      /* Modal */
      .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, .45);
        backdrop-filter: blur(4px);
      }

      .modal-content {
        background: #fff;
        width: 92%;
        max-width: 650px;
        margin: 60px auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow:
          0 25px 50px rgba(15, 23, 42, .18);
      }

      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: linear-gradient(90deg,
            #16a34a,
            #22c55e);
      }

      .modal-title {
        color: white;
        font-size: 16px;
        font-weight: 700;
      }

      .modal-close {
        border: none;
        background: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
      }

      .modal-content {
        padding-bottom: 20px;
      }

      .form-group {
        padding: 0 20px;
        margin-top: 16px;
      }

      .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
      }

      .form-group input,
      .form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13px;
      }

      .form-group input:focus,
      .form-group select:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, .12);
      }

      .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
      }

      .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 20px;
        margin-top: 10px;
      }

      .btn-modal-cancel {
        border: none;
        border-radius: 10px;
        background: #e2e8f0;
        color: #334155;
        padding: 10px 16px;
        cursor: pointer;
        font-weight: 700;
      }

      .btn-modal-save {
        border: none;
        border-radius: 10px;
        background: #16a34a;
        color: white;
        padding: 10px 18px;
        cursor: pointer;
        font-weight: 700;
      }

      .btn-modal-save:hover {
        background: #15803d;
      }
      /* End Modal */

      /* Punya Detail */
      .detail-card {
        background: #fff;
        border: 1px solid #dbe4ee;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(15, 23, 42, .04),
          0 8px 24px rgba(15, 23, 42, .06);
      }

      .detail-title {
        padding: 12px 16px;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        color: white;
        font-weight: 700;
      }

      .detail-body {
        padding: 16px;
      }

      #tbldetail {
        width: 100%;
        border-collapse: collapse;
      }

      #tbldetail th {
        background: #f8fafc;
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
      }

      #tbldetail td {
        padding: 10px;
        border-bottom: 1px solid #f1f5f9;
      }

      .btn-edit {
        background: #dbeafe;
        color: #1d4ed8;
      }

      .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
      }

      .btn-edit,
      .btn-delete {
        border: none;
        border-radius: 8px;
        padding: 6px 10px;
        cursor: pointer;
        margin-right: 5px;
      }

      .btn-siapkan {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 18px;
        font-weight: 700;
        cursor: pointer;
      }

      /* end punya detail */
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

  <body onLoad="periksaakses('PASS_DRUG_ENTR'); 
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
              <a class="pure-menu-link">FARMASI</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
              <a class="pure-menu-link">Transaksi</a>
            </li>


            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADRUG04.php'">
              <a class="pure-menu-link">Report</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG00.php'">
                <a class="pure-menu-link">
                  Input Resep
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Penyerahan Obat
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
          <!-- Tab Menu -->

          <div class="card-modern">
            <div class="card-title">
              Daftar Resep Masuk
            </div>

            <div class="card-body">
              <input type="text" id="txtsearch" autocomplete="off" class="input-modern" name="txtsearch"
                placeholder="Cari Pasien / No Antrian..." maxlength="20"
                onkeyup="if (value.length > 0) { ambilscreen(this.value); } else {ambilscreen('')};">
              <div style="margin-top:15px">
                <div id="tblscreen"></div>
              </div>
            </div>
          </div>

          <div id="resepdetail" style="display:none;margin-top:15px">
          </div>



          <div id="modalEditObat" class="modal">

            <div class="modal-content">

              <div class="modal-header">

                <div class="modal-title">
                  Edit Obat
                </div>

                <button type="button" class="modal-close" onclick="closemodal()">
                  ×
                </button>

              </div>

              <input type="hidden" id="edit_prsccode">
              <input type="hidden" id="edit_stockcode">

              <div class="form-group">
                <label>Nama Obat</label>
                <input type="text" id="edit_stockname" readonly>
              </div>

              <div class="form-grid">

                <div class="form-group">
                  <label>Qty</label>
                  <input type="number" id="edit_qty">
                </div>

                <div class="form-group">
                  <label>Jenis</label>
                  <select id="edit_conc">
                    <option value="N">Non Racikan</option>
                    <option value="Y">Racikan</option>
                  </select>
                </div>

              </div>

              <div class="form-group">
                <label>Batch</label>
                <input type="text" id="edit_batch" readonly>
              </div>

              <div class="modal-footer">

                <button type="button" class="btn-modal-cancel" onclick="closemodal()">

                  Batal

                </button>

                <button type="button" class="btn-modal-save" onclick="simpanobat()">

                  Simpan Perubahan

                </button>

              </div>

            </div>

          </div>

          </form>

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
    <script src="js/TRXADRUG01.js"></script>
    <script src="js/ui.js"></script>

  </body>

  </html>
  <?php
} else {
  header("Location: " . "signin.php");
}
?>