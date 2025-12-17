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
<title>Profit Loss</title>
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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="periksaakses('PASS_REPO_VIEW');">
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
                <a class="pure-menu-link">AKUNTING</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAJRNL00.php'">
                <a class="pure-menu-link">Jurnal</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'COACMAST00.php'">
                <a class="pure-menu-link">C.O.A.</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLACOAC00.php'">
                <a class="pure-menu-link">Grup Akun</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLEDIVI00.php'">
                <a class="pure-menu-link">Divisi</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Laporan</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'REPOACCT01.php'">
                <a class="pure-menu-link">
                General Ledger
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'REPOACCT02.php'">
                <a class="pure-menu-link">
                Trial Balance
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Profit Loss
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'REPOACCT04.php'">
                <a class="pure-menu-link">
                Equity
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'REPOACCT05.php'">
                <a class="pure-menu-link">
                Neraca
                </a>
              </li>


            </ul>
          </div>
      <!-- Tab Menu -->

      <!-- Form Menu -->
          <form name="frmrepoacct" class="pure-form" method="post" action="REPOACCT03P.php">
            <fieldset>
                  <input type="hidden" 
                        name="tglstartdate" 
                        id="tglstartdate"
                        value="<?php echo $yearnow;?>-01-01">

                  <label for="tglenddate">Periode</label>
                  <input type="date" 
                        name="tglenddate" 
                        id="tglenddate"
                        value="<?php echo $datenow;?>" 
                        onchange="ambilviewrepo(document.getElementById('tglstartdate').value ,document.getElementById('tglenddate').value);">

                <a class="pure-button button-print" onclick="javascript: document.frmrepoacct.submit();">Print</a>
            </fieldset>
            <fieldset>
                      <div  id="tblviewrepo" 
              style="position:absolute;
                          background-color:white;

                          width:300;
                          z-index:100">

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
<script src="js/REPOACCT03.js"></script>
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
