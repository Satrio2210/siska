  // periksa akses
    var aksesku;
  function periksaakses(fieldid)
  {
    aksesku = buatajaxakses();
    var url="TRXAPOLI01X-AKSES.php";
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

        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');
        document.getElementById('txtsigna').setAttribute('disabled','true');
        document.getElementById('txtusage').setAttribute('disabled','true');
                  var dokter = document.getElementById('hidprscdoct').value;
                  ambilregicode('X',dokter);

      }
      else
      {
        document.getElementById('txtsearch').setAttribute('disabled','true');
        document.getElementById('txtstockcode').setAttribute('disabled','true');
        document.getElementById('txtstockquty').setAttribute('disabled','true');
        document.getElementById('txtsigna').setAttribute('disabled','true');
        document.getElementById('txtusage').setAttribute('disabled','true');


      }
    }
  }
// end periksa akses  

// ambil data pendaftaran
var regiku;
function ambilregicode(kata,dokter)
{
  if(kata.length > 5)
  {
    document.getElementById("tblregi").innerHTML = "";
    document.getElementById("tblregi").style.visibility = "hidden";
  }
  else
  {
  regiku = buatajaxregi();
  var url="TRXAPOLI04C-REGI.php";
  regiku.onreadystatechange=stateChangedregi;
  var params = "q="+kata+"|"+dokter;
  regiku.open("POST",url,true);
  regiku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  regiku.setRequestHeader("Content-length", params.length);
  regiku.setRequestHeader("Connection", "close");
  regiku.send(params);
  }
} 

function buatajaxregi()
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

function stateChangedregi()
{
  var data;
  if (regiku.readyState==4 && regiku.status==200)
  {
  data=regiku.responseText;

      if(data.length>3)
    {   
    document.getElementById("tblregi").innerHTML = data;
    document.getElementById("tblregi").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblregi").innerHTML = "";
    document.getElementById("tblregi").style.visibility = "hidden";
    }
  }
}

function isiregi(outprsccode,outpaticode,outmainname,outmaingend,outmainage,outregipaym,outpaymcode,outregipoli)

