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
<title>Terima Transfer</title>
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
<body onLoad="periksaakses('PASS_TRANS_RECE'); 
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVETRANS03.php'">
                <a class="pure-menu-link">
                Transfer Execution
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Transfer Receipt
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frminvetrans" class="pure-form pure-form-aligned" method="post" action="INVETRANS04P.php">

      <fieldset>

      <div class="pure-control-group">

        <label for="txtsearch">Get Transfer  :</label>
        <input type="text" name="txtsearch" id="txtsearch"
        maxlength="10" style="width: 100px"
        onkeyup="if (value.length > 0) 
              {
              ambilexeccode(this.value);
              } 
            else 
              { 
               document.getElementById('tblexec').style.visibility = 'hidden';
              }"
        >

      </div><!-- pure-control-group -->
        

      </fieldset>

    	<fieldset>
        <legend>Receipt Info</legend>

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
                maxlength ="7"
                style="width: 90px;"
                readonly="true"> 

            <label for="tglestmdate">Estimate Receipt Date :</label>
              <input type="date" name="tglestmdate" id="tglestmdate" value="<?php echo $datenow; ?>"
                readonly="true">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="tgltrandate">Deadline Transfer Date :</label>
              <input type="date" name="tgltrandate" id="tgltrandate" value="<?php echo $datenow; ?>"
                readonly="true">

            <label for="tglrcvedate">Deadline Receipt Date :</label>
              <input type="date" name="tglrcvedate" id="tglrcvedate" value="<?php echo $datenow; ?>"
                readonly="true">

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
              readonly="true">
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

          <a class="pure-button pure-button-primary" 
        onclick="javascript: if (document.getElementById('txtexeccode').value.length == 7) 
        {
          if (confirm ('Are You Sure To Receipt Transfer ?')) 
            { 
                var inexeccode = document.getElementById('txtexeccode').value;
                update(inexeccode);

                //document.frminvetrans.submit(); 
            } 
          else 
            { 
              alert('Harap Lengkapi isian Form Execute');
              document.getElementById('txtsearch').focus(); 
            }                                             
        }
        ">Receipt</a>

              <div id="tbltrxascreen">                

        </fieldset>

        <fieldset>
                <div id="tblexec" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 200px);
                 background-color: white; 
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
                <div id="tbltran" 
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
<script src="js/INVETRANS04.js"></script>
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
