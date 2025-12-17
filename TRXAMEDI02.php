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
<title>Fee Master</title>
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
<script src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/sanie.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_MEDI_ENTR');
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
                <a class="pure-menu-link">RAWAT JALAN</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI01.php'">
                <a class="pure-menu-link">Pasien</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPOLI05.php'">
                <a class="pure-menu-link">Signa</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Tindakan Medis</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'DIAGMAST01.php'">
                <a class="pure-menu-link">Kode Diagnosa</a>
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
        <div class="headerlogo">
        </div>

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI01.php'">
                <a class="pure-menu-link">
                Tindakan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Fee Master
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI03.php'">
                <a class="pure-menu-link">
                Kehadiran
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAMEDI04.php'">
                <a class="pure-menu-link">
                Kunjungan
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxamedi" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtfeecode">Kode Fee :</label>
              		<input type="text" 
            	  	name="txtfeecode" 
              		id="txtfeecode" 
              		maxlength ="8"
              		style="width: 110px;"
              		readonly="true"> 

            <label for="txtmastroom">Ruang Medis :</label>
                <input type="text" name="txtmastroom" id="txtmastroom"
                  maxlength="50" style="width: 200px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                      ambilpolicode(this.value);
                    } 
                  else 
                    { 
                      document.getElementById('tblpoli').style.visibility = 'hidden';
                    }"
                  >
            <input type="hidden" name="hidmastroom" id="hidmastroom">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="optmasttype">Tipe Tindakan :</label>
                <select name="optmasttype" id="optmasttype" 
                onchange="document.getElementById('txtmastuser').value = '';
                document.getElementById('hidmastuser').value = '';

                document.getElementById('txtmedicode').value = '';
                document.getElementById('hidmedicode').value = '';

                document.getElementById('optmasttype').focus();">
                  <option value="J">Jasa</option>
                  <option value="O">Operatif</option>
                  <option value="N">Non Operatif</option>
                </select>

              <label for="optmastpaym">Pembayaran :</label>
                <select name="optmastpaym" id="optmastpaym" 
                onchange="document.getElementById('txtmastuser').value = '';
                document.getElementById('hidmastuser').value = '';

                document.getElementById('txtmedicode').value = '';
                document.getElementById('hidmedicode').value = '';
                
                document.getElementById('optmastpaym').focus();">
                  <option value="U">Umum</option>
                  <option value="B">BPJS</option>
                  <option value="A">Asuransi</option>
                  <option value="P">Perusahaan</option>
                </select>

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="txtmastuser">Fee User :</label>
                <input type="text" name="txtmastuser" id="txtmastuser"
                  maxlength="100" style="width: 300px"
                  autocomplete="off" 
                  onkeyup="if (value.length > 0) 
                    {
                    ambiluseriden(this.value);
                    } 
                  else 
                    { 
                    document.getElementById('tbluser').style.visibility = 'hidden';
                    }"
                    >
                <input type="hidden" name="hidmastuser" id="hidmastuser">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="txtmedicode">Tindakan :</label>
              	<input type="text" 
                  	name="txtmedicode" 
                  	id="txtmedicode" 
                  	maxlength ="100"
                  	style="width: 300px;"
                    autocomplete="off" 
                    onkeyup="if (value.length > 0) 
                    {
                    var getmastroom = document.getElementById('hidmastroom').value;
                    var getmasttype = document.getElementById('optmasttype').value; 
                    var getmastpaym = document.getElementById('optmastpaym').value;

                    ambilmedicode(getmastroom,getmasttype,getmastpaym,this.value);
                    } 
                    else 
                    { 
                    document.getElementById('tblmedi').style.visibility = 'hidden';
                    }"
                    >
                <input type="hidden" name="hidmedicode" id="hidmedicode">

          	</div><!-- pure-control-group -->

            <div class="pure-control-group">

              <label for="optprosentase">Prosentase</label>
                <input type="checkbox"
                  name="optprosentase" 
                  id="optprosentase"
                  value="true"
                  onclick="if (checked == true) 
                  {
                      document.getElementById('optfixrate').checked = false;
                      document.getElementById('hidmastrate').value = 'P';
                      let medicode = document.getElementById('hidmedicode').value;
                      ambiltarif(medicode);
                      document.getElementById('txtpartuser').focus();
                  }                
                "> [%]

              <label for="optfixrate">Nilai Tetap</label>    
                <input type="checkbox"
                  name="optfixrate" 
                  id="optfixrate"
                  value="true"
                  onclick="if (checked == true) 
                  {
                      document.getElementById('optprosentase').checked = false;
                      document.getElementById('hidmastrate').value = 'F';
                      let medicode = document.getElementById('hidmedicode').value;
                      ambiltarif(medicode);
                      document.getElementById('txtpartuser').focus();

                  }                
                "> [Rp.]

                <input name="hidmastrate" id="hidmastrate" type="hidden">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

      			   <label for="txtpartuser">Fee Dokter/Bidan :</label>
            			<input type="text" 
                   	name="txtpartuser" 
                   	id="txtpartuser" 
                   	maxlength ="10"
                    value="0" 
                   	style="width: 100px;"
                    onkeyup="if (value.length > 0)
                                {

                                  let medicode = document.getElementById('hidmedicode').value;
                                  let mastrate = document.getElementById('hidmastrate').value;
                                  ambilnilai(medicode,this.value,mastrate);
                                }
                                else
                                {
                                  let medicode = document.getElementById('hidmedicode').value;
                                  ambiltarif(medicode);
                                }
                            "

                   	onkeydown="if (event.keyCode == 13 && value.length > 0)
                   	{
                   		if (isNaN(this.value)) 
                   			{ 
                   				document.getElementById('txtpartuser').value = '0'; 
                   				document.getElementById('txtpartuser').focus(); 
                   			}
                   		else
                   		 	{
                  				var inRupiah = convertToRupiah(this.value);
                      		document.getElementById('txtpartuser').value = inRupiah;
                   		 	 	document.getElementById('txtparthome').focus(); 
                   		 	}
                   	}">        	


               <label for="txtparthome">Fee Klinik :</label>
                  <input type="text" 
                    name="txtparthome" 
                    id="txtparthome" 
                    maxlength ="10"
                    value="0" 
                    style="width: 100px;"
                    readonly="true"> 

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

               <label for="txtmaxiamnt">Fee Maximum :</label>
                  <input type="text" 
                    name="txtmaxiamnt" 
                    id="txtmaxiamnt" 
                    maxlength ="10"
                    value="0" 
                    style="width: 100px;"
                    onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                      if (isNaN(this.value)) 
                        { 
                          document.getElementById('txtmaxiamnt').value = '0'; 
                          document.getElementById('txtmaxiamnt').focus(); 
                        }
                      else
                        {
                          var inRupiah = convertToRupiah(this.value);
                          document.getElementById('txtmaxiamnt').value = inRupiah;
                          document.getElementById('txtminiamnt').focus(); 
                        }
                    }">         


               <label for="txtminiamnt">Fee Minimum :</label>
                  <input type="text" 
                    name="txtminiamnt" 
                    id="txtminiamnt" 
                    maxlength ="10"
                    value="0" 
                    style="width: 100px;"
                    onkeydown="if (event.keyCode == 13 && value.length > 0)
                    {
                      if (isNaN(this.value)) 
                        { 
                          document.getElementById('txtminiamnt').value = '0'; 
                          document.getElementById('txtminiamnt').focus(); 
                        }
                      else
                        {
                          var inRupiah = convertToRupiah(this.value);
                          document.getElementById('txtminiamnt').value = inRupiah;
                          document.getElementById('txtminiamnt').focus(); 
                        }
                    }">         

            </div><!-- pure-control-group -->

      	</fieldset>

      	<fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hidmastroom').value == '')
                  {
                    swal({
                        title: 'Nama Poli Kosong' ,
                        text: 'Anda belum mengisi Nama Poli, silah periksa lagi',
                        icon: 'warning',
                        });
                  }

                  else if (document.getElementById('hidmastuser').value == '0')
                  {
                      swal({
                          title: 'Nama Dokter atau Bidan Kosong' ,
                          text: 'Anda belum memilih nama Dokter atau Bidan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidmedicode').value == '')
                  {
                      swal({
                          title: 'Nama Tindakan Kosong' ,
                          text: 'Anda belum memilih nama Tindakan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('hidmastrate').value == '')
                  {
                      swal({
                          title: 'Opsi Nilai Kosong' ,
                          text: 'Anda belum memilih Opsi Nilai Tarif, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtpartuser').value == '')
                  {
                      swal({
                          title: 'Fee Dokter atau Bidan Kosong' ,
                          text: 'Anda belum mengisi Fee Dokter atau Bidan, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtparthome').value == '')
                  {
                      swal({
                          title: 'Fee Klinik Kosong' ,
                          text: 'Anda belum mengisi Fee Klinik, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtmaxiamnt').value == '')
                  {
                      swal({
                          title: 'Maksimal Fee Kosong' ,
                          text: 'Anda belum mengisi Maksimal Fee, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                  else if (document.getElementById('txtminiamnt').value == '')
                  {
                      swal({
                          title: 'Minimal Fee Kosong' ,
                          text: 'Anda belum mengisi Minimal Fee, silah periksa lagi',
                          icon: 'warning',
                          });
                  }

                   else
                   {
                       var infeecode = document.getElementById('txtfeecode').value;
                       var inmastroom = document.getElementById('hidmastroom').value;
                       var inmasttype = document.getElementById('optmasttype').value; 
                       var inmastpaym = document.getElementById('optmastpaym').value;

                       var inmastuser = document.getElementById('hidmastuser').value;
                       var inmedicode = document.getElementById('hidmedicode').value;

                       var inmastrate = document.getElementById('hidmastrate').value;

                       var inpartuser = document.getElementById('txtpartuser').value;
                       var inparthome = document.getElementById('txtparthome').value;

                       var inmaxiamnt = document.getElementById('txtmaxiamnt').value;
                       var inminiamnt = document.getElementById('txtminiamnt').value;

              input(infeecode,inmastroom,inmasttype,inmastpaym,inmastuser,inmedicode,inmastrate,inpartuser,inparthome,inmaxiamnt,inminiamnt);
                    }
        ">Submit</a>
        </fieldset>

      	<fieldset>
      	<label for="txtsearch">Search</label>
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
                <div id="tblpoli" 
                style="position: absolute; 
                top: 200px;
                left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">

      </fieldset>

      <fieldset>
                <div id="tbluser" 
                style="position: absolute; 
                top: 300px;
                left: calc(70% - 150px);
                background-color: white; 
                visibility: hidden; 
                z-index: 100">
      </fieldset>

      <fieldset>
                <div id="tblmedi" 
                style="position: absolute; 
                top: 300px;
                left: calc(70% - 150px);
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
<script src="js/TRXAMEDI02.js"></script>
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
