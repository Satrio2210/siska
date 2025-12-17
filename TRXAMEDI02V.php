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
  <th style="width: 200px">PELAKSANA</th>
  <th style="width: 100px">POLI</th>
  <th style="width: 100px">BAYAR</th>
  <th style="width: 200px">TINDAKAN</th>
  <th style="width: 100px">TARIF</th>
  <th style="width: 100px">FEE USER</th>
  <th style="width: 100px">INCOME</th>
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

$xquery = "SELECT FEE_MAST_CODE, FEE_MAST_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = FEE_MAST_ROOM) AS POLI_NAME, 
          FEE_MAST_PAYM, FEE_MAST_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FEE_MAST_USER) AS USER_NAME, 
          FEE_MEDI_CODE, 
          (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = FEE_MEDI_CODE) AS MEDI_NAME,
          (SELECT TBLF_MEDI_RATE FROM tblfmedi WHERE TBLF_MEDI_CODE = FEE_MEDI_CODE) AS MEDI_RATE, 
          FEE_MAST_RATE, FEE_PART_USER, FEE_PART_HOME 
          FROM feemast WHERE FEE_VIEW_STAT = 'Y'
          ORDER BY FEE_UPDT_DATE DESC, FEE_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{
$xquery = "SELECT FEE_MAST_CODE, FEE_MAST_ROOM, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = FEE_MAST_ROOM) AS POLI_NAME, 
          FEE_MAST_PAYM, FEE_MAST_USER, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FEE_MAST_USER) AS USER_NAME, 
          FEE_MEDI_CODE, 
          (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = FEE_MEDI_CODE) AS MEDI_NAME,
          (SELECT TBLF_MEDI_RATE FROM tblfmedi WHERE TBLF_MEDI_CODE = FEE_MEDI_CODE) AS MEDI_RATE, 
          FEE_MAST_RATE, FEE_PART_USER, FEE_PART_HOME 
          FROM feemast WHERE (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FEE_MAST_USER) LIKE '$kata%'
          AND FEE_VIEW_STAT = 'Y'
          OR (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = FEE_MEDI_CODE) LIKE '$kata%'
          AND FEE_VIEW_STAT = 'Y'
          ORDER by FEE_UPDT_DATE DESC, FEE_UPDT_TIME DESC"; 
}
$q = $db->query($xquery) or die("Gagal Tampilkan List Fee Dokter!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
//      Code | Dokter | Poli | Bayar | Tindakan | Tarif | Fee | Netto | Action
echo '<tr>';
$feecode = $k['FEE_MAST_CODE'];
echo '<td style="width: 100px">'.$k['FEE_MAST_CODE'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['USER_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';

$xmastpaym = $k['FEE_MAST_PAYM'];
if ($xmastpaym == 'U') { $mastpaym = 'Umum';}
else if ($xmastpaym == 'B') { $mastpaym = 'BPJS';}
else if ($xmastpaym == 'A') { $mastpaym = 'Asuransi';}
else if ($xmastpaym == 'P') { $mastpaym = 'Perusahaan';}
else { $mastpaym = 'Not Defined'; }  
echo '<td style="width: 100px">'.$mastpaym.'</td>';

echo '<td style="width: 200px; text-align: left;">'.$k['MEDI_NAME'].'</td>';

$medirate = number_format($k['MEDI_RATE'], 0, '', '.');
echo '<td style="width: 100px">Rp. '.$medirate.'</td>';

$partuser = number_format($k['FEE_PART_USER'], 0, '', '.');
$mastrate = $k['FEE_MAST_RATE'];
if ($mastrate == 'F')
{
echo '<td style="width: 100px">Rp. '.$partuser.'</td>';  
}
else if ($mastrate == 'P')
{
echo '<td style="width: 100px">'.$partuser.' %</td>';  
}
else
{
echo '<td style="width: 100px"></td>';
}
$parthome = number_format($k['FEE_PART_HOME'], 0, '', '.');
echo '<td style="width: 100px">Rp. '.$parthome.'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$feecode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$feecode.'\');}
              else
              { document.getElementById(\'txtmastroom\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


