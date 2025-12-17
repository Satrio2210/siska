<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');

//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtprntcode']) && ($_POST['txtmastcode']))
    {

        if(isset($_POST['txtprntcode']) && ($_POST['txtprntcode'] != ''))
        { $mastprnt = $_POST['txtprntcode']; }

        if(isset($_POST['txtmastcode']) && ($_POST['txtmastcode'] != '')) 
        {
         $mastcode = $_POST['txtmastcode'];
        }

        if(isset($_POST['txtmastname']) && ($_POST['txtmastname'] != '')) 
        {
         $mastname = $_POST['txtmastname'];
        }

        if(isset($_POST['hidmastcosg']) && ($_POST['hidmastcosg'] != ''))  
        {$mastcosg = $_POST['hidmastcosg'];}
        else
        {$mastcosg = 'N';} //ok


        if(isset($_POST['hidmaststat']) && ($_POST['hidmaststat'] != '')) 
        {
         $maststat = $_POST['hidmaststat'];
        }

        if(isset($_POST['hidnormblnc']) && ($_POST['hidnormblnc'] != '')) 
        {
         $normblnc = $_POST['hidnormblnc'];
        }

        if(isset($_POST['hidfnrpstat']) && ($_POST['hidfnrpstat'] != ''))
        { $fnrpstat = $_POST['hidfnrpstat']; }


        if(isset($_POST['txtmastnote']) && ($_POST['txtmastnote'] != '')) 
        {
         $mastnote = $_POST['txtmastnote'];
        }

        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE coacmast SET 
				    COAC_MAST_NAME='$mastname',
                    COAC_MAST_COSG='$mastcosg',
                    COAC_MAST_STAT='$maststat',
                    COAC_NORM_BLNC='$normblnc',
                    COAC_FNRP_STAT='$fnrpstat',
                    COAC_MAST_NOTE='$mastnote',

                    COAC_UPDT_DATE='$dateinput',
                    COAC_UPDT_TIME='$timeinput',
                    COAC_UPDT_USER='$userid'    
				WHERE COAC_MAST_CODE='$mastcode'
                AND COAC_MAST_PRNT='$mastprnt'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: COACMAST02.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>