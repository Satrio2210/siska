<?php
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
  <th style="width: 200px">GROUP CODE</th>
  <th style="width: 350px">GROUP NAME</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ $xquery = "SELECT * FROM tblacoac WHERE TBLA_COAC_STAT = 'Y' ORDER by TBLA_COAC_CODE"; }
else
{ $xquery = "SELECT * FROM tblacoac 
              WHERE TBLA_COAC_CODE LIKE '$kata%'
              AND TBLA_COAC_STAT = 'Y' 
              OR TBLA_COAC_NAME LIKE '$kata%'
              AND TBLA_COAC_STAT = 'Y'"; }
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 200px">'.$k['TBLA_COAC_CODE'].'</td>';
echo '<td style="width: 350px">'.$k['TBLA_COAC_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


