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
<title>Resep</title>
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
<script src="js/sanie.js"></script>
<script src="js/sweetalert.min.js"></script>

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_DRUG_ENTR'); 
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
                <a class="pure-menu-link">FARMASI</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Transaksi</a>
              </li>


              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADRUG04.php'">
                <a class="pure-menu-link">Report</a>
              </li>
              
              <li class="pure-menu-item" onclick="window.open('INVEUP00.php','_blank')" style="cursor:pointer;">
                <a class="pure-menu-link">Update Stock/Harga Obat</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = ''">
                <a class="pure-menu-link">
                Dashboard
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Input Resep
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG01.php'">
              	<a class="pure-menu-link">
                Penyerahan Obat
            	</a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG02.php'">
                <a class="pure-menu-link">
                Penjualan Obat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG03.php'">
                <a class="pure-menu-link">
                Faktur
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxadrug" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

          <div class="pure-control-group">

            <label for="txtsearch">Cari :</label>
              <input type="text" name="txtsearch" id="txtsearch"
                maxlength="10" style="width: 100px"
                onkeyup="if (value.length > 0) 
                {
                  var dokter = document.getElementById('hidprscdoct').value;
                  ambilregicode(this.value,dokter);
                } 
                else 
                { 
                  document.getElementById('tblregi').style.visibility = 'hidden';
                }"
            >

          </div><!-- pure-control-group -->

      		<div class="pure-control-group">

        		<label for="txtprsccode">No. Daftar :</label>
              <input type="text" 
            		name="txtprsccode" 
              	id="txtprsccode" 
              	maxlength ="14"
              	style="width: 160px;"
                readonly="true">

                <input type="hidden" name="hidprscdoct" id="hidprscdoct" value="<?php echo $user;?>">

            <label for="txtpaticode">Rekam Medis :</label>
              <input type="text" 
                name="txtpaticode" 
                id="txtpaticode" 
                maxlength ="10"
                style="width: 150px;"
                readonly="true">

          	</div><!-- pure-control-group --> 

          	<div class="pure-control-group">

        		<label for="txtmainname">Nama :</label>
              	<input type="text" 
            		name="txtmainname" 
              		id="txtmainname" 
              		maxlength ="14"
              		style="width: 300px;"
                  	readonly="true">

            	<label for="txtmaingend">L/P :</label>
              	<input type="text" 
                  name="txtmaingend" 
                  id="txtmaingend" 
                  maxlength ="10"
                  style="width: 120px;"
                  readonly="true">


          	</div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtlahir">Tangal Lahir :</label>
                <input type="text" 
                  name="txtlahir" 
                  id="txtlahir" 
                  maxlength ="50"
                  style="width: 300px;"
                  readonly="true">

            </div><!-- pure-control-group --> 
            
            <div class="pure-control-group">

              <label for="txtmainage">Usia :</label>
                <input type="text" 
                  name="txtmainage" 
                  id="txtmainage" 
                  maxlength ="50"
                  style="width: 300px;"
                  readonly="true">

            </div><!-- pure-control-group --> 

            <div class="pure-control-group">

              <label for="txtregipaym">Pembayaran :</label>
                <input type="text" 
                  name="txtregipaym" 
                  id="txtregipaym" 
                  maxlength ="50"
                  style="width: 150px;"
                  readonly="true">

                <input type="hidden" name="hidregipaym" id="hidregipaym">
                <input type="hidden" name="hidmediroom" id="hidmediroom">
            </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtexamprsc">Resep Dokter:</label>
            
            <textarea id="txtexamprsc" name="txtexamprsc" readonly="true" 
            rows="4" cols="30">
              
            </textarea>


          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtstockcode">Resep Farmasi :</label>
              <input type="text" 
                  name="txtstockcode" 
                  id="txtstockcode" 
                  maxlength ="100"
                  style="width: 300px;"
                  autocomplete="off" 

                  onkeyup="if (value.length > 0) 
                  {
                  var regipoli = document.getElementById('hidmediroom').value;
                  var regipaym = document.getElementById('hidregipaym').value;  
                  ambilresep(this.value,regipoli,regipaym);
                  } 
                else 
                  { 
                    document.getElementById('tblresep').innerHTML = '';
                    document.getElementById('tblresep').style.visibility = 'hidden';
                  }">
                  

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

                  <input type="hidden" name="hidstockcode" id="hidstockcode">
                  <input type="hidden" name="hidstockbtch" id="hidstockbtch">
                  <input type="hidden" name="hidstockpric" id="hidstockpric">
                  <input type="hidden" name="hidstockamnt" id="hidstockamnt">
                  
          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtstockquty">Qty :</label>
              <input type="text" 
                  name="txtstockquty" 
                  id="txtstockquty" 
                  maxlength ="10"
                  style="width: 50px;"
                  value="1" 

                  onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  this.value = '1';
                                  this.focus();                          
                                }
                                else
                                {
                                  document.getElementById('txtsigna').focus();
                                }
                            }"
                onclick="if (isNaN(this.value)) 
                              {
                                this.value = '0'
                                this.focus();
                              }

                            ">         

      		<label for="optnonracikan">Bukan Racikan</label>
      		<input type="checkbox"
            	name="optnonracikan" 
            	id="optnonracikan"
            	value="true"
            	onclick="if (checked == true) 
                	  {
                    	  document.getElementById('optracikan').checked = false;
                      	  document.getElementById('hidprscconc').value = 'N';
                  	  }                
                ">

      		<label for="optracikan">Racikan</label>
      		<input type="checkbox"
            	name="optracikan" 
            	id="optracikan"
            	value="true"
            	onclick="if (checked == true) 
                	  {
                    	document.getElementById('optnonracikan').checked = false;
                      	document.getElementById('hidprscconc').value = 'Y';
                  	  }                
                ">

      		<input name="hidprscconc"
              id="hidprscconc"
              type="hidden">

          	</div><!-- pure-control-group -->

          	<div class="pure-control-group">

            <label for="txtsigna">Aturan Makan :</label>
              <input type="text" name="txtsigna" id="txtsigna"
                maxlength="100" style="width: 300px"
                onkeyup="if (value.length > 0) 
                {
                  		ambilsignacode(this.value);
                } 
                else 
                { 
                  		document.getElementById('tblregi').style.visibility = 'hidden';
                }"
            >
            <input type="hidden" name="hidsigna" id="hidsigna">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtusage">Cara Pemakaian :</label>
              <input type="text" 
                  
                  name="txtusage" 
                  id="txtusage" 
                  maxlength ="100"
                  style="width: 500px;"

                  onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                                  this.focus();                          
                            }">         

          </div><!-- pure-control-group -->

      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:

                  var ambil = parseInt(document.getElementById('txtstockquty').value);

                  var tersedia = parseInt(document.getElementById('hidstockamnt').value);

                  if (document.getElementById('txtstockcode').value == '')
                  {
                    swal({
                        title: 'Item Obat Kosong' ,
                        text: 'Anda belum memilih item Obat, silah periksa lagi',
                        icon: 'warning',
                        });
                  }


                  else if (document.getElementById('txtstockquty').value == '0')
                  {
                      swal({
                          title: 'Qty Kosong' ,
                          text: 'Anda belum mengisi Kuantiti, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (document.getElementById('txtstockquty').value == '')
                  {
                      swal({
                          title: 'Qty Kosong' ,
                          text: 'Anda belum mengisi Kuantiti, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (isNaN(document.getElementById('txtstockquty').value))
                  {
                      swal({
                          title: 'Masukkan Angka' ,
                          text: 'Anda memasukkan Huruf, bukan angka, silah periksa lagi',
                          icon: 'warning',
                          });                    
                  }
                  else if ( ambil > tersedia)
                  {
                      swal({
                          title: 'Over Kuantiti' ,
                          text: 'Jumlah kuantiti anda melebihi jumlah stock di ruangan, kurangi kuantiti anda',
                          icon: 'warning',
                          });                    
                  }

                  else if (document.getElementById('hidprscconc').value == '')
                  {
                      swal({
                          title: 'Jenis Racikan Obat Kosong' ,
                          text: 'Anda belum memilih Jenis Racikan , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidsigna').value == '')
                  {
                      swal({
                          title: 'Signa Kosong' ,
                          text: 'Anda belum mengisi Signa, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtusage').value == '')
                  {
                      swal({
                          title: 'Cara Pemakaian ' ,
                          text: 'Anda belum mengisi Cara Pemakaian , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inprsccode = document.getElementById('txtprsccode').value;
                       var inprscdoct = document.getElementById('hidprscdoct').value;

                       var instockcode = document.getElementById('hidstockcode').value;
                       var instockbtch = document.getElementById('hidstockbtch').value;
                       var instockpric = document.getElementById('hidstockpric').value;
                       
		      /*up harga obat apotek lewat klinik*/
		       var instockpric40 = parseFloat(instockpric) * 0.4;
		       var instockpricbaru = parseFloat(instockpric40) + parseFloat(instockpric);

                       var instockquty = document.getElementById('txtstockquty').value;

                       var inprscconc = document.getElementById('hidprscconc').value;

                       var inprscsgna = document.getElementById('hidsigna').value;
                       var inprscusag = document.getElementById('txtusage').value;

                       var inmediroom = document.getElementById('hidmediroom').value;

                       input(inprsccode,inprscdoct,instockcode,instockbtch,instockpricbaru,instockquty,inprscconc, inprscsgna, inprscusag, inmediroom);
                    }
        ">Input</a>

          <a class="button-update pure-button" onclick="javascript: location.href = 'TRXADRUG00.php'">Close</a>

      </fieldset>
      
      <fieldset>
          <div id="tblscreen">
      </fieldset>

      <fieldset>
        <div id="tblresep"
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>
      <fieldset>
          <div id="tblregi" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>

          <div id="tblsigna" 
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 250px);
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
<script src="js/TRXADRUG00.js"></script>
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
