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
  <th style="width: 200px">Tindakan</th>
  <th style="width: 100px">Biaya</th>
  <th style="width: 100px">Qty</th>
  <th style="width: 100px">Total.</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$tretcode = xss_clean($_POST['q']);

$xquery = "SELECT TRXA_TRET_CODE, TRXA_MEDI_CODE, (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE = TRXA_MEDI_CODE) AS MEDI_NAME,
           TRXA_MEDI_RATE, TRXA_TRET_QUTY, (TRXA_MEDI_RATE * TRXA_TRET_QUTY) AS TOTAL
          FROM trxatret 
          WHERE TRXA_TRET_STAT='I' AND TRXA_TRET_CODE='$tretcode' AND TRXA_VIEW_STAT='Y'
          ORDER BY TRXA_MEDI_CODE";

$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 

echo '<tr>';
$medicode = $k['TRXA_MEDI_CODE'];
echo '<td style="width: 200px">'.$k['MEDI_NAME'].'</td>';

$viewrate = number_format($k['TRXA_MEDI_RATE'], 0, '', '.');
echo '<td style="width: 100px; text-align: right;">'.$viewrate.'</td>';

echo '<td style="width: 100px">'.$k['TRXA_TRET_QUTY'].'</td>';

$viewtotal = number_format($k['TOTAL'], 0, '', '.');
echo '<td style="width: 100px; text-align: right;">'.$viewtotal.'</td>';

echo '<td style="width: 200px">';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$tretcode.'\',\''.$medicode.'\');}
              else
              { document.getElementById(\'txtmedicode\').focus();}
              ">Delete</a>';

echo '</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


