<?php

include "conf/config.php";
include "inc/sanie.php";

$rawdata = $_POST['q'];
$inputcode = xss_clean($rawdata);
list($medicode, $feeuser, $mastrate) = explode("|",$inputcode);

if ($mastrate == 'F')
{
$query_nilai = "SELECT (TBLF_MEDI_RATE - '$feeuser') AS MEDI_RATE FROM tblfmedi 
                WHERE TBLF_MEDI_CODE='$medicode'";    
}
else if ($mastrate == 'P')
{
$query_nilai = "SELECT (TBLF_MEDI_RATE - (TBLF_MEDI_RATE * ('$feeuser'/100))) AS MEDI_RATE FROM tblfmedi 
                WHERE TBLF_MEDI_CODE='$medicode'";    

}
else
{
$query_nilai = "SELECT (TBLF_MEDI_RATE - TBLF_MEDI_RATE) AS MEDI_RATE FROM tblfmedi 
                WHERE TBLF_MEDI_CODE='$medicode'";    

}

$qnilai = $db->query($query_nilai) or die("Gagal Ambil Nilai !!");
$rnilai = $qnilai->fetch(PDO::FETCH_ASSOC);

$medirate = $rnilai['MEDI_RATE'];
echo "$medirate";

?>	
