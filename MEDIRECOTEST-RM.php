<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";

$paticode = $_POST['q'];
//$kode = 'ACC';
//list($startdate, $enddate) = explode("|",$fulldate);

// Data Pasien
$query_regi = "SELECT TRXA_REGI_CODE AS REGI_CODE, (SELECT TRXA_PAYM_MODE FROM trxasale WHERE TRXA_REGI_CODE = REGI_CODE) AS PAYMENT_METHOD,
                      TRXA_REGI_DATE AS REGI_DATE, 
                      TRXA_REGI_POLI, (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_REGI_POLI) AS UNIT_CARE,
                      TRXA_REGI_DOCT, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_REGI_DOCT) AS DOCT_NAME,
                      TRXA_ENTR_USER, (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = TRXA_ENTR_USER) AS REGISTER_NAME,
                      TRXA_REGI_STAT,
                      (SELECT TRXA_ENTR_USER FROM trxaprsc WHERE TRXA_PRSC_CODE = REGI_CODE LIMIT 1) AS FARMASI_CODE,

                      IF((SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FARMASI_CODE) IS NULL 
                    OR (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FARMASI_CODE) = '', 'Tidak ada', 
                    (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = FARMASI_CODE)) AS FARMASI_NAME,

                      (SELECT TRXA_ENTR_USER FROM trxatret WHERE TRXA_TRET_CODE = REGI_CODE AND TRXA_MEDI_ROOM='$code_lab_room' LIMIT 1) AS ANALIS_CODE,

                      IF((SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ANALIS_CODE) IS NULL 
                      OR (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ANALIS_CODE) = '', 'Tidak ada', 
                      (SELECT PASS_USER_NAME FROM passiden WHERE PASS_USER_IDEN = ANALIS_CODE)) AS ANALIS_NAME,

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

                      (SELECT GROUP_CONCAT(CONCAT(TRXA_DIAG_CODE ,' - ', TRXA_DIAG_NAME) SEPARATOR ';\n') FROM trxadiag WHERE TRXA_EXAM_CODE = REGI_CODE) AS DIAGNOSA

                      
              FROM trxaregi WHERE TRXA_REGI_STAT IN ('C','P','X') 
              AND TRXA_VIEW_STAT='Y'
              ORDER BY TRXA_REGI_DATE DESC
";

