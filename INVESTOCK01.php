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
<title>Stock Opname</title>
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
  
  .button-print {
            background: rgb(223, 117, 20);
            /* this is an orange */
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
<script type="text/javascript" src="js/sanie.js"></script>
<script src="js/sweetalert.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }

</script>

</head>
<body onLoad="periksaakses('PASS_STOCK_OPNA'); 
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVETRANS00.php'">
                <a class="pure-menu-link">Transfer</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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
                Stock Opname
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVESTOCK02.php'">
                <a class="pure-menu-link">
                Stock Adjustment
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVESTOCK03.php'">
                <a class="pure-menu-link">
                Stock Execute
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVESTOCK04.php'">
                <a class="pure-menu-link">
                Stock Report
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frminvestock" class="pure-form pure-form-aligned" method="post" action="INVETRANS03P.php">
    	<fieldset>

      		<div class="pure-control-group">

            <label for="txtopnacode">Transaction No :</label>
              <input type="text" 
                name="txtopnacode" 
                id="txtopnacode"
                maxlength ="7"
                style="width: 90px;"
                readonly = "true">

            <label for="tglopnadate">Transaction Date :</label>
              <input type="date" name="tglopnadate" id="tglopnadate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('txtwarename').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtwarename">Warehouse :</label>
              <input type="text" 
                name="txtwarename" 
                id="txtwarename"
                maxlength ="50"
                autocomplete="off" 
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
              <input type="hidden" name="hidwarecode" id="hidwarecode">


          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtopnadlay">Stock Opname Delay :</label>
                <input type="text" 
                name="txtopnadlay" 
                id="txtopnadlay" 
                maxlength ="100" 
                style="width: 400px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtinvetype').focus();
                            }"
                >   

              </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtinvetype">Inventory Type :</label>
              <input type="text" 
                name="txtinvetype" 
                id="txtinvetype"
                maxlength ="50"
                autocomplete="off" 
                style="width: 300px;"
                onkeyup="if (value.length > 0) 
                  {
                    ambiltypecode(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblware').style.visibility = 'hidden';
                  }"
              >
              <input type="hidden" name="hidinvetype" id="hidinvetype">

            <label for="tglfinsdate">Deadline Date :</label>
              <input type="date" name="tglfinsdate" id="tglfinsdate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('txtopnanote').focus()">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtopnanote">Notes :</label>
                <input type="text" 
                name="txtopnanote" 
                id="txtopnanote" 
                maxlength ="100" 
                style="width: 300px;"
                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtemplname').focus();
                            }"
                >   


                <label for="txtemplname">Opname By :</label>
                <input type="text" name="txtemplname" id="txtemplname"
                maxlength="50" style="width: 200px"
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

            <label for="txtstockname">Item Name :</label>
              <input type="text" 
              name="txtstockname" 
              id="txtstockname" 
              maxlength ="50" 
              style="width: 200px;"
              readonly="true"> 

              <input type="hidden" name="hidstockcode" id="hidstockcode">

            <label for="txtstockopna">Stock Opname Quantity :</label>
              <input type="text" 
              name="txtstockopna" 
              id="txtstockopna" 
              maxlength ="10" 
              style="width: 100px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtstockopna').value = '0';
                                  document.getElementById('txtstockopna').focus();                          
                                }
                                else
                                {
                                  alert('ok');
                                }
                            }"
              >   
              <input type="hidden" name="hidtimecode" id="hidtimecode">

              </div><!-- pure-control-group -->

      </fieldset>

      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  
                  if (document.getElementById('txtopnacode').value == '')
                    {
                      swal({
                          title: 'Nomor Stock Opname kosong!',
                          text: 'Nomor Stock Opname belum ada, silah periksa lagi',
                          icon: 'warning',
                          });
                    }

                  else if (document.getElementById('hidwarecode').value == '')
                    {
                      swal({
                          title: 'Warehouse belum dipilih' ,
                          text: 'Silahkan periksa pengisian Warehouse',
                          icon: 'warning',
                          });
                    }

                  else if (document.getElementById('hidstockcode').value == '')
                  {
                      swal({
                          title: 'Data Item belum diisi' ,
                          text: 'Anda belum memilih item, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtstockname').value == '')
                  {
                      swal({
                          title: 'Nama Stock belum diisi' ,
                          text: 'Anda belum memilih  nama item, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtstockopna').value == '')
                  {
                      swal({
                          title: 'Quantity Stock Opname belum diisi' ,
                          text: 'Anda belum mengisi quantity, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                  {

                      var inopnacode = document.getElementById('txtopnacode').value;
                      var inwarecode = document.getElementById('hidwarecode').value;
                      var instockcode = document.getElementById('hidstockcode').value;
                      var instockname = document.getElementById('txtstockname').value;
                      var instockopna = document.getElementById('txtstockopna').value;
                      var intimecode = document.getElementById('hidtimecode').value;

                      input(inopnacode, inwarecode, instockcode, instockname, instockopna, intimecode);
                  }
        ">Update Opname</a>

          <a class="pure-button pure-button-primary" 
              onclick="javascript: if (document.getElementById('txtopnacode').value.length == 7) 
                {
                  if (confirm ('Are You Sure To Close this Form Opname ?')) 
                  { 
                      var inopnacode = document.getElementById('txtopnacode').value;
                      var inopnadate = document.getElementById('tglopnadate').value;
                      var inwarecode = document.getElementById('hidwarecode').value;
                      var inopnadlay = document.getElementById('txtopnadlay').value;
                      var infinsdate = document.getElementById('tglfinsdate').value;
                      var inopnanote = document.getElementById('txtopnanote').value;
                      var inemplcode = document.getElementById('hidemplcode').value;

                      inputopname(inopnacode, inopnadate, inwarecode, inopnadlay, infinsdate, inopnanote, inemplcode);
                      //document.frminvestock.submit(); 
                  } 
                  else 
                  { 
                      alert('Harap Lengkapi isian Form Opname');
                      document.getElementById('txtwarecode').focus(); 
                  }                                             
                }
          ">Close Opname</a>

              <div id="tbltrxascreen">                

        </fieldset>

        <fieldset>
                <div id="tblware" 
                style="position: absolute; 
                top:300px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">          
        </fieldset>

        <fieldset>
                <div id="tblitem" 
                style="position: absolute; 
                top:600px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">          
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

		</div><!-- div content -->
<div class="footerdate">
  	<span class="labelTime Time"><b>Date  :</b> <?php $tgl=date('d-m-Y'); echo $tgl;?></span>
</div>
<div class="footertime">
	<span class = "labelTime Time" id="timestamp"></span>
</div>


    	</div><!-- div main -->
</div><!-- div layout -->
<script src="js/INVESTOCK01.js"></script>
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
