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
        $rawdata = $_POST['q'];
        //$rawdata='DTIAR|1|14:51:45'
        list($outdoctuser, $outschddays, $outschdstart, $outschdend, $outentrtime) = explode("|",$rawdata);

        $view = "SELECT TRXA_DOCT_USER, TRXA_DOCT_NAME, 
          TRXA_MEDI_ROOM, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_MEDI_ROOM) AS ROOM_NAME,
          TRXA_SCHD_DAYS, TRXA_SCHD_START, TRXA_SCHD_END, TRXA_SCHD_NOTE, TRXA_ENTR_TIME 
          FROM trxaschd 
          WHERE TRXA_DOCT_USER = '$outdoctuser' 
          AND TRXA_SCHD_DAYS = '$outschddays' 
          AND TRXA_SCHD_START = '$outschdstart'
          AND TRXA_SCHD_END = '$outschdend'
          AND TRXA_ENTR_TIME = '$outentrtime'
          ";


        $qview = $db->query($view) or die("Gagal Ambil Data Jadwal!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $doctuser = "$rview[TRXA_DOCT_USER]";
            $doctname = "$rview[TRXA_DOCT_NAME]";
            $mediroom = "$rview[TRXA_MEDI_ROOM]";
            $roomname = "$rview[ROOM_NAME]";
            $schddays = "$rview[TRXA_SCHD_DAYS]";
            $schdstart = "$rview[TRXA_SCHD_START]";
            $schdend = "$rview[TRXA_SCHD_END]";
            $schdnote = "$rview[TRXA_SCHD_NOTE]";
            $entrtime = "$rview[TRXA_ENTR_TIME]";

            echo "|$doctuser|$doctname|$mediroom|$roomname|$schddays|$schdstart|$schdend|$schdnote|$entrtime";    
        }
   }
}
?>