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
        $medicode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME, TBLF_MEDI_RATE, TBLF_MEDI_ROOM,
                (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=TBLF_MEDI_ROOM) AS NAME_ROOM,
                TBLF_MEDI_TYPE, TBLF_MEDI_PAYM, TBLF_MEDI_NOTE, TBLF_MEDI_ACTI 
          FROM tblfmedi 
          WHERE TBLF_MEDI_CODE = '$medicode' 
          AND TBLF_VIEW_STAT = 'Y'";

        $qview = $db->query($view) or die("Gagal Ambil Data Tindakan!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $medicode = "$rview[TBLF_MEDI_CODE]";
            $mediname = "$rview[TBLF_MEDI_NAME]";
            $medirate = "$rview[TBLF_MEDI_RATE]";
            $roomcode = "$rview[TBLF_MEDI_ROOM]";
            $roomname = "$rview[NAME_ROOM]";
            $meditype = "$rview[TBLF_MEDI_TYPE]";
            $medipaym = "$rview[TBLF_MEDI_PAYM]";
            $medinote = "$rview[TBLF_MEDI_NOTE]";
            $mediacti = "$rview[TBLF_MEDI_ACTI]";

            echo "|$medicode|$mediname|$medirate|$roomcode|$roomname|$meditype|$medipaym|$medinote|$mediacti";    
        }
   }
}
?>