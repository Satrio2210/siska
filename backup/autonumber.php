<?php
        //$medicode = $r['TBLF_MEDI_CODE'];
		$medicode = 'TND-0999';
        // ambil 4 huruf dari kanan
        $xcode = substr($medicode, -4);
        $int = (int)$xcode;
        $int++;

        if ($int <= 10)
        { $xmedicode = "TND-00" . $int; echo "$xmedicode";}

        elseif ($int <= 100)

        { $xmedicode = "TND-0" . $int; echo "$xmedicode";}

        elseif ($int <= 1000)
        { $xmedicode = "TND-" . $int;  echo "$xmedicode";}
        else { $xmedicode = "TND-000" . $int; echo "$xmedicode";}

?>