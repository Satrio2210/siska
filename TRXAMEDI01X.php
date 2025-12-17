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
        $sqllast = "SELECT TBLF_MEDI_CODE FROM tblfmedi 
               
              ORDER by TBLF_ENTR_DATE DESC, TBLF_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Medical terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $medicode = $r['TBLF_MEDI_CODE'] = isset($r['TBLF_MEDI_CODE']) ? $r['TBLF_MEDI_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($medicode, -4);
        $int = (int)$xcode;
        $int++;

        echo "TND-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xmedicode = "TND-00" . $int; echo "$xmedicode";}

        //elseif ($int <= 100)

        //{ $xmedicode = "TND-0" . $int; echo "$xmedicode";}

        //elseif ($int <= 1000)
        //{ $xmedicode = "TND-" . $int;  echo "$xmedicode";}
        //else { $xmedicode = "TND-000" . $int; echo "$xmedicode";}
      // End Generate Kode Medical       
}
else
{
  echo "TND-0000";
}

?>	
