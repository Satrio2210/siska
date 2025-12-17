<!doctype html>
<?php include "conf/config.php";
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
	$user = $_SESSION['username'];
  // Periksa Akses dimulai
  if ($user !="$idadmin")
  {
    $query_akses = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN = '$user' AND PASS_INVE_ENTR = 'Y'";
    $qakses = $db->query($query_akses) or die("Gagal Ambil Nilai Akses!!");
    $row = $qakses->fetchColumn();

    if ($row == 0)
    {
    header("Location: "."WAREMAST00.php");
    }
  }
  // Periksa Akses selesai  

?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="System Accounting Native Information">
<title>System Accounting Native Information</title>
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

<body onLoad="document.getElementById('txtlocacode').focus();
document.getElementById('txtlocaname').setAttribute('disabled','true');
document.getElementById('txtlocaaddr').setAttribute('disabled','true');
document.getElementById('txtemplname').setAttribute('disabled','true');
document.getElementById('txtlocanote').setAttribute('disabled','true');
ambilscreen('');
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

            <li class="pure-menu-item" onclick="javascript: location.href = 'SYSTEM.php'">
              <a class="pure-menu-link">SYSTEM</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'GL.php'">
               <a class="pure-menu-link">ACCOUNTING</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'index.php'">
                <a class="pure-menu-link">INVENTORY</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'SUPLMAST00.php'">
              <a class="pure-menu-link">Suplier</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TBLIUNIT00.php'">
              <a class="pure-menu-link">Support Item</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'INVEMAST00.php'">
              <a class="pure-menu-link">Master Item</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
              <a class="pure-menu-link">Ware House</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'INVETRANS00.php'">
              <a class="pure-menu-link">Transfer</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'INVESTOCK00.php'">
              <a class="pure-menu-link">Stock</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'PURCHASING.php'">
                <a class="pure-menu-link">PURCHASING</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'CUSTMAST00.php'">
                <a class="pure-menu-link">C.R.M.</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXASALE00.php'">
                <a class="pure-menu-link">SALES</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAFINA00.php'">
                <a class="pure-menu-link">FINANCE</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'FIXEDASSET.php'">
                <a class="pure-menu-link">FIXED ASSET</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLMAST00.php'">
                <a class="pure-menu-link">HUMAN RESOURCES</a>
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
        <div class="headerlogo">
        </div>

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-disabled">
                Location
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'WAREMAST01.php'">
                <a class="pure-menu-link">
                Ware House
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'WAREMAST05.php'">
                <a class="pure-menu-link">
                Distance Ware House
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmfixeloca" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtlocacode">Location Code :</label>
              <input type="text" 
            	  	name="txtlocacode" 
              		id="txtlocacode" 
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
                            document.getElementById('txtlocaname').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length > 2) document.getElementById('txtlocaname').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtlocaname">Location Name :</label>
              <input type="text" 
                  name="txtlocaname" 
                  id="txtlocaname" 
                  maxlength ="50"
                  style="width: 300px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtlocaaddr').focus()">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtlocaaddr">Location Address :</label>
              <input type="text" 
                  name="txtlocaaddr" 
                  id="txtlocaaddr" 
                  maxlength ="100"
                  style="width: 500px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtemplname').focus()">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtemplname">Employee Name :</label>
              <input type="text" 
                  name="txtemplname" 
                  id="txtemplname" 
                  maxlength ="50"
                  style="width: 300px;"
                autocomplete="off"
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

          <label for="txtlocanote">Location Note :</label>
              <input type="text" 
              name="txtlocanote" 
              id="txtlocanote" 
              maxlength ="100" 
              style="width: 500px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0)
              {
                  if (document.getElementById('txtlocacode').value == '')
                  {
                    swal({
                        title: 'Kode Lokasi Kosong' ,
                        text: 'Anda belum mengisi Kode Lokasi, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtlocacode').value = '';
                    document.getElementById('txtlocacode').focus();
                  }
                  else if (document.getElementById('txtlocaname').value == '')
                  {
                      swal({
                          title: 'Nama Lokasi Kosong' ,
                          text: 'Anda belum mengisi Nama Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtlocaname').value = '';
                      document.getElementById('txtlocaname').focus();
                  }
                  else if (document.getElementById('txtlocaaddr').value == '')
                  {
                      swal({
                          title: 'Alamat Lokasi Kosong' ,
                          text: 'Anda belum mengisi Alamat Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtlocaaddr').value = '';
                      document.getElementById('txtlocaaddr').focus();
                  }
                  else if (document.getElementById('hidemplcode').value == '')
                  {
                      swal({
                          title: 'Nama Staff Kosong' ,
                          text: 'Anda belum mengisi Nama Staff Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtemplname').value = '';
                      document.getElementById('txtemplname').focus();
                  }

                   else
                   {
                       var inlocacode = document.getElementById('txtlocacode').value;
                       var inlocaname = document.getElementById('txtlocaname').value;
                       var inlocaaddr = document.getElementById('txtlocaaddr').value;
                       var inemplcode = document.getElementById('hidemplcode').value;
                       var inlocanote = document.getElementById('txtlocanote').value;
                       input(inlocacode,inlocaname,inlocaaddr, inemplcode, inlocanote);
                    }

              }"
              >
            </div><!-- pure-control-group --> 
      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
			if ( document.getElementById('txtlocanote').value.length > 0)
              {
                  if (document.getElementById('txtlocacode').value == '')
                  {
                    swal({
                        title: 'Kode Lokasi Kosong' ,
                        text: 'Anda belum mengisi Kode Lokasi, silah periksa lagi',
                        icon: 'warning',
                        });
                    document.getElementById('txtlocacode').value = '';
                    document.getElementById('txtlocacode').focus();
                  }
                  else if (document.getElementById('txtlocaname').value == '')
                  {
                      swal({
                          title: 'Nama Lokasi Kosong' ,
                          text: 'Anda belum mengisi Nama Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtlocaname').value = '';
                      document.getElementById('txtlocaname').focus();
                  }
                  else if (document.getElementById('txtlocaaddr').value == '')
                  {
                      swal({
                          title: 'Alamat Lokasi Kosong' ,
                          text: 'Anda belum mengisi Alamat Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtlocaaddr').value = '';
                      document.getElementById('txtlocaaddr').focus();
                  }
                  else if (document.getElementById('hidemplcode').value == '')
                  {
                      swal({
                          title: 'Nama Staff Kosong' ,
                          text: 'Anda belum mengisi Nama Staff Lokasi, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtemplname').value = '';
                      document.getElementById('txtemplname').focus();
                  }

                   else
                   {
                       var inlocacode = document.getElementById('txtlocacode').value;
                       var inlocaname = document.getElementById('txtlocaname').value;
                       var inlocaaddr = document.getElementById('txtlocaaddr').value;
                       var inemplcode = document.getElementById('hidemplcode').value;
                       var inlocanote = document.getElementById('txtlocanote').value;
                       input(inlocacode,inlocaname,inlocaaddr, inemplcode, inlocanote);
                    }

              }        ">Submit</a>
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
<script src="js/FIXELOCA01.js"></script>
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
