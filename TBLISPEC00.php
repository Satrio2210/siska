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
<title>Spesifikasi</title>
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
            <h2>S.A.N.I</h2>
        </div><!-- div header -->
        <div class="headerlogo">
        </div>

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TBLIUNIT00.php'">
                <a class="pure-menu-link">
                Kemasan
            	</a>
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

              <li class="pure-menu-item pure-menu-disabled">
                Spesifikasi
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtblivarn" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtspeccode">Spec Code :</label>
              <input type="text" 
            	  	name="txtspeccode" 
              		id="txtspeccode" 
              		maxlength ="2"
              		style="width: 50px;"
                  onkeyup="var start = this.selectionStart;
                          var end = this.selectionEnd;
                          this.value = this.value.toUpperCase();
                          this.setSelectionRange(start, end);
                          if (value.length > 1) 
                            {
                              periksaid(this.value);
                            }
                          else
                          {
                            document.getElementById('txtspecname').setAttribute('disabled','true');
                            document.getElementById('txtspecnote').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length > 1) document.getElementById('txtspecname').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtspecname">Spec Name :</label>
              <input type="text" 
                  name="txtspecname" 
                  id="txtspecname" 
                  maxlength ="50"
                  style="width: 300px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtspecnote').focus()">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="txtspecnote">Spec Note :</label>
              <input type="text" 
              name="txtspecnote" 
              id="txtspecnote" 
              maxlength ="100" 
              style="width: 500px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0)
              {
                  if (document.getElementById('txtspeccode').value == '')
                  {
                    swal({
                        title: 'Kode Spec Kosong' ,
                        text: 'Anda belum mengisi Kode Spec, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtspeccode').value = '';
                    document.getElementById('txtspeccode').focus();
                  }
                  else if (document.getElementById('txtspecname').value == '')
                  {
                      swal({
                          title: 'Nama Spec Kosong' ,
                          text: 'Anda belum mengisi Nama Spec, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtspecname').value = '';
                      document.getElementById('txtspecname').focus();
                  }
                  else if (document.getElementById('txtspecnote').value == '')
                  {
                      swal({
                          title: 'Note Spec Kosong' ,
                          text: 'Anda belum mengisi Note Spec, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtspecnote').value = '';
                      document.getElementById('txtspecnote').focus();
                  }

                   else
                   {
                       var inspeccode = document.getElementById('txtspeccode').value;
                       var inspecname = document.getElementById('txtspecname').value;
                       var inspecnote = document.getElementById('txtspecnote').value;
                       input(inspeccode,inspecname,inspecnote);
                    }

              }"
              >
            </div><!-- pure-control-group --> 
      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtspeccode').value == '')
                  {
                    swal({
                        title: 'Kode Spec Kosong' ,
                        text: 'Anda belum mengisi Kode Spec, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtspeccode').value = '';
                    document.getElementById('txtspeccode').focus();
                  }
                  else if (document.getElementById('txtspecname').value == '')
                  {
                      swal({
                          title: 'Nama Spec Kosong' ,
                          text: 'Anda belum mengisi Nama Spec, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtspecname').value = '';
                      document.getElementById('txtspecname').focus();
                  }
                  else if (document.getElementById('txtspecnote').value == '')
                  {
                      swal({
                          title: 'Note Spec Kosong' ,
                          text: 'Anda belum mengisi Note Spec, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtspecnote').value = '';
                      document.getElementById('txtspecnote').focus();
                  }

                   else
                   {
                       var inspeccode = document.getElementById('txtspeccode').value;
                       var inspecname = document.getElementById('txtspecname').value;
                       var inspecnote = document.getElementById('txtspecnote').value;
                       input(inspeccode,inspecname,inspecnote);
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
<script src="js/TBLISPEC01.js"></script>
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
