<?php
//memulai session
include "conf/config.php";
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

      $xuseriden = $_POST['txtuseriden'];
      $periksauseriden = "SELECT COUNT(*) FROM passiden WHERE PASS_USER_IDEN='$xuseriden'";
      $periksauseriden_di_query=$db->query($periksauseriden) or die ("Cek Fail");
      $ketersediaan = $periksauseriden_di_query->fetchColumn();
      //Cek adanya user id yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode pos baru
      if ($ketersediaan == 0)
      {
        if(isset($_POST['txtuseriden']))  {$useriden = $_POST['txtuseriden'];}//ok
        if(isset($_POST['hidemplcode']))  {$emplcode = $_POST['hidemplcode'];}//ok
        if(isset($_POST['txtusername']))  {$username = $_POST['txtusername'];}//ok
        if(isset($_POST['txtuserpswd']))  {$xuserpswd = $_POST['txtuserpswd']; $userpswd=md5($xuserpswd);}//ok
        if(isset($_POST['hidusertype']))  {$usertype = $_POST['hidusertype'];}//ok

        $akses = 'N';             
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");
        $userid = $_SESSION['username'];

        $input = "INSERT INTO passiden (
        PASS_USER_IDEN, PASS_EMPL_CODE, PASS_USER_NAME, PASS_USER_PSWD, PASS_USER_TYPE,
        PASS_IDEN_NEW, PASS_IDEN_PREV, PASS_IDEN_DELL, PASS_IDEN_VIEW, 
        PASS_TRXA_ENTR, PASS_COAC_ENTR, PASS_TBLA_ENTR, PASS_DIVI_ENTR, PASS_REPO_VIEW, 
        PASS_SPEC_ITEM, PASS_INVE_ENTR, PASS_WARE_HOUS, 
        PASS_TRANS_REQU, PASS_TRANS_APRO, PASS_TRANS_EXEC, PASS_TRANS_RECE, 
        PASS_STOCK_OPNA, PASS_STOCK_ADJU, PASS_STOCK_EXEC, PASS_STOCK_REPO, 
        PASS_SUPL_ENTR, PASS_PROC_ENTR, PASS_PROC_UPDT, PASS_PROC_INVC, 
        PASS_REGI_ENTR, PASS_TRXA_POLI, PASS_MEDI_ENTR, PASS_LABO_ENTR, PASS_CUST_ENTR, 
        PASS_SALE_ENTR, PASS_SALE_VIEW, PASS_DRUG_ENTR, PASS_DRUG_VIEW, PASS_MEDI_REPO, 
        PASS_VEND_ENTR, PASS_VEND_UPDT, PASS_VEND_EXEC, PASS_CUST_RCVD, 
        PASS_PAYM_CASH, PASS_DEBT_ENTR, PASS_CRDT_ENTR, PASS_BANK_RECO, 
        PASS_FIXE_ASSE, 
        PASS_EMPL_ENTR, PASS_PAYR_ENTR, 
        PASS_ENTR_DATE, PASS_ENTR_TIME, PASS_ENTR_USER, 
        PASS_UPDT_DATE, PASS_UPDT_TIME, PASS_UPDT_USER) 
        VALUES (
        :PASS_USER_IDEN, :PASS_EMPL_CODE, :PASS_USER_NAME, :PASS_USER_PSWD, :PASS_USER_TYPE,
        :PASS_IDEN_NEW, :PASS_IDEN_PREV, :PASS_IDEN_DELL, :PASS_IDEN_VIEW, 
        :PASS_TRXA_ENTR, :PASS_COAC_ENTR, :PASS_TBLA_ENTR, :PASS_DIVI_ENTR, :PASS_REPO_VIEW, 
        :PASS_SPEC_ITEM, :PASS_INVE_ENTR, :PASS_WARE_HOUS, 
        :PASS_TRANS_REQU, :PASS_TRANS_APRO, :PASS_TRANS_EXEC, :PASS_TRANS_RECE, 
        :PASS_STOCK_OPNA, :PASS_STOCK_ADJU, :PASS_STOCK_EXEC, :PASS_STOCK_REPO, 
        :PASS_SUPL_ENTR, :PASS_PROC_ENTR, :PASS_PROC_UPDT, :PASS_PROC_INVC, 
        :PASS_REGI_ENTR, :PASS_TRXA_POLI, :PASS_MEDI_ENTR, :PASS_LABO_ENTR, :PASS_CUST_ENTR, 
        :PASS_SALE_ENTR, :PASS_SALE_VIEW, :PASS_DRUG_ENTR, :PASS_DRUG_VIEW, :PASS_MEDI_REPO, 
        :PASS_VEND_ENTR, :PASS_VEND_UPDT, :PASS_VEND_EXEC, :PASS_CUST_RCVD, 
        :PASS_PAYM_CASH, :PASS_DEBT_ENTR, :PASS_CRDT_ENTR, :PASS_BANK_RECO, 
        :PASS_FIXE_ASSE, 
        :PASS_EMPL_ENTR, :PASS_PAYR_ENTR, 
        :PASS_ENTR_DATE, :PASS_ENTR_TIME, :PASS_ENTR_USER, 
        :PASS_UPDT_DATE, :PASS_UPDT_TIME, :PASS_UPDT_USER)";
        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
        ':PASS_USER_IDEN' =>$useriden, ':PASS_EMPL_CODE' =>$emplcode,
        ':PASS_USER_NAME' =>$username, ':PASS_USER_PSWD' =>$userpswd,
        ':PASS_USER_TYPE' =>$usertype,

        ':PASS_IDEN_NEW' =>$akses, ':PASS_IDEN_PREV' =>$akses, ':PASS_IDEN_DELL' =>$akses, ':PASS_IDEN_VIEW' =>$akses, 
        ':PASS_TRXA_ENTR' =>$akses, ':PASS_COAC_ENTR' =>$akses, ':PASS_TBLA_ENTR' =>$akses, ':PASS_DIVI_ENTR' =>$akses, 
        ':PASS_REPO_VIEW' =>$akses, 
        ':PASS_SPEC_ITEM' =>$akses, ':PASS_INVE_ENTR' =>$akses, ':PASS_WARE_HOUS' =>$akses, 
        ':PASS_TRANS_REQU' =>$akses, ':PASS_TRANS_APRO' =>$akses, ':PASS_TRANS_EXEC' =>$akses, ':PASS_TRANS_RECE' =>$akses, 
        ':PASS_STOCK_OPNA' =>$akses, ':PASS_STOCK_ADJU' =>$akses, ':PASS_STOCK_EXEC' =>$akses, ':PASS_STOCK_REPO' =>$akses, 
        ':PASS_SUPL_ENTR' =>$akses, ':PASS_PROC_ENTR' =>$akses, ':PASS_PROC_UPDT' =>$akses, ':PASS_PROC_INVC' =>$akses, 
        ':PASS_REGI_ENTR' =>$akses, ':PASS_TRXA_POLI' =>$akses, ':PASS_MEDI_ENTR' =>$akses, ':PASS_LABO_ENTR' =>$akses, 
        ':PASS_CUST_ENTR' =>$akses, 
        ':PASS_SALE_ENTR' =>$akses, ':PASS_SALE_VIEW' =>$akses, ':PASS_DRUG_ENTR' =>$akses, ':PASS_DRUG_VIEW' =>$akses, 
        ':PASS_MEDI_REPO' =>$akses, 
        ':PASS_VEND_ENTR' =>$akses, ':PASS_VEND_UPDT' =>$akses, ':PASS_VEND_EXEC' =>$akses, ':PASS_CUST_RCVD' =>$akses, 
        ':PASS_PAYM_CASH' =>$akses, ':PASS_DEBT_ENTR' =>$akses, ':PASS_CRDT_ENTR' =>$akses, ':PASS_BANK_RECO' =>$akses, 
        ':PASS_FIXE_ASSE' =>$akses, 
        ':PASS_EMPL_ENTR' =>$akses, ':PASS_PAYR_ENTR' =>$akses, 

        ':PASS_ENTR_DATE' =>$dateinput, ':PASS_ENTR_TIME' =>$timeinput, ':PASS_ENTR_USER' =>$userid, 
        ':PASS_UPDT_DATE' =>$dateinput, ':PASS_UPDT_TIME' =>$timeinput, ':PASS_UPDT_USER' =>$userid));
        //print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
        header("location: PASSIDEN01.php");
      }
      else
      {
         header("location: PASSIDEN00.php");
      }
}
else
{
  header("location: "."index.php");
}
?>