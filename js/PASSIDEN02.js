  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="PASSIDEN02X-AKSES.php";
    aksesku.onreadystatechange=stateChangedAkses;
    var params = "q="+fieldid;
    //alert('Parameter adalah '+fieldid);
    aksesku.open("POST",url,true);
    aksesku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    aksesku.setRequestHeader("Content-length", params.length);
    aksesku.setRequestHeader("Connection", "close");
    aksesku.send(params);

  }

  function buatajaxakses()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedAkses()
  {
  var data;
  if (aksesku.readyState==4)
    {

    xdata=aksesku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtuseriden').focus();
        document.getElementById('txtusername').setAttribute('disabled','true');

        document.getElementById('optdoctor').setAttribute('disabled','true');
        document.getElementById('optnondoctor').setAttribute('disabled','true');

        document.getElementById('txtuserpswd').setAttribute('disabled','true');

        document.getElementById('optidennew').setAttribute('disabled','true');
        document.getElementById('optidenprev').setAttribute('disabled','true');
        document.getElementById('optidendell').setAttribute('disabled','true');
        document.getElementById('optidenview').setAttribute('disabled','true');

        document.getElementById('opttrxaentr').setAttribute('disabled','true');        
        document.getElementById('optcoacentr').setAttribute('disabled','true');        
        document.getElementById('opttblaentr').setAttribute('disabled','true');        

        document.getElementById('optdivientr').setAttribute('disabled','true');        

        document.getElementById('optrepoview').setAttribute('disabled','true');        

        document.getElementById('optspecitem').setAttribute('disabled','true');        

        document.getElementById('optinveentr').setAttribute('disabled','true');        

        document.getElementById('optwarehous').setAttribute('disabled','true');

        document.getElementById('opttransrequ').setAttribute('disabled','true');
        document.getElementById('opttransapro').setAttribute('disabled','true');
        document.getElementById('opttransexec').setAttribute('disabled','true');
        document.getElementById('opttransrece').setAttribute('disabled','true');

        document.getElementById('optstockopna').setAttribute('disabled','true');
        document.getElementById('optstockadju').setAttribute('disabled','true');
        document.getElementById('optstockexec').setAttribute('disabled','true');
        document.getElementById('optstockrepo').setAttribute('disabled','true');

        document.getElementById('optsuplentr').setAttribute('disabled','true');        

        document.getElementById('optprocentr').setAttribute('disabled','true');
        document.getElementById('optprocupdt').setAttribute('disabled','true');
        document.getElementById('optprocinvc').setAttribute('disabled','true');

        document.getElementById('optregientr').setAttribute('disabled','true');

        document.getElementById('opttrxapoli').setAttribute('disabled','true');

        document.getElementById('optmedientr').setAttribute('disabled','true');

        document.getElementById('optlaboentr').setAttribute('disabled','true');

        document.getElementById('optcustentr').setAttribute('disabled','true');

        document.getElementById('optsaleentr').setAttribute('disabled','true');
        document.getElementById('optsaleview').setAttribute('disabled','true');

        document.getElementById('optdrugentr').setAttribute('disabled','true');
        document.getElementById('optdrugview').setAttribute('disabled','true');

        document.getElementById('optmedirepo').setAttribute('disabled','true');

        document.getElementById('optvendentr').setAttribute('disabled','true');
        document.getElementById('optvendupdt').setAttribute('disabled','true');
        document.getElementById('optvendexec').setAttribute('disabled','true');

        document.getElementById('optcustrcvd').setAttribute('disabled','true');
        document.getElementById('optpaymcash').setAttribute('disabled','true');

        document.getElementById('optdebtentr').setAttribute('disabled','true');
        document.getElementById('optcrdtentr').setAttribute('disabled','true');

        document.getElementById('optbankreco').setAttribute('disabled','true');

        document.getElementById('optfixeasse').setAttribute('disabled','true');

        document.getElementById('optemplentr').setAttribute('disabled','true');

        document.getElementById('optpayrentr').setAttribute('disabled','true');
      }
      else
      {
        document.getElementById('txtuseriden').setAttribute('disabled','true');
        document.getElementById('txtusername').setAttribute('disabled','true');

        document.getElementById('optdoctor').setAttribute('disabled','true');
        document.getElementById('optnondoctor').setAttribute('disabled','true');

        document.getElementById('txtuserpswd').setAttribute('disabled','true');

        document.getElementById('optidennew').setAttribute('disabled','true');
        document.getElementById('optidenprev').setAttribute('disabled','true');
        document.getElementById('optidendell').setAttribute('disabled','true');
        document.getElementById('optidenview').setAttribute('disabled','true');

        document.getElementById('opttrxaentr').setAttribute('disabled','true');        
        document.getElementById('optcoacentr').setAttribute('disabled','true');        
        document.getElementById('opttblaentr').setAttribute('disabled','true');        

        document.getElementById('optdivientr').setAttribute('disabled','true');        

        document.getElementById('optrepoview').setAttribute('disabled','true');        

        document.getElementById('optspecitem').setAttribute('disabled','true');        

        document.getElementById('optinveentr').setAttribute('disabled','true');        

        document.getElementById('optwarehous').setAttribute('disabled','true');

        document.getElementById('opttransrequ').setAttribute('disabled','true');
        document.getElementById('opttransapro').setAttribute('disabled','true');
        document.getElementById('opttransexec').setAttribute('disabled','true');
        document.getElementById('opttransrece').setAttribute('disabled','true');

        document.getElementById('optstockopna').setAttribute('disabled','true');
        document.getElementById('optstockadju').setAttribute('disabled','true');
        document.getElementById('optstockexec').setAttribute('disabled','true');
        document.getElementById('optstockrepo').setAttribute('disabled','true');

        document.getElementById('optsuplentr').setAttribute('disabled','true');        

        document.getElementById('optprocentr').setAttribute('disabled','true');
        document.getElementById('optprocupdt').setAttribute('disabled','true');
        document.getElementById('optprocinvc').setAttribute('disabled','true');

        document.getElementById('optregientr').setAttribute('disabled','true');

        document.getElementById('opttrxapoli').setAttribute('disabled','true');

        document.getElementById('optmedientr').setAttribute('disabled','true');

        document.getElementById('optlaboentr').setAttribute('disabled','true');

        document.getElementById('optcustentr').setAttribute('disabled','true');

        document.getElementById('optsaleentr').setAttribute('disabled','true');
        document.getElementById('optsaleview').setAttribute('disabled','true');

        document.getElementById('optdrugentr').setAttribute('disabled','true');
        document.getElementById('optdrugview').setAttribute('disabled','true');

        document.getElementById('optmedirepo').setAttribute('disabled','true');

        document.getElementById('optvendentr').setAttribute('disabled','true');
        document.getElementById('optvendupdt').setAttribute('disabled','true');
        document.getElementById('optvendexec').setAttribute('disabled','true');

        document.getElementById('optcustrcvd').setAttribute('disabled','true');
        document.getElementById('optpaymcash').setAttribute('disabled','true');

        document.getElementById('optdebtentr').setAttribute('disabled','true');
        document.getElementById('optcrdtentr').setAttribute('disabled','true');

        document.getElementById('optbankreco').setAttribute('disabled','true');

        document.getElementById('optfixeasse').setAttribute('disabled','true');

        document.getElementById('optemplentr').setAttribute('disabled','true');

        document.getElementById('optpayrentr').setAttribute('disabled','true');
        document.getElementById("labelmessage").style.visibility =  "";

      }
    }
  }
