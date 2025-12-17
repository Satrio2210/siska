<?php

include "conf/config.php";
include "inc/sanie.php";

//$rawdata = $_POST['q'];
$rawdata='X';
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);
if ($inputcode == 'X')
{
        // Start Generate Kode   
        $sqllast = "SELECT TRXA_EXEC_CODE FROM trxaexec
        ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC LIMIT 1";

        $q = $db->query($sqllast) or die("Gagal Ambil  terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $execcode = $r['TRXA_EXEC_CODE'] = isset($r['TRXA_EXEC_CODE']) ? $r['TRXA_EXEC_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($execcode, -4);
        $int = (int)$xcode;
        $int++;

        echo "EX-" . sprintf("%'.04d\n", $int);

        //if ($int <= 10)
        //{ $xexeccode = "EX-00" . $int; echo "$xexeccode";}

        //elseif ($int <= 100)

        //{ $xexeccode = "EX-0" . $int; echo "$xexeccode";}

        //elseif ($int <= 1000)
        //{ $xexeccode = $int;  }
        //else { $xexeccode = "EX-000" . $int; echo "$xexeccode";}
      // End Generate Kode          
}
else
{
  echo "EX-0000";
}

?>  
