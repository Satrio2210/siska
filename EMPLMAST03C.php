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

  $xquery = "SELECT EMPL_MAST_CODE, EMPL_FRST_NAME, EMPL_LAST_NAME, 
                    EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_DOCU_STAT, 
                    EMPL_HIRE_DATE, EMPL_ACTI_DATE, 
            EMPL_MAIN_DIVI, 
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS EMPL_NAME_DIVI,     
                    EMPL_MAIN_PSTN, 
            (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS EMPL_NAME_PSTN
FROM emplmast
WHERE EMPL_VIEW_STAT = 'Y'";
}
else
{
  $xquery = "SELECT EMPL_MAST_CODE, EMPL_FRST_NAME, EMPL_LAST_NAME, 
                    EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_DOCU_STAT, 
                    EMPL_HIRE_DATE, EMPL_ACTI_DATE, 
            EMPL_MAIN_DIVI, 
            (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS EMPL_NAME_DIVI,     
                    EMPL_MAIN_PSTN, 
            (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS EMPL_NAME_PSTN
FROM emplmast
WHERE EMPL_VIEW_STAT = 'Y'
AND EMPL_FRST_NAME LIKE '$kata%'";

}

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  //mastcode, frstname, lastname,higheduc, lastschl, docustat,hiredate,    actidate,namedivi,       maindivim   namepstn,   mainpstn
  $mastcode = $k['EMPL_MAST_CODE'];  $frstname = $k['EMPL_FRST_NAME'];  $lastname = $k['EMPL_LAST_NAME'];
  $higheduc = $k['EMPL_HIGH_EDUC'];  $lastschl = $k['EMPL_LAST_SCHL'];  $docustat = $k['EMPL_DOCU_STAT'];  
  $hiredate = $k['EMPL_HIRE_DATE'];  $actidate = $k['EMPL_ACTI_DATE'];  
  $namedivi = $k['EMPL_NAME_DIVI'];  $maindivi = $k['EMPL_MAIN_DIVI'];  
  $namepstn = $k['EMPL_NAME_PSTN'];  $mainpstn = $k['EMPL_MAIN_PSTN']; 
  
echo '<tr>';

echo '<td style="width: 100px;" onClick="isiemplmastcode(\''.$mastcode.'\',\''.$frstname.'\',\''.$lastname.'\',\''.$higheduc.'\',\''.$lastschl.'\',\''.$docustat.'\',\''.$hiredate.'\',\''.$actidate.'\',\''.$namedivi.'\',\''.$maindivi.'\',\''.$namepstn.'\',\''.$mainpstn.'\');" 
      style="cursor:pointer">'.$k['EMPL_MAST_CODE'].'</td>';

echo '<td style="width: 200px;" onClick="isiemplmastcode(\''.$mastcode.'\',\''.$frstname.'\',\''.$lastname.'\',\''.$higheduc.'\',\''.$lastschl.'\',\''.$docustat.'\',\''.$hiredate.'\',\''.$actidate.'\',\''.$namedivi.'\',\''.$maindivi.'\',\''.$namepstn.'\',\''.$mainpstn.'\');" 
      style="cursor:pointer">'.$k['EMPL_FRST_NAME'].' '.$k['EMPL_LAST_NAME'].'</td>';
      
echo '</tr>';
}
?>
  </tbody>
  </table>


