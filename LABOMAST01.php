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
<title>Master Pemeriksaan Labs</title>
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXALABO01.php'">
                <a class="pure-menu-link">Data Pasien</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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


              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXALABO05.php'">
                <a class="pure-menu-link">
                Hasil
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Master
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLLEXAM01.php'">
                <a class="pure-menu-link">
                Golongan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLLUNIT01.php'">
                <a class="pure-menu-link">
                Satuan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLLMANU01.php'">
                <a class="pure-menu-link">
                Manual
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmlabomast" class="pure-form pure-form-aligned" method="post" action="">
      <fieldset>

          <div class="pure-control-group">

            <label for="txtmastcode">Kode :</label>
                  <input type="text" 
                  name="txtmastcode" 
                  id="txtmastcode" 
                  maxlength ="7"
                  style="width: 100px;"
                  readonly="true"> 

            <label for="txtsubscode">Kategori :</label>
                <input type="text" name="txtsubscode" id="txtsubscode"
                  maxlength="50" style="width: 200px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilsubscode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tblcategory').style.visibility = 'hidden';
                    }"
                  >
            <input type="hidden" name="hidsubscode" id="hidsubscode">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtsizename">Tindakan :</label>
                  <input type="text" 
                    name="txtsizename" 
                    id="txtsizename" 
                    maxlength ="50"
                    style="width: 400px;"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilsizecode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tbltindakan').style.visibility = 'hidden';
                    }"
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtsizename2').focus(); 
                    }"
                  >

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtsizename2">Pemeriksaan :</label>
                  <input type="text" 
                    name="txtsizename2" 
                    id="txtsizename2" 
                    maxlength ="50"
                    style="width: 400px;"
                  autocomplete="off" 
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtunitname').focus(); 
                    }"
                  >

            </div><!-- pure-control-group -->

			<input type="hidden" name="hidsizecode" id="hidsizecode">            

            <div class="pure-control-group">

              <label for="txtunitname">Satuan :</label>
                <input type="text" name="txtunitname" id="txtunitname"
                  maxlength="100" style="width: 300px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                    ambilsatuan(this.value);
                    } 
                  else 
                    { 
                    document.getElementById('tblsatuan').style.visibility = 'hidden';
                    }"
                    >
                <input type="hidden" name="hidunitname" id="hidunitname">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="optrange">Kuantitatif</label>
                <input type="checkbox"
                  name="optrange" 
                  id="optrange"
                  value="true"
                  onclick="if (checked == true) 
                  {
                      document.getElementById('optstring').checked = false;

                      document.getElementById('txtvalumin').removeAttribute('disabled');
                      document.getElementById('txtvalumax').removeAttribute('disabled');

                      document.getElementById('txtstring').value = '';

                      document.getElementById('hidnilainormal').value = 'N';

                      document.getElementById('txtstring').setAttribute('disabled','true');
                      document.getElementById('txtvalumin').focus();
                  }                
                "> 

              <label for="optstring">Kualitatif</label>    
                <input type="checkbox"
                  name="optstring" 
                  id="optstring"
                  value="true"
                  onclick="if (checked == true) 
                  {
                      document.getElementById('optrange').checked = false;

                      document.getElementById('txtvalumin').value = '';
                      document.getElementById('txtvalumax').value = '';

                      document.getElementById('txtunitname').value = '';
                      document.getElementById('hidunitname').value = '';
                      document.getElementById('hidnilainormal').value = 'S';

                      document.getElementById('txtvalumin').setAttribute('disabled','true');
                      document.getElementById('txtvalumax').setAttribute('disabled','true');

                      document.getElementById('txtstring').removeAttribute('disabled');
                      document.getElementById('txtstring').focus();

                  }                
                ">

                <input name="hidnilainormal" id="hidnilainormal" type="hidden">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtvalumin">Nilai Rujukan Awal :</label>
                  <input type="text" 
                    name="txtvalumin" 
                    id="txtvalumin" 
                    maxlength ="20"
                    style="width: 100px;"
                    onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtvalumax').focus(); 
                    }">         

               <label for="txtvalumax">Nilai Rujukan Akhir :</label>
                  <input type="text" 
                    name="txtvalumax" 
                    id="txtvalumax" 
                    maxlength ="20"
                    style="width: 100px;"
                    onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('optpatigend').focus(); 
                    }">         

               <label for="txtstring">Nilai String :</label>
                  <input type="text" 
                    name="txtstring" 
                    id="txtstring" 
                    maxlength ="20"
                    style="width: 200px;"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilstringcode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tblstring').style.visibility = 'hidden';
                    }"
                  >

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="optpatigend">Usia :</label>

                <select name="optpatigend" id="optpatigend">
                  <option selected value="F">Wanita Dewasa</option>
                  <option value="M">Pria Dewasa</option>
                  <option value="C">Anak Anak</option>
                </select>

            </div><!-- pure-control-group -->

        </fieldset>

        <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hidsubscode').value == '')
                  {
                    swal({
                        title: 'Kategori Pemeriksaan Kosong' ,
                        text: 'Anda belum memilih Kategori Pemeriksaan, silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('hidsizecode').value == '')
                  {
                      swal({
                          title: 'Tindakan Kosong' ,
                          text: 'Anda belum mengisi Jenis Tindakan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtsizename2').value == '')
                  {
                      swal({
                          title: 'Nama Pemeriksaan Kosong' ,
                          text: 'Anda belum mengisi Nama Pemeriksaan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }


                  //else if (document.getElementById('hidunitname').value == '')
                  //{
                  //    swal({
                  //        title: 'Satuan Pemeriksaan Kosong' ,
                  //        text: 'Anda belum memilih Satuan Pemeriksaan, silah periksa lagi',
                  //        icon: 'warning',
                  //        });
                  //}

                  //else if (document.getElementById('txtvalumin').value == '')
                  //{
                  //    swal({
                  //        title: 'Nilai Rujukan Masih Kosong' ,
                  //        text: 'Anda belum mengisi Nilai Rujukan , silah periksa lagi',
                  //        icon: 'warning',
                  //        });
                  //}

                  else if (document.getElementById('hidnilainormal').value == '')
                  {
                      swal({
                          title: 'Nilai Normal Masih Kosong' ,
                          text: 'Anda belum mengisi Nilai Normal , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inmastcode = document.getElementById('txtmastcode').value;
                       var insubscode = document.getElementById('hidsubscode').value;

                       var insizecode = document.getElementById('hidsizecode').value;
                       var insizename = document.getElementById('txtsizename2').value;

                       var inunitname = document.getElementById('hidunitname').value;

                       var invalumin = document.getElementById('txtvalumin').value;

                       var invalumax = document.getElementById('txtvalumax').value;
                       
                       var invalustring = document.getElementById('txtstring').value;

                       var inpatigend = document.getElementById('optpatigend').value;

                        input(inmastcode,insubscode,insizecode,insizename,inunitname,invalumin,invalumax,invalustring,inpatigend);
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
                <div id="tblcategory" 
                style="position: absolute; 
                  top: 200px;
                  left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tbltindakan" 
                style="position: absolute; 
                  top: 300px;
                  left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tblsatuan" 
                style="position: absolute; 
                  top: 300px;
                  left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tblstring" 
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
<script src="js/LABOMAST01.js"></script>
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
