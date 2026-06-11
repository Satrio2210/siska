<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";
include "inc/sanie.php";

$prsccode = $_POST['q'];
$xhead = "SELECT
         r.TRXA_REGI_CODE,
         r.TRXA_REGI_LIST,
         r.TRXA_REGI_PAYM,
         pm.PATI_MAIN_TITL,
         pm.PATI_MAIN_NAME,
         d.PASS_USER_NAME
         FROM trxaregi r
         LEFT JOIN patimast pm
         ON pm.PATI_MAST_CODE=r.TRXA_PATI_CODE
         LEFT JOIN passiden d
         ON d.PASS_USER_IDEN=r.TRXA_REGI_DOCT
         WHERE r.TRXA_REGI_CODE='$prsccode'
         ";

$qhead = $db->query($xhead) or die($db->errorInfo()[2]);
$row = $qhead->fetch(PDO::FETCH_ASSOC);

$xdetail = "SELECT
            p.TRXA_STOCK_CODE,
            p.TRXA_STOCK_BTCH,
            p.TRXA_PRSC_CONC,
            i.INVE_PART_NAME,
            s.TBLI_SPEC_NAME,
            u.TBLI_UNIT_NAME,
            p.TRXA_STOCK_QUTY,
            IFNULL(p.TRXA_STOCK_BTCH,'Belum Diisi') AS BTCH,
            CASE
            WHEN p.TRXA_PRSC_CONC='Y'
            THEN 'Racikan'
            ELSE 'Non Racikan'
            END AS JENIS
            FROM trxaprsc p
            LEFT JOIN invemast i
            ON i.INVE_MAST_CODE=p.TRXA_STOCK_CODE
            LEFT JOIN tblispec s
            ON s.TBLI_SPEC_CODE=i.INVE_MAIN_SPEC
            LEFT JOIN tbliunit u
            ON u.TBLI_UNIT_CODE=i.INVE_SALE_UNIT
            WHERE
            p.TRXA_PRSC_CODE='$prsccode'
            AND p.TRXA_VIEW_STAT='Y'
            ";

$qdetail = $db->query($xdetail) or die($db->errorInfo()[2]);

echo '

<div class="card-modern">

  <div class="card-title">
    DETAIL RESEP
  </div>

  <div class="card-body">

    <table width="100%" class="detail-header">

      <tr>
        <td width="150"><b>No Antrian</b></td>
        <td>: ' . $row['TRXA_REGI_LIST'] . '</td>
      </tr>

      <tr>
        <td><b>Pasien</b></td>
        <td>: ' . $row['PATI_MAIN_TITL'] . ' ' . $row['PATI_MAIN_NAME'] . '</td>
      </tr>

      <tr>
        <td><b>Dokter</b></td>
        <td>: ' . $row['PASS_USER_NAME'] . '</td>
      </tr>

      <tr>
        <td><b>Pembayaran</b></td>
        <td>: ' . ($row['TRXA_REGI_PAYM'] == 'B' ? 'BPJS' : 'UMUM') . '</td>
      </tr>

    </table>

    <div style="height:15px"></div>

    <table id="tbldetail">

      <thead>
        <tr>
          <th>Obat</th>
          <th>Qty</th>
          <th>Batch</th>
          <th>Jenis</th>
          <th width="150">Action</th>
        </tr>
      </thead>

      <tbody>
';

while ($d = $qdetail->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';

    echo '<td>'
        . $d['INVE_PART_NAME'] . ' '
        . $d['TBLI_SPEC_NAME']
        . '</td>';

    echo '<td>'
        . $d['TRXA_STOCK_QUTY'] . ' '
        . $d['TBLI_UNIT_NAME']
        . '</td>';

    echo '<td>'
        . $d['BTCH']
        . '</td>';

    echo '<td>'
        . $d['JENIS']
        . '</td>';

    echo '<td>';

    echo '<button type="button" class="btn-edit" onclick="editobat(\'' . $prsccode . '\',\'' . $d['TRXA_STOCK_CODE'] . '\')">Edit</button>';

    echo '<button type="button" class="btn-delete" onclick="hapusobat(\'' . $prsccode . '\',\'' . $d['TRXA_STOCK_CODE'] . '\')">Hapus</button>';

    echo '</td>';

    echo '</tr>';
}
echo '

      </tbody>

    </table>

    <div style="margin-top:20px;text-align:right;">

      <button
        class="btn-siapkan"
        type="button"
        onclick="siapkansemua(\'' . $prsccode . '\')">

        SIAPKAN SEMUA RESEP

      </button>

    </div>

  </div>

</div>

';

