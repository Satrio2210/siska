<?php
include "conf/config.php";
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
  <th style="width: 100px;">KODE BANK</th>
  <th style="width: 200px;">NAMA BANK</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TBLE_BANK_CODE, TBLE_BANK_NAME 
              FROM tblebank 
              WHERE TBLE_BANK_STAT = 'Y'
              ORDER by TBLE_BANK_CODE";
  }
  else
  {
  $xquery = "SELECT TBLE_BANK_CODE, TBLE_BANK_NAME 
              FROM tblebank 
              WHERE TBLE_BANK_CODE LIKE '$kata%'  
              AND TBLE_BANK_STAT = 'Y'
              OR TBLE_BANK_NAME LIKE '$kata%'
              AND TBLE_BANK_STAT = 'Y'
              ORDER by TBLE_BANK_CODE";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outbankcode = $k['TBLE_BANK_CODE'];
  $outbankname = $k['TBLE_BANK_NAME'];

echo '<tr>';
echo '<td style="width: 100px;" onClick="isibankcode(\''.$outbankcode.'\',\''.$outbankname.'\');" 
      style="cursor:pointer">'.$k['TBLE_BANK_CODE'].'</td>';
echo '<td style="width: 200px;" onClick="isibankcode(\''.$outbankcode.'\',\''.$outbankname.'\');" 
      style="cursor:pointer">'.$k['TBLE_BANK_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


