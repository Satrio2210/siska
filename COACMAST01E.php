<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";

      $xmastcode = $_POST['txtmastcode'];
      $xmastprnt = $_POST['hidmastprnt'];
      //$parentcode = substr($xmastprnt,0,3);
      //$mastcode = $xmastprnt . '.' . $xmastcode;

      $periksamastcode = "SELECT COUNT(*) FROM coacmast WHERE COAC_MAST_CODE='$xmastcode' AND COAC_MAST_PRNT='$xmastprnt'";
      $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
      $ketersediaan = $periksamastcode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['txtmastcode']) && ($_POST['txtmastcode'] != ''))  {$mastcode = $_POST['txtmastcode'];}//ok
        if(isset($_POST['hidmastprnt']) && ($_POST['hidmastprnt'] != ''))  {$mastprnt = $_POST['hidmastprnt'];}//ok
        if(isset($_POST['txtmastname']) && ($_POST['txtmastname'] != ''))  {$mastname = $_POST['txtmastname'];}//ok

        if(isset($_POST['hidmastcosg']) && ($_POST['hidmastcosg'] != ''))  
        {$mastcosg = $_POST['hidmastcosg'];}
        else
        {$mastcosg = 'N';} //ok

        if(isset($_POST['hidmaststat']) && ($_POST['hidmaststat'] != ''))  {$maststat = $_POST['hidmaststat'];}//ok
        if(isset($_POST['hidnormblnc']) && ($_POST['hidnormblnc'] != ''))  {$normblnc = $_POST['hidnormblnc'];}//ok
        if(isset($_POST['hidfnrpstat']) && ($_POST['hidfnrpstat'] != ''))  {$fnrpstat = $_POST['hidfnrpstat'];}//ok
        if(isset($_POST['txtmastnote']) && ($_POST['txtmastcode'] != ''))  {$mastnote = $_POST['txtmastnote'];}//ok
        $viewstat = 'Y';
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO coacmast (
        COAC_MAST_CODE, COAC_MAST_PRNT, COAC_MAST_NAME, 
        COAC_MAST_COSG, COAC_MAST_STAT, COAC_NORM_BLNC, 
        COAC_FNRP_STAT, COAC_MAST_NOTE, COAC_VIEW_STAT,
        COAC_ENTR_DATE, COAC_ENTR_TIME, COAC_ENTR_USER, 
        COAC_UPDT_DATE, COAC_UPDT_TIME, COAC_UPDT_USER) 
        VALUES (
        :COAC_MAST_CODE, :COAC_MAST_PRNT, :COAC_MAST_NAME, 
        :COAC_MAST_COSG, :COAC_MAST_STAT, :COAC_NORM_BLNC, 
        :COAC_FNRP_STAT, :COAC_MAST_NOTE, :COAC_VIEW_STAT,
        :COAC_ENTR_DATE, :COAC_ENTR_TIME, :COAC_ENTR_USER, 
        :COAC_UPDT_DATE, :COAC_UPDT_TIME, :COAC_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
            ':COAC_MAST_CODE' =>$mastcode, 
            ':COAC_MAST_PRNT' =>$mastprnt,
            ':COAC_MAST_NAME' =>$mastname,
            ':COAC_MAST_COSG' =>$mastcosg,
            ':COAC_MAST_STAT' =>$maststat,
            ':COAC_NORM_BLNC' =>$normblnc,
            ':COAC_FNRP_STAT' =>$fnrpstat,
            ':COAC_MAST_NOTE' =>$mastnote,
            ':COAC_VIEW_STAT' =>$viewstat, 
            ':COAC_ENTR_DATE' =>$dateinput,
            ':COAC_ENTR_TIME' =>$timeinput,
            ':COAC_ENTR_USER' =>$userid, 
            ':COAC_UPDT_DATE' =>$dateinput,
            ':COAC_UPDT_TIME' =>$timeinput,
            ':COAC_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
        header("location: COACMAST01.php");
      }
      else
      {
         header("location: COACMAST00.php");
      }
}
else
{
  header("location: "."index.php");
}
?>