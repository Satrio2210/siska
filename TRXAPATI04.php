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
<title>Jadwal Dokter</title>
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

<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_REGI_ENTR'); 
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

              <li class="pure-menu-item menu-item-divided pure-menu-selected" onclick="javascript: location.href = 'index.php'">
                <a class="pure-menu-link">ADMISI</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPATI06.php'">
                <a class="pure-menu-link">Harga</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'REPOPATI01.php'">
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI01.php'">
                <a class="pure-menu-link">
                Daftar Pasien
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI02.php'">
                <a class="pure-menu-link">
                Pasien Berobat
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI03.php'">
                <a class="pure-menu-link">
                Ruangan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Jadwal Dokter
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAPATI07.php'">
                <a class="pure-menu-link">
                Pasien Periksa 
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxapati" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txtdoctname">Nama Dokter :</label>
              	<input type="text" 
            	  	name="txtdoctname" 
              		id="txtdoctname" 
              		maxlength ="100"
              		style="width: 300px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambilusercode(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tbluser').style.visibility = 'hidden';
                  }">

                <input type="hidden" name="hiddoctuser" id="hiddoctuser">

          </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtmediroom">Nama Poli :</label>
              <input type="text" 
                  name="txtmediroom" 
                  id="txtmediroom" 
                  maxlength ="50"
                  style="width: 300px;"
                  onkeyup="if (value.length > 0) 
                  {
                    ambilpolicode(this.value);
                  } 
                  else 
                  { 
                    document.getElementById('tblpoli').style.visibility = 'hidden';
                  }">

                  <input type="hidden" name="hidmediroom" id="hidmediroom">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">
            <label for="hidschddays">Hari :</label>

          <input type="checkbox"
              name="optminggu" 
              id="optminggu"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optjumat').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '0';

                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();

                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 
                    }                
                  ">
              Minggu.

          <input type="checkbox"
              name="optsenin" 
              id="optsenin"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optjumat').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '1';

                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Senin.

          <input type="checkbox"
              name="optselasa" 
              id="optselasa"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optjumat').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '2';

                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Selasa.

          <input type="checkbox"
              name="optrabu" 
              id="optrabu"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optjumat').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '3';

                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Rabu.

          <input type="checkbox"
              name="optkamis" 
              id="optkamis"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optjumat').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '4';
                        
                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Kamis.

          <input type="checkbox"
              name="optjumat" 
              id="optjumat"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optsabtu').checked = false;

                        document.getElementById('hidschddays').value = '5';
                        
                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Jumat.

          <input type="checkbox"
              name="optsabtu" 
              id="optsabtu"
              value="true"
              onclick="if (checked == true) 
                    {
                        document.getElementById('optminggu').checked = false;
                        document.getElementById('optsenin').checked = false;
                        document.getElementById('optselasa').checked = false;
                        document.getElementById('optrabu').checked = false;
                        document.getElementById('optkamis').checked = false;
                        document.getElementById('optjumat').checked = false;

                        document.getElementById('hidschddays').value = '6';
                        
                        //var today = new Date();
                        //var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
                        
                        //document.getElementById('tmschdstart').value = time;
                        //document.getElementById('tmschdend').value = time; 

                    }                
                  ">
              Sabtu.

        <input name="hidschddays"
                id="hidschddays"
                type="hidden">

        <input name="hidxschddays"
                id="hidxschddays"
                type="hidden">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="tmschdstart">Dari :</label>
            <input type="time" name="tmschdstart" id="tmschdstart" >

            <input type="hidden" name="hidschdstart" id="hidschdstart" >            

            <label for="tmschdend">Sampai :</label>
            <input type="time" name="tmschdend" id="tmschdend" >

            <input type="hidden" name="hidschdend" id="hidschdend" >

          </div><!-- pure-control-group -->

          <div class="pure-control-group">
            <label for="txtschdnote">Keterangan Jadwal :</label>
            <input type="text" 
              name="txtschdnote" 
              id="txtschdnote" 
              maxlength ="100"
              style="width: 400px;">
              <input type="hidden" name="hidentrtime" id="hidentrtime"> 

       </div><!-- pure-control-group -->


      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
                  if (document.getElementById('hiddoctuser').value.length == 0 )
                                    {
                            swal({
                                title: 'Nama Dokter Kosong' ,
                                text: 'Anda belum memilih Nama Dokter, silah periksa lagi',
                                icon: 'warning',
                                });

                                        document.getElementById('txtdoctname').value = '';
                                        document.getElementById('txtdoctname').focus(); 
                                    }
                  else if (document.getElementById('hidmediroom').value.length == 0)
                                    {
                            swal({
                                title: 'Ruangan Poli Belum di Pilih' ,
                                text: 'Anda belum memilih Ruangan Poli, silah periksa lagi',
                                icon: 'warning',
                                });
                                    }
                  else if (document.getElementById('hidschddays').value.length == 0)
                                    {
                            swal({
                                title: 'Jadwal hari Kosong' ,
                                text: 'Anda belum Memilih Jadwal Hari Dokter, silah periksa lagi',
                                icon: 'warning',
                                });

                                    }
                  else
                    {
                       var indoctuser = document.getElementById('hiddoctuser').value;
                       var indoctname = document.getElementById('txtdoctname').value;
                       var inmediroom = document.getElementById('hidmediroom').value;
                       
                       var inschddays = document.getElementById('hidschddays').value;
                       var cekschddays =  document.getElementById('hidxschddays').value;

                       var inschdstart = document.getElementById('tmschdstart').value;
                       var cekschdstart = document.getElementById('hidschdstart').value;

                       var inschdend = document.getElementById('tmschdend').value;
                       var cekschdend = document.getElementById('hidschdend').value;
                       var inschdnote = document.getElementById('txtschdnote').value;
                       var inentrtime = document.getElementById('hidentrtime').value;
                       input(indoctuser,indoctname,inmediroom,inschddays,cekschddays,inschdstart,cekschdstart,inschdend,cekschdend,inschdnote,inentrtime);
                    }

        ">Submit</a>
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

          <div id="tbluser" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

        <fieldset>

          <div id="tblpoli" 
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
<script src="js/TRXAPATI04.js"></script>
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
