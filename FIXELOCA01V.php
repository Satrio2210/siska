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
  <th style="width: 100px">KODE</th>
  <th style="width: 300px">NAMA LOKASI</th>
  <th style="width: 500px">ALAMAT</th>
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

$xquery = "SELECT FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR
          FROM fixeloca 
          WHERE FIXE_VIEW_STAT = 'Y' 
          ORDER by FIXE_LOCA_CODE"; 
}
else
{
$xquery = "SELECT FIXE_LOCA_CODE, FIXE_LOCA_NAME, FIXE_LOCA_ADDR 
          FROM fixeloca 
          WHERE FIXE_LOCA_NAME LIKE '$kata%' 
          AND FIXE_VIEW_STAT = 'Y' 
          ORDER by FIXE_LOCA_CODE"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$locacode = $k['FIXE_LOCA_CODE'];
echo '<td style="width: 100px">'.$k['FIXE_LOCA_CODE'].'</td>';
echo '<td style="width: 300px">'.$k['FIXE_LOCA_NAME'].'</td>';
echo '<td style="width: 500px">'.$k['FIXE_LOCA_ADDR'].'</td>';
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$locacode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$locacode.'\');}
              else
              { document.getElementById(\'txtlocaname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


