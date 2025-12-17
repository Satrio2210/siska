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
    $query_akses = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN = '$user' AND PASS_INVE_DELL = 'Y'";
    $qakses = $db->query($query_akses) or die("Gagal Ambil Nilai Akses!!");
    $row = $qakses->fetchColumn();

    if ($row == 0)
    {
    header("Location: "."INVEMAST00.php");
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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="document.getElementById('txtmastcode').focus();">
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

            <li class="pure-menu-item" onclick="javascript: location.href = 'INVENTORY.php'">
                <a class="pure-menu-link">INVENTORY</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'SUPLMAST00.php'">
              <a class="pure-menu-link">Suplier</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TBLIUNIT00.php'">
              <a class="pure-menu-link">Support Item</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
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

		<div class="content">
        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVEMAST01.php'">
                <a class="pure-menu-link">
                Input Item
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVEMAST02.php'">
                <a class="pure-menu-link">
                Update Item
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Delete Item
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'INVEMAST04.php'">
                <a class="pure-menu-link">
                View Item
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->
    <!-- Form Input -->
    <form name="frminvemast" class="pure-form pure-form-aligned" method="post" action="INVEMAST03D.php">
      
      <fieldset>
        <div class="pure-control-group">
          <label for="txtmastcode">Sequence :</label>
            <input type="text" 
                name="txtmastcode" 
                id="txtmastcode" 
                maxlength ="4"
                style="width: 80px;"
                onkeyup="if (value.length > 0) 
                {
                  ambilinvemastcode(this.value);
                } 
              else 
                { 
                document.getElementById('tblinvemast').style.visibility = 'hidden';
                }"
                onkeydown="if (event.keyCode == 13 && value.length == 4)
                              {
                                   if (confirm ('Are You Sure To Delete?')) 
                                  { document.frminvemast.submit(); } else { location.href = 'INVEMAST03.php'; }                           
                              } 
                ">
        </div><!-- pure-control-group --> 

        <div class="pure-control-group">

          <label for="txttypename">Inventory Type :</label>
            
            <input type="text" 
                name="txttypename" 
                id="txttypename" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 

            <input type="hidden" name="hidtypecode" id="hidtypecode">

          <label for="txtunitname">Unit :</label>
            <input type="text" 
                name="txtunitname" 
                id="txtunitname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true">

            <input type="hidden" name="hidunitcode" id="hidunitcode">
            
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtspecname">Specification :</label>
            <input type="text" 
                name="txtspecname" 
                id="txtspecname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true">

            <input type="hidden" name="hidspeccode" id="hidspeccode">

          <label for="txtvarnname">Variant :</label>
            <input type="text" 
                name="txtvarnname" 
                id="txtvarnname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true">

            <input type="hidden" name="hidvarncode" id="hidvarncode">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">
          <label for="optwithsrnm">With Serial Number :</label>
            <input type="checkbox"
              name="optwithsrnm" 
              id="optwithsrnm"
              value="true"
              disabled="true"> 

            <input type="hidden" name="hidwithsrnm" id="hidwithsrnm">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Part Type :</label>

            <input type="checkbox"
            name="optstock" 
            id="optstock"
            value="true"
            disabled="true"> 
            Stock.

            <input type="checkbox"
            name="optnonstock" 
            id="optnonstock"
            value="true"
            disabled="true"> 
            Non Stock.

            <input type="checkbox"
            name="optfixedasset" 
            id="optfixedasset"
            value="true"
            disabled="true"> 
            Fixed Asset.

         <input type="hidden" name="hidparttype" id="hidparttype">   

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Standard Cost Freight :</label>

            <input type="checkbox"
            name="optweight" 
            id="optweight"
            value="true"
            disabled="true"> 
            Weight.

            <input type="checkbox"
            name="optvolume" 
            id="optvolume"
            value="true"
            disabled="true"> 
            Volume.

            <input type="hidden" name="hidcostfrgt" id="hidcostfrgt">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtpartname">Part Name :</label>
            <input type="text" 
                name="txtpartname" 
                id="txtpartname" 
                maxlength ="50"
                style="width: 500px;"
                readonly="true"> 
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtpartalias">Part Alias :</label>
            <input type="text" 
                name="txtpartalias" 
                id="txtpartalias" 
                maxlength ="50"
                style="width: 500px;"
                readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txthousname">Deffered Ware House :</label>
            <input type="text" 
                name="txthousnname" 
                id="txthousname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 

            <input type="hidden" name="hidhouscode" id="hidhouscode">

          <label for="txtstockmini">Minimum Stock :</label>
            <input type="text" 
              name="txtstockmini" 
              id="txtstockmini" 
              maxlength ="5"
              style="width: 60px;"
              readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtmainnote">Notes :</label>
            <input type="text" 
              name="txtmainnote" 
              id="txtmainnote" 
              maxlength ="100"
              style="width: 200px;"
              readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Pricing :</label>

            <input type="checkbox"
            name="optprice" 
            id="optprice"
            value="true"
            disabled="true"> 
            Price.

            <input type="checkbox"
            name="optdiscount" 
            id="optdiscount"
            value="true"
            disabled="true"> 
            Discount.

            <input type="hidden" name="hidmainpric" id="hidmainpric">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Type of Guarantee :</label>

            <input type="checkbox"
            name="optpartguarantee" 
            id="optpartguarantee"
            value="true"
            disabled="true"> 
            Part Guarantee.

            <input type="checkbox"
            name="optserviceguarantee" 
            id="optserviceguarantee"
            value="true"
            disabled="true"> 
            Service Guarantee.

            <input type="checkbox"
            name="optbothguarantee" 
            id="optbothguarantee"
            value="true"
            disabled="true"> 
            Both Guarantee.

            <input type="checkbox"
            name="optnonguarantee" 
            id="optnonguarantee"
            value="true"
            disabled="true"> 
            Non Guarantee.

            <input type="hidden" name="hidgrtetype" id="hidgrtetype">
            
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

            <label for="txtgrtelimt">Limit Days of Guarantee :</label>
              <input type="text" 
                name="txtgrtelimt" 
                id="txtgrtelimt" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> 

            <label for="txtexcercve">Tolerance Of Excess Received Item :</label>
              <input type="text" 
                name="txtexcercve" 
                id="txtexcercve" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> %

            <label for="txtlackrcve">Tolerance Of Lack Received Item :</label>
              <input type="text" 
                name="txtlackrcve" 
                id="txtlackrcve" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> % 

        </div><!-- pure-control-group -->
      </fieldset>
      <fieldset>
        
              <a class="pure-button button-delete" 
                    onclick="javascript: if (confirm ('Are You Sure To Delete?')) 
                                            { 
                                              document.frminvemast.submit(); 
                                            } 
                                            else 
                                            { 
                                              location.href = 'INVEMAST03.php'; 
                                            }                           

        ">Submit</a>

      </fieldset>

      <fieldset>
                <div id="tblinvemast" 
                style="position: absolute; 
                top:300px; 
                right: 600px; 
                background-color: white; 
                width: 600px; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

    </form>
    <!-- Form Input -->


		</div><!-- div content -->
<div class="footerdate">
  	<span class="labelTime Time"><b>Date  :</b> <?php $tgl=date('d-m-Y'); echo $tgl;?></span>
</div>
<div class="footertime">
	<span class = "labelTime Time" id="timestamp"></span>
</div>


    	</div><!-- div main -->
</div><!-- div layout -->
<script src="js/INVEMAST03.js"></script>
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
