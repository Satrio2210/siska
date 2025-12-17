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
<title>Hapus Suplier</title>
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
<script type="text/javascript" src="js/sanie.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_SUPL_ENTR');
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'PASSIDEN00.php'">
                <a class="pure-menu-link">ACCESS</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'index.php'">
                <a class="pure-menu-link">PURCHASING</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Suplier</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC00.php'">
                <a class="pure-menu-link">Purchase Order</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC03.php'">
                <a class="pure-menu-link">Quality Control</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC05.php'">
                <a class="pure-menu-link">Invoice</a>
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

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST01.php'">
              	<a class="pure-menu-link">
                Input Suplier
            	</a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST02.php'">
                <a class="pure-menu-link">
                Update Suplier
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Delete Suplier
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'SUPLMAST04.php'">
                <a class="pure-menu-link">
                View Suplier
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmsuplmast" class="pure-form pure-form-aligned" method="post" action="SUPLMAST03D.php">
    	<fieldset>

        <div class="pure-control-group">

    		<label for="txtmastcode">Supplier ID :</label>
      			<input type="text" 
             	name="txtmastcode" 
             	id="txtmastcode" 
             	maxlength ="7"
             	style="width: 90px;"

             onkeyup="if (value.length > 0) 
              {
              ambilsuplmastcode(this.value);
              } 
            else 
              { 
               document.getElementById('tblsuplmast').style.visibility = 'hidden';
              }"
                        >

    		<label for="txtmainname">Suplier Name :</label>
      			<input type="text" 
             	name="txtmainname" 
             	id="txtmainname" 
             	maxlength ="50"
             	style="width: 300px;"
              readonly="true"> 

    	   </div><!-- pure-control-group -->

    	   <div class="pure-control-group">

    		<label for="txtmainaddr">Address :</label>
      			<input type="text" 
             	name="txtmainaddr" 
             	id="txtmainaddr" 
             	maxlength ="100"
             	style="width: 500px;"
              readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmaincity">City :</label>
      			<input type="text" 
             	name="txtmaincity" 
             	id="txtmaincity" 
             	maxlength ="10"
             	style="width: 100px;"
              readonly="true"> 
    		
    		<label for="txtmainctry">Country :</label>
      			<input type="text" 
             	name="txtmainctry" 
             	id="txtmainctry" 
             	maxlength ="10"
             	style="width: 100px;"
              readonly="true"> 
    		
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmainphne">Phone :</label>
      			<input type="text" 
             	name="txtmainphne" 
             	id="txtmainphne" 
             	maxlength ="18"
             	style="width: 180px;"
              readonly="true"> 

    		<label for="txtmainfaxi">Fax :</label>
      			<input type="text" 
             	name="txtmainfaxi" 
             	id="txtmainfaxi" 
             	maxlength ="18"
             	style="width: 180px;"
              readonly="true"> 
    		
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmainmail">E-Mail :</label>
      			<input type="text" 
             	name="txtmainmail" 
             	id="txtmainmail"
             	placeholder="user@domain.com" 
             	maxlength ="30"
             	style="width: 300px;"
              readonly="true"> 

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmainwebs">Website :</label>
      			<input type="text" 
             	name="txtmainwebs" 
             	id="txtmainwebs" 
             	maxlength ="50"
             	placeholder ="http://" 
             	style="width: 500px;"
              readonly="true"> 
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmainpers">Contact Person :</label>
      			<input type="text" 
             	name="txtmainpers" 
             	id="txtmainpers" 
             	maxlength ="50"
             	style="width: 500px;"
              readonly="true"> 
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

    		<label for="txtmaintidn1">Tax Number :</label>
      			<input type="text" 
             	name="txtmaintidn1" 
             	id="txtmaintidn1" 
             	maxlength ="2"
             	style="width: 40px;"
              readonly="true"> 
			       .
      			<input type="text" 
             	name="txtmaintidn2" 
             	id="txtmaintidn2" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 
			       .
      			<input type="text" 
             	name="txtmaintidn3" 
             	id="txtmaintidn3" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 
			       .
      			<input type="text" 
             	name="txtmaintidn4" 
             	id="txtmaintidn4" 
             	maxlength ="1"
             	style="width: 30px;"
              readonly="true"> 

			       -
      			<input type="text" 
             	name="txtmaintidn5" 
             	id="txtmaintidn5" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 

			       .
      			<input type="text" 
             	name="txtmaintidn6" 
             	id="txtmaintidn6" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

			<label for="txtmainterm">Installment :</label>
      			<input type="text" 
             	name="txtmainterm" 
             	id="txtmainterm" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 

			<label for="txtestiarrv">Estimated Time Arrival :</label>
      			<input type="text" 
             	name="txtestiarrv" 
             	id="txtestiarrv" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 

			<label for="txtestideli">Estimated Time Delivered :</label>
      			<input type="text" 
             	name="txtestideli" 
             	id="txtestideli" 
             	maxlength ="3"
             	style="width: 50px;"
              readonly="true"> 
        	
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

			<label for="txtpayalimt">Account Payable Limit :</label>
      			<input type="text" 
             	name="txtpayalimt" 
             	id="txtpayalimt" 
             	maxlength ="10"
             	style="width: 100px;"
              readonly="true"> 

			<label for="txtbankname">Bank :</label>
      			<input type="text" 
             	name="txtbankname" 
             	id="txtbankname" 
             	maxlength ="60"
             	style="width: 200px;"
              readonly="true"> 

        		<input type="hidden" name="hidbankcode" id="hidbankcode">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="optavaifrwd">Available As Forwarder :</label>
      		<input type="checkbox"
            name="optavaifrwd" 
            id="optavaifrwd"
            value="true"
            disabled="true"> 

      <input name="hidavaifrwd"
              id="hidavaifrwd"
              type="hidden">

        </div><!-- pure-control-group -->

        </fieldset>

        <fieldset>
          <a class="pure-button button-delete" onclick="javascript:
              if (document.getElementById('txtmastcode').value.length == 7)
              {
                 if (confirm ('Are You Sure To Delete?')) 
                    { document.frmsuplmast.submit(); } else { location.href = 'SUPLMAST03.php'; }                           
              }
        ">Submit</a>

        </fieldset>

        <fieldset>
          <div id="tblsuplmast"                
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
<script src="js/SUPLMAST03.js"></script>
<script src="js/ui.js"></script>

</body>
</html>
<?php
}
else

{
  header("Location: "."login.php");
}
?>
