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
<title>Tagihan</title>
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
<script type="text/javascript" src="js/sanie.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="periksaakses('PASS_PROC_INVC');
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC01.php'">
                <a class="pure-menu-link">Buka PO</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC03.php'">
                <a class="pure-menu-link">Barang Masuk</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Buat Invoice
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC06.php'">
                <a class="pure-menu-link">
                Print Invoice
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC07.php'">
                <a class="pure-menu-link">
                Purchase Return
                </a>
              </li>

            </ul>
          </div>
    	<!-- Tab Menu -->
    <!-- Form Input -->
    <form name="frmtrxaproc" class="pure-form pure-form-aligned" method="post" action="">

    <fieldset>

      <div class="pure-control-group">

        <label for="txtsearch">Ambil PO  :</label>
        <input type="text" name="txtsearch" id="txtsearch"
        maxlength="10" style="width: 100px"
        onkeyup="if (value.length > 0) 
              {
              ambilpocode(this.value);
              } 
            else 
              { 
               document.getElementById('tblpo').style.visibility = 'hidden';
              }"
        >

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

  		<label for="txtinvccode">Nomor Invoice :</label>
      	<input type="text" 
             name="txtinvccode" 
             id="txtinvccode"
             maxlength ="20"
             style="width: 200px;"
             onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('tglinvcdate').focus()">
             

        <label for="tglinvcdate">Tanggal Invoice :</label>
        <input type="date" name="tglinvcdate" id="tglinvcdate" value="<?php echo $datenow; ?>">

      </div><!-- pure-control-group -->


      <div class="pure-control-group">

        <label for="txtproccode">Nomor PO :</label>
        <input type="text" name="txtproccode" id="txtproccode"
        maxlength="7" style="width: 100px"
        readonly="true"> 

        <label for="tgldueddate">Jatuh Tempo :</label>
        <input type="date" name="tgldueddate" id="tgldueddate" 
        readonly="true">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

        <label for="txtsuplname">Pemasok :</label>
        <input type="text" 
             name="txtsuplname" 
             id="txtsuplname"
             maxlength ="50"
             style="width: 400px;"
             readonly = "true">

        <input type="hidden" name="hidsuplcode" id="hidsuplcode">

      </div><!-- pure-control-group -->      

      <fieldset>

        <a class="pure-button pure-button-primary" 
        onclick="javascript: if (document.getElementById('txtinvccode').value == 0) 
                            {

                              swal({
                                  title: 'Nomor Invoice Kosong' ,
                                  text: 'Anda belum mengisi No. Invoice, silah periksa lagi',
                                  icon: 'warning',
                                  });
                            }
                            else
                            {
                              if (confirm ('Are You Sure To Create Invoice?')) 
                                { 
                                	var invccode = document.getElementById('txtinvccode').value;
                                	var invcdate = document.getElementById('tglinvcdate').value;
                                	var proccode = document.getElementById('txtproccode').value;
                                	var dueddate = document.getElementById('tgldueddate').value;
                                	var suplcode = document.getElementById('hidsuplcode').value;	
                                  input(invccode,invcdate,proccode,dueddate,suplcode);
                                  //alert(document.getElementById('txtproccode').value); 
                                } 
                              else 
                                { 
                                  document.getElementById('txtsearch').focus(); 
                                }                                             
                            }
        ">Buat Invoice</a>
              <div id="tbltrxascreen">
                
        </fieldset>
            <fieldset>
                <div id="tblpo" 
                style="position: absolute; 
                 top: 200px;
                 left: calc(60% - 100px);
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

<script src="js/TRXAPROC05.js"></script>
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
