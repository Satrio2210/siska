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
  <th style="width: 300px">NAMA</th>
  <th style="width: 200px">LOKASI</th>
  <th style="width: 200px">POLI</th>
  <th style="width: 200px">SUPERVISI</th>

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

$xquery = "SELECT WARE_HOUS_CODE, WARE_HOUS_NAME, 
          WARE_HOUS_LOCA, 
          (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE=WARE_HOUS_LOCA) AS LOCA_NAME, 
          WARE_MEDI_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=WARE_MEDI_ROOM) AS MEDI_NAME,
          WARE_EMPL_CODE, 
          (SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE=WARE_EMPL_CODE) AS EMPL_NAME  
          FROM waremast 
          WHERE WARE_HOUS_STAT = 'Y' 
          ORDER by WARE_HOUS_CODE"; 
}
else
{
$xquery = "SELECT WARE_HOUS_CODE, WARE_HOUS_NAME, 
          WARE_HOUS_LOCA, 
          (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE=WARE_HOUS_LOCA) AS LOCA_NAME, 
          WARE_MEDI_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE=WARE_MEDI_ROOM) AS MEDI_NAME,
          WARE_EMPL_CODE, 
          (SELECT CONCAT(EMPL_FRST_NAME,' ',EMPL_LAST_NAME) FROM emplmast WHERE EMPL_MAST_CODE=WARE_EMPL_CODE) AS EMPL_NAME
          FROM waremast 
          WHERE WARE_HOUS_NAME LIKE '$kata%' 
          AND WARE_HOUS_STAT = 'Y' 
          ORDER by WARE_HOUS_CODE"; 
}
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

//|100|200|300|100|100

echo '<tr>';
$houscode = $k['WARE_HOUS_CODE'];
echo '<td style="width: 100px">'.$k['WARE_HOUS_CODE'].'</td>';
echo '<td style="width: 300px">'.$k['WARE_HOUS_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['LOCA_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['MEDI_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['EMPL_NAME'].'</td>';
echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$houscode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$houscode.'\');}
              else
              { document.getElementById(\'txthousname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


