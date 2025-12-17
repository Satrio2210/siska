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
<title>Create User</title>
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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_IDEN_NEW');
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
          
        </ul><!-- pure-menu-list -->
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
        <!-- <li class="pure-menu-item pure-menu-disabled"> -->                

          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Buat User
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN02.php'">
                <a class="pure-menu-link">
                Akses User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN03.php'">
                <a class="pure-menu-link">
                Hapus User
                </a>
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
    <form name="frmpassiden" class="pure-form pure-form-aligned" method="post" action="PASSIDEN01E.php">
        <fieldset>

          <div class="pure-control-group">

            <label for="txtuseriden">User ID :</label>
            <input type="text" 
                name="txtuseriden" 
                id="txtuseriden" 
                autocomplete="off"
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
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtusername').focus()">

            <span id="labelmessage" 
            class="pure-form-message" 
            style="visibility: hidden;">User ID is Exist!.</span>

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="txtusername">User Name :</label>
            <input type="text" 
                name="txtusername" 
                placeholder="Nama User" 
                id="txtusername"
                autocomplete="off" 
                maxlength ="20" 
                style="width: 230px;"
                onkeyup="if (value.length > 0) 
                  {
                  ambilemplcode(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblempl').style.visibility = 'hidden';
                  }"
              >
              <input type="hidden" name="hidemplcode" id="hidemplcode">

          </div><!-- pure-control-group -->

                <div class="pure-control-group">

      <label>Type User  :</label>
      <input type="checkbox"
            name="optdoctor" 
            id="optdoctor"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optnondoctor').checked = false;
                      document.getElementById('hidusertype').value = 'Y';
                  }                
                ">
            Medis.
      <input type="checkbox"
            name="optnondoctor" 
            id="optnondoctor"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optdoctor').checked = false;
                      document.getElementById('hidusertype').value = 'N';
                  }                
                ">
            Non Medis.
      <input name="hidusertype"
              id="hidusertype"
              type="hidden">

      </div><!-- pure-control-group -->


          <div class="pure-control-group">

          <label for="txtuserpswd">Password :</label>

            <input type="password" 
                name="txtuserpswd" 
                placeholder="Password" 
                id="txtuserpswd" 
                maxlength ="100" 
                style="width: 300px;"
            onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtuserpswd2').focus()">

            <input type="password" 
                name="txtuserpswd2" 
                placeholder="Password" 
                id="txtuserpswd2" 
                maxlength ="100" 
                style="width: 300px;"
            onkeydown="if (event.keyCode == 13 && value.length > 0 )
            {
              if (value == document.getElementById('txtuserpswd').value)
              {
                  if (document.getElementById('hidemplcode').value == '')
                    {
                      alert('Pilih Nama Pegawai !');
                      document.getElementById('txtusername').value = '';
                      document.getElementById('txtusername').focus();
                    }
                    else if (document.getElementById('hidusertype').value == '') 
                    {
                      alert('Pilih Tipe Staff !');
                      document.getElementById('txtusername').focus();

                    }
                  else
                    {
                      document.frmpassiden.submit();
                    }
              }
              else              
              {
                document.getElementById('labelmessage2').style.visibility = '';
                document.getElementById('txtuserpswd').value = '';
                document.getElementById('txtuserpswd2').value = '';
                document.getElementById('txtuserpswd').focus();
              }
            }
             ">
            <span id="labelmessage2" 
            class="pure-form-message" 
            style="visibility: hidden;">Password is not the same!.</span>

          </div><!-- pure-control-group -->            

        </fieldset>

        <fieldset>
        <a class="pure-button pure-button-primary" 
        onclick="javascript:  if (document.getElementById('txtuserpswd').value == document.getElementById('txtuserpswd2').value) 
                                {
                                  if (document.getElementById('hidemplcode').value == '')
                                  {
                                    alert('Pilih Nama Pegawai !');
                                    document.getElementById('txtusername').value = '';
                                    document.getElementById('txtusername').focus();
                                  }
                                  else if (document.getElementById('hidusertype').value == '') 
                                  {
                                    alert('Pilih Tipe Staff !');
                                    document.getElementById('txtusername').focus();

                                  }

                                  else
                                  {
                                    document.frmpassiden.submit();
                                  }
              
                                }
                            else
                                {
                                    document.getElementById('labelmessage2').style.visibility = '';
                                    document.getElementById('txtuserpswd').value = '';
                                    document.getElementById('txtuserpswd2').value = '';
                                    document.getElementById('txtuserpswd').focus();
                                }          
        ">Create</a>
        </fieldset>

        <fieldset>
                <div id="tblempl" 
                style="position: absolute; 
                top:300px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

    </form>

            <!--<div id ="labelmessage" 
                style = "position: absolute; 
                    top:200px; 
                    left: 600px; 
                    width: 500;
                    visibility: hidden;
                    z-index: 100" 
                class="error-message">
            <span class="error-text">User ID Sudah dipakai!</span>
      </div>-->


		</div><!-- div content -->
<div class="footerdate">
  	<span class="labelTime Time"><b>Date  :</b> <?php $tgl=date('d-m-Y'); echo $tgl;?></span>
</div>
<div class="footertime">
	<span class = "labelTime Time" id="timestamp"></span>
</div>


    	</div><!-- div main -->
</div><!-- div layout -->
<script src="js/PASSIDEN01.js"></script>
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
