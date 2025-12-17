<?php
session_start();
include "conf/config.php";
include "inc/sanie.php";

$execcode = xss_clean($_POST['q']);
//$execcode = 'EX-0001';

//$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

// Ambil data item yang akan dipindahkan
$query = "SELECT ITEM_EXEC_CODE,  
        ITEM_STOCK_CODE, ITEM_STOCK_NAME, ITEM_STOCK_QUTY,
        ITEM_PART_UNIT, ITEM_STOCK_SRNM, ITEM_STOCK_BTCH,
        ITEM_CART_CODE, ITEM_DIMM_CODE,
        (SELECT INVE_PROC_CODE FROM investock WHERE INVE_STOCK_CODE = ITEM_STOCK_CODE AND INVE_STOCK_BTCH = ITEM_STOCK_BTCH
        AND INVE_STOCK_QUTY > 0) AS PROC_CODE,
        (SELECT INVE_MAIN_TYPE FROM invemast WHERE INVE_MAST_CODE = ITEM_STOCK_CODE) AS STOCK_TYPE,
        (SELECT TRXA_WARE_FROM FROM trxaexec WHERE TRXA_EXEC_CODE = '$execcode') AS WARE_FROM,
        (SELECT TRXA_WARE_DEST FROM trxaexec WHERE TRXA_EXEC_CODE = '$execcode') AS WARE_DEST,
        (SELECT INVE_STOCK_PRIC FROM investock WHERE INVE_STOCK_CODE = ITEM_STOCK_CODE AND INVE_STOCK_BTCH = ITEM_STOCK_BTCH
        AND INVE_STOCK_QUTY > 0) AS STOCK_PRIC 
        FROM itemexec
WHERE ITEM_EXEC_CODE = '$execcode' AND ITEM_VIEW_STAT='Y'
";

$q = $db->query($query) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
    $stockcode = $k['ITEM_STOCK_CODE'];
    $proccode = $k['PROC_CODE'];
    $stocktype = $k['STOCK_TYPE'];
    $stocksrnm = $k['ITEM_STOCK_SRNM'];
    $stockbtch = $k['ITEM_STOCK_BTCH'];
    $stockname = $k['ITEM_STOCK_NAME'];
    $warefrom = $k['WARE_FROM'];
    $waredest = $k['WARE_DEST'];
    $stockpric = $k['STOCK_PRIC'];
    $stockquty = $k['ITEM_STOCK_QUTY']; 

    $periksastatus = "SELECT INVE_EXPR_DATE, INVE_VIEW_STAT FROM investock 
                          WHERE INVE_STOCK_BTCH = '$stockbtch' 
                    AND INVE_WARE_CODE = '$warefrom' 
                    AND INVE_STOCK_CODE = '$stockcode'";

    $periksastatus_di_query=$db->query($periksastatus) or die ("Status gagal");
    $get = $periksastatus_di_query->fetch(PDO::FETCH_ASSOC);

    $exprdate = $get['INVE_EXPR_DATE'];
    $viewstat = $get['INVE_VIEW_STAT']; 

    $periksastock = "SELECT COUNT(*) FROM investock 
                    WHERE INVE_STOCK_BTCH = '$stockbtch' 
                    AND INVE_WARE_CODE = '$waredest' 
                    AND INVE_STOCK_CODE = '$stockcode'";

    $periksastock_di_query=$db->query($periksastock) or die ("Stock gagal");
    $ketersediaan = $periksastock_di_query->fetchColumn();

