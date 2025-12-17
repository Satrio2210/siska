<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];

//$rawdata='ST-0001|KACA|0001|Toor Dal|1|13:14:15';

list($opnacode, $warecode, $stockcode, $stockname, $stockopna, $timecode) = explode("|", $rawdata);

$viewstat = 'Y';

$userid = $_SESSION['username'];
//$userid = 'ASRUL';
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

// ambil data dari investock untuk di input ke tabel itemopna
$sqlstock = "SELECT INVE_STOCK_QUTY,
            (SELECT INVE_MAIN_UNIT FROM invemast WHERE INVE_MAST_CODE = '$stockcode') AS PART_UNIT,
             INVE_STOCK_SRNM, INVE_STOCK_BTCH FROM investock 
             WHERE INVE_STOCK_CODE = '$stockcode'
             AND INVE_WARE_CODE = '$warecode'
             AND INVE_ENTR_TIME = '$timecode'";

$q = $db->query($sqlstock) or die("Gagal Ambil  data investock!!");
$row = $q->fetch(PDO::FETCH_ASSOC);

$stockquty = $row['INVE_STOCK_QUTY'];
$partunit = $row['PART_UNIT'];
$stocksrnm = $row['INVE_STOCK_SRNM'];
$stockbtch = $row['INVE_STOCK_BTCH'];


//Cek adanya data item opname pada tabel itemopna jika tidak ada input jika ada update

$periksainvestock = "SELECT COUNT(*) FROM itemopna WHERE ITEM_OPNA_CODE='$opnacode' 
                     AND ITEM_WARE_CODE='$warecode'
                     AND ITEM_STOCK_CODE='$stockcode'
                     AND ITEM_STOCK_BTCH='$stockbtch'
                     AND ITEM_VIEW_STAT='Y'";

$periksainvestock_di_query=$db->query($periksainvestock) or die ("Cek Fail");

$ketersediaan = $periksainvestock_di_query->fetchColumn();

if ($ketersediaan == 0)
{

$input = "INSERT INTO itemopna (
        ITEM_OPNA_CODE, ITEM_WARE_CODE, ITEM_STOCK_CODE, ITEM_STOCK_NAME, 
        ITEM_STOCK_QUTY, ITEM_PART_UNIT, ITEM_STOCK_SRNM, ITEM_STOCK_BTCH,
        ITEM_STOCK_OPNA, ITEM_VIEW_STAT,
        ITEM_ENTR_DATE, ITEM_ENTR_TIME, ITEM_ENTR_USER,  
        ITEM_UPDT_DATE, ITEM_UPDT_TIME, ITEM_UPDT_USER) 
        VALUES (
        :ITEM_OPNA_CODE, :ITEM_WARE_CODE, :ITEM_STOCK_CODE, :ITEM_STOCK_NAME, 
        :ITEM_STOCK_QUTY, :ITEM_PART_UNIT, :ITEM_STOCK_SRNM, :ITEM_STOCK_BTCH,
        :ITEM_STOCK_OPNA, :ITEM_VIEW_STAT,
        :ITEM_ENTR_DATE, :ITEM_ENTR_TIME, :ITEM_ENTR_USER,  
        :ITEM_UPDT_DATE, :ITEM_UPDT_TIME, :ITEM_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
       ':ITEM_OPNA_CODE' =>$opnacode,':ITEM_WARE_CODE' =>$warecode,':ITEM_STOCK_CODE' =>$stockcode,':ITEM_STOCK_NAME' =>$stockname,                   
       ':ITEM_STOCK_QUTY' =>$stockquty,':ITEM_PART_UNIT' =>$partunit,':ITEM_STOCK_SRNM' =>$stocksrnm,':ITEM_STOCK_BTCH' =>$stockbtch,
       ':ITEM_STOCK_OPNA' =>$stockopna,':ITEM_VIEW_STAT' =>$viewstat,
       ':ITEM_ENTR_DATE' =>$dateinput, ':ITEM_ENTR_TIME' =>$timeinput, ':ITEM_ENTR_USER' =>$userid,
       ':ITEM_UPDT_DATE' =>$dateinput, ':ITEM_UPDT_TIME' =>$timeinput, ':ITEM_UPDT_USER' =>$userid));  
        ////print_r($db->error_Info());
        ////var_dump($query_input);
        ////exit();
        $db->commit();


        // Ubah status Item yang akan di opname agar terkunci sehingga tidak bisa digunakan oleh operator
        $update_status = "UPDATE investock SET INVE_VIEW_STAT='X'
            WHERE INVE_STOCK_CODE='$stockcode'
            AND INVE_WARE_CODE='$warecode'
            AND INVE_ENTR_TIME='$timecode'";

        // Prepare Request  
        $query_update_status = $db->prepare($update_status);

        // Mulai Input
        $db->beginTransaction();
        $query_update_status->execute();
        $db->commit();


}
else
{
$update = "UPDATE itemopna SET ITEM_STOCK_OPNA='$stockopna',ITEM_UPDT_DATE='$dateinput',ITEM_UPDT_TIME='$timeinput',
                  ITEM_UPDT_USER='$userid'    
            WHERE ITEM_OPNA_CODE='$opnacode'
            AND ITEM_WARE_CODE='$warecode'
            AND ITEM_STOCK_CODE='$stockcode'
            AND ITEM_STOCK_BTCH='$stockbtch'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

        // Ubah status Item yang akan di opname agar terkunci sehingga tidak bisa digunakan oleh operator
        $update_status = "UPDATE investock SET INVE_VIEW_STAT='X'
            WHERE INVE_STOCK_CODE='$stockcode'
            AND INVE_WARE_CODE='$warecode'
            AND INVE_ENTR_TIME='$timecode'";

        // Prepare Request  
        $query_update_status = $db->prepare($update_status);

        // Mulai Input
        $db->beginTransaction();
        $query_update_status->execute();
        $db->commit();


}

?>      
