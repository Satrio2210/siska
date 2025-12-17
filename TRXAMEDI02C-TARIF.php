<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
$inputcode = xss_clean($rawdata);
//list($status, $user) = explode("|",$inputcode);

$query_tarif = "SELECT TBLF_MEDI_RATE FROM tblfmedi 
                WHERE TBLF_MEDI_CODE='$inputcode'";

$qtarif = $db->query($query_tarif) or die("Gagal Ambil Tarif !!");
$rtarif = $qtarif->fetch(PDO::FETCH_ASSOC);

$medirate = $rtarif['TBLF_MEDI_RATE'];
echo "$medirate";

?>	
