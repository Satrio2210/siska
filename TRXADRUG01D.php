<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
//{

include "conf/config.php";
if (isset($_POST['q']))
    {
        $rawdata = $_POST['q'];
        list($prsccode, $stockcode) = explode("|",$rawdata);

  
        $userid = $_SESSION['username'];
        $dateinput = date("Y-m-d");
        $timeinput = date("G:i:s");

  		$periksastatus = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_REGI_CODE='$prsccode' 
                     AND TRXA_REGI_STAT='X'
                     AND TRXA_VIEW_STAT='Y'";

  		$periksastatus_di_query=$db->query($periksastatus) or die ("Cek Fail Status Pasien");
  		$ketersediaan_status = $periksastatus_di_query->fetchColumn();

  		if ($ketersediaan_status == 0)
  		{
  			$status_item = 'A';
  		}
  		else
  		{
  			$status_item = 'C';
  		}

        $update = "UPDATE trxaprsc SET TRXA_PRSC_STAT='$status_item',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
				WHERE TRXA_PRSC_CODE='$prsccode' AND TRXA_STOCK_CODE='$stockcode' AND TRXA_VIEW_STAT='Y'";
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