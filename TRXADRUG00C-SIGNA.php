<?php
include "conf/config.php";
?>
<style>
  #screensgna {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }

  #screensgna td {
    color: black;
    padding: 8px 10px;
    border-bottom: 1px solid #f1f5f9;
  }

  #screensgna tr:hover {
    background: #f8fafc;
    cursor: pointer;
  }

  #screensgna thead th {
    padding: 5px;
    font-size: 12px;
    text-align: left;
    color: black;
  }
</style>
<table id="screensgna">
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
              WHERE TBLP_SGNA_NAME LIKE '%$kata%'
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
      echo '<td>' . $k['TBLP_SGNA_NAME'] . '<br>
      <small>' . $k['TBLP_SGNA_USAG'] . '</small>
      </td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>