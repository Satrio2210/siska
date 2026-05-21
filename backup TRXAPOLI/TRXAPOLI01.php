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

          <!-- Form Input -->
          <form name="frmtrxapoli" class="pure-form pure-form-aligned" method="post" action="">
            <fieldset>

              <div class="pure-control-group">

                <label for="txtregidate">Tgl. Berkunjung :</label>
                <input type="text" name="txtregidate" id="txtregidate" maxlength="14" style="width: 150px;"
                  readonly="true">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtexamcode">No. Daftar :</label>
                <input type="text" name="txtexamcode" id="txtexamcode" maxlength="50" style="width: 250px;"
                  readonly="true">

                <input type="hidden" name="hidexamdoct" id="hidexamdoct" value="<?php echo $user; ?>">

                <label for="txtpaticode">Rekam Medis :</label>
                <input type="text" name="txtpaticode" id="txtpaticode" maxlength="10" style="width: 150px;"
                  readonly="true">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtmainname">Nama :</label>
                <input type="text" name="txtmainname" id="txtmainname" maxlength="50" style="width: 250px;"
                  readonly="true">

                <label for="txtmaingend">L/P :</label>
                <input type="text" name="txtmaingend" id="txtmaingend" maxlength="10" style="width: 150px;"
                  readonly="true">


              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtmainage">Usia :</label>
                <input type="text" name="txtmainage" id="txtmainage" maxlength="50" style="width: 250px;" readonly="true">

                <label for="txtbirtdate">Tgl Lahir :</label>
                <input type="text" name="txtbirtdate" id="txtbirtdate" maxlength="14" style="width: 150px;"
                  readonly="true">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtmainaddr">Alamat :</label>
                <input type="text" name="txtmainaddr" id="txtmainaddr" maxlength="50" style="width: 500px;"
                  readonly="true">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtregipaym">Pembayaran :</label>
                <input type="text" name="txtregipaym" id="txtregipaym" maxlength="50" style="width: 150px;"
                  readonly="true">

              </div><!-- pure-control-group -->


              <div class="pure-control-group">

                <label for="txtexamhght">Tinggi (cm) :</label>
                <input type="text" name="txtexamhght" id="txtexamhght" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {

                                  document.getElementById('txtexamwght').focus();
                                }">

                <label for="txtexamwght">Berat (kg) :</label>
                <input type="text" name="txtexamwght" id="txtexamwght" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamblod').focus();
                            }">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="">Lingkar Perut (cm) :</label>
                <input type="text" name="" id="" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {

                                  document.getElementById('').focus();
                                }" disabled>

                <label for="">IMT (kg/m2) :</label>
                <input type="text" name="" id="" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('').focus();
                            }" disabled>

              </div><!-- pure-control-group -->


              <div class="pure-control-group">

                <label for="txtexamblod">Tekanan Darah (mmHg) :</label>
                <input type="text" name="txtexamblod" id="txtexamblod" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamtemp').focus();
                            }">

                <label for="txtexamtemp">Suhu (celcius) :</label>
                <input type="text" name="txtexamtemp" id="txtexamtemp" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamanam').focus();
                            ">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="">Respiratory Rate (/minute) :</label>
                <input type="text" name="" id="" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('').focus();
                            }" disabled>

                <label for="">Heart Rate (bpm) :</label>
                <input type="text" name="" id="" maxlength="10" style="width: 100px;" onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('').focus();
                            " disabled>

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidmedialle">Alergi Obat :</label>

                <label for="optmedialle-no">Tidak Ada</label>
                <input type="checkbox" checked="checked" name="optmedialle-no" id="optmedialle-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optmedialle-yes').checked = false;
                              document.getElementById('hidmedialle').value = 'N';
                          }                
                        ">
                <label for="optmedialle-yes">Ada</label>
                <input type="checkbox" name="optmedialle-yes" id="optmedialle-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optmedialle-no').checked = false;
                              document.getElementById('hidmedialle').value = 'Y';
                          }                
                        ">

                <input name="hidmedialle" id="hidmedialle" type="hidden">


              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidfoodalle">Alergi Makanan :</label>

                <label for="optfoodalle-no">Tidak Ada</label>
                <input type="checkbox" checked="checked" name="optfoodalle-no" id="optfoodalle-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optfoodalle-yes').checked = false;
                              document.getElementById('hidfoodalle').value = 'N';
                          }                
                        ">
                <label for="optfoodalle-yes">Ada</label>
                <input type="checkbox" name="optfoodalle-yes" id="optfoodalle-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optfoodalle-no').checked = false;
                              document.getElementById('hidfoodalle').value = 'Y';
                          }                
                        ">

                <input name="hidfoodalle" id="hidfoodalle" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidchrodsse">Penyakit Kronis :</label>

                <label for="optchrodsse-no">Tidak Ada</label>
                <input type="checkbox" checked="checked" name="optchrodsse-no" id="optchrodsse-no" value="true"
                  <!--onclick="if (checked == true) -->
                          <!--    {-->
                          <!--        document.getElementById('optchrodsse-yes').checked = false;-->
                          <!--        document.getElementById('hidchrodsse').value = 'N';-->
                          <!--    }                -->
                            ">
                <label for="optchrodsse-yes">Ada</label>
                <input type="checkbox" name="optchrodsse-yes" id="optchrodsse-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optchrodsse-no').checked = false;
                              document.getElementById('hidchrodsse').value = 'Y';
                          }                
                        ">

                <input name="hidchrodsse" id="hidchrodsse" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidothrdsse">Penyakit Lainnya :</label>

                <label for="optothrdsse-no">Tidak Ada</label>
                <input type="checkbox" checked="checked" name="optothrdsse-no" id="optothrdsse-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optothrdsse-yes').checked = false;
                              document.getElementById('hidothrdsse').value = 'N';
                          }                
                        ">
                <label for="optothrdsse-yes">Ada</label>
                <input type="checkbox" name="optothrdsse-yes" id="optothrdsse-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optothrdsse-no').checked = false;
                              document.getElementById('hidothrdsse').value = 'Y';
                          }                
                        ">

                <input name="hidothrdsse" id="hidothrdsse" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidpaticare">Rawat Inap :</label>

                <label for="optpaticare-no">Tidak</label>
                <input type="checkbox" checked="checked" name="optpaticare-no" id="optpaticare-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpaticare-yes').checked = false;
                              document.getElementById('hidpaticare').value = 'N';
                          }                
                        ">
                <label for="optpaticare-yes">Ya</label>
                <input type="checkbox" name="optpaticare-yes" id="optpaticare-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpaticare-no').checked = false;
                              document.getElementById('hidpaticare').value = 'Y';
                          }                
                        ">

                <input name="hidpaticare" id="hidpaticare" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidpatisurge">Operasi :</label>

                <label for="optpatisurge-no">Tidak</label>
                <input type="checkbox" checked="checked" name="optpatisurge-no" id="optpatisurge-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpatisurge-yes').checked = false;
                              document.getElementById('hidpatisurge').value = 'N';
                          }                
                        ">
                <label for="optpatisurge-yes">Ya</label>
                <input type="checkbox" name="optpatisurge-yes" id="optpatisurge-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpatisurge-no').checked = false;
                              document.getElementById('hidpatisurge').value = 'Y';
                          }                
                        ">

                <input name="hidpatisurge" id="hidpatisurge" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="hidpatismoke">Merokok :</label>

                <label for="optpatismoke-no">Tidak</label>
                <input type="checkbox" checked="checked" name="optpatismoke-no" id="optpatismoke-no" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpatismoke-yes').checked = true;
                              document.getElementById('hidpatismoke').value = 'N';
                          }                
                        ">
                <label for="optpatismoke-yes">Ya</label>
                <input type="checkbox" name="optpatismoke-yes" id="optpatismoke-yes" value="true" onclick="if (checked == true) 
                          {
                              document.getElementById('optpatismoke-no').checked = false;
                              document.getElementById('hidpatismoke').value = 'Y';
                          }                
                        ">

                <input name="hidpatismoke" id="hidpatismoke" type="hidden">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtexamanam">Keluhan :</label>

                <textarea id="txtexamkeluh" name="txtexamkeluh" rows="4" cols="30" disabled>BELUM DAPAT DI ISI!!!!
              
                </textarea>

                <label for="txtexamanam">Anamnesa :</label>

                <textarea id="txtexamanam" name="txtexamanam" rows="4" cols="30">

                </textarea>

              </div>


              <div class="pure-control-group">

                <label for="txtexambody">Pemeriksaan Fisik :</label>

                <textarea id="txtexambody" name="txtexambody" rows="4" cols="30">

                </textarea>

                <label for="txtexambody">Terapi None Obat :</label>

                <select disabled>
                  <option value="js">Perbanyak Minum Air Putih</option>
                  <option value="py">Istirahat</option>
                  <option value="java">Makan</option>
                </select>

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

                <label for="txtlistdiag">Diagnosa :</label>

                <input type="text" name="txtlistdiag" id="txtlistdiag" maxlength="200" style="width: 400px;"
                  autocomplete="off" onkeyup="
                  if (value.length > 0) {
                    let regicode = document.getElementById('txtexamcode').value;  
                    ambildiagnosa(regicode,this.value);
                  } else { 
                    document.getElementById('tbllistdiag').style.visibility = 'hidden';
                  }">

              </div><!-- pure-control-group -->
              <!--new-->
              <div class="pure-control-group">

                <div id="tbldiagnosa" style="
                     width: 400px;
                     background-color: white; 
                     visibility: hidden; 
                     height: 150px;
                     ">
                </div>

                <div class="pure-control-group">

                  <label for="txtexamdiag">Note Diagnosa :</label>

                  <textarea id="txtexamdiag" name="txtexamdiag" rows="4" cols="30">

                </textarea>

                  <label for="txtexamprsc">Resep :</label>

                  <textarea id="txtexamprsc" name="txtexamprsc" rows="4" cols="30">

                </textarea>


                </div><!-- pure-control-group -->

            </fieldset>
            <fieldset>
              <a class="pure-button pure-button-primary" onclick="javascript:
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

                       var inexamblod = document.getElementById('txtexamblod').value;
                       var inexamtemp = document.getElementById('txtexamtemp').value;

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

                       input(inexamcode,inexamdoct,inexamhght,inexamwght,inexamblod,inexamtemp,inmedialle,infoodalle,inchrodsse,inothrdsse,inpaticare,inpatisurge,inpatismoke,inexamanam,inexambody,inexamdiag,inexamprsc);
                       
                       document.getElementById('tblrekammedis').style.visibility = 'hidden';
                       document.getElementById('tblrekammedis').innerHTML = '';

                    }
        ">Submit</a>

                      <!-- Dropdown Pilihan Surat -->
            <select id="jenis_surat" class="pure-input-1-2">
              <option value="">-- CETAK SURAT --</option>
              <option value="SKBW">SKBW</option>
              <option value="SURAT_SEHAT">Surat Sehat</option>
              <option value="SURAT_KETERANGAN">Surat Keterangan</option>
            </select>

            <!-- Tombol Cetak -->
            <button type="button" class="pure-button button-view" onclick="cetakSurat()">
              Cetak
            </button>

            </fieldset>
            <h2> REKAM MEDIS </h2>
            <fieldset>
              <div id="tblrekammedis">
            </fieldset>

            <fieldset>
              <div id="tblscreen" style="position: absolute; 
                 top: 200px;
                 left: calc(80% - 300px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
            </fieldset>

            <fieldset>
              <div id="tbllistdiag" style="position: absolute; 
                 top: 600px;
                 left: calc(60% - 700px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
            </fieldset>

            <!--<fieldset>-->
            <!--    <div id="tbldiagnosa"-->
            <!--        style="position: absolute; -->
            <!--           top: 600px;-->
            <!--           left: calc(80% - 300px);-->
            <!--           background-color: white; -->
            <!--           visibility: hidden; -->
            <!--           z-index: 100;-->
            <!--           height: 200px">-->
            <!--</fieldset>-->


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