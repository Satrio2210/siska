<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
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
  <th style="width: 100px;">CODE</th>
  <th style="width: 200px;">NAME</th>
  </tr>
  </thead>
  <tbody>
<?php
$rawdata = xss_clean($_POST['q']);
//$rawdata = 'PK|N|U|a';
list($room,$type,$paym,$kata) = explode("|", $rawdata);
 
  //$kata = $_POST['q'];
  //$kata = 'bag';
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME 
              FROM tblfmedi 
              WHERE TBLF_MEDI_ROOM = '$room' AND TBLF_MEDI_TYPE = '$type' AND TBLF_MEDI_PAYM = '$paym'  
              AND TBLF_MEDI_ACTI = 'A' AND TBLF_VIEW_STAT = 'Y'
              ORDER by TBLF_MEDI_NAME";    

  
  $xxxxxxxquery = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME 
              FROM tblfmedi 
              WHERE TBLF_MEDI_ACTI = 'A' AND TBLF_VIEW_STAT = 'Y'
              ORDER by TBLF_MEDI_NAME";    

  }
  else
  {
  $xquery = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME 
              FROM tblfmedi 
              WHERE TBLF_MEDI_ROOM = '$room' AND TBLF_MEDI_TYPE = '$type' AND TBLF_MEDI_PAYM = '$paym'
              AND TBLF_MEDI_NAME LIKE '$kata%'  
              AND TBLF_MEDI_ACTI = 'A' AND TBLF_VIEW_STAT = 'Y'
              ORDER by TBLF_MEDI_NAME";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $medicode = $k['TBLF_MEDI_CODE'];
  $mediname = $k['TBLF_MEDI_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isimedicode(\''.$medicode.'\',\''.$mediname.'\');" 
      style="cursor:pointer">'.$k['TBLF_MEDI_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isimediname(\''.$medicode.'\',\''.$mediname.'\');" 
      style="cursor:pointer">'.$k['TBLF_MEDI_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>