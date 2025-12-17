<?php
session_start();
include "conf/config.php";
include 'inc/sanie.php';

//$rawdata='PO-0001|0001|BOX|10|BTCH-39287|xxx|2021-06-29|OBTT|00010508';
$rawdata = xss_clean($_POST['q']);
list($proccode,$partcode,$unitcode,$xqutyrcve,$procbtch,$procsrnm,$arrvrequ,$warecode,$exprdate,$emplcode) = explode("|", $rawdata);
$qutyrcve = str_replace(".","",$xqutyrcve);
$viewstat = 'I';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

// ambil nilai tipe item dan nama item dan harga item dari transaksi PO
$queryinvemast = "SELECT INVE_MAIN_TYPE, INVE_PART_TYPE, INVE_PART_NAME, 
(SELECT ITEM_PART_PRIC FROM itemproc WHERE ITEM_PROC_CODE='$proccode' AND ITEM_PART_CODE='$partcode' LIMIT 1) AS STOCK_PRIC 
FROM invemast 
                WHERE INVE_MAST_CODE='$partcode'";


$qinvemast = $db->query($queryinvemast) or die("Gagal ambil data master item!!");
$row = $qinvemast->fetch(PDO::FETCH_ASSOC);

$stocktype = $row['INVE_MAIN_TYPE'];
$parttype = $row['INVE_PART_TYPE'];
$stockname = $row['INVE_PART_NAME'];
$stockpric = $row['STOCK_PRIC'];

$input = "INSERT INTO investock (
        INVE_STOCK_CODE, INVE_PROC_CODE, INVE_STOCK_TYPE, 
        INVE_STOCK_BTCH, INVE_STOCK_SRNM, INVE_STOCK_NAME, 
        INVE_WARE_CODE, INVE_STOCK_PRIC, INVE_STOCK_QUTY, 
        INVE_EXPR_DATE, INVE_VIEW_STAT,
        INVE_ENTR_DATE, INVE_ENTR_TIME, INVE_ENTR_USER,  
        INVE_UPDT_DATE, INVE_UPDT_TIME, INVE_UPDT_USER) 
        VALUES (
        :INVE_STOCK_CODE, :INVE_PROC_CODE, :INVE_STOCK_TYPE, 
        :INVE_STOCK_BTCH, :INVE_STOCK_SRNM, :INVE_STOCK_NAME,
        :INVE_WARE_CODE, :INVE_STOCK_PRIC, :INVE_STOCK_QUTY, 
        :INVE_EXPR_DATE, :INVE_VIEW_STAT,
        :INVE_ENTR_DATE, :INVE_ENTR_TIME, :INVE_ENTR_USER,  
        :INVE_UPDT_DATE, :INVE_UPDT_TIME, :INVE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':INVE_STOCK_CODE' =>$partcode,':INVE_PROC_CODE' =>$proccode,':INVE_STOCK_TYPE' =>$stocktype,
        ':INVE_STOCK_BTCH' =>$procbtch,':INVE_STOCK_SRNM' =>$procsrnm, ':INVE_STOCK_NAME' =>$stockname, 
        ':INVE_WARE_CODE' =>$warecode,':INVE_STOCK_PRIC' =>$stockpric,':INVE_STOCK_QUTY' =>$qutyrcve,
        ':INVE_EXPR_DATE' =>$exprdate,':INVE_VIEW_STAT' =>$viewstat,                   
        ':INVE_ENTR_DATE' =>$dateinput, ':INVE_ENTR_TIME' =>$timeinput, ':INVE_ENTR_USER' =>$userid,
        ':INVE_UPDT_DATE' =>$dateinput, ':INVE_UPDT_TIME' =>$timeinput, ':INVE_UPDT_USER' =>$userid));  
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();    
// Hitung total item pada tabel investock yang baru aja di masukkan

$querytotqty = "SELECT SUM(INVE_STOCK_QUTY) AS TOTAL_QUTY FROM investock 
                WHERE INVE_STOCK_CODE='$partcode' AND INVE_VIEW_STAT='I'";

$qtotqty = $db->query($querytotqty) or die("Gagal hitung stock terakhir!!");
$k = $qtotqty->fetch(PDO::FETCH_ASSOC);

$stockquty = $k['TOTAL_QUTY'];

// Update pada Kolom Penyerahan Item yang sudah di beli pada tabel Item PO 
$update = "UPDATE itemproc SET ITEM_QUTY_RCVE='$stockquty', 
            ITEM_PROC_BTCH='$procbtch', 
            ITEM_PROC_SRNM='$procsrnm',
            ITEM_EMPL_CODE='$emplcode',
                    ITEM_UPDT_DATE='$dateinput',
                    ITEM_UPDT_TIME='$timeinput',
                    ITEM_UPDT_USER='$userid'    
            WHERE ITEM_PROC_CODE='$proccode' AND ITEM_PART_CODE='$partcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

?>      
