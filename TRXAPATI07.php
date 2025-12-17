<!doctype html>
<?php include "conf/config.php";
include "inc/sanie.php";
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
	$user = $_SESSION['username'];

?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Sistem Informasi Klinik Pratama">
<title>Pemeriksaan Awal Pasien</title>
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
<script src="js/sweetalert.min.js"></script>

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_REGI_ENTR'); 
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

            		<a class="pure-menu-heading" href="#"><?php echo $_SESSION['username'];?></a>
				<ul class="pure-menu-list">

              <li class="pure-menu-item menu-item-divided pure-menu-selected" onclick="javascript: location.href = 'index.php'">
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
            <img align="right" 
                 height= "<?php echo $width_logo;?>" 
                 width= "<?php echo $height_logo;?>" 
                 src="img/logo.png" 
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI02.php'">
                <a class="pure-menu-link">
                Pasien Berobat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI03.php'">
                <a class="pure-menu-link">
                Ruangan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI04.php'">
                <a class="pure-menu-link">
                Jadwal Dokter
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Pasien Periksa
              </li>



            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxaregi" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">
              <input type="hidden" name="hidexamcode" id="hidexamcode">

            <label for="tglregidate">Tanggal Berobat :</label>
              <input type="date" name="tglregidate" id="tglregidate" readonly="true">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtmainname">Nama Pasien :</label>
                <input type="text" 
                  name="txtmainname" 
                  id="txtmainname" 
                  maxlength ="50"
                  style="width: 300px;"
                  readonly="true"> 

            <label for="txtmastcode">Rekam Medis :</label>
                <input type="text" 
                  name="txtmastcode" 
                  id="txtmastcode" 
                  maxlength ="10"
                  style="width: 120px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtmainbirt">Tanggal Lahir :</label>
                <input type="text" 
                  name="txtmainbirt" 
                  id="txtmainbirt" 
                  maxlength ="50"
                  style="width: 200px;"
                  readonly="true"> 


            <label for="txtmaingend">L/P :</label>
                <input type="text" 
                  name="txtmaingend" 
                  id="txtmaingend" 
                  maxlength ="50"
                  style="width: 100px;"
                  readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtexamhght">Tinggi :</label>
                <input type="text" 
                  name="txtexamhght" 
                  id="txtexamhght" 
                  maxlength ="10"
                  style="width: 60px;"

                  onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {

                                  document.getElementById('txtexamwght').focus();
                                }"> cm        

            <label for="txtexamwght">Berat :</label>
              <input type="text" 
                  name="txtexamwght" 
                  id="txtexamwght" 
                  maxlength ="10"
                  style="width: 60px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamblod').focus();
                            }"> Kg        

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtexamblod">Tekanan Darah :</label>
              <input type="text" 
                  name="txtexamblod" 
                  id="txtexamblod" 
                  maxlength ="10"
                  style="width: 100px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamtemp').focus();
                            }"> mmHg        

            <label for="txtexamtemp">Suhu :</label>
              <input type="text" 
                  name="txtexamtemp" 
                  id="txtexamtemp" 
                  maxlength ="10"
                  style="width: 50px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamtemp').focus();
                            "> Celcius        

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hidexamcode').value.length == 0 )
                                    {
                            swal({
                                title: 'Data Pendaftaran masih  Kosong' ,
                                text: 'Anda belum memilih Data pendaftaran, silah periksa lagi',
                                icon: 'warning',
                                });
                                    }
                  else if (document.getElementById('txtexamhght').value.length == 0)
                                    {
                            swal({
                                title: 'Tinggi Badan kosong' ,
                                text: 'Anda belum mengisi Tinggi Badan Pasien, silah periksa lagi',
                                icon: 'warning',
                                });
                                    }
                  else if (document.getElementById('txtexamwght').value.length == 0)
                                    {
                            swal({
                                title: 'Berat Badan Kosong' ,
                                text: 'Anda belum mengisi Berat Badan Pasien',
                                icon: 'warning',
                                });

                                    }
                  else if (document.getElementById('txtexamblod').value.length == 0)
                                    {
                            swal({
                                title: 'Tekanan Darah kosong' ,
                                text: 'Anda belum mengisi Tekanan Darah Pasien, silah periksa lagi',
                                icon: 'warning',
                                });

                                    }

                  else if (document.getElementById('txtexamtemp').value.length == 0)
                                    {
                            swal({
                                title: 'Suhu Tubuh  kosong' ,
                                text: 'Anda belum mengisi Suhu Tubuh Pasien, silah periksa lagi',
                                icon: 'warning',
                                });

                                    }


                  else
                    {
                       var inexamcode = document.getElementById('hidexamcode').value;
                       var inexamhght = document.getElementById('txtexamhght').value;
                       var inexamwght = document.getElementById('txtexamwght').value;
                       var inexamblod = document.getElementById('txtexamblod').value;
                       var inexamtemp = document.getElementById('txtexamtemp').value;

                       input(inexamcode,inexamhght,inexamwght,inexamblod,inexamtemp);
                    }

        ">Submit</a>
        </fieldset>
                <fieldset>
        <label for="txtsearch">Cari...</label>
        <input type="text" class="pure-input-rounded"
            name="txtsearch" 
            id="txtsearch" 
            maxlength ="20"
            style="width: 200px;"
            onkeyup="if (value.length > 0) { ambilscreen(this.value); } else {ambilscreen('')};"

            onkeydown="if (event.keyCode == 13 && value.length > 0) 
                        { 
                        document.getElementById('txtsearch').value = '';
                        document.getElementById('txtsearch').focus()
                        }">
        </fieldset>

      <fieldset>
          <div id="tblscreen">
      </fieldset>

        <fieldset>

          <div id="tbluser" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

        <fieldset>

          <div id="tblpati" 
          style="position: absolute; 
                 top: 300px;
                 left: calc(70% - 250px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

    </form>

		</div><!-- div content -->
<div class="footerdate">
  	<span class="labelTime Time"><b>Date  :</b> <?php $tgl=date('d-m-Y'); echo $tgl;?></span>
</div>
<div class="footertime">
	<span class = "labelTime Time" id="timestamp"></span>
</div>


    	</div><!-- div main -->
</div><!-- div layout -->
<script src="js/TRXAPATI07.js"></script>
<script src="js/ui.js"></script>

</body>
</html>
<?php
}
else

{
  header("Location: "."signin.php");
}
?>
