<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode Item  
        $sqllast = "SELECT INVE_MAST_CODE FROM invemast 
               
              ORDER by INVE_ENTR_DATE DESC, INVE_ENTR_TIME DESC 
              LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Item  terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $invecode = $r['INVE_MAST_CODE'] = isset($r['INVE_MAST_CODE']) ? $r['INVE_MAST_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($invecode, -4);
        $int = (int)$xcode;
        $int++;

        echo sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xinvecode = "00" . $int; echo $xinvecode; }

        //elseif ($int <= 100)

        //{ $xinvecode = "0" . $int; echo $xinvecode;}

        //elseif ($int <= 1000)
        //{ $xinvecode = $int;  echo $xinvecode;}
        //else { $xinvecode = "000" . $int; echo $xinvecode;}
      // End Generate Kode Item         
}
else
{
  echo "0000";
}

?>	
