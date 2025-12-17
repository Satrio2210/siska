<?php
include "conf/config.php";

$fulldate = $_POST['q'];
//$kode = 'ACC';
list($startdate, $enddate) = explode("|",$fulldate);
?>
        TOTAL PASIEN
          <table class="pure-table pure-table-bordered">
              <thead>
                  <tr>
                      <th>Total Pasien</th>
                  </tr>
                  <tr>
                      <th><?php echo $startdate?> - <?php echo $startdate?></th>
                  </tr>
              </thead>
              
              <tbody>
                  <tr>
                      <?php 
                      
                    if ($startdate == $enddate)
                    { 
                    $querytot = "SELECT COUNT(*) AS TOTAL_PASIEN FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'
                                ";
                    } else {
                    $querytot = "SELECT COUNT(*) AS TOTAL_PASIEN FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qtot = $db->query($querytot) or die("Gagal Ambil umum!!");
                    $ktot = $qtot->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$ktot['TOTAL_PASIEN'].' Pasien</td>';
                      
                      ?>
                  </tr>
              </tbody>
          </table>
          </br>
          Breakdown Per Payment
          </br>
          <table class="pure-table pure-table-bordered">
              <thead>
                  <tr>
                      <th>Pasien Umum</th>
                      <th>Pasien BPJS</th>
                  </tr>
              </thead>
              
              <tbody>
                  <tr>
                      <?php 
                      
                    if ($startdate == $enddate)
                    { 
                    $querytotum = "SELECT COUNT(*) AS TOTAL_UMUM FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y'
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $querytotum = "SELECT COUNT(*) AS TOTAL_UMUM FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y'
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qtotum = $db->query($querytotum) or die("Gagal Ambil umum paym!!");
                    $ktotum = $qtotum->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$ktotum['TOTAL_UMUM'].' Pasien</td>';
                    
                    if ($startdate == $enddate)
                    { 
                    $querytotbp = "SELECT COUNT(*) AS TOTAL_BPJS FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_PAYM = 'B'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $querytotbp = "SELECT COUNT(*) AS TOTAL_BPJS FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_PAYM = 'B'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qtotbp = $db->query($querytotbp) or die("Gagal Ambil bpjs paym!!");
                    $ktotbp = $qtotbp->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$ktotbp['TOTAL_BPJS'].' Pasien</td>';
                      
                      ?>
                  </tr>
              </tbody>
          </table>
      </br>
      Breakdown Per Poli
      </br>
          <table class="pure-table pure-table-bordered">
            <thead>
              <tr>
                  <th>Pasien P.Umum</th>
                  <th>Pasien P.Gigi</th>
                  <th>Pasien LAB</th>
                  <th>Pasien P.KIA</th>
              </tr>
            </thead>
            
            <tbody>
                <tr>
                    <?php
                    //UMUM
                    // $no=0;
                    if ($startdate == $enddate)
                    { 
                    $queryumum = "SELECT COUNT(*) AS UMUM_SEKARANG  FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'PU'
                                AND TRXA_REGI_PAYM = 'U' 
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $queryumum = "SELECT COUNT(*) AS UMUM_SEKARANG  FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'PU' 
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qumum = $db->query($queryumum) or die("Gagal Ambil umum!!");
                    $kumum = $qumum->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$kumum['UMUM_SEKARANG'].' Pasien</td>';
                    //UMUM
                    //GIGI
                    if ($startdate == $enddate)
                    { 
                    $querygigi = "SELECT COUNT(*) AS GIGI_SEKARANG  FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'PG' 
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $querygigi = "SELECT COUNT(*) AS GIGI_SEKARANG  FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'PG' 
                                AND TRXA_REGI_PAYM = 'U' 
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qgigi = $db->query($querygigi) or die("Gagal Ambil Gigi!!");
                    $kgigi = $qgigi->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$kgigi['GIGI_SEKARANG'].' Pasien</td>';
                    //GIGI
                    //LAB
                    if ($startdate == $enddate)
                    { 
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG  FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'LB' 
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $querylab = "SELECT COUNT(*) AS LAB_SEKARANG FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'LB' 
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qlab = $db->query($querylab) or die("Gagal Ambil Lab!!");
                    $klab = $qlab->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$klab['LAB_SEKARANG'].' Pasien</td>';
                    //LAB
                    //KIA
                    if ($startdate == $enddate)
                    { 
                    $querykia = "SELECT COUNT(*) AS KIA_SEKARANG FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'KB' 
                                AND TRXA_REGI_PAYM = 'U'
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                    $querykia = "SELECT COUNT(*) AS KIA_SEKARANG FROM trxaregi WHERE TRXA_VIEW_STAT = 'Y' 
                                AND TRXA_REGI_POLI = 'KB' 
                                AND TRXA_REGI_PAYM = 'U' 
                                AND TRXA_REGI_STAT IN ('C', 'P', 'X')
                                AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qkb = $db->query($querykia) or die("Gagal Ambil KIA!!");
                    $klab = $qkb->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$klab['KIA_SEKARANG'].' Pasien</td>';
                    //KIA
                    ?>
                </tr>
            </tbody>
            
             <thead>
              <tr>
                  <th>Pasien P.Umum BPJS</th>
                  <th>Pasien P.Gigi BPJS</th>
                  <th>Pasien LAB BPJS</th>
                  <th>Pasien P.KIA BPJS</th>
              </tr>
            </thead>
            
            <tbody>
                <tr>
                    <?php
                    //BPJS
                    $qbpjsumum = "SELECT COUNT(*) AS BPJS_SEKARANG  FROM trxaregi 
                                  WHERE TRXA_VIEW_STAT = 'Y' 
                                    AND TRXA_REGI_POLI = 'PU' 
                                    AND TRXA_REGI_PAYM = 'B' 
                                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    
                    if ($startdate == $enddate) {
                        $qbpjsumum .= " AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                        $qbpjsumum .= " AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $qbumum = $db->query($qbpjsumum) or die("Gagal Ambil BPJS_Umum!!");
                    $bumum = $qbumum->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$bumum['BPJS_SEKARANG'].' Pasien</td>';
                                        //BPJS
                    //GIGI
                    $gbpjsqueri = "SELECT COUNT(*) AS GBPJS_SEKARANG  FROM trxaregi 
                                  WHERE TRXA_VIEW_STAT = 'Y' 
                                    AND TRXA_REGI_POLI = 'PG' 
                                    AND TRXA_REGI_PAYM = 'B' 
                                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    
                    if ($startdate == $enddate) {
                        $gbpjsqueri .= " AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                        $gbpjsqueri .= " AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $gbpjs = $db->query($gbpjsqueri) or die("Gagal Ambil BPJS_GIGI!!");
                    $gbpjssum = $gbpjs->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$gbpjssum['GBPJS_SEKARANG'].' Pasien</td>';
                    //GIGI
                    //LAB
                    $lbpjsqueri = "SELECT COUNT(*) AS LBPJS_SEKARANG  FROM trxaregi 
                                  WHERE TRXA_VIEW_STAT = 'Y' 
                                    AND TRXA_REGI_POLI = 'PG' 
                                    AND TRXA_REGI_PAYM = 'B' 
                                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    
                    if ($startdate == $enddate) {
                        $lbpjsqueri .= " AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                        $lbpjsqueri .= " AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $lbpjs = $db->query($lbpjsqueri) or die("Gagal Ambil BPJS_LAB!!");
                    $lbpjssum = $lbpjs->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$lbpjssum['LBPJS_SEKARANG'].' Pasien</td>';
                    //LAB
                    //KIA
                    $kbpjsqueri = "SELECT COUNT(*) AS KBPJS_SEKARANG  FROM trxaregi 
                                  WHERE TRXA_VIEW_STAT = 'Y' 
                                    AND TRXA_REGI_POLI = 'KB' 
                                    AND TRXA_REGI_PAYM = 'B' 
                                    AND TRXA_REGI_STAT IN ('C', 'P', 'X')";
                    
                    if ($startdate == $enddate) {
                        $kbpjsqueri .= " AND TRXA_REGI_DATE = '$startdate'";
                    } else {
                        $kbpjsqueri .= " AND TRXA_REGI_DATE BETWEEN '$startdate' AND '$enddate'";
                    }
                    
                    $kbpjs = $db->query($kbpjsqueri) or die("Gagal Ambil BPJS_KIA!!");
                    $kbpjssum = $kbpjs->fetch(PDO::FETCH_ASSOC);
                    
                    echo '<td>'.$kbpjssum['KBPJS_SEKARANG'].' Pasien</td>';
                    //KIA
                    ?>
                </tr>
            </tbody>
            
           </table>
    

      </table>


