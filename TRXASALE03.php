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
<title>Report Harian Bulanan</title>
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
      width: 100px; height: 100px;
      position: relative;
      top: 0px; left: 0px;
        }

  .button-print {
            background: rgb(223, 117, 20);
            /* this is an orange */
        }

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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_SALE_VIEW');
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
                <a class="pure-menu-link">KASIR</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXASALE01.php'">
                <a class="pure-menu-link">Transaksi</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Harian / Bulanan
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXASALE04.php'">
                <a class="pure-menu-link">
                Fee Analis Laboratorium
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXASALE05.php'">
                <a class="pure-menu-link">
                Fee Dokter
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXASALE06.php'">
                <a class="pure-menu-link">
                Fee Bidan
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

      <form name="frmreport" class="pure-form" method="post" action="TRXASALE03P.php">

      <fieldset>
          <label for="tglstartdate">Start</label>

          <input type="date" 
          name="tglstartdate" 
          id="tglstartdate"
          value="<?php echo $datenow;?>" 
          onchange="document.getElementById('tglenddate').value = this.value;">

          <label for="tglenddate">End</label>

          <input type="date" 
          name="tglenddate" 
          id="tglenddate"
          value="<?php echo $datenow;?>" 
          onchange="ambilviewrepo(document.getElementById('tglstartdate').value,this.value);">

          <a class="pure-button button-print" 
          onclick="javascript: document.frmreport.submit();">Print</a>

      </fieldset>

      <fieldset>
        <div id="tblviewrepo">
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
<script src="js/TRXASALE03.js"></script>
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
