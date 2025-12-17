<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_POST['q'];
//$kode = 'VE-0004'; 

if($kode)
{
        $summ_order = 0;
        // ambil total pembelian yang masih terhutang
        $sql_summary = "SELECT TRXA_PROC_CODE, 
                (SELECT SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) FROM itemproc 
                WHERE ITEM_PROC_CODE=TRXA_PROC_CODE)  AS ITEM_ORDER 
                FROM trxaproc 
                WHERE TRXA_PROC_STAT = 'CL' AND TRXA_SUPL_CODE = '$kode'";

        $q_summary = $db->query($sql_summary) or die("Gagal ambil data total hutang!!");
        while ($row_summary = $q_summary->fetch(PDO::FETCH_ASSOC))  
        {
            $itemorder = "$row_summary[ITEM_ORDER]";
            $summ_order = $summ_order + $itemorder;
        }

        // ambil nilai limit suplier
        $sql_limit = "SELECT SUPL_PAYA_LIMT FROM suplmast WHERE SUPL_MAST_CODE = '$kode'";
        $q_limit = $db->query($sql_limit) or die("gagal ambil data limit vendor");
        $row_limit = $q_limit->fetch(PDO::FETCH_ASSOC);

        $paylimit = "$row_limit[SUPL_PAYA_LIMT]"; 


        echo "|$kode|$paylimit|$summ_order|"; 

}
?>	



