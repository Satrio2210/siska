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
        $sql = "SELECT COAC_MAST_CODE FROM coacmast 
        WHERE COAC_MAST_CODE='$mastcode' 
        AND COAC_MAST_PRNT='$mastprnt'
        AND COAC_VIEW_STAT='Y'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $coacmastcode = "$r[COAC_MAST_CODE]";
            echo "0$coacmastcode";
        }
}
?>	
