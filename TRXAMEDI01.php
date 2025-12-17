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
<title>Tindakan</title>
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
<script type="text/javascript" src="js/sanie.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_MEDI_ENTR');
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI01.php'">
                <a class="pure-menu-link">Pasien</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI05.php'">
                <a class="pure-menu-link">Signa</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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

              <li class="pure-menu-item  pure-menu-disabled">
                Tindakan
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI02.php'">
                <a class="pure-menu-link">
                Fee Master
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI03.php'">
                <a class="pure-menu-link">
                Kehadiran
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI04.php'">
                <a class="pure-menu-link">
                Kunjungan
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxamedi" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtmedicode">Kode Tindakan :</label>
              		<input type="text" 
            	  	name="txtmedicode" 
              		id="txtmedicode" 
              		maxlength ="8"
              		style="width: 110px;"
              		readonly="true"> 

            	<label for="txtmediname">Nama Tindakan :</label>
              		<input type="text" 
                  	name="txtmediname" 
                  	id="txtmediname" 
                  	maxlength ="100"
                  	style="width: 300px;"
                	onkeydown="if (event.keyCode == 13 && value.length > 0)
                	{
                		document.getElementById('txtmedirate').removeAttribute('disabled');
        				    document.getElementById('txtmediroom').removeAttribute('disabled');
        				    document.getElementById('optmeditype').removeAttribute('disabled');
        				    document.getElementById('optmedipaym').removeAttribute('disabled');
        				    document.getElementById('txtmedinote').removeAttribute('disabled');
        				    document.getElementById('optactive').removeAttribute('disabled');
        				    document.getElementById('optnonactive').removeAttribute('disabled');
                		document.getElementById('txtmedirate').focus();	
                	} 
                		">

          	</div><!-- pure-control-group -->

            <div class="pure-control-group">

			   <label for="txtmedirate">Tarif Tindakan :</label>
      			Rp. <input type="text" 
             	name="txtmedirate" 
             	id="txtmedirate" 
             	maxlength ="10"
              value="0" 
             	style="width: 100px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) 
             			{ 
             				document.getElementById('txtmedirate').value = '0'; 
             				document.getElementById('txtmedirate').focus(); 
             			}
             		else
             		 	{
            				var inRupiah = convertToRupiah(this.value);
                		document.getElementById('txtmedirate').value = inRupiah;
             		 	 	document.getElementById('txtmediroom').focus(); 
             		 	}
             	}">        	


      			<label for="txtmediroom">Poli :</label>
      			<input type="text" name="txtmediroom" id="txtmediroom"
      			maxlength="50" style="width: 200px"
      			autocomplete="off" 
      			onkeyup="if (value.length > 0) 
              		{
              		ambilpolicode(this.value);
              		} 
            		else 
              		{ 
               		document.getElementById('tblpoli').style.visibility = 'hidden';
              }"
        	>
      			<input type="hidden" name="hidmediroom" id="hidmediroom">


			</div><!-- pure-control-group -->

			<div class="pure-control-group">

          	<label for="optmeditype">Tipe Tindakan :</label>
              <select name="optmeditype" id="optmeditype" onchange="document.getElementById('optmeditype').focus();">
                <option value="J">Jasa</option>
                <option value="O">Operatif</option>
                <option value="N">Non Operatif</option>
              </select>

          	<label for="optmedipaym">Pembayaran :</label>
              <select name="optmedipaym" id="optmedipaym" onchange="document.getElementById('optmedipaym').focus();">
                <option value="U">Umum</option>
                <option value="B">BPJS</option>
                <option value="A">Asuransi</option>
                <option value="P">Perusahaan</option>
                <option value="H">Halodoc</option>
              </select>

			</div><!-- pure-control-group -->

          	<div class="pure-control-group">

            	<label for="txtmedinote"> Note :</label>
              		<input type="text" 
                  	name="txtmedinote" 
                  	id="txtmedinote" 
                  	maxlength ="100"
                  	style="width: 300px;"
                	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmedinote').focus()">

          	</div><!-- pure-control-group -->

      		<div class="pure-control-group">

      		<label for="optactive">Aktif</label>
      		<input type="checkbox"
            	name="optactive" 
            	id="optactive"
            	value="true"
            	onclick="if (checked == true) 
                  {
                      document.getElementById('optnonactive').checked = false;
                      document.getElementById('hidmediacti').value = 'A';
                  }                
                ">

            <label for="optnonactive">Tidak Aktif</label>    
      		<input type="checkbox"
            name="optnonactive" 
            id="optnonactive"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optactive').checked = false;
                      document.getElementById('hidmediacti').value = 'N';
                  }                
                ">

      		<input name="hidmediacti"
              id="hidmediacti"
              type="hidden">

      		</div><!-- pure-control-group -->

      	</fieldset>

      	<fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtmediname').value == '')
                  {
                    swal({
                        title: 'Nama Tindakan Kosong' ,
                        text: 'Anda belum mengisi Nama Tindakan, silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtmedirate').value == '0')
                  {
                      swal({
                          title: 'Tarif Tindakan Kosong' ,
                          text: 'Anda belum mengisi Tarif Tindakan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidmediroom').value == '')
                  {
                      swal({
                          title: 'Nama Poli Kosong' ,
                          text: 'Anda belum memilih nama Poli, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmedinote').value == '')
                  {
                      swal({
                          title: 'Keterangan Tindakan Kosong' ,
                          text: 'Anda belum mengisi tindakan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidmediacti').value == '')
                  {
                      swal({
                          title: 'Status Aktif Kosong' ,
                          text: 'Anda belum memilih Aktifasi Tindakan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inmedicode = document.getElementById('txtmedicode').value;
                       var inmediname = document.getElementById('txtmediname').value;
                       var inmedirate = document.getElementById('txtmedirate').value; 
                       var inmediroom = document.getElementById('hidmediroom').value;

                       var inmeditype = document.getElementById('optmeditype').value;
                       var inmedipaym = document.getElementById('optmedipaym').value;

                       var inmedinote = document.getElementById('txtmedinote').value;

                       var inmediacti = document.getElementById('hidmediacti').value;

                       input(inmedicode,inmediname,inmedirate,inmediroom,inmeditype,inmedipaym,inmedinote,inmediacti);
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
                <div id="tblpoli" 
                style="position: absolute; 
                top: 300px;
                left: calc(70% - 150px);
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
<script src="js/TRXAMEDI01.js"></script>
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
