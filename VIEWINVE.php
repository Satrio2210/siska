<?php
include "conf/config.php";
?>
<style type="text/css">
  tr:nth-child(even){background-color: #f3f2f2;}
</style>

      <h3>Laporan Stok In Hand</h3>

      <table class="pure-table pure-table-bordered">
          <thead>
              <tr>
                  <th>Kode</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
              </tr>
          </thead>

          <tbody>
                <?php

                $querytotal = "SELECT INVE_MAIN_TYPE, INVE_MAIN_SPEC, INVE_MAST_CODE, INVE_MAIN_VARN, INVE_PART_NAME, 
                              INVE_SALE_UNIT, 
                              (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = INVE_SALE_UNIT) AS NAME_UNIT,
                              (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = INVE_MAIN_SPEC) AS SPEC_NAME,
                              (SELECT SUM(INVE_STOCK_QUTY) FROM investock WHERE INVE_STOCK_CODE=INVE_MAST_CODE) AS QUANTITY
                              FROM invemast 
                              WHERE INVE_VIEW_STAT = 'Y' 
                              AND (SELECT SUM(INVE_STOCK_QUTY) FROM investock WHERE INVE_STOCK_CODE=INVE_MAST_CODE) IS NOT NULL
                              order by QUANTITY DESC";


                $qtotal = $db->query($querytotal) or die("Gagal Ambil Total!!");
                while ($k = $qtotal->fetch(PDO::FETCH_ASSOC))
                {
                echo '<tr>';  
                $mastcode = $k['INVE_MAIN_TYPE'].'-'.$k['INVE_MAIN_SPEC'].$k['INVE_MAST_CODE'].'-'.$k['INVE_MAIN_VARN'];
                echo '<td>'.$mastcode.' </td>';
                echo '<td>'.$k['INVE_PART_NAME'].' '.$k['SPEC_NAME'].' </td>';
                echo '<td>'.$k['NAME_UNIT'].' </td>';
                $quantity = number_format($k['QUANTITY'], 0, '', '.');
                echo '<td style="text-align: right;">'.$quantity.' </td>';
                echo '</tr>';  
                }
                


                ?>
          </tbody>

      </table>

