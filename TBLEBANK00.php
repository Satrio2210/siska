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
<title>Data Tambahan - Bank</title>
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
<script src="js/sweetalert.min.js"></script>

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_EMPL_ENTR');
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLMAST00.php'">
                <a class="pure-menu-link">PERSONEL</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Additional Data</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLPAYR00.php'">
                <a class="pure-menu-link">Payroll</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLEPOST00.php'">
                <a class="pure-menu-link">
                Position
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Bank
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtblebank" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtbankcode">Bank Code :</label>
              	<input type="text" 
            	  	name="txtbankcode" 
              		id="txtbankcode" 
              		maxlength ="3"
              		style="width: 100px;"
                  onkeyup="var start = this.selectionStart;
                          var end = this.selectionEnd;
                          this.value = this.value.toUpperCase();
                          this.setSelectionRange(start, end);
                          if (value.length > 2) 
                            {
                              periksaid(this.value);
                            }
                          else
                          {
                            document.getElementById('txtbankname').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length > 2) document.getElementById('txtbankname').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtbankname">Bank Name :</label>
              <input type="text" 
                  name="txtbankname" 
                  id="txtbankname" 
                  maxlength ="50"
                  style="width: 300px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0)
              {
                  if (document.getElementById('txtbankcode').value == '')
                  {
                    swal({
                        title: 'Kode Bank Kosong' ,
                        text: 'Anda belum mengisi Kode Bank, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtbankcode').value = '';
                    document.getElementById('txtbankcode').focus();
                  }
                  else if (document.getElementById('txtbankname').value == '')
                  {
                      swal({
                          title: 'Nama Bank Kosong' ,
                          text: 'Anda belum mengisi Nama Bank, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtbankname').value = '';
                      document.getElementById('txtbankname').focus();
                  }

                   else
                   {
                       var inpostcode = document.getElementById('txtbankcode').value;
                       var inpostname = document.getElementById('txtbankname').value;
                       input(inpostcode,inpostname);
                    }

              }"
              >

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtbankcode').value == '')
                  {
                    swal({
                        title: 'Kode Bank Kosong' ,
                        text: 'Anda belum mengisi Kode Bank, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtbankcode').value = '';
                    document.getElementById('txtbankcode').focus();
                  }
                  else if (document.getElementById('txtbankname').value == '')
                  {
                      swal({
                          title: 'Nama Bank Kosong' ,
                          text: 'Anda belum mengisi Nama Bank, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtbankname').value = '';
                      document.getElementById('txtbankname').focus();
                  }

                   else
                   {
                       var inpostcode = document.getElementById('txtbankcode').value;
                       var inpostname = document.getElementById('txtbankname').value;
                       input(inpostcode,inpostname);
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
<script src="js/TBLEBANK01.js"></script>
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
