<?php
error_reporting(E_ALL & ~E_NOTICE);
//memulai session
session_start();

//cek adanya session
if (ISSET($_SESSION['username']))
{

include "conf/config.php";
if (isset($_POST['txtuseriden']))
    {
        $useriden = $_POST['txtuseriden'];

        if(isset($_POST['txtusername']) && ($_POST['txtusername'] != '')) 
        {
         $username = $_POST['txtusername'];
        }

        if(isset($_POST['txtuserpswd']) && ($_POST['txtuserpswd'] != '')) 
            { 
                $xuserpswd = $_POST['txtuserpswd']; 
                $userpswd=md5($xuserpswd);
            } else { $userpswd = $_POST['hiduserpswd']; }

        // Manajemen User
        if(isset($_POST['optidennew']) && ($_POST['optidennew'] != '')) { $idennew = 'Y'; } else { $idennew = 'N'; }
        if(isset($_POST['optidenprev']) && ($_POST['optidenprev'] != '')) { $idenprev = 'Y'; } else { $idenprev = 'N'; }
        if(isset($_POST['optidendell']) && ($_POST['optidendell'] != '')) { $idendell = 'Y'; } else { $idendell = 'N'; }
        if(isset($_POST['optidenview']) && ($_POST['optidenview'] != '')) { $idenview = 'Y'; } else { $idenview = 'N'; }

        // Manual Journal 
       if(isset($_POST['opttrxaentr']) && ($_POST['opttrxaentr'] != '')) { $trxaentr = 'Y'; } else { $trxaentr = 'N'; }
        if(isset($_POST['opttrxaupdt']) && ($_POST['opttrxaupdt'] != '')) { $trxaupdt = 'Y'; } else { $trxaupdt = 'N'; }
        if(isset($_POST['opttrxadell']) && ($_POST['opttrxadell'] != '')) { $trxadell = 'Y'; } else { $trxadell = 'N'; }
        if(isset($_POST['opttrxaview']) && ($_POST['opttrxaview'] != '')) { $trxaview = 'Y'; } else { $trxaview = 'N'; }

        // Chart Of Account
       if(isset($_POST['optcoacentr']) && ($_POST['optcoacentr'] != '')) { $coacentr = 'Y'; } else { $coacentr = 'N'; }
        if(isset($_POST['optcoacupdt']) && ($_POST['optcoacupdt'] != '')) { $coacupdt = 'Y'; } else { $coacupdt = 'N'; }
        if(isset($_POST['optcoacdell']) && ($_POST['optcoacdell'] != '')) { $coacdell = 'Y'; } else { $coacdell = 'N'; }
        if(isset($_POST['optcoacview']) && ($_POST['optcoacview'] != '')) { $coacview = 'Y'; } else { $coacview = 'N'; }

        // Group Account
       if(isset($_POST['opttblaentr']) && ($_POST['opttblaentr'] != '')) { $tblaentr = 'Y'; } else { $tblaentr = 'N'; }
        if(isset($_POST['opttblaupdt']) && ($_POST['opttblaupdt'] != '')) { $tblaupdt = 'Y'; } else { $tblaupdt = 'N'; }
        if(isset($_POST['opttbladell']) && ($_POST['opttbladell'] != '')) { $tbladell = 'Y'; } else { $tbladell = 'N'; }
        if(isset($_POST['opttblaview']) && ($_POST['opttblaview'] != '')) { $tblaview = 'Y'; } else { $tblaview = 'N'; }

        // Divisi
       if(isset($_POST['optdivientr']) && ($_POST['optdivientr'] != '')) { $divientr = 'Y'; } else { $divientr = 'N'; }
        if(isset($_POST['optdiviupdt']) && ($_POST['optdiviupdt'] != '')) { $diviupdt = 'Y'; } else { $diviupdt = 'N'; }
        if(isset($_POST['optdividell']) && ($_POST['optdividell'] != '')) { $dividell = 'Y'; } else { $dividell = 'N'; }
        if(isset($_POST['optdiviview']) && ($_POST['optdiviview'] != '')) { $diviview = 'Y'; } else { $diviview = 'N'; }

        // Report
       if(isset($_POST['optrepogele']) && ($_POST['optrepogele'] != '')) { $repogele = 'Y'; } else { $repogele = 'N'; }
        if(isset($_POST['optrepotrba']) && ($_POST['optrepotrba'] != '')) { $repotrba = 'Y'; } else { $repotrba = 'N'; }
        if(isset($_POST['optrepoprlo']) && ($_POST['optrepoprlo'] != '')) { $repoprlo = 'Y'; } else { $repoprlo = 'N'; }
        if(isset($_POST['optrepoequi']) && ($_POST['optrepoequi'] != '')) { $repoequi = 'Y'; } else { $repoequi = 'N'; }
       if(isset($_POST['optreponrca']) && ($_POST['optreponrca'] != '')) { $reponrca = 'Y'; } else { $reponrca = 'N'; }

       // Data Suplier
       if(isset($_POST['optsuplentr']) && ($_POST['optsuplentr'] != '')) { $suplentr = 'Y'; } else { $suplentr = 'N'; }
        if(isset($_POST['optsuplupdt']) && ($_POST['optsuplupdt'] != '')) { $suplupdt = 'Y'; } else { $suplupdt = 'N'; }
        if(isset($_POST['optsupldell']) && ($_POST['optsupldell'] != '')) { $supldell = 'Y'; } else { $supldell = 'N'; }
        if(isset($_POST['optsuplview']) && ($_POST['optsuplview'] != '')) { $suplview = 'Y'; } else { $suplview = 'N'; }

        // Item Inventory
       if(isset($_POST['optinveentr']) && ($_POST['optinveentr'] != '')) { $inveentr = 'Y'; } else { $inveentr = 'N'; }
        if(isset($_POST['optinveupdt']) && ($_POST['optinveupdt'] != '')) { $inveupdt = 'Y'; } else { $inveupdt = 'N'; }
        if(isset($_POST['optinvedell']) && ($_POST['optinvedell'] != '')) { $invedell = 'Y'; } else { $invedell = 'N'; }
        if(isset($_POST['optinveview']) && ($_POST['optinveview'] != '')) { $inveview = 'Y'; } else { $inveview = 'N'; }

        // Inventory Movement
       if(isset($_POST['opttransrequ']) && ($_POST['opttransrequ'] != '')) { $transrequ = 'Y'; } else { $transrequ = 'N'; }
        if(isset($_POST['opttransapro']) && ($_POST['opttransapro'] != '')) { $transapro = 'Y'; } else { $transapro = 'N'; }
        if(isset($_POST['opttransexec']) && ($_POST['opttransexec'] != '')) { $transexec = 'Y'; } else { $transexec = 'N'; }
        if(isset($_POST['opttransrece']) && ($_POST['opttransrece'] != '')) { $transrece = 'Y'; } else { $transrece = 'N'; }
        if(isset($_POST['opttranstrans']) && ($_POST['opttranstrans'] != '')) { $transtrans = 'Y'; } else { $transtrans = 'N'; }
        if(isset($_POST['opttransexpd']) && ($_POST['opttransexpd'] != '')) { $transexpd = 'Y'; } else { $transexpd = 'N'; }

        // Stock Inventory 
        if(isset($_POST['optstockopna']) && ($_POST['optstockopna'] != '')) { $stockopna = 'Y'; } else { $stockopna = 'N'; }
        if(isset($_POST['optstockadju']) && ($_POST['optstockadju'] != '')) { $stockadju = 'Y'; } else { $stockadju = 'N'; }
        if(isset($_POST['optstockexec']) && ($_POST['optstockexec'] != '')) { $stockexec = 'Y'; } else { $stockexec = 'N'; }
        if(isset($_POST['optstockrepo']) && ($_POST['optstockrepo'] != '')) { $stockrepo = 'Y'; } else { $stockrepo = 'N'; }

        // Management Purchasing
        if(isset($_POST['optprocentr']) && ($_POST['optprocentr'] != '')) { $procentr = 'Y'; } else { $procentr = 'N'; }
        if(isset($_POST['optprocupdt']) && ($_POST['optprocupdt'] != '')) { $procupdt = 'Y'; } else { $procupdt = 'N'; }
        if(isset($_POST['optprocinvc']) && ($_POST['optprocinvc'] != '')) { $procinvc = 'Y'; } else { $procinvc = 'N'; }
        if(isset($_POST['optprocretu']) && ($_POST['optprocretu'] != '')) { $procretu = 'Y'; } else { $procretu = 'N'; }
        if(isset($_POST['optcustentr']) && ($_POST['optcustentr'] != '')) { $custentr = 'Y'; } else { $custentr = 'N'; }
        if(isset($_POST['optcustupdt']) && ($_POST['optcustupdt'] != '')) { $custupdt = 'Y'; } else { $custupdt = 'N'; }
        if(isset($_POST['optcustdell']) && ($_POST['optcustdell'] != '')) { $custdell = 'Y'; } else { $custdell = 'N'; }
        if(isset($_POST['optcustview']) && ($_POST['optcustview'] != '')) { $custview = 'Y'; } else { $custview = 'N'; }

        // Selling and Distibution
        if(isset($_POST['optsaleentr']) && ($_POST['optsaleentr'] != '')) { $saleentr = 'Y'; } else { $saleentr = 'N'; }
        if(isset($_POST['optsaleupdt']) && ($_POST['optsaleupdt'] != '')) { $saleupdt = 'Y'; } else { $saleupdt = 'N'; }

        // Management Finance
        if(isset($_POST['optfinaplan']) && ($_POST['optfinaplan'] != '')) { $finaplan = 'Y'; } else { $finaplan = 'N'; }
        if(isset($_POST['optvendentr']) && ($_POST['optvendentr'] != '')) { $vendentr = 'Y'; } else { $vendentr = 'N'; }
        if(isset($_POST['optvendupdt']) && ($_POST['optvendupdt'] != '')) { $vendupdt = 'Y'; } else { $vendupdt = 'N'; }
        if(isset($_POST['optvendexec']) && ($_POST['optvendexec'] != '')) { $vendexec = 'Y'; } else { $vendexec = 'N'; }
        if(isset($_POST['optcustrcvd']) && ($_POST['optcustrcvd'] != '')) { $custrcvd = 'Y'; } else { $custrcvd = 'N'; }
        if(isset($_POST['optpaymcash']) && ($_POST['optpaymcash'] != '')) { $paymcash = 'Y'; } else { $paymcash = 'N'; }
        if(isset($_POST['optothrreve']) && ($_POST['optothrreve'] != '')) { $othrreve = 'Y'; } else { $othrreve = 'N'; }
        if(isset($_POST['optdebtnote']) && ($_POST['optdebtnote'] != '')) { $debtnote = 'Y'; } else { $debtnote = 'N'; }
        if(isset($_POST['optdebtreal']) && ($_POST['optdebtreal'] != '')) { $debtreal = 'Y'; } else { $debtreal = 'N'; }
        if(isset($_POST['optcrdtnote']) && ($_POST['optcrdtnote'] != '')) { $crdtnote = 'Y'; } else { $crdtnote = 'N'; }
        if(isset($_POST['optcrdtreal']) && ($_POST['optcrdtreal'] != '')) { $crdtreal = 'Y'; } else { $crdtreal = 'N'; }
        if(isset($_POST['optfinareco']) && ($_POST['optfinareco'] != '')) { $finareco = 'Y'; } else { $finareco = 'N'; }

        // Management Asset
        if(isset($_POST['optassetype']) && ($_POST['optassetype'] != '')) { $assetype = 'Y'; } else { $assetype = 'N'; }
        if(isset($_POST['optassepost']) && ($_POST['optassepost'] != '')) { $assepost = 'Y'; } else { $assepost = 'N'; }
        if(isset($_POST['optasselist']) && ($_POST['optasselist'] != '')) { $asselist = 'Y'; } else { $asselist = 'N'; }
        if(isset($_POST['optmoveexec']) && ($_POST['optmoveexec'] != '')) { $moveexec = 'Y'; } else { $moveexec = 'N'; }
        if(isset($_POST['optmovehist']) && ($_POST['optmovehist'] != '')) { $movehist = 'Y'; } else { $movehist = 'N'; }
        if(isset($_POST['optrevaexec']) && ($_POST['optrevaexec'] != '')) { $revaexec = 'Y'; } else { $revaexec = 'N'; }
        if(isset($_POST['optrevahist']) && ($_POST['optrevahist'] != '')) { $revahist = 'Y'; } else { $revahist = 'N'; }
        if(isset($_POST['optassedisp']) && ($_POST['optassedisp'] != '')) { $assedisp = 'Y'; } else { $assedisp = 'N'; }

        //Human Resources
        if(isset($_POST['optemplentr']) && ($_POST['optemplentr'] != '')) { $emplentr = 'Y'; } else { $emplentr = 'N'; }
        if(isset($_POST['optemplupdt']) && ($_POST['optemplupdt'] != '')) { $emplupdt = 'Y'; } else { $emplupdt = 'N'; }
        if(isset($_POST['optempldell']) && ($_POST['optempldell'] != '')) { $empldell = 'Y'; } else { $empldell = 'N'; }
        if(isset($_POST['optemplview']) && ($_POST['optemplview'] != '')) { $emplview = 'Y'; } else { $emplview = 'N'; }
        if(isset($_POST['optemplkeys']) && ($_POST['optemplkeys'] != '')) { $emplkeys = 'Y'; } else { $emplkeys = 'N'; }
        if(isset($_POST['optempldivi']) && ($_POST['optempldivi'] != '')) { $empldivi = 'Y'; } else { $empldivi = 'N'; }
        if(isset($_POST['optpayrentr']) && ($_POST['optpayrentr'] != '')) { $payrentr = 'Y'; } else { $payrentr = 'N'; }
        if(isset($_POST['optemplpayr']) && ($_POST['optemplpayr'] != '')) { $emplpayr = 'Y'; } else { $emplpayr = 'N'; }
        if(isset($_POST['optpayrupdt']) && ($_POST['optpayrupdt'] != '')) { $payrupdt = 'Y'; } else { $payrupdt = 'N'; }
        if(isset($_POST['optpayrexec']) && ($_POST['optpayrexec'] != '')) { $payrexec = 'Y'; } else { $payrexec = 'N'; }
        if(isset($_POST['optpayrcash']) && ($_POST['optpayrcash'] != '')) { $payrcash = 'Y'; } else { $payrcash = 'N'; }

        $userid = $_SESSION['username'];
        $dateinput = date("y-m-d");
        $timeinput = date("G:i:s");

        $update = "UPDATE passiden SET PASS_USER_NAME='$username',
				    PASS_USER_PSWD='$userpswd',

					PASS_IDEN_NEW='$idennew',
					PASS_IDEN_PREV='$idenprev',
					PASS_IDEN_DELL='$idendell',
					PASS_IDEN_VIEW='$idenview',

					PASS_TRXA_ENTR='$trxaentr',
					PASS_TRXA_UPDT='$trxaupdt',
					PASS_TRXA_DELL='$trxadell',
					PASS_TRXA_VIEW='$trxaview',

					PASS_COAC_ENTR='$coacentr',
					PASS_COAC_UPDT='$coacupdt',
					PASS_COAC_DELL='$coacdell',
					PASS_COAC_VIEW='$coacview',

					PASS_TBLA_ENTR='$tblaentr',
					PASS_TBLA_UPDT='$tblaupdt',
					PASS_TBLA_DELL='$tbladell',
					PASS_TBLA_VIEW='$tblaview',

					PASS_DIVI_ENTR='$divientr',
					PASS_DIVI_UPDT='$diviupdt',
					PASS_DIVI_DELL='$dividell',
					PASS_DIVI_VIEW='$diviview',

					PASS_REPO_GELE='$repogele',
					PASS_REPO_TRBA='$repotrba',
					PASS_REPO_PRLO='$repoprlo',
					PASS_REPO_EQUI='$repoequi',
					PASS_REPO_NRCA='$reponrca',

					PASS_SUPL_ENTR='$suplentr',
					PASS_SUPL_UPDT='$suplupdt',
					PASS_SUPL_DELL='$supldell',
					PASS_SUPL_VIEW='$suplview',

					PASS_INVE_ENTR='$inveentr',
					PASS_INVE_UPDT='$inveupdt',
					PASS_INVE_DELL='$invedell',
					PASS_INVE_VIEW='$inveview',

					PASS_TRANS_REQU='$transrequ',
					PASS_TRANS_APRO='$transapro',
					PASS_TRANS_EXEC='$transexec',
					PASS_TRANS_RECE='$transrece',
					PASS_TRANS_TRANS='$transtrans',
					PASS_TRANS_EXPD='$transexpd',

					PASS_STOCK_OPNA='$stockopna',
					PASS_STOCK_ADJU='$stockadju',
					PASS_STOCK_EXEC='$stockexec',
					PASS_STOCK_REPO='$stockrepo',

					PASS_PROC_ENTR='$procentr',
					PASS_PROC_UPDT='$procupdt',
					PASS_PROC_INVC='$procinvc',
					PASS_PROC_RETU='$procretu',
                    
					PASS_CUST_ENTR='$custentr',
					PASS_CUST_UPDT='$custupdt',
					PASS_CUST_DELL='$custdell',
					PASS_CUST_VIEW='$custview',

					PASS_SALE_ENTR='$saleentr',
					PASS_SALE_UPDT='$saleupdt',

					PASS_FINA_PLAN='$finaplan',
					PASS_VEND_ENTR='$vendentr',
					PASS_VEND_UPDT='$vendupdt',
					PASS_VEND_EXEC='$vendexec',
					PASS_CUST_RCVD='$custrcvd',
					PASS_PAYM_CASH='$paymcash',
					PASS_OTHR_REVE='$othrreve',
					PASS_DEBT_NOTE='$debtnote',
					PASS_DEBT_REAL='$debtreal',
					PASS_CRDT_NOTE='$crdtnote',
					PASS_CRDT_REAL='$crdtreal',
					PASS_FINA_RECO='$finareco',

					PASS_ASSE_TYPE='$assetype',
					PASS_ASSE_POST='$assepost',
					PASS_ASSE_LIST='$asselist',
					PASS_MOVE_EXEC='$moveexec',
					PASS_MOVE_HIST='$movehist',
					PASS_REVA_EXEC='$revaexec',
					PASS_REVA_HIST='$revahist',
					PASS_ASSE_DISP='$assedisp',

					PASS_EMPL_ENTR='$emplentr',
					PASS_EMPL_UPDT='$emplupdt',
					PASS_EMPL_DELL='$empldell',
					PASS_EMPL_VIEW='$emplview',
					PASS_EMPL_KEYS='$emplkeys',
					PASS_EMPL_DIVI='$empldivi',
					PASS_PAYR_ENTR='$payrentr',
					PASS_EMPL_PAYR='$emplpayr',
					PASS_PAYR_UPDT='$payrupdt',
					PASS_PAYR_EXEC='$payrexec',
					PASS_PAYR_CASH='$payrcash',

                    PASS_UPDT_DATE='$dateinput',
                    PASS_UPDT_TIME='$timeinput',
                    PASS_UPDT_USER='$userid'    
				WHERE PASS_USER_IDEN='$useriden'";

                // Prepare Request  
                $query_update = $db->prepare($update);

                // Mulai Input
                $db->beginTransaction();
                $query_update->execute();
                $db->commit();
                header("location: PASSIDEN02.php");
    
    }
}
else
{
  header("Location: "."index.php");
}
?>