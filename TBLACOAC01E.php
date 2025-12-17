<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";
      $xparentcode = $_POST['optparentcode'];
      $xcoaccode = $_POST['txtcoaccode'];
      $incoaccode = ''.$xparentcode.''.$xcoaccode;

      $periksacoaccode = "SELECT COUNT(*) FROM tblacoac WHERE TBLA_COAC_CODE='$incoaccode'";
      $periksacoaccode_di_query=$db->query($periksacoaccode) or die ("Cek Fail");
      $ketersediaan = $periksacoaccode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['optparentcode']))  {$parentcode = $_POST['optparentcode'];}//ok
        if(isset($_POST['txtcoaccode']))  {$coaccode = $_POST['txtcoaccode'];}//ok
        if(isset($_POST['txtcoacname']))  {$coacname = $_POST['txtcoacname'];}//ok

        $akses = 'Y';             
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO tblacoac (
        TBLA_COAC_CODE, TBLA_COAC_NAME, TBLA_COAC_STAT, 
        TBLA_ENTR_DATE, TBLA_ENTR_TIME, TBLA_ENTR_USER, 
        TBLA_UPDT_DATE, TBLA_UPDT_TIME, TBLA_UPDT_USER) 
        VALUES (
        :TBLA_COAC_CODE, :TBLA_COAC_NAME, :TBLA_COAC_STAT,
        :TBLA_ENTR_DATE, :TBLA_ENTR_TIME, :TBLA_ENTR_USER, 
        :TBLA_UPDT_DATE, :TBLA_UPDT_TIME, :TBLA_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
            ':TBLA_COAC_CODE' =>$incoaccode, 
            ':TBLA_COAC_NAME' =>$coacname, 
            ':TBLA_COAC_STAT' =>$akses, 
            ':TBLA_ENTR_DATE' =>$dateinput,
            ':TBLA_ENTR_TIME' =>$timeinput,
            ':TBLA_ENTR_USER' =>$userid, 
            ':TBLA_UPDT_DATE' =>$dateinput,
            ':TBLA_UPDT_TIME' =>$timeinput,
            ':TBLA_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: TBLACOAC01.php");
      }
      else
      {
         header("location: TBLACOAC00.php");
      }
}
else
{
  header("location: "."index.php");
}
?>