<!doctype html>
<?php include "conf/config.php";
include "inc/sanie.php";
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
    <title>Pasien berobat</title>
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
        --primary: #10b981;
        --primary-dark: #059669;
        --bg: #f8fafc;
        --card: #ffffff;
        --border: #e2e8f0;
        --text: #0f172a;
        --muted: #64748b;
      }

      .content-modern {
        margin-top: 20px;
      }

      .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        align-items: start;
      }

      .right-grid {
        display: grid;
        gap: 20px;
      }

      .card-modern {
        background: #fff;
        border-radius: 18px;
        padding: 16px 18px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        border: 1px solid #edf2f7;
      }

      .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 14px;
      }

      .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }

      .form-group {
        display: flex;
        flex-direction: column;
      }

      .form-group.full {
        grid-column: 1 / -1;
      }

      .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
      }

      .form-control {
        height: 38px;
        border: 1px solid #dbe2ea;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 13px;
        transition: .2s;
      }

      textarea.form-control {
        height: 60px;
        padding-top: 12px;
        resize: none;
      }

      .form-control:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, .15);
      }

      .form-control[readonly] {
        background: #f8fafc;
      }

      .action-group {
        display: flex;
        gap: 12px;
        margin-top: 14px;
      }

      .btn-modern {
        border: none;
        height: 44px;
        padding: 0 20px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
      }

      .btn-modern:hover {
        transform: translateY(-1px);
      }

      .btn-save {
        background: #10b981;
        color: white;
      }

      .btn-reset {
        background: #f59e0b;
        color: white;
      }

      .btn-refresh {
        background: #0ea5e9;
        color: white;
      }

      .queue-box {
        text-align: center;
      }

      .queue-number {
        font-size: 60px;
        font-weight: 800;
        color: #10b981;
        margin: 10px 0;
      }

      .queue-estimation {
        color: #64748b;
        font-size: 14px;
      }

      .table-wrapper {
        overflow: auto;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
      }

      .search-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 6px;
        z-index: 999;
        width: 100%;
        background: white;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        overflow: auto;
        max-height: 300px;
        /* border: 1px solid #e2e8f0; */
        animation: dropdownFade .15s ease;
      }

      @keyframes dropdownFade {
        from {
          opacity: 0;
          transform: translateY(-4px);
        }

        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @media(max-width:1100px) {

        .main-grid {
          grid-template-columns: 1fr;
        }

        .form-grid {
          grid-template-columns: 1fr;
        }

      }
    </style>

  </head>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script src="js/sweetalert.min.js"></script>

  <script>
    $(document).ready(function () {
      setInterval(timestamp, 1000);
    });
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function (data) { $('#timestamp').html(data); }, }); }
  </script>

  <body onLoad="periksaakses('PASS_REGI_ENTR'); ambilscreen('');

  setTimeout(function(){

  document.getElementById('dataPasien').scrollIntoView({
    behavior:'smooth',
    block:'start'  
  });

  },300);
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

            <li class="pure-menu-item menu-item-divided pure-menu-selected"
              onclick="javascript: location.href = 'index.php'">
              <a class="pure-menu-link">ADMISI</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPATI06.php'">
              <a class="pure-menu-link">Harga</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'REPOPATI01.php'">
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI01.php'">
                <a class="pure-menu-link">
                  Daftar Pasien
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled" onclick="document">
                Pasien Berobat
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI07.php'">
                <a class="pure-menu-link">
                  TTV & Antropometri
                </a>
              </li>
              <!-- 
              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI03.php'">
                <a class="pure-menu-link">
                Ruangan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI04.php'">
                <a class="pure-menu-link">
                Jadwal Dokter
                </a>
              </li> -->
            </ul>
          </div>
          <!-- Tab Menu -->

          <!-- Form Input -->
          <div class="content-modern">

            <div class="main-grid">

              <!-- LEFT -->
              <div>

                <div class="card-modern" id="dataPasien">

                  <div class="card-title">
                    🧑 Data Pasien
                  </div>

                  <div class="form-grid">

                    <div class="form-group full" style="position:relative;">

                      <label class="form-label">
                        Cari Pasien
                      </label>

                      <input type="text" name="txtsearch" id="txtsearch" class="form-control"
                        placeholder="Cari Nama Pasien / Tanggal Lahir" autocomplete="off" onkeyup="
                        if (value.length > 1)
                        {
                          ambilpaticode(this.value);
                        }
                        else
                        {
                          document.getElementById('tblpati').style.display='none';
                        }
                        ">
                      <div id="tblpati" class="search-dropdown" style="display:none;"></div>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Tanggal Berobat
                      </label>

                      <input type="date" name="tglregidate" id="tglregidate" class="form-control"
                        value="<?php echo $datenow; ?>">

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        No Rekam Medis
                      </label>

                      <input type="text" name="txtmastcode" id="txtmastcode" class="form-control" readonly>

                      <input type="hidden" name="hidpaticode" id="hidpaticode">

                    </div>

                    <div class="form-group full">

                      <label class="form-label">
                        Nama Pasien
                      </label>

                      <input type="text" name="txtmainname" id="txtmainname" class="form-control" readonly>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Tanggal Lahir
                      </label>

                      <input type="text" name="txtmainbirt" id="txtmainbirt" class="form-control" readonly>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Jenis Kelamin
                      </label>

                      <input type="text" name="txtmaingend" id="txtmaingend" class="form-control" readonly>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Golongan Darah
                      </label>

                      <input type="text" name="txtmainblod" id="txtmainblod" class="form-control" readonly>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Kontak
                      </label>

                      <input type="text" name="txtmainphne" id="txtmainphne" class="form-control" readonly>

                    </div>

                    <div class="form-group full">

                      <label class="form-label">
                        Alamat
                      </label>

                      <textarea name="txtmainaddr" id="txtmainaddr" class="form-control" readonly></textarea>

                    </div>

                  </div>

                </div>

              </div>


              <!-- RIGHT -->
              <div class="right-grid">

                <!-- DETAIL -->
                <div class="card-modern" id="regidoct">

                  <div class="card-title">
                    🏥 Detail Kunjungan
                  </div>

                  <div class="form-grid">

                    <div class="form-group full" style="position:relative;">

                      <label class="form-label">
                        Dokter / Bidan
                      </label>

                      <input type="text" name="txtregidoct" id="txtregidoct" class="form-control"
                        placeholder="Cari Dokter" autocomplete="off" onkeyup="
                          if (value.length > 0)
                          {
                            ambildoctuser(this.value);
                          }
                          else
                          {
                            document.getElementById('tbluser').style.visibility='hidden';
                          }
                          ">
                      <input type="hidden" name="hidregidoct" id="hidregidoct">

                      <div id="tbluser" class="search-dropdown" style="visibility:hidden;"></div>

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Poli
                      </label>

                      <input type="text" name="txtregipoli" id="txtregipoli" class="form-control" readonly>

                      <input type="hidden" name="hidregipoli" id="hidregipoli">

                    </div>

                    <div class="form-group">

                      <label class="form-label">
                        Pembayaran
                      </label>

                      <select name="optregipaym" id="optregipaym" class="form-control" onchange="
                      if(this.value == 'B'){
                      document.getElementById('hidregifee').value='N';
                      document.getElementById('txtregifeeview').value='Tidak';}
                      else{document.getElementById('hidregifee').value='Y';
                      document.getElementById('txtregifeeview').value='Ya';}
                      ">

                        <option value="">- PILIH -</option>
                        <option value="U">Umum</option>
                        <option value="B">BPJS</option>
                        <option value="A">Asuransi</option>
                        <option value="P">Perusahaan</option>
                        <option value="H">Halodoc</option>

                      </select>

                    </div>

                    <div class="form-group full">

                      <label class="form-label">
                        Biaya Admin
                      </label>

                      <!-- <select name="hidregifee" id="hidregifee" class="form-control" readonly>

                        <option value="">- PILIH -</option>
                        <option value="Y">Ya</option>
                        <option value="N">Tidak</option>

                      </select> -->
                      <input type="text" id="txtregifeeview" class="form-control" readonly>

                      <input type="hidden" id="hidregifee">

                    </div>



                  </div>

                  <div class="action-group">

                    <button type="button" class="btn-modern btn-save" onclick="
                    if(document.getElementById('hidpaticode').value.length == 0)
                    {
                      swal({
                        title:'Pasien belum dipilih',
                        text:'Silakan pilih pasien dulu',
                        icon:'warning'
                      });
                    }
                    else if(document.getElementById('hidregidoct').value.length == 0)
                    {
                      swal({
                        title:'Dokter belum dipilih',
                        text:'Silakan pilih dokter',
                        icon:'warning'
                      });
                    }
                    else
                    {
                      var inpaticode = document.getElementById('hidpaticode').value;
                      var inregidate = document.getElementById('tglregidate').value;
                      var inregifrom = 'A';
                      var inregipaym = document.getElementById('optregipaym').value;
                      var inregidoct = document.getElementById('hidregidoct').value;
                      var inregipoli = document.getElementById('hidregipoli').value;
                      var inregifee = document.getElementById('hidregifee').value;

                      input(
                        inpaticode,
                        inregidate,
                        inregifrom,
                        inregipaym,
                        inregidoct,
                        inregipoli,
                        inregifee
                      );
                    }
                    ">
                      Simpan
                    </button>

                    <button type="reset" class="btn-modern btn-reset">
                      Reset
                    </button>

                    <button type="button" onclick="location.reload();" class="btn-modern btn-refresh">
                      Refresh
                    </button>

                  </div>

                </div>

                <!-- ANTRIAN -->
                <div class="card-modern">

                  <div class="card-title">
                    🎫 Antrian
                  </div>

                  <div class="queue-box">

                    <div style="font-size:14px;color:#64748b;">
                      Nomor Antrian Anda
                    </div>

                    <div class="queue-number" id="queueNumber">
                      -
                    </div>

                    <div class="queue-estimation">
                      Estimasi Dilayani ± 15 Menit
                    </div>
                    <div class="action-group">
                      <button id="btnPrintAntrian" class="btn-modern btn-save" style="width:100%;margin-top:10px;"
                        onclick="printAntrian();">
                        Cetak
                      </button>

                      <button id="btnSkipAntrian" class="btn-modern btn-reset" style="width:100%;margin-top:10px;"
                        onclick="resetFormAfterPrint();">
                        Skip
                      </button>
                    </div>

                  </div>

                </div>

              </div>

            </div>


            <!-- TABLE -->
            <div class="card-modern" style="margin-top:20px;">

              <div class="card-title">
                📋 Daftar Pasien
              </div>

              <input type="text" class="form-control" placeholder="Cari Pasien..." autocomplete="off"
                style="max-width:250px;margin-bottom:20px;" onkeyup="
                if (value.length < 16)
                {
                  ambilscreen(this.value);
                }
                else
                {
                  ambilscreen('');
                }
                ">

              <div class="table-wrapper">
                <div id="tblscreen">
                </div>
              </div>
            </div>
          </div>

          <div id="tbluser" style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100"></div>

          <div id="tblpati" style="position: absolute; 
                 top: 300px;
                 left: calc(70% - 250px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100"></div>

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

    <script src="js/TRXAPATI02.js?v=<?php echo time(); ?>"></script>
    <script src="js/ui.js"></script>

  </body>

  </html>
  <?php
} else {
  header("Location: " . "signin.php");
}
?>