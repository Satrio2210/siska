<?php
include "conf/config.php";
?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>

      
      <h3>Status Keluarga Pasien</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Status Keluarga</th>
                  <th>Jumlah</th>
              </tr>
          </thead>

          <tbody>
                <?php

                $no=0;
                $querytotal1 = "SELECT PATI_MAIN_STAT, COUNT(*) AS TOTAL_STAT 
                FROM patimast WHERE PATI_VIEW_STAT = 'Y'
                GROUP BY PATI_MAIN_STAT ORDER BY TOTAL_STAT DESC";


                $qtotal1 = $db->query($querytotal1) or die("Gagal Ambil Status!!");
                while ($k1 = $qtotal1->fetch(PDO::FETCH_ASSOC))
                {
                 $no++; 
                echo '<tr>';  
                echo '<td>'.$no.'</td>';
                echo '<td>'.$k1['PATI_MAIN_STAT'].' </td>';
                $quantity = number_format($k1['TOTAL_STAT'], 0, '', '.');
                echo '<td style="text-align: right;">'.$quantity.' </td>';
                echo '</tr>';  
                }
                


                ?>
          </tbody>

      </table>

      <h3>Status Pendidikan Terakhir Pasien</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Pendidikan Terakhir</th>
                  <th>Jumlah</th>
              </tr>
          </thead>

          <tbody>
                <?php

                $no=0;
                $querytotal2 = "SELECT PATI_MAIN_EDUC, COUNT(*) AS TOTAL_EDUC 
                                FROM patimast WHERE PATI_VIEW_STAT = 'Y' 
                                GROUP BY PATI_MAIN_EDUC ORDER BY TOTAL_EDUC DESC";

                $qtotal2 = $db->query($querytotal2) or die("Gagal Ambil Pendidikan!!");
                while ($k2 = $qtotal2->fetch(PDO::FETCH_ASSOC))
                {
                 $no++; 
                echo '<tr>';  
                echo '<td>'.$no.'</td>';
                echo '<td>'.$k2['PATI_MAIN_EDUC'].' </td>';
                $quantity = number_format($k2['TOTAL_EDUC'], 0, '', '.');
                echo '<td style="text-align: right;">'.$quantity.' </td>';
                echo '</tr>';  
                }
                


                ?>
          </tbody>

      </table>

      <h3>Status Pekerjaan Pasien</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Pekerjaan</th>
                  <th>Jumlah</th>
              </tr>
          </thead>

          <tbody>
                <?php

                $no=0;
                $querytotal3 = "SELECT PROFESI, COUNT(*) AS TOTAL_PROF 
                                FROM
                            (
                            SELECT PATI_MAIN_NAME AS MAIN_NAME, PATI_MAIN_PROF AS MAIN_PROF, 
                            CASE
                                WHEN PATI_MAIN_PROF = 'KARYAWAN SWASTA' THEN 'Karyawan Swasta'
                                WHEN PATI_MAIN_PROF = 'MENGURUS RUMAH TANGGA' THEN 'Ibu Rumah Tangga'
                                WHEN PATI_MAIN_PROF = 'Pelajar' THEN 'Pelajar / Mahasiswa'
                                WHEN PATI_MAIN_PROF = 'IRT' THEN 'Ibu Rumah Tangga'
                                WHEN PATI_MAIN_PROF = 'WIRASWASTA' THEN 'Wiraswasta'
                                WHEN PATI_MAIN_PROF = 'PELAJAR/MAHASISWA' THEN 'Pelajar / Mahasiswa'
                                WHEN PATI_MAIN_PROF = 'PNS' THEN 'Pegawai Negeri Sipil'
                                WHEN PATI_MAIN_PROF = 'MAHASISWA' THEN 'Pelajar / Mahasiswa'
                                WHEN PATI_MAIN_PROF = 'BELUM BEKERJA' THEN 'Tidak Bekerja'
                                WHEN PATI_MAIN_PROF = 'IBU RUMAH TANGGA' THEN 'Ibu Rumah Tangga'
                                WHEN PATI_MAIN_PROF = 'KARYAWAN BUMN' THEN 'Pegawai BUMN'
                                WHEN PATI_MAIN_PROF = 'Pegawai Negeri Sipil' THEN 'Pegawai Negeri Sipil'
                                WHEN PATI_MAIN_PROF = 'ANAK' THEN 'Anak Anak'
                                WHEN PATI_MAIN_PROF = 'GURU' THEN 'Guru'
                                WHEN PATI_MAIN_PROF = 'PENSIUNAN' THEN 'Pensiunan'
                                WHEN PATI_MAIN_PROF = 'BURUH' THEN 'Buruh Harian Lepas'
                                WHEN PATI_MAIN_PROF = 'buruh harian lepas' THEN 'Buruh Harian Lepas'
                                WHEN PATI_MAIN_PROF = 'TIDAK BEKERJA' THEN 'Tidak Bekerja'
                                WHEN PATI_MAIN_PROF = 'PERAWAT' THEN 'Perawat'
                                WHEN PATI_MAIN_PROF = 'BURUH HARIANN LEPAS' THEN 'Buruh Harian Lepas'
                                WHEN PATI_MAIN_PROF = 'KEPOLISIAN RI' THEN 'Polisi'
                                WHEN PATI_MAIN_PROF = 'DOKTER' THEN 'Dokter'
                                WHEN PATI_MAIN_PROF = 'KARYAWAN BUMD' THEN 'Pegawai BUMD'  
                                ELSE 'Tidak Di isi'
                            END
                            AS PROFESI

                            FROM patimast WHERE PATI_VIEW_STAT = 'Y'
                            ) AS TABLE_PROF
                            GROUP BY PROFESI ORDER BY TOTAL_PROF DESC
                            ";

                $qtotal3 = $db->query($querytotal3) or die("Gagal Ambil Pekerjaan!!");
                while ($k3 = $qtotal3->fetch(PDO::FETCH_ASSOC))
                {
                 $no++; 
                echo '<tr>';  
                echo '<td>'.$no.'</td>';
                echo '<td>'.$k3['PROFESI'].' </td>';
                $quantity = number_format($k3['TOTAL_PROF'], 0, '', '.');
                echo '<td style="text-align: right;">'.$quantity.' </td>';
                echo '</tr>';  
                }
                


                ?>
          </tbody>

      </table>
