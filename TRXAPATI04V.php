<?php
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
  <th style="width: 300px">DOCTOR</th>
  <th style="width: 200px">MEDICAL ROOM</th>
  <th style="width: 100px">DAYS</th>
  <th style="width: 100px">START</th>
  <th style="width: 100px">END</th>

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

$xquery = "SELECT TRXA_DOCT_USER, TRXA_DOCT_NAME, 
          TRXA_MEDI_ROOM, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_MEDI_ROOM) AS ROOM_NAME,
          TRXA_SCHD_DAYS, TRXA_SCHD_START, TRXA_SCHD_END, TRXA_SCHD_NOTE, TRXA_ENTR_TIME 
          FROM trxaschd 
          WHERE TRXA_VIEW_STAT = 'Y' 
          ORDER by TRXA_DOCT_NAME, TRXA_SCHD_DAYS ASC"; 
}
else
{
$xquery = "SELECT TRXA_DOCT_USER, TRXA_DOCT_NAME, 
          TRXA_MEDI_ROOM, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_MEDI_ROOM) AS ROOM_NAME,
          TRXA_SCHD_DAYS, TRXA_SCHD_START, TRXA_SCHD_END, TRXA_SCHD_NOTE, TRXA_ENTR_TIME 
          FROM trxaschd 
          WHERE TRXA_DOCT_NAME LIKE '$kata%' AND TRXA_VIEW_STAT = 'Y'
          OR TRXA_DOCT_NAME LIKE '%$kata%' AND TRXA_VIEW_STAT = 'Y' 
          ORDER by TRXA_DOCT_USER"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$doctuser = $k['TRXA_DOCT_USER'];
echo '<td style="width: 300px">'.$k['TRXA_DOCT_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['ROOM_NAME'].'</td>';

$schddays = $k['TRXA_SCHD_DAYS'];
if ($schddays == '0') { $namedays = 'Minggu'; }
else if ($schddays == '1') { $namedays = 'Senin'; }
else if ($schddays == '2') { $namedays = 'Selasa'; }
else if ($schddays == '3') { $namedays = 'Rabu'; }
else if ($schddays == '4') { $namedays = 'Kamis'; }
else if ($schddays == '5') { $namedays = 'Jumat'; }
else if ($schddays == '6') { $namedays = 'Sabtu'; }
else { $namedays = 'Fail get Day name'; }

echo '<td style="width: 100px">'.$namedays.'</td>';
echo '<td style="width: 100px">'.$k['TRXA_SCHD_START'].'</td>'; echo '<td style="width: 100px">'.$k['TRXA_SCHD_END'].'</td>';
$schdstart = $k['TRXA_SCHD_START'];
$schdend = $k['TRXA_SCHD_END'];
$entrtime = $k['TRXA_ENTR_TIME'];

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$doctuser.'\',\''.$schddays.'\',\''.$schdstart.'\',\''.$schdend.'\',\''.$entrtime.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$doctuser.'\',\''.$schddays.'\',\''.$schdstart.'\',\''.$schdend.'\',\''.$entrtime.'\');}
              else
              { document.getElementById(\'txtdoctname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


