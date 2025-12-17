<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
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
  <th style="width: 200px;">VEHICLE</th>
  <th style="width: 500px;">DRIVER NAME</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLI_TRANS_CODE, TBLI_TRANS_DRVR,
            (SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = TBLI_TRANS_DRVR) AS EMPL_NAME
            FROM tblitrans 
            WHERE TBLI_VIEW_STAT = 'Y'
            ORDER by TBLI_TRANS_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLI_TRANS_CODE, TBLI_TRANS_DRVR,
            (SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE = TBLI_TRANS_DRVR) AS EMPL_NAME
            FROM tblitrans 
            WHERE TBLI_TRANS_CODE LIKE '$kata%' AND TBLI_VIEW_STAT = 'Y'
            ORDER by TBLI_TRANS_CODE";    
  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outtrancode = $k['TBLI_TRANS_CODE'];
  $outdrivername = $k['EMPL_NAME'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isitrancode(\''.$outtrancode.'\',\''.$outdrivername.'\');" 
      style="cursor:pointer">'.$outtrancode.'</td>';
echo '<td style="width: 500px;" onClick="isitrancode(\''.$outtrancode.'\',\''.$outdrivername.'\');" 
      style="cursor:pointer">'.$outdrivername.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


