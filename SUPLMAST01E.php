<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";

      $mastcode = $_POST['txtmastcode'];

      $periksamastcode = "SELECT COUNT(*) FROM suplmast WHERE SUPL_MAST_CODE='$mastcode'";
      $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
      $ketersediaan = $periksamastcode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode suplier baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['txtmainname']) && ($_POST['txtmainname'] != ''))  {$mainname = $_POST['txtmainname'];}//ok

        if(isset($_POST['txtmainaddr']) && ($_POST['txtmainaddr'] != ''))  {$mainaddr = $_POST['txtmainaddr'];}//ok
        if(isset($_POST['txtmaincity']) && ($_POST['txtmaincity'] != ''))  {$maincity = $_POST['txtmaincity'];}//ok
        if(isset($_POST['txtmainctry']) && ($_POST['txtmainctry'] != ''))  {$mainctry = $_POST['txtmainctry'];}//ok
        if(isset($_POST['txtmainphne']) && ($_POST['txtmainphne'] != ''))  {$mainphne = $_POST['txtmainphne'];}//ok
        if(isset($_POST['txtmainfaxi']) && ($_POST['txtmainfaxi'] != ''))  {$mainfaxi = $_POST['txtmainfaxi'];}//ok
        if(isset($_POST['txtmainmail']) && ($_POST['txtmainmail'] != ''))  {$mainmail = $_POST['txtmainmail'];}//ok
        if(isset($_POST['txtmainwebs']) && ($_POST['txtmainwebs'] != ''))  {$mainwebs = $_POST['txtmainwebs'];}//ok
        if(isset($_POST['txtmainpers']) && ($_POST['txtmainpers'] != ''))  {$mainpers = $_POST['txtmainpers'];}//ok

        if(isset($_POST['txtmaintidn1']) && ($_POST['txtmaintidn1'] != ''))  {$maintidn1 = $_POST['txtmaintidn1'];}//ok
        if(isset($_POST['txtmaintidn2']) && ($_POST['txtmaintidn2'] != ''))  {$maintidn2 = $_POST['txtmaintidn2'];}//ok
        if(isset($_POST['txtmaintidn3']) && ($_POST['txtmaintidn3'] != ''))  {$maintidn3 = $_POST['txtmaintidn3'];}//ok
        if(isset($_POST['txtmaintidn4']) && ($_POST['txtmaintidn4'] != ''))  {$maintidn4 = $_POST['txtmaintidn4'];}//ok
        if(isset($_POST['txtmaintidn5']) && ($_POST['txtmaintidn5'] != ''))  {$maintidn5 = $_POST['txtmaintidn5'];}//ok
        if(isset($_POST['txtmaintidn6']) && ($_POST['txtmaintidn6'] != ''))  {$maintidn6 = $_POST['txtmaintidn6'];}//ok

        if(isset($_POST['txtmainterm']) && ($_POST['txtmainterm'] != ''))  {$mainterm = $_POST['txtmainterm'];}//ok

        if(isset($_POST['txtestiarrv']) && ($_POST['txtestiarrv'] != ''))  {$estiarrv = $_POST['txtestiarrv'];}//ok

        if(isset($_POST['txtestideli']) && ($_POST['txtestideli'] != ''))  {$estideli = $_POST['txtestideli'];}//ok

        if(isset($_POST['txtpayalimt']) && ($_POST['txtpayalimt'] != ''))  {$xpayalimt = $_POST['txtpayalimt'];}//ok

        if(isset($_POST['hidbankcode']) && ($_POST['hidbankcode'] != ''))  {$bankcode = $_POST['hidbankcode'];}//ok

        if(isset($_POST['hidavaifrwd']) && ($_POST['hidavaifrwd'] != ''))  
        {$avaifrwd = $_POST['hidavaifrwd'];}
        else
        {$avaifrwd = 'N';} //ok
 
        $maintidn = $maintidn1 . '.' . $maintidn2 . '.' . $maintidn3 . '.' . $maintidn4 . '-' . $maintidn5 . '.' . $maintidn6;
        $payalimt = str_replace(".","",$xpayalimt); 
        $viewstat = 'Y';
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO suplmast (
        SUPL_MAST_CODE, SUPL_MAIN_NAME, SUPL_MAIN_ADDR, 
        SUPL_MAIN_CITY, SUPL_MAIN_CTRY, SUPL_MAIN_PHNE,
        SUPL_MAIN_FAXI, SUPL_MAIN_MAIL, SUPL_MAIN_WEBS,
        SUPL_MAIN_PERS, SUPL_MAIN_TIDN, SUPL_MAIN_TERM,
        SUPL_ESTI_ARRV, SUPL_ESTI_DELI, SUPL_PAYA_LIMT,
        SUPL_BANK_CODE, SUPL_AVAI_FRWD, SUPL_VIEW_STAT, 
        SUPL_ENTR_DATE, SUPL_ENTR_TIME, SUPL_ENTR_USER, 
        SUPL_UPDT_DATE, SUPL_UPDT_TIME, SUPL_UPDT_USER) 
        VALUES (
        :SUPL_MAST_CODE, :SUPL_MAIN_NAME, :SUPL_MAIN_ADDR, 
        :SUPL_MAIN_CITY, :SUPL_MAIN_CTRY, :SUPL_MAIN_PHNE,
        :SUPL_MAIN_FAXI, :SUPL_MAIN_MAIL, :SUPL_MAIN_WEBS,
        :SUPL_MAIN_PERS, :SUPL_MAIN_TIDN, :SUPL_MAIN_TERM,
        :SUPL_ESTI_ARRV, :SUPL_ESTI_DELI, :SUPL_PAYA_LIMT,
        :SUPL_BANK_CODE, :SUPL_AVAI_FRWD, :SUPL_VIEW_STAT, 
        :SUPL_ENTR_DATE, :SUPL_ENTR_TIME, :SUPL_ENTR_USER, 
        :SUPL_UPDT_DATE, :SUPL_UPDT_TIME, :SUPL_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
            ':SUPL_MAST_CODE' =>$mastcode, 
            ':SUPL_MAIN_NAME' =>$mainname,
            ':SUPL_MAIN_ADDR' =>$mainaddr,
            ':SUPL_MAIN_CITY' =>$maincity,
            ':SUPL_MAIN_CTRY' =>$mainctry,
            ':SUPL_MAIN_PHNE' =>$mainphne,
            ':SUPL_MAIN_FAXI' =>$mainfaxi,
            ':SUPL_MAIN_MAIL' =>$mainmail,
            ':SUPL_MAIN_WEBS' =>$mainwebs,
            ':SUPL_MAIN_PERS' =>$mainpers,
            ':SUPL_MAIN_TIDN' =>$maintidn,
            ':SUPL_MAIN_TERM' =>$mainterm,
            ':SUPL_ESTI_ARRV' =>$estiarrv,
            ':SUPL_ESTI_DELI' =>$estideli,
            ':SUPL_PAYA_LIMT' =>$payalimt,
            ':SUPL_BANK_CODE' =>$bankcode,
            ':SUPL_AVAI_FRWD' =>$avaifrwd,
            ':SUPL_VIEW_STAT' =>$viewstat,

            ':SUPL_ENTR_DATE' =>$dateinput,
            ':SUPL_ENTR_TIME' =>$timeinput,
            ':SUPL_ENTR_USER' =>$userid, 
            ':SUPL_UPDT_DATE' =>$dateinput,
            ':SUPL_UPDT_TIME' =>$timeinput,
            ':SUPL_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: SUPLMAST01.php");
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