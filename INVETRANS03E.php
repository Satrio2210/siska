<?php
session_start();
include "conf/config.php";
//$rawdata='EX-00004|2021-11-10|RE-0005|2021-11-10|2021-11-10|2021-11-10|BOX2|BOX1|0012|Mersibion 5000 Injeksi|9|AMP|NoSerial|BTCH-75921|10x10|11x11';

$rawdata = $_POST['q'];
//  'EX-00004|  2021-11-10|RE-0005|2021-11-10|2021-11-10|2021-11-10|BOX2|BOX1|         0012|       Mersibion 5000 Injeksi|9|AMP|NoSerial|BTCH-75921|10x10|11x11';

list($execcode,$execdate,$requcode,$estmdate,$trandate,$rcvedate,$warefrom,$waredest,$stockcode,$stockname,$stockquty,$partunit,$stocksrnm,$stockbtch,$cartcode,$dimmcode) = explode("|", $rawdata);

$execstat = 'I';
$viewstat = 'Y';

$userid = $_SESSION['username'];
//$userid = 'ASRUL';
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksainvetrans = "SELECT COUNT(*) FROM trxaexec WHERE TRXA_EXEC_CODE='$execcode'";
$periksainvetrans_di_query=$db->query($periksainvetrans) or die ("Cek Fail");
$ketersediaan = $periksainvetrans_di_query->fetchColumn();
//Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
if ($ketersediaan == 0)
{

$input = "INSERT INTO trxaexec (
        TRXA_EXEC_CODE, TRXA_EXEC_DATE, TRXA_REQU_CODE, TRXA_ESTM_DATE, 
        TRXA_TRAN_DATE, TRXA_RCVE_DATE, TRXA_WARE_FROM, TRXA_WARE_DEST, 
        TRXA_EXEC_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_EXEC_CODE, :TRXA_EXEC_DATE, :TRXA_REQU_CODE, :TRXA_ESTM_DATE, 
        :TRXA_TRAN_DATE, :TRXA_RCVE_DATE, :TRXA_WARE_FROM, :TRXA_WARE_DEST, 
        :TRXA_EXEC_STAT, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
       ':TRXA_EXEC_CODE' =>$execcode,':TRXA_EXEC_DATE' =>$execdate,
       ':TRXA_REQU_CODE' =>$requcode,':TRXA_ESTM_DATE' =>$estmdate,                   
       ':TRXA_TRAN_DATE' =>$trandate,':TRXA_RCVE_DATE' =>$rcvedate,
       ':TRXA_WARE_FROM' =>$warefrom,':TRXA_WARE_DEST' =>$waredest,
       ':TRXA_EXEC_STAT' =>$execstat,':TRXA_VIEW_STAT' =>$viewstat,
       ':TRXA_ENTR_DATE' =>$dateinput, ':TRXA_ENTR_TIME' =>$timeinput, ':TRXA_ENTR_USER' =>$userid,
       ':TRXA_UPDT_DATE' =>$dateinput, ':TRXA_UPDT_TIME' =>$timeinput, ':TRXA_UPDT_USER' =>$userid));  
        ////print_r($db->error_Info());
        ////var_dump($query_input);
        ////exit();
        $db->commit();

