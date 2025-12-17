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
<title>WareHouse</title>
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
  .button-view {
      background: rgb(28, 184, 65);
            /* this is an green */
        }

  .button-delete {
            background: rgb(202, 60, 60);
            /* this is an maroon */
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

<body onLoad="periksaakses('PASS_WARE_HOUS');
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
                <a class="pure-menu-link">PERSEDIAAN</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLIUNIT00.php'">
                <a class="pure-menu-link">Spesifikasi Item</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'INVEMAST00.php'">
                <a class="pure-menu-link">Master Item</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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
            <h2>SISKA</h2>
        </div><!-- div header -->
        <div class="headerlogo">
        </div>

		<div class="content">

        <!-- Tab Menu -->
          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'FIXELOCA01.php'">
                <a class="pure-menu-link">
                Lokasi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Ware House
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmwaremast" class="pure-form pure-form-aligned" method="post" action="">
    	<fieldset>

      		<div class="pure-control-group">

        		<label for="txthouscode">ID Warehouse :</label>
              	<input type="text" 
            	  	name="txthouscode" 
              		id="txthouscode" 
              		maxlength ="4"
              		style="width: 80px;"
                  onkeyup="var start = this.selectionStart;
                          var end = this.selectionEnd;
                          this.value = this.value.toUpperCase();
                          this.setSelectionRange(start, end);
                          if (value.length > 3) 
                            {
                              periksaid(this.value);
                            }
                          else
                          {
                              document.getElementById('txthousname').setAttribute('disabled','true');
                              document.getElementById('txtlocaname').setAttribute('disabled','true');
                              document.getElementById('txtmediroom').setAttribute('disabled','true');

                              document.getElementById('optnormal').setAttribute('disabled','true');
                              document.getElementById('optreject').setAttribute('disabled','true');
                              document.getElementById('txtemplname').setAttribute('disabled','true');
                              document.getElementById('txthousnote').setAttribute('disabled','true');
                          }  
                          "
                onkeydown="if (event.keyCode == 13 && value.length > 3) document.getElementById('txthousname').focus()">

            </div><!-- pure-control-group --> 

      		<div class="pure-control-group">

        		<label for="txthousname">Nama Warehouse :</label>
              <input type="text" 
              name="txthousname" 
              id="txthousname" 
              maxlength ="50" 
              style="width: 500px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0 )
                        {
                              document.getElementById('txtlocaname').focus();
                        }
            ">

            </div><!-- pure-control-group --> 

      		<div class="pure-control-group">

            <label for="txtlocaname">Lokasi :</label>
                  <input type="text" 
                  name="txtlocaname" 
                  id="txtlocaname"
                  autocomplete="off" 
                  maxlength ="50" 
                  style="width: 500px;"
                  onkeyup="if (value.length > 0) 
                      {
                      ambillocacode(this.value);
                      } 
                    else 
                      { 
                      document.getElementById('tblloca').style.visibility = 'hidden';
                      }"
                  >

            <input type="hidden" name="hidlocacode" id="hidlocacode">

            </div><!-- pure-control-group --> 

          <div class="pure-control-group">

            <label for="txtmediroom">Ruang Poli :</label>
                  <input type="text" 
                  name="txtmediroom" 
                  id="txtmediroom"
                  autocomplete="off" 
                  maxlength ="50" 
                  style="width: 300px;"
                  onkeyup="if (value.length > 0) 
                      {
                      ambilpolicode(this.value);
                      } 
                    else 
                      { 
                      document.getElementById('tblloca').style.visibility = 'hidden';
                      }"
                  >

            <input type="hidden" name="hidmediroom" id="hidmediroom">

            </div><!-- pure-control-group --> 

      		<div class="pure-control-group">
      			<label>Tipe Warehouse :</label>

	            <input type="checkbox"
	            name="optnormal" 
	            id="optnormal"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optreject').checked = false;
                        document.getElementById('hidhoustype').value = 'N';
	                      document.getElementById('txtemplcode').focus(); 
	                  }                
	                ">
	            Normal.

	            <input type="checkbox"
	            name="optreject" 
	            id="optreject"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optnormal').checked = false;
                        document.getElementById('hidhoustype').value = 'R';
	                      document.getElementById('txtemplcode').focus(); 
	                  }                
	                ">
	            Reject.

	         <input type="hidden"
	                name="hidhoustype"
	                id="hidhoustype">   
            </div><!-- pure-control-group --> 

      		<div class="pure-control-group">

        <label for="txtemplcode">Staff In Charge :</label>
              <input type="text" 
              name="txtemplname" 
              id="txtemplname" 
              autocomplete="off" 
              maxlength ="20" 
              style="width: 200px;"
              onkeyup="if (value.length > 0) 
                  {
                  ambilemplcode(this.value);
                  } 
                else 
                  { 
                  document.getElementById('tblempl').style.visibility = 'hidden';
                  }"
              >
              <input type="hidden" name="hidemplcode" id="hidemplcode">
            </div><!-- pure-control-group --> 
      
      		<div class="pure-control-group">

        <label for="txthousnote">Notes :</label>
              <input type="text" 
              name="txthousnote" 
              id="txthousnote" 
              maxlength ="100" 
              style="width: 600px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0 )
                        {
                          if (document.getElementById('txthouscode').value == '')
                          {
                            swal({
                                title: 'Kode Gudang Kosong' ,
                                text: 'Anda belum mengisi Kode Gudang, silah periksa lagi',
                                icon: 'warning',
                                });
                            document.getElementById('txthouscode').value = '';
                            document.getElementById('txthouscode').focus();
                          }
                          else if (document.getElementById('txthousname').value == '')
                          {
                              swal({
                                  title: 'Nama Gudang Kosong' ,
                                  text: 'Anda belum mengisi Nama Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txthousname').value = '';
                              document.getElementById('txthousname').focus();
                          }
                          else if (document.getElementById('hidlocacode').value == '')
                          {
                              swal({
                                  title: 'Lokasi Kosong' ,
                                  text: 'Anda belum mengisi Lokasi, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txtlocaname').value = '';
                              document.getElementById('txtemplname').focus();
                          }

                          else if (document.getElementById('hidhoustype').value == '')
                          {
                              swal({
                                  title: 'Type Gudang Belum dipilih' ,
                                  text: 'Anda belum memilih Tipe Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('optnormal').checked = false;
                              document.getElementById('optreject').checked = false;
                          }
                          else if (document.getElementById('hidemplcode').value == '')
                          {
                              swal({
                                  title: 'Nama Staff Kosong' ,
                                  text: 'Anda belum mengisi Nama Staff Lokasi, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txtemplname').value = '';
                              document.getElementById('txtemplname').focus();
                          }
                          else if (document.getElementById('txthousnote').value == '')
                          {
                              swal({
                                  title: 'Keterangan Gudang Kosong' ,
                                  text: 'Anda belum mengisi Keterangan Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txthousnote').value = '';
                              document.getElementById('txthousnote').focus();
                          }

                           else
                           {
                               var inhouscode = document.getElementById('txthouscode').value;
                               var inhousname = document.getElementById('txthousname').value;
                               var inhousloca = document.getElementById('hidlocacode').value;
                               var inmediroom = document.getElementById('hidmediroom').value

                               var inhoustype = document.getElementById('hidhoustype').value;
                               var inemplcode = document.getElementById('hidemplcode').value;
                               var inhousnote = document.getElementById('txthousnote').value;
                               input(inhouscode,inhousname,inhousloca,inmediroom,inhoustype,inemplcode,inhousnote);
                            }
                          }
            ">

            </div><!-- pure-control-group --> 
      </fieldset>
      <fieldset>
          <a class="pure-button pure-button-primary" onclick="javascript:
      if (document.getElementById('txthousnote').value.length > 0)
                        {
                          if (document.getElementById('txthouscode').value == '')
                          {
                            swal({
                                title: 'Kode Gudang Kosong' ,
                                text: 'Anda belum mengisi Kode Gudang, silah periksa lagi',
                                icon: 'warning',
                                });
                            document.getElementById('txthouscode').value = '';
                            document.getElementById('txthouscode').focus();
                          }
                          else if (document.getElementById('txthousname').value == '')
                          {
                              swal({
                                  title: 'Nama Gudang Kosong' ,
                                  text: 'Anda belum mengisi Nama Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txthousname').value = '';
                              document.getElementById('txthousname').focus();
                          }
                          else if (document.getElementById('hidlocacode').value == '')
                          {
                              swal({
                                  title: 'Lokasi Kosong' ,
                                  text: 'Anda belum mengisi Lokasi, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txtlocaname').value = '';
                              document.getElementById('txtemplname').focus();
                          }

                          else if (document.getElementById('hidhoustype').value == '')
                          {
                              swal({
                                  title: 'Type Gudang Belum dipilih' ,
                                  text: 'Anda belum memilih Tipe Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('optnormal').checked = false;
                              document.getElementById('optreject').checked = false;
                          }
                          else if (document.getElementById('hidemplcode').value == '')
                          {
                              swal({
                                  title: 'Nama Staff Kosong' ,
                                  text: 'Anda belum mengisi Nama Staff Lokasi, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txtemplname').value = '';
                              document.getElementById('txtemplname').focus();
                          }
                          else if (document.getElementById('txthousnote').value == '')
                          {
                              swal({
                                  title: 'Keterangan Gudang Kosong' ,
                                  text: 'Anda belum mengisi Keterangan Gudang, silah periksa lagi',
                                  icon: 'warning',
                                  });
                              document.getElementById('txthousnote').value = '';
                              document.getElementById('txthousnote').focus();
                          }

                           else
                           {
                               var inhouscode = document.getElementById('txthouscode').value;
                               var inhousname = document.getElementById('txthousname').value;
                               var inhousloca = document.getElementById('hidlocacode').value;
                               var inmediroom = document.getElementById('hidmediroom').value

                               var inhoustype = document.getElementById('hidhoustype').value;
                               var inemplcode = document.getElementById('hidemplcode').value;
                               var inhousnote = document.getElementById('txthousnote').value;
                               input(inhouscode,inhousname,inhousloca,inmediroom,inhoustype,inemplcode,inhousnote);
                            }
                          }
            
        ">Submit</a>
        </fieldset>

        <fieldset>
                <div id="tblloca" 
              style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 300px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
        </fieldset>

        <fieldset>
                <div id="tblempl" 
          style="position: absolute; 
                 top: 200px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">
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
<script src="js/WAREMAST01.js"></script>
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
