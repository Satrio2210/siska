<?php
include "conf/config.php";
?>

      <h3>Jumlah Pasien Klinik</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>Total Pasien</th>
                  <th>Pria</th>
                  <th>Wanita</th>
              </tr>
          </thead>

          <tbody>
              <tr>
                <?php

                $querytotal = "SELECT COUNT(*) AS TOTAL_PASIEN  FROM patimast WHERE PATI_VIEW_STAT = 'Y'";

                $qtotal = $db->query($querytotal) or die("Gagal Ambil Total!!");
                $rowtotal = $qtotal->fetch(PDO::FETCH_ASSOC);

                $total_pasien = number_format($rowtotal['TOTAL_PASIEN'], 0, '', '.');
                echo '<td>'.$total_pasien.' Pasien</td>';

                $querymale = "SELECT COUNT(*) AS MALE_PASIEN  FROM patimast WHERE PATI_MAIN_GEND = 'M' 
                              AND PATI_VIEW_STAT = 'Y'";

                $qmale = $db->query($querymale) or die("Gagal Ambil Male!!");
                $rowmale = $qmale->fetch(PDO::FETCH_ASSOC);

                $male_pasien = number_format($rowmale['MALE_PASIEN'], 0, '', '.');
                echo '<td>'.$male_pasien.' Pasien</td>';

                $queryfemale = "SELECT COUNT(*) AS FEMALE_PASIEN  FROM patimast WHERE PATI_MAIN_GEND = 'F' 
                              AND PATI_VIEW_STAT = 'Y'";

                $qfemale = $db->query($queryfemale) or die("Gagal Ambil Female!!");
                $rowfemale = $qfemale->fetch(PDO::FETCH_ASSOC);

                $female_pasien = number_format($rowfemale['FEMALE_PASIEN'], 0, '', '.');
                echo '<td>'.$female_pasien.' Pasien</td>';

                ?>

              </tr>
          </tbody>

      </table>

      <h3>Pendaftaran Pasien Klinik</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>Rata Waktu Tunggu</th>
                  <th>Pasien Daftar Hari Ini</th>
                  <th>Pasien Baru Bulan Ini</th>
              </tr>
          </thead>

          <tbody>
              <tr>
                <?php

                $queryrata = "SELECT MIN(TRXA_ENTR_TIME) AS JAM_MULAI, 
                                    MAX(TRXA_ENTR_TIME) AS JAM_SELESAI, 
                                    timediff(MAX(TRXA_ENTR_TIME), MIN(TRXA_ENTR_TIME)) AS SELISIH_WAKTU, 
                                    COUNT(*) AS JUMLAH_DAFTAR
                              FROM trxaregi WHERE TRXA_ENTR_DATE = '$datenow'";

                $qrata = $db->query($queryrata) or die("Gagal Ambil rata rata!!");
                $rowrata = $qrata->fetch(PDO::FETCH_ASSOC);

                $timestamp = strtotime($rowrata['SELISIH_WAKTU']);

                $jumlahjam = date('h',$timestamp);
                $jumlahmenit = date('m',$timestamp);
                $jumlahdetik = date('s',$timestamp);

                $jumlahdaftar = $rowrata['JUMLAH_DAFTAR'];

                $xrata_rata_tunggu = ($jumlahdaftar / $jumlahjam);


                $rata_rata_tunggu = round($xrata_rata_tunggu) . ':' . $jumlahmenit . ':' . $jumlahdetik;

                echo '<td>'.$rata_rata_tunggu.'</td>';

                $querydaftar = "SELECT COUNT(*) AS DAFTAR_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                              AND TRXA_VIEW_STAT = 'Y'";

                $qdaftar = $db->query($querydaftar) or die("Gagal Ambil Daftar!!");
                $rowdaftar = $qdaftar->fetch(PDO::FETCH_ASSOC);
                echo '<td>'.$rowdaftar['DAFTAR_SEKARANG'].' Pasien</td>';

                $querybaru = "SELECT COUNT(*) AS DAFTAR_BARU FROM (SELECT TRXA_PATI_CODE, COUNT(*) 
                                                                  FROM trxaregi WHERE TRXA_REGI_DATE LIKE '$yearnow-$monthnow%' AND TRXA_VIEW_STAT = 'Y' 
                                                                  GROUP BY TRXA_PATI_CODE 
                                                                  HAVING COUNT(*) = 1) 
                                                                  AS REGISTER_BARU ";


                $qbaru = $db->query($querybaru) or die("Gagal Ambil Daftar_baru!!");
                $rowbaru = $qbaru->fetch(PDO::FETCH_ASSOC);

                
                echo '<td>'.$rowbaru['DAFTAR_BARU'].' Pasien</td>';

                ?>

              </tr>
          </tbody>

      </table>
      
      //test
      </br>
          <table class="pure-table pure-table-bordered">
            <thead>
              <tr>
                  <th>Pasien P.Umum Hari ini</th>
                  <th>Pasien P.Gigi Hari Ini</th>
                  <th>Pasien LAB Hari Ini</th>
                  <th>Pasien P.KIA Hari Ini</th>
              </tr>
            </thead>
            
            <tbody>
                <tr>
                    <?php
                    //UMUM
                    $queryumum = "SELECT COUNT(*) AS UMUM_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'PU' 
                    AND TRXA_REGI_PAYM = 'U' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qumum = $db->query($queryumum) or die("Gagal Ambil umum!!");
                    $rowumum = $qumum->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowumum['UMUM_SEKARANG'].' Pasien</td>';
                    //UMUM
                    //GIGI
                    $querygigi = "SELECT COUNT(*) AS GIGI_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'PG' 
                    AND TRXA_REGI_PAYM = 'U' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qgigi = $db->query($querygigi) or die("Gagal Ambil gigi!!");
                    $rowgigi = $qgigi->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowgigi['GIGI_SEKARANG'].' Pasien</td>';
                    //GIGI
                    //LAB
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'LB' 
                    AND TRXA_REGI_PAYM = 'U' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qlab = $db->query($querylab) or die("Gagal Ambil lab!!");
                    $rowlab = $qlab->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowlab['LAB_SEKARANG'].' Pasien</td>';
                    //LAB
                    //KIA
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'KB' 
                    AND TRXA_REGI_PAYM = 'U' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qlab = $db->query($querylab) or die("Gagal Ambil lab!!");
                    $rowlab = $qlab->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowlab['LAB_SEKARANG'].' Pasien</td>';
                    //KIA
                    ?>
                </tr>
            </tbody>
            
             <thead>
              <tr>
                  <th>Pasien P.Umum BPJS Hari Ini</th>
                  <th>Pasien P.Gigi BPJS Hari Ini</th>
                  <th>Pasien LAB BPJS Hari Ini</th>
                  <th>Pasien P.KIA BPJS Hari Ini</th>
              </tr>
            </thead>
            
            <tbody>
                <tr>
                    <?php
                    //BPJS
                    $querybpjs = "SELECT COUNT(*) AS BPJS_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_PAYM = 'B' 
                    AND TRXA_REGI_POLI = 'PU' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qbpjs = $db->query($querybpjs) or die("Gagal Ambil bpjs!!");
                    $rowbpjs = $qbpjs->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowbpjs['BPJS_SEKARANG'].' Pasien</td>';
                    //BPJS
                    //GIGI
                    $querygigi = "SELECT COUNT(*) AS GIGI_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'PG' 
                    AND TRXA_REGI_PAYM = 'B' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qgigi = $db->query($querygigi) or die("Gagal Ambil gigi!!");
                    $rowgigi = $qgigi->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowgigi['GIGI_SEKARANG'].' Pasien</td>';
                    //GIGI
                    //LAB
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'LB' 
                    AND TRXA_REGI_PAYM = 'B' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qlab = $db->query($querylab) or die("Gagal Ambil lab!!");
                    $rowlab = $qlab->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowlab['LAB_SEKARANG'].' Pasien</td>';
                    //LAB
                    //KIA
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG  FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow' 
                    AND TRXA_REGI_POLI = 'KB' 
                    AND TRXA_REGI_PAYM = 'B' 
                    AND TRXA_VIEW_STAT = 'Y'
                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    $qlab = $db->query($querylab) or die("Gagal Ambil lab!!");
                    $rowlab = $qlab->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$rowlab['LAB_SEKARANG'].' Pasien</td>';
                    //KIA
                    ?>
                </tr>
            </tbody>
            
           </table>
        

      <h3>Pendapatan Klinik Hari ini</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>Pasien Rawat Jalan</th>
                  <th>Pemeriksaan Laboratorium</th>
                  <th>Penjualan Obat/Alkes</th>
              </tr>
          </thead>

          <tbody>
              <tr>
                <?php

                $queryrajal = "SELECT SUM(TRXA_PAYM_AMNT) AS PENDAPATAN_RAJAL
                              FROM trxasale WHERE TRXA_REGI_POLI <> '$code_lab_room'
                              AND TRXA_VIEW_STAT = 'Y' 
                              AND TRXA_ENTR_DATE = '$datenow'";

                $qrajal = $db->query($queryrajal) or die("Gagal Ambil pendapatan rajal!!");
                $rowrajal = $qrajal->fetch(PDO::FETCH_ASSOC);


                $pendapatanrajal = number_format($rowrajal['PENDAPATAN_RAJAL'], 0, '', '.');

                echo '<td style="text-align: right;">Rp. '.$pendapatanrajal.'</td>';

                $querylabo = "SELECT SUM(TRXA_PAYM_AMNT) AS PENDAPATAN_LABORAT
                              FROM trxasale WHERE TRXA_REGI_POLI = '$code_lab_room'
                              AND TRXA_VIEW_STAT = 'Y' 
                              AND TRXA_ENTR_DATE = '$datenow'";

                $qlabo = $db->query($querylabo) or die("Gagal Ambil pendapatan Laboratorium!!");
                $rowlabo = $qlabo->fetch(PDO::FETCH_ASSOC);


                $pendapatanlabo = number_format($rowlabo['PENDAPATAN_LABORAT'], 0, '', '.');

                echo '<td style="text-align: right;">Rp. '.$pendapatanlabo.'</td>';

                $queryobat = "SELECT SUM(TRXA_PAYM_OUTS) AS PENJUALAN_OBAT
                              FROM trxadrug WHERE TRXA_DRUG_STAT = 'P' 
                              AND TRXA_VIEW_STAT = 'Y'
                              AND TRXA_ENTR_DATE = '$datenow'";

                $qobat = $db->query($queryobat) or die("Gagal Ambil penjualan obat!!");
                $rowobat = $qobat->fetch(PDO::FETCH_ASSOC);


                $penjualanobat = number_format($rowobat['PENJUALAN_OBAT'], 0, '', '.');

                echo '<td style="text-align: right;">Rp. '.$penjualanobat.'</td>';

                ?>

              </tr>
          </tbody>

      </table>


