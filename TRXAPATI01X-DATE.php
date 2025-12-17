<?php
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

  $dateid = xss_clean($_POST['q']);
  //$fieldid = 'PASS_EMPL_ENTR;
  //$userid = $_SESSION['username'];
  //$userid = 'ASRUL';

    //if ($userid !="$idadmin")
    //{
      $query_date = "SELECT COUNT(*) FROM patimast WHERE PATI_MAIN_BIRT = '$dateid' AND PATI_VIEW_STAT='Y'";
      $qdate = $db->query($query_date) or die("Field Tanggal Salah");
      $row = $qdate->fetchColumn();

      if ($row == 0)
      {
        echo "";
      }
      else
      {
        echo "0$row";
      }
    //}
    //else
    //{
    //  echo "01";
    //}
}
?>  
