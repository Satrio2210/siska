<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
  .table-wrapper {
    max-height: 420px;
    overflow: auto;
  }

  #screen {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 13px;
    background: #fff;
  }

  #screen thead {
    background: linear-gradient(90deg, #16a34a, #22c55e);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
  }

  #screen thead th {
    position: sticky;
    top: 0;
    /* background: #f8fafc; */
    /* color: #334155; */
    padding: 10px;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
  }

  #screen tbody td {
    padding: 10px;
    border-bottom: 1px solid #f1f5f9;
    font-weight: 600;
  }

  #screen tbody tr:hover {
    background: #f8fafc;
  }

  .badge-success {
    background: #dcfce7;
    color: #166534;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
  }

  .badge-warning {
    background: #fee2e2;
    color: #991b1b;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
  }

  .badge-info {
    background: #dbeafe;
    color: #1d4ed8;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
  }

  .btn-detail {
    border: none;
    border-radius: 8px;
    padding: 7px 12px;
    background: #16a34a;
    color: white;
    cursor: pointer;
    font-size: 12px;
    font-weight: 700;
  }

  .btn-cetak {
    border: none;
    border-radius: 8px;
    padding: 7px 12px;
    background: #a39516;
    color: white;
    cursor: pointer;
    font-size: 12px;
    font-weight: 700;
  }

  /* ========================= COLUMN WIDTH ========================= */
  #screen th:nth-child(1),
  #screen td:nth-child(1) {
    width: 20px;
  }

  #screen th:nth-child(2),
  #screen td:nth-child(2) {
    width: 120px;
  }

  #screen th:nth-child(3),
  #screen td:nth-child(3) {
    width: 120px;
  }

  #screen th:nth-child(4),
  #screen td:nth-child(4) {
    width: 50px;
  }

  #screen th:nth-child(5),
  #screen td:nth-child(5) {
    width: 50px;
  }

  #screen th:nth-child(6),
  #screen td:nth-child(6) {
    width: 50px;
  }

  #screen th:nth-child(7),
  #screen td:nth-child(7) {
    width: 50px;
  }
</style>
<div class="card-modern">

  <div class="card-body">
    <div class="table-wrapper">
      <table id="screen">
        <thead>
          <tr>
            <th>No. Antrian</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Pembayaran</th>
            <th>Jumlah Obat</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $kata = $_POST['q'];
          $panjangkata = strlen($kata);
          $xquery = "SELECT
              p.TRXA_PRSC_CODE,
              r.TRXA_REGI_LIST,
              pm.PATI_MAIN_TITL,
              pm.PATI_MAIN_NAME,
              d.PASS_USER_NAME,
              CASE
                  WHEN r.TRXA_REGI_PAYM='U' THEN 'UMUM'
                  WHEN r.TRXA_REGI_PAYM='B' THEN 'BPJS'
                  ELSE '-'
              END AS PEMBAYARAN,
              COUNT(*) AS JML_OBAT,
              SUM(CASE WHEN p.TRXA_PRSC_STAT='A' THEN 1 ELSE 0 END) AS CNT_A,
              SUM(CASE WHEN p.TRXA_PRSC_STAT='I' THEN 1 ELSE 0 END) AS CNT_I,
              MAX(p.TRXA_ENTR_DATE) AS LAST_DATE,
              MAX(p.TRXA_ENTR_TIME) AS LAST_TIME
              FROM trxaprsc p
              INNER JOIN trxaregi r
              ON r.TRXA_REGI_CODE=p.TRXA_PRSC_CODE
              LEFT JOIN patimast pm
              ON pm.PATI_MAST_CODE=r.TRXA_PATI_CODE
              LEFT JOIN passiden d
              ON d.PASS_USER_IDEN=r.TRXA_REGI_DOCT
              WHERE
              p.TRXA_VIEW_STAT='Y'
              AND p.TRXA_PRSC_STAT IN ('A','I')
              AND p.TRXA_ENTR_DATE > DATE_SUB(CURDATE(),INTERVAL 4 DAY)
              ";

          if ($kata != '') {
            $xquery .= "
      AND (
          pm.PATI_MAIN_NAME LIKE '$kata%'
          OR r.TRXA_REGI_LIST LIKE '$kata%'
      )
      ";
          }
          $xquery .= "
              GROUP BY 
              p.TRXA_PRSC_CODE,
              r.TRXA_REGI_LIST,
              pm.PATI_MAIN_TITL,
              pm.PATI_MAIN_NAME,
              d.PASS_USER_NAME,
              r.TRXA_REGI_PAYM

              ORDER BY 
              LAST_DATE DESC,
              LAST_TIME DESC
              ";

          // $q = $db->query($xquery) or die("Gagal Maning!!");
          
          $q = $db->query($xquery);

          if (!$q) {
            print_r($db->errorInfo());
            exit;
          }

          while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
            $cnt_a = $k['CNT_A'];
            $cnt_i = $k['CNT_I'];

            if ($cnt_i == 0) {
              $status = '<span class="badge-warning">BELUM SIAP</span>';
            } else if ($cnt_a == 0) {
              $status = '<span class="badge-success">SUDAH SIAP</span>';
            } else {
              $status = '<span class="badge-info">DIPROSES</span>';
            }

            echo '<tr>';

            echo '<td>' . $k['TRXA_REGI_LIST'] . '</td>';

            echo '<td style="text-align:left">' .
              $k['PATI_MAIN_TITL'] . ' ' .
              $k['PATI_MAIN_NAME'] .
              '</td>';

            echo '<td style="text-align:left">' .
              $k['PASS_USER_NAME'] .
              '</td>';

            echo '<td>' .
              $k['PEMBAYARAN'] .
              '</td>';

            echo '<td>' .
              $k['JML_OBAT'] . ' Item' .
              '</td>';

            echo '<td>' .
              $status .
              '</td>';

            echo '
      <td>
        <button
            type="button"
            class="btn-detail"
            onclick="viewresep(\'' . $k['TRXA_PRSC_CODE'] . '\')">
            Detail
        </button>

        <button
            type="button"
            class="btn-cetak"
            onclick="">
            E-Tiket
        </button>
      </td>';

            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>