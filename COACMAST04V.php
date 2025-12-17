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
  <th style="width: 150px">ACCOUNT CODE</th>
  <th style="width: 300px">ACCOUNT NAME</th>
  <th style="width: 150px">ACCOUNT GROUP</th>
  <th style="width: 100px">STATUS</th>
  <th style="width: 100px">BALANCE</th>
  <th style="width: 350px">NOTE</th>


  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kode = 'ACC';
$panjangkata = strlen($kata);
if ($panjangkata == 1 )
{ 
$xquery = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE,
            COAC_MAST_CODE, COAC_MAST_PRNT,
           (SELECT TBLA_COAC_NAME FROM tblacoac WHERE TBLA_COAC_CODE = COAC_MAST_PRNT) AS PARENT_NAME, 
            COAC_MAST_NAME, 
           CASE COAC_MAST_STAT
           WHEN 'P' THEN 'Parent'
           WHEN 'C' THEN 'Child'
           ELSE 'NO STATUS' END
           AS STATUS,
           CASE COAC_NORM_BLNC 
           WHEN 'DB' THEN 'Debit'
           WHEN 'CR' THEN 'Credit'
           ELSE 'NO BALANCE' END
           AS BALANCE, 
           COAC_MAST_NOTE 
           FROM coacmast 
           WHERE COAC_VIEW_STAT = 'Y'
           ORDER by COAC_MAST_PRNT, COAC_MAST_CODE LIMIT 10"; 
}
else
{ 
$xquery = "SELECT CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) AS MAST_CODE,
            COAC_MAST_CODE, COAC_MAST_PRNT,
          (SELECT TBLA_COAC_NAME FROM tblacoac WHERE TBLA_COAC_CODE = COAC_MAST_PRNT) AS PARENT_NAME, 
            COAC_MAST_NAME, 
           CASE COAC_MAST_STAT
           WHEN 'P' THEN 'Parent'
           WHEN 'C' THEN 'Child'
           ELSE 'NO STATUS' END
           AS STATUS,
           CASE COAC_NORM_BLNC 
           WHEN 'DB' THEN 'Debit'
           WHEN 'CR' THEN 'Credit'
           ELSE 'NO BALANCE' END
           AS BALANCE, 
           COAC_MAST_NOTE 
           FROM coacmast 
           WHERE CONCAT(COAC_MAST_PRNT,'.', COAC_MAST_CODE) LIKE '$kata%' AND COAC_VIEW_STAT = 'Y' 
           OR COAC_MAST_NAME LIKE '$kata%' AND COAC_VIEW_STAT = 'Y'
           ORDER by COAC_MAST_PRNT, COAC_MAST_CODE";
               
            }
$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
echo '<tr>';
echo '<td style="width: 150px"><b>'.$k['MAST_CODE'].'</b></td>';
echo '<td style="width: 300px; text-align: left;">'.$k['COAC_MAST_NAME'].'</td>';
echo '<td style="width: 150px">'.$k['PARENT_NAME'].'</td>';
echo '<td style="width: 100px">'.$k['STATUS'].'</td>';
echo '<td style="width: 100px">'.$k['BALANCE'].'</td>';
echo '<td style="width: 350px; text-align: left;">'.$k['COAC_MAST_NOTE'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


