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
  <th style="width: 100px;">CODE</th>
  <th style="width: 200px;">RESULT</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //$kata = 'bag';
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLL_MANU_CODE, TBLL_MANU_NAME 
              FROM tbllmanu 
              WHERE TBLL_VIEW_STAT = 'Y'
              ORDER by TBLL_MANU_CODE";    
  }
  else
  {
  $xquery = "SELECT TBLL_MANU_CODE, TBLL_MANU_NAME 
              FROM tbllmanu 
              WHERE TBLL_MANU_NAME LIKE '$kata%'  
              AND TBLL_VIEW_STAT = 'Y'
              ORDER by TBLL_MANU_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $stringcode = $k['TBLL_MANU_CODE'];
  $stringname = $k['TBLL_MANU_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isistringcode(\''.$stringcode.'\',\''.$stringname.'\');" 
      style="cursor:pointer">'.$k['TBLL_MANU_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isistringcode(\''.$stringcode.'\',\''.$stringname.'\');" 
      style="cursor:pointer">'.$k['TBLL_MANU_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>