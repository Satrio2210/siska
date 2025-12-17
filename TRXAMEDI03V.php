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
  <th style="width: 100px">CODE</th>
  <th style="width: 100px">PAYMENT</th>
  <th style="width: 100px">ROOM</th>
  <th style="width: 200px">DOCTOR</th>
  <th style="width: 100px">OPTION</th>
  <th style="width: 100px">NOMINAL</th>
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

$xquery = "SELECT ATT_MAST_CODE, ATT_MAST_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = ATT_MAST_ROOM) AS POLI_NAME, 
          ATT_MAST_PAYM, ATT_MAST_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ATT_MAST_USER) AS USER_NAME,
          ATT_MAST_RATE, ATT_NOMI_AMNT 
          FROM attmast WHERE ATT_VIEW_STAT = 'Y'
          ORDER BY ATT_UPDT_DATE DESC, ATT_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{
$xquery = "SELECT ATT_MAST_CODE, ATT_MAST_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = ATT_MAST_ROOM) AS POLI_NAME, 
          ATT_MAST_PAYM, ATT_MAST_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ATT_MAST_USER) AS USER_NAME,
          ATT_MAST_RATE, ATT_NOMI_AMNT 
          FROM attmast WHERE (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ATT_MAST_USER) LIKE '$kata%'
          AND ATT_VIEW_STAT = 'Y'
          OR (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = ATT_MAST_ROOM) LIKE '$kata%'
          AND ATT_VIEW_STAT = 'Y' 
          ORDER by ATT_UPDT_DATE DESC, ATT_UPDT_TIME DESC"; 
}
$q = $db->query($xquery) or die("Gagal Tampilkan List Kehadiran!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$attcode = $k['ATT_MAST_CODE'];
echo '<td style="width: 100px">'.$k['ATT_MAST_CODE'].'</td>';

$xmastpaym = $k['ATT_MAST_PAYM'];
if ($xmastpaym == 'U') { $mastpaym = 'Umum';}
else if ($xmastpaym == 'B') { $mastpaym = 'BPJS';}
else if ($xmastpaym == 'A') { $mastpaym = 'Asuransi';}
else if ($xmastpaym == 'P') { $mastpaym = 'Perusahaan';}
else { $mastpaym = 'Not Defined'; }  
echo '<td style="width: 100px">'.$mastpaym.'</td>';

echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';

echo '<td style="width: 200px; text-align: left;">'.$k['USER_NAME'].'</td>';

$xmastrate = $k['ATT_MAST_RATE'];
if ($xmastrate == 'P') { $mastrate = 'per Pasien';}
else if ($xmastrate == 'D') { $mastrate = 'per Hari';}
else { $mastrate = 'Not Defined'; }  

echo '<td style="width: 100px">'.$mastrate.'</td>';

$nomiamnt = number_format($k['ATT_NOMI_AMNT'], 0, '', '.');
echo '<td style="width: 100px">'.$nomiamnt.'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$attcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$attcode.'\');}
              else
              { document.getElementById(\'txtmastroom\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


