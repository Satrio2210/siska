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
  <th style="width: 100px;">KODE VARIAN</th>
  <th style="width: 200px;">NAMA VARIAN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //$kata = '24';
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLI_VARN_CODE, TBLI_VARN_NAME 
              FROM tblivarn 
              WHERE TBLI_VARN_STAT = 'Y'
              ORDER by TBLI_VARN_CODE";
  }
  else
  {
  $xquery = "SELECT TBLI_VARN_CODE, TBLI_VARN_NAME 
              FROM tblivarn 
              WHERE TBLI_VARN_NAME LIKE '$kata%'  
              AND TBLI_VARN_STAT = 'Y'
              ORDER by TBLI_VARN_CODE";    
  }

 //var_dump($xquery);
 //exit();         

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outvarncode = $k['TBLI_VARN_CODE'];
  $outvarnname = $k['TBLI_VARN_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isivarncode(\''.$outvarncode.'\',\''.$outvarnname.'\');" 
      style="cursor:pointer">'.$k['TBLI_VARN_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isivarncode(\''.$outvarncode.'\',\''.$outvarnname.'\');" 
      style="cursor:pointer">'.$k['TBLI_VARN_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