// end periksa akses  

    
      var ajaxku;
  function periksaid(kodeid)
  {
    ajaxku = buatajax();
    var url="PASSIDEN02X.php";
    url=url+"?q="+kodeid;
    url=url+"&sid="+Math.random();
    ajaxku.onreadystatechange=stateChanged;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
  }

  function buatajax()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChanged()
  {
  var data;
  if (ajaxku.readyState==4)
    {
    data=ajaxku.responseText;
    if(data.length>3)
      { 
        //alert(data);

        var res = data.split("|");
        document.getElementById("txtusername").disabled = false;
        document.getElementById("txtusername").value = res[2];

        document.getElementById("optdoctor").disabled = false;
        document.getElementById("optnondoctor").disabled = false;

        document.getElementById("txtuserpswd").disabled = false;
        document.getElementById("txtuserpswd").value = '';
        document.getElementById("txtuserpswd").placeholder = res[3];

        document.getElementById("hiduserpswd").disabled = false;
        document.getElementById("hiduserpswd").value = res[3];

        if(res[4] == 'Y') 
            { 
                document.getElementById("optdoctor").checked = true;
                document.getElementById("optnondoctor").checked = false; 
            }
        else if(res[4] == 'N')
            { 
                document.getElementById("optdoctor").checked = false;
                document.getElementById("optnondoctor").checked = true; 
            }         
        else 
            { 
                document.getElementById("optdoctor").checked = false;
                document.getElementById("optnondoctor").checked = false; 
            }

        document.getElementById("hidusertype").disabled = false;
        document.getElementById("hidusertype").value = res[4];

        // Manage User
        document.getElementById("optidennew").disabled = false;        
        if(res[5] == 'Y') { document.getElementById("optidennew").checked = true; }
        else { document.getElementById("optidennew").checked = false; }

        document.getElementById("optidenprev").disabled = false;        
        if(res[6] == 'Y') { document.getElementById("optidenprev").checked = true; }
        else { document.getElementById("optidenprev").checked = false; }

        document.getElementById("optidendell").disabled = false;        
        if(res[7] == 'Y') { document.getElementById("optidendell").checked = true; }
        else { document.getElementById("optidendell").checked = false; }

        document.getElementById("optidenview").disabled = false;        
        if(res[8] == 'Y') { document.getElementById("optidenview").checked = true; }
        else { document.getElementById("optidenview").checked = false; }


        // Manual Journal
        document.getElementById("opttrxaentr").disabled = false;        
        if(res[9] == 'Y') { document.getElementById("opttrxaentr").checked = true; }
        else { document.getElementById("opttrxaentr").checked = false; }

        // Charts Of Account
        document.getElementById("optcoacentr").disabled = false;        
        if(res[10] == 'Y') { document.getElementById("optcoacentr").checked = true; }
        else { document.getElementById("optcoacentr").checked = false; }

        // Group Account
        document.getElementById("opttblaentr").disabled = false;        
        if(res[11] == 'Y') { document.getElementById("opttblaentr").checked = true; }
        else { document.getElementById("opttblaentr").checked = false; }

        // Division
        document.getElementById("optdivientr").disabled = false;        
        if(res[12] == 'Y') { document.getElementById("optdivientr").checked = true; }
        else { document.getElementById("optdivientr").checked = false; }

        // Report Accounting
        document.getElementById("optrepoview").disabled = false;        
        if(res[13] == 'Y') { document.getElementById("optrepoview").checked = true; }
        else { document.getElementById("optrepoview").checked = false; }

        // Management Item Master
        document.getElementById("optspecitem").disabled = false;        
        if(res[14] == 'Y') { document.getElementById("optspecitem").checked = true; }
        else { document.getElementById("optspecitem").checked = false; }

        document.getElementById("optinveentr").disabled = false;        
        if(res[15] == 'Y') { document.getElementById("optinveentr").checked = true; }
        else { document.getElementById("optinveentr").checked = false; }

        // Manage location

        document.getElementById("optwarehous").disabled = false;        
        if(res[16] == 'Y') { document.getElementById("optwarehous").checked = true; }
        else { document.getElementById("optwarehous").checked = false; }

        // Transfer Inventory
        document.getElementById("opttransrequ").disabled = false;        
        if(res[17] == 'Y') { document.getElementById("opttransrequ").checked = true; }
        else { document.getElementById("opttransrequ").checked = false; }

        document.getElementById("opttransapro").disabled = false;        
        if(res[18] == 'Y') { document.getElementById("opttransapro").checked = true; }
        else { document.getElementById("opttransapro").checked = false; }

        document.getElementById("opttransexec").disabled = false;        
        if(res[19] == 'Y') { document.getElementById("opttransexec").checked = true; }
        else { document.getElementById("opttransexec").checked = false; }

        document.getElementById("opttransrece").disabled = false;        
        if(res[20] == 'Y') { document.getElementById("opttransrece").checked = true; }
        else { document.getElementById("opttransrece").checked = false; }

        //Stock Inventory
        document.getElementById("optstockopna").disabled = false;        
        if(res[21] == 'Y') { document.getElementById("optstockopna").checked = true; }
        else { document.getElementById("optstockopna").checked = false; }

        document.getElementById("optstockadju").disabled = false;        
        if(res[22] == 'Y') { document.getElementById("optstockadju").checked = true; }
        else { document.getElementById("optstockadju").checked = false; }

        document.getElementById("optstockexec").disabled = false;        
        if(res[23] == 'Y') { document.getElementById("optstockexec").checked = true; }
        else { document.getElementById("optstockexec").checked = false; }

        document.getElementById("optstockrepo").disabled = false;        
        if(res[24] == 'Y') { document.getElementById("optstockrepo").checked = true; }
        else { document.getElementById("optstockrepo").checked = false; }


        // Suplier
        document.getElementById("optsuplentr").disabled = false;        
        if(res[25] == 'Y') { document.getElementById("optsuplentr").checked = true; }
        else { document.getElementById("optsuplentr").checked = false; }

        //  Purchasing
        document.getElementById("optprocentr").disabled = false;        
        if(res[26] == 'Y') { document.getElementById("optprocentr").checked = true; }
        else { document.getElementById("optprocentr").checked = false; }

        document.getElementById("optprocupdt").disabled = false;        
        if(res[27] == 'Y') { document.getElementById("optprocupdt").checked = true; }
        else { document.getElementById("optprocupdt").checked = false; }

        document.getElementById("optprocinvc").disabled = false;        
        if(res[28] == 'Y') { document.getElementById("optprocinvc").checked = true; }
        else { document.getElementById("optprocinvc").checked = false; }


        // Admision
        document.getElementById("optregientr").disabled = false;        
        if(res[29] == 'Y') { document.getElementById("optregientr").checked = true; }
        else { document.getElementById("optregientr").checked = false; }

        // Out Patient
        document.getElementById("opttrxapoli").disabled = false;        
        if(res[30] == 'Y') { document.getElementById("opttrxapoli").checked = true; }
        else { document.getElementById("opttrxapoli").checked = false; }

        // Data Tindakan
        document.getElementById("optmedientr").disabled = false;        
        if(res[31] == 'Y') { document.getElementById("optmedientr").checked = true; }
        else { document.getElementById("optmedientr").checked = false; }


        // Laboratory
        document.getElementById("optlaboentr").disabled = false;        
        if(res[32] == 'Y') { document.getElementById("optlaboentr").checked = true; }
        else { document.getElementById("optlaboentr").checked = false; }

        // Partnership
        document.getElementById("optcustentr").disabled = false;        
        if(res[33] == 'Y') { document.getElementById("optcustentr").checked = true; }
        else { document.getElementById("optcustentr").checked = false; }

        // Cashier
        document.getElementById("optsaleentr").disabled = false;        
        if(res[34] == 'Y') { document.getElementById("optsaleentr").checked = true; }
        else { document.getElementById("optsaleentr").checked = false; }

        document.getElementById("optsaleview").disabled = false;        
        if(res[35] == 'Y') { document.getElementById("optsaleview").checked = true; }
        else { document.getElementById("optsaleview").checked = false; }

        document.getElementById("optdrugentr").disabled = false;        
        if(res[36] == 'Y') { document.getElementById("optdrugentr").checked = true; }
        else { document.getElementById("optdrugentr").checked = false; }

        document.getElementById("optdrugview").disabled = false;        
        if(res[37] == 'Y') { document.getElementById("optdrugview").checked = true; }
        else { document.getElementById("optdrugview").checked = false; }

        // Medical Record

        document.getElementById("optmedirepo").disabled = false;        
        if(res[38] == 'Y') { document.getElementById("optmedirepo").checked = true; }
        else { document.getElementById("optmedirepo").checked = false; }

        // Vendor Payment

        document.getElementById("optvendentr").disabled = false;        
        if(res[39] == 'Y') { document.getElementById("optvendentr").checked = true; }
        else { document.getElementById("optvendentr").checked = false; }

        document.getElementById("optvendupdt").disabled = false;        
        if(res[40] == 'Y') { document.getElementById("optvendupdt").checked = true; }
        else { document.getElementById("optvendupdt").checked = false; }

        document.getElementById("optvendexec").disabled = false;        
        if(res[41] == 'Y') { document.getElementById("optvendexec").checked = true; }
        else { document.getElementById("optvendexec").checked = false; }

        // Receivable

        document.getElementById("optcustrcvd").disabled = false;        
        if(res[42] == 'Y') { document.getElementById("optcustrcvd").checked = true; }
        else { document.getElementById("optcustrcvd").checked = false; }

        document.getElementById("optpaymcash").disabled = false;        
        if(res[43] == 'Y') { document.getElementById("optpaymcash").checked = true; }
        else { document.getElementById("optpaymcash").checked = false; }

        // Debit / Credit
        document.getElementById("optdebtentr").disabled = false;        
        if(res[44] == 'Y') { document.getElementById("optdebtentr").checked = true; }
        else { document.getElementById("optdebtentr").checked = false; }

        document.getElementById("optcrdtentr").disabled = false;        
        if(res[45] == 'Y') { document.getElementById("optcrdtentr").checked = true; }
        else { document.getElementById("optcrdtentr").checked = false; }

        // Bank
        document.getElementById("optbankreco").disabled = false;        
        if(res[46] == 'Y') { document.getElementById("optbankreco").checked = true; }
        else { document.getElementById("optbankreco").checked = false; }

        // Fixed Asset
        document.getElementById("optfixeasse").disabled = false;        
        if(res[47] == 'Y') { document.getElementById("optfixeasse").checked = true; }
        else { document.getElementById("optfixeasse").checked = false; }

        // Personnel
        document.getElementById("optemplentr").disabled = false;        
        if(res[48] == 'Y') { document.getElementById("optemplentr").checked = true; }
        else { document.getElementById("optemplentr").checked = false; }

        // Payroll
        document.getElementById("optpayrentr").disabled = false;        
        if(res[49] == 'Y') { document.getElementById("optpayrentr").checked = true; }
        else { document.getElementById("optpayrentr").checked = false; }

        document.getElementById("labelmessage").style.visibility =  "hidden";
      }
      else
      {
        document.getElementById("txtusername").disabled = true;
        document.getElementById("txtusername").value = '';
        document.getElementById("txtuserpswd").disabled = true;
        document.getElementById("txtuserpswd").placeholder = '';

        document.getElementById("hiduserpswd").disabled = true;
        document.getElementById("hiduserpswd").value = '';

        document.getElementById("optdoctor").checked = false;
        document.getElementById("optnondoctor").checked = false;
        document.getElementById("optdoctor").disabled = true;
        document.getElementById("optnondoctor").disabled = true;

        // Manage User
        document.getElementById("optidennew").checked = false;        
        document.getElementById("optidenprev").checked = false;        
        document.getElementById("optidendell").checked = false;        
        document.getElementById("optidenview").checked = false;        

        document.getElementById("optidennew").disabled = true;        
        document.getElementById("optidenprev").disabled = true;        
        document.getElementById("optidendell").disabled = true;        
        document.getElementById("optidenview").disabled = true;        

        // Manual Journal
        document.getElementById("opttrxaentr").checked = false;
        document.getElementById("opttrxaentr").disabled = true;        

        // Chart of Account
        document.getElementById("optcoacentr").checked = false;
        document.getElementById("optcoacentr").disabled = true;        

        // Group Account
        document.getElementById("opttblaentr").checked = false;
        document.getElementById("opttblaentr").disabled = true;        

        // Divisi
        document.getElementById("optdivientr").checked = false;
        document.getElementById("optdivientr").disabled = true;        

        // Report
        document.getElementById("optrepoview").checked = false;
        document.getElementById("optrepoview").disabled = true;        

        // Spec Item
        document.getElementById("optspecitem").checked = false;
        document.getElementById("optspecitem").disabled = true;

        // Manage Item Master
        document.getElementById("optinveentr").checked = false;
        document.getElementById("optinveentr").disabled = true;        

        // Manage Location
        document.getElementById("optwarehous").disabled = true;        

        // Transfer Inventory
        document.getElementById("opttransrequ").checked = false;
        document.getElementById("opttransapro").checked = false;
        document.getElementById("opttransexec").checked = false;
        document.getElementById("opttransrece").checked = false;

        document.getElementById("opttransrequ").disabled = true;
        document.getElementById("opttransapro").disabled = true;
        document.getElementById("opttransexec").disabled = true;
        document.getElementById("opttransrece").disabled = true;

        // Stock Inventory
        document.getElementById("optstockopna").checked = false;
        document.getElementById("optstockadju").checked = false;
        document.getElementById("optstockexec").checked = false;
        document.getElementById("optstockrepo").checked = false;

        document.getElementById("optstockopna").disabled = true;
        document.getElementById("optstockadju").disabled = true;
        document.getElementById("optstockexec").disabled = true;
        document.getElementById("optstockrepo").disabled = true;

        // Suplier
        document.getElementById("optsuplentr").checked = false;
        document.getElementById("optsuplentr").disabled = true;        

        // Purchasing
        document.getElementById("optprocentr").checked = false;
        document.getElementById("optprocentr").disabled = true;

        document.getElementById("optprocupdt").checked = false;
        document.getElementById("optprocupdt").disabled = true;

        document.getElementById("optprocinvc").checked = false;
        document.getElementById("optprocinvc").disabled = true;

        // Admision
        document.getElementById("optregientr").checked = false;
        document.getElementById("optregientr").disabled = true;

        // Out Patient
        document.getElementById("opttrxapoli").checked = false;
        document.getElementById("opttrxapoli").disabled = true;

        // Doctor Payment
        document.getElementById("optmedientr").checked = false;
        document.getElementById("optmedientr").disabled = true;

        // Laboratory
        document.getElementById("optlaboentr").checked = false;
        document.getElementById("optlaboentr").disabled = true;


        // Partnership
        document.getElementById("optcustentr").checked = false;
        document.getElementById("optcustentr").disabled = true;

        // Cashier
        document.getElementById("optsaleentr").checked = false;
        document.getElementById("optsaleview").checked = false;
        document.getElementById("optdrugentr").checked = false;
        document.getElementById("optdrugview").checked = false;

        document.getElementById("optsaleentr").disabled = true;
        document.getElementById("optsaleview").disabled = true;
        document.getElementById("optdrugentr").disabled = true;
        document.getElementById("optdrugview").disabled = true;

        // Medical Record 
        document.getElementById("optmedirepo").checked = false;        
        document.getElementById("optmedirepo").disabled = true;


        // Vendor Payment
        document.getElementById("optvendentr").checked = false;
        document.getElementById("optvendupdt").checked = false;
        document.getElementById("optvendexec").checked = false;

        document.getElementById("optvendentr").disabled = true;
        document.getElementById("optvendupdt").disabled = true;
        document.getElementById("optvendexec").disabled = true;

        // Receivable
        document.getElementById("optcustrcvd").checked = false;
        document.getElementById("optpaymcash").checked = false;

        document.getElementById("optcustrcvd").disabled = true;
        document.getElementById("optpaymcash").disabled = true;

        // Debit Credit
        document.getElementById("optdebtentr").checked = false;
        document.getElementById("optcrdtentr").checked = false;

        document.getElementById("optdebtentr").disabled = true;
        document.getElementById("optcrdtentr").disabled = true;

        // Bank
        document.getElementById("optbankreco").checked = false;
        document.getElementById("optbankreco").disabled = true;

        // Fixed Asset
        document.getElementById("optfixeasse").checked = false;
        document.getElementById("optfixeasse").disabled = true;

        // Personnel
        document.getElementById("optemplentr").checked = false;
        document.getElementById("optemplentr").disabled = true;

        // Payroll
        document.getElementById("optpayrentr").checked = false;
        document.getElementById("optpayrentr").disabled = true;

        swal({
            title: 'USER ID tidak ditemukan' ,
            text: 'USER ID tidak ditemukan dalam Data User, silah periksa lagi',
            icon: 'warning',
        });

        //document.getElementById("labelmessage").style.visibility =  "";
      }
    }
  }

