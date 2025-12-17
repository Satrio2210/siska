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
  <th style="width: 200px;">KODE SUPPLIER</th>
  <th style="width: 500px;">NAMA SUPLIER</th>
  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];

if (strlen($kata) == 1)
{
  $xquery = "SELECT   SUPL_MAST_CODE, SUPL_MAIN_NAME, SUPL_MAIN_ADDR, 
      SUPL_MAIN_CITY, SUPL_MAIN_CTRY, SUPL_MAIN_PHNE,
      SUPL_MAIN_FAXI, SUPL_MAIN_MAIL, SUPL_MAIN_WEBS,
      SUPL_MAIN_PERS, SUPL_MAIN_TIDN, SUPL_MAIN_TERM,
      SUPL_ESTI_ARRV, SUPL_ESTI_DELI, SUPL_PAYA_LIMT,
      SUPL_BANK_CODE AS BANK_CODE, (SELECT TBLE_BANK_NAME FROM tblebank WHERE TBLE_BANK_CODE = BANK_CODE) AS BANK_NAME,
      SUPL_AVAI_FRWD
FROM suplmast
WHERE SUPL_VIEW_STAT = 'Y'";
}
else
{
  $xquery = "SELECT   SUPL_MAST_CODE, SUPL_MAIN_NAME, SUPL_MAIN_ADDR, 
      SUPL_MAIN_CITY, SUPL_MAIN_CTRY, SUPL_MAIN_PHNE,
      SUPL_MAIN_FAXI, SUPL_MAIN_MAIL, SUPL_MAIN_WEBS,
      SUPL_MAIN_PERS, SUPL_MAIN_TIDN, SUPL_MAIN_TERM,
      SUPL_ESTI_ARRV, SUPL_ESTI_DELI, SUPL_PAYA_LIMT,
      SUPL_BANK_CODE AS BANK_CODE, (SELECT TBLE_BANK_NAME FROM tblebank WHERE TBLE_BANK_CODE = BANK_CODE) AS BANK_NAME,
      SUPL_AVAI_FRWD
FROM suplmast
WHERE SUPL_VIEW_STAT = 'Y'
AND SUPL_MAIN_NAME LIKE '$kata%'";

}
$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $mastcode = $k['SUPL_MAST_CODE'];
  $mainname = $k['SUPL_MAIN_NAME'];
  $mainaddr = $k['SUPL_MAIN_ADDR'];
  $maincity = $k['SUPL_MAIN_CITY'];
  $mainctry = $k['SUPL_MAIN_CTRY'];
  $mainphne = $k['SUPL_MAIN_PHNE'];
  $mainfaxi = $k['SUPL_MAIN_FAXI'];
  $mainmail = $k['SUPL_MAIN_MAIL'];
  $mainwebs = $k['SUPL_MAIN_WEBS'];
  $mainpers = $k['SUPL_MAIN_PERS'];
  $maintidn = $k['SUPL_MAIN_TIDN'];
  $mainterm = $k['SUPL_MAIN_TERM'];
  $estiarrv = $k['SUPL_ESTI_ARRV'];
  $estideli = $k['SUPL_ESTI_DELI'];
  $payalimt = $k['SUPL_PAYA_LIMT'];
  $bankcode = $k['BANK_CODE'];
  $bankname = $k['BANK_NAME'];
  $avaifrwd = $k['SUPL_AVAI_FRWD'];

//(mastcode, mainname, mainaddr, maincity, mainctry, mainphne, mainfaxi, mainmail, mainwebs, mainpers, maintidn, mainterm, estiarrv, estideli, payalimt, bankname, bankcode, avaifrwd)

echo '<tr>';
echo '<td style="width: 200px;" onClick="isisuplmastcode(\''.$mastcode.'\',\''.$mainname.'\',\''.$mainaddr.'\',\''.$maincity.'\',\''.$mainctry.'\',\''.$mainphne.'\',\''.$mainfaxi.'\',\''.$mainmail.'\',\''.$mainwebs.'\',\''.$mainpers.'\',\''.$maintidn.'\',\''.$mainterm.'\',\''.$estiarrv.'\',\''.$estideli.'\',\''.$payalimt.'\',\''.$bankname.'\',\''.$bankcode.'\',\''.$avaifrwd.'\');" 
      style="cursor:pointer">'.$k['SUPL_MAST_CODE'].'</td>';
echo '<td style="width: 500px;" onClick="isisuplmastcode(\''.$mastcode.'\',\''.$mainname.'\',\''.$mainaddr.'\',\''.$maincity.'\',\''.$mainctry.'\',\''.$mainphne.'\',\''.$mainfaxi.'\',\''.$mainmail.'\',\''.$mainwebs.'\',\''.$mainpers.'\',\''.$maintidn.'\',\''.$mainterm.'\',\''.$estiarrv.'\',\''.$estideli.'\',\''.$payalimt.'\',\''.$bankname.'\',\''.$bankcode.'\',\''.$avaifrwd.'\');" 
      style="cursor:pointer">'.$k['SUPL_MAIN_NAME'].'</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


