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
        $sqllast = "SELECT VST_MAST_CODE FROM vstmast 
               
              ORDER by VST_ENTR_DATE DESC, VST_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Visite terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $vstcode = $r['VST_MAST_CODE'] = isset($r['VST_MAST_CODE']) ? $r['VST_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($vstcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "VST-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xvstcode = "VST-00" . $int; echo "$xvstcode";}

        //elseif ($int <= 100)

        //{ $xvstcode = "VST-0" . $int; echo "$xvstcode";}

        //elseif ($int <= 1000)
        //{ $xvstcode = "VST-" . $int;  echo "$xvstcode";}
        //else { $xvstcode = "VST-000" . $int; echo "$xvstcode";}
      // End Generate Kode Medical       
}
else
{
  echo "ATT-0000";
}

?>	
