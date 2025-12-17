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
<title>Penjualan Obat Bebas</title>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG00.php'">
                <a class="pure-menu-link">
                Input Resep
              </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXADRUG01.php'">
                <a class="pure-menu-link">
                Penyerahan Obat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Penjualan Obat
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
    <form name="frmtrxadrug" class="pure-form pure-form-aligned" method="post" action="TRXADRUG02U.php">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtdrugcode">Faktur :</label>
              <input type="text" 
            		name="txtdrugcode" 
              	id="txtdrugcode" 
              	maxlength ="14"
              	style="width: 160px;"
                readonly="true">

              <label for="optpaymmode">Cara Bayar :</label>
              <select name="optpaymmode" id="optpaymmode" onchange="document.getElementById('optpaymmode').focus();">
                <option value="TUN">Tunai/Cash</option>
                <option value="BCA">Debit BCA</option>
                <option value="MAN">Debit Mandiri</option>
                <option value="BNI">Debit BNI</option>
                <option value="BCM">Transfer BCA</option>
                <option value="LIN">Transfer Link Aja</option>
              </select>

            </div><!-- pure-control-group --> 

            <div class="pure-control-group">

            <label for="txtpaymamnt">Pembayaran :</label>
              <input type="text" 
                name="txtpaymamnt" 
                id="txtpaymamnt" 
                maxlength ="10"
                style="width: 160px;"
                readonly="true">

            <label for="txtpaymdisc">Diskon :</label>
              <input type="text" name="txtpaymdisc" id="txtpaymdisc"
              maxlength="10" style="width: 160px" value="0"
              onkeydown="if (event.keyCode == 13 && value.length > 0) 
              {
                if (isNaN(this.value)) 
                  {
                    document.getElementById('txtpaymdisc').value = '0';
                    document.getElementById('txtpaymdisc').focus();                          
                  }
                else
                  {
                    var inRupiah = convertToRupiah(this.value);
                    document.getElementById('txtpaymdisc').value = inRupiah;
                    document.getElementById('txtstockcode').focus();
                  }
              }"

              onclick="if (isNaN(this.value)) 
              {
                var inAngka = convertToAngka(this.value);
                document.getElementById('txtpaymdisc').value = inAngka;
                document.getElementById('txtpaymdisc').focus();
              }
            ">        

          	</div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtstockcode">Obat :</label>
              <input type="text" 
                  name="txtstockcode" 
                  id="txtstockcode" 
                  maxlength ="100"
                  style="width: 300px;"
                  autocomplete="off" 

                  onkeyup="if (value.length > 0) 
                  {
                  //ambilresep(this.value,regipoli);
                  ambilobat(this.value);
                  } 
                else 
                  { 
                    document.getElementById('tblobat').innerHTML = '';
                    document.getElementById('tblobat').style.visibility = 'hidden';
                  }">
                  <input type="hidden" name="hidstockcode" id="hidstockcode">
                  <input type="hidden" name="hidstockpric" id="hidstockpric">
                  <input type="hidden" name="hidstockquty" id="hidstockquty">

            <label for="txtstockbtch">Kode Batch :</label>
              <input type="text" 
                name="txtstockbtch" 
                id="txtstockbtch" 
                maxlength ="10"
                style="width: 150px;"
                autocomplete="off" 

                onkeyup="if (value.length > 0) 
                  {
                  let stockcode = document.getElementById('hidstockcode').value;

                  ambilbatch(this.value,stockcode);
                  } 
                else 
                  { 
                    document.getElementById('tblbatch').innerHTML = '';
                    document.getElementById('tblbatch').style.visibility = 'hidden';
                  }">

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
                      	  document.getElementById('hiddrugconc').value = 'N';
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
                      	document.getElementById('hiddrugconc').value = 'Y';
                  	  }                
                ">

      		<input name="hiddrugconc"
              id="hiddrugconc"
              type="hidden">

          	</div><!-- pure-control-group -->

          	<div class="pure-control-group">

            <label for="txtdrugsigna">Aturan Makan :</label>
              <input type="text" name="txtdrugsigna" id="txtdrugsigna"
                maxlength="100" style="width: 300px"
                onkeyup="if (value.length > 0) 
                {
                  		ambilsignacode(this.value);
                } 
                else 
                { 
                  		document.getElementById('tblsigna').style.visibility = 'hidden';
                }"
            >
            <input type="hidden" name="hiddrugsigna" id="hiddrugsigna">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtdrugusage">Cara Pemakaian :</label>
              <input type="text" 
                  name="txtdrugusage" 
                  id="txtdrugusage" 
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

                  var tersedia = parseInt(document.getElementById('hidstockquty').value);

                  if (document.getElementById('hidstockcode').value == '')
                  {
                    swal({
                        title: 'Item Obat Kosong' ,
                        text: 'Anda belum memilih item Obat, silah periksa lagi',
                        icon: 'warning',
                        });
                  }
                  else if (document.getElementById('txtstockbtch').value == '')
                  {
                      swal({
                          title: 'Batch Code Kosong' ,
                          text: 'Anda belum mengisi Batch Code, silah periksa lagi',
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
                          text: 'Jumlah kuantiti anda melebihi jumlah stock saat ini, kurangi kuantiti anda',
                          icon: 'warning',
                          });                    
                  }

                  else if (document.getElementById('hiddrugconc').value == '')
                  {
                      swal({
                          title: 'Jenis Racikan Obat Kosong' ,
                          text: 'Anda belum memilih Jenis Racikan , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hiddrugsigna').value == '')
                  {
                      swal({
                          title: 'Signa Kosong' ,
                          text: 'Anda belum mengisi Signa, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtdrugusage').value == '')
                  {
                      swal({
                          title: 'Cara Pemakaian ' ,
                          text: 'Anda belum mengisi Cara Pemakaian , silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var indrugcode = document.getElementById('txtdrugcode').value;
                       var inpaymmode = document.getElementById('optpaymmode').value;

                       var inpaymamnt = document.getElementById('txtpaymamnt').value;
                       var inpaymdisc = document.getElementById('txtpaymdisc').value;

                       var instockcode = document.getElementById('hidstockcode').value;
                       var instockpric = document.getElementById('hidstockpric').value;
                       
		      <!--/*up harga obat apotek lewat klinik*/-->
		      <!-- var instockpric40 = parseFloat(instockpric) * 0.4;-->
		      <!-- var instockpricbaru = parseFloat(instockpric40) + parseFloat(instockpric);                       -->

                       var instockbtch = document.getElementById('txtstockbtch').value;

                       var instockquty = document.getElementById('txtstockquty').value;

                       var indrugconc = document.getElementById('hiddrugconc').value;

                       var indrugsgna = document.getElementById('hiddrugsigna').value;
                       var indrugusag = document.getElementById('txtdrugusage').value;

                       input(indrugcode,inpaymmode,inpaymamnt,inpaymdisc,instockcode,instockpric,instockbtch,instockquty,indrugconc, indrugsgna, indrugusag);
                    }
        ">Input</a>

          <a class="button-update pure-button" 
              onclick="javascript: if (document.getElementById('txtdrugcode').value.length == 14) 
                                  {
                                    if (confirm ('Are You Sure To Create Order ?')) 
                                        { 
                                          document.frmtrxadrug.submit(); 
                                        } 
                                    else 
                                        { 
                                          alert('Harap Lengkap isian Form Order');
                                          document.getElementById('txtstockcode').focus(); 
                                        }                                             
                                  }
        ">Bayar</a>


      </fieldset>
      
      <fieldset>
          <div id="tblscreen">
      </fieldset>

      <fieldset>
          <div id="tblregi" 
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>
 
      <fieldset>
          <div id="tblobat" 
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
        
      </fieldset>

      <fieldset>
          <div id="tblbatch" 
          style="position: absolute; 
                 top: 300px;
                 left: calc(70% - 200px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>
 
      <fieldset>
        
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
<script src="js/TRXADRUG02.js"></script>
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
