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
    padding-top: 10px;
    padding-bottom: 10px;
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
  <th style="width: 650px;">PASIEN</th>
  </tr>
    <thead>
  <tr>
  <th style="width: 100px">Antri</th>
  <th style="width: 140px">Nama</th>
  <th style="width: 160px">Poli</th>
  <th style="width: 100px">Payment</th>
  <th style="width: 113px">R.M</th>
  </tr>
    </thead>
  </thead>
  
  <tbody>
<?php
  $kata = $_POST['q'];
  //$kata = 'X';
  //list($kata, $dokter) = explode("|",$rawdata);

  if (strlen($kata) == 1)
  {
  $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, 
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_POLI,
                (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_PRSC
                FROM trxaregi
                WHERE TRXA_REGI_POLI <> '$code_lab_room' 
                AND TRXA_REGI_STAT IN ('C','W')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";    
  }
  else
  {
  $xquery = "SELECT TRXA_REGI_CODE, TRXA_PATI_CODE, 
                (SELECT CONCAT(PATI_MAIN_TITL,' ',PATI_MAIN_NAME) FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_NAME,
                (SELECT PATI_MAIN_BIRT FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_AGE,
                (SELECT PATI_MAIN_GEND FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) AS MAIN_GEND,
                TRXA_REGI_LIST, TRXA_REGI_PAYM, TRXA_REGI_POLI,
                (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE=TRXA_REGI_CODE) AS EXAM_PRSC
                FROM trxaregi
                WHERE (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE=TRXA_PATI_CODE) LIKE '$kata%' 
                AND TRXA_REGI_POLI <> '$code_lab_room' 
                AND TRXA_REGI_STAT IN ('C','W')
                AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 2 DAY)
                ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC";        
  }

$q = $db->query($xquery) or die("Gagal ambil regis !!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{
  $outprsccode = $k['TRXA_REGI_CODE'];
  $outpaticode = $k['TRXA_PATI_CODE'];
  $outmainname = $k['MAIN_NAME'];
  $mainage = $k['MAIN_AGE'];
  // tanggal lahir
  $tanggal = new DateTime($mainage);

  // tanggal hari ini
  $today = new DateTime('today');

  $y = $today->diff($tanggal)->y;
  $m = $today->diff($tanggal)->m;
  $d = $today->diff($tanggal)->d;
  $outmainage = '' . $y . ' tahun ' . $m . ' bulan ' . $d . ' hari';

  $gender = $k['MAIN_GEND'];
  
  if ($gender == 'M') { $outmaingend = 'Laki Laki';}
  else if ($gender = 'F') { $outmaingend = 'Perempuan';}
  else { $outmaingend = 'No Gender'; }

  $outpaymcode = $k['TRXA_REGI_PAYM'];

  if ($outpaymcode == 'U') { $outregipaym = 'Umum'; }
  else if ($outpaymcode == 'B') { $outregipaym = 'BPJS'; }
  else if ($outpaymcode == 'A') { $outregipaym = 'Asuransi'; }
  else if ($outpaymcode == 'P') { $outregipaym = 'Perusahaan'; }
  else { $outregipaym = 'Kosong';}

  $outregipoli = $k['TRXA_REGI_POLI'];
  $inexamprsc = $k['EXAM_PRSC'];
  $outexamprsc = preg_replace("/[\r\n]*/","",$inexamprsc);
  
  $regipoli = $k['TRXA_REGI_POLI'];
  if ($regipoli == 'PU') { $regipoli = 'Poli Umum'; }
  else if ($regipoli == 'KB') { $regipoli = 'Poli KIA'; }
  else if ($regipoli == 'PG') { $regipoli = 'Poli Gigi'; }
  else if ($regipoli == 'LB') { $regipoli = 'Laboratorium'; }
  else { $regipoli = 'Kosong';}
  
  
  $regipaym = $k['TRXA_REGI_PAYM'];
  if ($regipaym == 'U') { $regipaym = 'Umum'; }
  else if ($regipaym == 'B') { $regipaym = 'BPJS'; }
  else if ($regipaym == 'A') { $regipaym = 'Asuransi'; }
  else if ($regipaym == 'P') { $regipaym = 'Perusahaan'; }
  else { $regipaym = 'Kosong';}
                                                    //isiregi(outcsblcode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode)
echo '<tr>';

echo '<td style="width: 100px;" onClick="isiregi(\''.$outprsccode.'\',\''.$outpaticode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainage.'\',\''.$outregipaym.'\',\''.$outpaymcode.'\',\''.$outregipoli.'\',\''.$outexamprsc.'\');" 
      style="cursor:pointer">'.$k['TRXA_REGI_LIST'].'</td>';
      
echo '<td style="width: 145px;" onClick="isiregi(\''.$outprsccode.'\',\''.$outpaticode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainage.'\',\''.$outregipaym.'\',\''.$outpaymcode.'\',\''.$outregipoli.'\',\''.$outexamprsc.'\');" 
      style="cursor:pointer">'.$k['MAIN_NAME'].'</td>';
      
echo '<td style="width: 160px;">'.$regipoli.'</td>';

echo '<td style="width: 100px;" onClick="isiregi(\''.$outprsccode.'\',\''.$outpaticode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainage.'\',\''.$outregipaym.'\',\''.$outpaymcode.'\',\''.$outregipoli.'\',\''.$outexamprsc.'\');" 
      style="cursor:pointer">'.$regipaym.'</td>';

echo '<td style="width: 100px;" onClick="isiregi(\''.$outprsccode.'\',\''.$outpaticode.'\',\''.$outmainname.'\',\''.$outmaingend.'\',\''.$outmainage.'\',\''.$outregipaym.'\',\''.$outpaymcode.'\',\''.$outregipoli.'\',\''.$outexamprsc.'\');" 
      style="cursor:pointer">'.$k['TRXA_PATI_CODE'].'</td>';

echo '</tr>';
}
?>
  </tbody>
  </table>