//Cek adanya item pada WareHouse Tujuan apakahsudah pernah di input

    if ($ketersediaan == 0)
    {

    $datapenerima = "INSERT INTO investock (
        INVE_STOCK_CODE, INVE_PROC_CODE, INVE_STOCK_TYPE, 
        INVE_STOCK_SRNM, INVE_STOCK_BTCH, INVE_STOCK_NAME, 
        INVE_WARE_CODE, INVE_STOCK_PRIC, INVE_STOCK_QUTY,
        INVE_EXPR_DATE, INVE_VIEW_STAT,
        INVE_ENTR_DATE, INVE_ENTR_TIME, INVE_ENTR_USER,  
        INVE_UPDT_DATE, INVE_UPDT_TIME, INVE_UPDT_USER) 
        VALUES (
        :INVE_STOCK_CODE, :INVE_PROC_CODE, :INVE_STOCK_TYPE, 
        :INVE_STOCK_SRNM, :INVE_STOCK_BTCH, :INVE_STOCK_NAME, 
        :INVE_WARE_CODE, :INVE_STOCK_PRIC, :INVE_STOCK_QUTY,
        :INVE_EXPR_DATE, :INVE_VIEW_STAT,
        :INVE_ENTR_DATE, :INVE_ENTR_TIME, :INVE_ENTR_USER,  
        :INVE_UPDT_DATE, :INVE_UPDT_TIME, :INVE_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($datapenerima);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':INVE_STOCK_CODE' =>$stockcode, ':INVE_PROC_CODE' =>$proccode, ':INVE_STOCK_TYPE' =>$stocktype, 
        ':INVE_STOCK_SRNM' =>$stocksrnm, ':INVE_STOCK_BTCH' =>$stockbtch, ':INVE_STOCK_NAME' =>$stockname,
        ':INVE_WARE_CODE' =>$waredest, ':INVE_STOCK_PRIC' =>$stockpric, ':INVE_STOCK_QUTY' =>$stockquty,
        ':INVE_EXPR_DATE' =>$exprdate, ':INVE_VIEW_STAT' =>$viewstat,                   
        ':INVE_ENTR_DATE' =>$dateinput,':INVE_ENTR_TIME' =>$timeinput,':INVE_ENTR_USER' =>$userid,
        ':INVE_UPDT_DATE' =>$dateinput,':INVE_UPDT_TIME' =>$timeinput,':INVE_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Update item stock pada gudang pengirim
        $datapengirim = "UPDATE investock SET INVE_STOCK_QUTY = INVE_STOCK_QUTY - $stockquty
                        WHERE INVE_STOCK_BTCH = '$stockbtch' 
                        AND INVE_WARE_CODE = '$warefrom' 
                        AND INVE_STOCK_CODE = '$stockcode'";

        $query_update = $db->prepare($datapengirim);

        $db->beginTransaction();
        $query_update->execute();
        $db->commit();

    }
    else
    {
        // Update item stock pada gudang penerima
        $datapenerima = "UPDATE investock SET INVE_STOCK_QUTY = INVE_STOCK_QUTY + '$stockquty'
                        WHERE INVE_STOCK_BTCH = '$stockbtch' 
                        AND INVE_WARE_CODE = '$waredest' 
                        AND INVE_STOCK_CODE = '$stockcode'";

        $query_input = $db->prepare($datapenerima);

        $db->beginTransaction();
        $query_input->execute();
        $db->commit();


        // Update item stock pada gudang pengirim
        $datapengirim = "UPDATE investock SET INVE_STOCK_QUTY = INVE_STOCK_QUTY - '$stockquty'
                        WHERE INVE_STOCK_BTCH = '$stockbtch' 
                        AND INVE_WARE_CODE = '$warefrom' 
                        AND INVE_STOCK_CODE = '$stockcode'";

        $query_update = $db->prepare($datapengirim);

        $db->beginTransaction();
        $query_update->execute();
        $db->commit();
    }
}

//Update status item yang dikirim menjadi item sudah diterima
$update_status = "UPDATE trxaexec SET TRXA_EXEC_STAT = 'C'
                WHERE TRXA_EXEC_CODE = '$execcode'";

$query_update = $db->prepare($update_status);

$db->beginTransaction();
$query_update->execute();
$db->commit();

// ambil kode request awal
$query_get_requ = "SELECT TRXA_REQU_CODE FROM trxaexec
WHERE TRXA_EXEC_CODE = '$execcode' AND TRXA_VIEW_STAT='Y'";

$q_get_requ = $db->query($query_get_requ) or die("Gagal ambil data code request !!");
$row_requ = $q_get_requ->fetch(PDO::FETCH_ASSOC);
$requcode = $row_requ['TRXA_REQU_CODE'];


//Update status item request agar tidak muncul lagi di halaman aproval
$update_request = "UPDATE trxarequ SET TRXA_REQU_STAT = 'X'
                WHERE TRXA_REQU_CODE = '$requcode'";

$query_request = $db->prepare($update_request);

$db->beginTransaction();
$query_request->execute();
$db->commit();

?>      
