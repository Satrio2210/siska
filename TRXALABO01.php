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
<title>Data Pasien</title>
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

<body onLoad="periksaakses('PASS_LABO_ENTR'); 
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
                <a class="pure-menu-link">LABORATORIUM</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Data Pasien</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXALABO05.php'">
                <a class="pure-menu-link">Data Hasil</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXALABO06.php'">
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

              <li class="pure-menu-item pure-menu-disabled">
                Perawatan Pasien
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXALABO02.php'">
                <a class="pure-menu-link">
                BHP
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxalabo" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

          <div class="pure-control-group">

            <label for="txtsearch">Cari :</label>
              <input type="text" name="txtsearch" id="txtsearch"
                maxlength="10" style="width: 100px"
                onkeyup="if (value.length > 0) 
                {
                  var dokter = document.getElementById('hidtretdoct').value;
                  ambilregicode(this.value,dokter);
                } 
                else 
                { 
                  document.getElementById('tblregi').style.visibility = 'hidden';
                }"
            >

          </div><!-- pure-control-group -->

      		<div class="pure-control-group">

        		<label for="txttretcode">No. Daftar :</label>
              <input type="text" 
            		name="txttretcode" 
              	id="txttretcode" 
              	maxlength ="14"
              	style="width: 160px;"
                readonly="true">

                <input type="hidden" name="hidtretdoct" id="hidtretdoct" value="<?php echo $user;?>">

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
              		maxlength ="14"
              		style="width: 200px;"
                  	readonly="true">

            	<label for="txtmaingend">L/P :</label>
              	<input type="text" 
                  name="txtmaingend" 
                  id="txtmaingend" 
                  maxlength ="10"
                  style="width: 120px;"
                  readonly="true">


          	</div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtbirtdate">Tgl Lahir :</label>
                <input type="text" 
                  name="txtbirtdate" 
                  id="txtbirtdate" 
                  maxlength ="50"
                  style="width: 150px;"
                  readonly="true">

              <label for="txtmainage">Usia :</label>
                <input type="text" 
                  name="txtmainage" 
                  id="txtmainage" 
                  maxlength ="50"
                  style="width: 200px;"
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

                <input type="hidden" name="hidregipaym" id="hidregipaym">
                <input type="hidden" name="hidmediroom" id="hidmediroom">
            </div><!-- pure-control-group --> 




          <div class="pure-control-group">

            <label for="txtmedicode">Layanan/Tindakan :</label>
              <input type="text" 
                  name="txtmedicode" 
                  id="txtmedicode" 
                  maxlength ="100"
                  style="width: 300px;"
                  autocomplete="off" 

                  onkeyup="if (value.length > 0) 
                  {
                  var regipoli = document.getElementById('hidmediroom').value;
                  var regipaym = document.getElementById('hidregipaym').value;  
                  ambiltindakan(this.value,regipoli,regipaym);
                  } 
                else 
                  { 
                    document.getElementById('tbltindakan').innerHTML = '';
                    document.getElementById('tbltindakan').style.visibility = 'hidden';
                  }">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

                  <input type="hidden" name="hidmedicode" id="hidmedicode">
                  <input type="hidden" name="hidmedirate" id="hidmedirate">
                  
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txttretquty">Qty :</label>
              <input type="text" 
                  name="txttretquty" 
                  id="txttretquty" 
                  maxlength ="10"
                  style="width: 50px;"
                  value="1" 

                  onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  this.value = '1';
                                  this.focus();                          
                                }
                                else
                                {
                                  document.getElementById('txttretquty').focus();
                                }
                            }"
                onclick="if (isNaN(this.value)) 
                              {
                                this.value = '0'
                                this.focus();
                              }

                            ">         

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtmedicode').value == '')
                  {
                    swal({
                        title: 'Tindakan Kosong' ,
                        text: 'Anda belum mengisi Tindakan, silah periksa lagi',
                        icon: 'warning',
                        });
                  }
                  else if (document.getElementById('txttretquty').value == '0')
                  {
                      swal({
                          title: 'Qty Kosong' ,
                          text: 'Anda belum mengisi Diagnosa, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (document.getElementById('txttretquty').value == '')
                  {
                      swal({
                          title: 'Qty Kosong' ,
                          text: 'Anda belum mengisi Diagnosa, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (isNaN(document.getElementById('txttretquty').value))
                  {
                      swal({
                          title: 'Masukkan Angka' ,
                          text: 'Anda memasukkan Huruf, bukan angka, silah periksa lagi',
                          icon: 'warning',
                          });                    
                  }

                   else
                   {
                       var intretcode = document.getElementById('txttretcode').value;
                       var intretdoct = document.getElementById('hidtretdoct').value;

                       var inmedicode = document.getElementById('hidmedicode').value;
                       var inmedirate = document.getElementById('hidmedirate').value;

                       var intretquty = document.getElementById('txttretquty').value;

                       var inmediroom = document.getElementById('hidmediroom').value;

                       input(intretcode,intretdoct,inmedicode,inmedirate,intretquty,inmediroom);
                    }
        ">Input</a>

          <a class="button-update pure-button" onclick="javascript: location.href = 'TRXALABO01.php'">Close</a>


      </fieldset>
      
      <fieldset>
          <div id="tblscreen">
      </fieldset>

      <fieldset>
          <div id="tblregi" 
            style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>

      <fieldset>
          <div id="tbltindakan"
            style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 200px);
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
<script src="js/TRXALABO01.js"></script>
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
