<!doctype html>
<?php include "conf/config.php";
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
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
<title>Chart Of Account</title>
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
</style>
</head>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_COAC_ENTR');
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
               <a class="pure-menu-link">AKUNTING</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'AUTOJRNL00.php'">
              <a class="pure-menu-link">Auto Jurnal</a>
            </li>

            <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAJRNL00.php'">
              <a class="pure-menu-link">Manual Jurnal</a>
            </li>

            <li class="pure-menu-item menu-item-divided pure-menu-selected">
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

              <li class="pure-menu-item pure-menu-disabled">
                Buat COA
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'COACMAST02.php'">
                <a class="pure-menu-link">
                Ubah COA
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'COACMAST03.php'">
                <a class="pure-menu-link">
                Hapus COA
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'COACMAST04.php'">
                <a class="pure-menu-link">
                Lihat COA
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmcoacmast" class="pure-form pure-form-aligned" method="post" action="COACMAST01E.php">

      <fieldset>
        <div class="pure-control-group">

        <label for="txtmastprnt">Account Parent :</label>

            <input type="text" 
            name="txtmastprnt" 
            placeholder="Insert Code Account Parent" 
            id="txtmastprnt" 
            autocomplete="off" 
            maxlength ="50" 
            style="width: 300px;"
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
          <div id="tblcoac">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">
      <input name = "hidmastprnt"
               id = "hidmastprnt"
             type = "hidden">        
      </div><!-- pure-control-group -->

      <div class="pure-control-group">
      <label for="txtmastcode">Account Code :</label>
            <input type="text" 
             name="txtprntcode" 
             id="txtprntcode" 
             maxlength ="10"
             style="width: 60px;"
             readonly="true">

      <input type="text" 
             name="txtmastcode" 
             id="txtmastcode" 
             maxlength ="10"
             style="width: 100px;"
             onkeyup="
                     if (value.length > 0) 
                        {
                            var inmastprnt = document.getElementById('hidmastprnt').value;
                            periksamastcode (inmastprnt,this.value);
                        }
                    else
                        {
                            document.getElementById('labelmessage').style.visibility = 'hidden';
                        }"
              onkeydown="if (event.keyCode == 13 && value.length > 0 )
                        {
                              document.getElementById('txtmastname').focus();
                        }">

      <span id="labelmessage" 
                    class="pure-form-message" 
                    style="visibility: hidden;">Code is Exist!.</span>

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

        <label for="txtmastname">Account Name :</label>
              <input type="text" 
              name="txtmastname" 
              id="txtmastname" 
              maxlength ="50" 
              style="width: 300px;"
              onkeydown="if (event.keyCode == 13 && value.length > 0 )
                        {
                              document.getElementById('optmastcosg').checked = true;
                        }
            ">
      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="optmastcosg">Used for FOH With Allocated :</label>
      <input type="checkbox"
            name="optmastcosg" 
            id="optmastcosg"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('hidmastcosg').value = 'Y';
                  }   
                ">
      <input name="hidmastcosg"
              id="hidmastcosg"
              type="hidden">
      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="optparent">Type Account :</label>
      <input type="checkbox"
            name="optparent" 
            id="optparent"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optchild').checked = false;
                      document.getElementById('hidmaststat').value = 'P';
                  }                
                ">
            Parent.

      <input type="checkbox"
            name="optchild" 
            id="optchild"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optparent').checked = false;
                      document.getElementById('hidmaststat').value = 'C';
                  }                
                ">
            Child.

      <input name="hidmaststat"
              id="hidmaststat"
              type="hidden">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="optdebit">Normal Balance :</label>
      <input type="checkbox"
            name="optdebit" 
            id="optdebit"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optcredit').checked = false;
                      document.getElementById('hidnormblnc').value = 'DB'; 
                  }                
                ">
            Debit.

      <input type="checkbox"
            name="optcredit" 
            id="optcredit"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optdebit').checked = false;
                      document.getElementById('hidnormblnc').value = 'CR'; 
                  }                
                ">
            Credit.
      <input name="hidnormblnc"
              id="hidnormblnc"
              type="hidden">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

      <label for="optbs">Status Financial Report :</label>
      <input type="checkbox"
            name="optbs" 
            id="optbs"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optpl').checked = false;
                      document.getElementById('hidfnrpstat').value = 'BS'; 
                  }                
                ">
            Balance Sheet.

      <input type="checkbox"
            name="optpl" 
            id="optpl"
            value="true"
            onclick="if (checked == true) 
                  {
                      document.getElementById('optbs').checked = false;
                      document.getElementById('hidfnrpstat').value = 'PL';
                  }                
                ">
            Profit Loss.
      <input name="hidfnrpstat"
              id="hidfnrpstat"
              type="hidden">

      </div><!-- pure-control-group -->

      <div class="pure-control-group">

       <label for="txtmastnote">Note :</label>
              <input type="text" 
              name="txtmastnote" 
              id="txtmastnote" 
              maxlength ="100"
              style="width: 500px;"

              onkeydown="
                            if (event.keyCode == 13 && value.length > 0)
                                     {
                                          if (document.getElementById('hidmastprnt').value.length == 0) 
                                          { 
                                            alert('Pilih Daftar Kode Akun Induk'); 
                                            document.getElementById('txtmastprnt').value = '';
                                            document.getElementById('txtmastprnt').focus(); 
                                          }
                                          else if (document.getElementById('txtmastcode').value.length == 0) 
                                          {
                                            alert('Isi Kode Akun'); 
                                            document.getElementById('txtmastcode').value = '';
                                            document.getElementById('txtmastcode').focus();                                 
                                          }
                                          else
                                          {
                                            document.frmcoacmast.submit();  
                                          }                           
                                     } 
                                  else 
                                     {
                                      document.getElementById('txtmastnote').focus();
                                     }
                ">
      </div><!-- pure-control-group -->

      </fieldset>

      <fieldset>
      <div id="salah">

          <a class="pure-button pure-button-primary" 
             onclick="javascript: try { 
                            if (document.getElementById('txtmastnote').value.length > 0 )
                                     {
                                          if (document.getElementById('hidmastprnt').value.length == 0) 
                                          { 
                                            alert('Pilih Daftar Kode Akun Induk'); 
                                            document.getElementById('txtmastprnt').value = '';
                                            document.getElementById('txtmastprnt').focus(); 
                                          }
                                          else if (document.getElementById('txtmastcode').value.length == 0) 
                                          {
                                            alert('Isi Kode Akun'); 
                                            document.getElementById('txtmastcode').value = '';
                                            document.getElementById('txtmastcode').focus();                                 
                                          }
                                          else
                                          {
                                            document.frmcoacmast.submit();  
                                          }                           
                                     } 
                                  else 
                                     {
                                      document.getElementById('txtmastnote').focus();
                                     }
                                  }
                                  catch(err){ document.getElementById('salah').innerHTML = err.message; }
        ">Submit</a>
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
<script src="js/COACMAST01.js"></script>
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
