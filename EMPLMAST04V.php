<?php
include "conf/config.php";
?>
<style>
#screen {
    font-family: Arial, Helvetica, sans-serif;
    font-size:11;
    border-collapse: collapse;
    width: 100%;
}


#screen th {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}

#screen td {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center;
}

#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

table tbody, table thead
{
    display: block;
}
table tbody 
{
  overflow: auto;
  height: 300px;
}
</style>
  <table id="screen">
  <thead>
  <tr>

  <th style="width: 100px">ID Employer</th>
  <th style="width: 200px">Name Employer</th>
  <th style="width: 300px">E-Mail</th>
  <th style="width: 100px">Grade</th>
  <th style="width: 200px">School</th>
  <th style="width: 100px">Start</th>
  <th style="width: 200px">Division</th>
  <th style="width: 100px">Position</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT EMPL_MAST_CODE, CONCAT(EMPL_FRST_NAME,' ', EMPL_LAST_NAME) AS EMPL_MAIN_NAME,
            EMPL_MAIN_MAIL, EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_HIRE_DATE, 
            EMPL_MAIN_DIVI, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS NAME_DIVI,
            EMPL_MAIN_PSTN, (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS NAME_PSTN
            FROM emplmast 
           WHERE EMPL_VIEW_STAT = 'Y'
           ORDER by EMPL_MAST_CODE LIMIT 10"; 
}
else
{ 
$xquery = "SELECT EMPL_MAST_CODE, CONCAT(EMPL_FRST_NAME,' ', EMPL_LAST_NAME) AS EMPL_MAIN_NAME,
            EMPL_MAIN_MAIL, EMPL_HIGH_EDUC, EMPL_LAST_SCHL, EMPL_HIRE_DATE, 
            EMPL_MAIN_DIVI, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = EMPL_MAIN_DIVI) AS NAME_DIVI,
            EMPL_MAIN_PSTN, (SELECT TBLE_POST_NAME FROM tblepost WHERE TBLE_POST_CODE = EMPL_MAIN_PSTN) AS NAME_PSTN
            FROM emplmast 
           WHERE EMPL_FRST_NAME LIKE '$kata%'  
           AND EMPL_VIEW_STAT = 'Y'
           ORDER by EMPL_MAST_CODE";
               
            }
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 100px"><b>'.$k['EMPL_MAST_CODE'].'</b></td>';
echo '<td style="width: 200px">'.$k['EMPL_MAIN_NAME'].'</td>';
echo '<td style="width: 300px">'.$k['EMPL_MAIN_MAIL'].'</td>';
echo '<td style="width: 100px">'.$k['EMPL_HIGH_EDUC'].'</td>';
echo '<td style="width: 200px">'.$k['EMPL_LAST_SCHL'].'</td>';
echo '<td style="width: 100px">'.$k['EMPL_HIRE_DATE'].'</td>';
echo '<td style="width: 200px">'.$k['NAME_DIVI'].'</td>';
echo '<td style="width: 100px">'.$k['NAME_PSTN'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


