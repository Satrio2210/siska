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
<title>Pembayaran Lain Lain</title>
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

<body onLoad="periksaakses('PASS_PAYM_CASH');
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
                <a class="pure-menu-link">KEUANGAN</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAVEND01.php'">
                <a class="pure-menu-link">Bayar Vendor</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACUST01.php'">
                <a class="pure-menu-link">Pelunasan</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Bayar Lain Lain</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADEBT00.php'">
                <a class="pure-menu-link">Debit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACRDT00.php'">
                <a class="pure-menu-link">Credit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXARECO01.php'">
                <a class="pure-menu-link">Rekonsil</a>
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
                Transaksi
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPAYM02.php'">
                <a class="pure-menu-link">
                Report
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxapaym" class="pure-form pure-form-aligned" method="post" action="">
      <fieldset>

          <div class="pure-control-group">

            <label for="txtpaymcode">Kode :</label>
                  <input type="text" 
                  name="txtpaymcode" 
                  id="txtpaymcode" 
                  maxlength ="7"
                  style="width: 100px;"
                  readonly="true"> 

            <label for="tglpaymdate">Tanggal :</label>
                  <input type="date" 
                  name="tglpaymdate" 
                  id="tglpaymdate" 
                  value="<?php echo $datenow; ?>"
                  onchange="document.getElementById('txtcoaccode').focus()">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label for="txtcoaccode">Dibayar dari :</label>
                <input type="text" name="txtcoaccode" id="txtcoaccode"
                  maxlength="50" style="width: 400px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilcoaccode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tblcoac').style.visibility = 'hidden';
                    }"
                  >
            <input type="hidden" name="hidcoaccode" id="hidcoaccode">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtcheqcode">Cheque Code :</label>
                  <input type="text" 
                    name="txtcheqcode" 
                    id="txtcheqcode" 
                    maxlength ="100"
                    style="width: 400px;"
                  autocomplete="off" 
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtdivicode').focus(); 
                    }"
                  >

               <label for="txtdivicode">Divisi :</label>
                  <input type="text" 
                    name="txtdivicode" 
                    id="txtdivicode" 
                    maxlength ="50"
                    style="width: 400px;"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambildivicode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tbldivi').style.visibility = 'hidden';
                    }"
                  >

                  <input type="hidden" name="hiddivicode" id="hiddivicode">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtpayecode">Pembayaran untuk :</label>
                  <input type="text" 
                    name="txtpayecode" 
                    id="txtpayecode" 
                    maxlength ="50"
                    style="width: 400px;"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilpayecode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tblcoac').style.visibility = 'hidden';
                    }"
                  >

                  <input type="hidden" name="hidpayecode" id="hidpayecode">

           <label for="txtpaymamnt">Nominal :</label>
              <input type="text" name="txtpaymamnt" id="txtpaymamnt" autocomplete="off" 
              maxlength="20" style="width: 200px;"  value="0"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
              {
                if (isNaN(this.value)) 
                   {
                     document.getElementById('txtpaymamnt').value = '0';
                     document.getElementById('txtpaymamnt').focus();                          
                   }
                else
                  {
                    var inRupiah = convertToRupiah(this.value);
                    document.getElementById('txtpaymamnt').value = inRupiah;
                    document.getElementById('txtpaymnote').focus();
                  }
              }"

              onclick="if (isNaN(this.value)) 
              {
                var inAngka = convertToAngka(this.value);
                document.getElementById('txtpaymamnt').value = inAngka;
                document.getElementById('txtpaymamnt').focus();
              }
            ">        

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtpaymnote">Note :</label>
                  <input type="text" 
                    name="txtpaymnote" 
                    id="txtpaymnote" 
                    maxlength ="100"
                    style="width: 500px;"
                  autocomplete="off" 
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                          document.getElementById('txtpaymnote').focus(); 
                    }"
                  >
                  <input type="hidden" name="hidpaymstat" id="hidpaymstat">

            </div><!-- pure-control-group -->




        </fieldset>

        <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hidcoaccode').value == '')
                  {
                    swal({
                        title: 'Akun Kas Kosong' ,
                        text: 'Anda belum memilih Akun Kas , silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtcheqcode').value == '')
                  {
                      swal({
                          title: 'Nomor Cek atau Keterangan Kosong' ,
                          text: 'Anda belum mengisi cara Pembayaran, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hiddivicode').value == '')
                  {
                      swal({
                          title: 'Nama Divisi Kosong' ,
                          text: 'Anda belum mengisi Nama Divisi , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidpayecode').value == '')
                  {
                      swal({
                          title: 'Akun Biaya Kosong' ,
                          text: 'Anda belum memilih Akun Biaya, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtpaymamnt').value == '')
                  {
                      swal({
                          title: 'Nominal Pembayaran Kosong' ,
                          text: 'Anda belum mengisi Nilai Nominal Pembayaran, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtpaymnote').value == '')
                  {
                      swal({
                          title: 'Keterangan Pembayaran Kosong' ,
                          text: 'Anda belum mengisi Keterangan Pembayaran , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inpaymcode = document.getElementById('txtpaymcode').value;
                       var inpaymdate = document.getElementById('tglpaymdate').value;

                       var incoaccode = document.getElementById('hidcoaccode').value;
                       var incheqcode = document.getElementById('txtcheqcode').value;

                       var indivicode = document.getElementById('hiddivicode').value;

                       var inpayecode = document.getElementById('hidpayecode').value;

                       var inpaymamnt = document.getElementById('txtpaymamnt').value;
                       
                       var inpaymnote = document.getElementById('txtpaymnote').value;

                      input(inpaymcode,inpaymdate,incoaccode,incheqcode,indivicode,inpayecode,inpaymamnt,inpaymnote);
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
                <div id="tblcoac" 
                style="position: absolute; 
                  top: 200px;
                  left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tbldivi" 
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
<script src="js/TRXAPAYM01.js"></script>
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
