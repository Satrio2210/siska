<?php
include "conf/config.php";
?>
<style>
  #screen {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }

  #screen td {
    padding: 8px 10px;
    border-bottom: 1px solid #f1f5f9;
  }

  #screen tr:hover {
    background: #f8fafc;
    cursor: pointer;
  }
</style>
<table id="screen">
  <thead>
    <tr>
      <th>SIGNA</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $kata = $_POST['q'];
    //list($kata, $regipoli) = explode("|",$rawdata);
    
    if (strlen($kata) == 1) {

      $xquery = "SELECT TBLP_SGNA_CODE, TBLP_SGNA_NAME, TBLP_SGNA_USAG 
              FROM tblpsgna 
              WHERE TBLP_SGNA_STAT ='Y'
              ORDER by TBLP_SGNA_CODE";

    } else {
      $xquery = "SELECT TBLP_SGNA_CODE, TBLP_SGNA_NAME, TBLP_SGNA_USAG
              FROM tblpsgna 
              WHERE TBLP_SGNA_NAME LIKE '$kata%'
              AND TBLP_SGNA_STAT ='Y'
              ORDER by TBLP_SGNA_CODE";
    }

    $q = $db->query($xquery) or die("Gagal ambil Signa!!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
      $outsgnacode = $k['TBLP_SGNA_CODE'];
      $outsgnaname = $k['TBLP_SGNA_NAME'];
      $outsgnausag = $k['TBLP_SGNA_USAG'];

      echo '<tr onClick="isisigna(\'' . $outsgnacode . '\',\'' . $outsgnaname . '\',\'' . $outsgnausag . '\');" 
      style="cursor:pointer">';
      echo '<td>' . $k['TBLP_SGNA_NAME'] . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>