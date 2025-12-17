<?php
include "conf/config.php";
session_start();

// Sementara buat debug, bisa dimatiin kalau udah beres
error_reporting(E_ALL);
ini_set('display_errors', 1);

// require_once __DIR__ . 'conf/config.php'; // sesuaikan nama file koneksi lo

// cek koneksi PDO
if (!isset($db) || !($db instanceof PDO)) {
  // kalau dipanggil via ajax, balikin JSON
  if (isset($_GET['ajax'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
      'success' => false,
      'message' => 'Koneksi database (PDO $db) tidak tersedia'
    ]);
    exit;
  }
}

// contoh ambil user login
$currentUser = isset($_SESSION['username']) ? $_SESSION['username'] : 'UPDT';

if (isset($_GET['ajax'])) {
  header('Content-Type: application/json; charset=utf-8');

  if (!($db instanceof PDO)) {
    echo json_encode([
      'success' => false,
      'message' => 'Koneksi database belum siap'
    ]);
    exit;
  }

  $action = $_GET['ajax'];

  // =======================
  // 1) SEARCH NAMA OBAT
  // =======================
  if ($action === 'search') {
    $term = isset($_GET['term']) ? trim($_GET['term']) : '';
    $resultData = [];

    if ($term !== '') {
      try {
        $sql = "
                    SELECT 
                        INVE_STOCK_CODE,
                        INVE_STOCK_BTCH,
                        INVE_STOCK_SRNM,
                        INVE_STOCK_NAME,
                        INVE_WARE_CODE,
                        INVE_STOCK_QUTY,
                        INVE_VIEW_STAT,
                        INVE_STOCK_PRIC,
                        INVE_EXPR_DATE
                    FROM investock
                    WHERE INVE_STOCK_NAME LIKE :term 
                    AND INVE_WARE_CODE = 'BOX1' 
                    AND INVE_VIEW_STAT = 'Y' 
                    ORDER BY INVE_STOCK_NAME ASC, INVE_STOCK_BTCH ASC
                    LIMIT 50
                ";
        $stmt = $db->prepare($sql);
        $like = '%' . $term . '%';
        $stmt->bindParam(':term', $like, PDO::PARAM_STR);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        echo json_encode([
          'success' => false,
          'message' => 'Query search error: ' . $e->getMessage()
        ]);
        exit;
      }
    }

    echo json_encode([
      'success' => true,
      'data' => $resultData
    ]);
    exit;
  }

  // =======================
  // 2) DETAIL OBAT
  // =======================
  if ($action === 'detail') {
    $code = isset($_GET['code']) ? trim($_GET['code']) : '';
    $btch = isset($_GET['btch']) ? trim($_GET['btch']) : '';
    $ware = isset($_GET['ware']) ? trim($_GET['ware']) : '';

    if ($code === '' || $btch === '') {
      echo json_encode(['success' => false, 'message' => 'Kode / batch tidak lengkap']);
      exit;
    }

    try {
      $sql = "
                SELECT *
                FROM investock
                WHERE INVE_STOCK_CODE = :code
                  AND INVE_STOCK_BTCH = :btch
                  " . ($ware !== '' ? "AND INVE_WARE_CODE = :ware" : "") . "
                  AND INVE_VIEW_STAT = 'Y'
                LIMIT 1
            ";
      $stmt = $db->prepare($sql);
      $params = [
        ':code' => $code,
        ':btch' => $btch,
      ];
      if ($ware !== '') {
        $params[':ware'] = $ware;
      }

      $stmt->execute($params);

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo json_encode([
        'success' => false,
        'message' => 'Query detail error: ' . $e->getMessage()
      ]);
      exit;
    }

    if (!$row) {
      echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
      exit;
    }

    echo json_encode([
      'success' => true,
      'data' => $row
    ]);
    exit;
  }

  // =======================
  // 3) UPDATE STOK & HARGA
  // =======================
  if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = isset($_POST['code']) ? trim($_POST['code']) : '';
    $btch = isset($_POST['btch']) ? trim($_POST['btch']) : '';
    $ware = isset($_POST['ware']) ? trim($_POST['ware']) : '';

    $newQty = isset($_POST['new_qty']) ? trim($_POST['new_qty']) : '';
    $newPrice = isset($_POST['new_price']) ? trim($_POST['new_price']) : '';

    if ($code === '' || $btch === '') {
      echo json_encode(['success' => false, 'message' => 'Kode / batch tidak lengkap']);
      exit;
    }

    if ($newQty === '' && $newPrice === '') {
      echo json_encode(['success' => false, 'message' => 'Isi minimal salah satu: stok atau harga']);
      exit;
    }

    try {
      // ambil data lama
      $sql = "
                SELECT INVE_STOCK_QUTY, INVE_STOCK_PRIC
                FROM investock
                WHERE INVE_STOCK_CODE = :code
                  AND INVE_STOCK_BTCH = :btch
                  " . ($ware !== '' ? "AND INVE_WARE_CODE = :ware" : "") . "
                LIMIT 1
            ";
      $stmt = $db->prepare($sql);
      $params = [
        ':code' => $code,
        ':btch' => $btch,
      ];
      if ($ware !== '') {
        $params[':ware'] = $ware;
      }
      $stmt->execute($params);

      $old = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$old) {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        exit;
      }

      $qtyToSave = ($newQty === '' ? $old['INVE_STOCK_QUTY'] : (int) $newQty);
      $priceToSave = ($newPrice === '' ? $old['INVE_STOCK_PRIC'] : (float) $newPrice);

      $sqlUpdate = "
                UPDATE investock
                SET 
                    INVE_STOCK_QUTY = :qty,
                    INVE_STOCK_PRIC = :price,
                    INVE_UPDT_DATE  = CURDATE(),
                    INVE_UPDT_TIME  = CURTIME(),
                    INVE_UPDT_USER  = :user
                WHERE INVE_STOCK_CODE = :code
                  AND INVE_STOCK_BTCH = :btch
                  " . ($ware !== '' ? "AND INVE_WARE_CODE = :ware" : "") . "
            ";
      $stmt = $db->prepare($sqlUpdate);
      $paramsUpdate = [
        ':qty' => $qtyToSave,
        ':price' => $priceToSave,
        ':user' => $currentUser,
        ':code' => $code,
        ':btch' => $btch,
      ];
      if ($ware !== '') {
        $paramsUpdate[':ware'] = $ware;
      }
      $ok = $stmt->execute($paramsUpdate);
    } catch (PDOException $e) {
      echo json_encode([
        'success' => false,
        'message' => 'Query update error: ' . $e->getMessage()
      ]);
      exit;
    }

    if (!$ok) {
      echo json_encode(['success' => false, 'message' => 'Gagal update data']);
      exit;
    }

    echo json_encode([
      'success' => true,
      'message' => 'Data berhasil diupdate',
      'data' => [
        'INVE_STOCK_QUTY' => $qtyToSave,
        'INVE_STOCK_PRIC' => $priceToSave
      ]
    ]);
    exit;
  }

  // kalau action ga dikenali
  echo json_encode(['success' => false, 'message' => 'Invalid action']);
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Update Harga & Stok Obat</title>
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-soft: #e0edff;
      --bg: #f3f4f6;
      --card-bg: #ffffff;
      --border: #e5e7eb;
      --text-main: #111827;
      --text-muted: #6b7280;
      --danger: #dc2626;
      --success: #16a34a;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 24px 16px;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      font-size: 14px;
      background-color: var(--bg);
      color: var(--text-main);
    }

    .page {
      max-width: 1120px;
      margin: 0 auto;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
    }

    .page-title {
      font-size: 20px;
      font-weight: 600;
      letter-spacing: 0.02em;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .page-title-badge {
      font-size: 11px;
      padding: 2px 8px;
      border-radius: 999px;
      background-color: var(--primary-soft);
      color: var(--primary-dark);
      text-transform: uppercase;
      font-weight: 600;
    }

    .page-subtitle {
      font-size: 12px;
      color: var(--text-muted);
      margin-top: 2px;
    }

    .card {
      background-color: var(--card-bg);
      border-radius: 12px;
      border: 1px solid var(--border);
      box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
      padding: 14px 16px;
    }

    .card+.card {
      margin-top: 12px;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .card-title {
      font-size: 14px;
      font-weight: 600;
    }

    .card-subtitle {
      font-size: 11px;
      color: var(--text-muted);
    }

    .search-box label {
      font-size: 12px;
      font-weight: 500;
      margin-bottom: 4px;
      display: block;
    }

    .search-input-wrapper {
      position: relative;
    }

    .search-input-wrapper::before {
      content: "🔍";
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 14px;
      opacity: 0.75;
    }

    .search-box input[type="text"] {
      width: 100%;
      padding: 8px 10px 8px 30px;
      font-size: 13px;
      border-radius: 999px;
      border: 1px solid var(--border);
      outline: none;
      background-color: #f9fafb;
      transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
    }

    .search-box input[type="text"]:focus {
      border-color: var(--primary);
      background-color: #ffffff;
      box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.3);
    }

    .muted {
      color: var(--text-muted);
      font-size: 11px;
      margin-top: 4px;
    }

    .results-box {
      margin-top: 8px;
      border-radius: 10px;
      border: 1px dashed var(--border);
      background-color: #f9fafb;
      max-height: 240px;
      overflow-y: auto;
    }

    .result-row {
      padding: 8px 10px;
      border-bottom: 1px solid #e5e7eb;
      cursor: pointer;
      transition: background-color 0.12s, transform 0.05s;
    }

    .result-row:last-child {
      border-bottom: none;
    }

    .result-row:hover {
      background-color: #eef2ff;
      transform: translateY(-1px);
    }

    .result-main {
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 2px;
    }

    .result-sub {
      font-size: 11px;
      color: var(--text-muted);
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }

    .pill {
      padding: 1px 6px;
      border-radius: 999px;
      background-color: #e5e7eb;
      font-size: 10px;
    }

    .pill-primary {
      background-color: var(--primary-soft);
      color: var(--primary-dark);
    }

    .pill-success {
      background-color: #dcfce7;
      color: #166534;
    }

    .pill-danger {
      background-color: #fee2e2;
      color: #b91c1c;
    }

    .layout-two {
      display: grid;
      grid-template-columns: minmax(0, 2fr) minmax(0, 1.3fr);
      gap: 12px;
      margin-top: 12px;
    }

    @media (max-width: 840px) {
      .layout-two {
        grid-template-columns: minmax(0, 1fr);
      }
    }

    .detail-grid {
      display: grid;
      grid-template-columns: 130px minmax(0, 1fr);
      row-gap: 4px;
      column-gap: 6px;
      font-size: 12px;
    }

    .detail-label {
      font-weight: 500;
      color: var(--text-muted);
    }

    .detail-value {
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .form-group label {
      display: block;
      margin-bottom: 4px;
      font-size: 12px;
      font-weight: 500;
    }

    .form-group input[type="number"] {
      width: 100%;
      padding: 7px 9px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background-color: #f9fafb;
      font-size: 13px;
      outline: none;
      transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
    }

    .form-group input[type="number"]:focus {
      border-color: var(--primary);
      background-color: #ffffff;
      box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.3);
    }

    .btn {
      padding: 7px 12px;
      font-size: 13px;
      cursor: pointer;
      border-radius: 999px;
      border: none;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      white-space: nowrap;
      transition: background-color 0.15s, box-shadow 0.15s, transform 0.05s;
    }

    .btn-primary {
      background-color: var(--primary);
      color: #ffffff;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.28);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      box-shadow: 0 8px 22px rgba(37, 99, 235, 0.35);
      transform: translateY(-0.5px);
    }

    .btn-lock {
      background-color: #e5e7eb;
      color: #374151;
      font-size: 11px;
      padding: 6px 9px;
      border-radius: 999px;
      border: 1px solid #d1d5db;
    }

    .btn-lock:hover {
      background-color: #d1d5db;
    }

    .btn-icon {
      font-size: 14px;
    }

    .price-wrapper {
      display: flex;
      gap: 6px;
      align-items: center;
    }

    .status {
      margin-top: 8px;
      font-size: 12px;
    }

    .status.ok {
      color: var(--success);
    }

    .status.err {
      color: var(--danger);
    }

    .info {
      font-size: 11px;
      color: var(--text-muted);
    }

    .info ul {
      padding-left: 18px;
      margin: 4px 0 0;
    }

    .info li {
      margin: 2px 0;
    }
  </style>
</head>

<body>
  <div class="page">
    <header class="page-header">
      <div>
        <div class="page-title">
          Update Harga & Stok Obat
          <span class="page-title-badge">Pharmacy Tools</span>
        </div>
        <div class="page-subtitle">
          Cari obat, lihat detail per batch, lalu update stok & harga dengan lebih aman.
        </div>
      </div>
    </header>

    <!-- SEARCH + RESULT -->
    <section class="card">
      <div class="card-header">
        <div>
          <div class="card-title">Pencarian Obat</div>
          <div class="card-subtitle">Ketik minimal 2 huruf untuk menampilkan daftar obat.</div>
        </div>
      </div>

      <div class="search-box">
        <label for="searchInput">Cari nama obat</label>
        <div class="search-input-wrapper">
          <input type="text" id="searchInput" placeholder="Contoh: parasetamol, amoxicillin, dll">
        </div>
        <div class="muted">
          Hasil akan muncul di kotak di bawah ini. Klik salah satu baris untuk memilih batch yang ingin di-update.
        </div>
      </div>

      <div id="resultsBox" class="results-box">
        <!-- Hasil pencarian via JS -->
      </div>
    </section>

    <!-- DETAIL + UPDATE -->
    <section class="layout-two">
      <!-- DETAIL OBAT -->
      <section class="card">
        <div class="card-header">
          <div class="card-title">Detail Obat</div>
          <div class="card-subtitle">Informasi lengkap obat & batch yang dipilih.</div>
        </div>

        <div id="detailContent">
          <div class="muted">Belum ada obat yang dipilih. Cari dan pilih salah satu dari daftar di atas.</div>
        </div>
      </section>

      <!-- UPDATE FORM -->
      <section class="card">
        <div class="card-header">
          <div class="card-title">Update Harga & Stok</div>
          <div class="card-subtitle">Perbarui hanya data yang memang perlu diubah.</div>
        </div>

        <form id="updateForm">
          <input type="hidden" id="selectedCode" name="code">
          <input type="hidden" id="selectedBtch" name="btch">
          <input type="hidden" id="selectedWare" name="ware">

          <div class="form-group">
            <label for="newQty">Update Stok (QTY)</label>
            <input type="number" id="newQty" name="new_qty" step="1" min="0"
              placeholder="Kosongkan jika tidak ingin mengubah stok">
          </div>

          <div class="form-group">
            <label for="newPrice">Update Harga (Rp)</label>
            <div class="price-wrapper">
              <input type="number" id="newPrice" name="new_price" step="0.01" min="0"
                placeholder="Kolom harga dikunci, buka jika ingin mengubah" disabled>
              <button type="button" class="btn btn-lock" id="togglePriceLock">
                <span class="btn-icon">🔒</span> <span> Buka Harga</span>
              </button>
            </div>
            <div class="muted" id="priceLockInfo">
              Kolom harga saat ini terkunci. Klik "Buka Harga" dan masukkan password untuk mengaktifkan.
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <span class="btn-icon">💾</span>
            <span>Simpan Perubahan</span>
          </button>

          <div class="status" id="statusMsg"></div>
        </form>

        <div class="info">
          <ul>
            <li>Minimal salah satu diisi (stok atau harga).</li>
            <li>Perubahan berdasarkan kombinasi <strong>INVE_STOCK_CODE + INVE_STOCK_BTCH (+ INVE_WARE_CODE)</strong>.
            </li>
            <li>Kolom harga hanya bisa dibuka dengan password khusus.</li>
          </ul>
        </div>
      </section>
    </section>
  </div>

  <script>
    (function () {
      const searchInput = document.getElementById('searchInput');
      const resultsBox = document.getElementById('resultsBox');
      const detailBox = document.getElementById('detailContent');
      const updateForm = document.getElementById('updateForm');
      const statusMsg = document.getElementById('statusMsg');
      const selectedCode = document.getElementById('selectedCode');
      const selectedBtch = document.getElementById('selectedBtch');
      const newQty = document.getElementById('newQty');
      const newPrice = document.getElementById('newPrice');
      const selectedWare = document.getElementById('selectedWare');

      const togglePriceLock = document.getElementById('togglePriceLock');
      const priceLockInfo = document.getElementById('priceLockInfo');

      const PRICE_PASSWORD = 'adminharga'; // GANTI ke password yang lo mau
      let priceLocked = true;


      let searchTimer = null;

      function formatNumber(num) {
        if (num === null || num === undefined || num === '') return '-';
        const n = Number(num);
        if (isNaN(n)) return num;
        return n.toLocaleString('id-ID');
      }

      function formatDate(dateStr) {
        if (!dateStr) return '-';
        return dateStr; // yyyy-mm-dd dari MySQL, biarin apa adanya
      }

      function clearDetail() {
        detailBox.innerHTML = '<div class="muted">Belum ada obat yang dipilih.</div>';
        selectedCode.value = '';
        selectedBtch.value = '';
        newQty.value = '';
        newPrice.value = '';
      }

      function renderResults(data) {
        if (!data || data.length === 0) {
          resultsBox.innerHTML = '<div class="muted" style="padding:6px 8px;">Tidak ada data ditemukan.</div>';
          return;
        }

        let html = '';
        data.forEach(function (row) {
          const title = row.INVE_STOCK_NAME || '';
          const kode = row.INVE_STOCK_CODE || '';
          const btch = row.INVE_STOCK_BTCH || '';
          const srnm = row.INVE_STOCK_SRNM || '';
          const qty = formatNumber(row.INVE_STOCK_QUTY);
          const pric = formatNumber(row.INVE_STOCK_PRIC);
          const exp = formatDate(row.INVE_EXPR_DATE);
          const ware = row.INVE_WARE_CODE || '';
          const view = row.INVE_VIEW_STAT || '';

          html += `
                <div class="result-row" data-code="${kode}" data-btch="${btch}" data-ware="${ware}">
                    <div class="result-main">${title}</div>
                    <div class="result-sub">
                        Kode: ${kode} | Batch: ${btch} | Serial: ${srnm} | Stok: ${qty} | Harga: Rp ${pric} | Exp: ${exp} | Box: ${ware} | View: ${view}
                    </div>
                </div>
            `;
        });

        resultsBox.innerHTML = html;

        // Pasang event klik
        document.querySelectorAll('.result-row').forEach(function (el) {
          el.addEventListener('click', function () {
            const code = this.getAttribute('data-code');
            const btch = this.getAttribute('data-btch');
            const ware = this.getAttribute('data-ware');
            loadDetail(code, btch, ware);
          });
        });
      }

      function loadDetail(code, btch) {
        if (!code || !btch) return;

        statusMsg.textContent = '';
        statusMsg.className = 'status';

        fetch(`INVEUP00.php?ajax=detail&code=${encodeURIComponent(code)}&btch=${encodeURIComponent(btch)}`)
          .then(response => response.json())
          .then(json => {
            if (!json.success) {
              detailBox.innerHTML = `<div class="status err">${json.message || 'Gagal ambil data.'}</div>`;
              return;
            }

            const d = json.data;

            console.log('DETAIL RAW:', d);

            selectedCode.value = d.INVE_STOCK_CODE || '';
            selectedBtch.value = d.INVE_STOCK_BTCH || '';
            selectedWare.value = d.INVE_WARE_CODE || '';
            newQty.value = '';
            newPrice.value = '';

            setPriceLockState(true); // setiap pilih obat baru, harga dikunci lagi

            const html = `
                    <div class="detail-row">
                        <span class="detail-label">Nama Obat</span>
                        <span class="detail-value">${d.INVE_STOCK_NAME || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kode</span>
                        <span class="detail-value">${d.INVE_STOCK_CODE || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Batch</span>
                        <span class="detail-value">${d.INVE_STOCK_BTCH || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Serial</span>
                        <span class="detail-value">${d.INVE_STOCK_SRNM || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Stok Saat Ini</span>
                        <span class="detail-value">${d.INVE_STOCK_QUTY ?? ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Harga Saat Ini</span>
                        <span class="detail-value">Rp ${formatNumber(d.INVE_STOCK_PRIC)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Exp Date</span>
                        <span class="detail-value">${formatDate(d.INVE_EXPR_DATE)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Input Tgl/Jam</span>
                        <span class="detail-value">${formatDate(d.INVE_ENTR_DATE)} ${d.INVE_ENTR_TIME || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Update Terakhir</span>
                        <span class="detail-value">${formatDate(d.INVE_UPDT_DATE)} ${d.INVE_UPDT_TIME || ''} (${d.INVE_UPDT_USER || '-'})</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">INVE_VIEW_STAT</span>
                        <span class="detail-value">${d.INVE_VIEW_STAT || ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">BOX</span>
                        <span class="detail-value">${d.INVE_WARE_CODE || ''}</span>
                    </div>
                `;

            detailBox.innerHTML = html;
          })
          .catch(err => {
            console.error(err);
            detailBox.innerHTML = '<div class="status err">Error mengambil detail data.</div>';
          });
      }

      function doSearch() {
        const term = searchInput.value.trim();
        if (term.length < 2) {
          resultsBox.innerHTML = '<div class="muted" style="padding:6px 8px;">Ketik minimal 2 huruf untuk mencari.</div>';
          return;
        }

        resultsBox.innerHTML = '<div class="muted" style="padding:6px 8px;">Mencari...</div>';

        fetch(`INVEUP00.php?ajax=search&term=${encodeURIComponent(term)}`)
          .then(response => response.json())
          .then(json => {
            if (!json.success) {
              resultsBox.innerHTML = `<div class="muted" style="padding:6px 8px;">${json.message || 'Gagal mencari data.'}</div>`;
              return;
            }
            renderResults(json.data || []);
          })
          .catch(err => {
            console.error(err);
            resultsBox.innerHTML = '<div class="muted" style="padding:6px 8px;">Error koneksi saat mencari.</div>';
          });
      }

      function setPriceLockState(lock) {
        priceLocked = lock;
        newPrice.disabled = lock;

        if (lock) {
          togglePriceLock.textContent = 'Buka Harga';
          priceLockInfo.textContent = 'Kolom harga terkunci. Klik "Buka Harga" dan masukkan password untuk mengubah.';
        } else {
          togglePriceLock.textContent = 'Kunci Harga';
          priceLockInfo.textContent = 'Kolom harga sedang terbuka. Pastikan perubahan harga sudah benar sebelum simpan.';
        }
      }

      togglePriceLock.addEventListener('click', function () {
        if (priceLocked) {
          const pwd = prompt('Masukkan password untuk mengubah harga:');
          if (pwd === null) {
            return; // user cancel
          }
          if (pwd === PRICE_PASSWORD) {
            setPriceLockState(false);
            newPrice.focus();
          } else {
            alert('Password salah. Harga tetap terkunci.');
          }
        } else {
          // kunci lagi
          setPriceLockState(true);
          newPrice.value = ''; // optional: kosongkan kalau dikunci lagi
        }
      });


      searchInput.addEventListener('keyup', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(doSearch, 300); // debounce 300ms
      });

      updateForm.addEventListener('submit', function (e) {
        e.preventDefault();

        statusMsg.textContent = '';
        statusMsg.className = 'status';

        const code = selectedCode.value;
        const btch = selectedBtch.value;

        if (!code || !btch) {
          statusMsg.textContent = 'Pilih dulu obat yang mau di-update.';
          statusMsg.classList.add('err');
          return;
        }

        const formData = new FormData(updateForm);

        fetch('INVEUP00.php?ajax=update', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(json => {
            if (!json.success) {
              statusMsg.textContent = json.message || 'Gagal menyimpan perubahan.';
              statusMsg.classList.add('err');
              return;
            }

            statusMsg.textContent = json.message || 'Berhasil update.';
            statusMsg.classList.add('ok');

            // Setelah update, refresh detail biar stok/harga baru ke-refresh
            loadDetail(code, btch);
          })
          .catch(err => {
            console.error(err);
            statusMsg.textContent = 'Error koneksi saat menyimpan.';
            statusMsg.classList.add('err');
          });
      });

      // Awal: info default
      clearDetail();
      resultsBox.innerHTML = '<div class="muted" style="padding:6px 8px;">Ketik nama obat untuk mulai mencari.</div>';
    })();
  </script>
</body>

</html>