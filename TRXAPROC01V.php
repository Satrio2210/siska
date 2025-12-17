<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
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
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px">TASK</th>
  <th style="width: 200px">ITEM</th>
  <th style="width: 200px">QTY ORDER</th>
  <th style="width: 200px">UNIT PRICE</th>
  <th style="width: 200px">SUB TOTAL</th>
  
  </tr>
  </thead>
  <tbody>
<?php
$kodetransaksi = xss_clean($_POST['q']);
//$kodetransaksi = 'PO-0001';


$xquery = 
"SELECT ITEM_PART_CODE, 
(SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = ITEM_PART_CODE LIMIT 1) AS PART_NAME,
ITEM_QUTY_ORDR, ITEM_PART_UNIT,
(SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = ITEM_PART_UNIT LIMIT 1) AS UNIT_NAME,
ITEM_PART_PRIC, (ITEM_QUTY_ORDR * ITEM_PART_PRIC) AS TOTA_PRIC, ITEM_ENTR_TIME
  FROM itemproc
  WHERE ITEM_PROC_CODE = '$kodetransaksi' AND ITEM_VIEW_STAT='Y'
  ORDER BY ITEM_PART_CODE DESC
";
  $q = $db->query($xquery) or die("Gagal Get Tabel item");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$partcode = $k['ITEM_PART_CODE'];
$entrtime = $k['ITEM_ENTR_TIME'];
$xunitname = $k['UNIT_NAME'];
$posisi=strpos($xunitname,"@");

if ($posisi)
{
list($unitname,$subunitname) = explode("@",$xunitname);
}
else 
{
$unitname = $xunitname; 
}

echo '<td style="width: 100px;">';

echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapusitem(\''.$kodetransaksi.'\',\''.$partcode.'\',\''.$entrtime.'\');}
              else
              { document.getElementById(\'txtpartname\').focus();}
              ">Delete</a></td>';


echo '<td style="width: 200px">'.$k['PART_NAME'].'</td>';
$qtyorder = number_format($k['ITEM_QUTY_ORDR'], 0, '', '.');
echo '<td style="width: 200px">'.$qtyorder.' '.$unitname.'</td>';
$xpartpric = $k['ITEM_PART_PRIC'];
$partpric = number_format($xpartpric, 0, '', '.');
echo '<td style="width: 200px; text-align: right;">Rp.'.$partpric.'</td>';
$xtotapric = $k['TOTA_PRIC'];
$totapric = number_format($xtotapric, 0, '', '.');
echo '<td style="width: 200px; text-align: right;">Rp.'.$totapric.'</td>';
echo '</tr>';
}

$query_total = 
"
SELECT SUM(ITEM_QUTY_ORDR * ITEM_PART_PRIC) AS TOTA_PRIC
      FROM itemproc
      WHERE ITEM_PROC_CODE = '$kodetransaksi' AND ITEM_VIEW_STAT='Y'";

$q_total = $db->query($query_total) or die("Gagal Get SUM Total");
$data_total = $q_total->fetch(PDO::FETCH_ASSOC);
$total = $data_total['TOTA_PRIC'];
$view_total = number_format($total, 0, '', '.');
?>

<tr>
  <td colspan=3></td>
  <td style="text-align: left;"><b>Total</b></td>
  <td style="text-align: right;"><b>Rp.<?php echo $view_total; ?></b></td>
</tr>
  </tbody>
  </table>