$qregi = $db->query($query_regi) or die("Gagal Ambil data Rekam Medis Pasien!!");
while ($row_regi = $qregi->fetch(PDO::FETCH_ASSOC)) 
{ 
	
  $regicode = $row_regi['REGI_CODE'] = isset($row_regi['REGI_CODE']) ? $row_regi['REGI_CODE'] : ''; //Nomor Daftar

  $xpaymen_method = $row_regi['PAYMENT_METHOD'] = isset($row_regi['PAYMENT_METHOD']) ? $row_regi['PAYMENT_METHOD'] : '';  
  if ($xpaymen_method == 'TUN') { $paymen_method = 'Tunai';}
  else if ($xpaymen_method == 'BCA') { $paymen_method = 'Debit BCA';}
  else if ($xpaymen_method == 'MAN') { $paymen_method = 'Debit Mandiri';}
  else if ($xpaymen_method == 'BNI') { $paymen_method = 'Debit BNI';}
  else if ($xpaymen_method == 'BCM') { $paymen_method = 'Transfer BCA';}
  else if ($xpaymen_method == 'LIN') { $paymen_method = 'Transfer Link Aja';}
  else { $paymen_method = 'Non Cash';}
  
  $xregidate = $row_regi['REGI_DATE']  = isset($row_regi['REGI_DATE']) ? $row_regi['REGI_DATE'] : '';
  $regidate = formatTanggal($xregidate); // Tanggal Rekam Medis
  // Tempat Rujukan :
  $unitcare = $row_regi['UNIT_CARE'] = isset($row_regi['UNIT_CARE']) ? $row_regi['UNIT_CARE'] : '';  // Unit Perawatan
  
  $xregistat = $row_regi['TRXA_REGI_STAT'] = isset($row_regi['TRXA_REGI_STAT']) ? $row_regi['TRXA_REGI_STAT'] : ''; // STatus Pendaftaran
  $registat = ' ';
  if ($xregistat == 'X') { $registat = 'Selesai';}
  else {$xregistat == 'Menunggu';}


  $doctname  = $row_regi['DOCT_NAME'] = isset($row_regi['DOCT_NAME']) ? $row_regi['DOCT_NAME'] : ''; // Tenaga Medis
  // Kunjungan selanjutnya
  $register_name = $row_regi['REGISTER_NAME'] = isset($row_regi['REGISTER_NAME']) ? $row_regi['REGISTER_NAME'] : ''; // Pendaftaran
  // Status Pelayanan

  $farmasi_name = $row_regi['FARMASI_NAME'] = isset($row_regi['FARMASI_NAME']) ? $row_regi['FARMASI_NAME'] : ''; // Farmasi
  $analis_name = $row_regi['ANALIS_NAME'] = isset($row_regi['ANALIS_NAME']) ? $row_regi['ANALIS_NAME'] : ''; // Analis
  
  $height_patient = $row_regi['HEIGHT_PATIENT'] = isset($row_regi['HEIGHT_PATIENT']) ? $row_regi['HEIGHT_PATIENT'] : ''; // Tinggi (cm)
  $weight_patient = $row_regi['WEIGHT_PATIENT'] = isset($row_regi['WEIGHT_PATIENT']) ? $row_regi['WEIGHT_PATIENT'] : ''; // Berat (kg)
  $temperature = $row_regi['TEMPERATURE_PATIENT'] = isset($row_regi['TEMPERATURE_PATIENT']) ? $row_regi['TEMPERATURE_PATIENT'] : ''; // Suhu (celcius)
  $blood_patient = $row_regi['BLOOD_PATIENT'] = isset($row_regi['BLOOD_PATIENT']) ? $row_regi['BLOOD_PATIENT'] : ''; // Tekanan Darah (mm/Hg)

  $xdrug_alergy = $row_regi['DRUG_ALERGY'] = isset($row_regi['DRUG_ALERGY']) ? $row_regi['DRUG_ALERGY'] : '';  // Alergi Obat
  $drug_alergy = ' '; 
  if ($xdrug_alergy == 'N') { $drug_alergy = 'Tidak Ada';}
  else if ($xdrug_alergy == 'Y') { $drug_alergy = 'Ada';}
  else {$drug_alergy == 'Tidak di isi';}

  $xpaticare = $row_regi['PATI_CARE'] = isset($row_regi['PATI_CARE']) ? $row_regi['PATI_CARE'] : ''; // Rawat Inap
  $paticare = ' ';
  if ($xpaticare == 'N') { $paticare = 'Tidak Pernah';}
  else if ($xpaticare == 'Y') { $paticare = 'Pernah';}
  else {$paticare == 'Tidak di isi';}

  $xfood_alergy = $row_regi['FOOD_ALERGY'] = isset($row_regi['FOOD_ALERGY']) ? $row_regi['FOOD_ALERGY'] : ''; // Alergi Makanan
  $food_alergy = ' ';
  if ($xfood_alergy == 'N') { $food_alergy = 'Tidak Ada';}
  else if ($xfood_alergy == 'Y') { $paticare = 'Ada';}
  else {$food_alergy == 'Tidak di isi';}

  $xpatisurge = $row_regi['PATI_SURGE'] = isset($row_regi['PATI_SURGE']) ? $row_regi['PATI_SURGE'] : ''; //Operasi
  $patisurge = ' ';
  if ($xpatisurge == 'N') { $patisurge = 'Tidak Pernah';}
  else if ($xpatisurge == 'Y') { $patisurge = 'Pernah';}
  else {$patisurge == 'Tidak di isi';}

  $xchronis_dsse = $row_regi['CHRONIS_DSSE'] = isset($row_regi['CHRONIS_DSSE']) ? $row_regi['CHRONIS_DSSE'] : ''; // Penyakit Kronis
  $chronis_dsse = '';
  if ($xchronis_dsse == 'N') { $chronis_dsse = 'Tidak Ada';}
  else if ($xchronis_dsse == 'Y') { $chronis_dsse = 'Ada';}
  else {$chronis_dsse == 'Tidak di isi';}

  $xpatismoke = $row_regi['PATI_SMOKE'] = isset($row_regi['PATI_SMOKE']) ? $row_regi['PATI_SMOKE'] : ''; // Merokok
  $patismoke = '  ';
  if ($xpatismoke == 'N') { $patismoke = 'Tidak';}
  else if ($xpatismoke == 'Y') { $patismoke = 'Ya';}
  else {$patismoke == 'Tidak di isi';}

  $xother_dsse = $row_regi['OTHER_DSSE'] = isset($row_regi['OTHER_DSSE']) ? $row_regi['OTHER_DSSE'] : ''; // Penyakit lainnya
  $other_dsse = '  ';
  if ($xother_dsse == 'N') { $other_dsse = 'Tidak Ada';}
  else if ($xother_dsse == 'Y') { $other_dsse = 'Ada';}
  else {$other_dsse == 'Tidak di isi';}

  $anamnesa = $row_regi['ANAMNESA'] = isset($row_regi['ANAMNESA']) ? $row_regi['ANAMNESA'] : ''; 
  $check_body = $row_regi['CHECK_BODY'] = isset($row_regi['CHECK_BODY']) ? $row_regi['CHECK_BODY'] : ''; // Pemeriksaan Fisik
  $diagnosa = $row_regi['DIAGNOSA']; 
//   = isset($row_regi['DIAGNOSA']) ? $row_regi['DIAGNOSA'] : ''; // Diagnosa
//   $diagcode = $row_regi['DIAG_CODE'];
  $prescription = $row_regi['PRESCRIPTION'] = isset($row_regi['PRESCRIPTION']) ? $row_regi['PRESCRIPTION'] : ''; // Obat
  

?>
<fieldset>
	<legend>No Register :<?php echo $regicode; ?></legend>
    <form  class="pure-form pure-form-aligned" method="post" action="">

          <div class="pure-control-group">

            <label for="txtregicode">Nomor Daftar :</label>
              <input type="text"  name="txtregicode"  id="txtregicode" value="<?php echo $regicode;?>" 
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtpaymen_method">Metode Pembayaran :</label>
              <input type="text"  name="txtpaymen_method"  id="txtpaymen_method" value="<?php echo $paymen_method;?>" 
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtregidate">Tanggal Rekam Medis :</label>
              <input type="text"  name="txtregidate"  id="txtregidate"  value="<?php echo $regidate;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtunitcare">Unit Perawatan :</label>
              <input type="text"  name="txtunitcare"  id="txtunitcare" value="<?php echo $unitcare;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtregistat">Status Pendaftaran :</label>
              <input type="text"  name="txtregistat"  id="txtregistat" value="<?php echo $registat;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtdoctname">Tenaga Medis :</label>
              <input type="text"  name="txtdoctname"  id="txtdoctname" value="<?php echo $doctname;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtregister_name">Pendaftaran :</label>
              <input type="text"  name="txtregister_name"  id="txtregister_name" value="<?php echo $register_name;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtfarmasi_name">Farmasi :</label>
              <input type="text"  name="txtfarmasi_name"  id="txtfarmasi_name" value="<?php echo $farmasi_name;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtanalis_name">Analis :</label>
              <input type="text"  name="txtanalis_name"  id="txtanalis_name" value="<?php echo $analis_name;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtheight_patient">Tinggi (cm) :</label>
              <input type="text"  name="txtheight_patient"  id="txtheight_patient" value="<?php echo $height_patient;?>"
              maxlength ="10" style="width: 80px;"   readonly="true">

            <label for="txtweight_patient">Berat (kg) :</label>
              <input type="text"  name="txtweight_patient"  id="txtweight_patient" value="<?php echo $weight_patient;?>"
              maxlength ="10" style="width: 80px;"   readonly="true">

            <label for="txttemperature">Suhu (celcius) :</label>
              <input type="text"  name="txttemperature"  id="txttemperature" value="<?php echo $temperature;?>"
              maxlength ="10" style="width: 80px;"   readonly="true">

            <label for="txtblood_patient">Tekanan Darah (mm/Hg) :</label>
              <input type="text"  name="txtblood_patient"  id="txtblood_patient" value="<?php echo $blood_patient;?>"
              maxlength ="10" style="width: 100px;"   readonly="true">

          </div><!-- pure-control-group -->


          <div class="pure-control-group">



            <label for="txtpaticare">Rawat Inap :</label>
              <input type="text"  name="txtpaticare"  id="txtpaticare" value="<?php echo $paticare;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtpatisurge">Operasi :</label>
              <input type="text"  name="txtpatisurge"  id="txtpatisurge" value="<?php echo $patisurge;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->


          <div class="pure-control-group">

            <label for="txtdrug_alergy">Alergi Obat :</label>
              <input type="text"  name="txtdrug_alergy"  id="txtdrug_alergy" value="<?php echo $drug_alergy;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtfood_alergy">Alergi Makanan :</label>
              <input type="text"  name="txtfood_alergy"  id="txtfood_alergy" value="<?php echo $food_alergy;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtpatismoke">Merokok :</label>
              <input type="text"  name="txtpatismoke"  id="txtpatismoke" value="<?php echo $patismoke;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtchronis_dsse">Penyakit Kronis :</label>
              <input type="text"  name="txtchronis_dsse"  id="txtchronis_dsse" value="<?php echo $chronis_dsse;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

            <label for="txtother_dsse">Penyakit lainnya :</label>
              <input type="text"  name="txtother_dsse"  id="txtother_dsse" value="<?php echo $other_dsse;?>"
              maxlength ="10" style="width: 200px;"   readonly="true">

          </div><!-- pure-control-group -->
            
          <div class="pure-control-group">

            <label for="txtanamnesa">Anamnesa :</label>
            <textarea id="txtanamnesa" name="txtanamnesa" maxlength="10" style="width: 280px; height: 150px;" readonly="true"><?php echo $anamnesa;?></textarea>

            <label for="txtcheck_body">Pemeriksaan Fisik :</label>
            <textarea id="txtcheck_body" name="txtcheck_body" maxlength="10" style="width: 280px; height: 150px;" readonly="true"><?php echo $check_body;?></textarea>

          </div><!-- pure-control-group -->

          <div class="pure-control-group">

            <label for="txtdiagnosa">Diagnosa :</label>
            <textarea id="txtdiagnosa" name="txtdiagnosa" maxlength="10" style="width: 280px; height: 150px;" readonly="true"><?php echo $diagnosa;?>;</textarea>

            <label for="txtprescription">Resep :</label>
             <textarea id="txtprescription" name="txtprescription" maxlength="10" style="width: 280px; height: 150px;" readonly="true"><?php echo $prescription;?></textarea>

          </div><!-- pure-control-group -->


      </form>
        </fieldset>
<?php         
}
?>
        <fieldset>
              <a class="pure-button button-view" onclick="javascript: 
                  document.getElementById('tblviewrm').style.visibility = 'hidden';
                  document.getElementById('tblviewrm').innerHTML = '';

                  periksaakses('PASS_MEDI_REPO');

        ">Close</a>
        	
        </fieldset>
  </tbody>
  </table>


