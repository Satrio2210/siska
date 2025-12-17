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
  <th style="width: 100px;">SENDER</th>
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
  $xquery = "SELECT TRXA_EXEC_CODE, TRXA_EXEC_DATE, TRXA_REQU_CODE, TRXA_ESTM_DATE, 
                    TRXA_TRAN_DATE, TRXA_RCVE_DATE,  

                    TRXA_WARE_FROM,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS HOUS_NAME_FROM,
                    (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS LOCA_CODE_FROM,
                    (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_FROM) AS LOCA_NAME_FROM,

                    TRXA_WARE_DEST,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS HOUS_NAME_DEST,
                    (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS LOCA_CODE_DEST,
                    (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_DEST) AS LOCA_NAME_DEST,
                    TRXA_ENTR_USER,
                    (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REQU_NAME

                    FROM trxaexec
                    WHERE TRXA_EXEC_STAT = 'P'
                    AND TRXA_VIEW_STAT = 'Y'

                    ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";    
  }
  else
  {
  $xquery = "SELECT TRXA_EXEC_CODE, TRXA_EXEC_DATE, TRXA_REQU_CODE, TRXA_ESTM_DATE, 
                    TRXA_TRAN_DATE, TRXA_RCVE_DATE, 

                    TRXA_WARE_FROM,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS HOUS_NAME_FROM,
                    (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_FROM) AS LOCA_CODE_FROM,
                    (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_FROM) AS LOCA_NAME_FROM,

                    TRXA_WARE_DEST,(SELECT WARE_HOUS_NAME FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS HOUS_NAME_DEST,
                    (SELECT WARE_HOUS_LOCA FROM waremast WHERE WARE_HOUS_CODE = TRXA_WARE_DEST) AS LOCA_CODE_DEST,
                    (SELECT FIXE_LOCA_NAME FROM fixeloca WHERE FIXE_LOCA_CODE = LOCA_CODE_DEST) AS LOCA_NAME_DEST,
                     TRXA_ENTR_USER,
                    (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REQU_NAME
                    FROM trxaexec 
                    WHERE TRXA_EXEC_CODE LIKE  '$kata%'
                    AND TRXA_EXEC_STAT = 'P'
                    AND TRXA_VIEW_STAT = 'Y'
                    ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";    
  }


$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outexeccode = $k['TRXA_EXEC_CODE'];
  $outexecdate = $k['TRXA_EXEC_DATE'];
  $outrequcode = $k['TRXA_REQU_CODE'];
  $outestmdate = $k['TRXA_ESTM_DATE'];

  $outtrandate = $k['TRXA_TRAN_DATE'];
  $outrcvedate = $k['TRXA_RCVE_DATE'];

  $outwarefrom = $k['TRXA_WARE_FROM'];
  $outhousnamefrom = $k['HOUS_NAME_FROM'];
  $outlocanamefrom = $k['LOCA_NAME_FROM'];

  $outwaredest = $k['TRXA_WARE_DEST'];
  $outhousnamedest = $k['HOUS_NAME_DEST'];
  $outlocanamedest = $k['LOCA_NAME_DEST'];
  if ($k['REQU_NAME'] == '')
  {
    $outrequname = 'Administrator';
  }
  else
  {
    $outrequname = $k['REQU_NAME'];  
  }

echo '<tr>';
echo '<td style="width: 100px;" onClick="isiexeccode(\''.$outexeccode.'\',\''.$outexecdate.'\',\''.$outrequcode.'\',\''.$outestmdate.'\',
                                                      \''.$outtrandate.'\',\''.$outrcvedate.'\',
                                                      \''.$outwarefrom.'\',\''.$outhousnamefrom.'\',\''.$outlocanamefrom.'\',
                                                      \''.$outwaredest.'\',\''.$outhousnamedest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outrequname.'</td>';

echo '<td style="width: 100px;" onClick="isiexeccode(\''.$outexeccode.'\',\''.$outexecdate.'\',\''.$outrequcode.'\',\''.$outestmdate.'\',
                                                      \''.$outtrandate.'\',\''.$outrcvedate.'\',
                                                      \''.$outwarefrom.'\',\''.$outhousnamefrom.'\',\''.$outlocanamefrom.'\',
                                                      \''.$outwaredest.'\',\''.$outhousnamedest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outexecdate.'</td>';

echo '<td style="width: 200px;" onClick="isiexeccode(\''.$outexeccode.'\',\''.$outexecdate.'\',\''.$outrequcode.'\',\''.$outestmdate.'\',
                                                      \''.$outtrandate.'\',\''.$outrcvedate.'\',
                                                      \''.$outwarefrom.'\',\''.$outhousnamefrom.'\',\''.$outlocanamefrom.'\',
                                                      \''.$outwaredest.'\',\''.$outhousnamedest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outhousnamefrom.'</td>';

echo '<td style="width: 200px;" onClick="isiexeccode(\''.$outexeccode.'\',\''.$outexecdate.'\',\''.$outrequcode.'\',\''.$outestmdate.'\',
                                                      \''.$outtrandate.'\',\''.$outrcvedate.'\',
                                                      \''.$outwarefrom.'\',\''.$outhousnamefrom.'\',\''.$outlocanamefrom.'\',
                                                      \''.$outwaredest.'\',\''.$outhousnamedest.'\',\''.$outlocanamedest.'\');" 
      style="cursor:pointer">'.$outhousnamedest.'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


