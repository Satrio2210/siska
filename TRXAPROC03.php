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
<title>Barang Masuk</title>
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

<body onLoad="periksaakses('PASS_PROC_UPDT'); 
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
                <a class="pure-menu-link">PEMBELIAN</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'SUPLMAST00.php'">
                <a class="pure-menu-link">Pemasok</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC00.php'">
                <a class="pure-menu-link">Buka PO</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Barang Masuk</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC05.php'">
                <a class="pure-menu-link">Tagihan</a>
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
                PO dikirim
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC04.php'">
                <a class="pure-menu-link">
                PO diterima
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxaproc" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtproccode">Nomor PO :</label>
              <input type="text" 
            	  	name="txtproccode" 
              		id="txtproccode" 
              		maxlength ="7"
              		style="width: 90px;"
                  readonly="true">

            <label for="tglarrvrequ">Tanggal Terima :</label>
          <input type="date" name="tglarrvrequ" id="tglarrvrequ" value="<?php echo $datenow; ?>" 
                onchange="document.getElementById('txtpartname').focus()">

              <input type="hidden" name="hidpartcode" id="hidpartcode">
              <input type="hidden" name="hidunitcode" id="hidunitcode">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtpartname">Nama Item :</label>
              <input type="text" 
                  name="txtpartname" 
                  id="txtpartname" 
                  maxlength ="50"
                  style="width: 300px;"
                  readonly="true">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtqutyrcve">Jumlah terima :</label>
              <input type="text" 
                  name="txtqutyrcve" 
                  id="txtqutyrcve" 
                  maxlength ="10"
                  style="width: 100px;"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  this.value = '0';
                                  this.focus();                          
                                }
                                else
                                {
                                  //var inRupiah = convertToRupiah(this.value);
                                  //this.value = inRupiah;
                                  document.getElementById('txtprocbtch').focus();
                                }
                            }"
              onclick="if (isNaN(this.value)) 
                              {
                                var inAngka = convertToAngka(this.value);
                                this.value = inAngka
                                this.focus();
                              }

                            "> 
                  <input type="hidden" name="hidqutyrcve" id="hidqutyrcve">       

            <label for="txtprocbtch">Kode Batch :</label>
              <input type="text" 
                  name="txtprocbtch" 
                  id="txtprocbtch" 
                  maxlength ="10"
                  style="width: 150px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtprocsrnm').focus()">

            <label for="txtprocsrnm">Serial Number :</label>
              <input type="text" 
                  name="txtprocsrnm" 
                  id="txtprocsrnm" 
                  maxlength ="10"
                  style="width: 150px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtwarename').focus()">

          </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtwarename">Ware House :</label>
      <input type="text" name="txtwarename" id="txtwarename"
      autocomplete="off" 
      maxlength="50" style="width: 200px"
      onkeyup="if (value.length > 0) 
              {
              ambilwarecode(this.value);
              } 
            else 
              { 
               document.getElementById('tblware').style.visibility = 'hidden';
              }"
        >
      <input type="hidden" name="hidwarecode" id="hidwarecode">

      <label for="tglexprdate">Tanggal Kadaluarsa :</label>
      <input type="date" 
      name="tglexprdate" 
      id="tglexprdate" 
      value="<?php echo $datenow; ?>"> 

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtemplname">Diperiksa oleh :</label>
      <input type="text" name="txtemplname" id="txtemplname"
      autocomplete="off" 
      maxlength="50" style="width: 200px"
      value="" 
      onkeyup="if (value.length > 0) 
              {
              ambilemplcode(this.value);
              } 
            else 
              { 
               document.getElementById('tblempl').style.visibility = 'hidden';
              }"
        >
      <input type="hidden" name="hidemplcode" id="hidemplcode">

      </div><!-- pure-control-group -->



      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:

                  var jumlahpesan = parseInt(document.getElementById('hidqutyrcve').value);
                  var jumlahterima = parseInt(document.getElementById('txtqutyrcve').value);

                  if (document.getElementById('txtproccode').value == '')
                  {
                    swal({
                        title: 'Kode PO Kosong' ,
                        text: 'Anda belum memilih Kode PO, silah periksa lagi',
                        icon: 'warning',
                        });
                  }
                  else if (document.getElementById('txtqutyrcve').value == '0')
                  {
                      swal({
                          title: 'Quantity Penerimaan Kosong' ,
                          text: 'Anda belum mengisi Quantity, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtqutyrcve').value = '';
                      document.getElementById('txtqutyrcve').focus();
                  }
                  else if ( jumlahterima > jumlahpesan)
                  {
                      swal({
                          title: 'Quantity Penerimaan Lebih besar dari jumlah yang dipesan' ,
                          text: 'Anda salah  mengisi Quantity penerimaan, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtqutyrcve').value = '';
                      document.getElementById('txtqutyrcve').focus();
                  }

                  else if (document.getElementById('txtprocbtch').value == '')
                  {
                      swal({
                          title: 'Batch Kode Penerimaan Kosong' ,
                          text: 'Anda belum mengisi Batch Kode, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtprocbtch').value = '';
                      document.getElementById('txtprocbtch').focus();
                  }
                  else if (document.getElementById('hidwarecode').value == '')
                  {
                      swal({
                          title: 'Gudang Penerima Kosong' ,
                          text: 'Anda belum mengisi Gudang Penerima, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtwarename').value = '';
                      document.getElementById('txtwarename').focus();
                  }
                  else if (document.getElementById('hidemplcode').value == '')
                  {
                      swal({
                          title: 'Nama Pemeriksa Kosong' ,
                          text: 'Anda belum mengisi Nama Pemeriksa, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtemplname').value = '';
                      document.getElementById('txtemplname').focus();
                  }

                   else
                   {
                       var inproccode = document.getElementById('txtproccode').value;
                       var inpartcode = document.getElementById('hidpartcode').value;
                       var inunitcode = document.getElementById('hidunitcode').value; 
                       var inqutyrcve = document.getElementById('txtqutyrcve').value;
                       var inprocbtch = document.getElementById('txtprocbtch').value;
                       var inprocsrnm = document.getElementById('txtprocsrnm').value;
                       var inarrvrequ = document.getElementById('tglarrvrequ').value;
                       var inwarecode = document.getElementById('hidwarecode').value;
                       var inexprdate = document.getElementById('tglexprdate').value;
                       var inemplcode = document.getElementById('hidemplcode').value;

                       input(inproccode,inpartcode,inunitcode,inqutyrcve,inprocbtch,inprocsrnm,inarrvrequ,inwarecode,inexprdate,inemplcode);
                    }
        ">Terima</a>
        </fieldset>

        <fieldset>
        <label for="txtsearch">Cari PO...</label>
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
                <div id="tblware" 
              style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>
            <fieldset>
                <div id="tblempl" 
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
<script src="js/TRXAPROC03.js"></script>
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
