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
  <th style="width: 200px">PEMBAYARAN</th>
  <th style="width: 200px">TERTANGGUNG</th>
  <th style="width: 200px">NAMA OBAT</th>
  <th style="width: 100px">SATUAN</th>
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

$xquery = "SELECT TRXA_LIST_CODE, TRXA_INVE_CODE, (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS INVE_NAME,
           (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS SPEC_CODE,
           (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=SPEC_CODE) AS SPEC_NAME,
           (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS UNIT_CODE,
           (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,

           TRXA_CUST_CODE, (SELECT CUST_MAIN_NAME FROM custmast WHERE CUST_MAST_CODE=TRXA_CUST_CODE) AS CUST_NAME,
           TRXA_CUST_TYPE
           FROM trxacust WHERE TRXA_VIEW_STAT = 'Y'
          ORDER BY TRXA_UPDT_DATE DESC, TRXA_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{

$xquery = "SELECT TRXA_LIST_CODE, TRXA_INVE_CODE, (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS INVE_NAME,
           (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS SPEC_CODE,
           (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=SPEC_CODE) AS SPEC_NAME,
           (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) AS UNIT_CODE,
           (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE=UNIT_CODE) AS UNIT_NAME,

           TRXA_CUST_CODE, (SELECT CUST_MAIN_NAME FROM custmast WHERE CUST_MAST_CODE=TRXA_CUST_CODE) AS CUST_NAME,
           TRXA_CUST_TYPE
           FROM trxacust WHERE TRXA_VIEW_STAT = 'Y'
           AND (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE=TRXA_INVE_CODE) LIKE '$kata%'

          ORDER BY TRXA_UPDT_DATE DESC, TRXA_UPDT_TIME DESC"; 

}

$q = $db->query($xquery) or die("Gagal Tampilkan Data Rekanan!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$listcode = $k['TRXA_LIST_CODE'];

echo '<td style="width: 100px">'.$listcode.'</td>';

$status_payment = $k['TRXA_CUST_TYPE'];

if ($status_payment == 'B') 
{
  echo '<td style="width: 200px;">BPJS</td>';
}
else if ($status_payment == 'A')
{
  echo '<td style="width: 200px;">Asuransi</td>';
}
else if ($status_payment == 'P')
{
  echo '<td style="width: 200px;">Perusahaan</td>';
}

else 
{
  echo '<td style="width: 200px;">No Status</td>'; 
} 

echo '<td style="width: 200px">'.$k['CUST_NAME'].'</td>';
echo '<td style="width: 200px">'.$k['INVE_NAME'].' '.$k['SPEC_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['UNIT_NAME'].'</td>';


echo '<td style="width: 200px">';

echo '<a class="button-view pure-button" onclick="viewcode(\''.$listcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$listcode.'\');}
              else
              { document.getElementById(\'txtinvecode\').focus();}
              ">Delete</a>';

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


