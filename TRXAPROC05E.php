<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include "conf/config.php";
include 'inc/sanie.php';

$rawinput = xss_clean($_POST['q']);
list($invccode,$invcdate,$proccode,$dueddate,$suplcode) = explode("|",$rawinput);

//$downpaid = str_replace(".","",$xdownpaid);
//$remapaid = '0';

$invcstat = 'U';
$viewstat = 'Y';

$userid = $_SESSION['username'];
$dateinput = date("Y-m-d");
$timeinput = date("H:i:s");

$periksaproccode = "SELECT COUNT(*) FROM trxainvc WHERE TRXA_PROC_CODE='$proccode' AND TRXA_INVC_STAT='U'";
$periksaproccode_di_query=$db->query($periksaproccode) or die ("Cek Fail");
$ketersediaan = $periksaproccode_di_query->fetchColumn();
//Cek adanya invoice yang di masukkan di database jika tidak ada dilanjutkan dengan membuat record kode invoice baru
if ($ketersediaan == 0)
   {

        $input_invoice = "INSERT INTO trxainvc (
        TRXA_INVC_CODE, TRXA_INVC_DATE, TRXA_PROC_CODE, 
        TRXA_DUED_DATE, TRXA_SUPL_CODE, TRXA_INVC_STAT, TRXA_VIEW_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (
        :TRXA_INVC_CODE, :TRXA_INVC_DATE, :TRXA_PROC_CODE, 
        :TRXA_DUED_DATE, :TRXA_SUPL_CODE, :TRXA_INVC_STAT, :TRXA_VIEW_STAT,          
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_invoice = $db->prepare($input_invoice);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_invoice->execute(array(
        ':TRXA_INVC_CODE' =>$invccode, ':TRXA_INVC_DATE' =>$invcdate, ':TRXA_PROC_CODE' =>$proccode,   
        ':TRXA_DUED_DATE' =>$dueddate, ':TRXA_SUPL_CODE' =>$suplcode, ':TRXA_INVC_STAT' =>$invcstat,
        ':TRXA_VIEW_STAT' =>$viewstat, 
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input_header);
        ///exit();
        $db->commit();

        // Input Auto Jurnal pembelian barang berdasarkan nomor PO
        // 1. jrnlcode
        // Generate Kode Transaksi Jurnal dengan kode TA = Transaction Auto       
        // Start Generate Kode Transaksi Jurnal  
        $sqllast = "SELECT TRXA_JRNL_CODE FROM trxajrnl                
                    ORDER by TRXA_ENTR_DATE DESC, TRXA_ENTR_TIME DESC 
                    LIMIT 1";
        $qcode = $db->query($sqllast) or die("Gagal Ambil Kode Transaksi terakhir!!");
        $rcode = $qcode->fetch(PDO::FETCH_ASSOC);

        $jrnlcode = $rcode['TRXA_JRNL_CODE'] = isset($rcode['TRXA_JRNL_CODE']) ? $rcode['TRXA_JRNL_CODE'] : '';
        // ambil 4 huruf dari kanan
        $xcode = substr($jrnlcode, -4);
        $int = (int)$xcode;
        $int++;

        $xjrnlcode = "TA-" . sprintf("%'.04d\n", $int);

        //if ($int >= 10)
        //{ $xjrnlcode = "TA-00" . $int;}

        //elseif ($int >= 100)
        //{ $xjrnlcode = "TA-0" . $int; }

        //elseif ($int >= 1000)
        //{ $xjrnlcode = "TA-" . $int;  }

        //else { $xjrnlcode = "TA-000" . $int;}
        // End Generate Kode Transaksi Jurnal         
        
        // 2. jrnldate = $invcdate
        // ambil TRXA_PROC_DIVI, TRXA_PROC_VATX, TRXA_DOWN_PAID 

        // jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote
        // Data primer input jurnal
        $query_jurnal = "SELECT TRXA_PROC_DIVI, (SELECT TBLE_DIVI_NAME FROM tbledivi WHERE TBLE_DIVI_CODE = TRXA_PROC_DIVI) AS DIVI_NAME, 
        TRXA_PROC_VATX, TRXA_DOWN_PAID 
        FROM trxaproc 
        WHERE TRXA_PROC_CODE = '$proccode' 
        AND TRXA_PROC_STAT = 'CL'";

        $q_jurnal = $db->query($query_jurnal) or die("Gagal ambil data Input Jurnal");
        $data_jurnal = $q_jurnal->fetch(PDO::FETCH_ASSOC);
        $divicode = $data_jurnal['TRXA_PROC_DIVI'];
        $diviname = $data_jurnal['DIVI_NAME'];
        $procvatx = $data_jurnal['TRXA_PROC_VATX'];
        $downpaid = $data_jurnal['TRXA_DOWN_PAID'];
        $jrnlstat = 'Y';
        $jrnlnote = $invccode . 'Invoice-Auto Jurnal Pembelian Barang';
        // Data Debet dan Credit input jurnal
        $query_amount = "SELECT SUM(ITEM_QUTY_RCVE * ITEM_PART_PRIC) AS AMOUNT  
        FROM itemproc 
        WHERE ITEM_PROC_CODE = '$proccode' AND ITEM_VIEW_STAT = 'N'";

        $q_amount = $db->query($query_amount) or die("Gagal ambil data Amount");
        $data_amount = $q_amount->fetch(PDO::FETCH_ASSOC);
        $debt_inventory = $data_amount['AMOUNT'];
        $crdt_inventory = 0;

        $input_inventory = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_inventory = $db->prepare($input_inventory);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_inventory->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$invcdate,  
        ':TRXA_COAC_CODE' =>$code_inventory, ':TRXA_COAC_NAME' =>$name_inventory,                  
        ':TRXA_JRNL_DEBT' =>$debt_inventory, ':TRXA_JRNL_CRDT' =>$crdt_inventory,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // ambil status pajak = TRXA_PROC_VATX         

            if ($procvatx == 'E') 
                { 
                    $taxbase = $debt_inventory;
                    $debt_vat = (($taxbase * 10)/100);
                    $crdt_vat = 0; 
                }
            else if ($procvatx == 'I') 
                { 
                    $taxbase = ($debt_inventory * (100/110));
                    $debt_vat = (($taxbase * 10)/100);
                    $crdt_vat = 0; 
                }
            else 
                { 
                    $taxbase = $debt_inventory;
                    $debt_vat = 0;
                    $crdt_vat = 0; 
                }
        // Data PPN Input Jurnal

        $input_vat_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_vat_in = $db->prepare($input_vat_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_vat_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$invcdate,  
        ':TRXA_COAC_CODE' =>$code_vat_in, ':TRXA_COAC_NAME' =>$name_vat_in,                  
        ':TRXA_JRNL_DEBT' =>$debt_vat, ':TRXA_JRNL_CRDT' =>$crdt_vat,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        if ($downpaid > 0)
        {

        // Data input Jurnal Hutang usaha
        $debt_payable = 0;
        $crdt_payable = (($debt_inventory + $debt_vat) - $downpaid);

        $input_account_payable = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_account_payable = $db->prepare($input_account_payable);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_account_payable->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$invcdate,  
        ':TRXA_COAC_CODE' =>$code_account_payable, ':TRXA_COAC_NAME' =>$name_account_payable,                  
        ':TRXA_JRNL_DEBT' =>$debt_payable, ':TRXA_JRNL_CRDT' =>$crdt_payable,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        // Data Input Jurnal Down Payment
        $debt_cash = 0;
        $crdt_cash = $downpaid;

        $input_cash = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_cash = $db->prepare($input_cash);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cash->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$invcdate,  
        ':TRXA_COAC_CODE' =>$code_cash, ':TRXA_COAC_NAME' =>$name_cash,                  
        ':TRXA_JRNL_DEBT' =>$debt_cash, ':TRXA_JRNL_CRDT' =>$crdt_cash,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();


        }
        else
        {
        // Data input Jurnal Hutang usaha
        $debt_payable = 0;
        $crdt_payable = ($debt_inventory + $debt_vat);

        $input_account_payable = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
        TRXA_COAC_CODE, TRXA_COAC_NAME, TRXA_JRNL_DEBT, TRXA_JRNL_CRDT,           
        TRXA_DIVI_CODE, TRXA_DIVI_NAME, TRXA_JRNL_NOTE, TRXA_JRNL_STAT,
        TRXA_ENTR_DATE, TRXA_ENTR_TIME, TRXA_ENTR_USER,  
        TRXA_UPDT_DATE, TRXA_UPDT_TIME, TRXA_UPDT_USER) 
        VALUES (:TRXA_JRNL_CODE, :TRXA_JRNL_DATE, 
        :TRXA_COAC_CODE, :TRXA_COAC_NAME, :TRXA_JRNL_DEBT, :TRXA_JRNL_CRDT,          
        :TRXA_DIVI_CODE, :TRXA_DIVI_NAME, :TRXA_JRNL_NOTE, :TRXA_JRNL_STAT,
        :TRXA_ENTR_DATE, :TRXA_ENTR_TIME, :TRXA_ENTR_USER,  
        :TRXA_UPDT_DATE, :TRXA_UPDT_TIME, :TRXA_UPDT_USER)";
        // Prepare Request  
        $query_input_account_payable = $db->prepare($input_account_payable);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_account_payable->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$invcdate,  
        ':TRXA_COAC_CODE' =>$code_account_payable, ':TRXA_COAC_NAME' =>$name_account_payable,                  
        ':TRXA_JRNL_DEBT' =>$debt_payable, ':TRXA_JRNL_CRDT' =>$crdt_payable,  
        ':TRXA_DIVI_CODE' =>$divicode, ':TRXA_DIVI_NAME' =>$diviname, ':TRXA_JRNL_NOTE' =>$jrnlnote,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();

        }


   }
   else
   {
        $update = "UPDATE trxainvc SET TRXA_INVC_CODE='$invccode', TRXA_INVC_DATE='$invcdate', 
                    TRXA_DUED_DATE='$dueddate',
                    TRXA_SUPL_CODE='$suplcode',
                    TRXA_INVC_STAT='$invcstat',
                    TRXA_VIEW_STAT='$viewstat',
                    TRXA_UPDT_DATE='$dateinput',
                    TRXA_UPDT_TIME='$timeinput',
                    TRXA_UPDT_USER='$userid'    
            WHERE TRXA_PROC_CODE='$proccode'";
                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();

   }
?>      
