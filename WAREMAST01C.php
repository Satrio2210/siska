<?php
include "conf/config.php";

//error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
//if (ISSET($_SESSION['username']))
{

if (isset($_POST['q']) && ($_POST['q'] != ''))
    {
        $houscode = $_POST['q'];
        //$houscode = 'WAFE';
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT WARE_HOUS_CODE, WARE_HOUS_NAME, 
                  WARE_HOUS_LOCA,
                  (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = WARE_HOUS_LOCA) AS HOUS_NAME,
                  WARE_MEDI_ROOM,
                  (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=WARE_MEDI_ROOM) AS MEDI_NAME,

                  WARE_HOUS_TYPE, WARE_EMPL_CODE,
                  (SELECT CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = WARE_EMPL_CODE) AS EMPL_NAME,
                  WARE_HOUS_NOTE
          FROM waremast 
          WHERE WARE_HOUS_CODE = '$houscode' 
          AND WARE_HOUS_STAT = 'Y' 
          ORDER by WARE_HOUS_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Gudang!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $houscode = "$rview[WARE_HOUS_CODE]";
            $housname = "$rview[WARE_HOUS_NAME]";
            $locacode = "$rview[WARE_HOUS_LOCA]";
            $locaname = "$rview[HOUS_NAME]";
            $mediroom = "$rview[WARE_MEDI_ROOM]";
            $mediname = "$rview[MEDI_NAME]";

            $houstype = "$rview[WARE_HOUS_TYPE]";
            $emplname = "$rview[EMPL_NAME]";
            $emplcode = "$rview[WARE_EMPL_CODE]";
            $housnote = "$rview[WARE_HOUS_NOTE]";
            echo "|$houscode|$housname|$locaname|$locacode|$mediname|$mediroom|$houstype|$emplname|$emplcode|$housnote";    
        }
   }
}
?>