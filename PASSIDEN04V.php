<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
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
  <th style="width: 100px">USER ID</th>
  <th style="width: 100px">NIK</th>
  <th style="width: 200px">NAMA USER</th>
  <th style="width: 150px">TIPE USER</th>
  <th style="width: 300px">EMAIL</th>



  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ $xquery = "SELECT PASS_USER_IDEN, PASS_EMPL_CODE, PASS_USER_NAME, PASS_USER_TYPE,  
            (SELECT EMPL_MAIN_MAIL FROM emplmast WHERE EMPL_MAST_CODE = PASS_EMPL_CODE) AS MAIN_MAIL 
            FROM passiden ORDER by PASS_USER_NAME"; }
else
{ $xquery = "SELECT PASS_USER_IDEN, PASS_EMPL_CODE, PASS_USER_NAME, PASS_USER_TYPE,  
            (SELECT EMPL_MAIN_MAIL FROM emplmast WHERE EMPL_MAST_CODE = PASS_EMPL_CODE) AS MAIN_MAIL 
            FROM passiden WHERE PASS_USER_NAME LIKE '$kata%' ORDER BY PASS_USER_NAME"; }

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 100px">'.$k['PASS_USER_IDEN'].'</td>';
echo '<td style="width: 100px">'.$k['PASS_EMPL_CODE'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['PASS_USER_NAME'].'</td>';
$usertype = $k['PASS_USER_TYPE'];
if ($usertype == 'Y')
{
  echo '<td style="width: 150px"> Staff Medis </td>';  
}
else
{
  echo '<td style="width: 150px">Staff Non Medis</td>'; 
}
echo '<td style="width: 300px">'.$k['MAIN_MAIL'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


