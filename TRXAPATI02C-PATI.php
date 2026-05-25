<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
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
#screen tbody, #screen thead
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
  }

  #screen tr {
    transition: .15s;
    cursor: pointer;
  }

  #screen tr:hover {
    background: #f0fdf4;
  }

  #screen td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
  }

  .patient-name {
    font-weight: 600;
    color: #0f172a;
  }

  .patient-rm {
    font-size: 11px;
    color: #64748b;
  }

  .patient-birth {
    font-size: 12px;
    color: #64748b;
  }
</style>
<table id="screen">
  <tbody>
    <?php
    $kata = $_POST['q'];
    if (strlen($kata) == 1) {
      $xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                    PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_PHNE, PATI_MAIN_PRNT 
            FROM patimast 
            WHERE PATI_VIEW_STAT = 'Y' ORDER BY PATI_MAST_CODE";
    } else {
      $xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                    PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_PHNE, PATI_MAIN_PRNT 
            FROM patimast 
            WHERE PATI_MAIN_PIDN LIKE '%$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_NAME LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_BIRT LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            OR PATI_MAIN_PRNT LIKE '$kata%' AND PATI_VIEW_STAT = 'Y'
            ORDER BY PATI_MAST_CODE";
    }

    $q = $db->query($xquery) or die("Gagal ambil data !!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
      $outmastcode = $k['PATI_MAST_CODE'];
      $outmainname = $k['PATI_MAIN_NAME'];
      $outmaingend = $k['PATI_MAIN_GEND'];
      $outmainbirt = formatTanggal($k['PATI_MAIN_BIRT']);
      $outmainblod = $k['PATI_MAIN_BLOD'];
      $outmainaddr = $k['PATI_MAIN_ADDR'];
      $outmainphne = $k['PATI_MAIN_PHNE'];

      echo '<tr onclick="isipaticode(
      \'' . $outmastcode . '\',
      \'' . $outmainname . '\',
      \'' . $outmaingend . '\',
      \'' . $outmainbirt . '\',
      \'' . $outmainblod . '\',
      \'' . $outmainaddr . '\',
      \'' . $outmainphne . '\'
      )">';

      echo '
      <td>

      <div class="patient-name">
      ' . $k['PATI_MAIN_NAME'] . '
      </div>

      <div class="patient-rm">
      RM : ' . $k['PATI_MAST_CODE'] . '
      </div>

      <div class="patient-birth">
      ' . $k['PATI_MAIN_BIRT'] . '
      </div>

      </td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>