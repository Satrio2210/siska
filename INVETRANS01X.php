<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='X';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == 'X')
{
        // Start Generate Kode   
        $sqllast = "SELECT TRXA_REQU_CODE FROM trxarequ 
        ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil  terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $requcode = $r['TRXA_REQU_CODE'] = isset($r['TRXA_REQU_CODE']) ? $r['TRXA_REQU_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($requcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "RE-" . sprintf("%'.04d\n", $int);
        //if ($int <= 10)
        //{ $xrequcode = "RE-00" . $int; echo "$xrequcode";}

        //elseif ($int <= 100)

        //{ $xrequcode = "RE-0" . $int; echo "$xrequcode";}

        //elseif ($int <= 1000)
        //{ $xrequcode = $int;  }
        //else { $xrequcode = "RE-000" . $int; echo "$xrequcode";}
      // End Generate Kode          
}
else
{
  echo "RE-0000";
}

?>  
