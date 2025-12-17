<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='1';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode Pembayaran  
        $sqllast = "SELECT TRXA_VEND_CODE FROM trxavend 
               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Pembayaran terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $vendcode = $r['TRXA_VEND_CODE'] = isset($r['TRXA_VEND_CODE']) ? $r['TRXA_VEND_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($vendcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "VP-" . sprintf("%'.04d\n", $int);

      // End Generate Kode Pembayaran         
}
else
{
  echo "VP-0000";
}

?>	
