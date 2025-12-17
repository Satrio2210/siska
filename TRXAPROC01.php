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
<title>Buka PO</title>
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

<body onload="periksaakses('PASS_PROC_ENTR');
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
                <a class="pure-menu-link">PEMBELIAN</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'SUPLMAST00.php'">
                <a class="pure-menu-link">Pemasok</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Buka PO</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC03.php'">
                <a class="pure-menu-link">Barang Masuk</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPROC05.php'">
                <a class="pure-menu-link">Tagihan</a>
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
                Input Order
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPROC02.php'">
                <a class="pure-menu-link">
                Print Order
                </a>
              </li>


            </ul>
          </div>
    	<!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxaproc" class="pure-form pure-form-aligned" method="post" action="TRXAPROC01U.php">

    <fieldset>
    <legend>Info Suplier</legend>

    	<div class="pure-control-group">

      	<label for="txtproccode">Kode Transaksi :</label>
      	<input type="text" 
             name="txtproccode" 
             id="txtproccode"
             maxlength ="7"
             style="width: 100px;"
             readonly = "true">

        <label for="tglprocdate">Tanggal Transaksi :</label>
     	    <input type="date" name="tglprocdate" id="tglprocdate" value="<?php echo $datenow; ?>"
                onchange="document.getElementById('tglprocdued').focus()">

        <label for="tglprocdued">Tanggal Tenggat :</label>
     	<input type="date" name="tglprocdued" id="tglprocdued" value="<?php echo $datenow; ?>"
      onchange="document.getElementById('tglprocdivi').focus()">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtprocdivi">Divisi :</label>
      <input type="text" name="txtprocdivi" id="txtprocdivi"
      maxlength="50" style="width: 200px"
      autocomplete="off" 
      onkeyup="if (value.length > 0) 
              {
              ambildivicode(this.value);
              } 
            else 
              { 
               document.getElementById('tbldivi').style.visibility = 'hidden';
              }"
        >
      <input type="hidden" name="hidprocdivi" id="hidprocdivi">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtsuplname">Nama Suplier :</label>
      <input type="text" name="txtsuplname" id="txtsuplname"
      maxlength="50" style="width: 300px" 
      autocomplete="off" 
      onkeyup="if (value.length > 0) 
              {
              ambilsuplcode(this.value);
              } 
            else 
              { 
               document.getElementById('tblsupl').style.visibility = 'hidden';
              }"
        >
      <input type="hidden" name="hidsuplcode" id="hidsuplcode">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtsupladdr">Alamat :</label>
      <input type="text" name="txtsupladdr" id="txtsupladdr"
      maxlength="50" style="width: 500px" 
      readonly="true"> 

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label>Pengantaran Barang :</label>
      <input type="checkbox"
            name="optshipping" 
            id="optshipping"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optdestination').checked = false;
                      document.getElementById('hidprocfrob').value = 'S';
                  }                
                ">
            Diambil.
      <input type="checkbox"
            name="optdestination" 
            id="optdestination"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optshipping').checked = false;
                      document.getElementById('hidprocfrob').value = 'D';
                  }                
                ">
            Diantar.
      <input name="hidprocfrob"
              id="hidprocfrob"
              type="hidden">

      </div><!-- pure-control-group -->

    </fieldset>

    <fieldset>
      	<legend>Info Pembayaran</legend>


      <div class="pure-control-group">

      <label>PPN 10% :</label>
      <input type="checkbox"
            name="optnone" 
            id="optnone"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optexclude').checked = false;
                      document.getElementById('optinclude').checked = false;
                      document.getElementById('hidprocvatx').value = 'N';
                  }                
                ">
            None.
      <input type="checkbox"
            name="optexclude" 
            id="optexclude"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optnone').checked = false;
                      document.getElementById('optinclude').checked = false;
                      document.getElementById('hidprocvatx').value = 'E';
                  }                
                ">
            Exclude.
      <input type="checkbox"
            name="optinclude" 
            id="optinclude"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optnone').checked = false;
                      document.getElementById('optexclude').checked = false;
                      document.getElementById('hidprocvatx').value = 'I';
                  }                
                ">
            Include.

      <input name="hidprocvatx"
              id="hidprocvatx"
              type="hidden">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label>Tipe Transaksi :</label>
      <input type="checkbox"
            name="optnolc" 
            id="optnolc"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optwithlc').checked = false;
                      document.getElementById('hidproctype').value = 'NLC';
                  }                
                ">
            No Letter Of Credit.
      <input type="checkbox"
            name="optwithlc" 
            id="optwithlc"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optnolc').checked = false;
                      document.getElementById('hidproctype').value = 'WLC';
                  }                
                ">
            With Letter Of Credit.

      <input name="hidproctype"
              id="hidproctype"
              type="hidden">
      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="opttermpaid">Termin Pembayaran :</label>
							<select name="opttermpaid" id="opttermpaid" onchange="document.getElementById('txtdownpaid').focus();">
								<option value="CBD">Cash Before Delivery</option>
								<option value="COD">Cash On Delivery</option>
								<option value="T30">Term of 30 Day</option>
								<option value="CIA">Cash In Advance</option>
								<option value="NTD">Net The Days</option>
								<option value="EOM">End of Month</option>
							</select>

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtdownpaid">Uang Muka :</label>
      <input type="text" name="txtdownpaid" id="txtdownpaid"
                maxlength="10" style="width: 100px" value="0"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtdownpaid').value = '0';
                                  document.getElementById('txtdownpaid').focus();                          
                                }
                                else
                                {
                                  var inRupiah = convertToRupiah(this.value);
                                  document.getElementById('txtdownpaid').value = inRupiah;
                                  document.getElementById('txtpartname').focus();
                                }
                            }"
              onclick="if (isNaN(this.value)) 
                              {
                                var inAngka = convertToAngka(this.value);
                                document.getElementById('txtdownpaid').value = inAngka;
                                document.getElementById('txtdownpaid').focus();
                              }
                            ">        

      <label for="txtprocterm">Termin Angsuran :</label>
      <input type="text" 
             name="txtprocterm" 
             id="txtprocterm" 
             maxlength ="3"
             style="width: 50px;"
             readonly="true"> 

      </div><!-- pure-control-group -->
    </fieldset>

    <fieldset>
      <legend>Info Item</legend>

      <div class="pure-control-group">

      <label for="txtpartname">Nama Barang :</label>
      <input type="text" name="txtpartname" id="txtpartname"
      maxlength="50" style="width: 300px"
      autocomplete="off" 
      onkeyup="if (value.length > 0) 
              {
              ambilinvecode(this.value);
              } 
            else 
              { 
               document.getElementById('tblinve').style.visibility = 'hidden';
              }"
        >
      <input type="hidden" name="hidpartcode" id="hidpartcode">
      <input type="hidden" name="hidpartunit" id="hidpartunit">


      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtqutyordr">Qty :</label>
      <input type="text" 
             name="txtqutyordr" 
             id="txtqutyordr" 
             maxlength ="6"
             style="width: 60px;"
             onkeydown="if (event.keyCode == 13 && value.length > 0)
                {
                  if (isNaN(this.value)) { document.getElementById('txtqutyordr').value = ''; document.getElementById('txtqutyordr').focus(); }
                  else { document.getElementById('txtpartpric').focus(); }
                }">         

      <label for="txtpartpric">Harga Satuan :</label>
      <input type="text" name="txtpartpric" id="txtpartpric"
                maxlength="10" style="width: 100px" value="0"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtpartpric').value = '0';
                                  document.getElementById('txtpartpric').focus();                          
                                }
                                else
                                {
                                  //var totalpric = (this.value * document.getElementById('txtqutyordr').value);
                                  //var inTotalRupiah = convertToRupiah(totalpric);
                                  var inRupiah = convertToRupiah(this.value);
                                  document.getElementById('txtpartpric').value = inRupiah;
                                  //document.getElementById('txttotalpric').value = inTotalRupiah;
                                  document.getElementById('txtchrgvalu').focus();
                                }
                            }"
              onclick="if (isNaN(this.value)) 
                              {
                                var inAngka = convertToAngka(this.value);
                                document.getElementById('txtpartpric').value = inAngka
                                document.getElementById('txtpartpric').focus();
                              }
                            ">        

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="txtchrgvalu">Biaya keterlambatan perhari :</label>
      <input type="text" 
             name="txtchrgvalu" 
             id="txtchrgvalu" 
             maxlength ="6"
             style="width: 60px;"
             onkeydown="if (event.keyCode == 13 && value.length > 0)
                {
                  if (isNaN(this.value)) { document.getElementById('txtchrgvalu').value = ''; document.getElementById('txtchrgvalu').focus(); }
                  else { document.getElementById('txtchrgvalu').focus(); }
                }">         

      <label>Perhitungan Biaya Keterlambatan :</label>
      <input type="checkbox"
            name="optamount" 
            id="optamount"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optpercentage').checked = false;
                      document.getElementById('hidchrgmthd').value = 'A';
                  }                
                ">
            Jumlah.
      <input type="checkbox"
            name="optpercentage" 
            id="optpercentage"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optamount').checked = false;
                      document.getElementById('hidchrgmthd').value = 'P';
                  }                
                ">
            Prosentase.

      <input name="hidchrgmthd"
              id="hidchrgmthd"
              type="hidden">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

        <label for="tglarrvrequ">Waktu Kedatangan :</label>
          <input type="date" name="tglarrvrequ" id="tglarrvrequ" value="<?php echo $datenow; ?>"
                  onchange="document.getElementById('txtwarename').focus()">

        <label for="txtwarename">Nama Warehouse :</label>
          <input type="text" name="txtwarename" id="txtwarename"
                maxlength="50" style="width: 200px"
                readonly="true"> 

              <input type="hidden" name="hidwarecode" id="hidwarecode">

      </div><!-- pure-control-group -->
              
    </fieldset>

      <fieldset>
        <a class="pure-button pure-button-primary" 
                onclick=" try { 
                                if (document.getElementById('hidprocdivi').value == '')
                                {
                                  alert('Harap isi nama divisi');
                                  document.getElementById('txtprocdivi').focus();
                                }

                                else if (document.getElementById('hidsuplcode').value == '')
                                {
                                  alert('Harap isi nama Supplier');
                                  document.getElementById('txtsuplname').focus();
                                }

                                else if (document.getElementById('hidprocfrob').value == '')
                                {
                                  alert('Harap isi Cara pengantaran barang');
                                  document.getElementById('txtsuplname').focus();
                                }

                                else if (document.getElementById('hidprocvatx').value == '')
                                {
                                  alert('Harap isi Pilihan PPN 10%');
                                  document.getElementById('optnone').focus();
                                }

                                else if (document.getElementById('hidproctype').value == '')
                                {
                                  alert('Harap isi Letter Trans');
                                  document.getElementById('optnolc').focus();
                                }

                                else if (document.getElementById('hidpartcode').value == '')
                                {
                                  alert('Harap isi nama item');
                                  document.getElementById('txtpartname').focus();
                                } 

                                else if (document.getElementById('txtqutyordr').value == '0')
                                {
                                  alert('Harap isi Quantity Order item');
                                  document.getElementById('txtqutyordr').focus();
                                } 

                                else if (document.getElementById('txtpartpric').value == '0')
                                {
                                  alert('Harap isi Harga Quantity Order item');
                                  document.getElementById('txtpartpric').focus();
                                } 

                                else
                                {
                                  periksalimit(document.getElementById('hidsuplcode').value);
                                }
                              }

                      catch(err){ alert(err.message); }
        ">Input Item</a>

        <a class="pure-button pure-button-primary" 
        onclick="javascript: if (document.getElementById('txtproccode').value.length == 7) 
                            {
                              if (confirm ('Are You Sure To Create Order ?')) 
                                { 
                                  document.frmtrxaproc.submit(); 
                                } 
                              else 
                              { 
              alert('Harap Lengkap isian Form Order');
              document.getElementById('txtpartname').focus(); 
            }                                             
        }
        ">Create Order</a>
              <div id="tbltrxascreen">                

        </fieldset>

      <fieldset>
                <div id="tbldivi" 
                style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tblsupl" 
                style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
      </fieldset>


      <fieldset>
                <div id="tblinve" 
                style="position: absolute; 
                 top: 700px;
                 left: calc(60% - 250px);
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
<script src="js/TRXAPROC01.js"></script>
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
