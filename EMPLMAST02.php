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
<title>Update Employment</title>
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

<body onLoad="periksaakses('PASS_EMPL_ENTR');
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
                <a class="pure-menu-link">PERSONIL</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TBLEPOST00.php'">
                <a class="pure-menu-link">Data Pendukung</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'EMPLPAYR00.php'">
                <a class="pure-menu-link">Payroll</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST01.php'">
              	<a class="pure-menu-link">
                Register Karyawan
            	</a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Update Karyawan
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST03.php'">
                <a class="pure-menu-link">
                Resign Karyawan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST04.php'">
                <a class="pure-menu-link">
                Lihat Karyawan
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST05.php'">
                <a class="pure-menu-link">
                Jenjang Karir
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST06.php'">
                <a class="pure-menu-link">
                Mutasi
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'EMPLMAST07.php'">
                <a class="pure-menu-link">
                Surat Peringatan
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmemplmast" class="pure-form pure-form-aligned" method="post" action="EMPLMAST02U.php">

    	<fieldset> <legend>Biodata</legend>

        <div class="pure-control-group">

    		<label for="txtsearch">Cari :</label>
      			<input type="text" name="txtsearch" id="txtsearch" maxlength ="7"
              			autocomplete="off" style="width: 90px;"

             onkeyup="if (value.length > 0) 
              { ambilemplmastcode(this.value); } 
            else 
              { document.getElementById('tblempl').style.visibility = 'hidden'; }">
      	</div> <!-- pure-control-group -->    		

        <div class="pure-control-group">

    		<label for="txtmastcode">ID Karyawan :</label>
      			<input type="text" 
             	name="txtmastcode" 
             	id="txtmastcode" 
             	maxlength ="7"
             	style="width: 90px;"
             	readonly="true"> 

    		<label for="txtfrstname">Nama Depan :</label>
      			<input type="text" 
             	name="txtfrstname" 
             	id="txtfrstname" 
             	maxlength ="30"
             	style="width: 200px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtlastname').focus()">

    		<label for="txtlastname">Nama Belakang :</label>
      			<input type="text" 
             	name="txtlastname" 
             	id="txtlastname" 
             	maxlength ="20"
             	style="width: 200px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('optmale').focus()">

    	 </div><!-- pure-control-group -->

      	<div class="pure-control-group">

	      <label>L/P :</label>

	      <input type="checkbox"
	            name="optmale" 
	            id="optmale"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optfemale').checked = false;
	                      document.getElementById('hidmaingend').value = 'M';
	                  }                
	                ">
	            Laki Laki.
	      <input type="checkbox"
	            name="optfemale" 
	            id="optfemale"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optmale').checked = false;
	                      document.getElementById('hidmaingend').value = 'F';
	                  }                
	                ">
	            Perempuan.
	      <input name="hidmaingend"
	              id="hidmaingend"
	              type="hidden">

        <label for="tglmainbirt">Tanggal Lahir :</label>
          <input type="date" name="tglmainbirt" id="tglmainbirt" value="<?php echo $datenow; ?>">

      	</div><!-- pure-control-group -->


    	<div class="pure-control-group">


	      <label>Gol. Darah :</label>

	      <input type="checkbox"
	            name="optblooda" 
	            id="optblooda"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optbloodb').checked = false;
	                      document.getElementById('optbloodab').checked = false;
	                      document.getElementById('optbloodo').checked = false;
	                      document.getElementById('hidmainblod').value = 'A';
	                  }                
	                ">
	            [A]
	      <input type="checkbox"
	            name="optbloodb" 
	            id="optbloodb"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optblooda').checked = false;
	                      document.getElementById('optbloodab').checked = false;
	                      document.getElementById('optbloodo').checked = false;
	                      document.getElementById('hidmainblod').value = 'B';
	                  }                
	                ">
	            [B]
	      <input type="checkbox"
	            name="optbloodab" 
	            id="optbloodab"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optblooda').checked = false;
	                      document.getElementById('optbloodb').checked = false;
	                      document.getElementById('optbloodo').checked = false;
	                      document.getElementById('hidmainblod').value = 'AB';
	                  }                
	                ">
	            [AB]
	      <input type="checkbox"
	            name="optbloodo" 
	            id="optbloodo"
	            value="true"
	            onclick="if (checked == true) 
	                  {
	                      document.getElementById('optblooda').checked = false;
	                      document.getElementById('optbloodb').checked = false;
	                      document.getElementById('optbloodab').checked = false;
	                      document.getElementById('hidmainblod').value = 'O';
	                  }                
	                ">
	            [O]

	      <input name="hidmainblod"
	              id="hidmainblod"
	              type="hidden">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

			   <label for="txtfngrcode">ID Absen :</label>
      			<input type="text" 
             	name="txtfngrcode" 
             	id="txtfngrcode" 
             	maxlength ="3"
              value="0" 
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0)
             	{
             		if (isNaN(this.value)) 
             			{ 
             				document.getElementById('txtfngrcode').value = '0'; 
             				document.getElementById('txtfngrcode').focus(); 
             			}
             		else { document.getElementById('txtmaintidn1').focus(); }
             	}">        	


    		<label for="txtmaintidn1">NPWP :</label>
      			<input type="text" 
             	name="txtmaintidn1" 
             	id="txtmaintidn1" 
             	maxlength ="2"
             	style="width: 50px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 2) document.getElementById('txtmaintidn2').focus()">
			       .
      			<input type="text" 
             	name="txtmaintidn2" 
             	id="txtmaintidn2" 
             	maxlength ="3"
             	style="width: 60px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn3').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn3" 
             	id="txtmaintidn3" 
             	maxlength ="3"
             	style="width: 60px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn4').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn4" 
             	id="txtmaintidn4" 
             	maxlength ="1"
             	style="width: 40px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 1) document.getElementById('txtmaintidn5').focus()">        	
			       -
      			<input type="text" 
             	name="txtmaintidn5" 
             	id="txtmaintidn5" 
             	maxlength ="3"
             	style="width: 60px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('txtmaintidn6').focus()">        	
			       .
      			<input type="text" 
             	name="txtmaintidn6" 
             	id="txtmaintidn6" 
             	maxlength ="3"
             	style="width: 60px;"
             	onkeydown="if (event.keyCode == 13 && value.length == 3) document.getElementById('optmainstat').focus()">        	

        </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="optmainstat">Status :</label>
							<select name="optmainstat" id="optmainstat" onchange="document.getElementById('txtmktpaddr').focus();">
                <option value="TK0">Lajang</option>
                <option value="TK1">Lajang 1 Anak</option>
                <option value="TK2">Lajang 2 Anak</option>
                <option value="TK3">Lajang 3 Anak</option>
                <option value="K0">Menikah</option>
                <option value="K1">Menikah 1 Anak</option>
                <option value="K2">Menikah 2 Anak</option>
                <option value="K3">Menikah 3 Anak</option>
							</select>

      </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmktpaddr">Alamat :</label>
      			<input type="text" 
             	name="txtmktpaddr" 
             	id="txtmktpaddr" 
             	maxlength ="50"
             	style="width: 400px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmktpcity').focus()">

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

    		<label for="txtmktpcity">Kota :</label>
      			<input type="text" 
             	name="txtmktpcity" 
             	id="txtmktpcity" 
             	maxlength ="20"
             	style="width: 200px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmktpprov').focus()">

    		<label for="txtmktpprov">Provinsi :</label>
      			<input type="text" 
             	name="txtmktpprov" 
             	id="txtmktpprov" 
             	maxlength ="20"
             	style="width: 200px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmktpctry').focus()">
    		
    		<label for="txtmktpctry">Negara :</label>
      			<input type="text" 
             	name="txtmktpctry" 
             	id="txtmktpctry" 
             	value="Indonesia" 
             	maxlength ="10"
             	style="width: 100px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainhp01').focus()">
    		
    	 </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmainhp01">Nomor Kontak 1:</label>
      			<input type="text" 
             	name="txtmainhp01" 
             	id="txtmainhp01" 
             	maxlength ="18"
             	style="width: 180px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainhp02').focus()">

    		<label for="txtmainhp02">Nomor Kontak 2 :</label>
      			<input type="text" 
             	name="txtmainhp02" 
             	id="txtmainhp02" 
             	maxlength ="18"
             	style="width: 180px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainmail').focus()">
    		
    	 </div><!-- pure-control-group -->

    	 <div class="pure-control-group">

    		<label for="txtmainmail">E-Mail :</label>
      			<input type="text" 
             	name="txtmainmail" 
             	id="txtmainmail"
             	placeholder="user@domain.com" 
             	maxlength ="30"
             	style="width: 300px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('opthigheduc').focus()">

       </div><!-- pure-control-group -->

   </fieldset><!-- Mortem -->

   <fieldset><legend>Pendidikan</legend>

      <div class="pure-control-group">

      <label for="opthigheduc">Pendidikan Terakhir :</label>
							<select name="opthigheduc" id="opthigheduc" onchange="document.getElementById('txtlastschl').focus();">
								<option value="S1">Strata 1</option>
								<option value="S2">Strata 2</option>
								<option value="S3">Strata 3</option>
								<option value="D1">Diploma 1</option>
								<option value="D2">Diploma 2</option>
								<option value="D3">Diploma 3</option>
								<option value="SMK">Sekolah Menengah Kejuruan</option>
								<option value="SMP">Sekolah Menengah Pertama</option>
								<option value="SD">Sekolah Dasar</option>
							</select>

    	<label for="txtlastschl">Lulusan Sekolah :</label>
      			<input type="text" 
             	name="txtlastschl" 
             	id="txtlastschl" 
             	maxlength ="50"
             	style="width: 500px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('optdocustat').focus()">

      </div><!-- pure-control-group -->

        <div class="pure-control-group">

        	<label for="optdocustat">Jaminan Ijazah/STR :</label>
      		<input type="checkbox"
            name="optdocustat" 
            id="optdocustat"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('hiddocustat').value = 'Y';
                  }   
                ">
      		<input name="hiddocustat"
              id="hiddocustat"
              type="hidden">

        </div><!-- pure-control-group -->

       <div class="pure-control-group">

    		<label for="txtmainhobi">Hobi :</label>
      			<input type="text" 
             	name="txtmainhobi" 
             	id="txtmainhobi" 
             	maxlength ="50"
             	style="width: 300px;"
             	onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('tglhiredate').focus()">

        </div><!-- pure-control-group -->

    </fieldset><!-- Education -->

    <fieldset><legend>Personalia</legend>

        <div class="pure-control-group">

        	<label for="tglhiredate">Tanggal Rekrut :</label>
          	<input type="date" name="tglhiredate" id="tglhiredate" value="<?php echo $datenow; ?>"
                  onchange="document.getElementById('tglactidate').focus()">

        	<label for="tglactidate">Mulai Bekerja :</label>
          	<input type="date" name="tglactidate" id="tglactidate" value="<?php echo $datenow; ?>"
                  onchange="document.getElementById('txtmaindivi').focus()">

        </div><!-- pure-control-group -->



        <div class="pure-control-group">

        	<label for="txtmaindivi">Divisi :</label>
            	<input type="text" 
                  name="txtmaindivi" 
                  id="txtmaindivi"
              		autocomplete="off" 
                  maxlength ="100"
                  style="width: 200px;"
                        onkeyup="if (value.length > 0) 
                        {
                        ambildivicode(this.value);
                        } 
                        else 
                        { 
                        document.getElementById('tbldivi').style.visibility = 'hidden';
                        }"
                        >
                  <input type="hidden" name="hidmaindivi" id="hidmaindivi">

                  <label for="txtmainpstn">Jabatan :</label>
                        <input type="text" 
                  name="txtmainpstn" 
                  id="txtmainpstn"
              		autocomplete="off" 
                  maxlength ="100"
                  style="width: 200px;"
                        onkeyup="if (value.length > 0) 
                        {
                        ambilpstncode(this.value);
                        } 
                        else 
                        { 
                        document.getElementById('tblpstn').style.visibility = 'hidden';
                        }"
                        >
                  <input type="hidden" name="hidmainpstn" id="hidmainpstn">
            
        </div><!-- pure-control-group -->

    </fieldset><!-- Personalia -->

    <fieldset><legend>Payroll</legend>
        <div class="pure-control-group">

			<label for="txtbankname">Bank :</label>
      			<input type="text" 
             	name="txtbankname" 
             	id="txtbankname"
              autocomplete="off" 
             	maxlength ="60"
             	style="width: 200px;"
      			onkeyup="if (value.length > 0) 
              		{
              		ambilbankcode(this.value);
              		} 
            		else 
              		{ 
               		document.getElementById('tblbank').style.visibility = 'hidden';
              		}"
        			>
        		<input type="hidden" name="hidbankcode" id="hidbankcode">        		

        </div><!-- pure-control-group -->

        <div class="pure-control-group">

            <label for="txtbankacct">No. Rekening :</label>
            <input type="text" 
                  name="txtbankacct" 
                  id="txtbankacct" 
                  maxlength ="20"
              value="0" 
                  style="width: 200px;"
                  onkeydown="if (event.keyCode == 13 && value.length > 0)
                  {
                        if (isNaN(this.value)) 
                              { 
                                    document.getElementById('txtbankacct').value = '0'; 
                                    document.getElementById('txtbankacct').focus(); 
                              }
                        else { document.getElementById('txtbankpers').focus(); }
                  }">         

            <label for="txtbankpers">A/N Rekening :</label>
            <input type="text" 
                  name="txtbankpers" 
                  id="txtbankpers" 
                  maxlength ="50"
                  style="width: 300px;"
                  onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtbankpers').focus()">
            
        </div><!-- pure-control-group -->

        </fieldset><!-- Payroll -->

        <fieldset>
        	    <a class="pure-button button-update" 
             	onclick="javascript: if (document.getElementById('txtmastcode').value.length == 0 )
                                    {
                                    swal({
                                        title: 'Nomor ID Kosong' ,
                                        text: 'Nomor ID tidak ditemukan',
                                        icon: 'warning',
                                        });
                                    }
                                    else
                                    {
                                        document.frmemplmast.submit();  
                                    }
        ">Submit</a>

        </fieldset>

        <fieldset>
          <div id="tblemplmast"                
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

        <fieldset>
          <div id="tblempl"                
          style="position: absolute; 
                 top: 400px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">


        </fieldset>
        <fieldset>

          <div id="tbldivi" 
          style="position: absolute; 
                 top: 600px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

        <fieldset>

          <div id="tblpstn" 
          style="position: absolute; 
                 top: 600px;
                 left: calc(70% - 150px);
                 background-color: white; 
                 visibility: hidden; 
                 z-index: 100">

        </fieldset>

        <fieldset>
          <div id="tblbank" 
          style="position: absolute; 
                 top: 600px;
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
<script src="js/EMPLMAST02.js"></script>
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
