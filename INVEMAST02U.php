<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtmastcode']))
    {
        $mastcode = $_POST['txtmastcode'];

        if(isset($_POST['hidtypecode']) && ($_POST['hidtypecode'] != '')) 
        {
         $maintype = $_POST['hidtypecode'];
        }

        if(isset($_POST['hidunitcode']) && ($_POST['hidunitcode'] != ''))
        { $mainunit = $_POST['hidunitcode']; }

        if(isset($_POST['hidsaleunit']) && ($_POST['hidsaleunit'] != ''))
        { $saleunit = $_POST['hidsaleunit']; }

        if(isset($_POST['hidspeccode']) && ($_POST['hidspeccode'] != ''))
        { $mainspec = $_POST['hidspeccode']; }

        if(isset($_POST['hidvarncode']) && ($_POST['hidvarncode'] != ''))
        { $mainvarn = $_POST['hidvarncode']; }


        if(isset($_POST['hidwithsrnm']) && ($_POST['hidwithsrnm'] != '')) 
        {
         $withsrnm = $_POST['hidwithsrnm'];
        }

        if(isset($_POST['hidparttype']) && ($_POST['hidparttype'] != '')) 
        {
         $parttype = $_POST['hidparttype'];
        }

        if(isset($_POST['hidcostfrgt']) && ($_POST['hidcostfrgt'] != '')) 
        {
         $costfrgt = $_POST['hidcostfrgt'];
        }

        if(isset($_POST['txtpartname']) && ($_POST['txtpartname'] != '')) 
        {
         $partname = $_POST['txtpartname'];
        }

        if(isset($_POST['txtpartalias']) && ($_POST['txtpartalias'] != '')) 
        {
         $partalas = $_POST['txtpartalias'];
        }

        if(isset($_POST['hidhouscode']) && ($_POST['hidhouscode'] != ''))  {$defaware = $_POST['hidhouscode'];}//ok

        if(isset($_POST['txtstockmini']) && ($_POST['txtstockmini'] != ''))  {$stockmini = $_POST['txtstockmini'];}//ok

        if(isset($_POST['txtmainnote']) && ($_POST['txtmainnote'] != ''))  {$mainnote = $_POST['txtmainnote'];}//ok

        if(isset($_POST['hidmainpric']) && ($_POST['hidmainpric'] != ''))  {$mainpric = $_POST['hidmainpric'];}//ok

        if(isset($_POST['hidgrtetype']) && ($_POST['hidgrtetype'] != ''))  {$grtetype = $_POST['hidgrtetype'];}//ok

        if(isset($_POST['txtgrtelimt']) && ($_POST['txtgrtelimt'] != ''))  {$grtelimt = $_POST['txtgrtelimt'];}

        if(isset($_POST['txtexcercve']) && ($_POST['txtexcercve'] != ''))  {$excercve = $_POST['txtexcercve'];}

        if(isset($_POST['txtlackrcve']) && ($_POST['txtlackrcve'] != ''))  {$lackrcve = $_POST['txtlackrcve'];}

  
        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE invemast SET INVE_MAIN_TYPE='$maintype', 
                    INVE_MAIN_UNIT='$mainunit',
                    INVE_SALE_UNIT='$saleunit',
				    INVE_MAIN_SPEC='$mainspec',
                    INVE_MAIN_VARN='$mainvarn',
                    INVE_WITH_SRNM='$withsrnm',
                    INVE_PART_TYPE='$parttype',
                    INVE_COST_FRGT='$costfrgt',
                    INVE_PART_NAME='$partname',
                    INVE_PART_ALAS='$partalas',
                    INVE_DEFA_WARE='$defaware',
                    INVE_STOCK_MINI='$stockmini',
                    INVE_MAIN_NOTE='$mainnote',
                    INVE_MAIN_PRIC='$mainpric',
                    INVE_GRTE_TYPE='$grtetype',
                    INVE_GRTE_LIMT='$grtelimt',
                    INVE_EXCE_RCVE='$excercve',
                    INVE_LACK_RCVE='$lackrcve',
                    INVE_UPDT_DATE='$dateinput',
                    INVE_UPDT_TIME='$timeinput',
                    INVE_UPDT_USER='$userid'    
				WHERE INVE_MAST_CODE='$mastcode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: INVEMAST02.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>