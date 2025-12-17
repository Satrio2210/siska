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
  <th style="width: 100px">DATE</th>
  <th style="width: 200px">ACCOUNT</th>
  <th style="width: 100px">AMOUNT</th>
  <th style="width: 200px">DIVISI</th>
  <th style="width: 200px">NOTE</th>
  <th style="width: 100px">STATUS</th>
  <th style="width: 300px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_PAYM_CODE, DATE_FORMAT(TRXA_PAYM_DATE,'%d/%m/%Y') AS PAYM_DATE, TRXA_COAC_CODE,

           LEFT(TRXA_COAC_CODE,3) AS MAST_PRNT, RIGHT(TRXA_COAC_CODE,1) AS MAST_CODE, 
           (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = MAST_PRNT AND COAC_MAST_CODE = MAST_CODE) AS COAC_NAME,

           TRXA_CHEQ_CODE, TRXA_DIVI_CODE, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=TRXA_DIVI_CODE) AS DIVI_NAME,
           TRXA_PAYE_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_NOTE, TRXA_PAYM_STAT

           FROM trxapaym WHERE TRXA_VIEW_STAT = 'Y'
          ORDER BY TRXA_UPDT_DATE DESC, TRXA_UPDT_TIME DESC
          LIMIT 10"; 
}
else
{

$xquery = "SELECT TRXA_PAYM_CODE, DATE_FORMAT(TRXA_PAYM_DATE,'%d/%m/%Y') AS PAYM_DATE, TRXA_COAC_CODE,

           LEFT(TRXA_COAC_CODE,3) AS MAST_PRNT, RIGHT(TRXA_COAC_CODE,1) AS MAST_CODE, 
           (SELECT COAC_MAST_NAME FROM coacmast WHERE COAC_MAST_PRNT = MAST_PRNT AND COAC_MAST_CODE = MAST_CODE) AS COAC_NAME,

           TRXA_CHEQ_CODE, TRXA_DIVI_CODE, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE=TRXA_DIVI_CODE) AS DIVI_NAME,
           TRXA_PAYE_CODE, TRXA_PAYM_AMNT, TRXA_PAYM_NOTE, TRXA_PAYM_STAT

           FROM trxapaym WHERE TRXA_VIEW_STAT = 'Y'
           AND TRXA_PAYM_NOTE LIKE '$kata%'
           
           OR TRXA_VIEW_STAT = 'Y'
           AND TRXA_PAYM_NOTE LIKE '%$kata%'

           OR TRXA_VIEW_STAT = 'Y'
           AND TRXA_PAYM_CODE LIKE '$kata%'

           OR TRXA_VIEW_STAT = 'Y'
           AND DATE_FORMAT(TRXA_PAYM_DATE,'%d/%m/%Y') LIKE '$kata%'


          ORDER BY TRXA_UPDT_DATE DESC, TRXA_UPDT_TIME DESC"; 

}
$q = $db->query($xquery) or die("Gagal Tampilkan List Pengeluaran!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
$paymcode = $k['TRXA_PAYM_CODE'];
echo '<td style="width: 100px">'.$k['PAYM_DATE'].'</td>';

echo '<td style="width: 200px">'.$k['COAC_NAME'].'</td>';

$view_paym_amnt = number_format($k['TRXA_PAYM_AMNT'], 0, '', '.');
echo '<td style="width: 100px; text-align: right;">'.$view_paym_amnt.'</td>';

echo '<td style="width: 200px">'.$k['DIVI_NAME'].'</td>';

echo '<td style="width: 200px; text-align: left;">'.$k['TRXA_PAYM_NOTE'].'</td>';

$status_payment = $k['TRXA_PAYM_STAT'];

if ($status_payment == 'I') 
{
  echo '<td style="width: 100px;">Pencatatan</td>';
}
else if ($status_payment == 'P')
{
  echo '<td style="width: 100px;">Posting</td>';
}
else 
{
  echo '<td style="width: 100px;">No Status</td>'; 
} 

echo '<td style="width: 300px">';

if ($status_payment == 'I')
{
echo '<a class="button-view pure-button" onclick="viewcode(\''.$paymcode.'\');">Update</a>';
echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Delete ?\'))
              { hapuscode(\''.$paymcode.'\');}
              else
              { document.getElementById(\'txtcoaccode\').focus();}
              ">Delete</a>';

echo '<a class="button-posting pure-button" 
                onclick="if (confirm (\'Are You Sure To Posting ?\')) 
                { postcode(\''.$paymcode.'\'); }
                else 
                { document.getElementById(\'txtcoaccode\').focus();}
              ">Posting</a>';  
}
else
{
echo '<a class="button pure-button">Update</a>';
echo '<a class="button pure-button">Delete</a>'; 
echo '<a class="button pure-button">Posting</a>'; 

}

echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


