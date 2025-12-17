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
<title>Transfer Request</title>
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
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/sanie.js"></script>

<script type="text/javascript">
  $(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }

</script>

</head>
<body onLoad="periksaakses('PASS_TRANS_REQU');    
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLIUNIT00.php'">
                <a class="pure-menu-link">Spesifikasi Item</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVEMAST00.php'">
                <a class="pure-menu-link">Master Item</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'WAREMAST00.php'">
                <a class="pure-menu-link">Ware House</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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
                Transfer Request
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS02.php'">
                <a class="pure-menu-link">
                Transfer Approval
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS03.php'">
                <a class="pure-menu-link">
                Transfer Execution
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS04.php'">
                <a class="pure-menu-link">
                Transfer Receipt
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frminvetrans" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

            <label for="txtrequcode">Transaction No :</label>
              <input type="text" 
                name="txtrequcode" 
                id="txtrequcode"
                maxlength ="7"
                style="width: 90px;"
                readonly = "true">

            <label for="tglrequdate">Transaction Date :</label>
              <input type="date" name="tglrequdate" id="tglrequdate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('tgltrandate').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="tgltrandate">Deadline Transfer Date :</label>
              <input type="date" name="tgltrandate" id="tgltrandate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('tglrcvedate').focus()">

            <label for="tglrcvedate">Deadline Receipt Date :</label>
              <input type="date" name="tglrcvedate" id="tglrcvedate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('txtwarefrom').focus()">

          </div><!-- pure-control-group -->
      </fieldset>

      <fieldset>
        <legend>Location</legend>       

          <div class="pure-control-group">

            <label for="txtwarefrom">Warehouse From :</label>
              <input type="text" 
              name="txtwarefrom" 
              id="txtwarefrom" 
              autocomplete="off" 
              maxlength ="50" 
              style="width: 300px;"
              onkeyup="if (value.length > 0) 
                  {
                    ambilwarecode(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblware').style.visibility = 'hidden';
                  }"
              >
              <input type="hidden" name="hidwarefrom" id="hidwarefrom">

            <label for="txtlocaname">Location :</label>
              <input type="text" 
              name="txtlocaname" 
              id="txtlocaname" 
              maxlength ="50" 
              style="width: 300px;"
              readonly="true">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtwaredest">Warehouse To :</label>
              <input type="text" 
              name="txtwaredest" 
              id="txtwaredest"
              autocomplete="off" 
              maxlength ="50" 
              style="width: 300px;"
              onkeyup="if (value.length > 0) 
                  {
                    ambilwarecodeend(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblware').style.visibility = 'hidden';
                  }"
              >
              <input type="hidden" name="hidwaredest" id="hidwaredest">

            <label for="txtlocanamedest">Location :</label>
              <input type="text" 
              name="txtlocanamedest" 
              id="txtlocanamedest" 
              maxlength ="50" 
              style="width: 300px;"
              readonly="true">

          </div><!-- pure-control-group --> 

      </fieldset>


      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  
                  if (document.getElementById('hidwarefrom').value == '')
                    {
                      swal({
                          title: 'Warehouse pengirim belum diisi!',
                          text: 'Anda belum mengisi Warehouse asal, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtwarefrom').value = '';
                      document.getElementById('txtwarefrom').focus();
                    }

                  else if (document.getElementById('hidwaredest').value == '')
                    {
                      swal({
                          title: 'Warehouse tujuan belum diisi' ,
                          text: 'Anda belum mengisi Warehouse tujuan, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtwaredest').value = '';
                      document.getElementById('txtwaredest').focus();
                    }


                   else
                  {
                       var inrequcode = document.getElementById('txtrequcode').value;
                       var inrequdate = document.getElementById('tglrequdate').value;
                       var intrandate = document.getElementById('tgltrandate').value;
                       var inrcvedate = document.getElementById('tglrcvedate').value;
                       var inwarefrom = document.getElementById('hidwarefrom').value;
                       var inwaredest = document.getElementById('hidwaredest').value;

                       input(inrequcode,inrequdate,intrandate,inrcvedate,inwarefrom,inwaredest);
                    }
        ">Submit</a>
        </fieldset>

        <fieldset>
                <div id="tblware" 
                  style="position: absolute; 
                 top: 300px;
                 left: calc(70% - 350px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
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
<script src="js/INVETRANS01.js"></script>
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
