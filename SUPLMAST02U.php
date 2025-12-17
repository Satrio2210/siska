<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtmastcode']))
    {
        $mastcode = $_POST['txtmastcode'];

        if(isset($_POST['txtmainname']) && ($_POST['txtmainname'] != '')) 
        {
         $mainname = $_POST['txtmainname'];
        }

        if(isset($_POST['txtmainaddr']) && ($_POST['txtmainaddr'] != ''))
        { $mainaddr = $_POST['txtmainaddr']; }

        if(isset($_POST['txtmaincity']) && ($_POST['txtmaincity'] != ''))
        { $maincity = $_POST['txtmaincity']; }

        if(isset($_POST['txtmainctry']) && ($_POST['txtmainctry'] != ''))
        { $mainctry = $_POST['txtmainctry']; }


        if(isset($_POST['txtmainphne']) && ($_POST['txtmainphne'] != '')) 
        {
         $mainphne = $_POST['txtmainphne'];
        }

        if(isset($_POST['txtmainfaxi']) && ($_POST['txtmainfaxi'] != '')) 
        {
         $mainfaxi = $_POST['txtmainfaxi'];
        }

        if(isset($_POST['txtmainmail']) && ($_POST['txtmainmail'] != '')) 
        {
         $mainmail = $_POST['txtmainmail'];
        }

        if(isset($_POST['txtmainwebs']) && ($_POST['txtmainwebs'] != '')) 
        {
         $mainwebs = $_POST['txtmainwebs'];
        }

        if(isset($_POST['txtmainpers']) && ($_POST['txtmainpers'] != '')) 
        {
         $mainpers = $_POST['txtmainpers'];
        }

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
  
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
//|||||||||||$tblminvc|$tblmcomp|$tblmprdc|

        $update = "UPDATE suplmast SET SUPL_MAIN_NAME='$mainname', 
                    SUPL_MAIN_ADDR='$mainaddr',
				    SUPL_MAIN_CITY='$maincity',
                    SUPL_MAIN_CTRY='$mainctry',
                    SUPL_MAIN_PHNE='$mainphne',
                    SUPL_MAIN_FAXI='$mainfaxi',
                    SUPL_MAIN_MAIL='$mainmail',
                    SUPL_MAIN_WEBS='$mainwebs',
                    SUPL_MAIN_PERS='$mainpers',
                    SUPL_MAIN_TIDN='$maintidn',
                    SUPL_MAIN_TERM='$mainterm',
                    SUPL_ESTI_ARRV='$estiarrv',
                    SUPL_ESTI_DELI='$estideli',
                    SUPL_PAYA_LIMT='$payalimt',
                    SUPL_BANK_CODE='$bankcode',
                    SUPL_AVAI_FRWD='$avaifrwd',
                    SUPL_UPDT_DATE='$dateinput',
                    SUPL_UPDT_TIME='$timeinput',
                    SUPL_UPDT_USER='$userid'    
				WHERE SUPL_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: SUPLMAST02.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>