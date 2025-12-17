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
          periksaemploye('1');
          document.getElementById('txtfrstname').focus();

      }
      else
      {
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


  // periksa Kode Employer 
    var emplku;
  function periksaemploye(status)
  {
    emplku = buatajaxemployer();
    var url="EMPLMAST01X.php";
    emplku.onreadystatechange=stateChangedemployer;
    var params = "q="+status;
    //alert(params);
    emplku.open("POST",url,true);
    emplku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    emplku.setRequestHeader("Content-length", params.length);
    emplku.setRequestHeader("Connection", "close");
    emplku.send(params);

  }

  function buatajaxemployer()
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

  function stateChangedemployer()
  {
  var data;
  if (emplku.readyState==4)
    {

    xdata=emplku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtmastcode').value=data;
        //ambiltrxascreen(data);
      }
      else
      {
        document.getElementById('txtmastcode').value='';
      }
    }
  }
// end periksa Kode employer  

  
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
  if(bankcode.length > 10)
  {
  document.getElementById("tblbank").style.visibility = "hidden";
  }
  else
  {
  bankku = buatajaxbankcode();
  var url="EMPLMAST01C-BANK.php";
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
