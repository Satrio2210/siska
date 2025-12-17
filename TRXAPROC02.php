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
<title>Print Order</title>
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


  .button-delete {
      background: rgb(202, 60, 60);
            /* this is an maroon */
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
<script type="text/javascript" src="js/sanie.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="periksaakses('PASS_PROC_ENTR');">
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

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Buka PO</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC03.php'">
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

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">


             <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC01.php'">
                <a class="pure-menu-link">
                Input Order
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Print Order
              </li>


            </ul>
          </div>
    	<!-- Tab Menu -->


      <!-- Form Menu -->
          <form name="frmtrxaproc" class="pure-form" method="post" action="TRXAPROC01P.php">
            <fieldset>

                  <input type="hidden" 
                        name="hiduserid" 
                        id="hiduserid"
                        value="<?php echo $user;?>">

                
            </fieldset>
            <fieldset>
                      <div  id="tblviewpo" 
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
<script src="js/TRXAPROC02.js"></script>

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
