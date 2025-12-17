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
        $sqllast = "SELECT SUPL_MAST_CODE FROM suplmast 
               
              ORDER by SUPL_ENTR_DATE DESC, SUPL_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Suplier terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $suplcode = $r['SUPL_MAST_CODE'] = isset($r['SUPL_MAST_CODE']) ? $r['SUPL_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($suplcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "VE-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xsuplcode = "VE-00" . $int; echo "$xsuplcode";}

        //elseif ($int <= 100)

        //{ $xsuplcode = "VE-0" . $int; echo "$xsuplcode";}

        //elseif ($int <= 1000)
        //{ $xsuplcode = $int;  }
        //else { $xsuplcode = "VE-000" . $int; echo "$xsuplcode";}
      // End Generate Kode Suplier         
}
else
{
  echo "VE-0000";
}

?>	
