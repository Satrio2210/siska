<?php
    //Ambil Total Fee Klinik dan Fee Dokter
      // Input ke Biaya Jasa Admin Lain lain
        $cost_other_in_note = ''.$id_admisi.' - ' .$name_admisi. 'Bayar Kwitansi nomor '.$regicode.''; 
        $input_cost_other_in = "INSERT INTO trxajrnl (TRXA_JRNL_CODE, TRXA_JRNL_DATE,  
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
        $query_input_cost_other_in = $db->prepare($input_cost_other_in);

        // Mulai Input
        ///var_dump(array(
        $db->beginTransaction();
        $query_input_cost_other_in->execute(array(
        ':TRXA_JRNL_CODE' =>$xjrnlcode,':TRXA_JRNL_DATE' =>$dateinput,  
        ':TRXA_COAC_CODE' =>$code_cost_other, ':TRXA_COAC_NAME' =>$name_cost_other,                  
        ':TRXA_JRNL_DEBT' =>$fee_kasir, ':TRXA_JRNL_CRDT' =>$tret_null,  
        ':TRXA_DIVI_CODE' =>$code_divisi, ':TRXA_DIVI_NAME' =>$name_divisi, ':TRXA_JRNL_NOTE' =>$cost_other_in_note,
        ':TRXA_JRNL_STAT' =>$jrnlstat,
        ':TRXA_ENTR_DATE' =>$dateinput,':TRXA_ENTR_TIME' =>$timeinput,':TRXA_ENTR_USER' =>$userid,  
        ':TRXA_UPDT_DATE' =>$dateinput,':TRXA_UPDT_TIME' =>$timeinput,':TRXA_UPDT_USER' =>$userid));
        ///print_r($db->error_Info());
        ///var_dump($query_input);
        ///exit();
        $db->commit();
?>