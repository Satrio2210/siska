  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="EMPLMAST01X-AKSES.php";
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
          document.getElementById('txtsearch').focus();

          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtfrstname').setAttribute('disabled','true');
          document.getElementById('txtlastname').setAttribute('disabled','true');

          document.getElementById('optmale').setAttribute('disabled','true');
          document.getElementById('optfemale').setAttribute('disabled','true');

          document.getElementById('tglmainbirt').setAttribute('disabled','true');

          document.getElementById('optblooda').setAttribute('disabled','true');
          document.getElementById('optbloodb').setAttribute('disabled','true');
          document.getElementById('optbloodab').setAttribute('disabled','true');

          document.getElementById('optbloodo').setAttribute('disabled','true');

          document.getElementById('txtfngrcode').setAttribute('disabled','true');

          document.getElementById('txtmaintidn1').setAttribute('disabled','true');
          document.getElementById('txtmaintidn2').setAttribute('disabled','true');
          document.getElementById('txtmaintidn3').setAttribute('disabled','true');
          document.getElementById('txtmaintidn4').setAttribute('disabled','true');
          document.getElementById('txtmaintidn5').setAttribute('disabled','true');
          document.getElementById('txtmaintidn6').setAttribute('disabled','true');

          document.getElementById('optmainstat').setAttribute('disabled','true');

          document.getElementById('txtmktpaddr').setAttribute('disabled','true');
          document.getElementById('txtmktpcity').setAttribute('disabled','true');
          document.getElementById('txtmktpprov').setAttribute('disabled','true');          
          document.getElementById('txtmktpctry').setAttribute('disabled','true');

          document.getElementById('txtmainhp01').setAttribute('disabled','true');
          document.getElementById('txtmainhp02').setAttribute('disabled','true');
          
          document.getElementById('txtmainmail').setAttribute('disabled','true');

          document.getElementById('opthigheduc').setAttribute('disabled','true');
          document.getElementById('txtlastschl').setAttribute('disabled','true');


          document.getElementById('optdocustat').setAttribute('disabled','true');

          document.getElementById('txtmainhobi').setAttribute('disabled','true');

          document.getElementById('tglhiredate').setAttribute('disabled','true');
          document.getElementById('tglactidate').setAttribute('disabled','true');

          document.getElementById('txtmaindivi').setAttribute('disabled','true');
          document.getElementById('txtmainpstn').setAttribute('disabled','true');
          document.getElementById('txtbankname').setAttribute('disabled','true');
          document.getElementById('txtbankacct').setAttribute('disabled','true');
          document.getElementById('txtbankpers').setAttribute('disabled','true');          

      }
      else
      {
          document.getElementById('txtsearch').setAttribute('disabled','true');

          document.getElementById('txtmastcode').setAttribute('disabled','true');
          document.getElementById('txtfrstname').setAttribute('disabled','true');
          document.getElementById('txtlastname').setAttribute('disabled','true');

          document.getElementById('optmale').setAttribute('disabled','true');
          document.getElementById('optfemale').setAttribute('disabled','true');

          document.getElementById('tglmainbirt').setAttribute('disabled','true');

          document.getElementById('optblooda').setAttribute('disabled','true');
          document.getElementById('optbloodb').setAttribute('disabled','true');
          document.getElementById('optbloodab').setAttribute('disabled','true');
          document.getElementById('optbloodo').setAttribute('disabled','true');

          document.getElementById('txtfngrcode').setAttribute('disabled','true');

          document.getElementById('txtmaintidn1').setAttribute('disabled','true');
          document.getElementById('txtmaintidn2').setAttribute('disabled','true');
          document.getElementById('txtmaintidn3').setAttribute('disabled','true');
          document.getElementById('txtmaintidn4').setAttribute('disabled','true');
          document.getElementById('txtmaintidn5').setAttribute('disabled','true');
          document.getElementById('txtmaintidn6').setAttribute('disabled','true');

          document.getElementById('optmainstat').setAttribute('disabled','true');

          document.getElementById('txtmktpaddr').setAttribute('disabled','true');
          document.getElementById('txtmktpcity').setAttribute('disabled','true');
          document.getElementById('txtmktpprov').setAttribute('disabled','true');          
          document.getElementById('txtmktpctry').setAttribute('disabled','true');

          document.getElementById('txtmainhp01').setAttribute('disabled','true');
          document.getElementById('txtmainhp02').setAttribute('disabled','true');
          
          document.getElementById('txtmainmail').setAttribute('disabled','true');

          document.getElementById('opthigheduc').setAttribute('disabled','true');
          document.getElementById('txtlastschl').setAttribute('disabled','true');


          document.getElementById('optdocustat').setAttribute('disabled','true');

          document.getElementById('txtmainhobi').setAttribute('disabled','true');

          document.getElementById('tglhiredate').setAttribute('disabled','true');
          document.getElementById('tglactidate').setAttribute('disabled','true');

          document.getElementById('txtmaindivi').setAttribute('disabled','true');
          document.getElementById('txtmainpstn').setAttribute('disabled','true');
          document.getElementById('txtbankname').setAttribute('disabled','true');
          document.getElementById('txtbankacct').setAttribute('disabled','true');
          document.getElementById('txtbankpers').setAttribute('disabled','true');          
      }
    }
  }
