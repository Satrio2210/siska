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
  <th style="width: 100px">ICD CODE</th>
  <th style="width: 300px">ICD NOTE</th>
  <th style="width: 200px">ICD CATEGORY</th>
  <th style="width: 200px">ICD SUB CATEGORY</th>

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

$xquery = "SELECT DIAG_ICD_CATEGORY, DIAG_ICD_SUBCATE, DIAG_ICD_CODE, DIAG_ICD_NOTE
          FROM diagmast 
          WHERE DIAG_VIEW_STAT = 'Y' 
          ORDER by DIAG_UPDT_DATE DESC, DIAG_UPDT_TIME, DIAG_ICD_CODE LIMIT 100"; 
}
else
{
$xquery = "SELECT DIAG_ICD_CATEGORY, DIAG_ICD_SUBCATE, DIAG_ICD_CODE, DIAG_ICD_NOTE
          FROM diagmast 
          WHERE DIAG_VIEW_STAT = 'Y' AND DIAG_ICD_CODE LIKE '$kata%' 
          OR DIAG_VIEW_STAT = 'Y' AND DIAG_ICD_NOTE LIKE '$kata%'
          OR DIAG_VIEW_STAT = 'Y' AND DIAG_ICD_NOTE LIKE '%$kata%'  
          ORDER by DIAG_UPDT_DATE DESC, DIAG_UPDT_TIME, DIAG_ICD_CODE"; 

}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$icdcode = $k['DIAG_ICD_CODE'];
echo '<td style="width: 100px">'.$k['DIAG_ICD_CODE'].'</td>';
echo '<td style="width: 300px">'.$k['DIAG_ICD_NOTE'].'</td>';
echo '<td style="width: 200px">'.$k['DIAG_ICD_CATEGORY'].'</td>';
echo '<td style="width: 200px">'.$k['DIAG_ICD_SUBCATE'].'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$icdcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$icdcode.'\');}
              else
              { document.getElementById(\'txticdnote\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


