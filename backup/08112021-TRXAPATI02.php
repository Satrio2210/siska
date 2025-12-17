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

              <li class="pure-menu-item pure-menu-disabled">
                Pasien Berobat
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

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxaregi" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtsearch">Cari Pasien :</label>
              	<input type="text" 
            	  	name="txtsearch" 
              		id="txtsearch" 
              		maxlength ="50"
              		style="width: 200px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambilpaticode(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tblpati').style.visibility = 'hidden';
                  }">

                <input type="hidden" name="hidpaticode" id="hidpaticode">

            <label for="tglregidate">Tanggal Berobat :</label>
              <input type="date" name="tglregidate" id="tglregidate" value="<?php echo $datenow; ?>">

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

          <label for="optregifrom">Datang Dari :</label>
              <select name="optregifrom" id="optregifrom" onchange="document.getElementById('optregipaym').focus();">
                <option value="A">Datang Sendiri</option>
                <option value="R">Rujukan Bidan</option>
                <option value="P">Kecelakaan</option>
              </select>

          <label for="optregipaym">Pembayaran :</label>
              <select name="optregipaym" id="optregipaym" onchange="document.getElementById('txtregidoct').focus();">
                <option value="U">Umum</option>
                <option value="B">BPJS</option>
                <option value="A">Asuransi</option>
                <option value="P">Perusahaan</option>
              </select>

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtregidoct">Dokter/Bidan :</label>
              <input type="text" 
                  name="txtregidoct" 
                  id="txtregidoct" 
                  maxlength ="50"
                  style="width: 250px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambildoctuser(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tbluser').style.visibility = 'hidden';
                  }">

                  <input type="hidden" name="hidregidoct" id="hidregidoct">

            <label for="txtregipoli">Poli :</label>
              <input type="text" 
                  name="txtregipoli" 
                  id="txtregipoli" 
                  maxlength ="50"
                  style="width: 200px;"
                  readonly="true"> 

                  <input type="hidden" name="hidregipoli" id="hidregipoli">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">
            <label for="hidregifee">Biaya Admin :</label>

          <input type="checkbox"
              name="optcharge" 
              id="optcharge"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optnocharge').checked = false;

                        document.getElementById('hidregifee').value = 'Y';

                    }                
                  ">
              Ya.

          <input type="checkbox"
              name="optnocharge" 
              id="optnocharge"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optcharge').checked = false;

                        document.getElementById('hidregifee').value = 'N';

                    }                
                  ">
              Tidak.

          <input name="hidregifee"
                id="hidregifee"
                type="hidden">

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hidpaticode').value.length == 0 )
                                    {
                            swal({
                                title: 'Nama Pasien Kosong' ,
                                text: 'Anda belum memilih Nama Pasien, silah periksa lagi',
                                icon: 'warning',
                                });
                                    }
                  else if (document.getElementById('hidregidoct').value.length == 0)
                                    {
                            swal({
                                title: 'Nama Dokter Belum di Pilih' ,
                                text: 'Anda belum mengisi Nama Dokter, silah periksa lagi',
                                icon: 'warning',
                                });
                                    }
                  else if (document.getElementById('hidregipoli').value.length == 0)
                                    {
                            swal({
                                title: 'Nama Poli Belum di pilih' ,
                                text: 'Anda belum Memilih Nama Poli, silah periksa lagi',
                                icon: 'warning',
                                });

                                    }
                  else if (document.getElementById('hidregifee').value.length == 0)
                                    {
                            swal({
                                title: 'Biaya Admin Belum di pilih' ,
                                text: 'Anda belum Memilih Biaya Admin, silah periksa lagi',
                                icon: 'warning',
                                });

                                    }

                  else
                    {
                       var inpaticode = document.getElementById('hidpaticode').value;
                       var inregidate = document.getElementById('tglregidate').value;
                       var inregifrom = document.getElementById('optregifrom').value;
                       var inregipaym = document.getElementById('optregipaym').value;
                       var inregidoct = document.getElementById('hidregidoct').value;
                       var inregipoli = document.getElementById('hidregipoli').value;
                       var inregifee = document.getElementById('hidregifee').value;
                       input(inpaticode,inregidate,inregifrom,inregipaym,inregidoct,inregipoli,inregifee);
                    }

        ">Submit</a>
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
<script src="js/TRXAPATI02.js"></script>
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
