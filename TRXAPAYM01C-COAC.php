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
  <th style="width: 100px;">CODE</th>
  <th style="width: 200px;">GROUP</th>
  <th style="width: 200px;">NAME</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];

  if (strlen($kata) == 1)
  {

  $xquery = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_PRNT, COAC_MAST_NAME, 
             (SELECT TBLA_COAC_NAME FROM tblacoac WHERE TBLA_COAC_CODE=COAC_MAST_PRNT) AS PRNT_NAME
             FROM coacmast 
             WHERE COAC_MAST_PRNT = '1.1' AND COAC_VIEW_STAT='Y'
             ORDER BY MAST_CODE";            
  }
  else
  {
  $xquery = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE, COAC_MAST_PRNT, COAC_MAST_NAME, 
             (SELECT TBLA_COAC_NAME FROM tblacoac WHERE TBLA_COAC_CODE=COAC_MAST_PRNT) AS PRNT_NAME
             FROM coacmast 
             WHERE COAC_MAST_NAME LIKE '$kata%' 
             AND COAC_MAST_PRNT = '1.1' AND COAC_VIEW_STAT='Y'
             ORDER BY MAST_CODE";            
  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  //$coaccode = $k['COAC_MAST_CODE'];
  $coaccode = $k['MAST_CODE'];
  $prntname = $k['PRNT_NAME'];
  $coacname = $k['COAC_MAST_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isicoaccode(\''.$coaccode.'\',\''.$coacname.'\');" 
      style="cursor:pointer">'.$k['MAST_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isicoaccode(\''.$coaccode.'\',\''.$coacname.'\');" 
      style="cursor:pointer">'.$k['PRNT_NAME'].'</td>';
echo '<td style="width: 200px;" onClick="isicoaccode(\''.$coaccode.'\',\''.$coacname.'\');" 
      style="cursor:pointer">'.$k['COAC_MAST_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


