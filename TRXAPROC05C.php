<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
#screen {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#screen td, #screen th {
    border: 1px solid #ddd;
    padding: 4px;
}


#screen tr:nth-child(even){background-color: #f3f2f2;}

#screen tr:hover {background-color: #ddd;}

#screen th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}
#screen tbody, #screen thead
{
    display:block;
}
#screen tbody 
{
  overflow: auto;
  height: 200px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 100px;">Tgl</th>
  <th style="width: 100px;">PO</th>
  <th style="width: 200px;">Suplier</th>
  <th style="width: 220px;">Tujuan</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = xss_clean($_POST['q']);
  $xquery = "SELECT TRXA_PROC_CODE, DATE_FORMAT(TRXA_PROC_DATE,'%d/%m/%Y') AS PROC_DATE, 
            TRXA_PROC_DUED,
            TRXA_PROC_DIVI, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = TRXA_PROC_DIVI) AS DIVI_NAME, 
            TRXA_SUPL_CODE, (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE=TRXA_SUPL_CODE) AS SUPL_NAME
             FROM trxaproc 

            WHERE TRXA_PROC_CODE LIKE '$kata%' 
            AND TRXA_PROC_STAT = 'CL' AND TRXA_PROC_CODE NOT IN (SELECT TRXA_PROC_CODE FROM trxainvc WHERE TRXA_INVC_STAT IN ('U','O') AND TRXA_VIEW_STAT='Y')

            OR (SELECT SUPL_MAIN_NAME FROM suplmast WHERE SUPL_MAST_CODE=TRXA_SUPL_CODE) LIKE '$kata%'
            AND TRXA_PROC_STAT = 'CL' AND TRXA_PROC_CODE NOT IN (SELECT TRXA_PROC_CODE FROM trxainvc WHERE TRXA_INVC_STAT IN ('U','O') AND TRXA_VIEW_STAT='Y') 

            ORDER BY TRXA_PROC_DATE DESC";

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $procdate = $k['PROC_DATE'];
  $diviname = $k['DIVI_NAME'];
  $proccode = $k['TRXA_PROC_CODE'];
  $procdued = $k['TRXA_PROC_DUED'];
  $suplname = $k['SUPL_NAME'];
  $suplcode = $k['TRXA_SUPL_CODE'];
  
echo '<tr>';

echo '<td style="width: 100px; text-align: center;" onClick="isipocode(\''.$proccode.'\',\''.$procdued.'\',\''.$suplname.'\',\''.$suplcode.'\');" 
      style="cursor:pointer">'.$procdate.'</td>';

echo '<td style="width: 100px; text-align: center;" onClick="isipocode(\''.$proccode.'\',\''.$procdued.'\',\''.$suplname.'\',\''.$suplcode.'\');" 
      style="cursor:pointer">'.$proccode.'</td>';

echo '<td style="width: 200px; text-align: center;" onClick="isipocode(\''.$proccode.'\',\''.$procdued.'\',\''.$suplname.'\',\''.$suplcode.'\');" 
      style="cursor:pointer">'.$suplname.'</td>';

echo '<td style="width: 200px; text-align: center;" onClick="isipocode(\''.$proccode.'\',\''.$procdued.'\',\''.$suplname.'\',\''.$suplcode.'\');" 
      style="cursor:pointer">'.$diviname.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


