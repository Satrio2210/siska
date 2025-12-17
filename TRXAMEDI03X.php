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
        $sqllast = "SELECT ATT_MAST_CODE FROM attmast 
               
              ORDER by ATT_ENTR_DATE DESC, ATT_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Fee terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $attcode = $r['ATT_MAST_CODE'] = isset($r['ATT_MAST_CODE']) ? $r['ATT_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($attcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "ATT-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xattcode = "ATT-00" . $int; echo "$xattcode";}

        //elseif ($int <= 100)

        //{ $xattcode = "ATT-0" . $int; echo "$xattcode";}

        //elseif ($int <= 1000)
        //{ $xattcode = "ATT-" . $int;  echo "$xattcode";}
        //else { $xattcode = "ATT-000" . $int; echo "$xattcode";}
      // End Generate Kode Medical       
}
else
{
  echo "ATT-0000";
}

?>	
