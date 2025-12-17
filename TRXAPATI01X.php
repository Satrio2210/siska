<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode pASIEN  
        $sqllast = "SELECT PATI_MAST_CODE FROM patimast 
               
              ORDER by PATI_ENTR_DATE DESC, PATI_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Nomor terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $paticode = $r['PATI_MAST_CODE'] = isset($r['PATI_MAST_CODE']) ? $r['PATI_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($paticode, -5);
        $int = (int)$xcode;
        $int++;

        echo "-" . sprintf("%'.05d\n", $int);

      // End Generate Kode Suplier         
}
else
{
  echo "-99999";
}

?>	
