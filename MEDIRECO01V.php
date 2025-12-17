<?php
include "conf/config.php";
include "inc/sanie.php";
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

  <th style="width: 100px">No RM</th>
  <th style="width: 150px">NIK</th>
  <th style="width: 200px">Nama Pasien</th>
  <th style="width: 100px">L/P</th>
  <th style="width: 300px">Alamat</th>
  <th style="width: 200px">Status Pasien</th>
  <th style="width: 100px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, 
           PATI_MAIN_ADDR, PATI_MAIN_STAT
           FROM patimast WHERE PATI_VIEW_STAT = 'Y' ORDER BY PATI_ENTR_DATE DESC, PATI_ENTR_TIME DESC
           LIMIT 20";

}
else
{
$xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, 
           PATI_MAIN_ADDR, PATI_MAIN_STAT
           FROM patimast WHERE PATI_VIEW_STAT = 'Y' AND PATI_MAIN_NAME LIKE '$kata%'
           OR PATI_VIEW_STAT = 'Y' AND PATI_MAIN_NAME LIKE '%$kata%'
           OR PATI_MAST_CODE = '$kata'
           ORDER BY PATI_ENTR_DATE DESC, PATI_ENTR_TIME DESC 
           LIMIT 20";

}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$paticode = $k['PATI_MAST_CODE'];
$nikcode = $k['PATI_MAIN_PIDN'];

echo '<td style="width: 100px">'.$k['PATI_MAST_CODE'].'</td>';
echo '<td style="width: 150px; text-align: left;">'.$k['PATI_MAIN_PIDN'].'</td>';
//$regidate = date("d-m-Y", strtotime($k['TRXA_ENTR_DATE']));
echo '<td style="width: 200px;text-align: left;">'.$k['PATI_MAIN_NAME'].'</td>';

$maingend = $k['PATI_MAIN_GEND'];
if ($maingend == 'M')
{
  echo '<td style="width: 100px"> Laki-laki </td>'; 
}
else if ($maingend == 'F')
{
 echo '<td style="width: 100px"> Perempuan </td>'; 
}
else
{
 echo '<td style="width: 100px"> No gender </td>'; 
}

echo '<td style="width: 300px;text-align: left;">'.$k['PATI_MAIN_ADDR'].'</td>';

echo '<td style="width: 200px">'.$k['PATI_MAIN_STAT'].'</td>';

echo '<td style="width: 100px"><a class="button-view pure-button" onclick="viewcode(\''.$paticode.'\');">Detail</a>';
                                 //<a class="button-print pure-button" onclick="if (document.getElementById(\'hidregicode\').value == \'\')
                                 //   { alert(\'Pilih dahulu pasien!\'); }
                                 //   else
                                //{ document.frmtrxasale.submit(); }">Print</a>';  
echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


