<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
  #tblrspscreenracik {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    font-size: 14px;
    color: #000000;
  }

  #tblrspscreenracik th {
    background: #f8fafc;
    padding: 8px;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
  }

  #tblrspscreenracik td {
    padding: 8px;
    border-bottom: 1px solid #f1f5f9;
  }

  #tblrspscreenracik tr:hover {
    background: #f8fafc;
    cursor: pointer;
  }

  #tblrspscreenracik th:nth-child(1),
  #tblrspscreenracik td:nth-child(1) {
    width: 60%;
  }

  #tblrspscreenracik th:nth-child(2),
  #tblrspscreenracik td:nth-child(2) {
    width: 20%;
  }

  #tblrspscreenracik th:nth-child(3),
  #tblrspscreenracik td:nth-child(3) {
    width: 20%;
  }

  .badge-stock-ok-racik {
    background: #dcfce7;
    color: #166534;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 11px;
  }

  .badge-stock-low-racik {
    background: #fee2e2;
    color: #991b1b;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 11px;
  }
</style>
<table id="tblrspscreenracik">
  <thead>
    <tr>
      <th>Obat</th>
      <th>Stock</th>
      <th>Harga/Tab/Btl</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $rawdata = $_POST['q'] ?? '';
    list($kata, $regipoli, $regipaym) = explode("|", $rawdata);

    if (strlen($kata) == 1) {
      if ($regipaym == 'U') {
        $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY, INVE_UPDT_DATE,
                    (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
                    (SELECT INVE_PART_ALAS FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS PROD_NAME,
                    (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC 
                    FROM investock 
                    WHERE INVE_WARE_CODE = '$gudang_farmasi' 
                    AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST', 'NS')
                    AND INVE_STOCK_QUTY > 0
                    AND INVE_VIEW_STAT IN ('R','Y')
                    ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";
      } else {
        $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
                  (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
                  (SELECT INVE_PART_ALAS FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS PROD_NAME,
                  (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC 
                  FROM investock 
                  WHERE INVE_WARE_CODE = '$gudang_farmasi' 
                  AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST', 'NS')
                  AND INVE_STOCK_QUTY > 0
                  AND INVE_VIEW_STAT IN ('R','Y')
                  AND INVE_STOCK_CODE IN (SELECT TRXA_INVE_CODE FROM trxacust WHERE TRXA_CUST_TYPE='$regipaym' AND TRXA_VIEW_STAT='Y')
                  ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";
      }
    } else {
      if ($regipaym == 'U') {
        $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT INVE_PART_ALAS FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS PROD_NAME,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC   
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '%$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST', 'NS')
              AND INVE_STOCK_QUTY > 0  
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";
      } else {
        $xquery = "SELECT DISTINCT INVE_STOCK_CODE, INVE_STOCK_BTCH, INVE_STOCK_NAME, INVE_STOCK_PRIC, INVE_STOCK_QUTY,  INVE_UPDT_DATE,
              (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS CODE_SPEC,
              (SELECT INVE_PART_ALAS FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) AS PROD_NAME,
              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE=CODE_SPEC) AS NAME_SPEC   
              FROM investock 
              WHERE INVE_STOCK_NAME LIKE '$$kata%'
              AND INVE_WARE_CODE = '$gudang_farmasi'
              AND (SELECT INVE_PART_TYPE FROM invemast WHERE INVE_MAST_CODE=INVE_STOCK_CODE) IN ('ST', 'NS')
              AND INVE_STOCK_QUTY > 0  
              AND INVE_VIEW_STAT IN ('R','Y')
              ORDER by INVE_STOCK_CODE, INVE_UPDT_DATE DESC";
      }
    }

    $q = $db->query($xquery) or die("Gagal ambil item Obat !!");
    while ($k = $q->fetch(PDO::FETCH_ASSOC)) {
      $outstockcode = $k['INVE_STOCK_CODE'];
      $outstockbtch = $k['INVE_STOCK_BTCH'];
      $outstockname = $k['INVE_STOCK_NAME'];
      $harga_asli = $k['INVE_STOCK_PRIC'];
      $qty = $k['INVE_STOCK_QUTY'];

      $outstockpric = pembulatan((int)round($harga_asli * $profit));
      $view_outstockpric = number_format($outstockpric, 0, ',', '.');
      
      $outstockquty = $qty;

      echo '<tr onClick="isiresep_racik(\'' . $outstockcode . '\',\'' . $outstockbtch . '\',\'' . htmlspecialchars($outstockname, ENT_QUOTES) . '\',\'' . $outstockpric . '\',\'' . $outstockquty . '\');" style="cursor:pointer">';
      echo '<td>';
      echo '<b>' . htmlspecialchars($k['INVE_STOCK_NAME']) . ' - ' . htmlspecialchars($k['NAME_SPEC']) . '</b><br>';
      echo '<small>' . htmlspecialchars($k['PROD_NAME']) . '</small>';
      echo '</td>';

      if ($outstockquty < 20) {
        $stokbadge = '<span class="badge-stock-low-racik">' . $outstockquty . '</span>';
      } else {
        $stokbadge = '<span class="badge-stock-ok-racik">' . $outstockquty . '</span>';
      }

      echo '<td>' . $stokbadge . '</td>';
      echo '<td style="text-align:right;">Rp ' . $view_outstockpric . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
