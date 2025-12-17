<?php
//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $locacode = $_POST['q'];
        //$locacode = 'PIK';
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR, FIXE_EMPL_CODE AS EMPL_CODE, 
                (SELECT CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = EMPL_CODE LIMIT 1) AS EMPL_NAME, FIXE_LOCA_NOTE 
          FROM fixeloca 
          WHERE FIXE_LOCA_CODE = '$locacode' 
          AND FIXE_VIEW_STAT = 'Y' 
          ORDER by FIXE_LOCA_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Lokasi!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $locacode = "$rview[FIXE_LOCA_CODE]";
            $locaname = "$rview[FIXE_LOCA_NAME]";
            $locaaddr = "$rview[FIXE_LOCA_ADDR]";
            $emplcode = "$rview[EMPL_CODE]";
            $emplname = "$rview[EMPL_NAME]";
            $locanote = "$rview[FIXE_LOCA_NOTE]";
            echo "|$locacode|$locaname|$locaaddr|$emplcode|$emplname|$locanote";    
        }
   }
}
?>