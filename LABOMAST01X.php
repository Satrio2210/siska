<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode Medical
        $sqllast = "SELECT LABO_MAST_CODE FROM labomast 
               
              ORDER by LABO_ENTR_DATE DESC, LABO_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Laborat terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $mastcode = $r['LABO_MAST_CODE'] = isset($r['LABO_MAST_CODE']) ? $r['LABO_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($mastcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "LB-" . sprintf("%'.04d\n", $int);

}
else
{
  echo "LB-0000";
}

?>	
