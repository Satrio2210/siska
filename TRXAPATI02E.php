<?php
session_start();
include "conf/config.php";

$rawdata = $_POST['q'];
//$rawdata ='1187-00001|2021-08-11|A|U|DTIAR|PU|Y';
//q=1092-0003||A|U|DTIAR|PU|Y

list($paticode, $regidate, $regifrom, $regipaym, $regidoct, $regipoli, $regifee) = explode("|", $rawdata);

// Mapping kode poli ke prefix antrian
// Silakan sesuaikan kode polinya kalau beda:
$prefixMap = [
        'PU' => 'A', // Poli Umum
        'PG' => 'B', // Poli Gigi
        'KB' => 'C', // Poli KIA
        'LB' => 'D', // Laboratorium
];

// Default kalau poli nggak ketemu di mapping
$prefix = isset($prefixMap[$regipoli]) ? $prefixMap[$regipoli] : 'Z';
// End Mapping kode poli ke prefix antrian

$registat = 'W';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksatrxaregi = "SELECT COUNT(*) FROM trxaregi WHERE TRXA_PATI_CODE='$paticode' 
                    AND TRXA_REGI_DATE='$regidate' 
                    AND TRXA_REGI_DOCT='$regidoct'
                    AND TRXA_REGI_STAT IN ('W','C','P')";

$periksatrxaregi_di_query = $db->query($periksatrxaregi) or die("Cek Fail");
$ketersediaan = $periksatrxaregi_di_query->fetchColumn();

if ($ketersediaan == 0) {

        // Start Generate Kode Urut  
        $sqllast = "SELECT TRXA_REGI_CODE FROM trxaregi               
            ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
            LIMIT 1";
        $q = $db->query($sqllast) or die("Gagal Ambil Kode Pendaftaran terakhir!!");
        $r = $q->fetch(PDO::FETCH_ASSOC);

        $sequcode = $r['TRXA_REGI_CODE'] = isset($r['TRXA_REGI_CODE']) ? $r['TRXA_REGI_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($sequcode, -5);
        $int = (int) $xcode;
        $int++;

        $xsequcode = "-" . sprintf("%'.05d\n", $int);

        $regicode = $daynow . '' . $monthnow . '' . $yearnow . '' . $xsequcode;
        // End Generate Kode Pendaftaran         


        // // Start Generate Kode Antrian  
// $querylistxxx = "SELECT TRXA_REGI_LIST FROM trxaregi
//             WHERE TRXA_REGI_DATE = '$regidate'               
//             ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
//             LIMIT 1";

        // $querylist = "SELECT COUNT(*) AS REGI_LIST FROM trxaregi WHERE TRXA_REGI_DATE = '$datenow'";

        // $qlist = $db->query($querylist) or die("Gagal Ambil Nomor Antrian  terakhir!!");
// $rlist = $qlist->fetch(PDO::FETCH_ASSOC);

        // //$listcode = $rlist['TRXA_REGI_LIST'] = isset($rlist['TRXA_REGI_LIST']) ? $rlist['TRXA_REGI_LIST'] : '';
// $listcode = $rlist['REGI_LIST'] = isset($rlist['REGI_LIST']) ? $rlist['REGI_LIST'] : '';
// // ambil 3 huruf dari kanan
// $xcodel = substr($listcode, -3);
// $intl = (int)$xcodel;
// $intl++;

        // $xlistcode = sprintf("%'.03d\n", $intl);

        // $regilist = $xlistcode;
// // End Generate Kode Antrian


        // START GENERATE NOMOR ANTRIAN BARU
// Nomor antrian di-reset per TANGGAL + per POLI

        $sqlNo = "
    SELECT MAX(CAST(TRXA_REGI_LIST AS UNSIGNED)) AS last_no
    FROM trxaregi
    WHERE TRXA_REGI_DATE = :tgl
      AND TRXA_REGI_POLI = :poli
";

        $stmtNo = $db->prepare($sqlNo);
        $stmtNo->execute([
                ':tgl' => $regidate,
                ':poli' => $regipoli,
        ]);

        $rowNo = $stmtNo->fetch(PDO::FETCH_ASSOC);
        $lastNo = !empty($rowNo['last_no']) ? (int) $rowNo['last_no'] : 0;
        $nextNo = $lastNo + 1;

        // Simpan ke DB hanya 3 digit angka (001, 002, dst)
        $regilist = str_pad($nextNo, 3, '0', STR_PAD_LEFT);

        // Nomor antrian lengkap buat tampilan: A001, B001, dst
        $noantri_full = $prefix . $regilist;
        // End GENERATE NOMOR ANTRIAN BARU

        $input = "INSERT INTO trxaregi (
        TRXA_REGI_CODE, TRXA_PATI_CODE, TRXA_REGI_DATE,
        TRXA_REGI_LIST, TRXA_REGI_FROM, TRXA_REGI_PAYM,
        TRXA_REGI_DOCT, TRXA_REGI_POLI, TRXA_REGI_FEE,
        TRXA_REGI_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_REGI_CODE, :TRXA_PATI_CODE, :TRXA_REGI_DATE,
        :TRXA_REGI_LIST, :TRXA_REGI_FROM, :TRXA_REGI_PAYM,
        :TRXA_REGI_DOCT, :TRXA_REGI_POLI, :TRXA_REGI_FEE,
        :TRXA_REGI_STAT, :TRXA_VIEW_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";

        // Prepare Request  
        $query_input = $db->prepare($input);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input->execute(array(
                ':TRXA_REGI_CODE' => $regicode,
                ':TRXA_PATI_CODE' => $paticode,
                ':TRXA_REGI_DATE' => $regidate,
                ':TRXA_REGI_LIST' => $regilist,
                ':TRXA_REGI_FROM' => $regifrom,
                ':TRXA_REGI_PAYM' => $regipaym,
                ':TRXA_REGI_DOCT' => $regidoct,
                ':TRXA_REGI_POLI' => $regipoli,
                ':TRXA_REGI_FEE' => $regifee,
                ':TRXA_REGI_STAT' => $registat,
                ':TRXA_VIEW_STAT' => $viewstat,
                ':TRXA_ENTR_DATE' => $dateinput,
                ':TRXA_ENTR_TIME' => $timeinput,
                ':TRXA_ENTR_USER' => $userid,
                ':TRXA_UPDT_DATE' => $dateinput,
                ':TRXA_UPDT_TIME' => $timeinput,
                ':TRXA_UPDT_USER' => $userid
        ));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
        echo $noantri_full;
} else {
        $update = "UPDATE trxaregi SET TRXA_REGI_FROM='$regifrom',
                    TRXA_REGI_PAYM='$regipaym',
                    TRXA_REGI_DOCT='$regidoct',
                    TRXA_REGI_POLI='$regipoli',
                    TRXA_REGI_FEE='$regifee',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_PATI_CODE='$paticode' AND TRXA_REGI_DATE='$regidate' AND TRXA_REGI_DOCT='$regidoct'";
        // Prepare Request  
        $query_update = $db->prepare($update);

        // Mulai Input
        $db->beginTransaction();
        $query_update->execute();
        $db->commit();
}

?>