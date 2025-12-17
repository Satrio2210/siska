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
<title>Persetujuan Pembayaran</title>
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
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/sanie.js"></script>

<script type="text/javascript">
  $(document).ready(function() 
{
    setInterval(timestamp, 1000);
});  
    function timestamp() { $.ajax({ url: 'inc/timestamp.php', success: function(data) { $('#timestamp').html(data); }, }); }

</script>

</head>
<body onLoad="periksaakses('PASS_VEND_UPDT');  
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
                <a class="pure-menu-link">KEUANGAN</a>
              </li>

              <li class="pure-menu-item menu-item-divided pure-menu-selected">
                <a class="pure-menu-link">Bayar Vendor</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'CUSTRCVD01.php'">
                <a class="pure-menu-link">Pelunasan</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXAPAYM00.php'">
                <a class="pure-menu-link">Bayar Lain Lain</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXADEBT00.php'">
                <a class="pure-menu-link">Debit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXACRDT00.php'">
                <a class="pure-menu-link">Credit</a>
              </li>

              <li class="pure-menu-item" onclick="javascript: location.href = 'TRXARECO01.php'">
                <a class="pure-menu-link">Rekonsil</a>
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

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAVEND01.php'">
                <a class="pure-menu-link">
                Pengajuan Pembayaran
                </a>
              </li>

              <li class="pure-menu-item pure-menu-disabled">
                Persetujuan Pembayaran
              </li>

              <li class="pure-menu-item pure-menu-selected" onclick="javascript: location.href = 'TRXAVEND03.php'">
                <a class="pure-menu-link">
                Eksekusi Pembayaran
                </a>
              </li>

            </ul>
          </div>
    <!-- Tab Menu -->

    <!-- Form Input -->
    <form name="frmtrxavend" class="pure-form pure-form-aligned" method="post" action="">
      <fieldset>
        <div id="tblviewvend">
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
<script src="js/TRXAVEND02.js"></script>
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
