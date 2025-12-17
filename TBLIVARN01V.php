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
  <th style="width: 100px">VARN CODE</th>
  <th style="width: 300px">VARN NAME</th>
  <th style="width: 300px">VARN NOTE</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TBLI_VARN_CODE, TBLI_VARN_NAME, TBLI_VARN_NOTE
          FROM tblivarn 
          WHERE TBLI_VARN_STAT = 'Y' 
          ORDER by TBLI_VARN_CODE"; 
}
else
{
$xquery = "SELECT TBLI_VARN_CODE, TBLI_VARN_NAME, TBLI_VARN_NOTE 
          FROM tblivarn 
          WHERE TBLI_VARN_NAME LIKE '$kata%' 
          AND TBLI_VARN_STAT = 'Y'
          OR TBLI_VARN_NOTE LIKE '$kata%' 
          AND TBLI_VARN_STAT = 'Y' 
          ORDER by TBLI_VARN_CODE"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$varncode = $k['TBLI_VARN_CODE'];
echo '<td style="width: 100px">'.$k['TBLI_VARN_CODE'].'</td>';
echo '<td style="width: 300px">'.$k['TBLI_VARN_NAME'].'</td>';
echo '<td style="width: 300px">'.$k['TBLI_VARN_NOTE'].'</td>';
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$varncode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$varncode.'\');}
              else
              { document.getElementById(\'txtvarnname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


