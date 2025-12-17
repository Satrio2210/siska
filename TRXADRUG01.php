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
<title>Farmasi</title>
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

  .button-print {
            background: rgb(223, 117, 20);
            /* this is an orange */
        }

	.button-view {
    	background: rgb(28, 184, 65);
            /* this is an green */
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

              <li class="pure-menu-item pure-menu-disabled">
                Penyerahan Obat
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

            <label for="txtprsccode">No. Daftar :</label>
              <input type="text" 
                name="txtprsccode" 
                id="txtprsccode" 
                maxlength ="14"
                style="width: 160px;"
                readonly="true">

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
                  style="width: 200px;"
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

            <label for="txtstockcode">Resep Obat :</label>
              <input type="text" 
                  name="txtstockcode" 
                  id="txtstockcode" 
                  maxlength ="100"
                  style="width: 300px;"
                  readonly="true"> 
                  <input type="hidden" name="hidstockcode" id="hidstockcode">

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


      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('txtprsccode').value == '')
                  {
                    swal({
                        title: 'Kode Resep Kosong' ,
                        text: 'Anda belum memilih Resep, silah periksa lagi',
                        icon: 'warning',
                        });
                  }
                  else if (document.getElementById('txtstockquty').value == '')
                  {
                      swal({
                          title: 'Jumlah Item Kosong' ,
                          text: 'Anda belum mengisi Quantity, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (document.getElementById('hidprscconc').value == '')
                  {
                      swal({
                          title: 'Pilihan Obat Racikan kosong' ,
                          text: 'Anda belum mengisi Pilihan Obat Racikan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }
                  else if (document.getElementById('txtstockbtch').value == '')
                  {
                      swal({
                          title: 'Kode Batch Kosong' ,
                          text: 'Anda belum mengisi Kode Batch, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var inprsccode = document.getElementById('txtprsccode').value;
                       var instockcode = document.getElementById('hidstockcode').value;
                       var inprscconc = document.getElementById('hidprscconc').value;
                       var instockbtch = document.getElementById('txtstockbtch').value;

                       input(inprsccode,instockcode,inprscconc,instockbtch);
                    }
        ">Siapkan</a>

          <a class="pure-button button-print" onClick="javascript: var inregicode = document.getElementById('txtprsccode').value;
           location.href ='TRXADRUG01P.php?regicode='+inregicode">Print Kwitansi</a> 


        </fieldset>

              	<fieldset>
      	<label for="txtsearch">Cari...</label>
      	<input type="text" class="pure-input-rounded"
            name="txtsearch" 
            id="txtsearch" 
            maxlength ="20"
            style="width: 200px;"
            onkeyup="if (value.length > 0) { ambilscreen(this.value); } else {ambilscreen('')};"

            onkeydown="if (event.keyCode == 13 && value.length > 0) 
                        { 
                        document.getElementById('txtsearch').value = '';
                        document.getElementById('txtsearch').focus()
                        }">
      	</fieldset>

      <fieldset>
          <div id="tblscreen">
      </fieldset>

      <fieldset>
          <div id="tblbatch" 
          style="position: absolute; 
                 top: 300px;
                 left: calc(50% - 200px);
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
<script src="js/TRXADRUG01.js"></script>
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
