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

</style>

<style type="text/css">
	div.footerdate {
   position: fixed;
   left: 50;
   bottom: 50px;
   width: 85%;
   color: black;
   text-align: right;
}
div.footertime {
   position: fixed;
   left: 50;
   bottom: 20px;
   width: 84%;
   color: black;
   text-align: right;
}
</style>
</head>

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="ambilviewid('x');">
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
					<a class="pure-menu-link">AKSES</a>
				</li>

				<li class="pure-menu-item" onclick="javascript: location.href = 'GL.php'">
					<a class="pure-menu-link">AKUNTING</a>
				</li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'INVENTORY.php'">
		          <a class="pure-menu-link">PERSEDIAAN</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'PURCHASING.php'">
		          <a class="pure-menu-link">PEMBELIAN</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPATI01.php'">
		          <a class="pure-menu-link">ADMISI</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI00.php'">
		          <a class="pure-menu-link">RAWAT JALAN</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXALABO00.php'">
		          <a class="pure-menu-link">LABORATORIUM</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'CUSTMAST00.php'">
		          <a class="pure-menu-link">REKANAN</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXASALE00.php'">
		          <a class="pure-menu-link">KASIR</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADRUG00.php'">
		          <a class="pure-menu-link">FARMASI</a>
		        </li>
		        
		        <li class="pure-menu-item" onclick="javascript: location.href = '##'">
		          <a class="pure-menu-link">FARMASI New</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'MEDIRECO00.php'">
		          <a class="pure-menu-link">REKAM MEDIS</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAVEND00.php'">
		          <a class="pure-menu-link">KEUANGAN</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'FIXEDASSET.php'">
		          <a class="pure-menu-link">ASSET TETAP</a>
		        </li>

		        <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLMAST00.php'">
		          <a class="pure-menu-link">PERSONIL</a>
		        </li>

				<li class="pure-menu-item" onclick="javascript: location.href = 'signout.php'">
		          <a class="pure-menu-link">EXIT</a>
		        </li>

				</ul><!-- pure-menu-list -->

		    </div><!-- div pure-menu -->
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
        <!--/div-->

        </div><!-- div header -->

		<div class="content">

          		<div id="tblviewdata">			


		</div><!-- div content -->
    <!-- foot -->

<div style="padding: 400px 0 30px 0;">
  <center>
  &copy; 2020, Made in Jakarta..  
  </center>>
</div>

<div class="footerdate">
  	<span class="labelTime Time"><b>Date  :</b> <?php $tgl=date('d-m-Y'); echo $tgl;?></span>
</div>
<div class="footertime">
	<span class = "labelTime Time" id="timestamp"></span>
</div>


    	</div><!-- div main -->
</div><!-- div layout -->
<script src="js/VIEWDATA.js"></script>

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
