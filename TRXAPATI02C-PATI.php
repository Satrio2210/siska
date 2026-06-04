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
    color: #43474d;
  }

  .patient-addr {
    font-size: 14px;
    color: #43474d;
  }

  .patient-birth {
    font-size: 14px;
    color: #43474d;
  }
</style>
<table id="screen">
  <tbody>
    <?php
    // 1. Ambil input pencarian
    $kata = $_POST['q'] ?? '';

    // 2. Base Query (Mencegah ngetik ulang)
    $xquery = "SELECT PATI_MAST_CODE, PATI_MAIN_PIDN, PATI_MAIN_NAME, PATI_MAIN_GEND, PATI_MAIN_BIRT, 
                  PATI_MAIN_BLOD, PATI_MAIN_ADDR, PATI_MAIN_PHNE, PATI_MAIN_PRNT 
           FROM patimast 
           WHERE PATI_VIEW_STAT = 'Y'";

    $params = [];

    // 3. Tambahkan kondisi LIKE jika panjang karakter lebih dari 1
    if (strlen($kata) > 1) {
      $xquery .= " AND (
                    PATI_MAIN_PIDN LIKE :kata_mid 
                    OR PATI_MAIN_NAME LIKE :kata_start 
                    OR PATI_MAIN_BIRT LIKE :kata_start 
                    OR PATI_MAIN_PRNT LIKE :kata_start
                 )";

      // Setup parameter untuk mencegah SQL Injection
      $params[':kata_mid'] = "%$kata%";
      $params[':kata_start'] = "$kata%";
    }

    // 4. Tambahkan pengurutan
    $xquery .= " ORDER BY PATI_MAST_CODE";

    // 5. Eksekusi pakai Prepared Statement
    $stmt = $db->prepare($xquery);
    $stmt->execute($params);

    // Kalau mau matiin script saat error (mirip 'or die' yang lu pake sebelumnya)
    if (!$stmt) {
      die("Gagal ambil data !!");
    }

    // 6. Looping data
    while ($k = $stmt->fetch(PDO::FETCH_ASSOC)) {
      // WAJIB: Pakai htmlspecialchars dengan ENT_QUOTES
      // Biar tanda kutip satu (') di nama/alamat nggak bikin Javascript error
      $outmastcode = htmlspecialchars($k['PATI_MAST_CODE'], ENT_QUOTES);
      $outmainname = htmlspecialchars($k['PATI_MAIN_NAME'], ENT_QUOTES);
      $outmaingend = htmlspecialchars($k['PATI_MAIN_GEND'], ENT_QUOTES);
      $outmainbirt = htmlspecialchars(formatTanggal($k['PATI_MAIN_BIRT']), ENT_QUOTES);
      $outmainblod = htmlspecialchars($k['PATI_MAIN_BLOD'], ENT_QUOTES);
      $outmainaddr = htmlspecialchars($k['PATI_MAIN_ADDR'], ENT_QUOTES);
      $outmainphne = htmlspecialchars($k['PATI_MAIN_PHNE'], ENT_QUOTES);

      // Variabel untuk ditampilin di HTML
      $disp_name = htmlspecialchars($k['PATI_MAIN_NAME']);
      $disp_birt = htmlspecialchars($k['PATI_MAIN_BIRT']);
      $disp_addr = htmlspecialchars($k['PATI_MAIN_ADDR']);

      // Cetak HTML pakai heredoc (<<<HTML) biar nggak pusing ngegabungin string pakai titik (.)
      echo <<<HTML
    <tr onclick="isipaticode(
        '$outmastcode', 
        '$outmainname', 
        '$outmaingend', 
        '$outmainbirt', 
        '$outmainblod', 
        '$outmainaddr', 
        '$outmainphne'
    )">
        <td>
            <div class="patient-name">
                $disp_name
            </div>
            <div class="patient-birth">
                $disp_birt
            </div>
            <div class="patient-addr">
                $disp_addr
            </div>
        </td>
    </tr>
    HTML;
    }
    ?>
  </tbody>
</table>