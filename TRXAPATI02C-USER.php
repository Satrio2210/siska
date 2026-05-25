<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
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

  .doctor-name {
    font-weight: 600;
    color: #0f172a;
  }

  .room-name {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
  }
</style>
<table id="screen">
  <!-- <thead>
    <tr>
      <th style="width: 200px;">DOCTOR</th>
      <th style="width: 200px;">MEDICAL ROOM</th>
    </tr>
  </thead> -->
  <tbody>
    <?php
    $kata = $_POST['q'];
    $weekdays = date('w');

    if (strlen($kata) == 1) {
      $xquery = "SELECT TRXA_DOCT_USER, TRXA_DOCT_NAME, TRXA_MEDI_ROOM,
            (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_MEDI_ROOM) AS ROOM_NAME
            FROM trxaschd WHERE TRXA_SCHD_DAYS = '$weekdays' AND TRXA_VIEW_STAT = 'Y'";

    } else {
      $xquery = "SELECT TRXA_DOCT_USER, TRXA_DOCT_NAME, TRXA_MEDI_ROOM,
            (SELECT TBLA_POLI_NAME FROM tblapoli WHERE TBLA_POLI_CODE = TRXA_MEDI_ROOM) AS ROOM_NAME
            FROM trxaschd WHERE TRXA_DOCT_NAME LIKE '$kata%'
            AND TRXA_SCHD_DAYS = '$weekdays' AND TRXA_VIEW_STAT = 'Y'
            OR TRXA_DOCT_NAME LIKE '%$kata%'
            AND TRXA_SCHD_DAYS = '$weekdays' AND TRXA_VIEW_STAT = 'Y'
            ";
    }

    $q = $db->query($xquery) or die("Gagal ambil data !!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
      $outdoctuser = $k['TRXA_DOCT_USER'];
      $outdoctname = $k['TRXA_DOCT_NAME'];
      $outmediroom = $k['TRXA_MEDI_ROOM'];
      $outroomname = $k['ROOM_NAME'];

      // echo '<tr>';

      // echo '<td style="width: 200px;" onClick="isidoctuser(\'' . $outdoctuser . '\',\'' . $outdoctname . '\',\'' . $outmediroom . '\',\'' . $outroomname . '\');" 
      // style="cursor:pointer">' . $k['TRXA_DOCT_NAME'] . '</td>';
      // echo '<td style="width: 200px;" onClick="isidoctuser(\'' . $outdoctuser . '\',\'' . $outdoctname . '\',\'' . $outmediroom . '\',\'' . $outroomname . '\');" 
      // style="cursor:pointer">' . $k['ROOM_NAME'] . '</td>';

      // echo '</tr>';

      echo '
      <tr onclick="isidoctuser(
      \'' . $outdoctuser . '\',
      \'' . $outdoctname . '\',
      \'' . $outmediroom . '\',
      \'' . $outroomname . '\'
      )">

      <td>

      <div class="doctor-name">
      ' . $k['TRXA_DOCT_NAME'] . '
      </div>

      <div class="room-name">
      ' . $k['ROOM_NAME'] . '
      </div>

      </td>

      </tr>
      ';
    }
    ?>
  </tbody>
</table>