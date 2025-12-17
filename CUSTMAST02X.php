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
        $sqllast = "SELECT TRXA_LIST_CODE FROM trxacust 
               
              ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Urut!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $mastcode = $r['TRXA_LIST_CODE'] = isset($r['TRXA_LIST_CODE']) ? $r['TRXA_LIST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($mastcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "LS-" . sprintf("%'.04d\n", $int);

}
else
{
  echo "LS-0000";
}

?>	
