<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode Suplier  
        $sqllast = "SELECT EMPL_MAST_CODE FROM emplmast 
               
              ORDER by EMPL_ENTR_DATE DESC, EMPL_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Employer terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $emplcode = $r['EMPL_MAST_CODE'] = isset($r['EMPL_MAST_CODE']) ? $r['EMPL_MAST_CODE'] : '';


        // ambil 4 huruf dari kanan
        $xcode = substr($emplcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "ID-" . sprintf("%'.04d\n", $int);

}
else
{
  echo "ID-0000";
}

?>	
