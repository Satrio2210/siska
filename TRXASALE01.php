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
    <title>Pembayaran Pasien</title>
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

      .button-print {
        background: rgb(223, 117, 20);
        /* this is an orange */
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

  <body onLoad="periksaakses('PASS_SALE_ENTR'); 
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
              <a class="pure-menu-link">KASIR</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
              <a class="pure-menu-link">Transaksi</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXASALE03.php'">
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

              <li class="pure-menu-item pure-menu-disabled">
                Pembayaran
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXASALE02.php'">
                <a class="pure-menu-link">
                  Kwitansi
                </a>
              </li>

            </ul>
          </div>
          <!-- Tab Menu -->

          <!-- Form Input -->
          <form name="frmtrxasale" class="pure-form pure-form-aligned" method="post" action="TRXASALE01P.php">
            <fieldset>

              <div class="pure-control-group">

                <input type="hidden" name="hidregicode" id="hidregicode">
                <input type="hidden" name="hidpaticode" id="hidpaticode">
                <input type="hidden" name="hidregidoct" id="hidregidoct">
                <input type="hidden" name="hidregipoli" id="hidregipoli">
                <input type="hidden" name="hidregipaym" id="hidregipaym">

                <input type="hidden" name="hidpaymtota" id="hidpaymtota">

                <label for="txtpaymtota">Total Tagihan :</label>
                <input type="text" name="txtpaymtota" id="txtpaymtota" maxlength="20"
                  style="width: 200px; font-size: 30px;" readonly="true">

                <label for="txtpaymamnt">Total di Bayar :</label>
                <input type="text" name="txtpaymamnt" id="txtpaymamnt" autocomplete="off" maxlength="20"
                  style="width: 200px; font-size: 30px;" value="0" onkeydown="if (event.keyCode == 13 && value.length > 0) 
              {
                if (isNaN(this.value)) 
                   {
                     document.getElementById('txtpaymamnt').value = '0';
                     document.getElementById('txtpaymamnt').focus();                          
                   }
                else
                  {
                    var inRupiah = convertToRupiah(this.value);
                    document.getElementById('txtpaymamnt').value = inRupiah;
                    document.getElementById('txtpaymdisc').focus();
                  }
              }" onclick="if (isNaN(this.value)) 
              {
                var inAngka = convertToAngka(this.value);
                document.getElementById('txtpaymamnt').value = inAngka;
                document.getElementById('txtpaymamnt').focus();
              }
            ">

                <label for="txtpaymdisc">Diskon :</label>
                <input type="text" name="txtpaymdisc" id="txtpaymdisc" maxlength="10" style="width: 160px" value="0"
                  onkeydown="if (event.keyCode == 13 && value.length > 0) 
              {
                if (isNaN(this.value)) 
                  {
                    document.getElementById('txtpaymdisc').value = '0';
                    document.getElementById('txtpaymdisc').focus();                          
                  }
                else
                  {
                    var inRupiah = convertToRupiah(this.value);
                    document.getElementById('txtpaymdisc').value = inRupiah;
                    document.getElementById('optpaymmode').focus();
                  }
              }" onclick="if (isNaN(this.value)) 
              {
                var inAngka = convertToAngka(this.value);
                document.getElementById('txtpaymdisc').value = inAngka;
                document.getElementById('txtpaymdisc').focus();
              }
            ">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="optpaymmode">Cara Bayar :</label>
                <select name="optpaymmode" id="optpaymmode" onchange="document.getElementById('optpaymmode').focus();">
                  <option value="TUN">Tunai/Cash</option>
                  <option value="BCA">Debit BCA</option>
                  <option value="MAN">Debit Mandiri</option>
                  <option value="BNI">Debit BNI</option>
                  <option value="BCM">Transfer BCA</option>
                  <option value="LIN">Transfer Link Aja</option>
                </select>

                <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtpaymtota').value == '')
                  {
                    swal({
                        title: 'Total yang harus di bayar Kosong' ,
                        text: 'Anda belum memilih Pasien yang akan melakukan pembayaran',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtpaymtota').value <= 0)
                  {
                    swal({
                        title: 'Telah di lakukan Pembayaran' ,
                        text: 'Pasien telah melakukan pembayaran, konfirmasikan ke Admisi untuk di tutup',
                        icon: 'warning',
                        });
                  }

                else if (isNaN(document.getElementById('txtpaymamnt').value)) 
                  {
                    swal({
                        title: 'Salah Input Angka' ,
                        text: 'Masukkan Nominal Angka , silahkan periksa lagi',
                        icon: 'warning',
                        });
                  }

                else if (document.getElementById('txtpaymamnt').value <= 0)
                  {
                    swal({
                        title: 'Pembayaran Nol ' ,
                        text: 'Isi kembali Nominal pembayaran, silahkan periksa lagi',
                        icon: 'warning',
                        });
                  }

                else if (document.getElementById('txtpaymamnt').value < document.getElementById('hidpaymtota').value)
                  {
                    swal({
                        title: 'Pembayaran Kurang ' ,
                        text: 'Isi kembali Nominal pembayaran, silahkan periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtpaymamnt').value == '')
                  {
                      swal({
                          title: 'Nominal Pembayaran Kosong' ,
                          text: 'Anda belum mengisi Nominal Pembayaran, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (document.getElementById('txtpaymdisc').value == '')
                  {
                      swal({
                          title: 'Nominal Diskon Pembayaran Kosong' ,
                          text: 'Anda belum mengisi Nominal Diskon Pembayaran, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inregicode = document.getElementById('hidregicode').value;
                       var inpaticode = document.getElementById('hidpaticode').value;

                       var inregidoct = document.getElementById('hidregidoct').value;
                       var inregipoli = document.getElementById('hidregipoli').value;
                       var inregipaym = document.getElementById('hidregipaym').value;

                       var inpaymtota = document.getElementById('txtpaymtota').value; 
                       var inpaymamnt = document.getElementById('txtpaymamnt').value;

                       var inpaymdisc = document.getElementById('txtpaymdisc').value;
                       var inpaymmode = document.getElementById('optpaymmode').value;

                       //alert('ok sudah benar');
                       input(inregicode,inpaticode,inregidoct,inregipoli,inregipaym,inpaymtota,inpaymamnt,inpaymdisc,inpaymmode);
                    }
        ">Bayar!</a>

              </div><!-- pure-control-group -->

            </fieldset>

            <fieldset>
              <label for="txtregicode">Cari Pasien</label>
              <input type="text" class="pure-input-rounded" name="txtregicode" id="txtregicode" maxlength="20"
                style="width: 200px;" onkeyup="if (value.length > 0) { ambilscreen(this.value); };" onkeydown="if (event.keyCode == 13 && value.length > 13) 
                        { 
                        document.getElementById('txtregicode').value = '';
                        document.getElementById('txtregicode').focus()
                        }">
            </fieldset>

            <fieldset>
              <div id="tblscreen">
            </fieldset>

            <fieldset>
              <div id="tblviewinvc" style="position: absolute; 
                 top: 400px;
                 left: calc(80% - 900px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
            </fieldset>

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
    <script src="js/TRXASALE01.js"></script>
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