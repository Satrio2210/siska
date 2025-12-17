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
<title>Divisi</title>
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
        .button-update {
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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_DIVI_ENTR');
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

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Divisi</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'REPOACCT00.php'">
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLEDIVI01.php'">
                <a class="pure-menu-link">
                Buat Divisi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Ubah Divisi
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLEDIVI03.php'">
                <a class="pure-menu-link">
                Hapus Divisi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLEDIVI04.php'">
                <a class="pure-menu-link">
                Lihat Divisi
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtbledivi" class="pure-form pure-form-aligned" method="post" action="TBLEDIVI02U.php">
      <fieldset>
        <div class="pure-control-group">
        <label for="txtdivicode">Kode Divisi :</label>
              <input type="text" 
              name="txtdivicode" 
              id="txtdivicode" 
              maxlength ="3"
              style="width: 60px;"
            onkeyup="var start = this.selectionStart;
                     var end = this.selectionEnd;
                     this.value = this.value.toUpperCase();
                     this.setSelectionRange(start, end);
                     if (value.length == 3) 
                        {
                            periksadivi(this.value);
                        }
                    else
                        {
                            document.getElementById('labelmessage').style.visibility = 'hidden';
                            document.getElementById('labelmessage').innerHTML='';
                        }"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtdiviname').focus()">

                <input type="hidden"
                name="hiddivicode"
                id="hiddivicode">

            <span id="labelmessage" 
            class="pure-form-message" 
            style="visibility: hidden;">Code Division Not Found!.</span>
        </div><!-- pure-control-group -->

      <div class="pure-control-group">
        <label for="txtdiviname">Nama Divisi :</label>
              <input type="text" 
              name="txtdiviname" 
              id="txtdiviname" 
              maxlength ="100" 
              style="width: 800px;"
            onkeydown="if (event.keyCode == 13 && value.length > 0 )
                        {
                          if (document.getElementById('txtdivicode').value.length == 3)
                              {
                              document.frmtbledivi.submit();  
                              }
                          else              
                              {
                              document.getElementById('labelmessage2').style.visibility = '';
                              document.getElementById('txtdivicode').focus();
                              }
                         }
            ">
         <span id="labelmessage2" 
            class="pure-form-message" 
            style="visibility: hidden;">Fill Code Divisi.</span>

      </div><!-- pure-control-group -->
    </fieldset>
      <fieldset>
          <a class="pure-button button-update" onclick="javascript:
              if (document.getElementById('txtdivicode').value.length == 3)
              {
                document.frmtbledivi.submit();  
              }
              else              
              {
                document.getElementById('labelmessage2').style.visibility = '';
                document.getElementById('txtdivicode').focus();
              }
        ">Submit</a>
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
<script src="js/TBLEDIVI02.js"></script>
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
