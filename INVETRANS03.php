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
<title>Transfer Item</title>
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
<script src="js/sanie.js"></script>

<script type="text/javascript">
  $(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }

</script>

</head>
<body onLoad="periksaakses('PASS_TRANS_EXEC');  ambilexeccode('X'); 
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS01.php'">
                <a class="pure-menu-link">
                Transfer Request
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS02.php'">
                <a class="pure-menu-link">
                Transfer Approval
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Transfer Execution
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
    <form name="frminvetrans" class="pure-form pure-form-aligned" method="post" action="INVETRANS03P.php">
    	<fieldset>
        <legend>Request Info</legend>

      		<div class="pure-control-group">

            <label for="txtexeccode">Transaction No :</label>
              <input type="text" 
                name="txtexeccode" 
                id="txtexeccode"
                maxlength ="7"
                style="width: 90px;"
                readonly = "true">

            <label for="tglexecdate">Transaction Date :</label>
              <input type="date" name="tglexecdate" id="tglexecdate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('txtrequcode').focus()">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtrequcode">Request No :</label>
              <input type="text" 
                name="txtrequcode" 
                id="txtrequcode"
                autocomplete="off" 
                maxlength ="7"
                style="width: 90px;"
              onkeyup="if (value.length > 0) 
                  {
                    ambilrequcode(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblrequ').style.visibility = 'hidden';
                  }"
              >

            <label for="tglestmdate">Estimate Receipt Date :</label>
              <input type="date" name="tglestmdate" id="tglestmdate" value="<?php echo $datenow; ?>"
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
              maxlength ="50" 
              style="width: 300px;"
              readonly="true"> 

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
              maxlength ="50" 
              style="width: 300px;"
              readonly="true" >
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
        <legend>Item info</legend>
            <div class="pure-control-group">

            <label for="txtstockname">Item Name :</label>
              <input type="text" 
              name="txtstockname" 
              id="txtstockname" 
              maxlength ="50" 
              style="width: 200px;"
              onkeyup="if (value.length > 0) 
                  {
                    var origin = document.getElementById('hidwarefrom').value; 
                    ambilitemcode(this.value,origin);
                  } 
                else 
                  { 
                  document.getElementById('tblitem').style.visibility = 'hidden';
                  }"
              >

              <input type="hidden" name="hidstockcode" id="hidstockcode">

            <label for="txtstockquty">Item Quantity :</label>
              <input type="text" 
              name="txtstockquty" 
              id="txtstockquty" 
              maxlength ="10" 
              style="width: 100px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtstockquty').value = '0';
                                  document.getElementById('txtstockquty').focus();                          
                                }
                                else
                                {
                                  document.getElementById('txtcartcode').focus();
                                }
                            }"
              >   
              <input type="hidden" name="hidpartunit" id="hidpartunit">
              <input type="hidden" name="hidstocksrnm" id="hidstocksrnm">
              <input type="hidden" name="hidstockbtch" id="hidstockbtch">

              </div><!-- pure-control-group -->

              <div class="pure-control-group">

            <label for="txtcartcode">Cartoon Number :</label>
              <input type="text" 
              name="txtcartcode" 
              id="txtcartcode" 
              maxlength ="10" 
              style="width: 100px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtdimmcode').focus();
                            }"
              >   

            <label for="txtdimmcode">Dimension Number :</label>
              <input type="text" 
              name="txtdimmcode" 
              id="txtdimmcode" 
              maxlength ="10" 
              style="width: 100px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  document.getElementById('txtdimmcode').focus();
                            }"
              >   

              </div><!-- pure-control-group -->


      </fieldset>

      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  
                  if (document.getElementById('txtrequcode').value == '')
                    {
                      swal({
                          title: 'Nomor Request belum diisi!',
                          text: 'Anda belum mengisi Nomor Request asal, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtrequcode').value = '';
                      document.getElementById('txtrequcode').focus();
                    }

                  else if (document.getElementById('hidstockcode').value == '')
                  {
                      swal({
                          title: 'Data Item belum diisi' ,
                          text: 'Anda belum memilih item, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('hidstockcode').value = '';
                      document.getElementById('hidstockcode').focus();
                  }

                  else if (document.getElementById('txtstockquty').value == '')
                  {
                      swal({
                          title: 'Quantity Stock belum diisi' ,
                          text: 'Anda belum memilih quantity, silah periksa lagi',
                          icon: 'warning',
                          });
                      document.getElementById('txtstockquty').value = '';
                      document.getElementById('txtstockquty').focus();
                  }

                   else
                  {

                      var inexeccode = document.getElementById('txtexeccode').value;
                      var inexecdate = document.getElementById('tglexecdate').value;
                      var inrequcode = document.getElementById('txtrequcode').value;
                      var inestmdate = document.getElementById('tglestmdate').value;
                      var intrandate = document.getElementById('tgltrandate').value;
                      var inrcvedate = document.getElementById('tglrcvedate').value;
                      var inwarefrom = document.getElementById('hidwarefrom').value;
                      var inwaredest = document.getElementById('hidwaredest').value;
                      var instockcode = document.getElementById('hidstockcode').value;
                      var instockname = document.getElementById('txtstockname').value; 
                      var instockquty = document.getElementById('txtstockquty').value; 
                      var inpartunit = document.getElementById('hidpartunit').value; 

                      var instocksrnm = document.getElementById('hidstocksrnm').value;
                      var instockbtch = document.getElementById('hidstockbtch').value;
                      var incartcode = document.getElementById('txtcartcode').value;
                      var indimmcode = document.getElementById('txtdimmcode').value;

                      input(inexeccode,inexecdate,inrequcode,inestmdate,intrandate,inrcvedate,inwarefrom,inwaredest,instockcode,instockname,instockquty,inpartunit,instocksrnm,instockbtch,incartcode,indimmcode);
                    }
        ">Pilih Item</a>

          <a class="pure-button pure-button-primary" 
        onclick="javascript: if (document.getElementById('txtexeccode').value.length == 7) 
        {
          if (confirm ('Are You Sure To Execute Transfer ?')) 
            { 
                document.frminvetrans.submit(); 
            } 
          else 
            { 
              alert('Harap Lengkapi isian Form Execute');
              document.getElementById('txtrequcode').focus(); 
            }                                             
        }
        ">Kirim</a>
              <div id="tbltrxascreen">                

        </fieldset>

        <fieldset>
                <div id="tblrequ" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 300px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
        </fieldset>

        <fieldset>
                <div id="tblitem" 
          style="position: absolute; 
                 top: 300px;
                 left: calc(70% - 200px);
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
<script src="js/INVETRANS03.js"></script>
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
