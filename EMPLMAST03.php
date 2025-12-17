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
<title>Delete Employment</title>
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
<script type="text/javascript" src="js/sanie.js"></script>
<script src="js/sweetalert.min.js"></script>

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_EMPL_ENTR');
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
                <a class="pure-menu-link">PERSONIL</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLEPOST00.php'">
                <a class="pure-menu-link">Data Pendukung</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLPAYR00.php'">
                <a class="pure-menu-link">Payroll</a>
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

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST01.php'">
              	<a class="pure-menu-link">
                Register Karyawan
            	</a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST02.php'">
              	<a class="pure-menu-link">
                Update Karyawan
            	</a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Resign Karyawan
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST04.php'">
                <a class="pure-menu-link">
                Lihat Karyawan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST05.php'">
                <a class="pure-menu-link">
                Jenjang Karir
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST06.php'">
                <a class="pure-menu-link">
                Mutasi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST07.php'">
                <a class="pure-menu-link">
                Surat Peringatan
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmemplmast" class="pure-form pure-form-aligned" method="post" action="EMPLMAST03D.php">

    	<fieldset>

        <div class="pure-control-group">

    		<label for="txtsearch">Search ID :</label>
      			<input type="text" name="txtsearch" id="txtsearch" maxlength ="7"
              			autocomplete="off" style="width: 90px;"

             onkeyup="if (value.length > 0) 
              { ambilemplmastcode(this.value); } 
            else 
              { document.getElementById('tblemplmast').style.visibility = 'hidden'; }">
      	</div> <!-- pure-control-group -->    		

        <div class="pure-control-group">

    		<label for="txtmastcode">ID Karyawan :</label>
      			<input type="text" 
             	name="txtmastcode" 
             	id="txtmastcode" 
             	maxlength ="7"
             	style="width: 90px;"
             	readonly="true"> 

    		<label for="txtfrstname">Nama Depan :</label>
      			<input type="text" 
             	name="txtfrstname" 
             	id="txtfrstname" 
             	maxlength ="30"
             	style="width: 200px;"
             	readonly="true"> 

    		<label for="txtlastname">Nama Belakang :</label>
      			<input type="text" 
             	name="txtlastname" 
             	id="txtlastname" 
             	maxlength ="20"
             	style="width: 200px;"
             	readonly="true"> 

    	 </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="opthigheduc">Pendidikan Terakhir :</label>
							<select name="opthigheduc" id="opthigheduc" readonly="true">
								<option value="S1">Strata 1</option>
								<option value="S2">Strata 2</option>
								<option value="S3">Strata 3</option>
								<option value="D1">Diploma 1</option>
								<option value="D2">Diploma 2</option>
								<option value="D3">Diploma 3</option>
								<option value="SMK">Sekolah Menengah Kejuruan</option>
								<option value="SMP">Sekolah Menengah Pertama</option>
								<option value="SD">Sekolah Dasar</option>
							</select>

    	<label for="txtlastschl">Lulusan Sekolah :</label>
      			<input type="text" 
             	name="txtlastschl" 
             	id="txtlastschl" 
             	maxlength ="50"
             	style="width: 500px;"
             	readonly="true"> 

      </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="optdocustat">Jaminan Ijazah/STR :</label>
      		<input type="checkbox"
            name="optdocustat" 
            id="optdocustat"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('hiddocustat').value = 'Y';
                  }   
                ">
      		<input name="hiddocustat"
              id="hiddocustat"
              type="hidden">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="tglhiredate">Tanggal Rekrut :</label>
          	<input type="date" name="tglhiredate" id="tglhiredate" value="<?php echo $datenow; ?>"
                  readonly="true">

        	<label for="tglactidate">Tanggal Mulai Bekerja :</label>
          	<input type="date" name="tglactidate" id="tglactidate" value="<?php echo $datenow; ?>"
          		   readonly="true">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="txtmaindivi">Divisi :</label>
            	<input type="text" 
                  name="txtmaindivi" 
                  id="txtmaindivi"
              		autocomplete="off" 
                  maxlength ="100"
                  style="width: 200px;"
                  readonly="true"> 
                  <input type="hidden" name="hidmaindivi" id="hidmaindivi">

                  <label for="txtmainpstn">Jabatan :</label>
               <input type="text" 
                  name="txtmainpstn" 
                  id="txtmainpstn"
              		autocomplete="off" 
                  maxlength ="100"
                  style="width: 200px;"
                  readonly="true"> 
                  <input type="hidden" name="hidmainpstn" id="hidmainpstn">
            
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="tglrsgndate">Tanggal Pengunduran Diri :</label>
          	<input type="date" name="tglrsgndate" id="tglrsgndate" value="<?php echo $datenow; ?>"
                  onchange="document.getElementById('txtrsgnnote').focus()">

    		<label for="txtrsgnnote">Alasan Pengunduran Diri :</label>
      			<input type="text" 
             	name="txtrsgnnote" 
             	id="txtrsgnnote" 
             	maxlength ="50"
             	style="width: 500px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtrsgnnote').focus()">

        </div><!-- pure-control-group -->

    </fieldset>


        <fieldset>
          <a class="pure-button button-delete" onclick="javascript:
              if (document.getElementById('txtmastcode').value == '')
              {
                      swal({
                          title: 'Data Pegawai Kosong' ,
                          text: 'Anda belum memilih Data Pegawai, silah periksa lagi',
                          icon: 'warning',
                          });

              }
              else if (document.getElementById('txtrsgnnote').value == '')
              {
                      swal({
                          title: 'Catatan Resign belum di isi' ,
                          text: 'Anda belum mengisi Catatan resign, silah periksa lagi',
                          icon: 'warning',
                          });
              }
              else
              {
                 if (confirm ('Are You Sure To Resign this?')) 
                    { document.frmemplmast.submit(); } else { location.href = 'EMPLMAST03.php'; }                                           
              }
        ">Submit</a>

        </fieldset>

        <fieldset>
          <div id="tblemplmast"                
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">


        </fieldset>
        <fieldset>
                   <div id="tblbank" 
          style="position: absolute; 
                 top: 600px;
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
<script src="js/EMPLMAST03.js"></script>
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
