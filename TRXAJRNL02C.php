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
  <th style="width: 200px;">KODE TRANSAKSI</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  $xquery = "SELECT DISTINCT(TRXA_JRNL_CODE)
              FROM trxajrnl 
              WHERE TRXA_JRNL_CODE LIKE '$kata%'   
              AND TRXA_JRNL_STAT = 'Y'
              OR TRXA_JRNL_DATE LIKE '$kata%'
              AND TRXA_JRNL_STAT = 'Y'";

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $tbljrnlcode = $k['TRXA_JRNL_CODE'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isijrnlcode(\''.$tbljrnlcode.'\');" 
      style="cursor:pointer">'.$k['TRXA_JRNL_CODE'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


