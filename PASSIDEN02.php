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
<title>Akses User</title>
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

    .button-update 
    {
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
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_IDEN_PREV');">

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

        <li class="pure-menu-item menu-item-divided pure-menu-selected" onclick="javascript: location.href = 'index.php'">
          <a class="pure-menu-link">AKSES</a>
        </li>


        <li class="pure-menu-item" onclick="javascript: location.href = 'signout.php'">
          <a class="pure-menu-link">EXIT</a>
        </li>
          
        </ul><!-- pure-menu-list -->
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
        <!-- <li class="pure-menu-item pure-menu-disabled"> -->                

          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN01.php'">
                <a class="pure-menu-link">
                Buat User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Akses User
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN03.php'">
                <a class="pure-menu-link">
                Hapus User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN04.php'">
                <a class="pure-menu-link">
                Tampil User
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmpassiden" class="pure-form pure-form-aligned" method="post" action="PASSIDEN02U.php">

        <fieldset>
          <legend>Data User</legend>

            <div class="pure-control-group">

            <label for="txtuseriden">User ID :</label>    

            <input type="text" 
                name="txtuseriden" 
                id="txtuseriden" 
                autocomplete="off"
                maxlength ="5" 
                style="width: 80px;"

                onkeyup="var start = this.selectionStart;
                     var end = this.selectionEnd;
                     this.value = this.value.toUpperCase();
                     this.setSelectionRange(start, end);
                     if (value.length == 5) 
                        {
                            periksaid (this.value);
                        }
                    else
                        {
                            document.getElementById('labelmessage').style.visibility = 'hidden';
                        }"

                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtusername').focus()">

                <span id="labelmessage" 
                class="pure-form-message" 
                style="visibility: hidden;">User ID not found!.</span>

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label for="txtusername">User Name :</label>

            <input type="text" 
                name="txtusername" 
                placeholder="Nama User" 
                id="txtusername" 
                maxlength ="20" 
                style="width: 230px;"
                readonly="true"> 

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label>Type Staff  :</label>
                <input type="checkbox"
                    name="optdoctor" 
                    id="optdoctor"
                    value="true"
                    onclick="if (checked == true) 
                          {
                              document.getElementById('optnondoctor').checked = false;
                              document.getElementById('hidusertype').value = 'Y';
                              var userakses = document.getElementById('txtuseriden').value;
                              tipecode(userakses);
                          }                
                        ">
                        Medis.
                <input type="checkbox"
                        name="optnondoctor" 
                        id="optnondoctor"
                        value="true"
                        onclick="if (checked == true) 
                              {
                                  	document.getElementById('optdoctor').checked = false;
                                  	document.getElementById('hidusertype').value = 'N';
                              		var userakses = document.getElementById('txtuseriden').value;
                              		tipecode(userakses);
                              }                
                            ">
                        Non Medis.

                <input name="hidusertype"
                          id="hidusertype"
                          type="hidden">

            
            </div><!-- pure-control-group -->

            <div class="pure-control-group">
 
            <label for="txtuserpswd">Password :</label>

            <input type="password" 
                name="txtuserpswd" 
                placeholder="Password" 
                id="txtuserpswd" 
                maxlength ="100" 
                style="width: 300px;"

            onkeydown="if (event.keyCode == 13 && value.length > 0) 
            			{
            				var userakses = document.getElementById('txtuseriden').value;
            				sandicode(userakses,this.value);
            			}">

            <input type="hidden"
            name="hiduserpswd"
            id="hiduserpswd">

            </div><!-- pure-control-group -->
          </fieldset>
          <fieldset>
            <legend>Data Akses</legend>

            <div class="pure-control-group">

                <label>Manajemen User :</label>

                <input type="checkbox" name="optidennew" id="optidennew" value="true"

                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidennew').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_NEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidennew').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_NEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Buat User.
                <input type="checkbox" name="optidenprev" id="optidenprev" value="true"

                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidenprev').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_PREV');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidenprev').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_PREV')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Akses User.
                <input type="checkbox" name="optidendell" id="optidendell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidendell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidendell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Hapus User.
                <input type="checkbox" name="optidenview" id="optidenview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidenview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidenview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Tampil User.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Akuntansi :</label>

                <input type="checkbox" name="opttrxaentr" id="opttrxaentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxaentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxaentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Jurnal.

                <input type="checkbox" name="optcoacentr" id="optcoacentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcoacentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_COAC_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcoacentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_COAC_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Chart Of Account.

                <input type="checkbox" name="opttblaentr" id="opttblaentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttblaentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttblaentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Group Account.

                <input type="checkbox" name="optdivientr" id="optdivientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdivientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DIVI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdivientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DIVI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Divisi.

                <input type="checkbox" name="optrepoview" id="optrepoview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrepoview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_VIEW');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('optrepoview').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_VIEW')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Report.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Persediaan :</label>

                <input type="checkbox" name="optspecitem" id="optspecitem" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optspecitem').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SPEC_ITEM');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optspecitem').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SPEC_ITEM')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Spesifikasi Item.

                <input type="checkbox" name="optinveentr" id="optinveentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optinveentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_INVE_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optinveentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_INVE_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Master Item.

                <input type="checkbox" name="optwarehous" id="optwarehous" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optwarehous').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_WARE_HOUS');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optwarehous').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_WARE_HOUS')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Warehouse.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>  </label>

                <input type="checkbox" name="opttransrequ" id="opttransrequ" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransrequ').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_REQU');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttransrequ').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_REQU')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Ajukan Transfer.

                <input type="checkbox" name="opttransapro" id="opttransapro" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransapro').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_APRO');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('opttransapro').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_APRO')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Persetujuan Transfer.

                <input type="checkbox" name="opttransexec" id="opttransexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_EXEC');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('opttransexec').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_EXEC')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Jalankan Transfer.

                <input type="checkbox" name="opttransrece" id="opttransrece" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransrece').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_RECE');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('opttransrece').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_RECE')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Terima Transfer.

            </div><!-- pure-control-group -->


            <div class="pure-control-group">

                <label>  </label>

                <input type="checkbox" name="optstockopna" id="optstockopna" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockopna').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_OPNA');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('optstockopna').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_OPNA')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Stok Opname.

                <input type="checkbox" name="optstockadju" id="optstockadju" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockadju').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_ADJU');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('optstockadju').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_ADJU')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Stok Pengesahan.

                <input type="checkbox" name="optstockexec" id="optstockexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_EXEC');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('optstockexec').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_EXEC')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Stok Jalankan.

                <input type="checkbox" name="optstockrepo" id="optstockrepo" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockrepo').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_REPO');
                              }                
                              else if (checked == false) 
                              {
                                  document.getElementById('optstockrepo').checked = true;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_REPO')
                              }
                              else
                              {
                                alert('Problem Access!');
                              }
                            ">
                Stok Laporan.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Pembelian :</label>

                <input type="checkbox" name="optsuplentr" id="optsuplentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsuplentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SUPL_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsuplentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SUPL_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Pemasok/Suplier

                <input type="checkbox" name="optprocentr" id="optprocentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Buka PO.

                <input type="checkbox" name="optprocupdt" id="optprocupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Periksa Pembelian.

                <input type="checkbox" name="optprocinvc" id="optprocinvc" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocinvc').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_INVC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocinvc').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_INVC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Invoice.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Admisi :</label>
                <input type="checkbox" name="optregientr" id="optregientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optregientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REGI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optregientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REGI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Pendaftaran Pasien / Jadwal Dokter.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Rawat Jalan :</label>

                <input type="checkbox" name="opttrxapoli" id="opttrxapoli" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxapoli').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_POLI');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxapoli').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_POLI')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Perawatan Pasien.

                <input type="checkbox" name="optmedientr" id="optmedientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmedientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MEDI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmedientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MEDI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Data Tindakan


            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Laboratorium :</label>
                <input type="checkbox" name="optlaboentr" id="optlaboentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optlaboentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_LABO_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optlaboentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_LABO_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Pemeriksaan Laboratorium.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Rekanan :</label>
                <input type="checkbox" name="optcustentr" id="optcustentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Data Rekanan / Customer.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Kasir</label>
                <input type="checkbox" name="optsaleentr" id="optsaleentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsaleentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SALE_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsaleentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SALE_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Transaksi.

                <input type="checkbox" name="optsaleview" id="optsaleview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsaleview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SALE_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsaleview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SALE_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Laporan.

            </div><!-- pure-control-group -->                

            <div class="pure-control-group">

                <label>Farmasi :</label>
                <input type="checkbox" name="optdrugentr" id="optdrugentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdrugentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DRUG_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdrugentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DRUG_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Transaksi.

                <input type="checkbox" name="optdrugview" id="optdrugview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdrugview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DRUG_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdrugview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DRUG_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Laporan.


            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Rekam Medis :</label>
                <input type="checkbox" name="optmedirepo" id="optmedirepo" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmedirepo').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MEDI_REPO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmedirepo').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MEDI_REPO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Report Rekam Medis.


            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Keuangan :</label>

                <input type="checkbox" name="optvendentr" id="optvendentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Pengajuan Bayar Vendor.

                <input type="checkbox" name="optvendupdt" id="optvendupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Persetujuan Bayar Vendor.

                <input type="checkbox" name="optvendexec" id="optvendexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Eksekusi Bayar Vendor.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">
              <label>  </label>

                <input type="checkbox" name="optcustrcvd" id="optcustrcvd" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustrcvd').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_RCVD');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustrcvd').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_RCVD')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Pelunasan Piutang.
                
                <input type="checkbox" name="optpaymcash" id="optpaymcash" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpaymcash').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYM_CASH');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpaymcash').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYM_CASH')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Bayar Lain Lain.

                <input type="checkbox" name="optdebtentr" id="optdebtentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdebtentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DEBT_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdebtentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DEBT_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Debit.

                <input type="checkbox" name="optcrdtentr" id="optcrdtentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcrdtentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CRDT_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcrdtentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CRDT_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Credit.

                <input type="checkbox" name="optbankreco" id="optbankreco" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optbankreco').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_BANK_RECO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optbankreco').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_BANK_RECO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Rekonsiliasi Bank.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Asset Tetap :</label>
                <input type="checkbox" name="optfixeasse" id="optfixeasse" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optfixeasse').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_FIXE_ASSE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optfixeasse').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_FIXE_ASSE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Manajemen Aset Tetap.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Personil :</label>
                <input type="checkbox" name="optemplentr" id="optemplentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Manajemen Personalia.

                <input type="checkbox" name="optpayrentr" id="optpayrentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpayrentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYR_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpayrentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYR_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payroll.

            </div><!-- pure-control-group -->


            <div class="pure-control-group">

        </fieldset>

        <fieldset>
        <a class="pure-button button-update" 
        onclick="javascript: location.href = 'PASSIDEN02.php';
        ">Close</a>
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
<script src="js/PASSIDEN02.js"></script>
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
