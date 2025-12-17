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
  <th style="width: 100px">CODE</th>
  <th style="width: 200px">PEMASOK</th>
  <th style="width: 100px">KOTA</th>
  <th style="width: 250px">EMAIL</th>
  <th style="width: 100px">KONTAK</th>
  <th style="width: 150px">NPWP</th>
  <th style="width: 100px">TERMIN</th>
  <th style="width: 200px">LIMIT</th>


  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 

$xquery = "SELECT SUPL_MAST_CODE, SUPL_MAIN_NAME, 
                  SUPL_MAIN_CITY, SUPL_MAIN_MAIL,
                  SUPL_MAIN_PERS, SUPL_MAIN_TIDN,
                  SUPL_MAIN_TERM, SUPL_PAYA_LIMT 
          FROM suplmast 
          WHERE SUPL_VIEW_STAT = 'Y' 
          ORDER by SUPL_MAST_CODE"; 
}
else
{ 
$xquery = "SELECT SUPL_MAST_CODE, SUPL_MAIN_NAME, 
                  SUPL_MAIN_CITY, SUPL_MAIN_MAIL,
                  SUPL_MAIN_PERS, SUPL_MAIN_TIDN,
                  SUPL_MAIN_TERM, SUPL_PAYA_LIMT 
          FROM suplmast 
          WHERE SUPL_MAST_CODE LIKE '$kata%' AND SUPL_VIEW_STAT = 'Y'  
          OR    SUPL_MAIN_NAME LIKE '$kata%' AND SUPL_VIEW_STAT = 'Y'
          ORDER by SUPL_MAST_CODE"; 
}

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 100px">'.$k['SUPL_MAST_CODE'].'</td>';
echo '<td style="width: 200px; text-align:left;">'.$k['SUPL_MAIN_NAME'].'</td>';
echo '<td style="width: 100px; text-align:left;">'.$k['SUPL_MAIN_CITY'].'</td>';
echo '<td style="width: 250px">'.$k['SUPL_MAIN_MAIL'].'</td>';
echo '<td style="width: 100px">'.$k['SUPL_MAIN_PERS'].'</td>';
echo '<td style="width: 150px">'.$k['SUPL_MAIN_TIDN'].'</td>';
echo '<td style="width: 100px">'.$k['SUPL_MAIN_TERM'].'</td>';
$sumlimit = number_format($k['SUPL_PAYA_LIMT'], 0, '', '.');
echo '<td style="width: 200px">Rp. '.$sumlimit.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


