<?php
error_reporting(E_ALL & ~E_NOTICE);

include "config.php";

$kode = $_POST['q'];
//$kode = 'PO-0006'; 

if($kode)
{
        $sql = "SELECT TRXA_PROC_CODE, TRXA_ENTR_USER
                FROM trxaproc WHERE TRXA_PROC_CODE = '$kode'";

        $q = $db->query($sql) or die("Gagal ambil data print!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $proccode = "$r[TRXA_PROC_CODE]";
            $entruser = "$r[TRXA_ENTR_USER]";

        echo "|$proccode|$entruser|"; 
        }
}
?>	