$input_item = "INSERT INTO itemexec (
        ITEM_EXEC_CODE, ITEM_STOCK_CODE, ITEM_STOCK_NAME, ITEM_STOCK_QUTY, 
        ITEM_PART_UNIT, ITEM_STOCK_SRNM, ITEM_STOCK_BTCH, ITEM_CART_CODE,
        ITEM_DIMM_CODE, ITEM_VIEW_STAT, 
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER
        ) 
        VALUES (
        :ITEM_EXEC_CODE, :ITEM_STOCK_CODE, :ITEM_STOCK_NAME, :ITEM_STOCK_QUTY, 
        :ITEM_PART_UNIT, :ITEM_STOCK_SRNM, :ITEM_STOCK_BTCH, :ITEM_CART_CODE,
        :ITEM_DIMM_CODE, :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";

        // Prepare Request  
        $query_input_item = $db->prepare($input_item);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_item->execute(array(
       ':ITEM_EXEC_CODE' =>$execcode,':ITEM_STOCK_CODE' =>$stockcode,':ITEM_STOCK_NAME' =>$stockname,':ITEM_STOCK_QUTY' =>$stockquty,                   
       ':ITEM_PART_UNIT' =>$partunit,':ITEM_STOCK_SRNM' =>$stocksrnm,':ITEM_STOCK_BTCH' =>$stockbtch,':ITEM_CART_CODE' =>$cartcode,
       ':ITEM_DIMM_CODE' =>$dimmcode,':ITEM_VIEW_STAT' =>$viewstat,
       ':ITEM_ENTR_DATE' =>$dateinput, ':ITEM_ENTR_TIME' =>$timeinput, ':ITEM_ENTR_USER' =>$userid,
       ':ITEM_UPDT_DATE' =>$dateinput, ':ITEM_UPDT_TIME' =>$timeinput, ':ITEM_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

}
else
{
$update = "UPDATE trxaexec SET TRXA_EXEC_DATE='$execdate',
                  TRXA_REQU_CODE='$requcode', TRXA_ESTM_DATE='$estmdate',
                  TRXA_TRAN_DATE='$trandate', TRXA_RCVE_DATE='$rcvedate',  
                  TRXA_WARE_FROM='$warefrom', TRXA_WARE_DEST='$waredest',                  
                  TRXA_EXEC_STAT='$execstat',
                  TRXA_VIEW_STAT='$viewstat', 
                  TRXA_UPDT_DATE='$dateinput',
                  TRXA_UPDT_TIME='$timeinput',
                  TRXA_UPDT_USER='$userid'    
            WHERE TRXA_EXEC_CODE='$execcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
// Input Item
$input_item = "INSERT INTO itemexec (ITEM_EXEC_CODE, ITEM_STOCK_CODE, ITEM_STOCK_NAME, ITEM_STOCK_QUTY, 
        ITEM_PART_UNIT, ITEM_STOCK_SRNM, ITEM_STOCK_BTCH, ITEM_CART_CODE,
        ITEM_DIMM_CODE, ITEM_VIEW_STAT, 
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER
        ) 
        VALUES (
        :ITEM_EXEC_CODE, :ITEM_STOCK_CODE, :ITEM_STOCK_NAME, :ITEM_STOCK_QUTY, 
        :ITEM_PART_UNIT, :ITEM_STOCK_SRNM, :ITEM_STOCK_BTCH, :ITEM_CART_CODE,
        :ITEM_DIMM_CODE, :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";

        // Prepare Request  
        $query_input_item = $db->prepare($input_item);

        // Mulai Input
        ///var_dump(array(
        //$stockcode,$stockname,$stockquty,$partunit,$stocksrnm,$stockbtch,$cartcode,$dimmcode
        $db->beginTransaction();
        $query_input_item->execute(array(
       ':ITEM_EXEC_CODE' =>$execcode,':ITEM_STOCK_CODE' =>$stockcode,':ITEM_STOCK_NAME' =>$stockname,':ITEM_STOCK_QUTY' =>$stockquty,                   
       ':ITEM_PART_UNIT' =>$partunit,':ITEM_STOCK_SRNM' =>$stocksrnm,':ITEM_STOCK_BTCH' =>$stockbtch,':ITEM_CART_CODE' =>$cartcode,
       ':ITEM_DIMM_CODE' =>$dimmcode,':ITEM_VIEW_STAT' =>$viewstat,
       ':ITEM_ENTR_DATE' =>$dateinput, ':ITEM_ENTR_TIME' =>$timeinput, ':ITEM_ENTR_USER' =>$userid,
       ':ITEM_UPDT_DATE' =>$dateinput, ':ITEM_UPDT_TIME' =>$timeinput, ':ITEM_UPDT_USER' =>$userid));  
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


}

?>      
