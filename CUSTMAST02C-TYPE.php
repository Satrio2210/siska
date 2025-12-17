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
  <th style="width: 400px;">NAMA REKANAN</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];

  if (strlen($kata) == 1)
  {

  $xquery = "SELECT CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE
            FROM custmast WHERE CUST_VIEW_STAT='Y'
            ORDER BY CUST_MAST_CODE LIMIT 10";            
  }
  else
  {
  $xquery = "SELECT CUST_MAST_CODE, CUST_MAIN_NAME, CUST_MAIN_TYPE
            FROM custmast WHERE CUST_VIEW_STAT='Y'
            AND CUST_MAIN_NAME LIKE '$kata%'
            OR CUST_VIEW_STAT='Y'
            AND CUST_MAIN_NAME LIKE '%$kata%'
            ORDER BY CUST_MAST_CODE";            
  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  //$coaccode = $k['COAC_MAST_CODE'];
  $custcode = $k['CUST_MAST_CODE'];
  $custname = $k['CUST_MAIN_NAME'];
  $custtype = $k['CUST_MAIN_TYPE'];

echo '<tr>';
echo '<td style="width: 400px;" onClick="isicustcode(\''.$custcode.'\',\''.$custname.'\',\''.$custtype.'\');" 
      style="cursor:pointer">'.$custname.'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