// Update Tipe User
  var ajaxupdatetipe;
  function tipecode(userakses)
  {
    ajaxupdatetipe = buatajaxupdatetipe();
    var url="PASSIDEN02U-TIPE.php";
    ajaxupdatetipe.onreadystatechange=stateChangedupdatetipe;
    var params = "q="+userakses;
    //alert(params);
    ajaxupdatetipe.open("POST",url,true);
    ajaxupdatetipe.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxupdatetipe.setRequestHeader("Content-length", params.length);
    ajaxupdatetipe.setRequestHeader("Connection", "close");
    ajaxupdatetipe.send(params);
  }

  function buatajaxupdatetipe()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedupdatetipe()
  {
  var data;
  if (ajaxupdatetipe.readyState==4)
    {
        periksaid(document.getElementById('txtuseriden').value);
    }
  }
// Selesai Update Tipe User

// Update Sandi User
  var ajaxupdatesandi;
  function sandicode(userakses,sandi)
  {
    ajaxupdatesandi = buatajaxupdatesandi();
    var url="PASSIDEN02U-PSWD.php";
    ajaxupdatesandi.onreadystatechange=stateChangedupdatesandi;
    var params = "q="+userakses+"|"+sandi;
    //alert(params);
    ajaxupdatesandi.open("POST",url,true);
    ajaxupdatesandi.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxupdatesandi.setRequestHeader("Content-length", params.length);
    ajaxupdatesandi.setRequestHeader("Connection", "close");
    ajaxupdatesandi.send(params);
  }

  function buatajaxupdatesandi()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedupdatesandi()
  {
  var data;
  if (ajaxupdatesandi.readyState==4)
    {
        alert("Password telah di Ubah");
        periksaid(document.getElementById('txtuseriden').value);
    }
  }
// Selesai Update Sandi User


// Update Akses Menu User
  var ajaxupdate;
  function aksescode(userid,fieldid)
  {
    ajaxupdate = buatajaxupdate();
    var url="PASSIDEN02U.php";
    ajaxupdate.onreadystatechange=stateChangedupdate;
    var params = "q="+userid+"|"+fieldid;
    //alert(params);
    ajaxupdate.open("POST",url,true);
    ajaxupdate.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxupdate.setRequestHeader("Content-length", params.length);
    ajaxupdate.setRequestHeader("Connection", "close");
    ajaxupdate.send(params);
  }

  function buatajaxupdate()
  {
    if (window.XMLHttpRequest)
    {
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject)
    {
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function stateChangedupdate()
  {
  var data;
  if (ajaxupdate.readyState==4)
    {
        periksaid(document.getElementById('txtuseriden').value);
    }
  }
// Selesai Update Data
