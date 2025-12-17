<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='1';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode Medical
        $sqllast = "SELECT TRXA_PAYM_CODE FROM trxapaym 
               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Pembayaran terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $paymcode = $r['TRXA_PAYM_CODE'] = isset($r['TRXA_PAYM_CODE']) ? $r['TRXA_PAYM_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($paymcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "PY-" . sprintf("%'.04d\n", $int);

}
else
{
  echo "PY-0000";
}

?>	
