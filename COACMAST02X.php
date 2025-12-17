<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 'On');
include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
//$rawdata='5.1|2';
$inputcode = xss_clean($rawdata);
list($mastprnt, $mastcode) = explode("|",$inputcode);

if($mastcode)
{
        $sql = "SELECT COAC_MAST_NAME, COAC_MAST_COSG, COAC_MAST_STAT, COAC_NORM_BLNC, COAC_FNRP_STAT, COAC_MAST_NOTE
        FROM coacmast 
        WHERE COAC_MAST_CODE='$mastcode' 
        AND COAC_MAST_PRNT='$mastprnt'
        AND COAC_VIEW_STAT='Y'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);  
        
        $mastname = "$r[COAC_MAST_NAME]";
        $mastcosg = "$r[COAC_MAST_COSG]";
        $maststat = "$r[COAC_MAST_STAT]";
        $normblnc = "$r[COAC_NORM_BLNC]";
        $fnrpstat = "$r[COAC_FNRP_STAT]";
        $mastnote = "$r[COAC_MAST_NOTE]";

        echo "$mastname|$mastcosg|$maststat|$normblnc|$fnrpstat|$mastnote";
}
?>	
