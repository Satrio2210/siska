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
  <th style="width: 100px">KATEGORI</th>
  <th style="width: 200px">TINDAKAN</th>
  <th style="width: 200px">PEMERIKSAAN</th>
  <th style="width: 100px">SATUAN</th>
  <th style="width: 100px">KUANTITATIF</th>
  <th style="width: 100px">KUALITATIF</th>
  <th style="width: 100px">USIA</th>
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

$xquery = "SELECT LABO_MAST_CODE, LABO_SUBS_CODE, 
          (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE = LABO_SUBS_CODE) AS SUBS_NAME,
          LABO_SIZE_CODE, (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=LABO_SIZE_CODE) AS MEDI_NAME, 
          LABO_SIZE_NAME, LABO_UNIT_NAME, 
          (SELECT TBLL_UNIT_NAME FROM tbllunit WHERE TBLL_UNIT_CODE = LABO_UNIT_NAME) AS UNIT_NAME,
          LABO_VALU_MIN, LABO_VALU_MAX, LABO_VALU_STRG, LABO_PATI_GEND 
          FROM labomast WHERE LABO_VIEW_STAT = 'Y'
          ORDER BY LABO_UPDT_DATE DESC, LABO_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{

$xquery = "SELECT LABO_MAST_CODE, LABO_SUBS_CODE, 
          (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE = LABO_SUBS_CODE) AS SUBS_NAME, 
          LABO_SIZE_CODE, (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=LABO_SIZE_CODE) AS MEDI_NAME, 
          LABO_SIZE_NAME, LABO_UNIT_NAME, 
          (SELECT TBLL_UNIT_NAME FROM tbllunit WHERE TBLL_UNIT_CODE = LABO_UNIT_NAME) AS UNIT_NAME,
          LABO_VALU_MIN, LABO_VALU_MAX, LABO_VALU_STRG, LABO_PATI_GEND 
          FROM labomast 
          WHERE LABO_VIEW_STAT = 'Y' AND LABO_SIZE_NAME LIKE '$kata%'
          OR LABO_VIEW_STAT = 'Y' AND LABO_MAST_CODE LIKE '$kata%'
          OR LABO_VIEW_STAT = 'Y' AND (SELECT TBLL_EXAM_NAME FROM tbllexam WHERE TBLL_EXAM_CODE = LABO_SUBS_CODE) LIKE '$kata%'
          OR LABO_VIEW_STAT = 'Y' AND (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=LABO_SIZE_CODE) LIKE '$kata%'
          
          ORDER BY LABO_UPDT_DATE DESC, LABO_UPDT_TIME DESC"; 

}
$q = $db->query($xquery) or die("Gagal Tampilkan List Pemeriksaan!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$mastcode = $k['LABO_MAST_CODE'];
echo '<td style="width: 100px">'.$k['LABO_MAST_CODE'].'</td>';

echo '<td style="width: 100px">'.$k['SUBS_NAME'].'</td>';

echo '<td style="width: 200px">'.$k['MEDI_NAME'].'</td>';

echo '<td style="width: 200px">'.$k['LABO_SIZE_NAME'].'</td>';

echo '<td style="width: 100px">'.$k['LABO_UNIT_NAME'].'</td>';

if ($k['LABO_VALU_MIN'] == '<')
{
echo '<td style="width: 100px">'.$k['LABO_VALU_MIN'].' '.$k['LABO_VALU_MAX'].'</td>';
}
else if ($k['LABO_VALU_MIN'] == '>')
{
echo '<td style="width: 100px">'.$k['LABO_VALU_MIN'].' '.$k['LABO_VALU_MAX'].'</td>';  
} 
else
{
echo '<td style="width: 100px">'.$k['LABO_VALU_MIN'].' - '.$k['LABO_VALU_MAX'].'</td>';  
}

echo '<td style="width: 100px">'.$k['LABO_VALU_STRG'].'</td>'; 


if ($k['LABO_PATI_GEND'] == 'M') { $patigend = 'Pria';}
else if ($k['LABO_PATI_GEND'] == 'F') { $patigend = 'Wanita';}
else if ($k['LABO_PATI_GEND'] == 'C') { $patigend = 'Anak anak';}
else { $patigend = 'Not Defined'; }  
echo '<td style="width: 100px">'.$patigend.'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$mastcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$mastcode.'\');}
              else
              { document.getElementById(\'txtsubscode\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


