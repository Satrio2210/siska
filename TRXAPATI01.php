<!doctype html>
<?php include "conf/config.php";
//memulai session
session_start();

//cek adanya session
if (isset($_SESSION['username'])) {
	$user = $_SESSION['username'];

	?>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Sistem Informasi Klinik Pratama">
		<title>Daftar Pasien</title>
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

			input[type="date"] {
				color: #ff0000; /* Ganti kode #ff0000 dengan warna hex yang lu mau (ini merah) */
			}
		</style>
	</head>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/sanie.js"></script>
	<script src="js/sweetalert.min.js"></script>

	<script>
		$(document).ready(function () {
			setInterval(timestamp, 1000);
		});
		function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function (data) { $('#timestamp').html(data); }, }); }
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

					<a class="pure-menu-heading" href="#"><?php echo $_SESSION['username']; ?></a>
					<ul class="pure-menu-list">

						<li class="pure-menu-item menu-item-divided pure-menu-selected"
							onclick="javascript: location.href = 'index.php'">
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
					<img align="right" height="<?php echo $width_logo; ?>" width="<?php echo $height_logo; ?>"
						src="img/logo.png" alt="">

					<h1 id="login">Sistem Informasi Klinik Pratama</h1>
					<h2>SISKA</h2>
				</div><!-- div header -->

				<div class="content">
					<!-- Tab Menu -->
					<div class="pure-menu pure-menu-horizontal">
						<ul class="pure-menu-list">

							<li class="pure-menu-item pure-menu-disabled">
								Daftar Pasien
							</li>

							<li class="pure-menu-item pure-menu-selected"
								onclick="javascript: location.href = 'TRXAPATI02.php'">
								<a class="pure-menu-link">
									Pasien Berobat
								</a>
							</li>

							<li class="pure-menu-item pure-menu-selected"
								onclick="javascript: location.href = 'TRXAPATI07.php'">
								<a class="pure-menu-link">
									TTV & Antropometri
								</a>
							</li>

							<!-- <li class="pure-menu-item pure-menu-selected"
								onclick="javascript: location.href = 'TRXAPATI03.php'">
								<a class="pure-menu-link">
									Ruangan
								</a>
							</li>

							<li class="pure-menu-item pure-menu-selected"
								onclick="javascript: location.href = 'TRXAPATI04.php'">
								<a class="pure-menu-link">
									Jadwal Dokter
								</a>
							</li>						 -->
						</ul>
					</div>
					<!-- Tab Menu -->
					<!-- Form Input -->
					<form name="frmtrxapati" class="pure-form pure-form-aligned" method="post" action="TRXAPATI01E.php">
						<fieldset>

							<div class="pure-control-group">
								<p><span style="color:red;">**Cari pasien dengan Nama Lengkap / Tanggal Lahir (Tahun-Bulan-Tanggal)</span></p>
								<label for="txtsearch">Cari Pasien :</label>
								<input type="text" name="txtsearch" id="txtsearch" maxlength="50" style="width: 200px;"
									onkeyup="if (value.length <= 25) 
				  {
					ambilpaticode(this.value);
				  } 
				  else 
				  { 
					document.getElementById('tblpati');
				  }">

							</div><!-- pure-control-group -->


							<div class="pure-control-group">

								<label for="txtmastcode">Nomor Rekam Medis :</label>
								<input type="text" name="txtmastcode" id="txtmastcode" maxlength="10" style="width: 120px;"
									readonly="true">

								<label for="txtmainpidn">NIK :</label>
								<input type="text" name="txtmainpidn" id="txtmainpidn" maxlength="16" style="width: 200px;"
									autocomplete="off" onblur="periksanik(this.value)" onkeyup="if (value.length > 12) 
				 {
					 let inmastcode = value.substr(8,4); 
					 document.getElementById('txtmastcode').value = inmastcode;
					 periksanomor('1');
				 } " onkeydown="if (event.keyCode == 13 && value.length == 16)
				 {
					 periksanik(value);
					 document.getElementById('opttn').removeAttribute('disabled','true');
					  document.getElementById('optny').removeAttribute('disabled','true');
				document.getElementById('optnn').removeAttribute('disabled','true');
					  document.getElementById('optan').removeAttribute('disabled','true');

					  document.getElementById('txtmainname').removeAttribute('disabled','true');

					  document.getElementById('optmale').removeAttribute('disabled','true');
					  document.getElementById('optfemale').removeAttribute('disabled','true');

					  let indaybirt = value.substr(6,2);
					  let inmonthbirt = value.substr(8,2);
					  let inyear = value.substr(10,2);
					  let inyearbirt = '19'+inyear;
					  let rawdate = inyearbirt+'-'+inmonthbirt+'-'+indaybirt;
					  var birtdate = new Date(rawdate);
					  var inmainbirt = convertDate(birtdate);

					  document.getElementById('tglmainbirt').removeAttribute('disabled','true');
					  document.getElementById('tglmainbirt').value = inmainbirt; 
				//periksatanggal(inmainbirt);

					  document.getElementById('optblooda').removeAttribute('disabled','true');
					  document.getElementById('optbloodb').removeAttribute('disabled','true');
					  document.getElementById('optbloodab').removeAttribute('disabled','true');
					  document.getElementById('optbloodo').removeAttribute('disabled','true');
					  document.getElementById('optbloodx').removeAttribute('disabled','true');

					document.getElementById('txtmainaddr').removeAttribute('disabled','true');
					document.getElementById('txtmainward').removeAttribute('disabled','true');
					document.getElementById('txtmaindist').removeAttribute('disabled','true');
					document.getElementById('txtmaincity').removeAttribute('disabled','true');
					document.getElementById('txtmainprov').removeAttribute('disabled','true');
					document.getElementById('txtmainreli').removeAttribute('disabled','true');

					document.getElementById('optwni').removeAttribute('disabled','true');
					document.getElementById('optwna').removeAttribute('disabled','true');

					  document.getElementById('optmainstat').removeAttribute('disabled','true');
					  document.getElementById('txtmainprof').removeAttribute('disabled','true');

					  document.getElementById('optmaineduc').removeAttribute('disabled','true');

					  document.getElementById('txtmainphne').removeAttribute('disabled','true');
		  
					  document.getElementById('txtmainmail').removeAttribute('disabled','true');

					   document.getElementById('txtmainprnt').removeAttribute('disabled','true');

					 document.getElementById('opttn').focus();	
				 } 
				 
				 ">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmainname">Nama Pasien :</label>

								<input type="checkbox" name="opttn" id="opttn" value="true" onclick="if (checked == true) 
					  {
						document.getElementById('optny').checked = false;
					  document.getElementById('optnn').checked = false;
						document.getElementById('optan').checked = false;
						document.getElementById('hidmaintitl').value = 'Tn.';
						document.getElementById('txtmainname').focus();
					  }                
					">
								Tuan.
								<input type="checkbox" name="optny" id="optny" value="true" onclick="if (checked == true) 
					  {
						document.getElementById('opttn').checked = false;
						document.getElementById('optnn').checked = false;
						document.getElementById('optan').checked = false;
						document.getElementById('hidmaintitl').value = 'Ny.';
						document.getElementById('txtmainname').focus();
					  }                
					">
								Nyonya.
								<input type="checkbox" name="optnn" id="optnn" value="true" onclick="if (checked == true) 
					{
						document.getElementById('opttn').checked = false;
						document.getElementById('optny').checked = false;
						document.getElementById('optan').checked = false;
						document.getElementById('hidmaintitl').value = 'Nn.';
						document.getElementById('txtmainname').focus();
					}                
				  ">
								Nona.

								<input type="checkbox" name="optan" id="optan" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('opttn').checked = false;
						  document.getElementById('optny').checked = false;
						document.getElementById('optnn').checked = false;
						  document.getElementById('hidmaintitl').value = 'An.';
						  document.getElementById('txtmainname').focus();
					  }                
					">
								Anak.

								<input name="hidmaintitl" id="hidmaintitl" type="hidden">

								<input type="text" name="txtmainname" id="txtmainname" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 400px;"
									autocomplete="off" onkeyup="if (event.keyCode == 222)
						  {
							alert('Single Quote Error');
							this.value = '';
							this.focus();
						  }"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('optmale').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label>L/P :</label>

								<input type="checkbox" name="optmale" id="optmale" value="true" onclick="if (checked == true) 
					  {
						// let mydate = document.getElementById('tglmainbirt').value;
						// periksatanggal(mydate);
						  document.getElementById('optfemale').checked = false;
						  document.getElementById('hidmaingend').value = 'M';
					  }                
					">
								Laki Laki.
								<input type="checkbox" name="optfemale" id="optfemale" value="true" onclick="if (checked == true) 
					  {
						// let mydate = document.getElementById('tglmainbirt').value;
						// periksatanggal(mydate);

						  document.getElementById('optmale').checked = false;
						  document.getElementById('hidmaingend').value = 'F';
					  }                
					">
								Perempuan.
								<input name="hidmaingend" id="hidmaingend" type="hidden">
								
								<label for="tglmainbirt">
									<span style="font-size: 11px; color: #ff0000; font-weight: normal;">(Bulan/Tanggal/Tahun</span><br>
									Tanggal Lahir :
								</label>
								<input type="date" name="tglmainbirt" id="tglmainbirt">


							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label>Gol. Darah :</label>

								<input type="checkbox" name="optblooda" id="optblooda" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optbloodb').checked = false;
						  document.getElementById('optbloodab').checked = false;
						  document.getElementById('optbloodo').checked = false;
						  document.getElementById('optbloodx').checked = false;
						  document.getElementById('hidmainblod').value = 'A';
					  }                
					">
								[A]
								<input type="checkbox" name="optbloodb" id="optbloodb" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optblooda').checked = false;
						  document.getElementById('optbloodab').checked = false;
						  document.getElementById('optbloodo').checked = false;
						  document.getElementById('optbloodx').checked = false;
						  document.getElementById('hidmainblod').value = 'B';
					  }                
					">
								[B]
								<input type="checkbox" name="optbloodab" id="optbloodab" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optblooda').checked = false;
						  document.getElementById('optbloodb').checked = false;
						  document.getElementById('optbloodo').checked = false;
						  document.getElementById('optbloodx').checked = false
						  document.getElementById('hidmainblod').value = 'AB';
					  }                
					">
								[AB]
								<input type="checkbox" name="optbloodo" id="optbloodo" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optblooda').checked = false;
						  document.getElementById('optbloodb').checked = false;
						  document.getElementById('optbloodab').checked = false;
						  document.getElementById('optbloodx').checked = false;
						  document.getElementById('hidmainblod').value = 'O';
					  }                
					">
								[O]

								<input type="checkbox" name="optbloodx" id="optbloodx" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optblooda').checked = false;
						  document.getElementById('optbloodb').checked = false;
						  document.getElementById('optbloodab').checked = false;
						  document.getElementById('optbloodo').checked = false;
						  document.getElementById('hidmainblod').value = 'X';
					  }                
					">
								[Tidak Tahu]

								<input name="hidmainblod" id="hidmainblod" type="hidden">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmainaddr">Alamat :</label>
								<input type="text" name="txtmainaddr" id="txtmainaddr" oninput="this.value = this.value.toUpperCase()" maxlength="100" style="width: 500px;"
									autocomplete="off" onkeyup="if (event.keyCode == 222)
						  {
							alert('Single Quote Error');
							this.value = '';
							this.focus();
						  }"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainward').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmainward">Kelurahan :</label>
								<input type="text" name="txtmainward" id="txtmainward" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmaindist').focus()">

								<label for="txtmaindist">Kecamatan :</label>
								<input type="text" name="txtmaindist" id="txtmaindist" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmaincity').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmaincity">Kota :</label>
								<input type="text" name="txtmaincity" id="txtmaincity" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainprov').focus()">

								<label for="txtmainprov">Provinsi :</label>
								<input type="text" name="txtmainprov" id="txtmainprov" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainreli').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmainreli">Agama :</label>
								<input type="text" name="txtmainreli" id="txtmainreli" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 150px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) 
				 {
					 document.getElementById('optwni').checked = true;
					 document.getElementById('hidmainctzn').value = 'WNI';
					 document.getElementById('optmainstat').focus();
				 }">

								<label>Warga Negara :</label>

								<input type="checkbox" name="optwni" id="optwni" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optwna').checked = false;
						  document.getElementById('hidmainctzn').value = 'WNI';
					  }                
					">
								[Indonesia]

								<input type="checkbox" name="optwna" id="optwna" value="true" onclick="if (checked == true) 
					  {
						  document.getElementById('optwni').checked = false;
						  document.getElementById('hidmainctzn').value = 'WNA';
					  }                
					">
								[Asing]

								<input name="hidmainctzn" id="hidmainctzn" type="hidden">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="optmainstat">Status :</label>
								<select name="optmainstat" id="optmainstat"
									onchange="document.getElementById('txtmainprof').focus();">
									<option value="Lajang">Belum Menikah</option>
									<option value="Menikah">Sudah Menikah</option>
									<option value="Janda">Janda</option>
									<option value="Duda">Duda</option>
									<option value="Anak">Anak Anak</option>
								</select>

								<label for="txtmainprof">Profesi :</label>
								<input type="text" name="txtmainprof" id="txtmainprof" oninput="this.value = this.value.toUpperCase()" maxlength="50" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('optmaineduc').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="optmaineduc">Pendidikan :</label>
								<select name="optmaineduc" id="optmaineduc"
									onchange="document.getElementById('txtmainphne').focus();">
									<option value="SD">SD</option>
									<option value="SMP">SMP</option>
									<option value="SMA">SMA/SMK</option>
									<option value="D3">Diploma 3</option>
									<option value="S1">Strata 1</option>
									<option value="S2">Strata 2</option>
								</select>

							</div><!-- pure-control-group -->


							<div class="pure-control-group">

								<label for="txtmainphne">Mobile :</label>
								<input type="text" name="txtmainphne" id="txtmainphne" maxlength="18" style="width: 180px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainmail').focus()">

								<label for="txtmainmail">E-Mail :</label>
								<input type="text" name="txtmainmail" id="txtmainmail" placeholder="user@domain.com"
									maxlength="50" style="width: 300px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtmainprnt').focus()">

							</div><!-- pure-control-group -->

							<div class="pure-control-group">

								<label for="txtmainprnt">Nama Ibu Kandung :</label>
								<input type="text" name="txtmainprnt" id="txtmainprnt" oninput="this.value = this.value.toUpperCase()" maxlength="100" style="width: 200px;"
									onkeydown="if (event.keyCode == 13 && value.length > 0)
				 {
									if (document.getElementById('txtmainpidn').value.length == 0 )
									{
									swal({
										title: 'NIK Kosong' ,
										text: 'Anda belum mengisi NIK, silah periksa lagi',
										icon: 'warning',
										});

										document.getElementById('txtmainpidn').value = '';
										document.getElementById('txtmainpidn').focus(); 
									}
									else if (document.getElementById('hidmaintitl').value.length == 0)
									{
									swal({
										title: 'Title Belum di Pilih' ,
										text: 'Anda belum memilih Inisial, silah periksa lagi',
										icon: 'warning',
										});
									}
									else if (document.getElementById('txtmainname').value.length == 0)
									{
									swal({
										title: 'Nama Pasien Kosong' ,
										text: 'Anda belum mengisi Nama Pasien, silah periksa lagi',
										icon: 'warning',
										});

									}
									else if (document.getElementById('hidmaingend').value.length == 0)
									{
									swal({
										title: 'Gender Kosong' ,
										text: 'Anda belum memilih Gender / Jenis Kelamin Pasien, silah periksa lagi',
										icon: 'warning',
										});

									}
									else if (document.getElementById('hidmainblod').value.length == 0)
									{
									swal({
										title: 'Golongan Darah Kosong' ,
										text: 'Anda belum memilih Golongan Darah, silah periksa lagi',
										icon: 'warning',
										});

									}
									else if (document.getElementById('txtmainaddr').value.length == 0)
									{
									swal({
										title: 'Alamat Kosong' ,
										text: 'Anda belum mengisi Alamat Pasien, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainward').value.length == 0)
									{
									swal({
										title: 'Kelurahan Kosong' ,
										text: 'Anda belum mengisi Nama Kelurahan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmaindist').value.length == 0)
									{
									swal({
										title: 'Kecamatan Kosong' ,
										text: 'Anda belum mengisi Nama Kecamatan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmaincity').value.length == 0)
									{
									swal({
										title: 'Kota Kosong' ,
										text: 'Anda belum mengisi Nama Kota, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainprov').value.length == 0)
									{
									swal({
										title: 'Provinsi Kosong' ,
										text: 'Anda belum mengisi Nama Provinsi, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainreli').value.length == 0)
									{
									swal({
										title: 'Agama Kosong' ,
										text: 'Anda belum mengisi Agama, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('hidmainctzn').value.length == 0)
									{
									swal({
										title: 'Data Kewarga Negaraan Kosong' ,
										text: 'Anda belum memilih Data Kewarga Negaraan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainphne').value.length == 0)
									{
									swal({
										title: 'Nomor Telpon Kosong' ,
										text: 'Anda belum mengisi Nomor Telpon, silah periksa lagi',
										icon: 'warning',
										});
									}

									else
									{
										document.frmtrxapati.submit();	
									}
				 }
				 ">

							</div><!-- pure-control-group -->


						</fieldset><!-- Mortem -->


						<fieldset>

							<a class="pure-button pure-button-primary" onclick="javascript: if (document.getElementById('txtmainpidn').value.length == 0 )
									{
									swal({
										title: 'NIK Kosong' ,
										text: 'Anda belum mengisi NIK, silah periksa lagi',
										icon: 'warning',
										});

										document.getElementById('txtmainpidn').value = '';
										document.getElementById('txtmainpidn').focus(); 
									}
									else if (document.getElementById('hidmaintitl').value.length == 0)
									{
									swal({
										title: 'Title Belum di Pilih' ,
										text: 'Anda belum memilih Inisial, silah periksa lagi',
										icon: 'warning',
										});
									}
									else if (document.getElementById('txtmainname').value.length == 0)
									{
									swal({
										title: 'Nama Pasien Kosong' ,
										text: 'Anda belum mengisi Nama Pasien, silah periksa lagi',
										icon: 'warning',
										});

									}

									else if (document.getElementById('hidmaingend').value.length == 0)
									{
									swal({
										title: 'Gender Kosong' ,
										text: 'Anda belum memilih Gender / Jenis Kelamin Pasien, silah periksa lagi',
										icon: 'warning',
										});

									}
									else if (document.getElementById('hidmainblod').value.length == 0)
									{
									swal({
										title: 'Golongan Darah Kosong' ,
										text: 'Anda belum memilih Golongan Darah, silah periksa lagi',
										icon: 'warning',
										});

									}
									else if (document.getElementById('txtmainaddr').value.length == 0)
									{
									swal({
										title: 'Alamat Kosong' ,
										text: 'Anda belum mengisi Alamat Pasien, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainward').value.length == 0)
									{
									swal({
										title: 'Kelurahan Kosong' ,
										text: 'Anda belum mengisi Nama Kelurahan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmaindist').value.length == 0)
									{
									swal({
										title: 'Kecamatan Kosong' ,
										text: 'Anda belum mengisi Nama Kecamatan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmaincity').value.length == 0)
									{
									swal({
										title: 'Kota Kosong' ,
										text: 'Anda belum mengisi Nama Kota, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainprov').value.length == 0)
									{
									swal({
										title: 'Provinsi Kosong' ,
										text: 'Anda belum mengisi Nama Provinsi, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainreli').value.length == 0)
									{
									swal({
										title: 'Agama Kosong' ,
										text: 'Anda belum mengisi Agama, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('hidmainctzn').value.length == 0)
									{
									swal({
										title: 'Data Kewarga Negaraan Kosong' ,
										text: 'Anda belum memilih Data Kewarga Negaraan, silah periksa lagi',
										icon: 'warning',
										});
									}

									else if (document.getElementById('txtmainphne').value.length == 0)
									{
									swal({
										title: 'Nomor Telpon Kosong' ,
										text: 'Anda belum mengisi Nomor Telpon, silah periksa lagi',
										icon: 'warning',
										});
									}
									else if (document.getElementById('txtmainprnt').value.length == 0)
									{
									swal({
										title: 'Nama Ibu Kandung' ,
										text: 'Anda belum mengisi Nama Ibu Kandung Pasien, silah periksa lagi',
										icon: 'warning',
										});
									}

									else
									{
										document.frmtrxapati.submit();  
									}
		">Submit</a>

						</fieldset>
						<fieldset>

							<div id="tblpati" style="position: absolute; 
				 top: 300px;
				 left: calc(75% - 200px);
				 background-color: white; 
				 ">

						</fieldset>

						<fieldset>

							<div id="tblempl" style="position: absolute; 
				top:550px; 
				right: 600px; 
				background-color: white; 
				width: 600px; 
				visibility: hidden; 
				z-index: 100">

						</fieldset>

						<fieldset>

							<div id="tbldivi" style="position: absolute; 
				top:550px; 
				right: 600px; 
				background-color: white; 
				width: 600px; 
				visibility: hidden; 
				z-index: 100">

						</fieldset>

						<fieldset>

							<div id="tblpstn" style="position: absolute; 
				top:600px; 
				right: 600px; 
				background-color: white; 
				width: 600px; 
				visibility: hidden; 
				z-index: 100">

						</fieldset>

						<fieldset>

							<div id="tblbank" style="position: absolute; 
				top:650px; 
				right: 600px; 
				background-color: white; 
				width: 600px; 
				visibility: hidden; 
				z-index: 100">

						</fieldset>
					</form>

				</div><!-- div content -->
				<div class="footerdate">
					<span class="labelTime Time"><b>Date :</b> <?php $tgl = date('d-m-Y');
					echo $tgl; ?></span>
				</div>
				<div class="footertime">
					<span class="labelTime Time" id="timestamp"></span>
				</div>


			</div><!-- div main -->
		</div><!-- div layout -->
		<script src="js/TRXAPATI01.js?v=20260108-1"></script>

		<script src="js/ui.js"></script>

	</body>

	</html>
	<?php
} else {
	header("Location: " . "signin.php");
}
?>