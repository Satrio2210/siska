<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";

      $xdivicode = $_POST['txtdivicode'];
      $periksadivicode = "SELECT COUNT(*) FROM tbledivi WHERE TBLE_DIVI_CODE='$xdivicode'";
      $periksadivicode_di_query=$db->query($periksadivicode) or die ("Cek Fail");
      $ketersediaan = $periksadivicode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['txtdivicode']))  {$divicode = $_POST['txtdivicode'];}//ok
        if(isset($_POST['txtdiviname']))  {$diviname = $_POST['txtdiviname'];}//ok

        $akses = 'Y';             
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO tbledivi (
        TBLE_DIVI_CODE, TBLE_DIVI_NAME, TBLE_DIVI_STAT, 
        TBLE_ENTR_DATE, TBLE_ENTR_TIME, TBLE_ENTR_USER, 
        TBLE_UPDT_DATE, TBLE_UPDT_TIME, TBLE_UPDT_USER) 
        VALUES (
        :TBLE_DIVI_CODE, :TBLE_DIVI_NAME, :TBLE_DIVI_STAT,
        :TBLE_ENTR_DATE, :TBLE_ENTR_TIME, :TBLE_ENTR_USER, 
        :TBLE_UPDT_DATE, :TBLE_UPDT_TIME, :TBLE_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
            ':TBLE_DIVI_CODE' =>$divicode, 
            ':TBLE_DIVI_NAME' =>$diviname, 
            ':TBLE_DIVI_STAT' =>$akses, 
            ':TBLE_ENTR_DATE' =>$dateinput,
            ':TBLE_ENTR_TIME' =>$timeinput,
            ':TBLE_ENTR_USER' =>$userid, 
            ':TBLE_UPDT_DATE' =>$dateinput,
            ':TBLE_UPDT_TIME' =>$timeinput,
            ':TBLE_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: TBLEDIVI01.php");
      }
      else
      {
         header("location: TBLEDIVI00.php");
      }
}
else
{
  header("location: "."index.php");
}
?>