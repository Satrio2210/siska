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
        $sqllast = "SELECT CUST_MAST_CODE FROM custmast 
               
              ORDER by CUST_ENTR_DATE DESC, CUST_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Urut!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $mastcode = $r['CUST_MAST_CODE'] = isset($r['CUST_MAST_CODE']) ? $r['CUST_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($mastcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "CS-" . sprintf("%'.04d\n", $int);

}
else
{
  echo "CS-0000";
}

?>	
