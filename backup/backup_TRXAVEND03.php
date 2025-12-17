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
<title>Sistem Informasi Klinik Pratama</title>
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

<body onLoad="periksaakses('PASS_VEND_ENTR');
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'PASSIDEN00.php'">
                <a class="pure-menu-link">ACCESS</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'index.php'">
                <a class="pure-menu-link">FINANCE</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAMEDI01.php'">
                <a class="pure-menu-link">Doctor Payment</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Vendor Payment</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACUST01.php'">
                <a class="pure-menu-link">Cust. Received</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACASH00.php'">
                <a class="pure-menu-link">Other Payment</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADEBT00.php'">
                <a class="pure-menu-link">Debit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACRDT00.php'">
                <a class="pure-menu-link">Credit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXARECO01.php'">
                <a class="pure-menu-link">Bank Recon.</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAVEND01.php'">
                <a class="pure-menu-link">
                Payment Request
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAVEND02.php'">
                <a class="pure-menu-link">
                Payment Approval
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Payment Execution
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxavend" class="pure-form pure-form-aligned" method="post" action="TRXAVEND03U.php">
    	<fieldset>

          <div class="pure-control-group">

          <label for="txtsearch">Get Payment  :</label>
                <input type="text" name="txtsearch" id="txtsearch"
                  maxlength="10" style="width: 100px"
                  onkeyup="if (value.length > 0) 
                    {
                    ambilinvccode(this.value);
                    } 
                  else 
                    { 
                    document.getElementById('tblinvc').style.visibility = 'hidden';
                    }"
          >

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtvendcode">Transaction Code :</label>
                <input type="text" 
                     name="txtvendcode" 
                     id="txtvendcode"
                     maxlength ="7"
                     style="width: 90px;"
                     readonly = "true">

            <label for="tglvenddate">Transaction Date :</label>
                <input type="date" name="tglvenddate" id="tglvenddate" value="<?php echo $datenow; ?>"
                    onchange="document.getElementById('txtsuplname').focus()">

          </div><!-- pure-control-group -->

      		<div class="pure-control-group">

        		<label for="txtsuplname">Suplier Name :</label>
              <input type="text" 
            	  	name="txtsuplname" 
              		id="txtsuplname" 
              		maxlength ="20"
              		style="width: 200px;"
                  readonly="true">

                  <input type="hidden" name="hidsuplcode" id="hidsuplcode">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtcoaccode">Account Bank Code :</label>
              <input type="text" name="txtcoaccode" id="txtcoaccode"
                  autocomplete="off" 
                  maxlength="13" style="width: 130px"
                  onkeyup="if (value.length > 0) 
                    {
                    ambilcoaccode(this.value);
                    } 
                  else 
                    { 
                     document.getElementById('tblcoac').style.visibility = 'hidden';
                    }"
              >

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtcoacname">Account Bank Name :</label>
              <input type="text" name="txtcoacname" id="txtcoacname"
                  maxlength="50" style="width: 500px" readonly="true">  

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtcheqcode">Cheque Number :</label>
              <input type="text" 
                  name="txtcheqcode" 
                  id="txtcheqcode" 
                  maxlength ="20"
                  style="width: 130px;"
                  autocomplete="off" 
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                            { document.getElementById('tglcheqdate').focus(); }">

            <label for="tglcheqdate">Cheque Due Date :</label>
                <input type="date" name="tglcheqdate" id="tglcheqdate" value="<?php echo $datenow; ?>"
                    onchange="document.getElementById('txtsuplname').focus()">

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtcheqbank">Cheque Bank :</label>
              <input type="text" 
                  name="txtcheqbank" 
                  id="txtcheqbank"
                  autocomplete="off" 
                  maxlength ="60"
                  style="width: 500px;"
                  onkeyup="if (value.length > 0) 
                      {
                      ambilbankcode(this.value);
                      } 
                      else 
                      {  
                      document.getElementById('tblbank').style.visibility = 'hidden';
                      }"

                >
                <input type="hidden" name="hidcheqbank" id="hidcheqbank">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label for="txtinvccode">Invoice Number :</label>
              <input type="text" 
                  name="txtinvccode" 
                  id="txtinvccode"
                  autocomplete="off" 
                  maxlength ="20"
                  style="width: 200px;"
                  onkeyup="if (value.length > 0) 
                      {
                      ambilinvccode(this.value);
                      } 
                      else 
                      {  
                      document.getElementById('tblinvc').style.visibility = 'hidden';
                      }"
                >

            <label for="tgldueddate">Invoice Due Date :</label>
                <input type="date" name="tgldueddate" id="tgldueddate" value="<?php echo $datenow; ?>"
                    onchange="document.getElementById('txtsummamnt').focus()">

				                    
			</div><!-- pure-control-group -->            

			<div class="pure-control-group">

			<label for="txtsummamnt">Amount :</label>
      			<input type="text" name="txtsummamnt" id="txtsummamnt"
                maxlength="10" style="width: 130px" value="0" readonly="true"> 

			<label for="txtpaymamnt">Payment Amount :</label>
      			<input type="text" name="txtpaymamnt" id="txtpaymamnt"
                maxlength="10" style="width: 130px" value="0"

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
                                  document.getElementById('txtpaymamnt').focus();
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


      </fieldset>       

      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:

                  if (document.getElementById('txtvendcode').value == '')
                  {
                    swal({
                        title: 'Kode Transaksi Pembayaran Kosong' ,
                        text: 'Pastikan Akses Form sudah aktif',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtcoaccode').value == '')
                  {
                    swal({
                        title: 'Akun Kosong' ,
                        text: 'Anda belum memilih Akun Bank',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtcheqcode').value == '')
                  {
                    swal({
                        title: 'Cheque Kosong' ,
                        text: 'Anda belum isi Nomor Cheque',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('hidcheqbank').value == '')
                  {
                    swal({
                        title: 'Bank Cheque Kosong' ,
                        text: 'Anda belum isi Nama Bank Cheque',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtinvccode').value == '')
                  {
                    swal({
                        title: 'Nomor Invoice  Kosong' ,
                        text: 'Anda belum isi Nomor Invoice',
                        icon: 'warning',
                        });
                  }

                   else
                   {
                       var invendcode = document.getElementById('txtvendcode').value;
                       var ininvccode = document.getElementById('txtinvccode').value;
                       var indueddate = document.getElementById('tgldueddate').value;
                       var incoaccode = document.getElementById('txtcoaccode').value;
                       var incheqcode = document.getElementById('txtcheqcode').value;
                       var incheqdate = document.getElementById('tglcheqdate').value;
                       var incheqbank = document.getElementById('hidcheqbank').value;
                       var insummamnt = document.getElementById('txtsummamnt').value;
                       var inpaymamnt = document.getElementById('txtpaymamnt').value;

                       input(invendcode,ininvccode,indueddate,incoaccode,incheqcode,incheqdate,incheqbank,insummamnt,inpaymamnt);
                       //document.frmtrxavend.submit();
                    }
        ">Input</a>
                  <a class="pure-button pure-button-primary" 
              onclick="javascript: if (document.getElementById('txtvendcode').value.length > 0) 
                {
                    if (confirm ('Are You Sure To Close this Form Payment ?')) 
                      { 
                        document.frmtrxavend.submit();
                      } 
                    else 
                      { 
                        swal({
                            title: 'Isi Form belum lengkap' ,
                            text: 'Anda belum melengkapi isi Form, silah periksa lagi',
                            icon: 'warning',
                            });
                      }                                             

                }
                else
                {
                          swal({
                            title: 'Pilih Invoice Payment' ,
                            text: 'Anda belum memilih Invoice Payment, silah periksa lagi',
                            icon: 'warning',
                            });

                }
          ">Close</a>

        </fieldset>

      <fieldset>
          <div id="tblscreen">
      </fieldset>

              <fieldset>
                  <div id="tblcoac" 
                style="position: absolute; 
                top:300px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                  <div id="tblbank" 
                style="position: absolute; 
                top:350px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">
  
      </fieldset>
    <fieldset>
              <div id="tblinvc" 
                style="position: absolute; 
                top:400px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
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
<script src="js/TRXAVEND03.js"></script>
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
