<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
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
  <th style="width: 200px;">REQUEST</th>
  <th style="width: 100px;">DATE</th>
  <th style="width: 200px;">FROM</th>
  <th style="width: 200px;">TO</th>
  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TRXA_REQU_CODE, TRXA_REQU_DATE, TRXA_TRAN_DATE, TRXA_RCVE_DATE, 
             TRXA_WARE_FROM,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS HOUS_NAME_FROM,
             (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS LOCA_CODE_FROM,
             (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_FROM) AS LOCA_NAME_FROM,

             TRXA_WARE_DEST,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS HOUS_NAME_DEST,
             (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS LOCA_CODE_DEST,
             (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_DEST) AS LOCA_NAME_DEST,
             TRXA_ENTR_USER,
             (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REQU_NAME

            FROM trxarequ
            WHERE TRXA_REQU_STAT = 'A'
            AND TRXA_VIEW_STAT = 'Y'
            ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";    
  }
  else
  {
  $xquery = "SELECT TRXA_REQU_CODE, TRXA_REQU_DATE, TRXA_TRAN_DATE, TRXA_RCVE_DATE, 
             TRXA_WARE_FROM,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS HOUS_NAME_FROM,
             (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS LOCA_CODE_FROM,
             (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_FROM) AS LOCA_NAME_FROM,

             TRXA_WARE_DEST,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS HOUS_NAME_DEST,
             (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS LOCA_CODE_DEST,
             (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_DEST) AS LOCA_NAME_DEST,
              TRXA_ENTR_USER,
             (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REQU_NAME

            FROM trxarequ 
            WHERE TRXA_REQU_CODE LIKE  '$kata%'
            AND TRXA_REQU_STAT = 'A'
            AND TRXA_VIEW_STAT = 'Y'
            ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";    
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outrequcode = $k['TRXA_REQU_CODE'];
  $outrequdate = $k['TRXA_REQU_DATE'];
  $outtrandate = $k['TRXA_TRAN_DATE'];
  $outrcvedate = $k['TRXA_RCVE_DATE'];

  $outwarefrom = $k['TRXA_WARE_FROM'];
  $outhousnamefrom = $k['HOUS_NAME_FROM'];
  $outlocanamefrom = $k['LOCA_NAME_FROM'];

  $outwaredest = $k['TRXA_WARE_DEST'];
  $outhousnamedest = $k['HOUS_NAME_DEST'];
  $outlocanamedest = $k['LOCA_NAME_DEST'];
  $outrequname = $k['REQU_NAME'];

echo '<tr>';
echo '<td style="width: 200px;" onClick="isirequcode(\''.$outrequcode.'\',\''.$outtrandate.'\',\''.$outrcvedate.'\',\''.$outhousnamefrom.'\',\''.$outwarefrom.'\',\''.$outlocanamefrom.'\',\''.$outhousnamedest.'\',\''.$outwaredest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outrequcode.'|'.$outrequname.'</td>';
echo '<td style="width: 100px;" onClick="isirequcode(\''.$outrequcode.'\',\''.$outtrandate.'\',\''.$outrcvedate.'\',\''.$outhousnamefrom.'\',\''.$outwarefrom.'\',\''.$outlocanamefrom.'\',\''.$outhousnamedest.'\',\''.$outwaredest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outrequdate.'</td>';
echo '<td style="width: 200px;" onClick="isirequcode(\''.$outrequcode.'\',\''.$outtrandate.'\',\''.$outrcvedate.'\',\''.$outhousnamefrom.'\',\''.$outwarefrom.'\',\''.$outlocanamefrom.'\',\''.$outhousnamedest.'\',\''.$outwaredest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outhousnamefrom.'</td>';
echo '<td style="width: 200px;" onClick="isirequcode(\''.$outrequcode.'\',\''.$outtrandate.'\',\''.$outrcvedate.'\',\''.$outhousnamefrom.'\',\''.$outwarefrom.'\',\''.$outlocanamefrom.'\',\''.$outhousnamedest.'\',\''.$outwaredest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outhousnamedest.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


