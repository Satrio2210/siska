<?php
session_start();
include "conf/config.php";
include "inc/sanie.php";

if (!isset($_SESSION['username'])) {
    die("Unauthorized");
}

$action = $_GET['action'] ?? '';

if ($action == 'add_head') {
    $prsccode = $_POST['prsccode'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $signa = $_POST['signa'] ?? '';
    $qty = (int)($_POST['qty'] ?? 1);
    
    if ($prsccode == '' || $nama == '') {
        die("ERROR|Data tidak lengkap");
    }
    
    // Cari usage dari signa jika diinput nama signa-nya
    $usag = '';
    $qsg = $db->prepare("SELECT TBLP_SGNA_USAG FROM tblpsgna WHERE TBLP_SGNA_NAME = :signa1 OR TBLP_SGNA_CODE = :signa2 LIMIT 1");
    $qsg->execute([
        ':signa1' => $signa,
        ':signa2' => $signa
    ]);
    if ($row = $qsg->fetch(PDO::FETCH_ASSOC)) {
        $usag = $row['TBLP_SGNA_USAG'];
    }

    $sql = "INSERT INTO trxaracik_head (TRXAR_CODE, TRXAR_NAMA, TRXAR_SGNA, TRXAR_USAG, TRXAR_QTY, TRXAR_VIEW_STAT, TRXAR_ENTR_DATE, TRXAR_ENTR_TIME, TRXAR_ENTR_USER)
            VALUES (:code, :nama, :signa, :usag, :qty, 'Y', CURDATE(), CURTIME(), :user)";
    $q = $db->prepare($sql);
    $q->execute([
        ':code' => $prsccode,
        ':nama' => $nama,
        ':signa' => $signa,
        ':usag' => $usag,
        ':qty' => $qty,
        ':user' => $_SESSION['username']
    ]);
    $new_id = $db->lastInsertId();
    echo "OK|" . $new_id;
    exit;
}

if ($action == 'del_head') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        die("ERROR|ID tidak valid");
    }
    
    $db->beginTransaction();
    // Soft delete head
    $q1 = $db->prepare("UPDATE trxaracik_head SET TRXAR_VIEW_STAT = 'N' WHERE TRXAR_ID = :id");
    $q1->execute([':id' => $id]);
    
    // Soft delete items associated with this racikan
    $q2 = $db->prepare("UPDATE trxaprsc SET TRXA_VIEW_STAT = 'N' WHERE TRXA_RACIK_ID = :id");
    $q2->execute([':id' => $id]);
    $db->commit();
    
    echo "OK";
    exit;
}

