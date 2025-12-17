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
  <th style="width: 100px">MANUAL CODE</th>
  <th style="width: 300px">TEKS</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
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
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$manucode = $k['TBLL_MANU_CODE'];
echo '<td style="width: 100px">'.$k['TBLL_MANU_CODE'].'</td>';
echo '<td style="width: 300px">'.$k['TBLL_MANU_NAME'].'</td>';
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$manucode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$manucode.'\');}
              else
              { document.getElementById(\'txtmanuname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


