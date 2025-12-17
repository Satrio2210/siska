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
<title>Pelunasan</title>
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

<body onLoad="periksaakses('PASS_CUST_RCVD'); 
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

	              <li class="pure-menu-item menu-item-divided pure-menu-selected">
	                <a class="pure-menu-link">Pelunasan</a>
	              </li>

	              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPAYM00.php'">
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'CUSTRCVD02.php'">
                <a class="pure-menu-link">
                Report
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmcustrcvd" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>


      		<div class="pure-control-group">

        		<label for="txtregicode">No. Daftar :</label>
              		<input type="text" 
            				name="txtregicode" 
              				id="txtregicode" 
			              	maxlength ="50"
			              	style="width: 250px;"
			                readonly="true">


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
	                  style="width: 300px;"
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

                <input type="hidden" name="hidsalecode" id="hidsalecode">
            </div><!-- pure-control-group --> 

          	<div class="pure-control-group">

              	<label for="optpaymmode">Penerimaan :</label>
              		<select name="optpaymmode" id="optpaymmode" onchange="document.getElementById('optpaymmode').focus();">
                		<option value="TUN">Tunai/Cash</option>
		                <option value="BCA">Debit BCA</option>
		                <option value="MAN">Debit Mandiri</option>
		                <option value="BNI">Debit BNI</option>
		                <option value="BCM">Transfer BCA</option>
		                <option value="LIN">Transfer Link Aja</option>
		            </select>

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>

          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtregicode').value == '')
                  {
                    swal({
                        title: 'Register Kosong' ,
                        text: 'Anda belum memilih data kwitansi, silah periksa lagi',
                        icon: 'warning',
                        });
                  }
                  else if (document.getElementById('hidsalecode').value == '')
                  {
                      swal({
                          title: 'No Kwitansi Kosong' ,
                          text: 'Anda belum memilih data kwitansi, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inregicode = document.getElementById('txtregicode').value;
                       var insalecode = document.getElementById('hidsalecode').value;
                       var inpaymmode = document.getElementById('optpaymmode').value;

                       input(inregicode,insalecode, inpaymmode);
                    }
        ">Paid Off</a>

          <a class="button-update pure-button" onclick="javascript: location.href = 'CUSTRCVD01.php'">Close</a>


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
          <div id="tblsale" 
            style="position: absolute; 
                 top: 200px;
                 left: calc(75% - 350px);
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
<script src="js/CUSTRCVD01.js"></script>
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
