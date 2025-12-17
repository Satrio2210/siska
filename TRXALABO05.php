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
<title>Input Hasil Pemeriksaan</title>
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

  .button-print {
            background: rgb(223, 117, 20);
            /* this is an orange */
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


              <li class="pure-menu-item pure-menu-disabled">
                Hasil
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'LABOMAST01.php'">
                <a class="pure-menu-link">
                Master
                </a>
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
    <form name="frmtrxalabo" class="pure-form pure-form-aligned" method="post" action="">
      <fieldset>

          <div class="pure-control-group">

            <label for="txtlaboregi">Nomor Daftar :</label>
                  <input type="text" 
                  name="txtlaboregi" 
                  id="txtlaboregi" 
                  maxlength ="14"
                  style="width: 200px;"
                  readonly="true"> 

                  <input type="hidden" name="hidlabodoct" id="hidlabodoct" value="<?php echo $user;?>">

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

                  <input type="hidden" name="hidmaingend" id="hidmaingend">
                  <input type="hidden" name="hidmaintitl" id="hidmaintitl">

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

            <label for="txtmastcode">Pemeriksaan :</label>

                <input type="text" name="txtmastcode" id="txtmastcode"
                  maxlength="50" style="width: 200px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      let gender = document.getElementById('hidmaintitl').value;
                      let tindakan = document.getElementById('txtlaboregi').value;

                      ambilrujukan(this.value,gender,tindakan);
                    } 
                  else 
                    { 
                      document.getElementById('tbllabomast').style.visibility = 'hidden';
                    }"
                  >

            <input type="hidden" name="hidmastcode" id="hidmastcode">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtlaborslt">Hasil :</label>
                  <input type="text" 
                    name="txtlaborslt" 
                    id="txtlaborslt" 
                    maxlength ="10"
                    style="width: 100px;"
                    onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtlabonote').focus(); 
                    }">         

               <label for="txtlabovalu">Rujukan :</label>
                  <input type="text" 
                    name="txtlabovalu" 
                    id="txtlabovalu" 
                    maxlength ="10"
                    style="width: 150px;"
                    readonly="true"> 

               <label for="txtlabounit">Satuan :</label>
                  <input type="text" 
                    name="txtlabounit" 
                    id="txtlabounit" 
                    maxlength ="10"
                    style="width: 100px;"
                    readonly="true"> 

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label for="txtlabonote">Remark :</label>

                  <textarea id="txtlabonote" name="txtlabonote"
                            rows="4" cols="30">

                  </textarea>

            </div><!-- pure-control-group -->

        </fieldset>

        <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtlaboregi').value == '')
                  {
                    swal({
                        title: 'Nomor Pemeriksaan Kosong' ,
                        text: 'Anda belum memilih Pasien, silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('hidlabodoct').value == '')
                  {
                      swal({
                          title: 'Nama Petugas medis kosong' ,
                          text: 'Nama Petugas Medis Kosong, silah periksa lagi',
                          icon: 'warning',
                          });
                  }


                  else if (document.getElementById('hidmastcode').value == '')
                  {
                      swal({
                          title: 'Jenis Pemeriksaan Kosong' ,
                          text: 'Anda belum memilih Jenis Pemeriksaan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtlaborslt').value == '')
                  {
                      swal({
                          title: 'Nilai Pemeriksaan Kosong' ,
                          text: 'Anda belum mengisi Nilai Hasil Pemeriksaan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtlabonote').value == '')
                  {
                      swal({
                          title: 'Catatan Hasil Pemeriksaan Kosong' ,
                          text: 'Anda belum mengisi Penilaian Pemeriksaan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }


                   else
                   {
                      var inlaboregi = document.getElementById('txtlaboregi').value;

                      var inlabodoct = document.getElementById('hidlabodoct').value;

                      var inmastcode = document.getElementById('hidmastcode').value;

                      var inlaborslt = document.getElementById('txtlaborslt').value;

                      var inlabonote = document.getElementById('txtlabonote').value;

                      input(inlaboregi,inlabodoct,inmastcode,inlaborslt,inlabonote);
                    }
        ">Input Hasil</a>

          <a class="pure-button button-print" onclick="javascript:
                    if (document.getElementById('txtlaboregi').value == '')
                    {
                      swal({
                          title: 'Data Hasil belum di pilih' ,
                          text: 'Anda belum memilih Data Hasil Pemeriksaan Laboratorium, silah periksa lagi',
                          icon: 'warning',
                          });                      
                    }
                    else
                    {
                      var outlaboregi = document.getElementById('txtlaboregi').value;
                      location.href ='TRXALABO05P.php?laboregi='+outlaboregi;                      
                    } 
          ">Print Hasil</a> 

        <a class="pure-button button-view" onclick="javascript: 
                  document.getElementById('tblviewresult').style.visibility = 'hidden';
                  document.getElementById('tblviewresult').innerHTML = '';

                  document.getElementById('txtlaboregi').value = '';
                  document.getElementById('txtpaticode').value = '';
                  document.getElementById('txtmastcode').value = '';
                  document.getElementById('txtmainname').value = '';
                  document.getElementById('txtmaingend').value = '';
                  document.getElementById('hidmaingend').value = '';

                  document.getElementById('txtmainage').value = '';
                  document.getElementById('txtbirtdate').value = '';

                  document.getElementById('txtmainaddr').value = '';
                  document.getElementById('txtregipaym').value = '';

                  document.getElementById('txtmastcode').setAttribute('disabled','true');
                  document.getElementById('txtlaborslt').setAttribute('disabled','true');

                  document.getElementById('txtlabovalu').setAttribute('disabled','true');
                  document.getElementById('txtlabonote').setAttribute('disabled','true');

                  ambilscreen('',document.getElementById('hidlabodoct').value);

        ">Close</a>
        </fieldset>


        <fieldset>
          <div id="tblviewresult">
        </fieldset>

        <fieldset>
        <label for="txtsearch">Cari...</label>
        <input type="text" class="pure-input-rounded"
            name="txtsearch" 
            id="txtsearch" 
            maxlength ="20"
            style="width: 200px;"
            onkeyup="if (value.length > 0) { ambilscreen(this.value,document.getElementById('hidlabodoct').value); } else {ambilscreen('',document.getElementById('hidlabodoct').value)};"

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
                <div id="tbllabomast" 
                style="position: absolute; 
                  top: 400px;
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
<script src="js/TRXALABO05.js"></script>
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
