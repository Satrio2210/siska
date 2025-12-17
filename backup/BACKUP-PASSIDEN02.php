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
<title>Access User</title>
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

    .button-update 
    {
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
<script>
$(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }
</script>

<body onLoad="periksaakses('PASS_IDEN_PREV');">

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
          <a class="pure-menu-link">AKSES</a>
        </li>


        <li class="pure-menu-item" onclick="javascript: location.href = 'signout.php'">
          <a class="pure-menu-link">EXIT</a>
        </li>
          
        </ul><!-- pure-menu-list -->
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
        <!-- <li class="pure-menu-item pure-menu-disabled"> -->                

          <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN01.php'">
                <a class="pure-menu-link">
                Buat User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Akses User
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN03.php'">
                <a class="pure-menu-link">
                Hapus User
                </a>
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'PASSIDEN04.php'">
                <a class="pure-menu-link">
                Tampil User
                </a>
              </li>


            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmpassiden" class="pure-form pure-form-aligned" method="post" action="PASSIDEN02U.php">

        <fieldset>

            <div class="pure-control-group">

            <label for="txtuseriden">User ID :</label>    

            <input type="text" 
                name="txtuseriden" 
                id="txtuseriden" 
                autocomplete="off"
                maxlength ="5" 
                style="width: 80px;"

                onkeyup="var start = this.selectionStart;
                     var end = this.selectionEnd;
                     this.value = this.value.toUpperCase();
                     this.setSelectionRange(start, end);
                     if (value.length == 5) 
                        {
                            periksaid (this.value);
                        }
                    else
                        {
                            document.getElementById('labelmessage').style.visibility = 'hidden';
                        }"

                onkeydown="if (event.keyCode == 13 && value.length > 0) document.getElementById('txtusername').focus()">

                <span id="labelmessage" 
                class="pure-form-message" 
                style="visibility: hidden;">User ID not found!.</span>

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label for="txtusername">User Name :</label>

            <input type="text" 
                name="txtusername" 
                placeholder="Nama User" 
                id="txtusername" 
                maxlength ="20" 
                style="width: 230px;"
                readonly="true"> 

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

            <label>Type Staff  :</label>
                <input type="checkbox"
                    name="optdoctor" 
                    id="optdoctor"
                    value="true"
                    onclick="if (checked == true) 
                          {
                              document.getElementById('optnondoctor').checked = false;
                              document.getElementById('hidusertype').value = 'Y';
                              var userakses = document.getElementById('txtuseriden').value;
                              tipecode(userakses);
                          }                
                        ">
                        Medis.
                <input type="checkbox"
                        name="optnondoctor" 
                        id="optnondoctor"
                        value="true"
                        onclick="if (checked == true) 
                              {
                                  	document.getElementById('optdoctor').checked = false;
                                  	document.getElementById('hidusertype').value = 'N';
                              		var userakses = document.getElementById('txtuseriden').value;
                              		tipecode(userakses);
                              }                
                            ">
                        Non Medis.

                <input name="hidusertype"
                          id="hidusertype"
                          type="hidden">

            
            </div><!-- pure-control-group -->

            <div class="pure-control-group">
 
            <label for="txtuserpswd">Password :</label>

            <input type="password" 
                name="txtuserpswd" 
                placeholder="Password" 
                id="txtuserpswd" 
                maxlength ="100" 
                style="width: 300px;"

            onkeydown="if (event.keyCode == 13 && value.length > 0) 
            			{
            				var userakses = document.getElementById('txtuseriden').value;
            				sandicode(userakses,this.value);
            			}">

            <input type="hidden"
            name="hiduserpswd"
            id="hiduserpswd">

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Manage User :</label>
                <input type="checkbox" name="optidennew" id="optidennew" value="true"

                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidennew').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_NEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidennew').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_NEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Create User.
                <input type="checkbox" name="optidenprev" id="optidenprev" value="true"

                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidenprev').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_PREV');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidenprev').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_PREV')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Access User.
                <input type="checkbox" name="optidendell" id="optidendell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidendell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidendell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete User.
                <input type="checkbox" name="optidenview" id="optidenview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optidenview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_IDEN_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optidenview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_IDEN_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View User.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Auto Journal :</label>
                <input type="checkbox" name="optautojrnl" id="optautojrnl" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optautojrnl').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_AUTO_JRNL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optautojrnl').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_AUTO_JRNL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Input Transaction.

            </div><!-- pure-control-group -->                        

            <div class="pure-control-group">

                <label>Manual Journal :</label>
                <input type="checkbox" name="opttrxaentr" id="opttrxaentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxaentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxaentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Input Transaction.
                <input type="checkbox" name="opttrxaupdt" id="opttrxaupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxaupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxaupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Rollback Transaction.
                <input type="checkbox" name="opttrxadell" id="opttrxadell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxadell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxadell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Transaction.
                <input type="checkbox" name="opttrxaview" id="opttrxaview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxaview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxaview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Report Journal.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Chart of Account :</label>
                <input type="checkbox" name="optcoacentr" id="optcoacentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcoacentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_COAC_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcoacentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_COAC_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Create COA.
                <input type="checkbox" name="optcoacupdt" id="optcoacupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcoacupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_COAC_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcoacupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_COAC_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update COA.
                <input type="checkbox" name="optcoacdell" id="optcoacdell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcoacdell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_COAC_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcoacdell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_COAC_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete COA.
                <input type="checkbox" name="optcoacview" id="optcoacview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcoacview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_COAC_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcoacview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_COAC_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View COA.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Group Account :</label>
                <input type="checkbox" name="opttblaentr" id="opttblaentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttblaentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttblaentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Create Group
                <input type="checkbox" name="opttblaupdt" id="opttblaupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttblaupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttblaupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Group.
                <input type="checkbox" name="opttbladell" id="opttbladell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttbladell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttbladell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Group.
                <input type="checkbox" name="opttblaview" id="opttblaview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttblaview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttblaview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Group.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Divisi :</label>
                <input type="checkbox" name="optdivientr" id="optdivientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdivientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DIVI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdivientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DIVI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Input Divisi.
                <input type="checkbox" name="optdiviupdt" id="optdiviupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdiviupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DIVI_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdiviupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DIVI_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Divisi.
                <input type="checkbox" name="optdividell" id="optdividell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdividell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DIVI_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdividell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DIVI_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Divisi.
                <input type="checkbox" name="optdiviview" id="optdiviview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdiviview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DIVI_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdiviview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DIVI_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Divisi.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Report :</label>
                <input type="checkbox" name="optrepogele" id="optrepogele" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrepogele').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_GELE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrepogele').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REPO_GELE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                General Ledger.
                <input type="checkbox" name="optrepotrba" id="optrepotrba" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrepotrba').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_TRBA');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrepotrba').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REPO_TRBA')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Trial Balance.
                <input type="checkbox" name="optrepoprlo" id="optrepoprlo" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrepoprlo').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_PRLO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrepoprlo').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REPO_PRLO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Profit Loss.
                <input type="checkbox" name="optrepoequi" id="optrepoequi" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrepoequi').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_EQUI');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrepoequi').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REPO_EQUI')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Equity.
                <input type="checkbox" name="optreponrca" id="optreponrca" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optreponrca').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REPO_NRCA');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optreponrca').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REPO_NRCA')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Neraca.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Specification Item :</label>
                <input type="checkbox" name="optspecitem" id="optspecitem" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optspecitem').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SPEC_ITEM');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optspecitem').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SPEC_ITEM')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Specification Item.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Manage Item Master :</label>
                <input type="checkbox" name="optinveentr" id="optinveentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optinveentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_INVE_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optinveentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_INVE_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Entry Item.
                <input type="checkbox" name="optinveupdt" id="optinveupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optinveupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_INVE_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optinveupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_INVE_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Item.
                <input type="checkbox" name="optinvedell" id="optinvedell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optinvedell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_INVE_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optinvedell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_INVE_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Item.
                <input type="checkbox" name="optinveview" id="optinveview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optinveview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_INVE_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optinveview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_INVE_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Item.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Manage Location</label>
                <input type="checkbox" name="optfixeloca" id="optfixeloca" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optfixeloca').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_FIXE_LOCA');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optfixeloca').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_FIXE_LOCA')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Location.
                <input type="checkbox" name="optwaremast" id="optwaremast" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optwaremast').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_WARE_MAST');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optwaremast').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_WARE_MAST')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Ware House.

            </div><!-- pure-control-group -->                

            <div class="pure-control-group">

                <label>Transfer Inventory :</label>
                <input type="checkbox" name="opttransrequ" id="opttransrequ" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransrequ').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_REQU');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttransrequ').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_REQU')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Transfer request.
                <input type="checkbox" name="opttransapro" id="opttransapro" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransapro').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_APRO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttransapro').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_APRO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Transfer Aproval.
                <input type="checkbox" name="opttransexec" id="opttransexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttransexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Tranfer Execute.
                <input type="checkbox" name="opttransrece" id="opttransrece" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttransrece').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRANS_RECE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttransrece').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_RECE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Transfer Receipt.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Stock Inventory :</label>
                <input type="checkbox" name="optstockopna" id="optstockopna" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockopna').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_OPNA');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optstockopna').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_STOCK_OPNA')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Stock Opname.
                <input type="checkbox" name="optstockadju" id="optstockadju" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockadju').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_ADJU');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optstockadju').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_STOCK_ADJU')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Stock Adjustment.
                <input type="checkbox" name="optstockexec" id="optstockexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optstockexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_STOCK_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Stock Execute.
                <input type="checkbox" name="optstockrepo" id="optstockrepo" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optstockrepo').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_STOCK_REPO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optstockrepo').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_STOCK_REPO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Stock Report.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Suplier :</label>
                <input type="checkbox" name="optsuplentr" id="optsuplentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsuplentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SUPL_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsuplentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SUPL_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Entry Suplier.
                <input type="checkbox" name="optsuplupdt" id="optsuplupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsuplupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SUPL_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsuplupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SUPL_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Suplier.
                <input type="checkbox" name="optsupldell" id="optsupldell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsupldell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SUPL_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsupldell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SUPL_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Suplier.
                <input type="checkbox" name="optsuplview" id="optsuplview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsuplview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SUPL_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsuplview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SUPL_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Suplier.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Purchasing :</label>
                <input type="checkbox" name="optprocentr" id="optprocentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Purchase Order.
                <input type="checkbox" name="optprocupdt" id="optprocupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Receiving Order.
                <input type="checkbox" name="optprocinvc" id="optprocinvc" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocinvc').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_INVC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocinvc').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_INVC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Purchase Invoice.
                <input type="checkbox" name="optprocretu" id="optprocretu" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optprocretu').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PROC_RETU');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optprocretu').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PROC_RETU')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Purchase Return.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Admision :</label>
                <input type="checkbox" name="optregientr" id="optregientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optregientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REGI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optregientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REGI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Registration Patient.
                <input type="checkbox" name="optregiupdt" id="optregiupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optregiupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REGI_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optregiupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REGI_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Assign Patien To Poli.
                <input type="checkbox" name="optregiview" id="optregiview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optregiview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REGI_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optregiview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REGI_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Schedule Doctor.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Out Patient :</label>
                <input type="checkbox" name="opttrxapoli" id="opttrxapoli" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttrxapoli').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TRXA_POLI');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttrxapoli').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRXA_POLI')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Checking Patient.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Laboratory :</label>
                <input type="checkbox" name="optlaboentr" id="optlaboentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optlaboentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_LABO_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optlaboentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_LABO_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Schedule Patient.
                <input type="checkbox" name="optlaboupdt" id="optlaboupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('opttblaupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_TBLA_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('opttblaupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TBLA_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Checking Patient.
                <input type="checkbox" name="optlaboexit" id="optlaboexit" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optlaboexit').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_LABO_EXIT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optlaboexit').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_LABO_EXIT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Checkout Patient.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Partnership :</label>
                <input type="checkbox" name="optcustentr" id="optcustentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Entry Data Customer.
                <input type="checkbox" name="optcustupdt" id="optcustupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Data Customer.
                <input type="checkbox" name="optcustdell" id="optcustdell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustdell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustdell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Delete Data Customer.
                <input type="checkbox" name="optcustview" id="optcustview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Data Customer.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Cashier :</label>
                <input type="checkbox" name="optsaleentr" id="optsaleentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsaleentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SALE_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsaleentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SALE_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Patient Payment.
                <input type="checkbox" name="optsaleupdt" id="optsaleupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsaleupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SALE_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsaleupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_SALE_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Factur.
                <input type="checkbox" name="optsaleview" id="optsaleview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optsaleview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_SALE_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optsaleview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_TRANS_APRO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Cashier Report.
                <input type="checkbox" name="optdrugentr" id="optdrugentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdrugentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DRUG_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdrugentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DRUG_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Drug Sale.
                <input type="checkbox" name="optdrugview" id="optdrugview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdrugview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DRUG_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdrugview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DRUG_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Report Drug Sale.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Medical Record</label>
                <input type="checkbox" name="optmedirepo" id="optmedirepo" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmedirepo').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MEDI_REPO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmedirepo').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MEDI_REPO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Medical Record Report.

            </div><!-- pure-control-group -->                        

            <div class="pure-control-group">

                <label>Doctor Payment :</label>
                <input type="checkbox" name="optmedientr" id="optmedientr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmedientr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MEDI_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmedientr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MEDI_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Medical Action.
                <input type="checkbox" name="optmediupdt" id="optmediupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmediupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MEDI_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmediupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MEDI_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Fee Doctor.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Vendor Payment :</label>
                <input type="checkbox" name="optvendentr" id="optvendentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payment Request.
                <input type="checkbox" name="optvendupdt" id="optvendupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payment Aproval.
                <input type="checkbox" name="optvendexec" id="optvendexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optvendexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_VEND_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optvendexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_VEND_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payment Execute.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">
            
                <label>Receivable :</label>
                <input type="checkbox" name="optcustrcvd" id="optcustrcvd" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcustrcvd').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CUST_RCVD');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcustrcvd').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CUST_RCVD')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Customer Received.
                <input type="checkbox" name="optpaymcash" id="optpaymcash" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpaymcash').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYM_CASH');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpaymcash').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYM_CASH')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Cash Disbursement.
                <input type="checkbox" name="optothrreve" id="optothrreve" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optothrreve').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_OTHR_REVE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optothrreve').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_OTHR_REVE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Other Revenue.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Debit / Credit :</label>
                <input type="checkbox" name="optdebtnote" id="optdebtnote" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdebtnote').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DEBT_NOTE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdebtnote').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DEBT_NOTE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Debit Note.
                <input type="checkbox" name="optdebtreal" id="optdebtreal" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optdebtreal').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_DEBT_REAL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optdebtreal').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_DEBT_REAL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Debit Note Realization.
                <input type="checkbox" name="optcrdtnote" id="optcrdtnote" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcrdtnote').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CRDT_NOTE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcrdtnote').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CRDT_NOTE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Credit Note.
                <input type="checkbox" name="optcrdtreal" id="optcrdtreal" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optcrdtreal').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_CRDT_REAL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optcrdtreal').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_CRDT_REAL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Credit Note Realization.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Bank :</label>
                <input type="checkbox" name="optfinareco" id="optfinareco" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optfinareco').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_FINA_RECO');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optfinareco').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_FINA_RECO')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Bank Reconciliation.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Fixed Asset :</label>
                <input type="checkbox" name="optassetype" id="optassetype" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optassetype').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_ASSE_TYPE');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optassetype').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_ASSE_TYPE')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Asset Type.
                <input type="checkbox" name="optassepost" id="optassepost" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optassepost').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_ASSE_POST');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optassepost').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_ASSE_POST')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Asset Posting.
                <input type="checkbox" name="optasselist" id="optasselist" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optasselist').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_ASSE_LIST');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optasselist').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_ASSE_LIST')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Asset List.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Asset Tracking </label>
                <input type="checkbox" name="optmoveexec" id="optmoveexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Movement Execution.
                <input type="checkbox" name="optmovehist" id="optmovehist" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optmovehist').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_MOVE_HIST');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optmovehist').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_MOVE_HIST')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Movement History.
                <input type="checkbox" name="optrevaexec" id="optrevaexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrevaexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REVA_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrevaexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REVA_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Revaluation Execution.
                <input type="checkbox" name="optrevahist" id="optrevahist" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optrevahist').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_REVA_HIST');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optrevahist').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_REVA_HIST')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Revaluation History.
                <input type="checkbox" name="optassedisp" id="optassedisp" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optassedisp').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_ASSE_DISP');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optassedisp').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_ASSE_DISP')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Asset Disposal.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Personnel :</label>
                <input type="checkbox" name="optemplentr" id="optemplentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Register Employe.
                <input type="checkbox" name="optemplupdt" id="optemplupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Update Employe.
                <input type="checkbox" name="optempldell" id="optempldell" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optempldell').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_DELL');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optempldell').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_DELL')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Resign Employe.
                <input type="checkbox" name="optemplview" id="optemplview" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplview').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_VIEW');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplview').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_VIEW')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                View Employe.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

                <label>Payroll :</label>
                <input type="checkbox" name="optpayrentr" id="optpayrentr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpayrentr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYR_ENTR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpayrentr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYR_ENTR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payroll System.
                <input type="checkbox" name="optemplpayr" id="optemplpayr" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optemplpayr').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_EMPL_PAYR');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optemplpayr').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_EMPL_PAYR')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payroll Employe System.
                <input type="checkbox" name="optpayrupdt" id="optpayrupdt" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpayrupdt').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYR_UPDT');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpayrupdt').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYR_UPDT')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payroll Slip Request.
                <input type="checkbox" name="optpayrexec" id="optpayrexec" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpayrexec').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYR_EXEC');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpayrexec').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYR_EXEC')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Payroll Slip Processing.
                <input type="checkbox" name="optpayrcash" id="optpayrcash" value="true"
                        onclick="if (checked == true) 
                              {
                                  document.getElementById('optpayrcash').checked = false;
                                  var userakses = document.getElementById('txtuseriden').value;
                                  aksescode(userakses,'PASS_PAYR_CASH');
                              }                
                              else if (checked == false) 
                              {
                              	  document.getElementById('optpayrcash').checked = true;
                              	  var userakses = document.getElementById('txtuseriden').value;
                              	  aksescode(userakses,'PASS_PAYR_CASH')
                              }
                              else
                              {
                              	alert('Problem Access!');
                              }
                            ">
                Cash Disbursement.

            </div><!-- pure-control-group -->

            <div class="pure-control-group">

        </fieldset>

        <fieldset>
        <a class="pure-button button-update" 
        onclick="javascript: location.href = 'PASSIDEN02.php';
        ">Close</a>
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
<script src="js/PASSIDEN02.js"></script>
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
