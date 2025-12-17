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
<title>Kategori</title>
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

              <li class="pure-menu-item  pure-menu-disabled">
                Kategori
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
    <form name="frmtblitype" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txttypecode">Kode :</label>
              <input type="text" 
            	  	name="txttypecode" 
              		id="txttypecode" 
              		maxlength ="4"
              		style="width: 70px;"
                  onkeyup="var start = this.selectionStart;
                          var end = this.selectionEnd;
                          this.value = this.value.toUpperCase();
                          this.setSelectionRange(start, end);
                          if (value.length > 3) 
                            {
                              periksaid(this.value);
                            }
                          else
                          {
                            document.getElementById('txttypename').setAttribute('disabled','true');
              							document.getElementById('optgeneral').setAttribute('disabled','true');
              							document.getElementById('optraw').setAttribute('disabled','true');
              							document.getElementById('optfinish').setAttribute('disabled','true');
              							document.getElementById('txttypenote').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length == 4) document.getElementById('txttypename').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txttypename">Nama :</label>
              <input type="text" 
                  name="txttypename" 
                  id="txttypename" 
                  maxlength ="50"
                  style="width: 300px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('optgeneral').focus()">

          </div><!-- pure-control-group -->


      	<div class="pure-control-group">

      <label for="optgeneral">Kategori :</label>
      <input type="checkbox"
            name="optgeneral" 
            id="optgeneral"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optraw').checked = false;
                      document.getElementById('optfinish').checked = false;
                      document.getElementById('hidtypecate').value = 'GE';
                  }                
                ">
            Umum.

      <input type="checkbox"
            name="optraw" 
            id="optraw"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optgeneral').checked = false;
                      document.getElementById('optfinish').checked = false;
                      document.getElementById('hidtypecate').value = 'RM';
                  }                
                ">
            Bahan Material.

      <input type="checkbox"
            name="optfinish" 
            id="optfinish"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optgeneral').checked = false;
                      document.getElementById('optraw').checked = false;
                      document.getElementById('hidtypecate').value = 'FG';
                  }                
                ">
            Barang Siap Pakai.

      <input name="hidtypecate"
              id="hidtypecate"
              type="hidden">

      </div><!-- pure-control-group -->

          <div class="pure-control-group">

          <label for="txttypenote">Note :</label>
              <input type="text" 
              name="txttypenote" 
              id="txttypenote" 
              maxlength ="100" 
              style="width: 500px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0)
              {
                  if (document.getElementById('txttypecode').value == '')
                  {
                    swal({
                        title: 'Kode Type Kosong' ,
                        text: 'Anda belum mengisi Kode Type, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txttypecode').value = '';
                    document.getElementById('txttypecode').focus();
                  }
                  else if (document.getElementById('txttypename').value == '')
                  {
                      swal({
                          title: 'Nama Type Kosong' ,
                          text: 'Anda belum mengisi Nama Type, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txttypename').value = '';
                      document.getElementById('txttypename').focus();
                  }

                   else
                   {
                       var intypecode = document.getElementById('txttypecode').value;
                       var intypename = document.getElementById('txttypename').value;
                       var intypecate = document.getElementById('hidtypecate').value; 
                       var intypenote = document.getElementById('txttypenote').value;
                       input(intypecode,intypename,intypecate,intypenote);
                    }

              }"
              >
            </div><!-- pure-control-group --> 
      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txttypecode').value == '')
                  {
                    swal({
                        title: 'Kode Type Kosong' ,
                        text: 'Anda belum mengisi Kode Type, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txttypecode').value = '';
                    document.getElementById('txttypecode').focus();
                  }
                  else if (document.getElementById('txttypename').value == '')
                  {
                      swal({
                          title: 'Nama Type Kosong' ,
                          text: 'Anda belum mengisi Nama Type, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txttypename').value = '';
                      document.getElementById('txttypename').focus();
                  }

                   else
                   {
                       var intypecode = document.getElementById('txttypecode').value;
                       var intypename = document.getElementById('txttypename').value;
                       var intypecate = document.getElementById('hidtypecate').value; 
                       var intypenote = document.getElementById('txttypenote').value;
                       input(intypecode,intypename,intypecate,intypenote);
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
<script src="js/TBLITYPE01.js"></script>
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
