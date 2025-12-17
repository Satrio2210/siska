<?php
error_reporting(E_ALL & ~E_NOTICE);

include "conf/config.php";

$kode = $_GET['q'];
//$kode = 'ASRUL'; 

if($kode)
{
        $sql = "SELECT * FROM passiden WHERE PASS_USER_IDEN = '$kode'";
        $q = $db->query($sql) or die("Gagal Maning!!");
        while ($r = $q->fetch(PDO::FETCH_ASSOC))  
        {
            $useriden = "$r[PASS_USER_IDEN]"; 
            $username = "$r[PASS_USER_NAME]";
            $userpswd = "$r[PASS_USER_PSWD]";
            $usertype = "$r[PASS_USER_TYPE]";
                    //   res1       res2     res3      res4       
            $data = "|$useriden|$username|$userpswd|$usertype";

            // Manage user
            $idennew = "$r[PASS_IDEN_NEW]";
			$idenprev = "$r[PASS_IDEN_PREV]";
			$idendell = "$r[PASS_IDEN_DELL]";
			$idenview = "$r[PASS_IDEN_VIEW]";

                    //   res5       res6     res7      res8       
            $data .= "|$idennew|$idenprev|$idendell|$idenview";


            // Manual Journal
            $trxaentr = "$r[PASS_TRXA_ENTR]";

                    //   res9      
            $data .= "|$trxaentr";

            // Chart of Account
            $coacentr = "$r[PASS_COAC_ENTR]";

                    //   res10 
            $data .= "|$coacentr";

            // Group Account
            $tblaentr = "$r[PASS_TBLA_ENTR]";

                    //   res11
            $data .= "|$tblaentr";

            // Divisi
            $divientr = "$r[PASS_DIVI_ENTR]";

                    //   res12
            $data .= "|$divientr";

            // Report
            $repoview = "$r[PASS_REPO_VIEW]";

                    //   res13
            $data .= "|$repoview";

            // Spec Item
            $specitem = "$r[PASS_SPEC_ITEM]";

            // Manage Item Master
            $inveentr = "$r[PASS_INVE_ENTR]";

                    //   res14     res15  
            $data .= "|$specitem|$inveentr";

            // Manage Location
            $warehous = "$r[PASS_WARE_HOUS]";

                    //   res16  
            $data .= "|$warehous";

            // Transfer Inventory
            $transrequ = "$r[PASS_TRANS_REQU]";
            $transapro = "$r[PASS_TRANS_APRO]";
            $transexec = "$r[PASS_TRANS_EXEC]";
            $transrece = "$r[PASS_TRANS_RECE]";

                    //   res17      res18      res19     res20      
            $data .= "|$transrequ|$transapro|$transexec|$transrece";

            // Stock Inventory
            $stockopna = "$r[PASS_STOCK_OPNA]";
            $stockadju = "$r[PASS_STOCK_ADJU]";
            $stockexec = "$r[PASS_STOCK_EXEC]";
            $stockrepo = "$r[PASS_STOCK_REPO]";

                    //   res21      res22    res23     res24
            $data .= "|$stockopna|$stockadju|$stockexec|$stockrepo";

            // Suplier
            $suplentr = "$r[PASS_SUPL_ENTR]";

                    //   res25      
            $data .= "|$suplentr";

            // Purchasing
            $procentr = "$r[PASS_PROC_ENTR]";
            $procupdt = "$r[PASS_PROC_UPDT]";
            $procinvc = "$r[PASS_PROC_INVC]";

                    //   res26      res27    res28    
            $data .= "|$procentr|$procupdt|$procinvc";

            // Admision
            $regientr = "$r[PASS_REGI_ENTR]";

                    //    res29     
            $data .= "|$regientr";

            // Out Patient
            $trxapoli = "$r[PASS_TRXA_POLI]";

            // Doctor Payment
            $medientr = "$r[PASS_MEDI_ENTR]";

            // Laboratory
            $laboentr = "$r[PASS_LABO_ENTR]";

                    //    res30     res31    res32
            $data .= "|$trxapoli|$medientr|$laboentr";

            // Partnership
            $custentr = "$r[PASS_CUST_ENTR]";

                    //    res33
            $data .= "|$custentr";

            // Cashier
            $saleentr = "$r[PASS_SALE_ENTR]";
            $saleview = "$r[PASS_SALE_VIEW]";

                    //   res34      res35   
            $data .= "|$saleentr|$saleview";

            $drugentr = "$r[PASS_DRUG_ENTR]";
            $drugview = "$r[PASS_DRUG_VIEW]";

                    //   res36      res37       
            $data .= "|$drugentr|$drugview";

            // Medical Record
            $medirepo = "$r[PASS_MEDI_REPO]";


                    //   res38   
            $data .= "|$medirepo";

            // Vendor Payment
            $vendentr = "$r[PASS_VEND_ENTR]";
            $vendupdt = "$r[PASS_VEND_UPDT]";
            $vendexec = "$r[PASS_VEND_EXEC]";

                    //   res39      res40    res41   
            $data .= "|$vendentr|$vendupdt|$vendexec";

            // Receivable
            $custrcvd = "$r[PASS_CUST_RCVD]";
            $paymcash = "$r[PASS_PAYM_CASH]";

                    //   res42      res43   
            $data .= "|$custrcvd|$paymcash";

            //  Debit / Credit
            $debtentr = "$r[PASS_DEBT_ENTR]";
            $crdtentr = "$r[PASS_CRDT_ENTR]";

            // Bank
            $bankreco = "$r[PASS_BANK_RECO]";

                    //   res44      res45    res46          
            $data .= "|$debtentr|$crdtentr|$bankreco";

            // Fixed Asset
            $fixeasse = "$r[PASS_FIXE_ASSE]";

                    //   res47
            $data .= "|$fixeasse";


            // Personnel
            $emplentr = "$r[PASS_EMPL_ENTR]";

            // Payroll
            $payrentr = "$r[PASS_PAYR_ENTR]";

                    //   res48      res49
            $data .= "|$emplentr|$payrentr";

            echo $data;

        }
}
?>	
