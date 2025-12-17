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
  <th style="width: 300px;">SIGNA</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  //list($kata, $regipoli) = explode("|",$rawdata);

  if (strlen($kata) == 1)
  {

  $xquery = "SELECT TBLP_SGNA_CODE, TBLP_SGNA_NAME 
              FROM tblpsgna 
              WHERE TBLP_SGNA_STAT ='Y'
              ORDER by TBLP_SGNA_CODE";    

  }
  else
  {
  $xquery = "SELECT TBLP_SGNA_CODE, TBLP_SGNA_NAME 
              FROM tblpsgna 
              WHERE TBLP_SGNA_NAME LIKE '$kata%'
              AND TBLP_SGNA_STAT ='Y'
              ORDER by TBLP_SGNA_CODE";        
  }

$q = $db->query($xquery) or die("Gagal ambil Signa!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outsgnacode = $k['TBLP_SGNA_CODE'];
  $outsgnaname = $k['TBLP_SGNA_NAME'];

echo '<tr>';
echo '<td style="width: 300px;" onClick="isisigna(\''.$outsgnacode.'\',\''.$outsgnaname.'\');" 
      style="cursor:pointer">'.$k['TBLP_SGNA_NAME'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


