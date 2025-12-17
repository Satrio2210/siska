<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
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
  <th style="width: 150px">No.Reg</th>
  <th style="width: 200px">Pasien</th>
  <th style="width: 150px">Obat</th>
  <th style="width: 100px">Jumlah</th>
  <th style="width: 100px">Batch</th>
  <th style="width: 150px">Jenis</th>
  <th style="width: 200px">Farmasi</th>
  <th style="width: 100px">Status</th>
  <th style="width: 200px">Action</th>

  </tr>
  </thead>
  <tbody>
<?php
$kata = $_POST['q'];
//$kata = '';
$panjangkata = strlen($kata);
if ($panjangkata == 0 )
{ 

$xquery = "SELECT TRXA_PRSC_CODE, 
          (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_PRSC_CODE) AS PATI_CODE,
          (SELECT CASE WHEN PATI_MAIN_TITL = 'Tn.' THEN 'Tn.'
                       WHEN PATI_MAIN_TITL = 'Ny.' THEN 'Ny.'
                       WHEN PATI_MAIN_TITL = 'Nn.' THEN 'Nn.'
                       WHEN PATI_MAIN_TITL = 'An.' THEN 'An.'
            END AS MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS TITLE,
          (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,  
          TRXA_PRSC_DOCT,
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_PRSC_DOCT) AS DOCT_NAME,           
          TRXA_STOCK_CODE,
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,
          TRXA_STOCK_QUTY, 
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS CODE_UNIT,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT,
          IF(TRXA_STOCK_BTCH IS NULL, 'Belum diisi', TRXA_STOCK_BTCH) AS BTCH_CODE,
          CASE WHEN TRXA_PRSC_CONC = 'Y' THEN 'Racikan'
               WHEN TRXA_PRSC_CONC = 'N' THEN 'Bukan Racikan'
          END AS PRSC_CONC, TRXA_STOCK_QUTY, TRXA_PRSC_STAT
          FROM trxaprsc WHERE TRXA_PRSC_STAT IN ('A','I') 
          AND TRXA_VIEW_STAT='Y'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 4 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 

}
else
{
$xquery = "SELECT TRXA_PRSC_CODE, 
          (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_PRSC_CODE) AS PATI_CODE,
          (SELECT CASE WHEN PATI_MAIN_TITL = 'Tn.' THEN 'Tn.'
                       WHEN PATI_MAIN_TITL = 'Ny.' THEN 'Ny.'
                       WHEN PATI_MAIN_TITL = 'Nn.' THEN 'Nn.'
                       WHEN PATI_MAIN_TITL = 'An.' THEN 'An'
          END AS MAIN_TITL FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS TITLE,
          (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME,  
          TRXA_PRSC_DOCT,
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_PRSC_DOCT) AS DOCT_NAME,           
          TRXA_STOCK_CODE,
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS SPEC_CODE,
          (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,

          TRXA_STOCK_QUTY, 
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS CODE_UNIT,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = CODE_UNIT) AS NAME_UNIT,
          IF(TRXA_STOCK_BTCH IS NULL, 'Belum diisi', TRXA_STOCK_BTCH) AS BTCH_CODE,
          CASE WHEN TRXA_PRSC_CONC = 'Y' THEN 'Racikan'
               WHEN TRXA_PRSC_CONC = 'N' THEN 'Bukan Racikan'
          END AS PRSC_CONC, TRXA_STOCK_QUTY, TRXA_PRSC_STAT
          FROM trxaprsc WHERE (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_PRSC_CODE)) LIKE '$kata%'
          AND TRXA_PRSC_STAT IN ('A','I') AND TRXA_VIEW_STAT='Y'
          OR (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_PRSC_CODE)) 
          LIKE '$kata%'
          AND TRXA_PRSC_STAT IN ('A','I') 
          AND TRXA_VIEW_STAT='Y'
          AND TRXA_ENTR_DATE > DATE_SUB(CURDATE(), INTERVAL 4 DAY)
          ORDER BY TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC"; 
}


$q = $db->query($xquery) or die("Gagal Maning!!");
while ($k = $q->fetch(PDO::FETCH_ASSOC))
{ 
//|No.Reg||Pasien|Obat|Jumlah|Batch|Jenis|Dokter|Status
echo '<tr>';
$prsccode = $k['TRXA_PRSC_CODE'];
$stockcode = $k['TRXA_STOCK_CODE'];
$prscstat = $k['TRXA_PRSC_STAT'];
echo '<td style="width: 150px">'.$prsccode.'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['TITLE'].' '.$k['PATI_NAME'].'</td>';
echo '<td style="width: 150px; text-align: left;">'.$k['STOCK_NAME'].' '.$k['SPEC_NAME'].'</td>';
echo '<td style="width: 100px; text-align: left;">'.$k['TRXA_STOCK_QUTY'].' '.$k['NAME_UNIT'].'</td>';
echo '<td style="width: 100px; text-align: left;">'.$k['BTCH_CODE'].'</td>';
echo '<td style="width: 150px; text-align: left;">'.$k['PRSC_CONC'].'</td>';
echo '<td style="width: 200px; text-align: left;">'.$k['DOCT_NAME'].'</td>';

if ( $prscstat == 'A')
  {
	 echo '<td style="width: 100px; background-color: #FDC098;">Belum Siap</td>';
  }
else if ($prscstat == 'I')
 {
  echo '<td style="width: 100px; background-color: #98F7FD;">Sudah Siap</td>';
 }
else
{
  echo '<td style="width: 100px;"> </td>';
}


echo '<td style="width: 200px">';


echo '<a class="button-view pure-button" onclick="viewcode(\''.$prsccode.'\',\''.$stockcode.'\');">Periksa</a>';

echo '<a class="button-delete pure-button" 
              onclick="if (confirm (\'Are You Sure To Cancel ?\'))
              { hapuscode(\''.$prsccode.'\',\''.$stockcode.'\');}
              else
              { document.getElementById(\'txtprsccode\').focus();}
              ">Batalkan</a>';


echo '</td>';
echo '</tr>';
}
?>
  </tbody>
  </table>


