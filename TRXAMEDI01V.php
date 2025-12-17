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
  <th style="width: 200px">NAMA TINDAKAN</th>
  <th style="width: 100px">TARIF</th>
  <th style="width: 100px">TIPE</th>
  <th style="width: 100px">BAYAR</th>
  <th style="width: 100px">POLI</th>
  <th style="width: 100px">STATUS</th>
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

$xquery = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME, TBLF_MEDI_RATE, TBLF_MEDI_ROOM,
            (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TBLF_MEDI_ROOM) AS POLI_NAME, 
            TBLF_MEDI_TYPE, TBLF_MEDI_PAYM, TBLF_MEDI_ACTI
            FROM tblfmedi WHERE TBLF_VIEW_STAT = 'Y'
            ORDER BY TBLF_UPDT_DATE DESC, TBLF_UPDT_TIME DESC
            LIMIT 10"; 
}
else
{
$xquery = "SELECT TBLF_MEDI_CODE, TBLF_MEDI_NAME, TBLF_MEDI_RATE, TBLF_MEDI_ROOM,
            (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TBLF_MEDI_ROOM) AS POLI_NAME, 
            TBLF_MEDI_TYPE, TBLF_MEDI_PAYM, TBLF_MEDI_ACTI
            FROM tblfmedi WHERE TBLF_MEDI_NAME LIKE '$kata%'
            AND TBLF_VIEW_STAT = 'Y'
            OR TBLF_MEDI_NAME LIKE '%$kata%'
            AND TBLF_VIEW_STAT = 'Y'
            OR (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TBLF_MEDI_ROOM) LIKE '$kata%'
            AND TBLF_VIEW_STAT = 'Y' 
          ORDER by TBLF_UPDT_DATE DESC, TBLF_UPDT_TIME DESC"; 
}
$q = $db->query($xquery) or die("Gagal Tampilkan List Tindakan!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
//      Code | Nama Tindakan | Tarif | Tipe | Pembayaran | Poli |

echo '<tr>';
$medicode = $k['TBLF_MEDI_CODE'];
echo '<td style="width: 100px">'.$k['TBLF_MEDI_CODE'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['TBLF_MEDI_NAME'].'</td>';
$medirate = number_format($k['TBLF_MEDI_RATE'], 0, '', '.');

echo '<td style="width: 100px">Rp.'.$medirate.'</td>';

$xmeditype = $k['TBLF_MEDI_TYPE'];
if ($xmeditype == 'O') { $meditype = 'Operatif';}
else if ($xmeditype == 'N') { $meditype = 'Non Operatif';}
else if ($xmeditype == 'J') { $meditype = 'Jasa';}
else { $meditype = 'Not Defined'; }  
echo '<td style="width: 100px">'.$meditype.'</td>';

$xmedipaym = $k['TBLF_MEDI_PAYM'];
if ($xmedipaym == 'U') { $medipaym = 'Umum';}
else if ($xmedipaym == 'B') { $medipaym = 'BPJS';}
else if ($xmedipaym == 'A') { $medipaym = 'Asuransi';}
else if ($xmedipaym == 'P') { $medipaym = 'Perusahaan';}
else if ($xmedipaym == 'H') { $medipaym = 'Halodoc';}
else { $medipaym = 'Not Defined'; }  
echo '<td style="width: 100px">'.$medipaym.'</td>';


echo '<td style="width: 100px">'.$k['POLI_NAME'].'</td>';

$xmediacti = $k['TBLF_MEDI_ACTI'];
if ($xmediacti == 'A') { $mediacti = 'Aktif';}
else if ($xmediacti == 'N') { $mediacti = 'Tidak Aktif';}
else { $mediacti = 'Not Defined'; }  
echo '<td style="width: 100px">'.$mediacti.'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-view pure-button" onclick="viewcode(\''.$medicode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$medicode.'\');}
              else
              { document.getElementById(\'txtmediname\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


