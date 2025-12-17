<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='I|ADMIN';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == '1')
{
        // Start Generate Kode pASIEN  
        $sqllast = "SELECT PATI_MAST_CODE FROM patimast 
               
              ORDER by PATI_ENTR_DATE DESC, PATI_ENTR_TIME DESC 
              LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil Kode Nomor terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $paticode = $r['PATI_MAST_CODE'];
        // ambil 4 huruf dari kanan
        $xcode = substr($paticode, -5);
        $int = (int)$xcode;
        $int++;

        if ($int <= 10)
        { $xpaticode = "-0000" . $int; echo "$xpaticode";}

        elseif ($int <= 100)
        { $xpaticode = "-000" . $int; echo "$xpaticode";}

        elseif ($int <= 1000)
        { $xpaticode = "-0" . $int;  echo "$xpaticode";}

        elseif ($int <= 10000)
        { $xpaticode = "-" . $int;  echo "$xpaticode";}

        else 
        { $xpaticode = "-99999" . $int; echo "$xpaticode";}
      // End Generate Kode Suplier         
}
else
{
  echo "-99999";
}

?>	