if ($action == 'tmpl_head') {
    $prsccode = $_POST['prsccode'] ?? '';
    
    $sql = "SELECT * FROM trxaracik_head WHERE TRXAR_CODE = :code AND TRXAR_VIEW_STAT = 'Y' ORDER BY TRXAR_ID DESC";
    $q = $db->prepare($sql);
    $q->execute([':code' => $prsccode]);
    
    echo '<style>
        .tbl-racik { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 5px; }
        .tbl-racik th { background: #f1f5f9; padding: 8px; border-bottom: 1px solid #cbd5e1; text-align: left; font-weight: bold; }
        .tbl-racik td { padding: 8px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .tbl-racik tr.active-row { background: #dcfce7 !important; font-weight: bold; }
        .tbl-racik tbody tr:hover { background: #f8fafc; cursor: pointer; }
        .btn-racik-action { border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold; }
        .btn-racik-del { background: #fee2e2; color: #b91c1c; }
        .btn-racik-del:hover { background: #fecaca; }
        .btn-racik-sel { background: #dbeafe; color: #1e40af; margin-right: 5px; }
        .btn-racik-sel:hover { background: #bfdbfe; }
    </style>';
    
    echo '<table class="tbl-racik">
            <thead>
                <tr>
                    <th>Nama Racikan</th>
                    <th>Signa</th>
                    <th>Qty</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';
    
    $count = 0;
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        echo '<tr id="row_racik_' . $row['TRXAR_ID'] . '" onclick="selectRacikanRow(' . $row['TRXAR_ID'] . ', \'' . htmlspecialchars($row['TRXAR_NAMA'], ENT_QUOTES) . '\')">
                <td>' . htmlspecialchars($row['TRXAR_NAMA']) . '</td>
                <td>' . htmlspecialchars($row['TRXAR_SGNA']) . '</td>
                <td>' . htmlspecialchars($row['TRXAR_QTY']) . '</td>
                <td style="text-align: center;" onclick="event.stopPropagation();">
                    <button type="button" class="btn-racik-action btn-racik-sel" onclick="selectRacikanRow(' . $row['TRXAR_ID'] . ', \'' . htmlspecialchars($row['TRXAR_NAMA'], ENT_QUOTES) . '\')">Pilih</button>
                    <button type="button" class="btn-racik-action btn-racik-del" onclick="hapusRacikan(' . $row['TRXAR_ID'] . ')">Hapus</button>
                </td>
              </tr>';
    }
    
    if ($count == 0) {
        echo '<tr><td colspan="4" style="text-align: center; color: #64748b; font-style: italic;">Belum ada racikan. Silakan buat dahulu.</td></tr>';
    }
    
    echo '</tbody></table>';
    exit;
}

if ($action == 'add_detail') {
    $prsccode = $_POST['prsccode'] ?? '';
    $stockcode = $_POST['stockcode'] ?? '';
    $stockbtch = $_POST['stockbtch'] ?? '';
    $stockpric = $_POST['stockpric'] ?? 0;
    $stockqty = $_POST['stockqty'] ?? 1;
    $racik_id = (int)($_POST['racik_id'] ?? 0);
    
    if ($prsccode == '' || $stockcode == '' || $racik_id <= 0) {
        die("ERROR|Data komposisi tidak lengkap");
    }
    
    // Ambil info signa & usage dari header racikan
    $qhead = $db->prepare("SELECT TRXAR_SGNA, TRXAR_USAG FROM trxaracik_head WHERE TRXAR_ID = :id LIMIT 1");
    $qhead->execute([':id' => $racik_id]);
    $head = $qhead->fetch(PDO::FETCH_ASSOC);
    if (!$head) {
        die("ERROR|Racikan tidak ditemukan");
    }
    
    $signa_name = $head['TRXAR_SGNA'];
    $usag = $head['TRXAR_USAG'];
    
    // Cari signa code dari namanya jika ada
    $signa_code = '01'; // default
    $qsg = $db->prepare("SELECT TBLP_SGNA_CODE FROM tblpsgna WHERE TBLP_SGNA_NAME = :name LIMIT 1");
    $qsg->execute([':name' => $signa_name]);
    if ($row = $qsg->fetch(PDO::FETCH_ASSOC)) {
        $signa_code = $row['TBLP_SGNA_CODE'];
    }
    
    // Info dokter dan poli dari registrasi
    $qreg = $db->prepare("SELECT TRXA_REGI_DOCT, TRXA_REGI_POLI FROM trxaregi WHERE TRXA_REGI_CODE = :code LIMIT 1");
    $qreg->execute([':code' => $prsccode]);
    $reg = $qreg->fetch(PDO::FETCH_ASSOC);
    $doctor = $reg['TRXA_REGI_DOCT'] ?? '';
    $poli = $reg['TRXA_REGI_POLI'] ?? '';
    
    $userid = $_SESSION['username'];
    
    // Cek apakah obat sudah ada di racikan ini
    $qcek = $db->prepare("SELECT COUNT(*) FROM trxaprsc WHERE TRXA_PRSC_CODE = :code AND TRXA_STOCK_CODE = :stock AND TRXA_RACIK_ID = :racik_id AND TRXA_VIEW_STAT = 'Y'");
    $qcek->execute([':code' => $prsccode, ':stock' => $stockcode, ':racik_id' => $racik_id]);
    $exists = $qcek->fetchColumn();
    
    if ($exists == 0) {
        $sql = "INSERT INTO trxaprsc (
                    TRXA_PRSC_CODE, TRXA_PRSC_DOCT, TRXA_STOCK_CODE, TRXA_STOCK_BTCH, TRXA_PRSC_CONC,
                    TRXA_STOCK_PRIC, TRXA_STOCK_QUTY, TRXA_PRSC_SGNA, TRXA_PRSC_USAG, TRXA_MEDI_ROOM,
                    TRXA_PRSC_STAT, TRXA_VIEW_STAT, TRXA_RACIK_ID,
                    TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,
                    TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER
                ) VALUES (
                    :code, :doctor, :stock, :btch, 'Y',
                    :pric, :qty, :sgna, :usag, :poli,
                    'A', 'Y', :racik_id,
                    CURDATE(), CURTIME(), :user,
                    CURDATE(), CURTIME(), :user
                )";
        $q = $db->prepare($sql);
        $q->execute([
            ':code' => $prsccode,
            ':doctor' => $doctor,
            ':stock' => $stockcode,
            ':btch' => $stockbtch,
            ':pric' => $stockpric,
            ':qty' => $stockqty,
            ':sgna' => $signa_code,
            ':usag' => $usag,
            ':poli' => $poli,
            ':racik_id' => $racik_id,
            ':user' => $userid
        ]);
    } else {
        $sql = "UPDATE trxaprsc SET 
                    TRXA_STOCK_QUTY = TRXA_STOCK_QUTY + :qty,
                    TRXA_STOCK_BTCH = :btch,
                    TRXA_STOCK_PRIC = :pric,
                    TRXA_UPDT_DATE = CURDATE(),
                    TRXA_UPDT_TIME = CURTIME(),
                    TRXA_UPDT_USER = :user
                WHERE TRXA_PRSC_CODE = :code AND TRXA_STOCK_CODE = :stock AND TRXA_RACIK_ID = :racik_id AND TRXA_VIEW_STAT = 'Y'";
        $q = $db->prepare($sql);
        $q->execute([
            ':qty' => $stockqty,
            ':btch' => $stockbtch,
            ':pric' => $stockpric,
            ':user' => $userid,
            ':code' => $prsccode,
            ':stock' => $stockcode,
            ':racik_id' => $racik_id
        ]);
    }
    
    echo "OK";
    exit;
}

if ($action == 'del_detail') {
    $prsccode = $_POST['prsccode'] ?? '';
    $stockcode = $_POST['stockcode'] ?? '';
    $racik_id = (int)($_POST['racik_id'] ?? 0);
    
    if ($prsccode == '' || $stockcode == '' || $racik_id <= 0) {
        die("ERROR|Data hapus tidak lengkap");
    }
    
    $sql = "UPDATE trxaprsc SET TRXA_VIEW_STAT = 'N' WHERE TRXA_PRSC_CODE = :code AND TRXA_STOCK_CODE = :stock AND TRXA_RACIK_ID = :racik_id";
    $q = $db->prepare($sql);
    $q->execute([
        ':code' => $prsccode,
        ':stock' => $stockcode,
        ':racik_id' => $racik_id
    ]);
    
    echo "OK";
    exit;
}

if ($action == 'tmpl_detail') {
    $racik_id = (int)($_POST['racik_id'] ?? 0);
    
    if ($racik_id <= 0) {
        echo '<p style="color: #64748b; font-style: italic;">Pilih racikan terlebih dahulu.</p>';
        exit;
    }
    
    $sql = "SELECT p.*, 
            (SELECT INVE_PART_NAME FROM invemast WHERE INVE_MAST_CODE = p.TRXA_STOCK_CODE) AS STOCK_NAME,
            (SELECT INVE_SALE_UNIT FROM invemast WHERE INVE_MAST_CODE = p.TRXA_STOCK_CODE) AS UNIT_CODE,
            (SELECT TBLI_UNIT_NAME FROM tbliunit WHERE TBLI_UNIT_CODE = UNIT_CODE) AS UNIT_NAME
            FROM trxaprsc p 
            WHERE p.TRXA_RACIK_ID = :racik_id AND p.TRXA_VIEW_STAT = 'Y' 
            ORDER BY p.TRXA_STOCK_CODE";
    $q = $db->prepare($sql);
    $q->execute([':racik_id' => $racik_id]);
    
    echo '<style>
        .tbl-komposisi { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 5px; }
        .tbl-komposisi th { background: #f1f5f9; padding: 8px; border-bottom: 1px solid #cbd5e1; text-align: left; font-weight: bold; }
        .tbl-komposisi td { padding: 8px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .btn-komposisi-del { border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; cursor: pointer; font-weight: bold; background: #fee2e2; color: #b91c1c; }
        .btn-komposisi-del:hover { background: #fecaca; }
    </style>';
    
    echo '<table class="tbl-komposisi">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th style="width: 80px;">Qty</th>
                    <th style="width: 60px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';
    
    $count = 0;
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        echo '<tr>
                <td>' . htmlspecialchars($row['STOCK_NAME']) . '</td>
                <td>' . htmlspecialchars($row['TRXA_STOCK_QUTY']) . ' ' . htmlspecialchars($row['UNIT_NAME']) . '</td>
                <td style="text-align: center;">
                    <button type="button" class="btn-komposisi-del" onclick="hapusObatKomposisi(\'' . $row['TRXA_PRSC_CODE'] . '\', \'' . $row['TRXA_STOCK_CODE'] . '\')">Delete</button>
                </td>
              </tr>';
    }
    
    if ($count == 0) {
        echo '<tr><td colspan="3" style="text-align: center; color: #64748b; font-style: italic;">Belum ada obat dalam racikan ini. Silakan tambahkan.</td></tr>';
    }
    
    echo '</tbody></table>';
    exit;
}
?>