// end periksa akses  


// Ambil Data Employer Master
var emplmastku;
function ambilemplmastcode(emplmastcode)
{
  if(emplmastcode.length > 5)
  {
  document.getElementById("tblemplmast").style.visibility = "hidden";
  }
  else
  {
  emplmastku = buatajaxemplmastcode();
  var url="EMPLMAST02C.php";
  emplmastku.onreadystatechange=stateChangedemplmastcode;
  var params = "q="+emplmastcode;
  emplmastku.open("POST",url,true);
  emplmastku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  emplmastku.setRequestHeader("Content-length", params.length);
  emplmastku.setRequestHeader("Connection", "close");
  emplmastku.send(params);
  }
} 

function buatajaxemplmastcode()
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


function stateChangedemplmastcode()
{
  var data;
  if (emplmastku.readyState==4 && emplmastku.status==200)
  {
  data=emplmastku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblemplmast").innerHTML = data;
    document.getElementById("tblemplmast").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblemplmast").innerHTML = "";
    document.getElementById("tblemplmast").style.visibility = "hidden";
    }
  }
}

function isiemplmastcode(mastcode, frstname, lastname, maingend, mainbirt, mainblod, fngrcode, maintidn, mainstat, mktpaddr, mktpcity, mktpprov, mktpctry, mainhp01, mainhp02, mainmail, higheduc, lastschl, docustat, mainhobi, hiredate, actidate, maindivi, namedivi, mainpstn, namepstn, bankcode, bankname, bankacct, bankpers)
{
  document.getElementById('txtmastcode').removeAttribute('disabled');
  document.getElementById("txtmastcode").value = mastcode;

  document.getElementById('txtfrstname').removeAttribute('disabled');
  document.getElementById("txtfrstname").value = frstname;

  document.getElementById('txtlastname').removeAttribute('disabled');
  document.getElementById("txtlastname").value = lastname;

  document.getElementById('optmale').removeAttribute('disabled');
  document.getElementById('optfemale').removeAttribute('disabled');

  if (maingend == 'M') 
    { 
      document.getElementById("optmale").checked = true;
      document.getElementById("optfemale").checked = false;
      document.getElementById("hidmaingend").value = 'M'; 
    }
  else if (maingend == 'F') 
    { 
      document.getElementById("optmale").checked = false;
      document.getElementById("optfemale").checked = true;
      document.getElementById("hidmaingend").value = 'F'; 
    }

    else
    {
      document.getElementById("optmale").checked = false;
      document.getElementById("optfemale").checked = false;
      document.getElementById("hidmaingend").value = ''; 
    }

  document.getElementById('tglmainbirt').removeAttribute('disabled');
  document.getElementById("tglmainbirt").value = mainbirt;

  document.getElementById('optblooda').removeAttribute('disabled');
  document.getElementById('optbloodb').removeAttribute('disabled');
  document.getElementById('optbloodab').removeAttribute('disabled');
  document.getElementById('optbloodo').removeAttribute('disabled');


  if (mainblod == 'A') 
    { 
      document.getElementById("optblooda").checked = true;
      document.getElementById("optbloodb").checked = false;
      document.getElementById("optbloodab").checked = false;
      document.getElementById("optbloodo").checked = false;
      document.getElementById("hidmainblod").value = mainblod; 
    }
  else if (mainblod == 'B') 
    { 
      document.getElementById("optblooda").checked = false;
      document.getElementById("optbloodb").checked = true;
      document.getElementById("optbloodab").checked = false;
      document.getElementById("optbloodo").checked = false;
      document.getElementById("hidmainblod").value = mainblod; 
    }
  else if (mainblod == 'AB') 
    { 
      document.getElementById("optblooda").checked = false;
      document.getElementById("optbloodb").checked = false;
      document.getElementById("optbloodab").checked = true;
      document.getElementById("optbloodo").checked = false;
      document.getElementById("hidmainblod").value = mainblod; 
    }
  else if (mainblod == 'O') 
    { 
      document.getElementById("optblooda").checked = false;
      document.getElementById("optbloodb").checked = false;
      document.getElementById("optbloodab").checked = false;
      document.getElementById("optbloodo").checked = true;
      document.getElementById("hidmainblod").value = mainblod; 
    }

    else
    {
      document.getElementById("optblooda").checked = false;
      document.getElementById("optbloodb").checked = false;
      document.getElementById("optbloodab").checked = false;
      document.getElementById("optbloodo").checked = false;
      document.getElementById("hidmainblod").value = ''; 
    }

  document.getElementById('txtfngrcode').removeAttribute('disabled');
  document.getElementById('txtfngrcode').value = fngrcode;

  taxnumber = new String (maintidn);
    //01.844.059.4-038.000  
  var maintidn1 = taxnumber.substring(0,2);
  document.getElementById('txtmaintidn1').removeAttribute('disabled');
  document.getElementById("txtmaintidn1").value = maintidn1;

  var maintidn2 = taxnumber.substring(6,3);
  document.getElementById('txtmaintidn2').removeAttribute('disabled');
  document.getElementById("txtmaintidn2").value = maintidn2;

  var maintidn3 = taxnumber.substring(10,7);
  document.getElementById('txtmaintidn3').removeAttribute('disabled');
  document.getElementById("txtmaintidn3").value = maintidn3;

  var maintidn4 = taxnumber.substring(12,11);
  document.getElementById('txtmaintidn4').removeAttribute('disabled');
  document.getElementById("txtmaintidn4").value = maintidn4;

  var maintidn5 = taxnumber.substring(16,13);
  document.getElementById('txtmaintidn5').removeAttribute('disabled');
  document.getElementById("txtmaintidn5").value = maintidn5;

  var maintidn6 = taxnumber.substring(20,17);
  document.getElementById('txtmaintidn6').removeAttribute('disabled');
  document.getElementById("txtmaintidn6").value = maintidn6;

  document.getElementById('optmainstat').removeAttribute('disabled');
  document.getElementById('optmainstat').value = mainstat;

  document.getElementById('txtmktpaddr').removeAttribute('disabled');
  document.getElementById('txtmktpaddr').value = mktpaddr;

  document.getElementById('txtmktpcity').removeAttribute('disabled');
  document.getElementById("txtmktpcity").value = mktpcity;

  document.getElementById('txtmktpprov').removeAttribute('disabled');
  document.getElementById("txtmktpprov").value = mktpprov;

  document.getElementById('txtmktpctry').removeAttribute('disabled');
  document.getElementById("txtmktpctry").value = mktpctry;

  document.getElementById('txtmainhp01').removeAttribute('disabled');
  document.getElementById("txtmainhp01").value = mainhp01;

  document.getElementById('txtmainhp02').removeAttribute('disabled');
  document.getElementById("txtmainhp02").value = mainhp02;

  document.getElementById('txtmainmail').removeAttribute('disabled');
  document.getElementById("txtmainmail").value = mainmail;

  document.getElementById('opthigheduc').removeAttribute('disabled');
  document.getElementById('opthigheduc').value = higheduc;

  document.getElementById('txtlastschl').removeAttribute('disabled');
  document.getElementById("txtlastschl").value = lastschl;

  document.getElementById('optdocustat').removeAttribute('disabled');

  if (docustat == 'Y') 
    { 
      document.getElementById("optdocustat").checked = true;
      document.getElementById("hiddocustat").value = 'Y'; 
    }
    else
    {
      document.getElementById("optdocustat").checked = false;
      document.getElementById("hiddocustat").value = 'N'; 
    }

  document.getElementById('txtmainhobi').removeAttribute('disabled');
  document.getElementById("txtmainhobi").value = mainhobi;

  document.getElementById('tglhiredate').removeAttribute('disabled');
  document.getElementById("tglhiredate").value = hiredate;

  document.getElementById('tglactidate').removeAttribute('disabled');
  document.getElementById("tglactidate").value = actidate;

// maindivi, namedivi, mainpstn, namepstn, bankcode, bankname, bankacct, bankpers)

  document.getElementById('txtmaindivi').removeAttribute('disabled');
  document.getElementById("txtmaindivi").value = namedivi;
  document.getElementById("hidmaindivi").value = maindivi;

  document.getElementById('txtmainpstn').removeAttribute('disabled');
  document.getElementById("txtmainpstn").value = namepstn;
  document.getElementById("hidmainpstn").value = mainpstn;

  document.getElementById('txtbankname').removeAttribute('disabled');
  document.getElementById("txtbankname").value = bankname;
  document.getElementById("hidbankcode").value = bankcode;

  document.getElementById('txtbankacct').removeAttribute('disabled');
  document.getElementById("txtbankacct").value = bankacct;

  document.getElementById('txtbankpers').removeAttribute('disabled');
  document.getElementById("txtbankpers").value = bankpers;

  document.getElementById("txtsearch").focus();
  document.getElementById("tblemplmast").style.visibility = "hidden";
  document.getElementById("tblemplmast").innerHTML = "";

}

    // ambil Kode Divisi dari tabel tbledivi

