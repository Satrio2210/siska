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
<title>Auto Jurnal Transaksi</title>
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
            background: rgb(66, 184, 221);
            /* this is a light blue */
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
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onload="periksaakses('PASS_TRXA_ENTR');">
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
                <a class="pure-menu-link">AKUNTING</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Auto Jurnal</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAJRNL00.php'">
                <a class="pure-menu-link">Manual Jurnal</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'COACMAST00.php'">
                <a class="pure-menu-link">C.O.A.</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLACOAC00.php'">
                <a class="pure-menu-link">Grup Akun</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLEDIVI00.php'">
                <a class="pure-menu-link">Divisi</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'REPOACCT00.php'">
                <a class="pure-menu-link">Laporan</a>
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


              <li class="pure-menu-item pure-menu-disabled">
                Transaksi Pasien
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'AUTOJRNL02.php'">
                <a class="pure-menu-link">
                Penjualan Obat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'AUTOJRNL05.php'">
                <a class="pure-menu-link">
                Daftar Akun
                </a>
              </li>


            </ul>
          </div>
    	<!-- Tab Menu -->
    <!-- Form Input -->
    <form name="frmtrxajrnl" class="pure-form pure-form-aligned" method="post" action="TRXAJRNL02U.php">

    <fieldset><legend>Data Kwitansi</legend>

    <div class="pure-control-group">

      	<label for="txtsearch">Cari :</label>
      	<input type="text" 
            name="txtsearch" 
            id="txtsearch"
            autocomplete="off" 
            maxlength ="10"
            style="width: 100px;"
      		  onkeyup="if (value.length > 0) 
              {
              ambiljrnlcode(this.value);
              } 
            else 
              { 
               document.getElementById('tbljrnl').style.visibility = 'hidden';
               document.getElementById('tbljrnl').innerHTML = '';
              }"
        >
        <input type="hidden"
         		name="hidsalecode"
         		id="hidsalecode">

        <input type="hidden"
         		name="hidregicode"
         		id="hidregicode">

        <label for="tgljrnldate">Tanggal Transaksi :</label>
     	  <input type="date" name="tgljrnldate" id="tgljrnldate" value="<?php echo $datenow; ?>" 
        onchange="document.getElementById('txtcoaccode').focus()">

      <!--div id="tbljrnl"-->	
    </div><!-- pure-control-group -->

    </fieldset>

      <fieldset>
          <div id="tbljrnl"
              style="position: absolute; 
                 top: 300px;
                 left: calc(80% - 600px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>

    <fieldset> <div id="tbltrxascreen"></fieldset>

    <fieldset>
      <legend>Transaksi Obat</legend>
    
      <div class="pure-control-group">

        <label for="txtsale_drugs">Penjualan Obat (Cr):</label>
        <input type="text" name="txtsale_drugs" id="txtsale_drugs"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_sale_drugs"
            id="hidcode_sale_drugs">

         <input type="hidden"
            name="hidname_sale_drugs"
            id="hidname_sale_drugs">

        <label for="txtvat_out">PPN Keluaran (Cr):</label>
        <input type="text" name="txtvat_out" id="txtvat_out"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_vat_out"
            id="hidcode_vat_out">

         <input type="hidden"
            name="hidname_vat_out"
            id="hidname_vat_out">

        <label for="txtsale_bhp">Penjualan BHP (Cr):</label>
        <input type="text" name="txtsale_bhp" id="txtsale_bhp"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_sale_bhp"
            id="hidcode_sale_bhp">

         <input type="hidden"
            name="hidname_sale_bhp"
            id="hidname_sale_bhp">


    </div><!-- pure-control-group -->    

    <div class="pure-control-group">

        <label for="txtcash_drugs">Pembayaran Obat/BHP (Db):</label>
        <input type="text" name="txtcash_drugs" id="txtcash_drugs"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_cash_drugs"
            id="hidcode_cash_drugs">

         <input type="hidden"
            name="hidname_cash_drugs"
            id="hidname_cash_drugs">

    </div><!-- pure-control-group -->

</fieldset>

<fieldset>
<!-- Posting Transaksi Obat -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('hidsalecode').value.length == 14) 
        {
          var insalecode = document.getElementById('hidsalecode').value;
          var inregicode = document.getElementById('hidregicode').value;

          var injrnldate = document.getElementById('tgljrnldate').value;

          // penjualan obat bhp
          var insaledrugs = document.getElementById('txtsale_drugs').value;
          var incodesaledrugs = document.getElementById('hidcode_sale_drugs').value;
          var innamesaledrugs = document.getElementById('hidname_sale_drugs').value;

          var invatout = document.getElementById('txtvat_out').value;
          var incodevatout = document.getElementById('hidcode_vat_out').value;
          var innamevatout = document.getElementById('hidname_vat_out').value;

          var insalebhp = document.getElementById('txtsale_bhp').value;
          var incodesalebhp = document.getElementById('hidcode_sale_bhp').value;
          var innamesalebhp = document.getElementById('hidname_sale_bhp').value;

          var incashdrugs = document.getElementById('txtcash_drugs').value;
          var incodecashdrugs = document.getElementById('hidcode_cash_drugs').value;
          var innamecashdrugs = document.getElementById('hidname_cash_drugs').value;

      InsertDrugs(insalecode,inregicode,injrnldate,insaledrugs,incodesaledrugs,innamesaledrugs,invatout,incodevatout,innamevatout,insalebhp,incodesalebhp,innamesalebhp,incashdrugs,incodecashdrugs,innamecashdrugs);

        }
        else
        {
                document.getElementById('txtsearch').focus();          
        }
        ">Posting</a>
