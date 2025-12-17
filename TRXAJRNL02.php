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
<title>Rollback</title>
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

              <li class="pure-menu-item" onclick="javascript: location.href = 'AUTOJRNL00.php'">
                <a class="pure-menu-link">Auto Jurnal</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
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


              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAJRNL01.php'">
                <a class="pure-menu-link">
                Input Jurnal
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Rollback
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAJRNL04.php'">
                <a class="pure-menu-link">
                Laporan
                </a>
              </li>


            </ul>
          </div>
    	<!-- Tab Menu -->
    <!-- Form Input -->
    <form name="frmtrxajrnl" class="pure-form pure-form-aligned" method="post" action="TRXAJRNL02U.php">

    <fieldset>

    <div class="pure-control-group">

      	<label for="txtjrnlcode">Transaction Code :</label>
      	<input type="text" 
            name="txtjrnlcode" 
            id="txtjrnlcode"
            autocomplete="off" 
            maxlength ="7"
            style="width: 90px;"
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
         		name="hidjrnlcode"
         		id="hidjrnlcode">

        <input type="hidden"
         		name="hidentrtime"
         		id="hidentrtime">

        <label for="tgljrnldate">Transaction Date :</label>
     	<input type="date" name="tgljrnldate" id="tgljrnldate" value="<?php echo $datenow; ?>" 
      onchange="document.getElementById('txtcoaccode').focus()">
      <div id="tbljrnl">	

    </div><!-- pure-control-group -->

    <div class="pure-control-group">

      <label for="txtcoaccode">Account Code :</label>
      <input type="text" name="txtcoaccode" id="txtcoaccode"
      maxlength="13" style="width: 130px"
      onkeyup="if (value.length > 0) 
              {
              ambilcoaccode(this.value);
              } 
            else 
              { 
               document.getElementById('tblcoac').style.visibility = 'hidden';
               document.getElementById('tblcoac').innerHTML = '';
              }"
        >
         <input type="hidden"
            name="hidcoaccode"
            id="hidcoaccode">

    </div><!-- pure-control-group -->

    <div class="pure-control-group">

      <label for="txtcoacname">Account Name :</label>
      <input type="text" name="txtcoacname" id="txtcoacname"
      maxlength="50" style="width: 500px" readonly="true">	

      <div id="tblcoac">

    </div><!-- pure-control-group -->

    <div class="pure-control-group">

      	<label for="txtjrnldebt">Debit :</label>
		    <input type="text" name="txtjrnldebt" id="txtjrnldebt"
                maxlength="10" style="width: 100px" value="0"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtjrnldebt').value = '0';
                                  document.getElementById('txtjrnldebt').focus();                          
                                }
                                else
                                {
                                  var inRupiah = convertToRupiah(this.value);
                                  document.getElementById('txtjrnldebt').value = inRupiah;
                                  document.getElementById('txtjrnlcrdt').focus();
                                }
                            }"
              onclick="if (isNaN(this.value)) 
                              {
                                var inAngka = convertToAngka(this.value);
                                document.getElementById('txtjrnldebt').value = inAngka
                                document.getElementById('txtjrnldebt').focus();
                              }

                            ">      	

      	<label for="txtjrnlcrdt">Credit :</label>
		    <input type="text" name="txtjrnlcrdt" id="txtjrnlcrdt"
                maxlength="10" style="width: 100px" value="0"

                onkeydown="if (event.keyCode == 13 && value.length > 0) 
                            {
                              if (isNaN(this.value)) 
                                {
                                  document.getElementById('txtjrnlcrdt').value = '0';
                                  document.getElementById('txtjrnlcrdt').focus();                          
                                }
                                else
                                {
                                  var inRupiah = convertToRupiah(this.value);
                                  document.getElementById('txtjrnlcrdt').value = inRupiah;
                                  document.getElementById('txtdiviname').focus();
                                }
                            }"
              onclick="if (isNaN(this.value)) 
                              {
                                var inAngka = convertToAngka(this.value);
                                document.getElementById('txtjrnlcrdt').value = inAngka
                                document.getElementById('txtjrnlcrdt').focus();
                              }

                            ">        
    </div><!-- pure-control-group -->

    <div class="pure-control-group">

      	<label for="txtdiviname">Divisi :</label>
      	<input type="text" name="txtdiviname" id="txtdiviname"
      			maxlength="50" style="width: 500px"
      			onkeyup="if (value.length > 0) 
              	{
              		ambildivicode(this.value);
              	} 
            	else 
              	{ 
               		document.getElementById('tbldivi').style.visibility = 'hidden';
                  document.getElementById('tbldivi').innerHTML = '';
              	}">
        <input type="hidden" name="hiddivicode" id="hiddivicode">
        <div id="tbldivi">

    </div><!-- pure-control-group -->

    <div class="pure-control-group">

        <label for="txtjrnlnote">Notes :</label>
        <input type="text" name="txtjrnlnote" id="txtjrnlnote"
                maxlength="100" style="width: 500px">
    </div><!-- pure-control-group -->

      </fieldset>

      <fieldset>
        <!-- Update Data Transaksi -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('txtjrnlcode').value.length > 4) 
        {

                              var injrnlcode = document.getElementById('hidjrnlcode').value;
                              var injrnldate = document.getElementById('tgljrnldate').value;
                              var incoaccode = document.getElementById('txtcoaccode').value;
                              var oldcoaccode = document.getElementById('hidcoaccode').value;
                              var incoacname = document.getElementById('txtcoacname').value;
                              var injrnldebt = document.getElementById('txtjrnldebt').value;
                              var injrnlcrdt = document.getElementById('txtjrnlcrdt').value;
                              var indivicode = document.getElementById('hiddivicode').value;
                              var indiviname = document.getElementById('txtdiviname').value;
                              var injrnlnote = document.getElementById('txtjrnlnote').value;
                              var inentrtime = document.getElementById('hidentrtime').value;
Update(injrnlcode,injrnldate, oldcoaccode, incoaccode, incoacname,injrnldebt,injrnlcrdt,indivicode,indiviname,injrnlnote,inentrtime);


        }
        else
        {
                document.getElementById('txtcoaccode').focus();          
        }
        ">Update</a>
        <!-- Tambah Data Transaksi -->
        <a class="pure-button button-update" 
        onclick="javascript: if (document.getElementById('txtjrnlcode').value.length > 4) 
        {

                              var injrnlcode = document.getElementById('hidjrnlcode').value;

                              var injrnldate = document.getElementById('tgljrnldate').value;
                              var incoaccode = document.getElementById('txtcoaccode').value;
                              var oldcoaccode = document.getElementById('hidcoaccode').value;

                              var incoacname = document.getElementById('txtcoacname').value;
                              var injrnldebt = document.getElementById('txtjrnldebt').value;
                              var injrnlcrdt = document.getElementById('txtjrnlcrdt').value;
                              var indivicode = document.getElementById('hiddivicode').value;
                              var indiviname = document.getElementById('txtdiviname').value;
                              var injrnlnote = document.getElementById('txtjrnlnote').value;
Insert(injrnlcode,injrnldate, incoaccode, incoacname,injrnldebt,injrnlcrdt,indivicode,indiviname,injrnlnote);
        }
        else
        {
                document.getElementById('txtcoaccode').focus();          
        }
        ">Insert</a>

        <!-- Hapus Data Transaksi -->
  <?php
  // Periksa Akses Delete dimulai
  if ($user !="$idadmin")
    {
      $query_akses_delete = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN = '$user' AND PASS_TRXA_ENTR = 'Y'";
      $qakses_delete = $db->query($query_akses_delete) or die("Gagal Ambil Nilai Akses!!");
      $row_delete = $qakses_delete->fetchColumn();

      if ($row_delete == 0)
      {      
        echo '<a class="pure-button pure-button-disabled" href="#">Delete</a>';
      }
      else
      {
      ?>
          <a class="pure-button button-delete" 
            onclick="javascript: if (document.getElementById('txtjrnlcode').value.length > 4) 
            {
                var injrnlcode = document.getElementById('hidjrnlcode').value;
                var oldcoaccode = document.getElementById('hidcoaccode').value;
                var inentrtime = document.getElementById('hidentrtime').value;
				Delete(injrnlcode,oldcoaccode, inentrtime);
        	}
        	else
        	{
                document.getElementById('txtcoaccode').focus();          
        	}
        	">Delete</a>

     <?php 
      }
  	}
  	else
  	{
      ?>
          <a class="pure-button button-delete" 
            onclick="javascript: if (document.getElementById('txtjrnlcode').value.length > 4) 
            {
                var injrnlcode = document.getElementById('hidjrnlcode').value;
                var oldcoaccode = document.getElementById('hidcoaccode').value;
                var inentrtime = document.getElementById('hidentrtime').value;
				Delete(injrnlcode,oldcoaccode, inentrtime);
        	}
        	else
        	{
                document.getElementById('txtcoaccode').focus();          
        	}
        	">Delete</a>

     <?php 
  		
  	}
  // Periksa Akses selesai  
  ?>        <!-- Hapus Data Transaksi -->
                        <div id="tbltrxascreen">                
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
<script src="js/TRXAJRNL02.js"></script>
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