{
  try 
  {
  document.getElementById("txtprsccode").value = outprsccode;
  
  document.getElementById("txtpaticode").value = outpaticode;
  document.getElementById("txtmainname").value = outmainname;
  document.getElementById("txtmaingend").value = outmaingend;
  document.getElementById("txtmainage").value = outmainage;


  document.getElementById("txtregipaym").value = outregipaym;
  document.getElementById("hidregipaym").value = outpaymcode;
  document.getElementById("hidmediroom").value = outregipoli;
   
  ambilscreen(outprsccode);
  
  document.getElementById("txtstockcode").removeAttribute('disabled');
  document.getElementById("txtstockquty").removeAttribute('disabled');

  document.getElementById("txtsigna").removeAttribute('disabled');
  document.getElementById("txtusage").removeAttribute('disabled');

  document.getElementById("txtsearch").value = '';

  document.getElementById("txtstockcode").focus();
  document.getElementById("tblregi").style.visibility = "hidden";
  document.getElementById("tblregi").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

    // ambil List Resep
    
var resepku;
function ambilresep(kata,regipoli)
{
  if(kata.length > 7)
  {
    document.getElementById("tblresep").innerHTML = "";
    document.getElementById("tblresep").style.visibility = "hidden";
  }
  else
  {
  resepku = buatajaxresep();
  var url="TRXAPOLI04C-RESEP.php";
  resepku.onreadystatechange=stateChangedResep;
  var params = "q="+kata+"|"+regipoli;
  resepku.open("POST",url,true);
  resepku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  resepku.setRequestHeader("Content-length", params.length);
  resepku.setRequestHeader("Connection", "close");
  resepku.send(params);
  }
} 

function buatajaxresep()
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

function stateChangedResep()
{
  var data;
  if (resepku.readyState==4 && resepku.status==200)
  {
  data=resepku.responseText;
    if(data.length>3)
    {   
    document.getElementById("tblresep").innerHTML = data;
    document.getElementById("tblresep").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblresep").innerHTML = "";
    document.getElementById("tblresep").style.visibility = "hidden";
    }
  }
}

function isiresep(outstockcode,outstockname,outstockpric, outstockamnt)

{
  try 
  {
  
  document.getElementById("txtstockcode").value = outstockname;

  document.getElementById("hidstockcode").value = outstockcode;
  
  document.getElementById("hidstockpric").value = outstockpric;

  document.getElementById("hidstockamnt").value = outstockamnt;

  document.getElementById("txtstockquty").focus();
  document.getElementById("tblresep").style.visibility = "hidden";
  document.getElementById("tblresep").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}

// isi data signa
var signaku;
function ambilsignacode(kata)
{
  if(kata.length > 5)
  {
    document.getElementById("tblsigna").innerHTML = "";
    document.getElementById("tblsigna").style.visibility = "hidden";
  }
  else
  {
  signaku = buatajaxsigna();
  var url="TRXAPOLI04C-SIGNA.php";
  signaku.onreadystatechange=stateChangedsigna;
  var params = "q="+kata;
  signaku.open("POST",url,true);
  signaku.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  signaku.setRequestHeader("Content-length", params.length);
  signaku.setRequestHeader("Connection", "close");
  signaku.send(params);
  }
} 

function buatajaxsigna()
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

function stateChangedsigna()
{
  var data;
  if (signaku.readyState==4 && signaku.status==200)
  {
  data=signaku.responseText;

      if(data.length>3)
    {   
    document.getElementById("tblsigna").innerHTML = data;
    document.getElementById("tblsigna").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblsigna").innerHTML = "";
    document.getElementById("tblsigna").style.visibility = "hidden";
    }
  }
}

function isisigna(outsgnacode,outsgnaname)

{
  try 
  {
  document.getElementById("txtsigna").value = outsgnaname;
  
  document.getElementById("hidsigna").value = outsgnacode;
   
 
  document.getElementById("txtsigna").removeAttribute('disabled');

  document.getElementById("txtsearch").value = '';

  document.getElementById("txtusage").focus();
  document.getElementById("tblsigna").style.visibility = "hidden";
  document.getElementById("tblsigna").innerHTML = "";

  } 
  catch(err){ alert(err.message); }
}


  // Input Data Posisi dari form ke Tabel 
 //  inprsccode,inprscdoct,instockcode,instockpric,instockquty,inprscconc, inprscsgna, inprscusag, inmediroom
  var ajaxinput;
  function input(prsccode,prscdoct,stockcode,stockpric,stockquty,prscconc,prscsgna,prscusag,mediroom)
  {
    ajaxinput = buatajaxinput();
    var url="TRXAPOLI04E.php";
    ajaxinput.onreadystatechange=stateChangedInput;
    var params = "q="+prsccode+"|"+prscdoct+"|"+stockcode+"|"+stockpric+"|"+stockquty+"|"+prscconc+"|"+prscsgna+"|"+prscusag+"|"+mediroom;
    //alert(params);
    ajaxinput.open("POST",url,true);
    ajaxinput.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //ajaxinput.setRequestHeader("Content-length", params.length);
    //ajaxinput.setRequestHeader("Connection", "close");
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
  if (ajaxinput.readyState==4)
    {

        document.getElementById('txtstockcode').value = '';
        document.getElementById('hidstockcode').value = '';
        document.getElementById('hidstockpric').value = '';
        document.getElementById('hidstockamnt').value = '';
        document.getElementById('txtstockquty').value = '1';

        document.getElementById('txtsigna').value = '';
        document.getElementById('hidsigna').value = '';

        document.getElementById('txtusage').value = '';


        var prsccode = document.getElementById('txtprsccode').value;
        ambilscreen(prsccode);

        document.getElementById('txtstockcode').focus();

        //}
    }
  }
  // Selesai Input Data

// Tampilkan Data Order   yang telah di pilih pada tabel untuk di ubah pada form 
var ajaxview
function viewcode(tretcode,paticode)
{
  try 
  {
    ajaxview = buatajaxview();
    var url="TRXAPOLI01C.php";
    ajaxview.onreadystatechange=stateChangedView;
    var params = "q="+regicode+"|"+paticode;
    //alert(params);
    ajaxview.open("POST",url,true);
    ajaxview.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxview.setRequestHeader("Content-length", params.length);
    ajaxview.setRequestHeader("Connection", "close");
    ajaxview.send(params);

  } 
  catch(err){ alert(err.message); }
}

  function buatajaxview()
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

  function stateChangedView()
  {
  var data;
  if (ajaxview.readyState==4)
    {
      data=ajaxview.responseText;
      if(data.length>1)
      {
//      1        2          3       4        5         6        7        8         9         10       11
//|$regicode|$paticode|$mainname|$fullage|$gender|$regipaym|$examhght|$examwght|$examblod|$examanam|$examdiag|

      var res = data.split("|");
      document.getElementById("txtexamcode").value = res[1];

      document.getElementById("txtpaticode").value = res[2];

      document.getElementById("txtmainname").value = res[3];

      document.getElementById("txtmaingend").value = res[5];

      document.getElementById("txtmainage").value = res[4];

      document.getElementById("txtregipaym").value = res[6];

      document.getElementById("txtexamhght").removeAttribute('disabled');
      document.getElementById("txtexamhght").value = res[7];

      document.getElementById("txtexamwght").removeAttribute('disabled');
      document.getElementById("txtexamwght").value = res[8];

      document.getElementById("txtexamblod").removeAttribute('disabled');
      document.getElementById("txtexamblod").value = res[9];

      document.getElementById("txtexamanam").removeAttribute('disabled');
      document.getElementById("txtexamanam").value = res[10];

      document.getElementById("txtexamdiag").removeAttribute('disabled');
      document.getElementById("txtexamdiag").value = res[11];

      document.getElementById("txtexamhght").focus();

      }      
        //}
    }
  }



// Tampilkan data yang diinput dalam datable
var drz;
function ambilscreen(prsccode)
{
  if(prsccode.length > 14)
  {
  document.getElementById("tblscreen").style.visibility = "hidden";
  }
  else
  {
  drz = buatajaxscreen();
  var url="TRXAPOLI04V.php";
  drz.onreadystatechange=stateChangedscreen;
  var params = "q="+prsccode;
  //alert(params);
  
  drz.open("POST",url,true);
  //beberapa http header harus kita set kalau menggunakan POST
  drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  drz.setRequestHeader("Content-length", params.length);
  drz.setRequestHeader("Connection", "close");
  drz.send(params);
  }
} 

  function buatajaxscreen()
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

function stateChangedscreen()
{
  var datapost;
  if (drz.readyState==4 && drz.status==200)
  {
  datapost=drz.responseText;
    if(datapost.length>0)
    {
    document.getElementById("tblscreen").innerHTML = datapost;
    document.getElementById("tblscreen").style.visibility = "";
    }
    else  
    {
    document.getElementById("tblscreen").innerHTML = "";
    document.getElementById("tblscreen").style.visibility = "hidden";
    }
  }
}


// Hapus 
  var ajaxhapus;
  function hapuscode(prsccode,stockcode)
  {
    ajaxhapus = buatajaxhapus();
    //var url="TBLIUNIT01D.php";
    var url="TRXAPOLI04D.php";
    ajaxhapus.onreadystatechange=stateChangedhapus;
    var params = "q="+prsccode+"|"+stockcode;
    //alert(params);
    ajaxhapus.open("POST",url,true);
    ajaxhapus.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxhapus.setRequestHeader("Content-length", params.length);
    ajaxhapus.setRequestHeader("Connection", "close");
    ajaxhapus.send(params);
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

  function stateChangedhapus()
  {
  var data;
  if (ajaxhapus.readyState==4)
    {
        var inprsccode = document.getElementById('txtprsccode').value;
        ambilscreen(inprsccode);
        document.getElementById('txtstockcode').focus();
    }
  }
// Selesai hapus Data 