<!-- Posting Transaksi Obat -->  
</fieldset>

<fieldset><legend>Transaksi Persediaan</legend>

      <div class="pure-control-group">

        <label for="txtinventory_drugs">Persediaan Obat Medis farmasi(Cr):</label>
        <input type="text" name="txtinventory_drugs" id="txtinventory_drugs"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_inventory_drugs"
            id="hidcode_inventory_drugs">

         <input type="hidden"
            name="hidname_inventory_drugs"
            id="hidname_inventory_drugs">

        <label for="txtinventory_bhp">Persediaan BHP (Cr):</label>
        <input type="text" name="txtinventory_bhp" id="txtinventory_bhp"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_inventory_bhp"
            id="hidcode_inventory_bhp">

         <input type="hidden"
            name="hidname_inventory_bhp"
            id="hidname_inventory_bhp">

    </div><!-- pure-control-group -->    

    <div class="pure-control-group">

        <label for="txtusage_cost">Biaya Pemakaian Bahan (Db):</label>
        <input type="text" name="txtusage_cost" id="txtusage_cost"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcode_usage_cost"
            id="hidcode_usage_cost">

         <input type="hidden"
            name="hidname_usage_cost"
            id="hidname_usage_cost">

    </div><!-- pure-control-group -->
  
</fieldset>
<fieldset>
<!-- Posting Transaksi Persediaan -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('hidsalecode').value.length == 14) 
        {
          var insalecode = document.getElementById('hidsalecode').value;
          var inregicode = document.getElementById('hidregicode').value;

          var injrnldate = document.getElementById('tgljrnldate').value;

          // persediaan Obat bhp 
          var ininventorydrugs = document.getElementById('txtinventory_drugs').value;
          var incodeinventorydrugs = document.getElementById('hidcode_inventory_drugs').value;
          var innameinventorydrugs = document.getElementById('hidname_inventory_drugs').value;

          var ininventorybhp = document.getElementById('txtinventory_bhp').value;
          var incodeinventorybhp = document.getElementById('hidcode_inventory_bhp').value;
          var innameinventorybhp = document.getElementById('hidname_inventory_bhp').value;

          var inusagecost = document.getElementById('txtusage_cost').value;
          var incodeusagecost = document.getElementById('hidcode_usage_cost').value;
          var innameusagecost = document.getElementById('hidname_usage_cost').value;

      InsertInventory(insalecode,inregicode,injrnldate,ininventorydrugs,incodeinventorydrugs,innameinventorydrugs,ininventorybhp,incodeinventorybhp,innameinventorybhp,inusagecost,incodeusagecost,innameusagecost);


        }
        else
        {
                document.getElementById('txtsearch').focus();          
        }
        ">Posting</a>

<!-- Posting Transaksi Persediaan -->
</fieldset>
<fieldset><legend>Transaksi Jasa</legend>

    <div class="pure-control-group">

        <label for="txttret_doct">Jasa Tindakan Dokter (Cr):</label>
        <input type="text" name="txttret_doct" id="txttret_doct"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodetret_doct"
            id="hidcodetret_doct">

         <input type="hidden"
            name="hidnametret_doct"
            id="hidnametret_doct">

        <label for="txttret_nurs">Jasa Tindakan Bidan (Cr):</label>
        <input type="text" name="txttret_nurs" id="txttret_nurs"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodetret_nurs"
            id="hidcodetret_nurs">

         <input type="hidden"
            name="hidnametret_nurs"
            id="hidnametret_nurs">

        <label for="txttret_labs">Jasa Laboratorium (Cr):</label>
        <input type="text" name="txttret_labs" id="txttret_labs"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodetret_labs"
            id="hidcodetret_labs">

         <input type="hidden"
            name="hidnametret_labs"
            id="hidnametret_labs">

    </div><!-- pure-control-group -->

    <div class="pure-control-group">

        <label for="txtcash_tret">Pembayaran Jasa (Db):</label>
        <input type="text" name="txtcash_tret" id="txtcash_tret"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodecash_tret"
            id="hidcodecash_tret">

         <input type="hidden"
            name="hidnamecash_tret"
            id="hidnamecash_tret">

        <label for="txtaccount_receivable">Sisa Pembayaran (Db):</label>
        <input type="text" name="txtaccount_receivable" id="txtaccount_receivable"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodeaccount_receivable"
            id="hidcodeaccount_receivable">

         <input type="hidden"
            name="hidnameaccount_receivable"
            id="hidnameaccount_receivable">

    </div><!-- pure-control-group -->

 </fieldset>
