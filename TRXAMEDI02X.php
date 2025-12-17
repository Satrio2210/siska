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
        $sqllast = "SELECT FEE_MAST_CODE FROM feemast 
               
              ORDER by FEE_ENTR_DATE DESC, FEE_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Fee terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $feecode = $r['FEE_MAST_CODE'] = isset($r['FEE_MAST_CODE']) ? $r['FEE_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($feecode, -4);
        $int = (int)$xcode;
        $int++;

        echo "FEE-" . sprintf("%'.04d\n", $int);
        //if ($int <= 10)
        //{ $xmedicode = "FEE-00" . $int; echo "$xmedicode";}

        //elseif ($int <= 100)

        //{ $xmedicode = "FEE-0" . $int; echo "$xmedicode";}

        //elseif ($int <= 1000)
        //{ $xmedicode = "FEE-" . $int;  echo "$xmedicode";}
        //else { $xmedicode = "FEE-000" . $int; echo "$xmedicode";}
      // End Generate Kode Medical       
}
else
{
  echo "FEE-0000";
}

?>	
