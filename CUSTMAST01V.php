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
  <th style="width: 200px">NAMA</th>
  <th style="width: 100px">TIPE</th>
  <th style="width: 100px">LIMIT</th>
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

$xquery = "SELECT CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE, CUST_CRDT_LIMT
           FROM custmast WHERE CUST_VIEW_STAT = 'Y'
          ORDER BY CUST_UPDT_DATE DESC, CUST_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{

$xquery = "SELECT CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE, CUST_CRDT_LIMT
           FROM custmast WHERE CUST_VIEW_STAT = 'Y'
           AND CUST_MAIN_NAME LIKE '$kata%'
           OR CUST_VIEW_STAT = 'Y'
           AND CUST_MAIN_NAME LIKE '%$kata%'
          ORDER BY CUST_UPDT_DATE DESC, CUST_UPDT_TIME DESC"; 

}
$q = $db->query($xquery) or die("Gagal Tampilkan Data Rekanan!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$mastcode = $k['CUST_MAST_CODE'];

echo '<td style="width: 100px">'.$mastcode.'</td>';

echo '<td style="width: 200px">'.$k['CUST_MAIN_NAME'].'</td>';

$status_payment = $k['CUST_MAIN_TYPE'];

if ($status_payment == 'B') 
{
  echo '<td style="width: 100px;">BPJS</td>';
}
else if ($status_payment == 'A')
{
  echo '<td style="width: 100px;">Asuransi</td>';
}
else if ($status_payment == 'P')
{
  echo '<td style="width: 100px;">Perusahaan</td>';
}

else 
{
  echo '<td style="width: 100px;">No Status</td>'; 
} 


$view_limit_amnt = number_format($k['CUST_CRDT_LIMT'], 0, '', '.');
echo '<td style="width: 100px; text-align: right;">'.$view_limit_amnt.'</td>';


echo '<td style="width: 200px">';

echo '<a class="button-view pure-button" onclick="viewcode(\''.$mastcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$mastcode.'\');}
              else
              { document.getElementById(\'txtmainname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


