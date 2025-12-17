<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtproccode']) && ($_POST['txtproccode'] != ''))
    {
        $proccode = $_POST['txtproccode'];

        if(isset($_POST['tglprocdate']) && ($_POST['tglprocdate'] != ''))  {$procdate = $_POST['tglprocdate'];}//ok
        if(isset($_POST['tglprocdued']) && ($_POST['tglprocdued'] != ''))  {$procdued = $_POST['tglprocdued'];}//ok
        if(isset($_POST['hidprocdivi']) && ($_POST['hidprocdivi'] != ''))  {$procdivi = $_POST['hidprocdivi'];}//ok
        if(isset($_POST['hidsuplcode']) && ($_POST['hidsuplcode'] != ''))  {$suplcode = $_POST['hidsuplcode'];}//ok
        if(isset($_POST['hidprocfrob']) && ($_POST['hidprocfrob'] != ''))  {$procfrob = $_POST['hidprocfrob'];}//ok
        if(isset($_POST['hidprocvatx']) && ($_POST['hidprocvatx'] != ''))  {$procvatx = $_POST['hidprocvatx'];}//ok
        if(isset($_POST['hidproctype']) && ($_POST['hidproctype'] != ''))  {$proctype = $_POST['hidproctype'];}//ok
        if(isset($_POST['opttermpaid']) && ($_POST['opttermpaid'] != ''))  {$termpaid = $_POST['opttermpaid'];}//ok
        if(isset($_POST['txtdownpaid']) && ($_POST['txtdownpaid'] != ''))  {$xdownpaid = $_POST['txtdownpaid'];}//ok
        if(isset($_POST['txtprocterm']) && ($_POST['txtprocterm'] != ''))  {$procterm = $_POST['txtprocterm'];}//ok
        $downpaid = str_replace(".","",$xdownpaid);

        $update = "UPDATE trxaproc SET  TRXA_PROC_DATE='$procdate', 
                                        TRXA_PROC_DUED='$procdued', 
                                        TRXA_PROC_DIVI='$procdivi', 
                                        TRXA_PROC_STAT='OP', 
                                        TRXA_SUPL_CODE='$suplcode', 
                                        TRXA_PROC_FROB='$procfrob', 
                                        TRXA_PROC_VATX='$procvatx', 
                                        TRXA_PROC_TYPE='$proctype', 
                                        TRXA_TERM_PAID='$termpaid',
                                        TRXA_DOWN_PAID='$downpaid', 
                                        TRXA_REMA_PAID=((SELECT SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) FROM itemproc WHERE ITEM_PROC_CODE='$proccode') - ' $downpaid'), 
                                        TRXA_PROC_TERM='$procterm' 
                    WHERE TRXA_PROC_CODE='$proccode'";


                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: TRXAPROC01.php");
    
    }
}
//else
//{
//  header("Location: "."index.php");
//}
?>