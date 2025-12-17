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
<title>Kemasan</title>
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

<body onLoad="periksaakses('PASS_SPEC_ITEM');
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
                <a class="pure-menu-link">PERSEDIAAN</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Spesifikasi Item</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVEMAST00.php'">
                <a class="pure-menu-link">Master Item</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'WAREMAST00.php'">
                <a class="pure-menu-link">Ware House</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVETRANS00.php'">
                <a class="pure-menu-link">Transfer</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVESTOCK00.php'">
                <a class="pure-menu-link">Stock</a>
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

              <li class="pure-menu-item pure-menu-disabled">
                Kemasan
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLITYPE00.php'">
                <a class="pure-menu-link">
                Kategori
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLIVARN00.php'">
                <a class="pure-menu-link">
                Segmentasi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLISPEC00.php'">
                <a class="pure-menu-link">
                Spesifikasi
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtbliunit" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtunitcode">Kode :</label>
              <input type="text" 
            	  	name="txtunitcode" 
              		id="txtunitcode" 
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
                            document.getElementById('txtunitname').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length > 2) document.getElementById('txtunitname').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtunitname">Nama :</label>
              <input type="text" 
                  name="txtunitname" 
                  id="txtunitname" 
                  maxlength ="50"
                  style="width: 300px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtunitdevi').focus()">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="txtunitname">Pembagi :</label>
              <input type="text" 
              name="txtunitdevi" 
              id="txtunitdevi" 
              maxlength ="3" 
              value="1" 
              style="width: 40px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0)
              {
                  if (document.getElementById('txtunitcode').value == '')
                  {
                    swal({
                        title: 'Kode Unit Kosong' ,
                        text: 'Anda belum mengisi Kode Unit, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtunitcode').value = '';
                    document.getElementById('txtunitcode').focus();
                  }
                  else if (document.getElementById('txtunitname').value == '')
                  {
                      swal({
                          title: 'Nama Unit Kosong' ,
                          text: 'Anda belum mengisi Nama Unit, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtunitname').value = '';
                      document.getElementById('txtunitname').focus();
                  }

                   else
                   {
                       var inunitcode = document.getElementById('txtunitcode').value;
                       var inunitname = document.getElementById('txtunitname').value;
                       var inunitdevi = document.getElementById('txtunitdevi').value;
                       input(inunitcode,inunitname,inunitdevi);
                    }

              }"
              >
            </div><!-- pure-control-group --> 
      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtunitcode').value == '')
                  {
                    swal({
                        title: 'Kode Unit Kosong' ,
                        text: 'Anda belum mengisi Kode Unit, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtunitcode').value = '';
                    document.getElementById('txtunitcode').focus();
                  }
                  else if (document.getElementById('txtunitname').value == '')
                  {
                      swal({
                          title: 'Nama Unit Kosong' ,
                          text: 'Anda belum mengisi Nama Unit, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtunitname').value = '';
                      document.getElementById('txtunitname').focus();
                  }
                   else
                   {
                       var inunitcode = document.getElementById('txtunitcode').value;
                       var inunitname = document.getElementById('txtunitname').value;
                       var inunitdevi = document.getElementById('txtunitdevi').value;
                       input(inunitcode,inunitname,inunitdevi);
                    }
        ">Submit</a>
        </fieldset>

        <fieldset>
        <label for="txtsearch">Cari...</label>
        <input type="text" class="pure-input-rounded"
            name="txtsearch" 
            id="txtsearch" 
            maxlength ="20"
            style="width: 200px;"
            onkeyup="if (value.length > 0) { ambilscreen(this.value); } else {ambilscreen('')};"

            onkeydown="if (event.keyCode == 13 && value.length > 0) 
                        { 
                        document.getElementById('txtsearch').value = '';
                        document.getElementById('txtsearch').focus()
                        }">
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
<script src="js/TBLIUNIT01.js"></script>
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
