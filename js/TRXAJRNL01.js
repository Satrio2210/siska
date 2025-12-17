  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAJRNL01X-AKSES.php";
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
        document.getElementById('tgljrnldate').focus();
        periksajurnal('I');
        var aktifjurnal = document.getElementById('txtjrnlcode').value;
        document.getElementById('txtjrnldebt').setAttribute('disabled','true');
        document.getElementById('txtjrnlcrdt').setAttribute('disabled','true');
        document.getElementById('txtdiviname').setAttribute('disabled','true');
        document.getElementById('txtjrnlnote').setAttribute('disabled','true');
      }
      else
      {
        document.getElementById('txtjrnlcode').setAttribute('disabled','true');
        document.getElementById('tgljrnldate').setAttribute('disabled','true');
        document.getElementById('txtcoaccode').setAttribute('disabled','true');      
        document.getElementById('txtcoacname').setAttribute('disabled','true');
        document.getElementById('txtjrnldebt').setAttribute('disabled','true');
        document.getElementById('txtjrnlcrdt').setAttribute('disabled','true');
        document.getElementById('txtdiviname').setAttribute('disabled','true');
        document.getElementById('txtjrnlnote').setAttribute('disabled','true');
      }
    }
  }
// end periksa akses  


  // periksa Kode Jurnal Transaksi 
    var jurnalku;
  function periksajurnal(status)
  {
    jurnalku = buatajaxjurnal();
    var url="TRXAJRNL01X.php";
    jurnalku.onreadystatechange=stateChangedJurnal;
    var params = "q="+status;
    //alert(params);
    jurnalku.open("POST",url,true);
    jurnalku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    jurnalku.setRequestHeader("Content-length", params.length);
    jurnalku.setRequestHeader("Connection", "close");
    jurnalku.send(params);

  }

  function buatajaxjurnal()
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

  function stateChangedJurnal()
  {
  var data;
  if (jurnalku.readyState==4)
    {

    xdata=jurnalku.responseText;
    data=xdata.trim();
    
    if(data.length>1)
      {
        document.getElementById('txtjrnlcode').value=data;
        ambiltrxascreen(data);
      }
      else
      {
        document.getElementById('txtjrnlcode').value='';
      }
    }
  }
// end periksa Kode Jurnal  

	// ambil Akun Code dari tabel coacmast
var coacku;
function ambilcoaccode(coaccode)
{
  if(coaccode.length > 13)
  {
  document.getElementById("tblcoac").style.visibility = "hidden";
  }
  else
  {
  coacku = buatajaxcoaccode();
  //var url="TRXAJRNL01GETCOACCODE.php";
  var url="TRXAJRNL01C-COAC.php";
  coacku.onreadystatechange=stateChangedcoaccode;
  var params = "q="+coaccode;
  coacku.open("POST",url,true);
  coacku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  coacku.setRequestHeader("Content-length", params.length);
  coacku.setRequestHeader("Connection", "close");
  coacku.send(params);
  }
} 
function buatajaxcoaccode()
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

function stateChangedcoaccode()
{
  var data;
  if (coacku.readyState==4 && coacku.status==200)
  {
  data=coacku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblcoac").innerHTML = data;
    document.getElementById("tblcoac").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblcoac").innerHTML = "";
    document.getElementById("tblcoac").style.visibility = "hidden";
    }
  }
}

