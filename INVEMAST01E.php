<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{
      include "conf/config.php";

      $mastcode = $_POST['txtmastcode'];

      $periksamastcode = "SELECT COUNT(*) FROM invemast WHERE INVE_MAST_CODE='$mastcode'";
      $periksamastcode_di_query=$db->query($periksamastcode) or die ("Cek Fail");
      $ketersediaan = $periksamastcode_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode suplier baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['hidtypecode']) && ($_POST['hidtypecode'] != ''))  {$maintype = $_POST['hidtypecode'];}//ok

        if(isset($_POST['hidunitcode']) && ($_POST['hidunitcode'] != ''))  {$mainunit = $_POST['hidunitcode'];}//ok

        if(isset($_POST['hidsaleunit']) && ($_POST['hidsaleunit'] != ''))  {$saleunit = $_POST['hidsaleunit'];}//ok

        if(isset($_POST['hidspeccode']) && ($_POST['hidspeccode'] != ''))  {$mainspec = $_POST['hidspeccode'];}//ok

        if(isset($_POST['hidvarncode']) && ($_POST['hidvarncode'] != ''))  {$mainvarn = $_POST['hidvarncode'];}//ok

        if(isset($_POST['hidwithsrnm']) && ($_POST['hidwithsrnm'] != ''))  {$withsrnm = $_POST['hidwithsrnm'];}
        else
        {$withsrnm = 'N';} //ok

        if(isset($_POST['hidparttype']) && ($_POST['hidparttype'] != ''))  {$parttype = $_POST['hidparttype'];}//ok

        if(isset($_POST['hidcostfrgt']) && ($_POST['hidcostfrgt'] != ''))  {$costfrgt = $_POST['hidcostfrgt'];}//ok

        if(isset($_POST['txtpartname']) && ($_POST['txtpartname'] != ''))  {$partname = $_POST['txtpartname'];}//ok

        if(isset($_POST['txtpartalias']) && ($_POST['txtpartalias'] != ''))  {$partalas = $_POST['txtpartalias'];}//ok

        if(isset($_POST['hidhouscode']) && ($_POST['hidhouscode'] != ''))  {$defaware = $_POST['hidhouscode'];}//ok

        if(isset($_POST['txtstockmini']) && ($_POST['txtstockmini'] != ''))  {$stockmini = $_POST['txtstockmini'];}//ok

        if(isset($_POST['txtmainnote']) && ($_POST['txtmainnote'] != ''))  {$mainnote = $_POST['txtmainnote'];}//ok

        if(isset($_POST['hidmainpric']) && ($_POST['hidmainpric'] != ''))  {$mainpric = $_POST['hidmainpric'];}//ok

        if(isset($_POST['hidgrtetype']) && ($_POST['hidgrtetype'] != ''))  {$grtetype = $_POST['hidgrtetype'];}//ok

        if(isset($_POST['txtgrtelimt']) && ($_POST['txtgrtelimt'] != ''))  {$grtelimt = $_POST['txtgrtelimt'];}//ok

        if(isset($_POST['txtexcercve']) && ($_POST['txtexcercve'] != ''))  {$excercve = $_POST['txtexcercve'];}//ok

        if(isset($_POST['txtlackrcve']) && ($_POST['txtlackrcve'] != ''))  {$lackrcve = $_POST['txtlackrcve'];}//ok

        $viewstat = 'Y';
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO invemast (
        INVE_MAST_CODE, INVE_MAIN_TYPE, INVE_MAIN_UNIT, INVE_SALE_UNIT, 
        INVE_MAIN_SPEC, INVE_MAIN_VARN, INVE_WITH_SRNM,
        INVE_PART_TYPE, INVE_COST_FRGT, INVE_PART_NAME,
        INVE_PART_ALAS, INVE_DEFA_WARE, INVE_STOCK_MINI,
        INVE_MAIN_NOTE, INVE_MAIN_PRIC, INVE_GRTE_TYPE, INVE_GRTE_LIMT,
        INVE_EXCE_RCVE, INVE_LACK_RCVE, INVE_VIEW_STAT, 
        INVE_ENTR_DATE, INVE_ENTR_TIME, INVE_ENTR_USER, 
        INVE_UPDT_DATE, INVE_UPDT_TIME, INVE_UPDT_USER) 
        VALUES (
        :INVE_MAST_CODE, :INVE_MAIN_TYPE, :INVE_MAIN_UNIT, :INVE_SALE_UNIT,
        :INVE_MAIN_SPEC, :INVE_MAIN_VARN, :INVE_WITH_SRNM,
        :INVE_PART_TYPE, :INVE_COST_FRGT, :INVE_PART_NAME,
        :INVE_PART_ALAS, :INVE_DEFA_WARE, :INVE_STOCK_MINI,
        :INVE_MAIN_NOTE, :INVE_MAIN_PRIC, :INVE_GRTE_TYPE, :INVE_GRTE_LIMT,
        :INVE_EXCE_RCVE, :INVE_LACK_RCVE, :INVE_VIEW_STAT, 
        :INVE_ENTR_DATE, :INVE_ENTR_TIME, :INVE_ENTR_USER, 
        :INVE_UPDT_DATE, :INVE_UPDT_TIME, :INVE_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        //var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
            ':INVE_MAST_CODE' =>$mastcode, 
            ':INVE_MAIN_TYPE' =>$maintype,
            ':INVE_MAIN_UNIT' =>$mainunit,
            ':INVE_SALE_UNIT' =>$saleunit,
            ':INVE_MAIN_SPEC' =>$mainspec,
            ':INVE_MAIN_VARN' =>$mainvarn,
            ':INVE_WITH_SRNM' =>$withsrnm,
            ':INVE_PART_TYPE' =>$parttype,
            ':INVE_COST_FRGT' =>$costfrgt,
            ':INVE_PART_NAME' =>$partname,
            ':INVE_PART_ALAS' =>$partalas,
            ':INVE_DEFA_WARE' =>$defaware,
            ':INVE_STOCK_MINI' =>$stockmini,
            ':INVE_MAIN_NOTE' =>$mainnote,
            ':INVE_MAIN_PRIC' =>$mainpric,
            ':INVE_GRTE_TYPE' =>$grtetype,
            ':INVE_GRTE_LIMT' =>$grtelimt,
            ':INVE_EXCE_RCVE' =>$excercve,
            ':INVE_LACK_RCVE' =>$lackrcve,
            ':INVE_VIEW_STAT' =>$viewstat,
            ':INVE_ENTR_DATE' =>$dateinput,
            ':INVE_ENTR_TIME' =>$timeinput,
            ':INVE_ENTR_USER' =>$userid, 
            ':INVE_UPDT_DATE' =>$dateinput,
            ':INVE_UPDT_TIME' =>$timeinput,
            ':INVE_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        //var_dump($query_input);
        //exit();
        $db->commit();
        header("location: INVEMAST01.php");
      }
      else
      {
         header("location: INVEMAST00.php");
      }
}
else
{
  header("location: "."index.php");
}
?>