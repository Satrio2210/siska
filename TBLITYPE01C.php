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
        $typecode = $_POST['q'];
        //list($outvchrsequ, $outvchrcode) = explode("|",$viewitemvoucher);

        $view = "SELECT TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_CATE, TBLI_TYPE_NOTE 
          FROM tblitype 
          WHERE TBLI_TYPE_CODE = '$typecode' 
          AND TBLI_TYPE_STAT = 'Y' 
          ORDER by TBLI_TYPE_CODE";

        $qview = $db->query($view) or die("Gagal Ambil Data Type!!");
        while ($rview = $qview->fetch(PDO::FETCH_ASSOC))  
        {
            $typecode = "$rview[TBLI_TYPE_CODE]";
            $typename = "$rview[TBLI_TYPE_NAME]";
            $typecate = "$rview[TBLI_TYPE_CATE]";
            $typenote = "$rview[TBLI_TYPE_NOTE]";
            echo "|$typecode|$typename|$typecate|$typenote";    
        }
   }
}
?>