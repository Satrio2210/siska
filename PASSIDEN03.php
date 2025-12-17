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
<meta name="description" content="System Accounting Native Information">
<title>Hapus User</title>
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

<body onLoad="periksaakses('PASS_IDEN_DELL');
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

        <li class="pure-menu-item menu-item-divided pure-menu-selected" onclick="javascript: location.href = 'index.php'">
          <a class="pure-menu-link">AKSES</a>
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

            <h1 id="login">System Accounting Native Information</h1>
            <h2>S.A.N.I</h2>
        </div><!-- div header -->

		<div class="content">
        <!-- Tab Menu -->
        <!-- <li class="pure-menu-item pure-menu-disabled"> -->                

          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN01.php'">
                <a class="pure-menu-link">
                Buat User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN02.php'">
                <a class="pure-menu-link">              
                Akses User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Hapus User
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN04.php'">
                <a class="pure-menu-link">
                Tampil User
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmpassiden" class="pure-form pure-form-aligned" method="post" action="PASSIDEN03D.php">

        <fieldset>

          <div class="pure-control-group">

            <label for="txtuseriden">User ID :</label>

            <input type="text" 
                name="txtuseriden" 
                id="txtuseriden" 
                maxlength ="5" 
                style="width: 80px;"
                onkeyup="var start = this.selectionStart;
                     var end = this.selectionEnd;
                     this.value = this.value.toUpperCase();
                     this.setSelectionRange(start, end);
                     if (value.length == 5) 
                        {
                            periksaid (this.value);
                        }
                    else
                        {
                            document.getElementById('labelmessage').style.visibility = 'hidden';
                        }"
                onkeydown="if (event.keyCode == 13 && value.length == 5)
                          {
                            if (confirm ('Are You Sure To Delete?')) 
                                { document.frmpassiden.submit(); }
                                else 
                                { location.href = 'PASSIDEN03.php'; }                           
                          }">
            <span id="labelmessage" 
            class="pure-form-message" 
            style="visibility: hidden;">User ID not found!.</span>

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtusername">User Name</label>

            <input type="text" 
                name="txtusername" 
                placeholder="Nama User" 
                id="txtusername" 
                maxlength ="20" 
                style="width: 230px;"
                readonly = "true">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="txtuserpswd">Password</label>

            <input type="password" 
                name="txtuserpswd" 
                placeholder="Password" 
                id="txtuserpswd" 
                maxlength ="100" 
                style="width: 300px;"
                readonly = "true">

          </div><!-- pure-control-group -->

          <fieldset>
            
        <a class="pure-button button-delete" 
        onclick="javascript: 
        if (confirm ('Are You Sure To Delete?')) 
                                { document.frmpassiden.submit(); }
                                else 
                                { location.href = 'PASSIDEN03.php'; }
        ">Delete</a>
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

<script src="js/PASSIDEN03.js"></script>
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
