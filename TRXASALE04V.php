<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);

if ($startdate == $enddate)
{

$query1 = "SELECT DISTINCT(TRXA_REGI_DOCT) AS REGI_DOCT, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME 
          FROM trxaregi 
          WHERE TRXA_REGI_STAT = 'X'
          AND TRXA_REGI_POLI = '$code_lab_room'
          AND TRXA_REGI_DATE = '$startdate'";  

}
else
{
$query1 = "SELECT DISTINCT(TRXA_REGI_DOCT) AS REGI_DOCT, 
          (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN=TRXA_REGI_DOCT) AS DOCT_NAME, 
          TRXA_REGI_POLI, 
          (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS POLI_NAME 
          FROM trxaregi 
          WHERE TRXA_REGI_STAT = 'X'
          AND TRXA_REGI_POLI = '$code_lab_room' 
          AND TRXA_REGI_DATE 
          BETWEEN '$startdate' AND '$enddate'";  

}

$q1 = $db->query($query1) or die("Gagal Ambil Nama Dokter!!");
while ($k1 = $q1->fetch(PDO::FETCH_ASSOC))
{
    //$regicode = $k1['TRXA_REGI_CODE'];
    $doctcode = $k1['REGI_DOCT'];
    $doctname = $k1['DOCT_NAME'];
    $policode = $k1['TRXA_REGI_POLI'];
    $poliname = $k1['POLI_NAME'];

    echo '<h3>'.$doctname.'</h3>';

    echo '<table class="pure-table pure-table-horizontal">';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="width: 50px; text-align: center;">No.</th>';  
    echo '<th style="width: 300px; text-align: center;">Analis</th>';
    echo '<th style="width: 300px; text-align: center;">Tindakan</th>';
    echo '<th style="width: 100px; text-align: center;">Fee</th>'; 
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $no=0;
    $fee_total = 0;
    $fee_user = 0;
    $query2 = "SELECT TRXA_TRET_CODE, (SELECT TRXA_PATI_CODE FROM trxaregi WHERE TRXA_REGI_CODE=TRXA_TRET_CODE) AS PATI_CODE,
               (SELECT PATI_MAIN_NAME FROM patimast WHERE PATI_MAST_CODE = PATI_CODE) AS PATI_NAME, 
              TRXA_MEDI_CODE, 
              (SELECT TBLF_MEDI_NAME FROM tblfmedi WHERE TBLF_MEDI_CODE=TRXA_MEDI_CODE) AS MEDI_NAME,
              TRXA_MEDI_RATE, 
              TRXA_TRET_QUTY,

              IF ((SELECT FEE_MAST_RATE FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE) IS NULL 
              OR (SELECT FEE_MAST_RATE FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE) = '','0',
              (SELECT FEE_MAST_RATE FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE)) 
              AS FEE_RATE,

              IF ((SELECT FEE_PART_USER FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE) IS NULL 
              OR (SELECT FEE_PART_USER FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE) = '','0',
              (SELECT FEE_PART_USER FROM feemast WHERE FEE_MAST_USER = '$doctcode' AND FEE_MEDI_CODE = TRXA_MEDI_CODE))
              AS FEE_USER

              FROM trxatret WHERE TRXA_TRET_DOCT = '$doctcode' 
              AND (SELECT TRXA_REGI_DATE FROM trxaregi WHERE TRXA_REGI_CODE = TRXA_TRET_CODE) 
              BETWEEN '$startdate' AND '$enddate'";


    $q2 = $db->query($query2) or die("Gagal ambil data Fee");
    while ($k2 = $q2->fetch(PDO::FETCH_ASSOC))
    {
      $no++;
      $mediname  = $k2['MEDI_NAME'];
      $patiname = $k2['PATI_NAME'];
      $medirate = $k2['TRXA_MEDI_RATE'];
      $feerate = $k2['FEE_RATE'];
      $xfeeuser = $k2['FEE_USER'];
      $tretquty = $k2['TRXA_TRET_QUTY'];
      $feeuser = 0;

      echo '<tr>';
      echo '<td style="width: 50px">'.$no.'</td>';
      echo '<td style="width: 300px">Pasien '.$patiname.'</td>';
      echo '<td style="width: 300px">'.$mediname.'</td>';
      if ($feerate == 'F')
      {
        $feeuser = ($xfeeuser * $tretquty);         
      }
      else if ($feerate == 'P')
      {
        $feeuser = ($medirate * ($xfeeuser / 100));
      }

      $fee_total = ($fee_total + $feeuser);

      $view_fee = number_format($feeuser, 0, '', '.');
      echo '<td style="width: 100px; text-align: right;">Rp. '.$view_fee.'</td>';
      echo '</tr>';
    }

      echo '<tr class="pure-table-odd">';
      echo '<td style="width: 50px"> </td>';
      echo '<td style="width: 300px"></td>';
      echo '<td style="width: 300px">Total Fee</td>';
      $view_fee_total = number_format($fee_total, 0, '', '.');
      echo '<td style="width: 100px; text-align: right;">Rp. '.$view_fee_total.'</td>';
      echo '</tr>';

      $query3 = "SELECT ATT_NOMI_AMNT FROM attmast WHERE ATT_MAST_USER='$doctcode' 
      AND ATT_MAST_ROOM='$policode' AND ATT_VIEW_STAT='Y'";

      $q3 = $db->query($query3) or die("Gagal Ambil Uang Duduk");
      $k3 = $q3->fetch(PDO::FETCH_ASSOC);
      $fee_hadir = $k3['ATT_NOMI_AMNT'];
      $view_fee_hadir = number_format($fee_hadir, 0, '', '.');

      echo '<tr class="pure-table-odd">';
      echo '<td style="width: 50px"> </td>';
      echo '<td style="width: 300px"></td>';
      echo '<td style="width: 300px">Uang Kehadiran</td>';
      echo '<td style="width: 100px; text-align: right;">Rp. '.$view_fee_hadir.'</td>';
      echo '</tr>';

      echo '</tbody></table>';

}

//Total Fee per user

// Total Tunai

//$total = $fee_total + $fee_hadir;

//$view_total = number_format($total, 0, '', '.');
?>


<div style="padding: 30px 0 30px 0;">
  <center>
  &copy; 2021, SISKA Development Legal   
  </center>
</div>


