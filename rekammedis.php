<?php
        //$paticode = $r['PATI_MAST_CODE'];
        // 0396-00071
        $paticode = '0291-00169';
        // ambil 4 huruf dari kanan
        $xcode = substr($paticode, -5);
        $int = (int)$xcode;
        $int++;

        $nomor = "-" . sprintf("%'.04d\n", $int); 
        echo $nomor;
        //echo "-" . sprintf("%'.04d\n", $int);


        //var_dump($int);
        //exit();

        /*if ($int >= 10)
        { $xpaticode = "-000" . $int; echo "$xpaticode";}

        elseif ($int >= 100)
        { $xpaticode = "-00" . $int; echo "$xpaticode";}

        elseif ($int >= 1000)
        { $xpaticode = "-0" . $int;  echo "$xpaticode";}

        elseif ($int >= 10000)
        { $xpaticode = "-" . $int;  echo "$xpaticode";}

        else 
        { $xpaticode = "-99999" . $int; echo "$xpaticode";} */
      // End Generate Kode Suplier         
//}
//else
//{
//  echo "-99999";
//}
?>