<?php

include "conf/config.php";

$xquery = "SELECT CONCAT(TRXA_EXAM_CODE,'|',TRXA_ENTR_DATE,'|',TRXA_ENTR_TIME) AS NOTIFKEY 
        FROM trxaexam 
        WHERE TRXA_EXAM_PRSC <> '' 
        AND TRXA_VIEW_STAT = 'Y' 
        ORDER BY 
        TRXA_ENTR_DATE DESC,
        TRXA_ENTR_TIME DESC
        LIMIT 1
        ";

$q = $db->query($xquery)
    or die("Gagal ambil notif!");

$row = $q->fetch(PDO::FETCH_ASSOC);

echo $row['NOTIFKEY'];

?>