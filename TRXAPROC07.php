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
<title>Purchase Return</title>
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

<body onLoad="periksaakses('PASS_PROC_INVC');
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
        <div class="headerlogo">
        </div>

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC05.php'">
                <a class="pure-menu-link">
                Buat Invoice
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC06.php'">
                <a class="pure-menu-link">
                Print Invoice
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Purchase Return
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxaproc" class="pure-form pure-form-aligned" method="post" action="TRXAPROC07P.php">
    	<fieldset>
        <legend>Suplier</legend>

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

            <label for="txtsupladdr">Address :</label>
              <input type="text" 
                  name="txtsupladdr" 
                  id="txtsupladdr" 
                  maxlength ="100"
                  style="width: 600px;"
                  readonly="true">

          </div><!-- pure-control-group -->
        </fieldset>

        <fieldset>
          <legend>Return</legend>
            <div class="pure-control-group">
              <label for="txtretucode">Purchase Return Code :</label>
              <input type="text" 
                  name="txtretucode" 
                  id="txtretucode" 
                  maxlength ="11"
                  style="width: 150px;"
                  readonly="true">  

                  <input type="hidden" name="hidproccode" id="hidproccode">

              <label for="tglretudate">Return Date :</label>

              <input type="date" name="tglretudate" id="tglretudate" value="<?php echo $datenow; ?>" 
                onchange="document.getElementById('txtretunote').focus()">

            </div><!-- pure-control-group -->          

          <div class="pure-control-group">

            <label for="txtdiviname">Division :</label>
              <input type="text" 
                  name="txtdiviname" 
                  id="txtdiviname" 
                  maxlength ="50"
                  style="width: 200px;"
                  readonly="true">

                  <input type="hidden" name="hidretudivi" id="hidretudivi">
                  <input type="hidden" name="hidretustat" id="hidretustat">
          </div><!-- pure-control-group -->

            <div class="pure-control-group">
            <label for="txtretunote">Notes :</label>
              <input type="text" 
                  name="txtretunote" 
                  id="txtretunote" 
                  maxlength ="100"
                  style="width: 500px;">
            </div><!-- pure-control-group -->

        </fieldset>

      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:

                  if (document.getElementById('txtsuplname').value == '')
                  {
                    swal({
                        title: 'Data Kosong' ,
                        text: 'Anda belum memilih item di bawah',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('txtretunote').value == '')
                  {
                    swal({
                        title: 'Notes Kosong' ,
                        text: 'Anda belum isi keterangan note',
                        icon: 'warning',
                        });
                  }

                   else
                   {
                       var inretucode = document.getElementById('txtretucode').value;
                       var inretudate = document.getElementById('tglretudate').value;
                       var inproccode = document.getElementById('hidproccode').value;
                       var inretudivi = document.getElementById('hidretudivi').value;
                       var inretustat = document.getElementById('hidretustat').value;
                       var insuplcode = document.getElementById('hidsuplcode').value;
                       var inretunote = document.getElementById('txtretunote').value;

                       input(inretucode,inretudate,inproccode,inretudivi,inretustat,insuplcode,inretunote);
                       //document.frmtrxaproc.submit();
                    }
        ">Submit</a>
        </fieldset>
      <fieldset>
          <div id="tblscreen">
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
<script src="js/TRXAPROC07.js"></script>
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
