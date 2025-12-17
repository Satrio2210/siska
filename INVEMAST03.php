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
<title>Hapus Item</title>
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

        .button-update {
      color: white;
            border-radius: 4px;
            background: rgb(66, 184, 221);
            /* this is a light blue */
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

<body onload="periksaakses('PASS_INVE_ENTR');">
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
          <label for="txtmastcode">No.Urut :</label>
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

          <label for="txttypename">Kategori :</label>
            
            <input type="text" 
                name="txttypename" 
                id="txttypename" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 

            <input type="hidden" name="hidtypecode" id="hidtypecode">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtunitname">Unit Beli :</label>
            <input type="text" 
                name="txtunitname" 
                id="txtunitname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 
            <input type="hidden" name="hidunitcode" id="hidunitcode">

          <label for="txtsaleunit">Unit Jual :</label>
            <input type="text" 
                name="txtsaleunit" 
                id="txtsaleunit" 
                maxlength ="50"
                style="width: 200px;"
                autocomplete="off"
                readonly="true"> 
            <input type="hidden" name="hidsaleunit" id="hidsaleunit">
            
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtspecname">Spesifikasi :</label>
            <input type="text" 
                name="txtspecname" 
                id="txtspecname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 
            <input type="hidden" name="hidspeccode" id="hidspeccode">

          <label for="txtvarnname">Segmentasi :</label>
            <input type="text" 
                name="txtvarnname" 
                id="txtvarnname" 
                maxlength ="50"
                style="width: 200px;"
                readonly="true"> 
            <input type="hidden" name="hidvarncode" id="hidvarncode">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">
          <label for="optwithsrnm">Ada Serial Number :</label>
            <input type="checkbox"
              name="optwithsrnm" 
              id="optwithsrnm"
              value="true"
              disabled="true"> 
            <input type="hidden" name="hidwithsrnm" id="hidwithsrnm">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Tipe Barang :</label>

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

          <label>Estimasi Standar Biaya :</label>

            <input type="checkbox"
            name="optweight" 
            id="optweight"
            value="true"
            disabled="true"> 
            Berat.

            <input type="checkbox"
            name="optvolume" 
            id="optvolume"
            value="true"
            disabled="true"> 
            Jumlah.

            <input type="hidden" name="hidcostfrgt" id="hidcostfrgt">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtpartname">Nama Barang :</label>
            <input type="text" 
                name="txtpartname" 
                id="txtpartname" 
                maxlength ="50"
                style="width: 300px;"
                readonly="true"> 
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txtpartalias">Manufaktur :</label>
            <input type="text" 
                name="txtpartalias" 
                id="txtpartalias" 
                maxlength ="50"
                style="width: 300px;"
                readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label for="txthousname">Gudang Penerima :</label>
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

          <label for="txtmainnote">Note :</label>
            <input type="text" 
              name="txtmainnote" 
              id="txtmainnote" 
              maxlength ="100"
              style="width: 500px;"
              readonly="true"> 

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

          <label>Kalkulasi Harga :</label>

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

          <label>Tipe Garansi :</label>

            <input type="checkbox"
            name="optpartguarantee" 
            id="optpartguarantee"
            value="true"
            disabled="true"> 
            Garansi Barang.

            <input type="checkbox"
            name="optserviceguarantee" 
            id="optserviceguarantee"
            value="true"
            disabled="true"> 
            Garansi Perbaikan.

            <input type="checkbox"
            name="optbothguarantee" 
            id="optbothguarantee"
            value="true"
            disabled="true"> 
            Garansi Barang dan Perbaikan.

            <input type="checkbox"
            name="optnonguarantee" 
            id="optnonguarantee"
            value="true"
            disabled="true"> 
            Tidak Ada Garansi.

            <input type="hidden" name="hidgrtetype" id="hidgrtetype">
            
        </div><!-- pure-control-group -->

        <div class="pure-control-group">

            <label for="txtgrtelimt">Batas Hari Garansi :</label>
              <input type="text" 
                name="txtgrtelimt" 
                id="txtgrtelimt" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> 

            <label for="txtexcercve">Toleransi Kelebihan Barang :</label>
              <input type="text" 
                name="txtexcercve" 
                id="txtexcercve" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> 

            <label for="txtlackrcve">Toleransi Kekurangan Barang :</label>
              <input type="text" 
                name="txtlackrcve" 
                id="txtlackrcve" 
                maxlength ="3"
                style="width: 50px;"
                readonly="true"> 

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
  header("Location: "."login.php");
}
?>
