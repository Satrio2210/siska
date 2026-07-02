<?php

include "conf/config.php";

$xquery = "SELECT CONCAT(
            e.TRXA_EXAM_CODE, '|',
            IFNULL(p.PATI_MAIN_NAME, 'Pasien Baru'), '|',
            e.TRXA_ENTR_DATE, '|',
            e.TRXA_ENTR_TIME
          ) AS NOTIFKEY 
        FROM trxaexam e
        INNER JOIN trxaregi r ON r.TRXA_REGI_CODE = e.TRXA_EXAM_CODE
        LEFT JOIN patimast p ON p.PATI_MAST_CODE = r.TRXA_PATI_CODE
        WHERE e.TRXA_EXAM_PRSC <> '' 
        AND e.TRXA_VIEW_STAT = 'Y' 
        ORDER BY 
        e.TRXA_ENTR_DATE DESC,
        e.TRXA_ENTR_TIME DESC
        LIMIT 1
        ";

$q = $db->query($xquery)
    or die("Gagal ambil notif!");

$row = $q->fetch(PDO::FETCH_ASSOC);

echo $row['NOTIFKEY'];

?>
