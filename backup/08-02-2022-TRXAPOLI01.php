<!doctype html>
<?php include "conf/config.php";
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
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
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

            		<a class="pure-menu-heading" href="#"><?php echo $_SESSION['username'];?></a>
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

              <li class="pure-menu-item pure-menu-disabled">
                Pemeriksaan Pasien
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPOLI02.php'">
                <a class="pure-menu-link">
                Perawatan Pasien
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPOLI03.php'">
                <a class="pure-menu-link">
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
                <input type="text" 
                name="txtregidate" 
                  id="txtregidate" 
                  maxlength ="14"
                  style="width: 150px;"
                  readonly="true">

          </div><!-- pure-control-group --> 

      		<div class="pure-control-group">

        		<label for="txtexamcode">No. Daftar :</label>
              	<input type="text" 
            		name="txtexamcode" 
              		id="txtexamcode" 
              		maxlength ="50"
              		style="width: 250px;"
                  	readonly="true">

                <input type="hidden" name="hidexamdoct" id="hidexamdoct" value="<?php echo $user;?>">

            <label for="txtpaticode">Rekam Medis :</label>
              	<input type="text" 
                  name="txtpaticode" 
                  id="txtpaticode" 
                  maxlength ="10"
                  style="width: 150px;"
                  readonly="true">

          	</div><!-- pure-control-group --> 

          	<div class="pure-control-group">

        		<label for="txtmainname">Nama :</label>
              	<input type="text" 
            		name="txtmainname" 
              		id="txtmainname" 
              		maxlength ="50"
              		style="width: 250px;"
                  	readonly="true">

            	<label for="txtmaingend">L/P :</label>
              	<input type="text" 
                  name="txtmaingend" 
                  id="txtmaingend" 
                  maxlength ="10"
                  style="width: 150px;"
                  readonly="true">


          	</div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtmainage">Usia :</label>
                <input type="text" 
                  name="txtmainage" 
                  id="txtmainage" 
                  maxlength ="50"
                  style="width: 250px;"
                  readonly="true">

              <label for="txtbirtdate">Tgl Lahir :</label>
                <input type="text" 
                  name="txtbirtdate" 
                  id="txtbirtdate" 
                  maxlength ="14"
                  style="width: 150px;"
                  readonly="true">

            </div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtmainaddr">Alamat :</label>
                <input type="text" 
                  name="txtmainaddr" 
                  id="txtmainaddr" 
                  maxlength ="50"
                  style="width: 500px;"
                  readonly="true">

            </div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtregipaym">Pembayaran :</label>
                <input type="text" 
                  name="txtregipaym" 
                  id="txtregipaym" 
                  maxlength ="50"
                  style="width: 150px;"
                  readonly="true">

            </div><!-- pure-control-group --> 


          <div class="pure-control-group">

            <label for="txtexamhght">Tinggi :</label>
              <input type="text" 
                  name="txtexamhght" 
                  id="txtexamhght" 
                  maxlength ="10"
                  style="width: 100px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {

                                  document.getElementById('txtexamwght').focus();
                                }"> cm        

            <label for="txtexamwght">Berat :</label>
              <input type="text" 
                  name="txtexamwght" 
                  id="txtexamwght" 
                  maxlength ="10"
                  style="width: 100px;"

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
                  style="width: 100px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtexamanam').focus();
                            "> Celcius        

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtexamanam">Anamnesa :</label>
            
            <textarea id="txtexamanam" name="txtexamanam"
            rows="4" cols="30">
              
            </textarea>

            <label for="txtexambody">Pemeriksaan Fisik :</label>

            <textarea id="txtexambody" name="txtexambody"
            rows="4" cols="30">

          </textarea>

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtexamdiag">Diagnosa :</label>
              <input type="text" 
                  name="txtexamdiag" 
                  id="txtexamdiag" 
                  maxlength ="200"
                  style="width: 500px;"
                onkeydown="if (event.keyCode == 13 && value.length > 1)
                            { document.getElementById('txtexamprsc').focus(); }
                ">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtexamprsc">Resep :</label>
            
            <textarea id="txtexamprsc" name="txtexamprsc"
            rows="4" cols="30">
              
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

                  else if (document.getElementById('txtexamdiag').value == '')
                  {
                      swal({
                          title: 'Diagnosa Kosong' ,
                          text: 'Anda belum mengisi Diagnosa, silah periksa lagi',
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

                       var inexamanam = document.getElementById('txtexamanam').value;
                       var inexambody = document.getElementById('txtexambody').value;

                       var inexamdiag = document.getElementById('txtexamdiag').value;

                       var inexamprsc = document.getElementById('txtexamprsc').value;

                       input(inexamcode,inexamdoct,inexamhght,inexamwght,inexamblod,inexamtemp,inexamanam,inexambody,inexamdiag,inexamprsc);
                       document.getElementById('tblrekammedis').style.visibility = 'hidden';
                       document.getElementById('tblrekammedis').innerHTML = '';

                    }
        ">Submit</a>
      </fieldset>

      <fieldset>
          <div id="tblrekammedis">
      </fieldset>

      <fieldset>
          <div id="tblscreen"
              style="position: absolute; 
                 top: 200px;
                 left: calc(100% - 700px);
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
<script src="js/TRXAPOLI01.js"></script>
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
