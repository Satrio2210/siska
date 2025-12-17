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
        $sqllast = "SELECT TRXA_OPNA_CODE FROM trxaopna 
        ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil  terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $opnacode = $r['TRXA_OPNA_CODE'] = isset($r['TRXA_OPNA_CODE']) ? $r['TRXA_OPNA_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($opnacode, -4);
        $int = (int)$xcode;
        $int++;

        echo "ST-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xopnacode = "ST-00" . $int; echo "$xopnacode";}

        //elseif ($int <= 100)

        //{ $xopnacode = "ST-0" . $int; echo "$xopnacode";}

        //elseif ($int <= 1000)
        //{ $xopnacode = $int;  }
        //else { $xopnacode = "ST-000" . $int; echo "$xopnacode";}
      // End Generate Kode          
}
else
{
  echo "ST-0000";
}

?>  
