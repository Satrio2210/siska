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
<title>Input Suplier</title>
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

<body onLoad="periksaakses('PASS_SUPL_ENTR');
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
                <a class="pure-menu-link">PURCHASING</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Suplier</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC00.php'">
                <a class="pure-menu-link">Purchase Order</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC03.php'">
                <a class="pure-menu-link">Quality Control</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC05.php'">
                <a class="pure-menu-link">Invoice</a>
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
            <h2>S.A.N.I</h2>
        </div><!-- div header -->

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Input Suplier
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST02.php'">
                <a class="pure-menu-link">
                Update Suplier
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST03.php'">
                <a class="pure-menu-link">
                Delete Suplier
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST04.php'">
                <a class="pure-menu-link">
                View Suplier
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->
    <!-- Form Input -->
    <form name="frmsuplmast" class="pure-form pure-form-aligned" method="post" action="SUPLMAST01E.php">
    	<fieldset>

        <div class="pure-control-group">

    		<label for="txtmastcode">Suplier ID :</label>
      			<input type="text" 
             	name="txtmastcode" 
             	id="txtmastcode" 
             	maxlength ="7"
             	style="width: 90px;"
             	readonly="true"> 

    		<label for="txtmainname">Supplier Name :</label>
      			<input type="text" 
             	name="txtmainname" 
             	id="txtmainname" 
             	maxlength ="50"
             	style="width: 300px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainaddr').focus()">

    	 </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmainaddr">Address :</label>
      			<input type="text" 
             	name="txtmainaddr" 
             	id="txtmainaddr" 
             	maxlength ="100"
             	style="width: 500px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmaincity').focus()">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

    		<label for="txtmaincity">City :</label>
      			<input type="text" 
             	name="txtmaincity" 
             	id="txtmaincity" 
             	maxlength ="10"
             	style="width: 100px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainctry').focus()">
    		
    		<label for="txtmainctry">Country :</label>
      			<input type="text" 
             	name="txtmainctry" 
             	id="txtmainctry" 
              value="Indonesia" 
             	maxlength ="10"
             	style="width: 100px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainphne').focus()">
    		
    	 </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmainphne">Phone :</label>
      			<input type="text" 
             	name="txtmainphne" 
             	id="txtmainphne" 
             	maxlength ="18"
             	style="width: 180px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainfaxi').focus()">

    		<label for="txtmainfaxi">Fax :</label>
      			<input type="text" 
             	name="txtmainfaxi" 
             	id="txtmainfaxi" 
             	maxlength ="18"
             	style="width: 180px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainmail').focus()">
    		
    	 </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmainmail">E-Mail :</label>
      			<input type="text" 
             	name="txtmainmail" 
             	id="txtmainmail"
             	placeholder="user@domain.com" 
             	maxlength ="30"
             	style="width: 300px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainwebs').focus()">

       </div><!-- pure-control-group -->

       <div class="pure-control-group">

    		<label for="txtmainwebs">Website :</label>
      			<input type="text" 
             	name="txtmainwebs" 
             	id="txtmainwebs" 
             	maxlength ="50"
             	placeholder ="http://" 
             	style="width: 500px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainpers').focus()">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

    		<label for="txtmainpers">Contact Person :</label>
      			<input type="text" 
             	name="txtmainpers" 
             	id="txtmainpers" 
             	maxlength ="50"
             	style="width: 500px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmaintidn1').focus()">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

    		<label for="txtmaintidn1">Tax Number :</label>
      			<input type="text" 
             	name="txtmaintidn1" 
             	id="txtmaintidn1" 
             	maxlength ="2"
             	style="width: 40px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 2) document.getElementById('txtmaintidn2').focus()">
			       .
      			<input type="text" 
             	name="txtmaintidn2" 
             	id="txtmaintidn2" 
             	maxlength ="3"
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn3').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn3" 
             	id="txtmaintidn3" 
             	maxlength ="3"
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn4').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn4" 
             	id="txtmaintidn4" 
             	maxlength ="1"
             	style="width: 30px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 1) document.getElementById('txtmaintidn5').focus()">        	
			       -
      			<input type="text" 
             	name="txtmaintidn5" 
             	id="txtmaintidn5" 
             	maxlength ="3"
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn6').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn6" 
             	id="txtmaintidn6" 
             	maxlength ="3"
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmainterm').focus()">        	

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

			   <label for="txtmainterm">Installment :</label>
      			<input type="text" 
             	name="txtmainterm" 
             	id="txtmainterm" 
             	maxlength ="3"
              value="1" 
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) { document.getElementById('txtmainterm').value = ''; document.getElementById('txtmainterm').focus(); }
             		else { document.getElementById('txtestiarrv').focus(); }
             	}">        	

			<label for="txtestiarrv">Estimated Time Arrival :</label>
      			<input type="text" 
             	name="txtestiarrv" 
             	id="txtestiarrv" 
             	maxlength ="3"
              value="1" 
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) { document.getElementById('txtestiarrv').value = ''; document.getElementById('txtestiarrv').focus(); }
             		else { document.getElementById('txtestideli').focus(); }
             	}">        	

			<label for="txtestideli">Estimated Time Delivered :</label>
      			<input type="text" 
             	name="txtestideli" 
             	id="txtestideli" 
             	maxlength ="3"
              value="1" 
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) { document.getElementById('txtestideli').value = ''; document.getElementById('txtestideli').focus(); }
             		else { document.getElementById('txtpayalimt').focus(); }
             	}">        	
        	
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

			<label for="txtpayalimt">Account Payable Limit :</label>
      			<input type="text" 
             	name="txtpayalimt" 
             	id="txtpayalimt" 
             	maxlength ="100"
              value="0" 
             	style="width: 100px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) 
             			{ 
             				document.getElementById('txtpayalimt').value = '0'; 
             				document.getElementById('txtpayalimt').focus(); 
             			}
             		else 
             			{ 
                            var inRupiah = convertToRupiah(this.value);
                            document.getElementById('txtpayalimt').value = inRupiah;
                            document.getElementById('txtbankname').focus();
             			}
             	}"

             	onclick="if (isNaN(this.value)) 
                        {
                            var inAngka = convertToAngka(this.value);
                            document.getElementById('txtpayalimt').value = inAngka
                            document.getElementById('txtpayalimt').focus();
                        }">        	

			<label for="txtbankname">Bank :</label>
      			<input type="text" 
             	name="txtbankname" 
             	id="txtbankname"
              autocomplete="off" 
             	maxlength ="60"
             	style="width: 200px;"
      			onkeyup="if (value.length > 0) 
              		{
              		ambilbankcode(this.value);
              		} 
            		else 
              		{ 
               		document.getElementById('tblbank').style.visibility = 'hidden';
              		}"
        			>
        		<input type="hidden" name="hidbankcode" id="hidbankcode">
        		

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="optavaifrwd">Available As Forwarder :</label>
      		<input type="checkbox"
            name="optavaifrwd" 
            id="optavaifrwd"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('hidavaifrwd').value = 'Y';
                  }   
                ">
      <input name="hidavaifrwd"
              id="hidavaifrwd"
              type="hidden">

        </div><!-- pure-control-group -->

        </fieldset>

        <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtmainname').value == '')
                  {
                    swal({
                        title: 'Nama Suplier Kosong' ,
                        text: 'Anda belum mengisi Nama Suplier, silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtmainaddr').value == '')
                  {
                      swal({
                          title: 'Alamat Suplier Kosong' ,
                          text: 'Anda belum mengisi Alamat, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaincity').value == '')
                  {
                      swal({
                          title: 'Nama Kota Kosong' ,
                          text: 'Anda belum mengisi Nama Kota, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmainctry').value == '')
                  {
                      swal({
                          title: 'Nama Negara Kosong' ,
                          text: 'Anda belum mengisi Nama Negara, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmainphne').value == '')
                  {
                      swal({
                          title: 'Nomor Handphone Kosong' ,
                          text: 'Anda belum mengisi Nomor Handphone, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmainpers').value == '')
                  {
                      swal({
                          title: 'Nama Kontak Person Kosong' ,
                          text: 'Anda belum mengisi Kontak Person, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn1').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn2').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn3').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn4').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn5').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaintidn6').value == '')
                  {
                      swal({
                          title: 'Nomor NPWP kosong' ,
                          text: 'Anda belum melengkapi data NPWP, silah periksa lagi',
                          icon: 'warning',
                          });
                  }


                  else if (document.getElementById('hidbankcode').value == '')
                  {
                      swal({
                          title: 'Nama Bank Kosong' ,
                          text: 'Anda belum melengkapi data Bank, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else
                  {
                      document.frmsuplmast.submit();
                  }
        ">Submit</a>
        </fieldset>

        <fieldset>

          <div id="tblbank" 
                style="position: absolute; 
                top:300px; 
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
<script src="js/SUPLMAST01.js"></script>

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
