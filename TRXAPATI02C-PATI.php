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
  <th style="width: 100px;">R.M.</th>
  <th style="width: 150px;">NAMA</th>
  <th style="width: 100px;">LAHIR</th>
  <th style="width: 150px;">IBU KANDUNG</th>

  </tr>
  </thead>
  <tbody>
<?php
  $kata = $_POST['q'];
  if (strlen($kata) == 1)
  {
  $xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                    PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_PHNE, PATI_MAIN_PRNT 
            FROM patimast 
            WHERE PATI_VIEW_STAT = 'Y' ORDER BY PATI_MAST_CODE";    
  }
  else
  {
  $xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                    PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_PHNE, PATI_MAIN_PRNT 
            FROM patimast 
            WHERE PATI_MAIN_PIDN LIKE '%$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_NAME LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_BIRT LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_PRNT LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            ORDER BY PATI_MAST_CODE";        
  }

$q = $db->query($xquery) or die("Gagal ambil data !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outmastcode = $k['PATI_MAST_CODE'];
  $outmainname = $k['PATI_MAIN_NAME'];
  $outmaingend = $k['PATI_MAIN_GEND'];
  $outmainbirt = formatTanggal($k['PATI_MAIN_BIRT']);
  $outmainblod = $k['PATI_MAIN_BLOD'];
  $outmainaddr = $k['PATI_MAIN_ADDR'];
  $outmainphne = $k['PATI_MAIN_PHNE'];

echo '<tr>';

echo '<td style="width: 100px;" onClick="isipaticode(\''.$outmastcode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainbirt.'\',\''.$outmainblod.'\',\''.$outmainaddr.'\',\''.$outmainphne.'\');" 
      style="cursor:pointer">'.$k['PATI_MAST_CODE'].'</td>';
echo '<td style="width: 150px;" onClick="isipaticode(\''.$outmastcode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainbirt.'\',\''.$outmainblod.'\',\''.$outmainaddr.'\',\''.$outmainphne.'\');" 
      style="cursor:pointer">'.$k['PATI_MAIN_NAME'].'</td>';
echo '<td style="width: 100px;" onClick="isipaticode(\''.$outmastcode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainbirt.'\',\''.$outmainblod.'\',\''.$outmainaddr.'\',\''.$outmainphne.'\');" 
      style="cursor:pointer">'.$k['PATI_MAIN_BIRT'].'</td>';
echo '<td style="width: 150px;" onClick="isipaticode(\''.$outmastcode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainbirt.'\',\''.$outmainblod.'\',\''.$outmainaddr.'\',\''.$outmainphne.'\');" 
      style="cursor:pointer">'.$k['PATI_MAIN_PRNT'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>
