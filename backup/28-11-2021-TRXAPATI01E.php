<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";
      include "inc/sanie.php";

      $mastcode = $_POST['txtmastcode'];
      $mainpidn = $_POST['txtmainpidn'];

      if(isset($_POST['hidmaintitl']) && ($_POST['hidmaintitl'] != ''))  {$maintitl = $_POST['hidmaintitl'];}//ok
      if(isset($_POST['txtmainname']) && ($_POST['txtmainname'] != ''))  {$mainname = $_POST['txtmainname'];}//ok

      if(isset($_POST['hidmaingend']) && ($_POST['hidmaingend'] != ''))  {$maingend = $_POST['hidmaingend'];}//ok

      if(isset($_POST['tglmainbirt']) && ($_POST['tglmainbirt'] != ''))  {$mainbirt = $_POST['tglmainbirt'];}//ok

      if(isset($_POST['hidmainblod']) && ($_POST['hidmainblod'] != ''))  {$mainblod = $_POST['hidmainblod'];}//ok

      if(isset($_POST['txtmainaddr']) && ($_POST['txtmainaddr'] != ''))  {$mainaddr = xss_clean($_POST['txtmainaddr']);}//ok
      if(isset($_POST['txtmainward']) && ($_POST['txtmainward'] != ''))  {$mainward = $_POST['txtmainward'];}//ok
      if(isset($_POST['txtmaindist']) && ($_POST['txtmaindist'] != ''))  {$maindist = $_POST['txtmaindist'];}//ok
      if(isset($_POST['txtmaincity']) && ($_POST['txtmaincity'] != ''))  {$maincity = $_POST['txtmaincity'];}//ok
      if(isset($_POST['txtmainprov']) && ($_POST['txtmainprov'] != ''))  {$mainprov = $_POST['txtmainprov'];}//ok
      if(isset($_POST['txtmainreli']) && ($_POST['txtmainreli'] != ''))  {$mainreli = $_POST['txtmainreli'];}//ok
      if(isset($_POST['hidmainctzn']) && ($_POST['hidmainctzn'] != ''))  {$mainctzn = $_POST['hidmainctzn'];}//ok
      if(isset($_POST['optmainstat']) && ($_POST['optmainstat'] != ''))  {$mainstat = $_POST['optmainstat'];}//ok

      if(isset($_POST['txtmainprof']) && ($_POST['txtmainprof'] != ''))  {$mainprof = $_POST['txtmainprof'];}        
      if(isset($_POST['optmaineduc']) && ($_POST['optmaineduc'] != ''))  {$maineduc = $_POST['optmaineduc'];}//ok        

      if(isset($_POST['txtmainphne']) && ($_POST['txtmainphne'] != ''))  {$mainphne = $_POST['txtmainphne'];}

      if(isset($_POST['txtmainmail']) && ($_POST['txtmainmail'] != ''))  {$mainmail = $_POST['txtmainmail'];}

      if(isset($_POST['txtmainprnt']) && ($_POST['txtmainprnt'] != ''))  {$mainprnt = $_POST['txtmainprnt'];}

      $viewstat = 'Y';
      $dateinput = date("y-m-d");
      $timeinput = date("G:i:s");
      $userid = $_SESSION['username'];

      $periksamastcode = "SELECT COUNT(*) FROM patimast WHERE PATI_MAIN_PIDN='$mainpidn'";
      $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
      $ketersediaan = $periksamastcode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pasien baru
      if ($ketersediaan == 0)
      {

        $input = "INSERT INTO patimast (
        PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_TITL, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
        PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_WARD, PATI_MAIN_DIST, PATI_MAIN_CITY, PATI_MAIN_PROV,
        PATI_MAIN_RELI, PATI_MAIN_CTZN, PATI_MAIN_STAT, PATI_MAIN_PROF, PATI_MAIN_EDUC, PATI_MAIN_PHNE, 
        PATI_MAIN_MAIL, PATI_MAIN_PRNT, PATI_VIEW_STAT,
        PATI_ENTR_DATE, PATI_ENTR_TIME, PATI_ENTR_USER, PATI_UPDT_DATE, PATI_UPDT_TIME, PATI_UPDT_USER) 
        VALUES (
        :PATI_MAST_CODE, :PATI_MAIN_PIDN, :PATI_MAIN_TITL, :PATI_MAIN_NAME, :PATI_MAIN_GEND, :PATI_MAIN_BIRT, 
        :PATI_MAIN_BLOD, :PATI_MAIN_ADDR, :PATI_MAIN_WARD, :PATI_MAIN_DIST, :PATI_MAIN_CITY, :PATI_MAIN_PROV,
        :PATI_MAIN_RELI, :PATI_MAIN_CTZN, :PATI_MAIN_STAT, :PATI_MAIN_PROF, :PATI_MAIN_EDUC, :PATI_MAIN_PHNE, 
        :PATI_MAIN_MAIL, :PATI_MAIN_PRNT, :PATI_VIEW_STAT,
        :PATI_ENTR_DATE, :PATI_ENTR_TIME, :PATI_ENTR_USER, :PATI_UPDT_DATE, :PATI_UPDT_TIME, :PATI_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':PATI_MAST_CODE' =>$mastcode, ':PATI_MAIN_PIDN' =>$mainpidn, ':PATI_MAIN_TITL' =>$maintitl, 
        ':PATI_MAIN_NAME' =>$mainname, ':PATI_MAIN_GEND' =>$maingend, ':PATI_MAIN_BIRT' =>$mainbirt,
        ':PATI_MAIN_BLOD' =>$mainblod, ':PATI_MAIN_ADDR' =>$mainaddr, ':PATI_MAIN_WARD' =>$mainward, 
        ':PATI_MAIN_DIST' =>$maindist, ':PATI_MAIN_CITY' =>$maincity, ':PATI_MAIN_PROV' =>$mainprov,
        ':PATI_MAIN_RELI' =>$mainreli, ':PATI_MAIN_CTZN' =>$mainctzn, ':PATI_MAIN_STAT' =>$mainstat, 
        ':PATI_MAIN_PROF' =>$mainprof, ':PATI_MAIN_EDUC' =>$maineduc, ':PATI_MAIN_PHNE' =>$mainphne, 
        ':PATI_MAIN_MAIL' =>$mainmail, ':PATI_MAIN_PRNT' =>$mainprnt, ':PATI_VIEW_STAT' =>$viewstat,
        ':PATI_ENTR_DATE' =>$dateinput,':PATI_ENTR_TIME' =>$timeinput,':PATI_ENTR_USER' =>$userid, 
        ':PATI_UPDT_DATE' =>$dateinput,':PATI_UPDT_TIME' =>$timeinput,':PATI_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: TRXAPATI01.php");
      }
      else
      {
        $update = "UPDATE patimast SET PATI_MAIN_TITL='$maintitl', PATI_MAIN_NAME='$mainname', 
                  PATI_MAIN_GEND='$maingend',  PATI_MAIN_BIRT='$mainbirt', PATI_MAIN_BLOD='$mainblod', 
                  PATI_MAIN_ADDR='$mainaddr',  PATI_MAIN_WARD='$mainward', PATI_MAIN_DIST='$maindist', 
                  PATI_MAIN_CITY='$maincity',  PATI_MAIN_PROV='$mainprov', PATI_MAIN_RELI='$mainreli', 
                  PATI_MAIN_CTZN='$mainctzn',  PATI_MAIN_STAT='$mainstat', PATI_MAIN_PROF='$mainprof', 
                  PATI_MAIN_EDUC='$maineduc',  PATI_MAIN_PHNE='$mainphne', PATI_MAIN_MAIL='$mainmail', 
                  PATI_MAIN_PRNT='$mainprnt', 
                  PATI_UPDT_DATE='$dateinput', PATI_UPDT_TIME='$timeinput',PATI_UPDT_USER='$userid'    
            WHERE PATI_MAIN_PIDN='$mainpidn'";

                // Prepare Request  
        $query_update = $db->prepare($update);

                // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

         header("location: TRXAPATI01.php");
      }
}
else
{
  header("location: "."index.php");
}
?>