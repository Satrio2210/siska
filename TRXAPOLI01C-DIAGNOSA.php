<?php
include "conf/config.php";
?>
<style>
  /* #screen {
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
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;
    color: black;
}
/* #screen tbody, #screen thead
{
    display:block;
}
#screen tbody 
{
  overflow: auto;
  height: 200px;
} */
  #screen {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
  }

  #screen thead {
    background: #10b981;
    color: white;
  }

  #screen th {
    padding: 12px;
    text-align: left;
    font-size: 13px;
  }

  #screen td {
    padding: 12px;
    font-size: 13px;
    border-bottom: 1px solid #e5e7eb;
    cursor: pointer;
  }

  #screen tr:hover {
    background: #f9fafb;
  }
</style>
<table id="screen">
  <thead>
    <tr>
      <th style="width: 100px;">Kode</th>
      <th style="width: 500px;">Diagnosa</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $rawdata = $_POST['q'];
    list($regicode, $diagcode) = explode("|", $rawdata);

    // $xquery = "SELECT DIAG_ICD_CODE AS ICD_CODE, DIAG_ICD_NOTE AS ICD_NAME
    //         FROM diagmast WHERE DIAG_ICD_CODE LIKE '$diagcode%' AND DIAG_VIEW_STAT='Y' 
    //         OR DIAG_ICD_NOTE LIKE '$diagcode%' AND DIAG_VIEW_STAT = 'Y'
    //         OR DIAG_ICD_NOTE LIKE '%$diagcode%' AND DIAG_VIEW_STAT = 'Y'
    //         ORDER BY DIAG_ICD_CODE";
    
    $xquery = "SELECT 
            DIAG_ICD_CODE AS ICD_CODE, 
            DIAG_ICD_NOTE AS ICD_NAME
          FROM diagmast
          WHERE 
          (
              DIAG_ICD_CODE LIKE '$diagcode%'
              OR DIAG_ICD_NOTE LIKE '$diagcode%'
              OR DIAG_ICD_NOTE LIKE '%$diagcode%'
          )
          AND DIAG_VIEW_STAT = 'Y'
          ORDER BY DIAG_ICD_CODE";

    $q = $db->query($xquery) or die("Gagal ambil data !!");
    $found = false;
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {

      $found = true;

      $outicdcode = $k['ICD_CODE'];
      $outicdname = $k['ICD_NAME'];

      echo '<tr>';

      echo '<td style="width: 100px;" onClick="isidiagnosa(\'' . $regicode . '\',\'' . $outicdcode . '\',\'' . $outicdname . '\');" 
      style="cursor:pointer">' . $outicdcode . '</td>';

      echo '<td style="width: 500px; text-align: left;" onClick="isidiagnosa(\'' . $regicode . '\',\'' . $outicdcode . '\',\'' . $outicdname . '\');" 
      style="cursor:pointer">' . $outicdname . '</td>';

      echo '</tr>';

      if (!$found) {
        echo '<tr>
            <td colspan="2" style="
                text-align:center;
                padding:14px;
                color:#6b7280;
            ">
                Diagnosa tidak ditemukan
            </td>
          </tr>';
      }
    }
    ?>
  </tbody>
</table>