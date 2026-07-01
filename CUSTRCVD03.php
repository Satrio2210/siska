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
<title>Cetak Kwitansi Massal</title>
<link rel="shortcut icon" href="img/icon.png">
<link rel="stylesheet" href="css/pure/pure-min.css">
<!--[if lte IE 8]>
	<link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
<![endif]-->
<!--[if gt IE 8]><!-->
	<link rel="stylesheet" href="css/layouts/side-menu.css">
<!--<![endif]-->
<style type="text/css">
    img { width: 100px; height: 100px; position: relative; top: 0px; left: 0px; }
    .button-print { background: rgb(223, 117, 20); color: white; }
    div.footerdate { position: fixed; left: 50; bottom: 50px; width: 90%; color: black; text-align: right; }
    div.footertime { position: fixed; left: 50; bottom: 20px; width: 90%; color: black; text-align: right; }
</style>
</head>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/sanie.js"></script>
<script>
$(document).ready(function()
{
    setInterval(timestamp, 1000);
});
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }

    function cetakkwitansi()
    {
        var start = document.getElementById('txtstart').value;
        var end   = document.getElementById('txtend').value;

        if (start == '' || end == '')
        {
            alert('Tanggal awal dan akhir harus diisi.');
            return;
        }
        if (start > end)
        {
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            return;
        }

        var url = 'CUSTRCVD03P.php?start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);
        window.open(url, '_blank');
    }
</script>

<body onLoad="periksaakses('PASS_CUST_RCVD');">
<div id="layout">
	<a href="#menu" id="menuLink" class="menu-link"><span></span></a>
    	<div id="menu">
        	<div class="pure-menu">
            <a class="pure-menu-heading" href="#"><?php echo $_SESSION['username'];?></a>
				<ul class="pure-menu-list">
	              <li class="pure-menu-item" onclick="javascript: location.href = 'index.php'">
	                <a class="pure-menu-link">KEUANGAN</a>
	              </li>
	              <li class="pure-menu-item" onclick="javascript: location.href = 'CUSTRCVD01.php'">
	                <a class="pure-menu-link">Pelunasan</a>
	              </li>
	              <li class="pure-menu-item menu-item-divided pure-menu-selected">
	                <a class="pure-menu-link">Cetak Kwitansi</a>
	              </li>
	              <li class="pure-menu-item" onclick="javascript: location.href = 'signout.php'">
	                <a class="pure-menu-link">EXIT</a>
	              </li>
				</ul>
			</div>
    	</div><!-- div menu -->

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

          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">
              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'CUSTRCVD01.php'">
                <a class="pure-menu-link">Transaksi</a>
              </li>
              <li class="pure-menu-item pure-menu-disabled">
                Cetak Kwitansi
              </li>
            </ul>
          </div>

    <form name="frmcetakkwitansi" class="pure-form pure-form-aligned" method="post" action="" onsubmit="return false;">
    	<fieldset>
    		<legend>Cetak Kwitansi Pasien Berobat (per Rentang Tanggal)</legend>

      		<div class="pure-control-group">
        		<label for="txtstart">Tanggal Awal :</label>
              		<input type="date"
            				name="txtstart"
              				id="txtstart"
			              	style="width: 200px;"
			                value="2026-01-01">
          	</div>

          	<div class="pure-control-group">
        		<label for="txtend">Tanggal Akhir :</label>
	              	<input type="date"
	                	name="txtend"
	                	id="txtend"
	                	style="width: 200px;"
	                	value="2026-06-30">
          	</div>

          	<div class="pure-controls">
                <a class="button-print pure-button" onclick="cetakkwitansi();">Cetak Semua Kwitansi (PDF)</a>
                <a class="button-update pure-button" onclick="javascript: location.href = 'CUSTRCVD01.php'">Close</a>
          	</div>
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