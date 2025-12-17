<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$paticode = $_POST['q'];
//$kode = 'ACC';
//list($startdate, $enddate) = explode("|",$fulldate);

?>


  <table class="pure-table pure-table-horizontal">
  <thead>

  <tr>
    <td style="width: 100px; text-align: center;"><b>Head</b></td>
    <td style="width: 300px; text-align: center;"><b>Info</b></td>
    <td style="width: 100px; text-align: center;"><b>Head</b></td>
    <td style="width: 300px; text-align: center;"><b>Info</b></td>
  </tr>

  </thead>
  <tbody>

<?php
// Data Pasien
$query_regi = "SELECT TRXA_REGI_CODE AS REGI_CODE, (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = REGI_CODE) AS PAYMENT_METHOD,
                      DATE_FORMAT(TRXA_REGI_DATE,'%d/%m/%Y') AS REGI_DATE, 
                      TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS UNIT_CARE,
                      TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME,
                      TRXA_ENTR_USER, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS REGISTER_NAME,
                      TRXA_REGI_STAT,
                      (SELECT TRXA_ENTR_USER FROM trxaprsc WHERE TRXA_PRSC_CODE = REGI_CODE LIMIT 1) AS FARMASI_CODE,
                      (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FARMASI_CODE) AS FARMASI_NAME,
                      (SELECT TRXA_ENTR_USER FROM trxatret WHERE TRXA_TRET_CODE = REGI_CODE AND TRXA_MEDI_ROOM='LB' LIMIT 1) AS ANALIS_CODE,
                      (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ANALIS_CODE) AS ANALIS_NAME,

                      (SELECT TRXA_EXAM_HGHT FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS HEIGHT_PATIENT,
                      (SELECT TRXA_EXAM_WGHT FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS WEIGHT_PATIENT,

                      (SELECT TRXA_EXAM_TEMP FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS TEMPERATURE_PATIENT,
                      (SELECT TRXA_EXAM_BLOD FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS BLOOD_PATIENT,

                      (SELECT TRXA_MEDI_ALLE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS DRUG_ALERGY,
                      (SELECT TRXA_PATI_CARE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS PATI_CARE,
                      (SELECT TRXA_FOOD_ALLE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS FOOD_ALERGY,
                      (SELECT TRXA_PATI_SURGE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS PATI_SURGE,
                      (SELECT TRXA_CHRO_DSSE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS CHRONIS_DSSE,
                      (SELECT TRXA_PATI_SMOKE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS PATI_SMOKE,
                      (SELECT TRXA_OTHR_DSSE FROM trxaassm WHERE TRXA_ASSM_CODE = REGI_CODE) AS OTHER_DSSE,

                      (SELECT TRXA_EXAM_ANAM FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS ANAMNESA,
                      (SELECT TRXA_EXAM_BODY FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS CHECK_BODY,
                      (SELECT TRXA_EXAM_PRSC FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS PRESCRIPTION,
                      (SELECT TRXA_EXAM_DIAG FROM trxaexam WHERE TRXA_EXAM_CODE = REGI_CODE) AS DIAGNOSA

              FROM trxaregi WHERE TRXA_PATI_CODE = '$paticode' 
              AND TRXA_REGI_STAT = 'X' AND TRXA_VIEW_STAT='Y'
              ORDER BY TRXA_REGI_DATE DESC
";

//var_dump($query_regi);
//exit();

$qregi = $db->query($query_regi) or die("Gagal Ambil data Pasien!!");
while ($row_regi = $qregi->fetch(PDO::FETCH_ASSOC))
{
  $regicode = $row_regi['REGI_CODE'];
  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Nomor Daftar :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['REGI_CODE'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Metode Pembayaran :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['PAYMENT_METHOD'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Tanggal Rekam Medis :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['REGI_DATE'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Tempat Rujukan :</td>';
  echo '<td style="width: 300px; text-align: left;"> </td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Unit Perawatan :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['UNIT_CARE'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Status Pendaftaran :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['TRXA_REGI_STAT'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Tenaga Medis :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['DOCT_NAME'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Kunjungan Selanjutnya :</td>';
  echo '<td style="width: 300px; text-align: left;"> </td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Pendaftaran :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['REGISTER_NAME'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Status Pelayanan :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['TRXA_REGI_STAT'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Farmasi :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['FARMASI_NAME'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Analis :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['ANALIS_NAME'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Tinggi (cm) :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['HEIGHT_PATIENT'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Berat (kg) :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['WEIGHT_PATIENT'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Suhu (celcius) :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['TEMPERATURE_PATIENT'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Tekanan Darah (mm/Hg) :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['BLOOD_PATIENT'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Alergi Obat :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['DRUG_ALERGY'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Rawat Inap :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['PATI_CARE'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Alergi Makanan :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['FOOD_ALERGY'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Operasi :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['PATI_SURGE'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Penyakit Kronis :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['CHRONIS_DSSE'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Merokok :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['PATI_SMOKE'].'</td>';
  echo '</tr>';

    echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Penyakit Lainnya :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['OTHER_DSSE'].'</td>';

  echo '<td style="width: 100px; text-align: left;"></td>';
  echo '<td style="width: 300px; text-align: left;"></td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Anamnesa :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['ANAMNESA'].'</td>';

  echo '<td style="width: 100px; text-align: left;">Pemeriksaan Fisik :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['CHECK_BODY'].'</td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Diagnosa :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['DIAGNOSA'].'</td>';

  echo '<td style="width: 100px; text-align: left;"></td>';
  echo '<td style="width: 300px; text-align: left;"></td>';
  echo '</tr>';

  echo '<tr>';
  echo '<td style="width: 100px; text-align: left;">Obat :</td>';
  echo '<td style="width: 300px; text-align: left;">'.$row_regi['PRESCRIPTION'].'</td>';

  echo '<td style="width: 100px; text-align: left;"></td>';
  echo '<td style="width: 300px; text-align: left;"></td>';
  echo '</tr>';


}

  echo '<tr>';
  echo '<td style="width: 100px; text-align: right;">
  <a class="button-print pure-button" onclick="periksaakses(\'PASS_MEDI_REPO\');
            document.getElementById(\'tblviewrm\').innerHTML = \'\'; 
            document.getElementById(\'tblviewrm\').style.visibility = \'hidden\';">Close</a></td>';

  echo '<td style="width: 300px; text-align: center;"> </td>';
  echo '<td style="width: 100px; text-align: center;"> </td>';
  echo '<td style="width: 300px; text-align: center;"> </td>';
  echo '</tr>';

?>
  </tbody>
  </table>


