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
  <th style="width: 100px">TYPE CODE</th>
  <th style="width: 200px">TYPE NAME</th>
  <th style="width: 200px">CATEGORY</th>
  <th style="width: 300px">NOTE</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_CATE, TBLI_TYPE_NOTE
          FROM tblitype 
          WHERE TBLI_TYPE_STAT = 'Y' 
          ORDER by TBLI_TYPE_CODE"; 
}
else
{
$xquery = "SELECT TBLI_TYPE_CODE, TBLI_TYPE_NAME, TBLI_TYPE_CATE, TBLI_TYPE_NOTE 
          FROM tblitype 
          WHERE TBLI_TYPE_NAME LIKE '$kata%' 
          AND TBLI_TYPE_STAT = 'Y'
          OR TBLI_TYPE_NOTE LIKE '$kata%'
          AND TBLI_TYPE_STAT = 'Y' 
          ORDER by TBLI_TYPE_CODE"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$typecode = $k['TBLI_TYPE_CODE'];
echo '<td style="width: 100px">'.$k['TBLI_TYPE_CODE'].'</td>';
echo '<td style="width: 200px">'.$k['TBLI_TYPE_NAME'].'</td>';
$typecate = $k['TBLI_TYPE_CATE'];
if ($typecate == 'GE') { $catename = 'General / Umum';}
else if ($typecate == 'RM') { $catename = 'Bahan Material';}
else if ($typecate == 'FG') { $catename = 'Barang Jadi';}
else { $catename = 'Kategori tidak diketahui'; }  
echo '<td style="width: 200px">'.$catename.'</td>';
echo '<td style="width: 300px">'.$k['TBLI_TYPE_NOTE'].'</td>';
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$typecode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$typecode.'\');}
              else
              { document.getElementById(\'txtunitname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


