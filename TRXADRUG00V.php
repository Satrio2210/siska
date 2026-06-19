<?php
include "conf/config.php";
include "inc/sanie.php";
?>
<style>
    #screen {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 12px;
        color: #0f172a;
    }

    /* header */
    /* #screen th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 8px;
        text-align: left;
        font-weight: 600;
    } */

    #screen thead th {
        position: sticky;
        top: 0;
        background: #f8fafc;
        padding: 8px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        font-weight: 700;
        z-index: 2;
    }

    /* body */
    /* #screen td {
        padding: 8px;
        border-bottom: 1px solid #f1f5f9;
    } */

    #screen tbody td {
        padding: 7px 8px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    #screen tbody tr:hover {
        background: #f8fafc;
    }

    /* scroll
    #screen tbody {
        display: block;
        max-height: 260px;
        overflow: auto;
    }

    #screen thead,
    #screen tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    } */

    /* ========================= COLUMN WIDTH ========================= */
    #screen th:nth-child(1),
    #screen td:nth-child(1) {
        width: auto;
    }

    #screen th:nth-child(2),
    #screen td:nth-child(2) {
        width: 70px;
    }

    #screen th:nth-child(3),
    #screen td:nth-child(3) {
        width: 120px;
    }

    #screen th:nth-child(4),
    #screen td:nth-child(4) {
        width: 120px;
    }

    #screen th:nth-child(5),
    #screen td:nth-child(5) {
        width: 70px;
    }

    /* ========================= ACTION BUTTON ========================= */
    .btn-delete {
        border: none;
        background: #fee2e2;
        color: #b91c1c;
        border-radius: 8px;
        width: 28px;
        height: 28px;
        cursor: pointer;
        font-size: 13px;
        transition: .2s;
    }

    .btn-delete:hover {
        background: #fecaca;
    }
</style>
<table id="screen">
    <thead>
        <tr>

            <!-- <th style="width: 300px">Nama Item</th>
            <th style="width: 100px">Batch</th>
            <th style="width: 100px">Satuan</th>
            <th style="width: 100px">Harga</th>
            <th style="width: 100px">Qty</th>
            <th style="width: 100px">Total</th>
            <th style="width: 200px">Action</th> -->

            <th>Obat</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $prsccode = $_POST['q'];

        $xquery = "SELECT TRXA_PRSC_CODE, TRXA_STOCK_CODE, TRXA_STOCK_BTCH, 
          (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS STOCK_NAME,
          (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS UNIT_CODE,
          (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE= UNIT_CODE) AS UNIT_NAME,

                (SELECT INVE_MAIN_SPEC FROM invemast WHERE INVE_MAST_CODE = TRXA_STOCK_CODE) AS SPEC_CODE,
                (SELECT TBLI_SPEC_NAME FROM tblispec WHERE TBLI_SPEC_CODE = SPEC_CODE) AS SPEC_NAME,

           TRXA_STOCK_PRIC, TRXA_STOCK_QUTY, (TRXA_STOCK_PRIC * TRXA_STOCK_QUTY) AS TOTAL_HNA,
           ((TRXA_STOCK_PRIC * '$profit') * TRXA_STOCK_QUTY) AS TOTAL_SALE
          FROM trxaprsc 
          WHERE TRXA_PRSC_STAT IN ('A','I') AND TRXA_PRSC_CODE='$prsccode' AND TRXA_VIEW_STAT='Y'
          ORDER BY TRXA_STOCK_CODE";
        $q = $db->query($xquery) or die("Gagal Ambil Daftar Item Resep!!");

        while ($k = $q->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr>';
            $stockcode = $k['TRXA_STOCK_CODE'];
            echo '<td>' . $k['STOCK_NAME'] . ' ' . $k['SPEC_NAME'] . ' ' . $k['UNIT_NAME'] . '</td>';
            echo '<td>' . $k['TRXA_STOCK_QUTY'] . '</td>';

            $harga_bulat = pembulatan($k['TRXA_STOCK_PRIC']);
            $viewprice = number_format($harga_bulat, 0, '', '.');
            echo '<td>' . $viewprice . '</td>';

            $tothna_bulat = pembulatan($k['TOTAL_HNA']);
            $viewtotalhna = number_format($tothna_bulat, 0, '', '.');
            echo '<td>' . $viewtotalhna . '</td>';

            // $viewtotalsale = number_format($k['TOTAL_SALE'], 0, '', '.');
            // echo '<td>' . $viewtotalsale . '</td>';
        
            // $xharga = round($k['TOTAL_SALE']);
            // $int = (int) $xharga;
        
            // $total_sale = pembulatan($int);
        
            // $viewtotalsale = number_format($total_sale, 0, '', '.');
            //echo '<td style="width: 100px; text-align: right;">'.$viewtotalsale.'</td>';
        
            echo '<td>';
            echo '<button type="button"
            class="btn-delete" onclick="
            if (confirm (\'Hapus Item Resep ?\'))
              { 
            hapuscode(\'' . $prsccode . '\',\'' . $stockcode . '\');
            }">
               🗑<i class="fas fa-trash"></>
              </button>';
            echo '</td>';

            echo '</tr>';
        }
        ?>
    </tbody>
</table>