var diviku;
function ambildivicode(divicode)
{
  if(divicode.length > 5)
  {
  document.getElementById("tbldivi").style.visibility = "hidden";
  }
  else
  {
  diviku = buatajaxdivicode();
  var url="EMPLMAST01C-DIVI.php";
  diviku.onreadystatechange=stateChangeddivicode;
  var params = "q="+divicode;
  diviku.open("POST",url,true);
  diviku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  diviku.setRequestHeader("Content-length", params.length);
  diviku.setRequestHeader("Connection", "close");
  diviku.send(params);
  }
} 
function buatajaxdivicode()
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

function stateChangeddivicode()
{
  var data;
  if (diviku.readyState==4 && diviku.status==200)
  {
  data=diviku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tbldivi").innerHTML = data;
    document.getElementById("tbldivi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tbldivi").innerHTML = "";
    document.getElementById("tbldivi").style.visibility = "hidden";
    }
  }
}

function isidivicode(outdivicode,outdiviname)
{
  try 
  {
  document.getElementById("txtmaindivi").value = outdiviname;
  document.getElementById("hidmaindivi").value = outdivicode;
  document.getElementById("txtmainpstn").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// Ambil Kode Posisi
var pstnku;
function ambilpstncode(pstncode)
{
  if(pstncode.length > 5)
  {
  document.getElementById("tblpstn").style.visibility = "hidden";
  }
  else
  {
  pstnku = buatajaxpstncode();
  var url="EMPLMAST01C-PSTN.php";
  pstnku.onreadystatechange=stateChangedpstncode;
  var params = "q="+pstncode;
  pstnku.open("POST",url,true);
  pstnku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  pstnku.setRequestHeader("Content-length", params.length);
  pstnku.setRequestHeader("Connection", "close");
  pstnku.send(params);
  }
} 
function buatajaxpstncode()
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

function stateChangedpstncode()
{
  var data;
  if (pstnku.readyState==4 && pstnku.status==200)
  {
  data=pstnku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblpstn").innerHTML = data;
    document.getElementById("tblpstn").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblpstn").innerHTML = "";
    document.getElementById("tblpstn").style.visibility = "hidden";
    }
  }
}

function isipstncode(outpstncode,outpstnname)
{
  try 
  {
  document.getElementById("txtmainpstn").value = outpstnname;
  document.getElementById("hidmainpstn").value = outpstncode;
  document.getElementById("txtbankname").focus();
  document.getElementById("tblpstn").style.visibility = "hidden";
  document.getElementById("tblpstn").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
// End Ambil Kode Posisi

    // ambil Kode Bank dari tabel tblebank

var bankku;
function ambilbankcode(bankcode)
{
  if(bankcode.length > 5)
  {
  document.getElementById("tblbank").style.visibility = "hidden";
  }
  else
  {
  bankku = buatajaxbankcode();
  var url="SUPLMAST02C-BANK.php";
  bankku.onreadystatechange=stateChangedbankcode;
  var params = "q="+bankcode;
  bankku.open("POST",url,true);
  bankku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  bankku.setRequestHeader("Content-length", params.length);
  bankku.setRequestHeader("Connection", "close");
  bankku.send(params);
  }
} 

function buatajaxbankcode()
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

function stateChangedbankcode()
{
  var data;
  if (bankku.readyState==4 && bankku.status==200)
  {
  data=bankku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblbank").innerHTML = data;
    document.getElementById("tblbank").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblbank").innerHTML = "";
    document.getElementById("tblbank").style.visibility = "hidden";
    }
  }
}

function isibankcode(outbankcode,outbankname)
{
  try 
  {
  document.getElementById("txtbankname").value = outbankname;
  document.getElementById("hidbankcode").value = outbankcode;
  document.getElementById("txtbankname").focus();
  document.getElementById("tblbank").style.visibility = "hidden";
  document.getElementById("tblbank").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}
