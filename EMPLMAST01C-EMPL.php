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
  <th style="width: 200px;">EMPL CODE</th>
  <th style="width: 500px;">EMPL NAME</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT EMPL_MAST_CODE, CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) AS EMPL_MAST_NAME 
              FROM emplmast 
              WHERE EMPL_VIEW_STAT = 'Y'
              ORDER by EMPL_MAST_CODE LIMIT 20";    
  }
  else
  {
  $xquery = "SELECT EMPL_MAST_CODE, CONCAT(EMPL_FRST_NAME, ' ', EMPL_LAST_NAME) AS EMPL_MAST_NAME 
              FROM emplmast 
              WHERE EMPL_FRST_NAME LIKE '$kata%' OR EMPL_LAST_NAME LIKE '$kata%'  
              AND EMPL_VIEW_STAT = 'Y'
              ORDER by EMPL_MAST_CODE";        
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outemplcode = $k['EMPL_MAST_CODE'];
  $outmastname = $k['EMPL_MAST_NAME'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isiemplcode(\''.$outemplcode.'\',\''.$outmastname.'\');" 
      style="cursor:pointer">'.$k['EMPL_MAST_CODE'].'</td>';
echo '<td style="width: 500px;" onClick="isiemplcode(\''.$outemplcode.'\',\''.$outmastname.'\');" 
      style="cursor:pointer">'.$k['EMPL_MAST_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


