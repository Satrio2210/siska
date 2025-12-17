<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";

      $mastcode = $_POST['txtmastcode'];

      $periksamastcode = "SELECT COUNT(*) FROM emplmast WHERE EMPL_MAST_CODE='$mastcode'";
      $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
      $ketersediaan = $periksamastcode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode suplier baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['txtfrstname']) && ($_POST['txtfrstname'] != ''))  {$frstname = $_POST['txtfrstname'];}//ok
        if(isset($_POST['txtlastname']) && ($_POST['txtlastname'] != ''))  {$lastname = $_POST['txtlastname'];}//ok

        if(isset($_POST['hidmaingend']) && ($_POST['hidmaingend'] != ''))  {$maingend = $_POST['hidmaingend'];}//ok
        if(isset($_POST['tglmainbirt']) && ($_POST['tglmainbirt'] != ''))  {$mainbirt = $_POST['tglmainbirt'];}//ok
        if(isset($_POST['hidmainblod']) && ($_POST['hidmainblod'] != ''))  {$mainblod = $_POST['hidmainblod'];}//ok

        if(isset($_POST['txtfngrcode']) && ($_POST['txtfngrcode'] != ''))  {$fngrcode = $_POST['txtfngrcode'];}//ok

        if(isset($_POST['txtmaintidn1']) && ($_POST['txtmaintidn1'] != ''))  {$maintidn1 = $_POST['txtmaintidn1'];}//ok
        if(isset($_POST['txtmaintidn2']) && ($_POST['txtmaintidn2'] != ''))  {$maintidn2 = $_POST['txtmaintidn2'];}//ok
        if(isset($_POST['txtmaintidn3']) && ($_POST['txtmaintidn3'] != ''))  {$maintidn3 = $_POST['txtmaintidn3'];}//ok
        if(isset($_POST['txtmaintidn4']) && ($_POST['txtmaintidn4'] != ''))  {$maintidn4 = $_POST['txtmaintidn4'];}//ok
        if(isset($_POST['txtmaintidn5']) && ($_POST['txtmaintidn5'] != ''))  {$maintidn5 = $_POST['txtmaintidn5'];}//ok
        if(isset($_POST['txtmaintidn6']) && ($_POST['txtmaintidn6'] != ''))  {$maintidn6 = $_POST['txtmaintidn6'];}//ok

        if(isset($_POST['optmainstat']) && ($_POST['optmainstat'] != ''))  {$mainstat = $_POST['optmainstat'];}//ok

        if(isset($_POST['txtmktpaddr']) && ($_POST['txtmktpaddr'] != ''))  {$mktpaddr = $_POST['txtmktpaddr'];}//ok
        if(isset($_POST['txtmktpcity']) && ($_POST['txtmktpcity'] != ''))  {$mktpcity = $_POST['txtmktpcity'];}//ok
        if(isset($_POST['txtmktpprov']) && ($_POST['txtmktpprov'] != ''))  {$mktpprov = $_POST['txtmktpprov'];}//ok
        if(isset($_POST['txtmktpctry']) && ($_POST['txtmktpctry'] != ''))  {$mktpctry = $_POST['txtmktpctry'];}//ok

        if(isset($_POST['txtmainhp01']) && ($_POST['txtmainhp01'] != ''))  {$mainhp01 = $_POST['txtmainhp01'];}//ok
        if(isset($_POST['txtmainhp02']) && ($_POST['txtmainhp02'] != ''))  {$mainhp02 = $_POST['txtmainhp02'];}//ok

        if(isset($_POST['txtmainmail']) && ($_POST['txtmainmail'] != ''))  {$mainmail = $_POST['txtmainmail'];}//ok

        if(isset($_POST['opthigheduc']) && ($_POST['opthigheduc'] != ''))  {$higheduc = $_POST['opthigheduc'];}//ok
        if(isset($_POST['txtlastschl']) && ($_POST['txtlastschl'] != ''))  {$lastschl = $_POST['txtlastschl'];}//ok

        if(isset($_POST['hiddocustat']) && ($_POST['hiddocustat'] != ''))  
        {$docustat = $_POST['hiddocustat'];}
        else
        {$docustat = 'N';} //ok

        if(isset($_POST['txtmainhobi']) && ($_POST['txtmainhobi'] != ''))  {$mainhobi = $_POST['txtmainhobi'];}//ok

        if(isset($_POST['tglhiredate']) && ($_POST['tglhiredate'] != ''))  {$hiredate = $_POST['tglhiredate'];}//ok
        if(isset($_POST['tglactidate']) && ($_POST['tglactidate'] != ''))  {$actidate = $_POST['tglactidate'];}//ok


        if(isset($_POST['hidmaindivi']) && ($_POST['hidmaindivi'] != ''))  {$maindivi = $_POST['hidmaindivi'];}//ok
        if(isset($_POST['hidmainpstn']) && ($_POST['hidmainpstn'] != ''))  {$mainpstn = $_POST['hidmainpstn'];}//ok

        if(isset($_POST['hidbankcode']) && ($_POST['hidbankcode'] != ''))  {$bankcode = $_POST['hidbankcode'];}//ok

        if(isset($_POST['txtbankacct']) && ($_POST['txtbankacct'] != ''))  {$bankacct = $_POST['txtbankacct'];}//ok


        if(isset($_POST['txtbankpers']) && ($_POST['txtbankpers'] != ''))  {$bankpers = $_POST['txtbankpers'];}//ok

        $maintidn = $maintidn1 . '.' . $maintidn2 . '.' . $maintidn3 . '.' . $maintidn4 . '-' . $maintidn5 . '.' . $maintidn6;
        $mainpict = 'user.jpg'; 
        $viewstat = 'Y';
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO emplmast (
        EMPL_MAST_CODE, EMPL_FRST_NAME, EMPL_LAST_NAME, EMPL_MAIN_GEND, EMPL_MAIN_BIRT, EMPL_MAIN_BLOD, 
        EMPL_FNGR_CODE, EMPL_MAIN_TIDN, EMPL_MAIN_STAT, EMPL_MKTP_ADDR, EMPL_MKTP_CITY, EMPL_MKTP_PROV, 
        EMPL_MKTP_CTRY, EMPL_MAIN_HP01, EMPL_MAIN_HP02, EMPL_MAIN_MAIL, EMPL_HIGH_EDUC, EMPL_LAST_SCHL, 
        EMPL_DOCU_STAT, EMPL_MAIN_HOBI, EMPL_HIRE_DATE, EMPL_ACTI_DATE, EMPL_MAIN_DIVI, EMPL_MAIN_PSTN, 
        EMPL_MAIN_PICT, EMPL_BANK_CODE, EMPL_BANK_ACCT, EMPL_BANK_PERS, EMPL_VIEW_STAT, 
        EMPL_ENTR_DATE, EMPL_ENTR_TIME, EMPL_ENTR_USER, EMPL_UPDT_DATE, EMPL_UPDT_TIME, EMPL_UPDT_USER) 
        VALUES (
        :EMPL_MAST_CODE, :EMPL_FRST_NAME, :EMPL_LAST_NAME, :EMPL_MAIN_GEND, :EMPL_MAIN_BIRT, :EMPL_MAIN_BLOD, 
        :EMPL_FNGR_CODE, :EMPL_MAIN_TIDN, :EMPL_MAIN_STAT, :EMPL_MKTP_ADDR, :EMPL_MKTP_CITY, :EMPL_MKTP_PROV, 
        :EMPL_MKTP_CTRY, :EMPL_MAIN_HP01, :EMPL_MAIN_HP02, :EMPL_MAIN_MAIL, :EMPL_HIGH_EDUC, :EMPL_LAST_SCHL, 
        :EMPL_DOCU_STAT, :EMPL_MAIN_HOBI, :EMPL_HIRE_DATE, :EMPL_ACTI_DATE, :EMPL_MAIN_DIVI, :EMPL_MAIN_PSTN, 
        :EMPL_MAIN_PICT, :EMPL_BANK_CODE, :EMPL_BANK_ACCT, :EMPL_BANK_PERS, :EMPL_VIEW_STAT, 
        :EMPL_ENTR_DATE, :EMPL_ENTR_TIME, :EMPL_ENTR_USER, :EMPL_UPDT_DATE, :EMPL_UPDT_TIME, :EMPL_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':EMPL_MAST_CODE' =>$mastcode, ':EMPL_FRST_NAME' =>$frstname,
        ':EMPL_LAST_NAME' =>$lastname, ':EMPL_MAIN_GEND' =>$maingend,
        ':EMPL_MAIN_BIRT' =>$mainbirt, ':EMPL_MAIN_BLOD' =>$mainblod,  
        ':EMPL_FNGR_CODE' =>$fngrcode, ':EMPL_MAIN_TIDN' =>$maintidn,
        ':EMPL_MAIN_STAT' =>$mainstat, ':EMPL_MKTP_ADDR' =>$mktpaddr,
        ':EMPL_MKTP_CITY' =>$mktpcity, ':EMPL_MKTP_PROV' =>$mktpprov,
        ':EMPL_MKTP_CTRY' =>$mktpctry, ':EMPL_MAIN_HP01' =>$mainhp01,
        ':EMPL_MAIN_HP02' =>$mainhp02, ':EMPL_MAIN_MAIL' =>$mainmail, 
        ':EMPL_HIGH_EDUC' =>$higheduc, ':EMPL_LAST_SCHL' =>$lastschl,
        ':EMPL_DOCU_STAT' =>$docustat, ':EMPL_MAIN_HOBI' =>$mainhobi,
        ':EMPL_HIRE_DATE' =>$hiredate, ':EMPL_ACTI_DATE' =>$actidate, 
        ':EMPL_MAIN_DIVI' =>$maindivi, ':EMPL_MAIN_PSTN' =>$mainpstn, 
        ':EMPL_MAIN_PICT' =>$mainpict, ':EMPL_BANK_CODE' =>$bankcode,
        ':EMPL_BANK_ACCT' =>$bankacct, ':EMPL_BANK_PERS' =>$bankpers,
        ':EMPL_VIEW_STAT' =>$viewstat,
        ':EMPL_ENTR_DATE' =>$dateinput,':EMPL_ENTR_TIME' =>$timeinput, ':EMPL_ENTR_USER' =>$userid, 
        ':EMPL_UPDT_DATE' =>$dateinput,':EMPL_UPDT_TIME' =>$timeinput, ':EMPL_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: EMPLMAST01.php");
      }
      else
      {
         header("location: EMPLMAST01.php");
      }
}
else
{
  header("location: "."index.php");
}
?>