<fieldset>

<!-- Posting Transaksi Jasa -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('hidsalecode').value.length == 14) 
        {
          var insalecode = document.getElementById('hidsalecode').value;
          var inregicode = document.getElementById('hidregicode').value;

          var injrnldate = document.getElementById('tgljrnldate').value;

          // Jasa 
          var intret_doct = document.getElementById('txttret_doct').value;
          var incodetret_doct = document.getElementById('hidcodetret_doct').value;
          var innametret_doct = document.getElementById('hidnametret_doct').value;

          var intret_nurs = document.getElementById('txttret_nurs').value;
          var incodetret_nurs = document.getElementById('hidcodetret_nurs').value;
          var innametret_nurs = document.getElementById('hidnametret_nurs').value;

          var intret_labs = document.getElementById('txttret_labs').value;
          var incodetret_labs = document.getElementById('hidcodetret_labs').value;
          var innametret_labs = document.getElementById('hidnametret_labs').value;

          var incash_tret = document.getElementById('txtcash_tret').value;
          var incodecash_tret = document.getElementById('hidcodecash_tret').value;
          var innamecash_tret = document.getElementById('hidnamecash_tret').value;

          var inaccount_receivable = document.getElementById('txtaccount_receivable').value;
          var incodeaccount_receivable = document.getElementById('hidcodeaccount_receivable').value;
          var innameaccount_receivable = document.getElementById('hidnameaccount_receivable').value;

      InsertJasa(insalecode,inregicode,injrnldate,intret_doct,incodetret_doct,innametret_doct,intret_nurs,incodetret_nurs,innametret_nurs,intret_labs,incodetret_labs,innametret_labs,incash_tret,incodecash_tret,innamecash_tret,inaccount_receivable,incodeaccount_receivable,innameaccount_receivable);


        }
        else
        {
                document.getElementById('txtsearch').focus();          
        }
        ">Posting</a>

<!-- Posting Transaksi Jasa -->
</fieldset>

<fieldset><legend>Transaksi Admin</legend>

    <div class="pure-control-group">

        <label for="txtfee_admin">Jasa Pendaftaran (Cr):</label>
        <input type="text" name="txtfee_admin" id="txtfee_admin"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodefee_admin"
            id="hidcodefee_admin">

         <input type="hidden"
            name="hidnamefee_admin"
            id="hidnamefee_admin">

        <label for="txtfee_resep">Jasa Resep (Cr):</label>
        <input type="text" name="txtfee_resep" id="txtfee_resep"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodefee_resep"
            id="hidcodefee_resep">

         <input type="hidden"
            name="hidnamefee_resep"
            id="hidnamefee_resep">

    </div><!-- pure-control-group -->

    <div class="pure-control-group">


        <label for="txtcash_admin">Pembayaran Admin (Db):</label>
        <input type="text" name="txtcash_admin" id="txtcash_admin"
              maxlength="100" style="width: 130px"
              readonly="true"> 

         <input type="hidden"
            name="hidcodecash_admin"
            id="hidcodecash_admin">

         <input type="hidden"
            name="hidnamecash_admin"
            id="hidnamecash_admin">

    </div><!-- pure-control-group -->

 </fieldset>
 <fieldset>
  <!-- Posting Transaksi Admin -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('hidsalecode').value.length == 14) 
        {
          var insalecode = document.getElementById('hidsalecode').value;
          var inregicode = document.getElementById('hidregicode').value;

          var injrnldate = document.getElementById('tgljrnldate').value;

          // Admin 
          var infee_admin = document.getElementById('txtfee_admin').value;
          var incodefee_admin = document.getElementById('hidcodefee_admin').value;
          var innamefee_admin = document.getElementById('hidnamefee_admin').value;

          var infee_resep = document.getElementById('txtfee_resep').value;
          var incodefee_resep = document.getElementById('hidcodefee_resep').value;
          var innamefee_resep = document.getElementById('hidnamefee_resep').value;

          var incash_admin = document.getElementById('txtcash_admin').value;
          var incodecash_admin = document.getElementById('hidcodecash_admin').value;
          var innamecash_admin = document.getElementById('hidnamecash_admin').value;

      InsertAdmin(insalecode,inregicode,injrnldate,infee_admin,incodefee_admin,innamefee_admin,infee_resep,incodefee_resep,innamefee_resep,incash_admin,incodecash_admin,innamecash_admin);


        }
        else
        {
                document.getElementById('txtsearch').focus();          
        }
        ">Posting</a>

<!-- Posting Transaksi Admin -->
   
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
<script src="js/AUTOJRNL01.js"></script>
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
