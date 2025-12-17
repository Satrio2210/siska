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
  height: 100px;
}
</style>
  <table id="screen">
  <thead>
  <tr>
  <th style="width: 200px;">BATCH CODE</th>
  </tr>
  </thead>
  <tbody>
<?php
  $rawdata = $_POST['q'];
  list($kata,$stockcode) = explode("|", $rawdata);

  if (strlen($kata) == 1)
  {
  $xquery = "SELECT DISTINCT(INVE_STOCK_BTCH) AS STOCK_BTCH 
              FROM investock 
              WHERE INVE_STOCK_CODE = '$stockcode'";    
  }
  else
  {
  $xquery = "SELECT DISTINCT(INVE_STOCK_BTCH) AS STOCK_BTCH 
              FROM investock 
              WHERE INVE_STOCK_BTCH LIKE '$kata%'  
              AND INVE_STOCK_CODE = '$stockcode'";        
  }

$q = $db->query($xquery) or die("Gagal ambil batch code !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outbatch = $k['STOCK_BTCH'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isibatch(\''.$outbatch.'\');" 
      style="cursor:pointer">'.$k['STOCK_BTCH'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


