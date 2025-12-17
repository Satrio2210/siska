<?php
include "conf/config.php";
?>
<style>
#screen {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#screen td, #screen th {
    border: 1px solid #ddd;
    padding: 4px;
}


#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

#screen th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}
#screen tbody, #screen thead
{
    display:block;
}
#screen tbody 
{
  overflow: auto;
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px;">ID EMPLOYER</th>
  <th style="width: 200px;">NAMA EMPLOYER</th>
  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];

if (strlen($kata) == 1)
{

  $xquery = "SELECT EMPL_MAST_CODE, EMPL_FRST_NAME, EMPL_LAST_NAME, EMPL_MAIN_GEND, EMPL_MAIN_BIRT, EMPL_MAIN_BLOD, EMPL_FNGR_CODE, 
                    EMPL_MAIN_TIDN, EMPL_MAIN_STAT, EMPL_MKTP_ADDR, EMPL_MKTP_CITY, EMPL_MKTP_PROV, EMPL_MKTP_CTRY, 
                    EMPL_MAIN_HP01, EMPL_MAIN_HP02, EMPL_MAIN_MAIL, EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_DOCU_STAT, 
                    EMPL_MAIN_HOBI, EMPL_HIRE_DATE, EMPL_ACTI_DATE, 
                    EMPL_MAIN_DIVI, 
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS EMPL_NAME_DIVI,     
                    EMPL_MAIN_PSTN, 
            (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS EMPL_NAME_PSTN,       
                    EMPL_BANK_CODE, 
            (SELECT TBLE_BANK_NAME FROM tblebank WHERE TBLE_BANK_CODE = EMPL_BANK_CODE) AS EMPL_BANK_NAME,
                    EMPL_BANK_ACCT, EMPL_BANK_PERS
FROM emplmast
WHERE EMPL_VIEW_STAT = 'Y'";


}
else
{
  $xquery = "SELECT EMPL_MAST_CODE, EMPL_FRST_NAME, EMPL_LAST_NAME, EMPL_MAIN_GEND, EMPL_MAIN_BIRT, EMPL_MAIN_BLOD, EMPL_FNGR_CODE, 
                    EMPL_MAIN_TIDN, EMPL_MAIN_STAT, EMPL_MKTP_ADDR, EMPL_MKTP_CITY, EMPL_MKTP_PROV, EMPL_MKTP_CTRY, 
                    EMPL_MAIN_HP01, EMPL_MAIN_HP02, EMPL_MAIN_MAIL, EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_DOCU_STAT, 
                    EMPL_MAIN_HOBI, EMPL_HIRE_DATE, EMPL_ACTI_DATE, 
                    EMPL_MAIN_DIVI, 
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS EMPL_NAME_DIVI,     
                    EMPL_MAIN_PSTN, 
            (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS EMPL_NAME_PSTN,       
                    EMPL_BANK_CODE, 
            (SELECT TBLE_BANK_NAME FROM tblebank WHERE TBLE_BANK_CODE = EMPL_BANK_CODE) AS EMPL_BANK_NAME,
                    EMPL_BANK_ACCT, EMPL_BANK_PERS
FROM emplmast
WHERE EMPL_VIEW_STAT = 'Y'
AND EMPL_FRST_NAME LIKE '$kata%'";

}
$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $mastcode = $k['EMPL_MAST_CODE'];  $frstname = $k['EMPL_FRST_NAME'];  $lastname = $k['EMPL_LAST_NAME'];
  $maingend = $k['EMPL_MAIN_GEND'];  $mainbirt = $k['EMPL_MAIN_BIRT'];  $mainblod = $k['EMPL_MAIN_BLOD'];
  $fngrcode = $k['EMPL_FNGR_CODE'];  $maintidn = $k['EMPL_MAIN_TIDN'];  $mainstat = $k['EMPL_MAIN_STAT'];
  $mktpaddr = $k['EMPL_MKTP_ADDR'];  $mktpcity = $k['EMPL_MKTP_CITY'];  $mktpprov = $k['EMPL_MKTP_PROV'];
  $mktpctry = $k['EMPL_MKTP_CTRY'];  $mainhp01 = $k['EMPL_MAIN_HP01'];  $mainhp02 = $k['EMPL_MAIN_HP02'];
  $mainmail = $k['EMPL_MAIN_MAIL'];  $higheduc = $k['EMPL_HIGH_EDUC'];  $lastschl = $k['EMPL_LAST_SCHL'];
  $docustat = $k['EMPL_DOCU_STAT'];  $mainhobi = $k['EMPL_MAIN_HOBI'];  
  $hiredate = $k['EMPL_HIRE_DATE'];  $actidate = $k['EMPL_ACTI_DATE'];  
  $maindivi = $k['EMPL_MAIN_DIVI'];  $namedivi = $k['EMPL_NAME_DIVI'];
  $mainpstn = $k['EMPL_MAIN_PSTN'];  $namepstn = $k['EMPL_NAME_PSTN']; 
  $bankcode = $k['EMPL_BANK_CODE'];  $bankname = $k['EMPL_BANK_NAME'];
  $bankacct = $k['EMPL_BANK_ACCT'];  $bankpers = $k['EMPL_BANK_PERS'];

//(  $mastcode, $frstname, $lastname, $maingend, $mainbirt, $mainblod, $fngrcode, $maintidn, $mainstat, $mktpaddr, $mktpcity, $mktpprov, $mktpctry, $mainhp01, $mainhp02, $mainmail, $higheduc, $lastschl, $docustat, $mainhobi, $hiredate, $actidate, $inforefe, $namerefe, $infospvs, $namespvs, $maindivi, $namedivi, $mainpstn, $namepstn, $bankcode, $bankname, $bankacct, $bankpers)

echo '<tr>';

echo '<td style="width: 100px;" onClick="isiemplmastcode(\''.$mastcode.'\',\''.$frstname.'\',\''.$lastname.'\',\''.$maingend.'\',\''.$mainbirt.'\',\''.$mainblod.'\',\''.$fngrcode.'\',\''.$maintidn.'\',\''.$mainstat.'\',\''.$mktpaddr.'\',\''.$mktpcity.'\',\''.$mktpprov.'\',\''.$mktpctry.'\',\''.$mainhp01.'\',\''.$mainhp02.'\',\''.$mainmail.'\',\''.$higheduc.'\',\''.$lastschl.'\',\''.$docustat.'\',\''.$mainhobi.'\',\''.$hiredate.'\',\''.$actidate.'\',\''.$maindivi.'\',\''.$namedivi.'\',\''.$mainpstn.'\',\''.$namepstn.'\',\''.$bankcode.'\',\''.$bankname.'\',\''.$bankacct.'\',\''.$bankpers.'\');" 
      style="cursor:pointer">'.$k['EMPL_MAST_CODE'].'</td>';

echo '<td style="width: 200px;" onClick="isiemplmastcode(\''.$mastcode.'\',\''.$frstname.'\',\''.$lastname.'\',\''.$maingend.'\',\''.$mainbirt.'\',\''.$mainblod.'\',\''.$fngrcode.'\',\''.$maintidn.'\',\''.$mainstat.'\',\''.$mktpaddr.'\',\''.$mktpcity.'\',\''.$mktpprov.'\',\''.$mktpctry.'\',\''.$mainhp01.'\',\''.$mainhp02.'\',\''.$mainmail.'\',\''.$higheduc.'\',\''.$lastschl.'\',\''.$docustat.'\',\''.$mainhobi.'\',\''.$hiredate.'\',\''.$actidate.'\',\''.$maindivi.'\',\''.$namedivi.'\',\''.$mainpstn.'\',\''.$namepstn.'\',\''.$bankcode.'\',\''.$bankname.'\',\''.$bankacct.'\',\''.$bankpers.'\');" 
      style="cursor:pointer">'.$k['EMPL_FRST_NAME'].' '.$k['EMPL_LAST_NAME'].'</td>';
      
echo '</tr>';
}
?>
  </tbody>
  </table>


