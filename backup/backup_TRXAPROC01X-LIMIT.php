<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_POST['q'];
//$kode = 'PO-0004'; 

if($kode)
{
        $sql = "SELECT ITEM_PROC_CODE, 
                (SELECT SUPL_PAYA_LIMT FROM suplmast WHERE SUPL_MAST_CODE = 
                (SELECT TRXA_SUPL_CODE FROM trxaproc WHERE TRXA_PROC_CODE = ITEM_PROC_CODE)) AS PAY_LIMIT, 
                SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) AS TOTA_PRIC
                FROM itemproc
                WHERE ITEM_PROC_CODE = '$kode' AND ITEM_VIEW_STAT='Y'
";
        $q = $db->query($sql) or die("Gagal ambil data limit!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $proccode = "$r[ITEM_PROC_CODE]";
            $paylimit = "$r[PAY_LIMIT]";
            $totapric = "$r[TOTA_PRIC]";

        echo "|$proccode|$paylimit|$totapric|"; 
        }
}
?>	