function isicoaccode(tblcoaccode,tblcoacname,tblcoacblnc)
{
	try 
	{
  document.getElementById("txtcoaccode").value = tblcoaccode;
  document.getElementById("txtcoacname").value = tblcoacname;
  document.getElementById("txtjrnldebt").removeAttribute('disabled','true');
  document.getElementById("txtjrnlcrdt").removeAttribute('disabled','true');
  document.getElementById("txtdiviname").removeAttribute('disabled','true');
  document.getElementById("txtjrnlnote").removeAttribute('disabled','true');
  if (tblcoacblnc == 'DB') { document.getElementById("txtjrnldebt").focus(); }
  else { document.getElementById("txtjrnlcrdt").focus(); }
  document.getElementById("tblcoac").style.visibility = "hidden";
  document.getElementById("tblcoac").innerHTML = "";

	} catch(err){ alert(err.message); }


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
  //var url="TRXAJRNL01GETDIVICODE.php";
  var url="TRXAJRNL01C-DIVI.php";
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

function isidivicode(tbldivicode,tbldiviname)
{
	try 
	{
  document.getElementById("hiddivicode").value = tbldivicode;
  document.getElementById("txtdiviname").value = tbldiviname;
  document.getElementById("txtjrnlnote").focus();
  document.getElementById("tbldivi").style.visibility = "hidden";
  document.getElementById("tbldivi").innerHTML = "";

	} 
  catch(err){ alert(err.message); }
}

// Input Data Jurnal Transaksi ke Tabel Jurnal
  var ajaxinput;
  function Input(jrnlcode,jrnldate,coaccode,coacname,jrnldebt,jrnlcrdt,divicode,diviname,jrnlnote)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAJRNL01E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+jrnlcode+"|"+jrnldate+"|"+coaccode+"|"+coacname+"|"+jrnldebt+"|"+jrnlcrdt+"|"+divicode+"|"+diviname+"|"+jrnlnote;
    //alert(params);
    ajaxinput.open("POST",url,true);
    ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxinput.setRequestHeader("Content-length", params.length);
    ajaxinput.setRequestHeader("Connection", "close");
    ajaxinput.send(params);
  }

  function buatajaxinput()
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

  function stateChangedInput()
  {
  var data;
  if (ajaxinput.readyState==4)
    {
        var todaynow = new Date()
        var today = convertDate(todaynow);
        document.getElementById("tgljrnldate").value = today;
        document.getElementById('txtcoaccode').value = '';
        document.getElementById('txtcoacname').value = '';
        document.getElementById('txtjrnldebt').value = '0';
        document.getElementById('txtjrnlcrdt').value = '0';
        document.getElementById('hiddivicode').value = '';
        document.getElementById('txtdiviname').value = '';
        document.getElementById('txtjrnlnote').value = '';
        document.getElementById('txtcoaccode').focus();
        var kodejurnal = document.getElementById('txtjrnlcode').value;
        ambiltrxascreen(kodejurnal);
        //}
    }
  }
// Selesai Input Data Jurnal Transaksi ke Tabel Jurnal

// tampilkan data transaksi yang sedang di proses dan belum di posting

var drz;
function ambiltrxascreen(kodejurnal)
{
  try {	
  drz = buatajaxtrxascreen();
  //var url="TRXAJRNL01XX.php";
  var url="TRXAJRNL01V.php";
  drz.onreadystatechange=stateChangedtrxascreen;
  var params = "q="+kodejurnal;
  drz.open("POST",url,true);
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }  catch(err) {alert (err.message);}
} 

function buatajaxtrxascreen()
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

function stateChangedtrxascreen() 
{   var datapost;   
  if (drz.readyState==4)   
    { 
      datapost=drz.responseText;
      if(datapost.length>3)
        { 
          document.getElementById("tbltrxascreen").innerHTML = datapost;
            document.getElementById("tbltrxascreen").style.visibility = "";     
        }     
      else 
        {  
          document.getElementById("tbltrxascreen").innerHTML = "";
          document.getElementById("tbltrxascreen").style.visibility = "hidden";     
        }

    } 
}
// hapus item transaksi pada jurnal yang masih proses input 
var ajaxhapus
function hapuscode(outjrnlcode,outcoaccode,outentrtime)
{
  try 
  {
    ajaxhapus = buatajaxhapus();
    var url="TRXAJRNL01D.php";
    ajaxhapus.onreadystatechange=stateChangedHapus;
    var params = "q="+outjrnlcode+"|"+outcoaccode+"|"+outentrtime;
    //alert(params);
    ajaxhapus.open("POST",url,true);
    ajaxhapus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxhapus.setRequestHeader("Content-length", params.length);
    ajaxhapus.setRequestHeader("Connection", "close");
    ajaxhapus.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxhapus()
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

  function stateChangedHapus()
  {
  var data;
  if (ajaxhapus.readyState==4)
    {
        document.getElementById("tgljrnldate").value = '';
        document.getElementById('txtcoaccode').value = '';
        document.getElementById('txtcoacname').value = '';
        document.getElementById('txtjrnldebt').value = '0';
        document.getElementById('txtjrnlcrdt').value = '0';
        document.getElementById('hiddivicode').value = '';
        document.getElementById('txtdiviname').value = '';
        document.getElementById('txtjrnlnote').value = '';
        document.getElementById('txtcoaccode').focus();
        var kodejurnal = document.getElementById('txtjrnlcode').value;
        ambiltrxascreen(kodejurnal);
        //}
    }
  }
