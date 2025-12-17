<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

  $fieldid = xss_clean($_POST['q']);
  //$fieldid = 'PASS_STOCK_ADJU';
  $userid = $_SESSION['username'];
  //$userid = 'ASRUL';

    if ($userid !="$idadmin")
    {
      $query_akses = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN = '$userid' AND ".$fieldid." = 'Y'";
      $qakses = $db->query($query_akses) or die("Field Akses Salah");
      $row = $qakses->fetchColumn();

      if ($row == 0)
      {
        echo "";
      }
      else
      {
        echo "0$row";
      }
    }
    else
    {
      echo "01";
    }
}
?>  
