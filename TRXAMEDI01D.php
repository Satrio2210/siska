<?php
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $medicode = $_POST['q'];
  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE tblfmedi SET TBLF_MEDI_ACTI='N', TBLF_VIEW_STAT='N',
                    TBLF_UPDT_DATE='$dateinput',
                    TBLF_UPDT_TIME='$timeinput',
                    TBLF_UPDT_USER='$userid'    
				WHERE TBLF_MEDI_CODE='$medicode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
    }
//}
//else
//{
//  header("Location: "."index.php");
//}
?>